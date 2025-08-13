<?php

namespace App\Http\Controllers;

use App\Models\SchoolEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the calendar page
     */
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get events for the month
        $events = SchoolEvent::whereBetween('start_date', [$startDate, $endDate])
            ->orWhere(function($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $startDate);
            })
            ->orderBy('start_date')
            ->get();

        // Group events by date
        $eventsByDate = $events->groupBy(function($event) {
            return $event->start_date->format('Y-m-d');
        });

        // Get upcoming events
        $upcomingEvents = SchoolEvent::upcoming()
            ->take(10)
            ->get();

        // Get event types for filter
        $eventTypes = Cache::remember('event_types', 3600, function() {
            return SchoolEvent::select('type', \DB::raw('count(*) as count'))
                ->groupBy('type')
                ->get()
                ->map(function($item) {
                    return [
                        'type' => $item->type,
                        'label' => SchoolEvent::make(['type' => $item->type])->type_label,
                        'color' => SchoolEvent::make(['type' => $item->type])->type_color,
                        'count' => $item->count
                    ];
                });
        });

        return view('calendar.index', compact(
            'events', 
            'eventsByDate', 
            'upcomingEvents', 
            'eventTypes',
            'startDate',
            'month',
            'year'
        ));
    }

    /**
     * Get events for API/AJAX requests
     */
    public function events(Request $request)
    {
        $start = Carbon::parse($request->get('start', now()->startOfMonth()));
        $end = Carbon::parse($request->get('end', now()->endOfMonth()));

        $events = SchoolEvent::whereBetween('start_date', [$start, $end])
            ->orWhere(function($query) use ($start, $end) {
                $query->where('start_date', '<=', $start)
                      ->where('end_date', '>=', $start);
            })
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->format('Y-m-d'),
                    'end' => $event->end_date ? $event->end_date->format('Y-m-d') : null,
                    'color' => $event->color,
                    'type' => $event->type,
                    'level' => $event->level_label,
                    'description' => $event->description,
                    'location' => $event->location,
                    'is_ongoing' => $event->is_ongoing,
                    'url' => route('calendar.event', $event->id)
                ];
            });

        return response()->json($events);
    }

    /**
     * Show event details
     */
    public function showEvent($id)
    {
        $event = SchoolEvent::findOrFail($id);
        
        // Get similar events
        $similarEvents = SchoolEvent::where('id', '!=', $id)
            ->where('type', $event->type)
            ->upcoming()
            ->take(3)
            ->get();

        return view('calendar.event', compact('event', 'similarEvents'));
    }

    /**
     * Get calendar widget for homepage
     */
    public function widget()
    {
        $events = Cache::remember('calendar_widget', 600, function() {
            return SchoolEvent::upcoming()
                ->take(6)
                ->get()
                ->map(function($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'date_range' => $event->date_range,
                        'type' => $event->type,
                        'type_label' => $event->type_label,
                        'type_color' => $event->type_color,
                        'level' => $event->level_label,
                        'days_until' => $event->days_until,
                        'is_ongoing' => $event->is_ongoing,
                        'importance' => $event->importance
                    ];
                });
        });

        return response()->json($events);
    }

    /**
     * Get important dates for the academic year
     */
    public function importantDates()
    {
        $dates = Cache::remember('important_dates', 3600, function() {
            return SchoolEvent::where('importance', '>=', 7)
                ->whereYear('start_date', now()->year)
                ->orderBy('start_date')
                ->get()
                ->groupBy(function($event) {
                    return $event->start_date->format('F');
                })
                ->map(function($events, $month) {
                    return $events->map(function($event) {
                        return [
                            'title' => $event->title,
                            'date' => $event->start_date->format('d'),
                            'type' => $event->type_label,
                            'color' => $event->type_color
                        ];
                    });
                });
        });

        return response()->json($dates);
    }

    /**
     * Export calendar to ICS format
     */
    public function export(Request $request)
    {
        $events = SchoolEvent::upcoming()->get();
        
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//E-Library CI//School Calendar//FR\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";
        $ics .= "X-WR-CALNAME:Calendrier Scolaire Côte d'Ivoire\r\n";
        $ics .= "X-WR-CALDESC:Calendrier scolaire officiel de Côte d'Ivoire\r\n";

        foreach ($events as $event) {
            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:" . $event->id . "@elibrary-ci.com\r\n";
            $ics .= "DTSTART:" . $event->start_date->format('Ymd') . "\r\n";
            
            if ($event->end_date) {
                $ics .= "DTEND:" . $event->end_date->format('Ymd') . "\r\n";
            }
            
            $ics .= "SUMMARY:" . $event->title . "\r\n";
            
            if ($event->description) {
                $ics .= "DESCRIPTION:" . str_replace("\n", "\\n", $event->description) . "\r\n";
            }
            
            if ($event->location) {
                $ics .= "LOCATION:" . $event->location . "\r\n";
            }
            
            $ics .= "STATUS:CONFIRMED\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";

        return response($ics)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="calendrier-scolaire-ci.ics"');
    }
}