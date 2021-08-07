@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Thêm hoá đơn.....')
@section('library')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="js/itemlist.js"></script>
@endsection

@section('content')
<?php
    //fuction last day of next month
    $date = new DateTime(date('Y-m-d'));
    $date->modify('last day of next month');
?>
<div style="font-size: 0.8rem; margin:20px;">
    <form>
        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="ngaytao">Ngày tạo:</label>
            </div>
            <div class="form-group col-md-5">
                <input class="date form-control" id="ngaytao" value="<?php echo date("Y-m-d"); ?>" type="text" >                          
            </div>
            <div class="form-group col-md-1">
                 <label for="hantt">Hạn thanh toán:</label>
            </div>
            <div class="form-group col-md-5">               
                <input class="date form-control" id="hantt" type="text" value="<?php echo $date->format('Y-m-d');?>" >             
                <!--#add datepicker-->
                <script type="text/javascript">
                    $('.date').datepicker({  
                    format: 'yyyy-mm-dd'
                    });  
                </script> 
                <!--#daetpicker end-->
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="khachang">Khách hàng:</label>
            </div>
            <div class="form-group col-md-5">                
                <select class="form-control" id="khachang">
                <option value="" selected disabled>Chọn khách hàng..</option>
                    @foreach($customers as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach   
                </select>           
            </div>
            <div class="form-group col-md-1">
                <label for="sdt">Điện thoại:</label>
            </div>
            <div class="form-group col-md-5">
                <input class="date form-control" type="text" value="" id="sdt" name="txtsdt" disabled>             
            </div>
        </div>
        <div class="form-row">
             <div class="form-group col-md-1">
                 <label for="diachi">Địa chỉ:</label>
            </div>
            <div class="form-group col-md-5">
                <input class="form-control" value="" type="text" id="diachi" disabled>                          
            </div>
            <div class="form-group col-md-1">
                <label for="fax">Fax:</label>
            </div>
            <div class="form-group col-md-5">
                <input class="form-control" type="text" value="" id="fax" disabled >             
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-1">
                <label for="project">Project:</label>     
            </div>
            <div class="form-group col-md-5">
                <select class="form-control" id="project" data-depen>
                <option value="" selected disabled>Chọn project..</option>
                    @foreach($projects as $p)
                        <option value="{{$p->id}}">{{$p->name}}</option>
                    @endforeach   
                </select>                               
            </div>
            <div class="form-group col-md-1">
                <label for="estimate">Estimate:</label>     
            </div>
            <div class="form-group col-md-5">
                <select class="form-control" id="estimate">
                <option value="" selected disabled>Chọn estimate..</option>
                    @foreach($estimates as $e)
                        <option value="{{$e->id}}">{{$e->id}}</option>
                    @endforeach   
                </select>                   
            </div>
        </div>
            
        <div id="test"></div>
    <!--total of invoice-->
    <div class="row clearfix" style="margin-top:20px">
        <div class="pull-right col-md-6"></div>
        <div class="pull-right col-md-6">
                <table class="table table-bordered table-hover" id="tab_logic_total">
                    <tbody>
                        <tr>
                            <th class="text-center">Tổng phụ</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                        </tr>
                    <tr>
                        <th class="text-center">Tax</th>
                        <td class="text-center"><div class="input-group mb-2 mb-sm-0">
                            <input type="number" class="form-control" id="tax" placeholder="0" >
                            <div class="input-group-addon"> %</div>
                        </div></td>
                    </tr>
                    <tr>
                        <th class="text-center">Tax Amount</th>
                        <td class="text-center"><input type="number" name='tax_amount' id="tax_amount" placeholder='0.00' class="form-control" readonly/></td>
                    </tr>
                    <tr>
                        <th class="text-center">Grand Total</th>
                        <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                    </tr>
                    </tbody>
                </table>
        </div>
    </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
 </form>
    <!--end total of invoice-->
</div>

@endsection
