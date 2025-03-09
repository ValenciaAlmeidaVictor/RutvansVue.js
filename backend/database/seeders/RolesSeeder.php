<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles iniciales
        $adminRole = Role::create(['name' => 'Admin']);
        $moderatorRole = Role::create(['name' => 'Moderator']);
        $userRole = Role::create(['name' => 'User']);

        // Opcional: Crear permisos iniciales
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'view posts']);

        // Opcional: Asignar permisos a roles
        $adminRole->givePermissionTo(['edit posts', 'delete posts', 'view posts']);
        $moderatorRole->givePermissionTo(['edit posts', 'view posts']);
        $userRole->givePermissionTo(['view posts']);
    }
}
