<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MamaEcoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer ou récupérer des enseignants
        $teachers = [];
        for ($i = 1; $i <= 5; $i++) {
            $teachers[] = User::firstOrCreate(
                ['email' => "prof$i@elibrary.ci"],
                [
                    'name' => "Professeur $i",
                    'password' => Hash::make('password'),
                    'role' => 'author',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Créer des classes
        $classes = [];
        $levels = ['Primaire', 'Collège', 'Lycée'];
        $classNames = [
            'Primaire' => ['CP1', 'CP2', 'CE1', 'CE2', 'CM1', 'CM2'],
            'Collège' => ['6ème', '5ème', '4ème', '3ème'],
            'Lycée' => ['2nde', '1ère', 'Terminale']
        ];

        foreach ($levels as $level) {
            foreach ($classNames[$level] as $className) {
                $classes[] = SchoolClass::create([
                    'name' => $className . ' A',
                    'level' => $level,
                    'academic_year' => '2024-2025',
                    'teacher_id' => $teachers[array_rand($teachers)]->id,
                ]);
            }
        }

        // Créer des parents
        $languages = ['french', 'dioula', 'baoule', 'bete', 'senoufo'];
        $parents = [];

        for ($i = 1; $i <= 50; $i++) {
            $canRead = rand(0, 100) < 40; // 40% peuvent lire
            
            $parents[] = ParentModel::create([
                'name' => "Parent $i",
                'phone_number' => '+2250' . rand(100000000, 799999999),
                'preferred_language' => $languages[array_rand($languages)],
                'can_read' => $canRead,
                'preferred_call_time' => ['morning', 'afternoon', 'evening'][rand(0, 2)],
                'enrolled_mama_ecole' => !$canRead, // Inscrire automatiquement les illettrés
                'enrollment_date' => !$canRead ? now() : null,
            ]);
        }

        // Créer des élèves et les associer aux parents et classes
        foreach ($parents as $parent) {
            $numChildren = rand(1, 3);
            
            for ($j = 1; $j <= $numChildren; $j++) {
                $student = Student::create([
                    'name' => "Élève {$parent->id}-$j",
                    'matricule' => 'MAT' . str_pad($parent->id * 10 + $j, 6, '0', STR_PAD_LEFT),
                    'date_of_birth' => now()->subYears(rand(6, 18)),
                    'gender' => ['M', 'F'][rand(0, 1)],
                    'class_id' => $classes[array_rand($classes)]->id,
                    'parent_id' => $parent->id,
                    'average_grade' => rand(8, 18) + (rand(0, 99) / 100),
                    'absences_count' => rand(0, 10),
                    'is_active' => true,
                ]);

                // Créer la relation parent-student
                DB::table('parent_student')->insert([
                    'parent_id' => $parent->id,
                    'student_id' => $student->id,
                    'relationship' => ['mother', 'father', 'guardian'][rand(0, 2)],
                    'is_primary_contact' => $j == 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Créer des interactions de test
        $messageTypes = ['grades', 'absence', 'meeting', 'urgent', 'welcome'];
        $callStatuses = ['completed', 'failed', 'no-answer'];

        foreach ($parents as $parent) {
            if (!$parent->enrolled_mama_ecole) continue;
            $numInteractions = rand(1, 10);
            
            for ($i = 0; $i < $numInteractions; $i++) {
                DB::table('mama_ecole_interactions')->insert([
                    'parent_id' => $parent->id,
                    'message_type' => $messageTypes[array_rand($messageTypes)],
                    'language' => $parent->preferred_language,
                    'call_sid' => 'DEMO_' . uniqid(),
                    'call_status' => $callStatuses[array_rand($callStatuses)],
                    'call_duration' => rand(30, 180),
                    'listened_full' => rand(0, 1),
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now(),
                ]);
            }
        }

        // Créer des templates de messages
        $templates = [
            [
                'name' => 'Notes Mensuelles',
                'type' => 'grades',
                'content' => json_encode([
                    'french' => 'Votre enfant {student_name} a obtenu {grade}/20 en {subject}.',
                    'dioula' => 'I den {student_name} ye nota {grade} sɔrɔ 20 la {subject} la.',
                ]),
                'variables' => json_encode(['student_name', 'grade', 'subject']),
                'active' => true,
            ],
            [
                'name' => 'Absence Non Justifiée',
                'type' => 'absence',
                'content' => json_encode([
                    'french' => 'Votre enfant {student_name} était absent le {date}.',
                    'dioula' => 'I den {student_name} tun tɛ kalanso la {date}.',
                ]),
                'variables' => json_encode(['student_name', 'date']),
                'active' => true,
            ],
            [
                'name' => 'Réunion Parents',
                'type' => 'meeting',
                'content' => json_encode([
                    'french' => 'Réunion parents le {date} à {time}. Votre présence est importante.',
                    'dioula' => 'Bangebaga lajɛ bɛna kɛ {date} {time} la. I ka na.',
                ]),
                'variables' => json_encode(['date', 'time']),
                'active' => true,
            ],
        ];

        foreach ($templates as $template) {
            DB::table('mama_ecole_templates')->insert(array_merge($template, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Créer des données d'analytics
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $totalCalls = rand(50, 200);
            $successfulCalls = intval($totalCalls * (rand(70, 95) / 100));
            
            DB::table('mama_ecole_analytics')->insert([
                'date' => $date->format('Y-m-d'),
                'total_calls' => $totalCalls,
                'successful_calls' => $successfulCalls,
                'failed_calls' => $totalCalls - $successfulCalls,
                'average_duration' => rand(60, 120) + (rand(0, 99) / 100),
                'language_breakdown' => json_encode([
                    'french' => rand(30, 50),
                    'dioula' => rand(15, 25),
                    'baoule' => rand(10, 20),
                    'bete' => rand(5, 15),
                    'senoufo' => rand(5, 10),
                ]),
                'hourly_distribution' => json_encode($this->generateHourlyData()),
                'message_type_breakdown' => json_encode([
                    'grades' => rand(20, 35),
                    'absence' => rand(15, 25),
                    'meeting' => rand(10, 20),
                    'urgent' => rand(5, 10),
                    'welcome' => rand(5, 10),
                ]),
                'engagement_rate' => rand(65, 95) + (rand(0, 99) / 100),
                'cost_fcfa' => $totalCalls * rand(25, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Mettre à jour les compteurs des classes
        foreach ($classes as $class) {
            $class->updateStudentCount();
        }

        $this->command->info('MAMA ÉCOLE seeding completed successfully!');
        $this->command->info('Created:');
        $this->command->info('- ' . count($teachers) . ' teachers');
        $this->command->info('- ' . count($classes) . ' classes');
        $this->command->info('- ' . count($parents) . ' parents');
        $this->command->info('- ' . Student::count() . ' students');
        $this->command->info('- ' . DB::table('mama_ecole_interactions')->count() . ' interactions');
    }

    private function generateHourlyData(): array
    {
        $data = [];
        for ($hour = 8; $hour <= 20; $hour++) {
            $data[$hour] = rand(0, 20);
        }
        return $data;
    }
}
