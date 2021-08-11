@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Danh sách Invoice')
@section('content')
<div class="add-button">
	<button type="button" class="btn btn-success btn-lg"> <a href="{{URL::to('/get-project')}}">+ Add Invoice</a></button>
</div>
@if (session('success'))
<div class="alert alert-success">
	{{ session('success') }}
</div>
@endif
	<table class="table table-hover table-bordered table-border-margin"> 
		<thead>
			<tr style="background-color: black;">
				<th>STT</th>
				<th>Create Date</th>
				<th>Customer</th>
				<th>Address</th>				
				<th>Estimate</th>   
				<th>Expire Date</th>             
				<th>Total</th>
				<th>Status</th>
                <th>Invoice Detail</th>				
			</tr>
		</thead>
		<tbody>	
	
		<?php $stt=0; ?>
		@foreach($invoices as $invoice)
            <?php $status = ""; ?>
            @if($invoice->status == 0)
                <?php $status = "Chưa thanh toán"; ?>
            @else
                <?php $status = "Đã thanh toán"; ?>
            @endif
			<tr>
				<td>{{++$stt}} </td>
				<td><?php echo date_format(new DateTime($invoice->create_date),'Y-m-d');  ?></td>
				<td>{{$invoice->customer_name}}</td>
				<td>{{$invoice->customer_address}}</td>				
				<td>{{$invoice->estimate_id}}</td>
				<td><?php echo date_format(new DateTime($invoice->expire_date),'Y-m-d');?></td>
				<td><?php echo number_format($invoice->total)?></td>
                <td>{{$status}}</td>				                
                <td><a href="{{URL::to('/invoice'.$invoice->id)}}" style="color:seagreen;">Detail</a></td>
			</tr>
			<!-- last day of next month
			<?php
				$date = new DateTime($invoice->expire_date);
				$date->modify('last day of next month');
				echo $date->format('Y-m-d');
			?> -->
		@endforeach
  		</tbody> 
	</table>
	{{ $invoices -> links() }}
@endsection

