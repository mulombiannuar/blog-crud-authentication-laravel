<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Web Design',
            'HTML',
            'Photoshop'
        ];

        DB::table('categories')->truncate();
        foreach ($categories as $category) {
            Category::insert([
                'name' => $category
            ]);
        }
    }
}
