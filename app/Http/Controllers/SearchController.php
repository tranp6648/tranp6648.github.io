<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    //
    public function index()
    {
        //code here
        return view('search');
    }
    public function Search(Request $request)
    {
        $get_name = $request->input('search');
        $product = DB::table('product')->join('photo', 'photo.id_product', '=', 'product.id_product')->where('name_product', 'like', '%' . $get_name . '%')->select('*')->get();
        return view('search')->with('product', $product);
    }
}
