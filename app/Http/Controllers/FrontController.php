<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Hod;
use App\Models\Teacher;
use Auth;
use Hash;

class FrontController extends Controller
{
    //!============================ admin ===================

    // admin register
    public function  post_register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'password' => 'required',
        ]);

        $admin = new  User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect('/register')->with('success', "admin signup successfully!");
    }

    // admin login
    public function  post_Login(Request $request)
    {
        $validations = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // dd($request->all());
        // dd($request->password);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // admin logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logs out the user
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token
        return redirect('/')->with('success', 'Log out successfully!');
    }


    //!=========================== student ==========================

    // student form data save
    public function addStudentForm()
    {
        return view('student.add-student-form');
    }

    public function  studentForm(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|digits:10|unique:students,phone',
            'aadhaar' => 'required',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validation->errors()
            ], 400);
        } else {
            $std = new  Student();
            $std->name = $request->name;
            $std->email = $request->email;
            $std->phone = $request->phone;
            $std->aadhaar = $request->aadhaar;
            $std->address = $request->address;
            $std->save();

            return response()->json([
                'status'  => true,
                'message' => 'Students added successfully!',
            ], 200);
        }
    }

    // edit student form data
    public function editStudentForm($id)
    {
        $student = Student::where('id', $id)->first();
        return view('student.edit-student-form', ['students' => $student]);
        // or
        // $data['students'] = $student;
        // return view('student.edit-student-form',$data);
    }

    public function updateFormData(Request $request)
    {
        $id = $request->student_id;
        $validation = \Validator::make($request->all(), [
            'student_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|digits:10|unique:students,phone,' . $id,
            'aadhaar' => 'required',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validation->errors()
            ], 400);
        } else {
            $std = Student::where('id', $id)->first();
            $std->name = $request->name;
            $std->email = $request->email;
            $std->phone = $request->phone;
            $std->aadhaar = $request->aadhaar;
            $std->address = $request->address;
            $std->save();

            return response()->json([
                'status'  => true,
                'message' => 'Students updated successfully!',
            ], 200);
        }
    }

    public function mainpage()
    {
        // count user
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        //   dd($totalStudents);
        return view('mainContentpage', ["totalStudents" => $totalStudents, "totalTeachers" => $totalTeachers]);
    }

    public function loginPage()
    {
        return view('Login');
    }

    public function registerPage()
    {
        return view('Register');
    }

    //   public function studentList(){
    //     // get all user
    //     $students = Student::get(); // where()-> ye filtter ke liye use hota hai
    //     // dd($students);
    //     return view('StudentList',["students"=> $students]);
    // }

    /// yajra data table
    public function student_list(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::query(); // or select specific columns

            return DataTables::of($students)
                ->addIndexColumn() // auto serial number
                ->addColumn('action', function ($row) {
                    $btn = '<a onclick="editStudent(' . $row->id . ')" class="btn btn-sm btn-primary">Edit</a> ';
                    $btn .= '<a onclick="deleteStudent(' . $row->id . ')" class="btn btn-sm btn-danger">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('student.student-list');
    }

    /// delete
    public function deleteStudentForm($id)
    {
        $response = array();
        // $student = Student::where('id',$id)->first();
        // or
        $student = Student::findOrFail($id); // work on primary key findOrFail
        if ($student !== null) {
            $student->delete();
            $response['status']  = true;
            $response['message'] = 'Student deleted successfully!';
        } else {
            $response['status']  = false;
            $response['message'] = 'Student not  deleted ';
        }
        return response()->json($response);
    }

    //// ======================== teacher =================

    public function add_teacher()
    {
        return view('teacher.add-teacher-form');
    }

    //! ==================== Edit teacher ====================

    public function edit_teacher_form($id)
    {
        $teacher = Teacher::where('id', $id)->first();
        // dd($teacher);
        $data['teachers'] = $teacher;
        return view('teacher.edit-teacher-form', $data);
    }

    public function teacher_list()
    {
        $teachers = Teacher::get(); // get all teacher
        // $teachers = Teacher::paginate(1); // ek ek user pagination pr jayega 

        return view('teacher.teacher-list', ["teachers" => $teachers]); // as a prop sare user bhej denge
    }

    //! ======================== add teacher =================

    public function save_teacher(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|digits:10',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validation->errors()
            ], 400);
        } else {
            $std = new  Teacher();
            $std->name = $request->name;
            $std->email = $request->email;
            $std->phone = $request->phone;
            $std->address = $request->address;
            $std->save();

            return response()->json([
                'status'  => true,
                'message' => 'Teacher added successfully!',
            ], 200);
        }
    }

    //!============================== update teacher =================

    public function update_Teacher_FormData(Request $request)
    {
        $id = $request->teacher_id;
        $validation = \Validator::make($request->all(), [
            'teacher_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'required|digits:10',
            'address' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validation->errors()
            ], 400);
        } else {
            $std = Teacher::where('id', $id)->first(); // agar ye data base me colomn ki  kisi id se jo id  aa rahi hai usse match karti hai to update kar de 
            $std->name = $request->name;
            $std->email = $request->email;
            $std->phone = $request->phone;
            $std->address = $request->address;
            $std->save();

            return response()->json([
                'status'  => true,
                'message' => 'teacher updated successfully!',
            ], 200);
        }
    }

    //!================== delete teacher =========================

    public function delete_Teacher_Form($id)
    {
        $response = array();
        // $student = Student::where('id',$id)->first();
        // or
        $teacher = Teacher::findOrFail($id); // work on primary key findOrFail
        if ($teacher !== null) {
            $teacher->delete();
            $response['status']  = true;
            $response['message'] = 'Teacher deleted successfully!';
        } else {
            $response['status']  = false;
            $response['message'] = 'Teacher not  deleted ';
        }
        return response()->json($response);
    }


    //================== HOD ======================================

    public function add_hod()
    {
        return view('hod.add-hod');
    }

    public function edit_hod($id)
    {
        $hod = Hod::where('id', $id)->first();
        return view('hod.edit-hod', ['hod' => $hod]);
    }

    public function list_hod()
    {
        $hods = Hod::get();
        return view('hod.list-hod', ["hods" => $hods]);
    }

    public function post_hod(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:hods,email',
            'phone' => 'required|digits:10|unique:hods,phone',
            'department' => 'required'
        ]);

        $Hod = new  Hod();
        $Hod->name = $request->name;
        $Hod->email = $request->email;
        $Hod->phone = $request->phone;
        $Hod->department = $request->department;
        $Hod->save();

        return redirect()->back()->with('success', "hod added successfully!");
    }

    public function update_hod(Request $request)
    {
        $id = $request->hod_id;
        $validation = $request->validate([
            'hod_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:hods,email,' . $id,
            'phone' => 'required|digits:10|unique:hods,phone,' . $id,
            'department' => 'required'
        ]);

        // $hod =  Hod::where('id',$id)->first();
        $hod = Hod::findOrFail($id);
        $hod->name = $request->name;
        $hod->email = $request->email;
        $hod->phone = $request->phone;
        $hod->department = $request->department;
        $hod->save();

        return redirect()->back()->with('success', "Hod updated successfully!");
    }

    public function delete_hod($id)
    {
        $hod = Hod::findOrFail($id);
        if ($hod !== null) {
            $hod->delete();
            return redirect()->back()->with('success', "Hod deleted successfully!");
        } else {
            return redirect()->back()->with('error', "Hod not found!");
        }
    }
}