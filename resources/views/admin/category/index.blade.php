@extends('layout.layout_admin')
@section('content')
<div class="card">
	<div class="card-header">
		Quản lý danh mục
	</div>
	    @if (session('success'))
    <div class="alert alert-success">
    	{{session('success')}}
    </div>
@endif
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Tên danh mục</th>
				<th>slug</th>
				<th>keywords</th>
				<th>meta</th>
				<th>trạng thái</th>
				<th></th>

			</tr>
		</thead>
		<tbody>
			@foreach($cate as $key =>$cate)
			<tr>
				<td>{{$cate->category_name}}</td>
				<td>{{$cate->category_slug}}</td>
				<td>{{$cate->category_key}}</td>
				<td>{{$cate->category_meta}}</td>
				@if($cate->category_status==0)
				<td><img src="{{asset('/public/backend/upload/1.ico')}}" /></td>
				@else
				<td><img src="{{asset('/public/backend/upload/2.ico')}}" style="width: 30px" /></td>
				@endif
				<td>
					<a href="{{route('danhmuc.edit',['danhmuc'=>$cate->category_id])}}" class="btn btn-primary">edit</a>
					<form onClick="confirm('Delete entry?')"
					 action="{{route('danhmuc.destroy',['danhmuc'=>$cate->category_id])}}" method="POST">
						@method('DELETE')
						@csrf
					<button  class="btn btn-danger">delete</button>
				</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection