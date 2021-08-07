@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Danh sách Customer')
@section('content')
<div class="add-button">
	<button type="button" class="btn btn-success btn-lg"> + Add Customer</button>
</div>

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
				<td class="col-sm-1 display-text"><a href="{{'/customer'.$customer->id.'/edit'}}" class="fas fa-edit" style="color:seagreen;"></a></td>
				<td class="col-sm-1 display-text"><a href="{{'/customer'.$customer->id.'/delete'}}" class="fas fa-trash" style="color:red;"></a></td>
			</tr>
		@endforeach
  		</tbody> 
	</table>
	{{ $customers -> links() }}
@endsection


	