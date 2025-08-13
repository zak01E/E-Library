<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MamaEcoleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des parents test
        $parentIds = [];
        $languages = ['french', 'dioula', 'baoule', 'bete', 'senoufo'];
        $callTimes = ['morning', 'afternoon', 'evening'];
        
        for ($i = 1; $i <= 20; $i++) {
            $parentIds[] = DB::table('parents')->insertGetId([
                'name' => "Parent Test $i",
                'phone_number' => '+22507' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'preferred_language' => $languages[array_rand($languages)],
                'can_read' => rand(0, 1),
                'preferred_call_time' => $callTimes[array_rand($callTimes)],
                'enrolled_mama_ecole' => true,
                'enrollment_date' => Carbon::now()->subDays(rand(1, 90)),
                'total_calls_received' => rand(0, 50),
                'total_calls_answered' => rand(0, 40),
                'engagement_score' => rand(20, 100),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Créer des classes si elles n'existent pas
        $classIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $classIds[] = DB::table('classes')->insertGetId([
                'name' => "CM$i",
                'level' => "Primaire",
                'academic_year' => '2024-2025',
                'total_students' => 0,
                'teacher_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Créer des étudiants
        $studentIds = [];
        foreach ($parentIds as $parentId) {
            for ($j = 1; $j <= rand(1, 3); $j++) {
                $studentIds[] = DB::table('students')->insertGetId([
                    'parent_id' => $parentId,
                    'name' => "Élève " . $parentId . "-" . $j,
                    'matricule' => 'MAT' . str_pad($parentId . $j, 6, '0', STR_PAD_LEFT),
                    'class_id' => $classIds[array_rand($classIds)],
                    'date_of_birth' => Carbon::now()->subYears(rand(6, 12)),
                    'gender' => rand(0, 1) ? 'M' : 'F',
                    'is_active' => true,
                    'absences_count' => rand(0, 10),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        // Créer des liens parent-student
        foreach ($studentIds as $studentId) {
            $student = DB::table('students')->find($studentId);
            DB::table('parent_student')->insert([
                'parent_id' => $student->parent_id,
                'student_id' => $studentId,
                'relationship' => 'father',
                'is_primary_contact' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Créer des templates de messages
        $templates = [
            [
                'name' => 'Notes hebdomadaires',
                'type' => 'grades',
                'content' => json_encode([
                    'french' => 'Bonjour, {student_name} a obtenu {grade}/20 en {subject}. {comment}',
                    'dioula' => 'I ni ce, {student_name} ye {grade} sɔrɔ 20 la {subject} la. {comment}',
                    'baoule' => 'Akwaba, {student_name} asi {grade} su 20 {subject}. {comment}'
                ]),
                'variables' => json_encode(['student_name', 'grade', 'subject', 'comment']),
                'active' => true,
                'usage_count' => rand(10, 100)
            ],
            [
                'name' => 'Notification absence',
                'type' => 'absence',
                'content' => json_encode([
                    'french' => '{student_name} était absent(e) le {date}. Merci de justifier.',
                    'dioula' => '{student_name} tun tɛ kalanso la {date}. I ka sabati di.',
                ]),
                'variables' => json_encode(['student_name', 'date']),
                'active' => true,
                'usage_count' => rand(5, 50)
            ],
            [
                'name' => 'Convocation réunion',
                'type' => 'meeting',
                'content' => json_encode([
                    'french' => 'Réunion parents le {date} à {time}. Votre présence est importante.',
                    'dioula' => 'Bangebaga lajɛ {date} {time} la. I ka na.',
                ]),
                'variables' => json_encode(['date', 'time']),
                'active' => true,
                'usage_count' => rand(3, 30)
            ]
        ];
        
        foreach ($templates as $template) {
            DB::table('mama_ecole_templates')->insert(array_merge($template, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Créer des interactions test
        $messageTypes = ['grades', 'absence', 'meeting', 'urgent', 'welcome'];
        $statuses = ['completed', 'failed', 'no-answer', 'busy'];
        
        for ($i = 0; $i < 100; $i++) {
            DB::table('mama_ecole_interactions')->insert([
                'parent_id' => $parentIds[array_rand($parentIds)],
                'message_type' => $messageTypes[array_rand($messageTypes)],
                'language' => $languages[array_rand($languages)],
                'call_sid' => 'DEMO_' . uniqid(),
                'call_status' => $statuses[array_rand($statuses)],
                'call_duration' => rand(0, 300),
                'listened_full' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => now()
            ]);
        }
        
        // Créer des campagnes test
        $campaigns = [
            [
                'name' => 'Campagne Notes Trimestrielles',
                'description' => 'Envoi des notes du premier trimestre à tous les parents',
                'target_type' => 'all',
                'message_content' => json_encode(['type' => 'grades']),
                'total_recipients' => 150,
                'successful_calls' => 132,
                'failed_calls' => 18,
                'status' => 'completed',
                'completed_at' => Carbon::now()->subDays(5),
                'created_by' => 1
            ],
            [
                'name' => 'Réunion Parents CM2',
                'description' => 'Convocation pour la réunion d\'orientation',
                'target_type' => 'class',
                'target_criteria' => json_encode(['class_id' => 5]),
                'message_content' => json_encode(['type' => 'meeting']),
                'total_recipients' => 45,
                'successful_calls' => 20,
                'failed_calls' => 2,
                'status' => 'in_progress',
                'started_at' => Carbon::now()->subHours(2),
                'created_by' => 1
            ],
            [
                'name' => 'Rappel Paiement Scolarité',
                'description' => 'Rappel pour les parents ayant des arriérés',
                'target_type' => 'custom',
                'message_content' => json_encode(['type' => 'urgent']),
                'total_recipients' => 30,
                'status' => 'scheduled',
                'scheduled_at' => Carbon::now()->addDays(2),
                'created_by' => 1
            ]
        ];
        
        foreach ($campaigns as $campaign) {
            DB::table('mama_ecole_campaigns')->insert(array_merge($campaign, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Créer des rewards test
        $actionTypes = ['listen_full', 'attend_meeting', 'respond_survey', 'child_improvement'];
        
        foreach ($parentIds as $parentId) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $points = rand(50, 500);
                DB::table('mama_ecole_rewards')->insert([
                    'parent_id' => $parentId,
                    'action_type' => $actionTypes[array_rand($actionTypes)],
                    'points_earned' => $points,
                    'fcfa_value' => $points * 10,
                    'paid_out' => rand(0, 1),
                    'paid_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 30)) : null,
                    'created_at' => Carbon::now()->subDays(rand(1, 60)),
                    'updated_at' => now()
                ]);
            }
        }
        
        // Créer des notes pour les étudiants
        $subjects = ['Mathématiques', 'Français', 'Sciences', 'Histoire', 'Géographie'];
        
        foreach ($studentIds as $studentId) {
            foreach ($subjects as $subject) {
                DB::table('student_grades')->insert([
                    'student_id' => $studentId,
                    'subject' => $subject,
                    'grade' => rand(8, 20),
                    'term' => 'Trimestre 1',
                    'academic_year' => '2024-2025',
                    'comment' => 'Bon travail',
                    'teacher_id' => null,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => now()
                ]);
            }
        }
        
        $this->command->info('Données de test Mama École créées avec succès!');
    }
}