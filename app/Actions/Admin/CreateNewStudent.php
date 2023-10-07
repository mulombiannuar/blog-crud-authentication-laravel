<?php

namespace App\Actions\Admin;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class CreateNewStudent
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input, string $image): Student
    {
        return Student::create([
            'image' => $image,
            'name' => $input['name'],
            'email' => $input['email'],
            'course' => $input['course'],
            'mobile_number' => $input['mobile_number'],
            'password' => Hash::make($input['password']),
            'user_id' => user()->id
        ]);
    }
}
