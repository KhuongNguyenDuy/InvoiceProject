@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Danh sách Estimate')
@section('content')
	<div class="add-button">
		<button type="button" onclick="window.location.href='/file-upload'" class="btn btn-success btn-lg"> + Add Estimate</button>
	</div>
	<table class="table table-hover table-bordered table-border-margin"> 
		<thead>
			<tr style="background-color: black;">
				<th class="col-sm-1 display-text" >STT</th>
				<th class="col-sm-5 display-text">Estimate ID</th>
                <th class="col-sm-4 display-text">Mô Tả</th>
				<th class="col-sm-1 display-text">Edit</th>
				<th class="col-sm-1 display-text">Delete</th>
			</tr>
		</thead>
		<tbody>	
		<?php $stt=0;?>
		@foreach($estimates as $estimate)
			<tr>
				<td class="col-sm-1 display-text">{{++$stt}} </td>
				<td class="col-sm-5">{{$estimate->id}}</td>
                <td class="col-sm-4"><a href="{{URL::to('/file-download')}}">download</a></td>
				<td class="col-sm-1 display-text"><a href="{{'/estimate'.$estimate->id.'/edit'}}" class="fas fa-edit" style="color:seagreen;"></a></td>
				<td class="col-sm-1 display-text"><a href="{{'/estimate'.$estimate->id.'/delete'}}" class="fas fa-trash" style="color:red;"></a></td>
			</tr>
		@endforeach
  		</tbody> 
	</table>
	{{ $estimates -> links() }}
@endsection
