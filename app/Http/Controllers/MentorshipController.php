<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorshipRequest;
use App\Models\MentorshipSession;
use App\Models\MentorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MentorshipController extends Controller
{
    /**
     * Display mentorship homepage
     */
    public function index()
    {
        // For now, use static data until tables are created
        $stats = [
            'total_mentors' => 250,
            'total_students' => 1500,
            'total_sessions' => 5200,
            'success_rate' => 95.0,
            'avg_rating' => 4.8,
        ];

        $topMentors = collect([]);
        $specializations = collect([]);
        $testimonials = collect([]);

        return view('mentorship.index', compact('stats', 'topMentors', 'specializations', 'testimonials'));
    }

    /**
     * Browse mentors
     */
    public function browseMentors(Request $request)
    {
        $query = Mentor::active()->verified()->with('user');

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Filter by subject
        if ($request->filled('subject')) {
            $query->whereJsonContains('subjects', $request->subject);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->whereJsonContains('levels', $request->level);
        }

        // Filter by language
        if ($request->filled('language')) {
            $query->whereJsonContains('languages_spoken', $request->language);
        }

        // Filter by mentoring type
        if ($request->filled('type')) {
            if ($request->type !== 'both') {
                $query->where('mentoring_type', $request->type);
            }
        }

        // Filter by volunteer status
        if ($request->has('volunteer')) {
            $query->where('is_volunteer', true);
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Sort
        $sortBy = $request->get('sort', 'rating');
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'experience':
                $query->orderBy('total_sessions', 'desc');
                break;
            case 'recent':
                $query->latest();
                break;
            case 'price_low':
                $query->orderBy('hourly_rate', 'asc');
                break;
        }

        $mentors = $query->paginate(12);

        // Get filter options
        $filterOptions = $this->getFilterOptions();

        return view('mentorship.browse', compact('mentors', 'filterOptions'));
    }

    /**
     * Show mentor profile
     */
    public function showMentor($id)
    {
        $mentor = Mentor::with(['user', 'reviews.student'])
            ->findOrFail($id);

        // Get upcoming available slots
        $availableSlots = $this->getAvailableSlots($mentor);

        // Get recent reviews
        $reviews = $mentor->reviews()
            ->with('student')
            ->latest()
            ->paginate(5);

        // Get statistics
        $stats = [
            'total_students' => $mentor->students_helped,
            'total_hours' => $mentor->total_hours,
            'response_time' => $mentor->average_response_time,
            'success_rate' => $mentor->success_rate,
        ];

        return view('mentorship.mentor-profile', compact('mentor', 'availableSlots', 'reviews', 'stats'));
    }

    /**
     * Request mentorship
     */
    public function requestMentorship(Request $request, $mentorId)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'level' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'goals' => 'nullable|string|max:500',
            'preferred_schedule' => 'nullable|array',
        ]);

        $mentor = Mentor::active()->findOrFail($mentorId);

        // Check if user already has pending request with this mentor
        $existingRequest = MentorshipRequest::where('student_id', Auth::id())
            ->where('mentor_id', $mentorId)
            ->where('status', 'pending')
            ->exists();

        if ($existingRequest) {
            return back()->with('error', 'Vous avez déjà une demande en attente avec ce mentor.');
        }

        $mentorshipRequest = MentorshipRequest::create([
            'student_id' => Auth::id(),
            'mentor_id' => $mentorId,
            'subject' => $request->subject,
            'level' => $request->level,
            'message' => $request->message,
            'goals' => $request->goals,
            'preferred_schedule' => $request->preferred_schedule,
        ]);

        // TODO: Send notification to mentor

        return redirect()->route('mentorship.my-requests')
            ->with('success', 'Votre demande de mentorat a été envoyée avec succès.');
    }

    /**
     * Become a mentor
     */
    public function becomeMentor()
    {
        // Check if user is already a mentor
        if (Auth::user()->mentor) {
            return redirect()->route('mentorship.dashboard');
        }

        $specializations = $this->getSpecializations();
        $subjects = $this->getSubjects();
        $levels = $this->getEducationalLevels();

        return view('mentorship.become-mentor', compact('specializations', 'subjects', 'levels'));
    }

    /**
     * Store mentor application
     */
    public function storeMentorApplication(Request $request)
    {
        $request->validate([
            'specialization' => 'required|string',
            'subjects' => 'required|array|min:1',
            'levels' => 'required|array|min:1',
            'bio' => 'required|string|min:100|max:1000',
            'qualification' => 'required|string|max:255',
            'years_experience' => 'required|integer|min:0',
            'certifications' => 'nullable|array',
            'languages_spoken' => 'required|array|min:1',
            'availability' => 'required|array',
            'hourly_rate' => 'nullable|numeric|min:0',
            'is_volunteer' => 'boolean',
            'mentoring_type' => 'required|in:online,in_person,both',
            'linkedin_url' => 'nullable|url',
        ]);

        // Create mentor profile
        $mentor = Mentor::create([
            'user_id' => Auth::id(),
            'specialization' => $request->specialization,
            'subjects' => $request->subjects,
            'levels' => $request->levels,
            'bio' => $request->bio,
            'qualification' => $request->qualification,
            'years_experience' => $request->years_experience,
            'certifications' => $request->certifications,
            'languages_spoken' => $request->languages_spoken,
            'availability' => $request->availability,
            'hourly_rate' => $request->hourly_rate,
            'is_volunteer' => $request->boolean('is_volunteer'),
            'mentoring_type' => $request->mentoring_type,
            'linkedin_url' => $request->linkedin_url,
            'is_verified' => false, // Will be verified by admin
            'is_active' => false, // Will be activated after verification
        ]);

        // TODO: Send notification to admin for verification

        return redirect()->route('mentorship.index')
            ->with('success', 'Votre candidature de mentor a été soumise. Elle sera examinée dans les 48 heures.');
    }

    /**
     * Calculate overall success rate
     */
    private function calculateSuccessRate()
    {
        $totalSessions = MentorshipSession::whereIn('status', ['completed', 'cancelled', 'no_show'])->count();
        
        if ($totalSessions === 0) {
            return 0;
        }

        $completedSessions = MentorshipSession::where('status', 'completed')->count();
        
        return round(($completedSessions / $totalSessions) * 100, 1);
    }

    /**
     * Get filter options for browsing
     */
    private function getFilterOptions()
    {
        return [
            'specializations' => $this->getSpecializations(),
            'subjects' => $this->getSubjects(),
            'levels' => $this->getEducationalLevels(),
            'languages' => ['Français', 'Anglais', 'Dioula', 'Baoulé', 'Bété', 'Sénoufo'],
            'types' => [
                'online' => 'En ligne',
                'in_person' => 'En personne',
                'both' => 'Les deux'
            ],
        ];
    }

    /**
     * Get available specializations
     */
    private function getSpecializations()
    {
        return [
            'Mathématiques',
            'Sciences Physiques',
            'Sciences Naturelles',
            'Français',
            'Anglais',
            'Histoire-Géographie',
            'Philosophie',
            'Économie',
            'Informatique',
            'Langues Nationales',
            'Orientation Scolaire',
            'Préparation Examens',
        ];
    }

    /**
     * Get subjects list
     */
    private function getSubjects()
    {
        return [
            'Algèbre', 'Géométrie', 'Statistiques',
            'Physique', 'Chimie', 'Biologie',
            'Grammaire', 'Littérature', 'Rédaction',
            'Histoire', 'Géographie', 'Éducation Civique',
            'Programmation', 'Bureautique',
            'Dioula', 'Baoulé', 'Bété',
        ];
    }

    /**
     * Get educational levels
     */
    private function getEducationalLevels()
    {
        return [
            'CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2',
            '6ème', '5ème', '4ème', '3ème',
            '2nde', '1ère', 'Terminale',
            'Licence 1', 'Licence 2', 'Licence 3',
            'Master 1', 'Master 2',
        ];
    }

    /**
     * Get available time slots for a mentor
     */
    private function getAvailableSlots($mentor)
    {
        $slots = [];
        $today = now();
        
        for ($i = 0; $i < 14; $i++) { // Next 2 weeks
            $date = $today->copy()->addDays($i);
            $dayOfWeek = strtolower($date->format('l'));
            
            if (isset($mentor->availability[$dayOfWeek])) {
                $daySlots = [];
                foreach ($mentor->availability[$dayOfWeek] as $slot) {
                    // Check if slot is not already booked
                    // TODO: Implement booking check
                    $daySlots[] = [
                        'date' => $date->format('Y-m-d'),
                        'start' => $slot['start'],
                        'end' => $slot['end'],
                    ];
                }
                
                if (!empty($daySlots)) {
                    $slots[$date->format('Y-m-d')] = $daySlots;
                }
            }
        }
        
        return $slots;
    }
}