<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Photo;
use App\Models\product;
use Illuminate\Support\Facades\Session;
class ProductController extends Controller
{
    //
    public function product(){
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $list_category=DB::table('category')->select('*')->get();
        $list_product=DB::table('product')->select('*')->get();
        return view('Product.add_product')->with('list_category',$list_category)->with('list_product', $list_product)->with('list_photo',$list_photo);
    }
    public function show_add_product(){
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $list_product=DB::table('product')->join('category','product.id_category','=','category.id')->orderBy('id_product','DESC')->select('*')->paginate(5);
        if($key=request()->key){
            $list_product=DB::table('product')->join('category','product.id_category','=','category.id')->select('*')->where('product.name_product','like','%'.$key.'%')->paginate(5);
        }
        return view('product.list_product')->with('list_product',$list_product)->with('list_photo',$list_photo);
    }
    public function bonus_photo(Request $request){
        $data=array();
        $request->validate(['fileImg'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048']);
        
        $data['status']=$request->status;
        $data['id_product']=$request->product;
        $get_image=$request->file('fileImg');
        if($get_image){
            $new_image=rand(0,99).'.' .$get_image->getClientOriginalExtension();
            $get_image->move('public/upload',$new_image);
            $data['value']=$new_image;
            DB::table('photo')->insert($data);
            return redirect('add_Product')->with('success','add Photo success');
        }
        $data['value']='';
        DB::table('photo')->insert($data);
 
        return redirect('add_Product')->with('success','add Photo success');
    }
    public function add_product(Request $request){
        $data=array();
        $request->validate(['nameProduct' => 'required','Price'=>'required']);
        $data['name']=$request->nameProduct;
        $data['id_category']=$request->category;
        $data['money']=$request->Price;
        $data['content']=$request->description;
        DB::table('product')->insert($data);
       
        return redirect('/add_Product')->with('success','add Product success');
    }
    public function delete_product($id){
      
      
       DB::table('product')->where('id_product',$id)->delete();
    
        return redirect('/list_product')->with('success','delete Product success');
    }
    public function edit_product($id_product){
        $data_last = session()->get('value');
        
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $student=DB::table('product')->select('*')->where('id_product',$id_product)->get();
        $list_category=DB::table('category')->select('*')->get();
        return view('Product.edit_product')->with('student',$student)->with('list_category',$list_category)->with('list_photo',$list_photo);
    }
    public function update_product(Request $request,$id_product){
        $data=array();
     
        $data['name_product']=$request->nameProduct;
        $data['id_category']=$request->category;
        $data['money']=$request->Price;
        $data['content']=$request->description;
      
        DB::table('product')->where('id_product',$id_product)->update($data);
        return redirect('/list_product')->with('success','update product success');  
    }
    public function detail_product($id_product){
        $data_last = session()->get('value');
        $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
        $data=DB::table('product')->select('*')->join('photo','product.id_product','=','photo.id_product')->join('category','product.id_category','=','category.id')->where('product.id_product',$id_product)->first();
        $data1=DB::table('product')->select('*')->join('photo','product.id_product','=','photo.id_product')->where('product.id_product',$id_product)->get();
        return view('Product.detail_product')->with('data',$data)->with('data1',$data1)->with('list_photo',$list_photo);
    }
    public function filter_product(Request $request){
     $filter_category=$request->date;
     $data_last = session()->get('value');
     $list_product=DB::table('product')->join('category','product.id_category','=','category.id')->orderBy('id_product','DESC')->select('*')->paginate(5);
     $list_photo = DB::table('user')->join('photo', 'user.id_photo', '=', 'photo.id_photo')->select('*')->where('user.id_photo', $data_last)->first();
    $product= DB::table('product')->join('category','product.id_category','=','category.id')->orderBy('id_product','DESC')->where('category.id','like', '%' . $filter_category . '%')->select('*')->get();
     return view('product.filter_product')->with('product',$product)->with('list_product',$list_product)->with('list_photo',$list_photo); 
    }
    }

