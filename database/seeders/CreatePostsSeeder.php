<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreatePostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Post::create([
            'title' => 'Post 1',
            'description' => 'Description for post 1',
            'body' => 'Body for post 1',
            'slug' => 'post-1',
            'category_id' => 1,
            'user_id' => 1,
            'image' => 'image1.png'
        ]);

        Post::create([
            'title' => 'Post 2',
            'description' => 'Description for post 2',
            'body' => 'Body for post 2',
            'slug' => 'post-2',
            'category_id' => 2,
            'user_id' => 1,
            'image' => 'image1.png'
        ]);

        Post::create([
            'title' => 'Post 3',
            'slug' => 'post-3',
            'description' => 'Description for post 3',
            'body' => 'Body for post 3',
            'category_id' => 3,
            'user_id' => 1,
            'image' => 'image1.png'
        ]);
    }
}
