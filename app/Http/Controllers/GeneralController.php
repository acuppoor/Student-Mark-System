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
}
