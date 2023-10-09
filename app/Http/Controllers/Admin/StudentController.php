<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateNewStudent;
use App\Actions\Admin\MediaUploading;
use App\Actions\Admin\UpdateStudent;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'class_name'  => 'alert-success'
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|' . Rule::unique(Student::class),
            'mobile_number' => 'required|string|digits:10|max:255|' . Rule::unique(Student::class),
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->messages(),
                'class_name'  => 'alert-danger'
            ]);
        }

        $studentImage = (new MediaUploading())->upload($request->file('image'), 'images/students', 'default.png', null);

        if (!$studentImage)
            return back()->with('danger', 'Student couldnt be saved because of invalid image provided');

        $student = (new CreateNewStudent())->create($request->all(), $studentImage);

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'class_name'  => 'alert-success',
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
                'class_name'  => 'alert-success'
            ]);
        }

        return response()->json([
            'status'  => 200,
            'student'  => $student,
            'class_name'  => 'alert-success',
            'image' => '<img src="/assets/images/students/' . $student->image . '" class="img-thumbnail" width="200" />',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|' . Rule::unique('students')->ignore($id),
            'mobile_number' => 'required|string|digits:10|max:255|' . Rule::unique('students')->ignore($id),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'class_name'  => 'alert-danger',
                'errors'  => $validator->messages(),
            ]);
        }

        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status'  => 404,
                'class_name'  => 'alert-danger',
                'message'  => 'Student not found',
            ]);
        }

        $studentImage = (new MediaUploading())->upload($request->file('image'), 'images/students', 'default.png', $student->image);
        if (!$studentImage)
            return back()->with('danger', 'Student couldnt be saved because of invalid image provided');

        $student = (new UpdateStudent())->update($request->all(), $studentImage, $id);

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'class_name'  => 'alert-success',
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
                'class_name'  => 'alert-danger',
                'message'  => 'Student not found',
            ]);
        }
        $student->delete();

        return response()->json([
            'status'  => 200,
            'data' => $student,
            'class_name'  => 'alert-success',
            'message'  => 'Student data deleted successfully',
        ]);
    }
}
