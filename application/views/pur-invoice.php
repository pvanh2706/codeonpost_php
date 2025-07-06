<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

  <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Xem hóa đơn nhập
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="<?php echo $base_url; ?>purchase">Thống kê đơn nhập</a></li>
        <li class="active">Đơn nhập</li>
      </ol>
    </section>
    <div class="row">
      <div class="col-md-12">
      <!-- ********** ALERT MESSAGE START******* -->
      <?php include"comman/code_flashdata.php"; ?>
      <!-- ********** ALERT MESSAGE END******* -->
      </div>
    </div>
    <?php
    $q1=$this->db->query("select * from db_company where id=1 and status=1");
    $res1=$q1->row();
    $company_name=$res1->company_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;
    $company_pan_no=$res1->pan_no;

    
    $q3=$this->db->query("SELECT a.supplier_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,a.city,
                           a.postcode,a.address,b.purchase_date,b.reference_no,
                           b.purchase_code,b.purchase_status,b.purchase_note,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status

                           FROM db_suppliers a,
                           db_purchase b 
                           WHERE 
                           a.`id`=b.`supplier_id` AND 
                           b.`id`='$purchase_id' 
                           ");
                        
    
    $res3=$q3->row();
    $supplier_name=$res3->supplier_name;
    $supplier_mobile=$res3->mobile;
    $supplier_phone=$res3->phone;
    $supplier_email=$res3->email;
    $supplier_state=$res3->state_id;
    $supplier_city=$res3->city;
    $supplier_address=$res3->address;
    $supplier_postcode=$res3->postcode;
    $supplier_gst_no=$res3->gstin;
    $supplier_tax_number=$res3->tax_number;
    $supplier_opening_balance=$res3->opening_balance;
    $purchase_date=$res3->purchase_date;
    $reference_no=$res3->reference_no;
    $purchase_code=$res3->purchase_code;
    $purchase_status=$res3->purchase_status;
    $purchase_note=$res3->purchase_note;

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    $discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    $supplier_country = $this->db->query("select country from db_country where id=".$res3->country_id)->row()->country;
    if(!empty($supplier_state)){
      $supplier_state = $this->db->query("select state from db_states where id=".$res3->state_id)->row()->state;
    }
    ?>


    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="printableArea">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> HÓA ĐƠN NHẬP HÀNG
            <small class="pull-right">Ngày lập: <?= show_date($purchase_date); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <i>CỬA HÀNG</i>
          <address>
            <strong><?php echo  $company_name; ?> | <?php echo  $company_mobile; ?></strong><br>
            <?php echo  str_replace('Aqua Home - ','',$company_address); ?>
            
           
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <i>NHÀ CUNG CẤP<br></i>
          <address>
            <strong><?php echo  $supplier_name; ?> | <?php echo $supplier_mobile; ?></strong><br>
            <?php 
              if(!empty($supplier_address)){
                echo $supplier_address;
              }
              if(!empty($supplier_country)){
                //echo $supplier_country;
              }
              if(!empty($supplier_state)){
                //echo ",".$supplier_state;
              }
              if(!empty($supplier_city)){
                //echo ",".$supplier_city;
              }
              if(!empty($supplier_postcode)){
                //echo "-".$supplier_postcode;
              }
            ?>
            <br>
            <?php //echo (!empty(trim($supplier_mobile))) ? $this->lang->line('mobile').": ".$supplier_mobile."<br>" : '';?>
            <?php //echo (!empty(trim($supplier_phone))) ? $this->lang->line('phone').": ".$supplier_phone."<br>" : '';?>
            <?php //echo (!empty(trim($supplier_email))) ? $this->lang->line('email').": ".$supplier_email."<br>" : '';?>
            <?php //echo (!empty(trim($supplier_gst_no))) ? $this->lang->line('gst_number').": ".$supplier_gst_no."<br>" : '';?>
            <?php //echo (!empty(trim($supplier_tax_number))) ? $this->lang->line('tax_number').": ".$supplier_tax_number."<br>" : '';?>

          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <i>HỆ THỐNG<br></i>
          <b>Mã hóa đơn: <span style="color: blue;">#<?php echo  $purchase_code; ?></span></b><br>
          <?php
                switch ($purchase_status) {
                    case 'Pending':
                        $stts = 'Chờ xử lý';
                        break;
                    case 'Ordered':
                        $stts = 'Đã đặt hàng';
                        break;
                    case 'Received':
                        $stts = 'Đã hoàn thành';
                        break;
                    default:
                        $stts = 'Đang xử lý';
                } ?>
          <b>Trạng thái: <span style="color: blue;"><?php echo $stts ; ?></span></b><br>
         
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
<hr>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped records_table table-bordered">
            <thead class="bg-gray-active">
            <tr>
              <th>#</th>
              <th>Mặt hàng</th>
              <th>Giá nhập</th>
              <th>Số lượng</th>
              <th>Chiết khấu</th>
              <!--th><?= $this->lang->line('discount_amount'); ?></th-->
              
              <th class="<?=tax_disable_class()?>"><?= $this->lang->line('tax'); ?></th>
              <th class="<?=tax_disable_class()?>"><?= $this->lang->line('tax_amount'); ?></th>
              
              <!--th><?= $this->lang->line('unit_cost'); ?></th-->
              <th>Tạm tính</th>
            </tr>
            </thead>
            <tbody>

              <?php
              $i=0;
              $tot_qty=0;
              $tot_purchase_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              

              $this->db->select("a.purchase_qty,
                                 a.tax_type,
                                 a.price_per_unit,
                                 a.tax_amt,
                                 a.discount_input,
                                 a.discount_type,
                                 a.discount_amt, 
                                 a.unit_total_cost,
                                 a.total_cost,
                                 b.tax,
                                 b.tax_name,
                                 c.item_name,
                                 a.description
                                 ");
              $this->db->from("db_purchaseitems a");
              $this->db->where("a.purchase_id",$purchase_id);
              $this->db->join("db_tax b","b.id=a.tax_id","left");
              $this->db->join("db_items c","c.id=a.item_id","left");
              $q2 = $this->db->get();


              foreach ($q2->result() as $res2) {

                  
                  echo "<tr>";  
                  echo "<td>".++$i."</td>";
                  echo "<td>";
                    echo $res2->item_name;
                    echo (!empty($res2->description)) ? "<br><i>[".nl2br($res2->description)."]</i>" : '';
                  echo "</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->price_per_unit))."</td>";
                  /*echo "<td>";
                    echo $res2->discount_input;
                      if(!empty($res2->discount_input) && $res2->discount_input>0){
                        echo (strtoupper($res2->discount_type)==strtoupper('Percentage')) ? "<br><b>(%)</b>" : "<br><b>(Fixed)</b>";
                      }
                  echo "</td>";*/
                  echo "<td class='text-right'>".number_format($res2->purchase_qty)."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->discount_amt))."</td>";
                  

                  echo "<td class='".tax_disable_class()."'>";
                    echo $res2->tax_name;
                      echo ($res2->tax_type=='Inclusive')? '<br><b>Inclusive</b>' : '<br><b>Exclusive</b>';
                    echo "</td>";
                  echo "<td class='text-right ".tax_disable_class()."'>".$CI->currency($res2->tax_amt)."</td>";
                  
                  //echo "<td class='text-right'>".$CI->currency($res2->unit_total_cost)."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->total_cost))."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->purchase_qty;
                  $tot_purchase_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_total_cost +=$res2->total_cost;
              }
              ?>
         
      
            </tbody>
            <tfoot class="text-right text-bold bg-gray">
              <tr>
                <td colspan="3" class="text-right">Tổng tạm tính</td>
                <td class="text-right"><?=number_format($tot_qty);?></td>
                <td><?= $CI->currency(number_format($tot_discount_amt)) ;?></td>
                
                <td class="<?=tax_disable_class()?>"></td>
                <td class="<?=tax_disable_class()?>"><?=$CI->currency($tot_tax_amt);?></td>
                
                <!--td><?= $CI->currency(number_format($tot_unit_total_cost)) ;?></td-->
                <td><?= $CI->currency(number_format($tot_total_cost)) ;?></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    
      <div class="row">
       <div class="col-md-6">
           <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="discount_to_all_input" class="col-sm-4 control-label" style="font-size: 17px;">Tổng chiết khấu</label>    
                    <div class="col-sm-8">
                       <label class="control-label  " style="font-size: 17px;">: <?=($discount_to_all_input) ? $discount_to_all_input : 'Không áp dụng'; ?></label>
                    </div>
                 </div>
              </div>
           </div>
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="purchase_note" class="col-sm-4 control-label" style="font-size: 17px;">Ghi chú đơn nhập</label>    
                    <div class="col-sm-8">
                       <label class="control-label  " style="font-size: 17px;">: <?=($purchase_note) ? $purchase_note : 'Không có ghi chú kèm theo';?></label>
                    </div>
                 </div>
              </div>
           </div> 
           <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <table class="table table-hover table-bordered" style="width:100%" id=""><h4 class="box-title text-info">Thông tin thanh toán: </h4>
                       <thead>
                          <tr class="bg-purple " >
                             <th>#</th>
                             <th>Thời gian</th>
                             <th>Thanh toán</th>
                             <th>Hình thức</th>
                             <th>Ghi chú</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php 
                            if(isset($purchase_id)){
                              $q3 = $this->db->query("select * from db_purchasepayments where purchase_id=$purchase_id");
                              if($q3->num_rows()>0){
                                $i=1;
                                $total_paid = 0;
                                foreach ($q3->result() as $res3) {
                                  echo "<tr class='text-center text-bold' id='payment_row_".$res3->id."'>";
                                  echo "<td>".$i++."</td>";
                                  echo "<td>".show_date($res3->payment_date)."</td>";
                                  echo "<td class='text-right'>".$CI->currency(number_format($res3->payment))."</td>";
                                  echo "<td>".$res3->payment_type."</td>";
                                  echo "<td>".$res3->payment_note."</td>";
                                  
                                  echo "</tr>";
                                  $total_paid +=$res3->payment;
                                }
                                echo "<tr class='text-right text-bold'><td colspan='4' >Tổng thanh toán</td><td>".$CI->currency(number_format($total_paid))."</td></tr>";
                              }
                              else{
                                echo "<tr><td colspan='5' class='text-center text-bold'>Chưa có thanh toán nào cho hóa đơn này!!</td></tr>";
                              }

                            }
                            else{
                              echo "<tr><td colspan='5' class='text-center text-bold'>Đang cập nhật dữ liệu thanh toán!!</td></tr>";
                            }
                          ?>
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>           
        </div>

        <div class="col-md-6">
           <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                     
                    <table  class="col-md-11">
                       <tr>
                          <th class="text-right" style="font-size: 17px;">Tổng tạm tính</th>
                          <th class="text-right" style="padding-left:10%;font-size: 17px;">
                             <h4><b id="subtotal_amt" name="subtotal_amt"><?=$CI->currency(number_format($subtotal));?></b></h4>
                          </th>
                       </tr>
                       <tr>
                          <th class="text-right" style="font-size: 17px;">Phụ phí khác</th>
                          <th class="text-right" style="padding-left:10%;font-size: 17px;">
                             <h4><b id="other_charges_amt" name="other_charges_amt"><?=$CI->currency(number_format($other_charges_amt));?></b></h4>
                          </th>
                       </tr>
                       <tr>
                          <th class="text-right" style="font-size: 17px;">Chiết khấu</th>
                          <th class="text-right" style="padding-left:10%;font-size: 17px;">
                             <h4><b id="discount_to_all_amt" name="discount_to_all_amt"><?=$CI->currency(number_format($tot_discount_to_all_amt));?></b></h4>
                          </th>
                       </tr>
                       <!--tr>
                          <th class="text-right" style="font-size: 17px;"><?= $this->lang->line('round_off'); ?></th>
                          <th class="text-right" style="padding-left:10%;font-size: 17px;">
                             <h4><b id="round_off_amt" name="tot_round_off_amt"><?=$CI->currency($round_off);?></b></h4>
                          </th>
                       </tr-->
                       <tr>
                          <th class="text-right" style="font-size: 17px;">Tổng thanh toán</th>
                          <th class="text-right" style="padding-left:10%;font-size: 17px;">
                             <h4><b id="total_amt" name="total_amt"><?=$CI->currency(number_format($grand_total));?></b></h4>
                          </th>
                       </tr>
                    </table>
                 </div>
              </div>
           </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </div><!-- printableArea -->
      <!-- this row will not appear when printing -->
      <div class="row no-print text-right">
        <div class="col-xs-12">
          <?php if($CI->permissions('sales_edit')) { ?>
          <!--a href="<?php echo $base_url; ?>purchase/update/<?php echo  $purchase_id ?>" class="btn btn-success">
            <i class="fa  fa-edit"></i> Edit
          </a-->
          <?php } ?>
          
          <?php if($payment_status != 'Paid') { ?>
            <span class="btn btn-primary" onclick="pay_now(<?=$purchase_id?>)">
                <i class="fa fa-dollar"></i> 
              Thanh toán nợ
            </span>
            <?php } ?>

          <a href='<?= base_url('items/labels/'.$purchase_id);?>' class="btn btn-info" title='Pop Up'><i class="fa fa-barcode"></i> In nhãn hàng</a>

          
          <a href="<?php echo $base_url; ?>purchase/print_invoice/<?php echo  $purchase_id ?>" target="_blank" class="btn btn-warning">
              <i class="fa fa-print"></i> 
            In hóa đơn A4
          </a>


          <!--a href="<?php echo $base_url; ?>purchase/pdf/<?php echo  $purchase_id ?>" target="_blank" class="btn btn-primary">
              <i class="fa fa-file-pdf-o"></i> 
            PDF
          </a-->
          
          <?php if($CI->permissions('purchase_return_add')) { ?>
            <!--a href="<?php echo $base_url; ?>purchase_return/add/<?php echo  $purchase_id ?>" class="btn btn-danger">
            <i class="fa  fa-undo"></i> Hoàn trả NCC
          </a-->
          <?php } ?>
       
          
          
        </div>
      </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <div class="pay_now_modal"></div>
  <!-- /.content-wrapper -->
  <?php include"footer.php"; ?>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>
<script>
    function save_payment(purchase_id){
  //var base_url=$("#base_url").val();

    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


   //Validate Input box or selection box should not be blank or empty
    check_field("amount");
    check_field("payment_date");


    var payment_date=$("#payment_date").val().trim();
    var amount=$("#amount").val().trim();//tiền thanh toán
    var payment_type=$("#payment_type").val().trim();
    var payment_note=$("#payment_note").val().trim();
    
    var getPoint = Math.floor(amount / 1000);

    if(amount == 0){
      toastr["error"]("Số tiền nhập vào không hợp lệ!");
      return false; 
    }

    var longdeptrai = $("#due_amount_temp")[0].getAttribute('data-due_amount_temp');
    //if(amount > parseFloat($("#due_amount_temp").html().trim())){
    if(amount > parseFloat(longdeptrai.trim())){
        //console.log('AAAA ' + parseFloat($("#due_amount_temp").html().trim()));
      toastr["error"]("Số tiền nhập vào không được lớn hơn nợ!");
      return false;
    }

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $(".payment_save").attr('disabled',true);  //Enable Save or Update button
    $.post('<?= base_url();?>purchase/save_payment', {purchase_id: purchase_id,payment_type:payment_type,amount:amount,payment_date:payment_date,payment_note:payment_note}, function(result) {
      result=result.trim();
  //alert(result);return;
        if(result=="success")
        {
          $('#pay_now').modal('toggle');
          toastr["success"]("Hoàn thành!");
          success.currentTime = 0; 
          success.play();
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed")
        {
           toastr["error"]("Sorry! Failed to save Record.Try again!");
           failed.currentTime = 0; 
           failed.play();
        }
        else
        {
          toastr["error"](result);
          failed.currentTime = 0; 
          failed.play();
        }
        $(".payment_save").attr('disabled',false);  //Enable Save or Update button
        $(".overlay").remove();
    });
}
</script>
<script>
    function pay_now(purchase_id){
      $.post('<?= base_url();?>purchase/show_pay_now_modal', {purchase_id: purchase_id}, function(result) {
        $(".pay_now_modal").html('').html(result);
        //Date picker
        $('.datepicker').datepicker({
          autoclose: true,
        format: 'dd-mm-yyyy',
         todayHighlight: true
        });
        $('#pay_now').modal('toggle');
    
      });
    }
</script>


<!-- Make sidebar menu hughlighter/selector -->
<script>$(".purchase-list-active-li").addClass("active");</script>

</body>
</html>
