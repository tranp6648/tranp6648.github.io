<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PhotoController extends Controller
{
    //
    public function add_photo()
    {
        $list_product = DB::table('product')->select('*')->get();
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        return view('photo.add_picture')->with('list_product', $list_product)->with('list_photo',$list_photo);
    }

    public function save_photo(Request $request)
    {
        $data = array();
        $request->validate(['fileImg' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048']);
        $data['status'] = $request->status;
        $data['id_product'] = $request->product;
        $get_image = $request->file('fileImg');
        if ($get_image) {
            $new_image = rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload', $new_image);
            $data['value'] = $new_image;
            DB::table('photo')->insert($data);
            return redirect('add_photo')->with('success', 'add Photo success');
        }
        $data['value'] = '';
        DB::table('photo')->insert($data);
        return redirect('add_photo')->with('success', 'add Photo success');
    }
    public function show_photo()
    {
        $photo = DB::table('photo')->join('product', 'product.id_product', '=', 'photo.id_product')->select('*')->paginate(5);
        $data_last = session()->get('value');
        if($key=request()->key){
            $photo = DB::table('photo')->join('product', 'product.id_product', '=', 'photo.id_product')->select('*')->where('product.name_product','like','%'.$key.'%')->paginate(5);
        }
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        return view('photo.list_picture')->with('photo', $photo)->with('list_photo',$list_photo);
    }

    public function unlike($id_photo)
    {
        DB::update('update photo set status=? where id_photo=?', [0, $id_photo]);
        return redirect('show_photo');
    }
    public function like($id_photo)
    {
        DB::update('update photo set status=? where id_photo=?', [1, $id_photo]);
        return redirect('show_photo');
    }
    //delete picture
    public function delete_picture($id_photo)
    {
        $category = DB::table('photo')->where('id_photo', $id_photo);
        $category->delete();
        return redirect('/show_photo')->with('success', 'delete photo success');
    }
}
