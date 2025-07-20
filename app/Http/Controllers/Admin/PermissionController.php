<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->get();
        $permissions = Permission::all();
        $users = User::with('roles')->get();

        // Statistiques
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::role('admin')->count(),
            'total_authors' => User::role('author')->count(),
            'total_readers' => User::role('user')->count(),
        ];

        // Matrice des permissions
        $permissionMatrix = $this->buildPermissionMatrix($roles, $permissions);

        // Modifications récentes (simulées pour l'instant)
        $recentChanges = $this->getRecentChanges();

        // Préparer les données des rôles pour JavaScript
        $rolesData = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->toArray()
            ];
        });

        return view('admin.permissions', compact('roles', 'permissions', 'users', 'stats', 'permissionMatrix', 'recentChanges', 'rolesData'));
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Rôle créé avec succès !');
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        // Mettre à jour le nom du rôle
        $role->update(['name' => $request->name]);

        // Synchroniser les permissions
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            // Si aucune permission n'est sélectionnée, retirer toutes les permissions
            $role->syncPermissions([]);
        }

        return redirect()->back()->with('success', 'Rôle "' . $role->name . '" mis à jour avec succès !');
    }

    public function getRole(Role $role)
    {
        return response()->json([
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->toArray()
        ]);
    }

    public function deleteRole(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'Impossible de supprimer un rôle assigné à des utilisateurs.');
        }

        $role->delete();
        return redirect()->back()->with('success', 'Rôle supprimé avec succès !');
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Rôle assigné avec succès !');
    }

    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500'
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->back()->with('success', 'Permission créée avec succès !');
    }

    private function buildPermissionMatrix($roles, $permissions)
    {
        $matrix = [];

        foreach ($permissions as $permission) {
            $matrix[$permission->name] = [];
            foreach ($roles as $role) {
                $matrix[$permission->name][$role->name] = $role->hasPermissionTo($permission->name);
            }
        }

        return $matrix;
    }

    private function getRecentChanges()
    {
        // Pour l'instant, retournons des données simulées
        // Dans une vraie application, vous pourriez avoir une table d'audit
        return [
            [
                'user' => 'Marie Dubois',
                'action' => 'Rôle changé de "Utilisateur" à "Auteur"',
                'time' => '2 heures',
                'avatar' => 'https://ui-avatars.com/api/?name=Marie+Dubois&background=6366f1&color=fff'
            ],
            [
                'user' => 'Jean Martin',
                'action' => 'Permissions modifiées pour le rôle "Auteur"',
                'time' => '1 jour',
                'avatar' => 'https://ui-avatars.com/api/?name=Jean+Martin&background=6366f1&color=fff'
            ],
            [
                'user' => 'Sophie Laurent',
                'action' => 'Nouveau rôle "Modérateur" créé',
                'time' => '3 jours',
                'avatar' => 'https://ui-avatars.com/api/?name=Sophie+Laurent&background=6366f1&color=fff'
            ]
        ];
    }
}
