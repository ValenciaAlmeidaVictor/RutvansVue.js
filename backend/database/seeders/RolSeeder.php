<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roleAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $roleUser = Role::firstOrCreate(['name' => 'User']);

        // Crear permisos y asignarlos al rol Admin
        $permissions = [
            ['name' => 'dashboard', 'description' => 'Ver el Dashboard'],
            ['name' => 'users.index', 'description' => 'Ver listado de Usuarios'],
            ['name' => 'users.edit', 'description' => 'Asignar un Rol'],
            ['name' => 'users.update', 'description' => 'Actualizar un Rol'],
            ['name' => 'roles.index', 'description' => 'Ver listado de Roles'],
            ['name' => 'roles.show', 'description' => 'Ver Vista de Roles'],
            ['name' => 'roles.create', 'description' => 'Crear un Rol'],
            ['name' => 'roles.edit', 'description' => 'Editar un Rol'],
            ['name' => 'roles.destroy', 'description' => 'Eliminar un Rol'],
            ['name' => 'permissions.index', 'description' => 'Ver listado de Permisos'],
            ['name' => 'permissions.show', 'description' => 'Ver detalle de un Permiso'],
            ['name' => 'permissions.create', 'description' => 'Crear un Permiso'],
            ['name' => 'permissions.edit', 'description' => 'Editar un Permiso'],
            ['name' => 'permissions.destroy', 'description' => 'Eliminar un Permiso'],
            // Agrega aquí más permisos según sea necesario
        ];

        foreach ($permissions as $permissionData) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionData['name'], 'guard_name' => 'web'],
                ['description' => $permissionData['description']]
            );

            // Asignar el permiso al rol Admin
            $roleAdmin->givePermissionTo($permission);
        }

        // Asignar permisos específicos para el rol User
        $userPermissions = [
            'dashboard', // Ver Dashboard
        ];

        foreach ($userPermissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            $roleUser->givePermissionTo($permission);
        }

        // Si necesitas asignar más permisos a otros roles, puedes hacerlo aquí

        // Puedes asignar roles a usuarios aquí, si es necesario
        // Ejemplo:
        // $user = User::find(1); // Encuentra un usuario
        // $user->assignRole($roleAdmin); // Asignar el rol Admin al usuario
    }
}
