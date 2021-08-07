
  <table style="width:100%">
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>VAIX CO., LTD</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>So 50, Go Soi, Hong Ky, Soc Son, Ha Noi, Viet Nam</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Tel: +843-3384-6868</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8">請求書</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>日付：</td>
        <td></td>
        <td colspan="2"><?php echo date_format(new DateTime($invoice_details[0]->create_date),'Y-m-d');?></td>
        <td colspan="4">No：</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>お客様：</td>
        <td></td>
        <td colspan="6">{{$invoice_details[0]->customer_name}}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>住所：</td>
        <td></td>
        <td colspan="6">{{$invoice_details[0]->customer_address}}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>TEL：</td>
        <td></td>
        <td colspan="2">{{$invoice_details[0]->customer_phone}}</td>
        <td>FAX：　</td>
        <td colspan="2">{{$invoice_details[0]->customer_fax}}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>見積番号：</td>
        <td></td>
        <td colspan="2">{{$invoice_details[0]->estimate_id}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>製品・サービス：</td>
        <td></td>
        <td colspan="6">{{$invoice_details[0]->project_name}}</td>
      </tr>
  </table>
  <table class="table">
        <thead>
            <tr>
                 <th></th>
                 <th></th>
                 <th>#</th>
                 <th colspan="4">項目</th>
                 <th>数量</th>
                 <th>単価（円）</th>
                 <th>合計（円）</th>
             </tr>
         </thead>
         <tbody>
             <?php 
                $stt = 0;  
                $sub_total = 0;
                $tax = config('global.tax'); //take tax in file global
            ?>
                @for ($y = 0; $y < $invoice_details->count();$y++)
                 <?php $sub_total += $invoice_details[0]->amount; ?>
                 <tr>
                     <td></td>
                     <td></td>
                     <td>{{++$stt}}</td>
                     <td colspan="4">{{$invoice_details[0]->item_name}}</td>
                     <td>{{$invoice_details[0]->quantity}}</td>
                     <td><?php echo number_format($invoice_details[0]->price); ?></td>
                     <td><?php echo number_format($invoice_details[0]->amount); ?></td>
                 </tr>
                 @endfor
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="7">合計</td>
                    <td>¥ <?php echo number_format($sub_total); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="7">消費税({{$tax}}%)</td>
                    <td>¥ <?php echo number_format($sub_total*$tax/100); ?></td><!--#echo tax in file global-->
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="7"><b>合計金額</b></td>
                    <td>¥ <?php echo number_format($sub_total+($sub_total*$tax/100));?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td rowspan="3" colspan ="8">備考</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
         </tbody>
</table>
<table class="table">
         <tbody>
             <tr>
                 <td></td>
                 <td></td>
                 <td>お支払い期限：</td>
                 <td><?php echo date_format(new DateTime($invoice_details[0]->expire_date),'Y-m-d');?></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td>銀行名：</td>
                 <td>NGAN HANG TMCP DAU TU VA PHAT TRIEN VIET NAM (BIDV)</td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td colspan="2">支店名：</td>
                 <td>DONG HA NOI</td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td>Swift コード：</td>
                 <td>BIDVVNVX</td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td>口座番号：</td>
                 <td><p>21410410265442</p></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
             <tr>
                 <td></td>
                 <td></td>
                 <td>口座名義：</td>
                 <td>CONG TY TNHH TRI TUE NHAN TAO VAIX VIET NAM</td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td></td>
             </tr>
         </tbody>
</table>