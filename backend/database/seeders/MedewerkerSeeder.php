<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MedewerkerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medewerkers')->insert([
            'gebruikersnaam' => 'admin',
            'wachtwoord' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
