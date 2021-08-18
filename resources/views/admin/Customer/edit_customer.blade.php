@extends('admin.layout')
@section('title', 'Home page')
@section('title-detail', 'Sửa thông tin khách hàng')
@section('library')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="js/itemlist.js"></script>
@endsection

@section('content')
<div style="font-size:0.9rem; margin: auto; width:80%;border: solid 1px gray;padding:15px;">
    <!--form submit request add invoice-->
    <form action='/customer-edit' method="post" name="form_edit_customer" onsubmit="return validateForm()">
         @csrf
         <!--row ten customer name-->
        <div class="form-row">
            <div class="form-group col-md-2">
                <b><label for="customer_name" >Tên công ty : (*)</label></b>
            </div>
            <div class="form-group col-md-10">
                <input type="hidden" name="customer_id" value="{{$customers[0]->id}}">
                <input type="text" value="{{$customers[0]->name}}" id="customer_name" name="customer_name" placeholder="" class="input-xlarge form-control" required oninvalid="this.setCustomValidity('Hãy nhập tên công ty')" oninput="this.setCustomValidity('')">
                <p class="help-block" id="mess_name"><i>Tên công ty không quá 225 ký tự</i></p>                        
            </div>
        </div>
         <!--row ten customer address-->
        <div class="form-row">
            <div class="form-group col-md-2">
                <b><label for="address">Địa chỉ : (*)</label></b>
            </div>
            <div class="form-group col-md-10">
                <input type="text" value="{{$customers[0]->adress}}" id="address" name="address" placeholder="" class="input-xlarge form-control" required oninvalid="this.setCustomValidity('Hãy nhập địa chỉ')" oninput="this.setCustomValidity('')">
                <p class="help-block" id="mess_address"><i>Địa chỉ không quá 255 ký tự</i></p>                        
            </div>
        </div>
         <!--row ten customer phone-->
        <div class="form-row">
            <div class="form-group col-md-2">
                <b><label for="phone_number">Số điện thoại : (*)</label></b>
            </div>
            <div class="form-group col-md-5">
                <input type="text" value="{{$customers[0]->phone}}" id="phone_number" name="phone_number" class="input-xlarge form-control" required oninvalid="this.setCustomValidity('Hãy nhập số điện thoại')" oninput="this.setCustomValidity('')">
                <p class="help-block" id="mess_phone"><i>Không quá 11 chữ số</i></p>                        
            </div>
        </div>
         <!--row ten customer fax-->
        <div class="form-row">
            <div class="form-group col-md-2">
                <b><label for="fax_number">Số Fax : (*)</label></b>
            </div>
            <div class="form-group col-md-5">
                <input type="text" value="{{$customers[0]->fax}}" id="fax_number" name="fax_number" class="input-xlarge form-control" required oninvalid="this.setCustomValidity('Hãy nhập số Fax')" oninput="this.setCustomValidity('')">
                <p class="help-block" id="mess_fax"><i>Không quá 11 chữ số</i></p>                        
            </div>
        </div>

         <!--row ten customer name-->
        <div class="form-row">
            <div class="form-group col-md-8"></div>
            <div class="form-group col-md-4">
                <button type="submit"  class="btn btn-success">Cập nhật</button>
            </div>
        </div>
    </form>
    <!--#end form submit add customer-->
</div>
<script>
    function validateForm() {
    let name = document.forms["form_edit_customer"]["customer_name"].value;
    let address = document.forms["form_edit_customer"]["address"].value;
    let phone = document.forms["form_edit_customer"]["phone_number"].value;
    let fax = document.forms["form_edit_customer"]["fax_number"].value;
    var flag = 0;
    
    if(name.length > 255){
        document.getElementById("mess_name").style.color = "red";
        flag = 1;
    }else{
        document.getElementById("mess_name").style.color = "#858796";
    }
    if(address.length > 255){
        document.getElementById("mess_address").style.color = "red";
        flag = 1;
    }else{
        document.getElementById("mess_address").style.color = "#858796";
    }
    // var japan_phone = /(\d{2,3})\-?(\d{3,4})\-?(\d{4})/g;
    // if (japan_phone.test(phone) == false) {
    //         alert('Số điện thoại của bạn không đúng định dạng!');
    //         return false;
    // }
    // var numb = phone.match(/\d/g);//get number only
    // numb = numb.join("");
    // var faxn = fax.match(/\d/g);//get number only
    // faxn = faxn.join("");
    if(phone.length > 11){
        document.getElementById("mess_phone").style.color = "red";
        flag = 1;
    }else{
        document.getElementById("mess_phone").style.color = "#858796";
    }
    if(fax.length > 11){
        document.getElementById("mess_fax").style.color = "red";
        flag = 1;
    }else{
        document.getElementById("mess_fax").style.color = "#858796";
    }
    if(flag == 1){
        return false;
    }
    
    // var japan_fax = /(\d{2,3})\-?(\d{3,4})\-?(\d{4})/g;
    // if (japan_fax.test(faxn) == false) {
    //         alert('Số fax của bạn không đúng định dạng!');
    //         return false;
    // }

    var numbers = /^[0-9]+$/;
    if(phone.match(numbers)){
    }
    else{
        alert('Không phải số điện thoại');
        document.forms["form_edit_customer"]["phone_number"].focus();
        return false;
    }
    var numbers = /^[0-9]+$/;
    if(fax.match(numbers)){
    }
    else{
        alert('Không phải số fax');
        document.forms["form_edit_customer"]["fax_number"].focus();
        return false;
    }
    
}
        
</script>
@endsection
