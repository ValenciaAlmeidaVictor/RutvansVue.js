<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role; // Si estás usando Spatie Laravel Permission
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        // Crear el superadministrador
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@material.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('secret'),
            ]
        );
        

        // Asignar rol de superadministrador utilizando Spatie Laravel Permission
        $role = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->assignRole($role);
    }
    

}
