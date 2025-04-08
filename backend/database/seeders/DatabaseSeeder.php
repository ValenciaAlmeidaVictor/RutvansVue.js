<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;
use Spatie\Permission\Models\Role; // Si estás usando Spatie Laravel Permission
=======
>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
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
=======
        // Crear los roles si no existen
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'User']);

        // Llamar al UserSeeder
        $this->call(UserSeeder::class);
>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723
    }
    

}
