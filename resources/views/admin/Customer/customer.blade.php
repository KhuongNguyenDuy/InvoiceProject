@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Danh sách khách hàng')
@section('content')
<div class="add-button">
	<!--<button type="button" class="btn btn-success btn-lg"> + Add Customer</button>-->
	<button type="button" onclick="window.location.href='/add-customer'" class="btn btn-success btn-lg">+ Thêm </button>
</div>
<!--check session add invoice if success-->
@if (session('success'))
<div class="alert alert-success" style="margin:10px;">
	{{ session('success') }}
</div>
@endif
<table class="table table-hover table-bordered table-border-margin"> 
	<thead>
			<tr style="background-color: black;">
			<th class="col-sm-1 display-text" >STT</th>
			<th class="col-sm-2 display-text">Customer Name</th>
			<th class="col-sm-3 display-text">address</th>
			<th class="col-sm-2 display-text">Phone Number</th>
            <th class="col-sm-2 display-text">Fax Number</th>
			<th class="col-sm-1 display-text">Edit</th>
			<th class="col-sm-1 display-text">Delete</th>
		</tr>
	</thead>
	<tbody>	
		<?php $stt=0;?>
		@foreach($customers as $customer)
		<tr>
			<td class="col-sm-1 display-text">{{++$stt}} </td>
			<td class="col-sm-2">{{$customer->name}}</td>
			<td class="col-sm-3">{{$customer->adress}}</td>
            <td class="col-sm-2">{{$customer->phone}}</td>
			<td class="col-sm-2">{{$customer->fax}}</td>
			<td class="col-sm-1 display-text"><a href="{{'/customer-edit'.$customer->id}}" class="fas fa-edit" style="color:seagreen;font-size:20px;"></a></td>
			<td class="col-sm-1 display-text"><a href="{{'/customer-delete'.$customer->id}}" class="fas fa-trash delete_customer" style="color:red;font-size:20px;"></a></td>
		</tr>
		@endforeach
	</tbody> 
</table>
<script type="text/javascript">
    $('.delete_customer').on('click', function () {
        return confirm('Bạn có muốn xoá mục đã chọn không?');
    });
</script>
	{{ $customers -> links() }}
@endsection



	