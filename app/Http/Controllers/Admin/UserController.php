<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadProfileImageRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function dashboard(): View
    {
        $pageData = [
            'title' => 'Admin Dashboard',
            'posts' => Post::latest()->get(),
            'roles' => Role::latest()->get(),
            'categories' => Category::latest()->get(),
            'users' => User::where('accessibility', '!=', 0)->latest()->get(),
        ];
        return view('dashboard', $pageData);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pageData = ['title' => 'Create New User', 'roles' => Role::all(), 'password' => Str::password()];
        return view('admin.user.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        (new CreateNewUser())->create($request->all());

        return redirect(route('dashboard'))->with('success', 'User data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', ['title' => $user->name, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        $pageData = [
            'title' => $user->name,
            'user' => $user,
            'roles' => Role::all(),
            'user_role' => $user->roles()->first()
        ];
        return view('admin.user.edit', $pageData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        (new UpdateUserProfileInformation())->update(User::findOrFail($id), $request->all());

        return redirect(route('dashboard'))->with('success', 'User updated successfully');
    }

    public function uploadPhoto(UploadProfileImageRequest $request, User $user): RedirectResponse
    {
        $userImage = $user->user_image;
        //dd($user);
        if ($request->hasFile('user_image')) {

            //unlink existing file first
            $existingFileWithPath = public_path('assets/images/users/' . $userImage);

            if (file_exists($existingFileWithPath) && $userImage  != 'avatar.png') {
                File::delete((public_path($existingFileWithPath)));
            }

            $uploadedFile = $request->file('user_image');

            $extension = $uploadedFile->extension();

            $userImage = Str::random(20) . '_' . time() . '.' . $extension;

            $uploadedFile->move(public_path('assets/images/users'), $userImage);
        }

        $user->user_image = $userImage;
        $user->save();
        return back()->with('success', 'User photo uploaded successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::find($id);
        $existingFileWithPath = public_path('assets/images/users/' . $user->user_mage);

        if (file_exists($existingFileWithPath) && $user->user_mage  != 'avatar.png') {
            File::delete((public_path($existingFileWithPath)));
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    public function activateUser(User $user): RedirectResponse
    {
        $user->status = 1;
        $user->save();
        return back()->with('success', 'User activated successfully');
    }

    public function deactivateUser(User $user): RedirectResponse
    {
        $user->status = 0;
        $user->save();
        return back()->with('success', 'User deactivated successfully');
    }
}
