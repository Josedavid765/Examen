<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AddAuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            'id' => Str::uuid(),
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password123'),
            'birth_date' => '1995-05-05',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
