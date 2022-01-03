<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\admin;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function auth()
    {
        $get=Session::get('admin');
        if($get){
            return redirect('/home');
        }
        else{
            return redirect('/login')->send();
        }
    }
    public function index(){
        $this->auth();
        return view('admin.index');
    }
    public function login(){
        return view('admin.login');
    }
        public function logout(){
        Session::put('admin',null);
            return view('admin.login');
    }
    public function login_admin(Request $request){
        $request->validate([
            'email'=>'required|min:5',
            'pass'=>'required|min:5'
        ]);
        $data=$request->all();
        $admin=admin::where('admin_email',$data['email'])->where('admin_password',md5($data['pass']))->first();
        if($admin!=null){
        Session::put('admin',$admin->admin_name);
        return redirect('/home');
        }
        else{
        session::flash('error','Đăng nhập thất bại');
        return redirect()->back();
        }
    }
}
