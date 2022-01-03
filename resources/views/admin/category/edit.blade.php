@extends('layout.layout_admin')
@section('content')
<div class="card">
	<div class="card-header">
		Sửa danh mục
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
	   <form method="POST" action="{{route('danhmuc.update',['danhmuc'=>$cate->category_id])}}">
      @method('PUT')
      @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Tên thể loại</label>
    <input type="text" id="title" onkeyup="ChangeToSlug();" class="form-control" name="category_name" value="{{$cate->category_name}}" >
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">slug</label>
    <input type="text" id="slug" class="form-control" name="category_slug" value="{{$cate->category_slug}}" >
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">keywords</label>
    <input type="text" class="form-control" name="category_key" value="{{$cate->category_key}}" >
  </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Mô tả</label>
    <input type="text" class="form-control" name="category_meta" value="{{$cate->category_meta}}" >
  </div>
      <div class="form-group">
	<label for="exampleInputPassword1">Trạng thái</label>
<select name="category_status" class="form-select" aria-label="Default select example">
  <option {{($cate->category_status==0) ?'selected':''}} value="0">Kích hoạt</option>
  <option {{($cate->category_status==1) ?'selected':''}}  value="1">khóa</option>
</select>
</div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>
@endsection