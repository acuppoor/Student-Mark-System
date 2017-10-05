<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Response;

class GeneralController extends Controller
{
    /**
     * This controller is mainly used for general tasks which can be assosciated with many kind of users.
     */


    /**
     * this method takes in a userid with a new and old password
     * the authenticity of the user is checked and also checks whether the user is changing his own password
     * the password is updated
     * @param Request $request
     */
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

    /**
     * it is first checked that the user is updating his own personal information
     * if yes, the user account is updated.
     * @param Request $request
     */
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

    /**
     * AJAX call to this function to get the faculties name and id available in the system
     * @param Request $request
     * @return mixed
     */
    public function getFaculties(Request $request){
        $faculties = [];
        foreach (Faculty::all() as $item) {
            $fac = [];
            $fac['name'] = $item->name;
            $fac['id'] = $item->id;
            $faculties[] = $fac;
        }
        return Response::json($faculties);
    }
}
