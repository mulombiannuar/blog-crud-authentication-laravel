<?php

declare(strict_types=1);

namespace App\Http\Controllers\Blog;

use App\Actions\Admin\MediaUploading;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('blog.post.create', ['title' => 'Create Post', 'categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $postImage = (new MediaUploading())->upload($request->file('post_image'), 'images/posts', 'default.png', null);
        if (!$postImage)
            return back()->with('danger', 'Post couldnt be saved because of invalid image');

        Post::create([
            'image' => $postImage,
            'body' => $request->body,
            'title' => $request->title,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'slug' => Str::of($request->title)->slug('-')
        ]);
        return redirect(route('dashboard'))->with('success', 'Post data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $post = Post::findOrFail($id);
        return view('blog.post.show', ['title' => $post->title, 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $this->redirectIfNotOwner($id);

        $post = Post::findOrFail($id);
        return view('blog.post.edit', ['title' => $post->title, 'post' => $post, 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $this->redirectIfNotOwner($id);

        $post = Post::findOrFail($id);
        $postImage = $post->image;

        $postImage = (new MediaUploading())->upload($request->file('post_image'), 'images/posts', 'default.png', $post->image);
        if (!$postImage)
            return back()->with('danger', 'Post couldnt be saved because of invalid image');

        $post->update([
            'image' => $postImage,
            'body' => $request->body,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'slug' => Str::of($request->title)->slug('-')
        ]);
        return redirect(route('dashboard'))->with('success', 'Post data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->redirectIfNotOwner($id);

        $post = Post::find($id);

        //unlink existing file first
        $existingFileWithPath = public_path('assets/images/posts/' . $post->image);
        if (file_exists($existingFileWithPath) && $post->image != 'default.png') {
            File::delete((public_path($existingFileWithPath)));
        }
        $post->delete();

        //Redirect to blog page is user is generic user

        return back()->with('success', 'Post data deleted successfully');
    }

    private function redirectIfNotOwner(string $id)
    {
        //abort if user is not the creater of the post or admin 
        if (!$this->isOwnerOfThePost($id))
            return back()->with('danger', 'You dont have right to access this resource');
    }

    private function isOwnerOfThePost(string $id): bool
    {
        if (Post::findOrFail($id)->user_id == Auth::user()->id || has_role('admin'))
            return true;
        return false;
    }

    public function wordDocument()
    {
        $imagePath = realpath(__DIR__ . '/../../../../public/assets/images/posts/default.png');
        $file_name = 'document-' . time() . '.docx';

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
        $section->addImage($imagePath);
        $section->addText($description);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(public_path('docs/' . $file_name));
        } catch (Exception $e) {
        }
        return response()->download(public_path('docs/' . $file_name));
    }
}
