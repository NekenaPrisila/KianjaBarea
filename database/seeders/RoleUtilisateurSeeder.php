<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RoleUtilisateur;
use Illuminate\Database\Seeder;

class RoleUtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'caissier', 'commercial', 'dg'];
        
        foreach ($roles as $role) {
            RoleUtilisateur::create(['role' => $role]);
        }
    }
}
