<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function homePage(): View
    {
        $pageData = [
            'title' => 'Home',
            'categories' => Category::all(),
            'posts' => Post::when(request('category_id'), function ($query) {
                $query->where('category_id', request('category_id'));
            })->latest()->get(),
        ];
        return view('blog.post.index', $pageData);;
    }

    public function showPost(Post $post): View
    {
        $pageData = [
            'title' => 'Post',
            'post' => $post
        ];
        return view('blog.post.show', $pageData);
    }

    public function aboutPage(): View
    {
        return view('pages.about_page', ['title' => 'About']);
    }
}
