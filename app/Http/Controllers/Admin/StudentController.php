<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateNewStudent;
use App\Actions\Admin\UpdateStudent;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    use PasswordValidationRules;
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $pageData = ['title' => 'Create New Student',  'password' => Str::password()];
        return view('admin.student.create', $pageData);
    }

    public function fetchStudents()
    {
        $students = Student::latest()->get();
        return response()->json([
            'status'  => 200,
            'students'  => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique(Student::class),
            'mobile_number' => 'required|string|digits:10|max:255|' . Rule::unique(Student::class),
            'password' => $this->passwordRules(),
        ]);

        $studentImage = 'default.png';

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages(),
            ]);
        }

        $student = (new CreateNewStudent())->create($request->all(), $studentImage);

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'message'  => 'Student data saved successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        if (!$student) {
            return response()->json([
                'status'  => 404,
                'message'  => 'Student not found',
            ]);
        }

        return response()->json([
            'status'  => 200,
            'student'  => $student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|' . Rule::unique('students')->ignore($id),
            'mobile_number' => 'required|string|digits:10|max:255|' . Rule::unique('students')->ignore($id),
        ]);

        $studentImage = 'default.png';

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages(),
            ]);
        }

        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status'  => 404,
                'message'  => 'Student not found',
            ]);
        }

        $student = (new UpdateStudent())->update($request->all(), $studentImage, $id);

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'message'  => 'Student data updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => 404,
                'message'  => 'Student not found',
            ]);
        }
        $student->delete();

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'message'  => 'Student data deleted successfully',
        ]);
    }
}
