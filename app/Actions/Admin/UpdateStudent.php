<?php

namespace App\Actions\Admin;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UpdateStudent
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function update(array $input, string $image, string $id): bool
    {
        return Student::where('id', $id)->update([
            'image' => $image,
            'name' => $input['name'],
            'email' => $input['email'],
            'course' => $input['course'],
            'mobile_number' => $input['mobile_number'],
        ]);
    }
}
