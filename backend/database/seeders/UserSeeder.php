<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el rol de 'Super Admin' si no existe
        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        // Crear el usuario Admin y asignarle el rol de 'Super Admin'
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'email_verified_at' => now()
        ]);

        $admin->assignRole($role);  // Asignar el rol 'Super Admin' al usuario
    }
}
