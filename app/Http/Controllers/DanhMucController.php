<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use Illuminate\Support\Facades\Session;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function index()
    {
        $this->auth();
        $cate=category::get();
        return view('admin.category.index')->with(compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->auth();
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->auth();
        $request->validate([
            'category_name'=>'required|unique:tbl_category',
            'category_key'=>'required',
            'category_slug'=>'required',
            'category_meta'=>'required',
        ]);
        $data=$request->all();
        $cate=new category;
        $cate->category_name=$data['category_name'];
        $cate->category_key=$data['category_key'];
        $cate->category_slug=$data['category_slug'];
        $cate->category_meta=$data['category_meta'];
        $cate->category_status=$data['category_status'];
        $cate->save();
        session::flash('success','Thêm thành công');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->auth();
        $cate=category::where('category_id',$id)->first();
        return view('admin.category.edit')->with(compact('cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->auth();
        $request->validate([
            'category_name'=>'required',
            'category_key'=>'required',
            'category_slug'=>'required',
            'category_meta'=>'required',
        ]);
        $data=$request->all();
        $cate=category::find($id);
        $cate->category_name=$data['category_name'];
        $cate->category_key=$data['category_key'];
        $cate->category_slug=$data['category_slug'];
        $cate->category_meta=$data['category_meta'];
        $cate->category_status=$data['category_status'];
        $cate->save();
        session::flash('success','Sửa thành công');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->auth();
        $cate=category::where('category_id',$id)->delete();
        session::flash('success','Xóa thành công');
        return back();
    }
}
