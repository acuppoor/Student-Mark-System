<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function changePassword(Request $request){
        $oldPassword = $request->input('oldPassword');
        $newPasswordOne = $request->input('newPasswordOne');
        $newPasswordTwo = $request->input('newPasswordTwo');
        $userId = $request->input('userId');

        if(Auth::user()->id != $userId || !password_verify($oldPassword, Auth::user()->password)){
            throwException();
        }
        $user = Auth::user();
        $user->password  = bcrypt($newPasswordOne);
        $user->save();
    }

    public function updatePersonalInfo(Request $request){
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $studentNumber = $request->input('studentNumber');
        $employeeId = $request->input('employeeId');
        $email = $request->input('email');
        $userId = $request->input('userId');

        if(Auth::user()->id != $userId){
            throwException();
        }
        $user = Auth::user();
        if($firstName && $user->first_name != $firstName){
            $user->first_name = $firstName;
//            $user->approved = 0;
        }
        if($lastName && $user->last_name != $lastName){
            $user->last_name = $lastName;
//            $user->approved = 0;
        }
        if($studentNumber){
            $user->student_number = $studentNumber;
        }
        if($employeeId){
            $user->employee_id = $employeeId;
        }
        if($email){$user->email = $email;}
        $user->save();
    }
}
