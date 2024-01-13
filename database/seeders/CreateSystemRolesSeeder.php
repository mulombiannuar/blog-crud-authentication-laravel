<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSystemRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();
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
