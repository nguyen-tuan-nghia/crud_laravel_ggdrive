@extends('layout.layout_admin')
@section('content')
<div class="card">
	<div class="card-header">
		Sửa truyện
	</div>
		    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
	    @if (session('success'))
    <div class="alert alert-success">
    	{{session('success')}}
    </div>
@endif
	   <form method="POST" action="{{route('product.update',['product'=>$pro->product_id])}}" enctype="multipart/form-data">
	   	@method('PUT')
      @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Tên truyện</label>
    <input type="text" id="title" onkeyup="ChangeToSlug();" class="form-control" name="product_name" value="{{$pro->product_name}}" >
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">slug</label>
    <input type="text" id="slug" class="form-control" name="product_slug" value="{{$pro->product_slug}}" >
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">keywords</label>
    <input type="text" class="form-control" name="product_key" value="{{$pro->product_key}}" >
  </div>
      <div class="form-group">
    <label for="exampleInputPassword1">Tác giả</label>
    <input type="text" class="form-control" name="product_auth" value="{{$pro->product_auth}}" >
  </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Mô tả</label>
    <input type="text" class="form-control" name="product_meta" value="{{$pro->product_meta}}" >
  </div>
     <div class="form-group">
    <label for="exampleInputPassword1">Nội dung</label>
    <input type="text" class="form-control" name="product_content" value="{{$pro->product_content}}" >
  </div>
      <div class="form-group">
	<label for="exampleInputPassword1">ảnh</label>
    <input type="file" class="form-control" name="product_img"  accept="image/*">
 				@foreach($contents as $content)
 				@if($pro->product_img==$content['name'])
 				<td><iframe src="https://drive.google.com/file/d/{{$content['basename']}}/preview" width="150" allow="autoplay"></iframe></td>
 				@endif
 				@endforeach
</div>
    <div class="form-group">
	<label for="exampleInputPassword1">Trạng thái</label>
<select name="product_status" class="form-select" aria-label="Default select example">
  <option  {{($pro->product_status==0) ? 'selected':''}} value="0">Kích hoạt</option>
  <option {{($pro->product_status==1) ? 'selected':''}} value="1">khóa</option>
</select>
</div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>
@endsection