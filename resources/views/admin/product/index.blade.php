@extends('layout.layout_admin')
@section('content')
<div class="card">
	<div class="card-header">
		Quản lý truyện
	</div>
	    @if (session('success'))
    <div class="alert alert-success">
    	{{session('success')}}
    </div>
@endif
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Anh</th>
				<th>Tên truyện</th>
				<th>slug</th>
				<th>keywords</th>
				<th>meta</th>
				<th>Nội dung</th>
				<th>trạng thái</th>
				<th></th>

			</tr>
		</thead>
		<tbody>
			@foreach($pro as $key =>$pro)
			<tr>
{{-- 				<td><img style="width: 80px" src="{{url('/public/backend/upload/'.$pro->product_img)}}"/></td>
 --}}
 				@foreach($contents as $content)
 				@if($pro->product_img==$content['name'])
 				<td><iframe src="https://drive.google.com/file/d/{{$content['basename']}}/preview" width="150" allow="autoplay"></iframe></td>
 				@endif
 				@endforeach
 				<td>{{$pro->product_name}}</td>
				<td>{{$pro->product_slug}}</td>
				<td>{{$pro->product_key}}</td>
				<td>{{$pro->product_meta}}</td>
				<td>{{$pro->product_content}}</td>
				@if($pro->product_status==0)
				<td><img src="{{asset('/public/backend/upload/1.ico')}}" /></td>
				@else
				<td><img src="{{asset('/public/backend/upload/2.ico')}}" style="width: 30px" /></td>
				@endif
				<td>
					<a href="{{route('product.edit',['product'=>$pro->product_id])}}" class="btn btn-primary">edit</a>
					<form onClick="confirm('Delete entry?')"
					 action="{{route('product.destroy',['product'=>$pro->product_id])}}" method="POST">
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