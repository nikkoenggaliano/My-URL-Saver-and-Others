<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Validator;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

 
    public function signup(Request $request){
        $db = new User;
        $role = 'user';
        $active = 0;
        $message = array(
            'required'     => ':attribute Tidak boleh kosong',
            'username.min' => 'Username minimal adalah 5 karakter',
            'username.max' => 'Username maximal adalah 15 karakter',
            'username.alpha_num' => 'Username hanya boleh huruf dan angka',
            'password.min' => 'Password minimal 6 karakter',
            'password.max' => 'Password maximum 30 karakter',
            'password.different' => 'Password tidak boleh sama dengan username'
        );

        $rules = array(
            'username' => 'required|unique:users|min:5|max:15|alpha_num',
            'email'    => 'required|unique:users|email',
            'password' => 'required|confirmed|min:6|max:30'
        );

        $valid = Validator::make($request->post(), $rules, $message);
        if($valid->fails()){ 
            $msg = $valid->errors()->first();
            // dd($msg);
            return redirect()->route('auth')->with('error', $msg);
        }else{
            
            User::Create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $role,
                'active'   => $active,
            ]);
        
            return redirect()->route('auth')->with('success', 'User Berhasil dibuat!');
        }

    }


    public function login(Request $request){

        $user = filter_var($request->user, FILTER_VALIDATE_EMAIL) ? "email" : "username";
        
        $data = array(
            $user => $request->user,
            "password" => $request->password
        );

        if(Auth::attempt($data)){
                
            if(!Auth::user()->active) {
                Auth::logout();
                return redirect()->route('auth')->with('info', 'Akunmu belum aktif, aktifkan dahulu atau hubungi Admin');
            }else{
                return redirect()->route('user-dashboard');
            }
            
        }else{
            
            return redirect()->route('auth')->with('error', 'Username atau password salah!');

        }
    }



    public function auth(Request $request){

        if(isset($request->logonfirst)){
            return redirect()->route('auth')->with('info', 'You need login first!');
        }


        return view('auth');
    }


    public function logout(Request $request){

        if(Auth::check()){
            Auth::logout();
            return redirect()->route('auth')->with('info', 'Logout success!');
            
        }

        return redirect()->route('auth');

    }



}