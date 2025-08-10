<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup roles and permissions for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up roles and permissions...');

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
            $this->info("Permission créée: {$name}");
        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        $this->info('Rôle admin créé');

        $authorRole = Role::firstOrCreate([
            'name' => 'author',
            'guard_name' => 'web'
        ]);
        $this->info('Rôle author créé');

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
        $this->info('Rôle user créé');

        // Assigner les permissions aux rôles
        $adminRole->syncPermissions(Permission::all());
        $this->info('Permissions assignées au rôle admin');

        $authorRole->syncPermissions([
            'publish-books',
            'download-books',
            'view-analytics',
            'manage-categories'
        ]);
        $this->info('Permissions assignées au rôle author');

        $userRole->syncPermissions([
            'download-books'
        ]);
        $this->info('Permissions assignées au rôle user');

        // Vider le cache des permissions
        app()['cache']->forget(config('permission.cache.key'));
        $this->info('Cache des permissions vidé');

        $this->info('Setup terminé avec succès !');
    }
}
