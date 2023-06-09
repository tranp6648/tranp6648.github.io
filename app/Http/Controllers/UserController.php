<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        return view('user.User')->with('list_photo', $list_photo);
    }

    public function my_account()
    {
        $data_session = session()->get('id');
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $list_user = DB::select('select username,password,email,phone from user where id=?', [$data_session]);
        return view('user.my_account')->with('list_user', $list_user)->with('list_photo', $list_photo);
    }

    public function EditUsername(request $request)
    {
        $data_session = session('id');
        $new_username = $request->input('new_username');
        DB::update('update user set username =? where id=?', [$new_username, $data_session]);
        session()->flash('success', 'UserName Was Update!');
        return redirect('/user/my_account');
    }

    public function EditEmail(request $request)
    {
        $data_session = session()->get('id');
        $new_email = $request->input('new_email');
        DB::update('update user set email =? where id=?', [$new_email, $data_session]);
        session()->flash('success', 'Email Was Update!');
        return redirect('/user/my_account');
    }

    public function EditPhone(request $request)
    {
        $data_session = session()->get('id');
        $new_phone = $request->input('new_phone');
        DB::update('update user set phone =? where id=?', [$new_phone, $data_session]);
        session()->flash('success', 'Phone Was Update!');
        return redirect('/user/my_account');
    }

    public function EditPassword(request $request)
    {
        $data_session = session()->get('id');
        $old_password = md5($request->old_password);
        $new_password = md5($request->new_password);
        $re_new_password = md5($request->re_new_password);
        $password = DB::table('user')->where('password', $old_password)->first();
        if ($password and $new_password == $re_new_password) {
            DB::update('update user set password=? where id=? ', [$new_password, $data_session]);
            Session()->flash('message', 'Reset Password success');
            return redirect('/user/my_account');
        } else if (!$password and $new_password == $re_new_password) {
            Session()->flash('old', 'Old password incorrect');
            return redirect('/user/my_account');
        } else if ($password and $re_new_password !== $new_password) {
            Session()->flash('accept', 'New password does not match the re-enter Password ');
            return redirect('/user/my_account');
        } else if (!$password and $new_password !== $re_new_password) {
            Session()->flash('same', 'Old password and re-enter password is incorrect');
            return redirect('/user/my_account');
        }
    }

    public function history_feedback()
    {
        $data_session = session()->get('id');
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $data_feedback = DB::table('feedback')->join('product', 'feedback.id_product', '=', 'product.id_product')->join('user', 'user.id', '=', 'feedback.id_user')->where('user.id', '=', $data_session)->get();
        return view('user.history_feedback')->with('data_feedback', $data_feedback)->with('list_photo', $list_photo);
    }
}
