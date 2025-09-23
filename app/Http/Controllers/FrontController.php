<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Auth;
use Hash;

class FrontController extends Controller
{
    // admin register
public function  post_Form(Request $request){
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
$admin -> save();

return redirect('/register') -> with('success',"form submited successfully!");
}

// admin login
public function  post_Login(Request $request){
$validations = $request->validate([
    'email' => 'required',
    'password' => 'required',
]);
// dd($request->all());
// dd($request->password);

if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    return redirect('/dashboard');
}
return back()->withErrors(['email' => 'Invalid credentials']);
}


// admin logout 
public function logout(Request $request){
    Auth::logout(); // Logs out the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate CSRF token
    return redirect('/')->with('success', 'Logged out successfully!');
}

// student form data save

public function  studentForm (Request $request){
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
}else{
    $std = new  Student();


    $std->name = $request->name;
    $std->email = $request->email;
    $std->phone = $request->phone;
    $std->aadhaar = $request->aadhaar;
    $std->address = $request->address;
    $std -> save();

     return response()->json([
        'status'  => true,
        'message' => 'Students added successfully!',
    ],200);
}
}

    public function test(){
        $totalStudents = Student::count();
        //   dd($totalStudents);
        return view('mainContentpage',["totalStudents"=> $totalStudents]); 
    }
     public function loginPage(){
        return view('Login');
    }
    public function registerPage(){
        return view('Register');
    }
      public function studentList(){
        $students = Student::get(); // where()-> ye filtter ke liye use hota hai 
        // dd($students);
        return view('StudentList',["students"=> $students]);
    }
}
