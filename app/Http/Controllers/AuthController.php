<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
class AuthController extends Controller
{
    public function grant_auth($employee_number,$area_code)
    { 
        $data_auth =
        [
            'employee_number' => $employee_number,
        ];

        if(Auth::attempt($data_auth))
        {
            Session::put('area_code',$area_code);
            Session::save();
            return Redirect::route('dashboard');
        }
        else
            return Redirect::to('login');
    }

    public function grant_auth_guest($employee_number)
    { 
        $data_auth =
        [
            'employee_number' => $employee_number,
        ];

        if(Auth::attempt($data_auth))
        {
            Session::put('area_code',"P14");
            Session::save();
            return Redirect::route('dashboard');
        }
        else
            return Redirect::to('login');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

    public function login()
    {
        Auth::logout();
        return view('login');
    }

    public function change_code(Request $request)
    { 
        Session::put('area_code',$request['area_code']);
        Session::save();
    }
   
}
