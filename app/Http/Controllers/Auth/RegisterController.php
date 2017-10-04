<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\UserDepartmentMap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'studentNumber' => 'required|string|min:9|max:9',
            'employeeID' => 'required|string|min:7|max:7',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::where('student_number', $data['studentNumber'])
            ->where('email', $data['email'])->first();

        if(!$user) {
            $user = User::where('student_number', $data['studentNumber'])->first();
        }

        if(!$user) {
            $user = User::where('email', $data['email'])->first();
        }

        if(!$user){
           $user =  new User();
           $user->first_name = $data['firstName'];
            $user->last_name = $data['lastName'];
            $user->email = $data['email'];
            $user->student_number = $data['studentNumber'];
            $user->employee_id = $data['employeeID'];
            $user->approved = 0;
            $user->role_id = 1;
            $user->password = bcrypt($data['password']);
            $user->account_registered = 1;
            $user->save();
        } else {
            $user->first_name = $data['firstName'];
            $user->last_name = $data['lastName'];
            $user->email = $data['email'];
            $user->student_number = $data['studentNumber'];
            $user->employee_id = $data['employeeID'];
            $user->password = bcrypt($data['password']);
            $user->account_registered = 1;
            $user->save();
//            Auth::logout();
        }

        /**
         * Adding the user to the first department which is Computer Science in the event the user is
         *not already mapped to a department. This must, however, be changed to allow user to select their department.
         *Currently, it is assumed the system is mainly being used for comp sci dept.
         */
        $userDepartmentMap = UserDepartmentMap::where('user_id', $user->id)->first();
        if(!$userDepartmentMap){
            $userDepartmentMap = new UserDepartmentMap();
            $userDepartmentMap->user_id = $user->id;
            $userDepartmentMap->department_id = 1;
            $userDepartmentMap->status = 0;
            $userDepartmentMap->save();
        }

        /**
         * the section just above must be commnented if the user is allowed to choose his department when
         * logging in
         */

        return /*redirect()->route('login')*/ $user;
    }
}
