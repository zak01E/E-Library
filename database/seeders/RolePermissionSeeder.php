<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les permissions
        $permissions = [
            'manage-users' => 'Gérer les utilisateurs',
            'publish-books' => 'Publier des livres',
            'approve-books' => 'Approuver les livres',
            'download-books' => 'Télécharger des livres',
            'view-reports' => 'Voir les rapports',
            'manage-settings' => 'Gérer les paramètres',
            'manage-roles' => 'Gérer les rôles et permissions',
            'moderate-content' => 'Modérer le contenu',
            'view-analytics' => 'Voir les analyses',
            'manage-categories' => 'Gérer les catégories'
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web'
            ]);
        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $authorRole = Role::firstOrCreate([
            'name' => 'author',
            'guard_name' => 'web'
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        // Assigner les permissions aux rôles
        $adminRole->syncPermissions(Permission::all());

        $authorRole->syncPermissions([
            'publish-books',
            'download-books',
            'view-analytics',
            'manage-categories'
        ]);

        $userRole->syncPermissions([
            'download-books'
        ]);

        // Créer des utilisateurs de test s'ils n'existent pas
        $adminUser = User::firstOrCreate([
            'email' => 'admin@elibrary.com'
        ], [
            'name' => 'Administrateur',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        $adminUser->assignRole('admin');

        $authorUser = User::firstOrCreate([
            'email' => 'author@elibrary.com'
        ], [
            'name' => 'Auteur Test',
            'password' => bcrypt('password'),
            'role' => 'author'
        ]);
        $authorUser->assignRole('author');

        $regularUser = User::firstOrCreate([
            'email' => 'user@elibrary.com'
        ], [
            'name' => 'Utilisateur Test',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
        $regularUser->assignRole('user');

        // Assigner des rôles aux utilisateurs existants
        $existingUsers = User::whereNotIn('email', [
            'admin@elibrary.com',
            'author@elibrary.com',
            'user@elibrary.com'
        ])->get();

        foreach ($existingUsers as $user) {
            if (!$user->hasAnyRole(['admin', 'author', 'user'])) {
                // Assigner un rôle basé sur le champ 'role' existant ou par défaut 'user'
                $roleName = $user->role ?? 'user';
                if (in_array($roleName, ['admin', 'author', 'user'])) {
                    $user->assignRole($roleName);
                } else {
                    $user->assignRole('user');
                }
            }
        }
    }
}
