<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSystemRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->truncate();
        Role::create([
            'name' => 'admin',
            'display_name' => 'admin',
            'description' => 'admin',
        ]);

        Role::create([
            'name' => 'user',
            'display_name' => 'user',
            'description' => 'user',
        ]);
    }
}
