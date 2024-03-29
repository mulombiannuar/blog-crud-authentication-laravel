<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();
        User::create([
            'name' => 'Anuary Mulombi',
            'email' => 'mulombiannuar@gmail.com',
            'mobile_number' => '0703539208',
            'email_verified_at' => now(),
            'password' => Hash::make('2023@Mulombi'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
