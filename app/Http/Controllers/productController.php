<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\product;
use File;
use Storage;
class productController extends Controller
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
        $contents = collect(Storage::cloud()->listContents('', false))
        ->where('type', '!=' ,'dir');
        $pro= product::get();
        return view('admin.product.index')->with(compact('pro','contents'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->auth();
        return view('admin.product.create');

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
            'product_name'=>'required|unique:tbl_product',
            'product_key'=>'required',
            'product_slug'=>'required',
            'product_meta'=>'required',
            'product_auth'=>'required',
            'product_content'=>'required',
            'product_img'=>'required',
        ]);
        $data=$request->all();
        $pro=new product;
        $pro->product_name=$data['product_name'];
        $pro->product_key=$data['product_key'];
        $pro->product_slug=$data['product_slug'];
        $pro->product_meta=$data['product_meta'];
        $pro->product_auth=$data['product_auth'];
        $pro->product_content=$data['product_content'];
        $pro->product_status=$data['product_status'];
        $get_image=$data['product_img'];
        $path='public/backend/upload/';
      $get_name_img=$get_image->getClientOriginalName();
      $name_img=current(explode('.', $get_name_img));
      $new_image=$name_img.time().'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $pro->product_img=$new_image;

        $filename = $new_image;
        $filePath = public_path('backend/upload/'.$new_image);
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);

        $pro->save();

        $path1='public/backend/upload/'.$new_image;
        if(File::exists($path1)){
            unlink($path1);
        }
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
        $pro=product::where('product_id',$id)->first();
        $contents = collect(Storage::cloud()->listContents('', false))
        ->where('type', '!=' ,'dir');
        return view('admin.product.edit')->with(compact('pro','contents'));
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
            'product_name'=>'required',
            'product_key'=>'required',
            'product_slug'=>'required',
            'product_meta'=>'required',
            'product_auth'=>'required',
            'product_content'=>'required',
        ]);
        $data=$request->all();
        $pro= product::find($id);
        $pro->product_name=$data['product_name'];
        $pro->product_key=$data['product_key'];
        $pro->product_slug=$data['product_slug'];
        $pro->product_meta=$data['product_meta'];
        $pro->product_auth=$data['product_auth'];
        $pro->product_content=$data['product_content'];
        $pro->product_status=$data['product_status'];
        $file=$request->product_img;
        if($file){
        $get_image=$data['product_img'];
        $path='public/backend/upload/';
      $get_name_img=$get_image->getClientOriginalName();
      $name_img=current(explode('.', $get_name_img));
      $new_image=$name_img.time().'.'.$get_image->getClientOriginalExtension();
        $get_image->move($path,$new_image);
        $pro->product_img=$new_image;


        //thêm
        $filename = $new_image;
        $filePath = public_path('backend/upload/'.$new_image);
        $fileData = File::get($filePath);
        Storage::cloud()->put($filename, $fileData);

        //xóa
        $proo=product::find($id);
        $filename=$proo->product_img;
        $fileinfo = collect(Storage::cloud()->listContents('/', false))
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // có thể bị trùng tên file với nhau!
        Storage::cloud()->delete($fileinfo['path']);
        
        $pro->save();

        $path1='public/backend/upload/'.$new_image;
        if(File::exists($path1)){
            unlink($path1);
        }
        session::flash('success','Sửa thành công');
        return back();    
    }
        else{
        $pro->save();
        session::flash('success','Sửa thành công');
        return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro=product::where('product_id',$id)->first();
        $path='public/backend/upload/'.$pro->product_img;
        if(File::exists($path)){
            unlink($path);
        }
        $filename=$pro->product_img;
        $fileinfo = collect(Storage::cloud()->listContents('/', false))
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // có thể bị trùng tên file với nhau!
        Storage::cloud()->delete($fileinfo['path']);

        product::where('product_id',$id)->delete();
        session::flash('success','Xóa thành công');
        return back();
    }
}
