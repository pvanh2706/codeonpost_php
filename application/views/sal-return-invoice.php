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
    
    
    <?php
    $CI =& get_instance();
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

    
    $q3=$this->db->query("SELECT b.sales_id,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,a.city,
                           a.postcode,a.address,b.return_date,b.created_time,b.reference_no,
                           b.return_code,b.return_status,b.return_note,
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
                           b.payment_status,b.pos

                           FROM db_customers a,
                           db_salesreturn b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$return_id' 
                           ");
                        
    // Debug: Kiểm tra số lượng kết quả từ bảng db_salesreturn
    echo "<div class='alert alert-info'>Debug: SQL Query executed for return_id = $return_id</div>";
    echo "<div class='alert alert-info'>Debug: Number of rows found = " . $q3->num_rows() . "</div>";
    
    if($q3->num_rows() == 0) {
        echo "<div class='alert alert-danger'>Lỗi: Không tìm thấy dữ liệu đơn trả hàng với ID: $return_id</div>";
        echo "<div class='alert alert-warning'>Gợi ý: Kiểm tra xem ID $return_id có tồn tại trong bảng db_salesreturn không?</div>";
        return;
    }
    
    $res3=$q3->row();
    $sales_id=$res3->sales_id;
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_city=$res3->city;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $return_date=$res3->return_date;
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $return_code=$res3->return_code;
    $return_status=$res3->return_status;
    $return_note=$res3->return_note;

    
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
    $pos=$res3->pos;
    
    if(!empty($customer_country)){
      $customer_country = $this->db->query("select country from db_country where id='$customer_country'")->row()->country;  
    }
    if(!empty($customer_state)){
      $customer_state = $this->db->query("select state from db_states where id='$customer_state'")->row()->state;  
    }
    
    $sales_code = (!empty($sales_id))?$this->db->query("select sales_code from db_sales where id=".$sales_id)->row()->sales_code:'';
    ?>

    <section class="content-header">
      <h1>
        Hóa đơn hoàn trả
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li>Hóa đơn hoàn trả</li>
        <li class="active"><?php echo  $return_code; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content-header">
    <div class="row">
      <div class="col-md-12">
      <!-- ********** ALERT MESSAGE START******* -->
                 
            <?php if($this->session->flashdata('error')!=''){ ?>
                <div class="alert alert-danger text-left">
                 <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><?= $this->session->flashdata('error') ?></strong>
              </div> 
               <?php
              }
              else{ ?>
                <div class="alert alert-success text-left">
                 <!--a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a-->
                <strong>
                  <?php 
                   if(!empty($this->session->flashdata('success'))){ 
                    echo $this->session->flashdata('success')."<br>";
                   }
                   if(!empty($sales_id)){ 
                    echo "<i class='fa fa-fw fa-hand-o-right'></i>Hoàn trả theo mục nhập bán hàng [Thay thế Mã hóa đơn số ".$this->db->select('sales_code')->where('id',$sales_id)->get('db_sales')->row()->sales_code.'].';
                    //echo "<br>";
                   } 
                   else{
                    echo '<i class="fa fa-fw fa-hand-o-right"></i>Direct Return Invoice.';
                   }
                   ?>
                  </strong>
              </div>
              <?php } ?>
            <!-- ********** ALERT MESSAGE END******* -->
     </div>
    </div>
    </section>
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="printableArea">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> HÓA ĐƠN HOÀN TRẢ
            <small class="pull-right">Ngày lập: <?php echo  show_date($return_date)." ".$created_time; ?></small>
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
          <i>KHÁCH HÀNG<br></i>
          <address>
            <strong><?php echo  $customer_name . " | " . $customer_mobile; ?> </strong><br>
            <?php 
              //if(!empty($customer_address)){
                echo ($customer_address != '') ? $customer_address : 'Khách hàng là thượng đế nha!';
              //}
              if(!empty($customer_country)){
                //echo ' ' .$customer_country;
              }
              if(!empty($customer_city)){
                //echo ",".$customer_city;
              }
              if(!empty($customer_state)){
                //echo ",".$customer_state;
              }
              
              if(!empty($customer_postcode)){
                //echo "-".$customer_postcode;
              }
            ?>
            <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <i>HỆ THỐNG<br></i>
            <b>Mã đơn hoàn trả: <span style="color: blue;">#<?php echo  $return_code; ?> | <?= ($sales_code) ? $sales_code : 'N/A' ?></span></b><br>
          <?php
                switch ($return_status) {
                    case 'return':
                        $stts = 'Đơn hoàn trả';
                        break;
                    default:
                        $stts = 'Đang xử lý';
                } ?>
          <b>Tham chiếu: <span style="color: blue;"><?php echo  $reference_no; ?></span></b><br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped records_table table-bordered">
            <thead class="bg-gray-active">
            <tr>
              <th>#</th>
              <th>Mặt hàng</th>
              <th>Đơn giá</th>
              <th>Số lượng</th>
              <th>Chiết khấu</th>
              <th>Tạm tính</th>
              <th class="<?=tax_disable_class()?>"><?= $this->lang->line('tax'); ?></th>
              <th class="<?=tax_disable_class()?>"><?= $this->lang->line('tax_amount'); ?></th>
              <!--th>Chiết khấu</th-->
              <!--th><?= $this->lang->line('discount_amount'); ?></th>
              <th><?= $this->lang->line('unit_cost'); ?></th>
              <th><?= $this->lang->line('total_amount'); ?></th-->
            </tr>
            </thead>
            <tbody>

              <?php
              $i=0;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_total_cost=0;

              $q2=$this->db->query("SELECT c.item_name, a.return_qty,a.tax_type,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost 
                                  FROM 
                                  db_salesitemsreturn AS a,db_tax AS b,db_items AS c 
                                  WHERE 
                                  c.id=a.item_id AND b.id=a.tax_id AND a.return_id='$return_id'");
              
              // Debug: Kiểm tra số lượng kết quả
              $num_rows = $q2->num_rows();
              echo "<div class='alert alert-info'>Debug: Found $num_rows return items for return_id = $return_id</div>";
              
              if($num_rows == 0) {
                  echo "<tr><td colspan='8' class='text-center text-danger'>Không có dữ liệu sản phẩm trả hàng. Return ID: $return_id</td></tr>";
                  echo "<div class='alert alert-warning'>Gợi ý: Kiểm tra xem có dữ liệu trong bảng db_salesitemsreturn với return_id = $return_id không?</div>";
              }
              
              foreach ($q2->result() as $res2) {
                  $str = ($res2->tax_type=='Inclusive')? 'Inc.' : 'Exc.';
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '-':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '-':$res2->discount_amt."";
                  echo "<tr>";  
                  echo "<td>".++$i."</td>";
                  echo "<td>".$res2->item_name."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format($res2->price_per_unit))."</td>";
                  echo "<td class='text-center'>".number_format($res2->return_qty)."</td>";
                  echo "<td class='text-right'>".$discount."</td>";
                  echo "<td class='text-right'>".$CI->currency(number_format(($res2->price_per_unit * $res2->return_qty)))."</td>";
                  
                  echo "<td class='".tax_disable_class()."'>".$res2->tax."%<br>".$res2->tax_name."[".$str."]</td>";
                  echo "<td class='text-right ".tax_disable_class()."'>".$CI->currency($res2->tax_amt)."</td>";
                  
                  //echo "<td class='text-right'>".$CI->currency($discount_amt)."</td>";
                  //echo "<td class='text-right'>".$CI->currency(number_format($res2->unit_total_cost,0,'.',''))."</td>";
                  //echo "<td class='text-right'>".$CI->currency(number_format($res2->total_cost,0,'.',''))."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->return_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_total_cost +=$res2->total_cost;
              }
              ?>
         
      
            </tbody>
            <tfoot class="text-right text-bold bg-gray">
              <tr>
                <td colspan="2" class="text-center"><?= $this->lang->line('total'); ?></td>
                <td class="text-right"><?= $CI->currency(number_format($tot_sales_price)) ;?></td>
                <td class="text-center"><?=number_format($tot_qty);?></td>
                <td class="text-right"><?= $CI->currency(number_format($tot_discount_amt)) ;?></td>
                <td class="text-right"><?= $CI->currency(number_format($tot_total_cost)) ;?></td>
                <td class="<?=tax_disable_class()?>">-</td>
                <td class="text-right <?=tax_disable_class()?>"><?= $CI->currency(number_format($tot_tax_amt,2,'.',''));?></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <hr>
      <div class="row">
       <div class="col-md-6">
           <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="discount_to_all_input" class="col-sm-4 control-label" style="font-size: 17px;">Tổng chiết khấu</label>    
                    <div class="col-sm-8">
                       <!--label class="control-label  " style="font-size: 17px;">: <?=$discount_to_all_input; ?> (<?= $discount_to_all_type ?>)</label-->
                       <label class="control-label  " style="font-size: 17px;">: <?=($discount_to_all_input) ? $discount_to_all_input : 'Không áp dụng'; ?></label>
                    </div>
                 </div>
              </div>
           </div>
          <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <label for="return_note" class="col-sm-4 control-label" style="font-size: 17px;">Ghi chú hoàn trả</label>    
                    <div class="col-sm-8">
                       <label class="control-label  " style="font-size: 17px;">: <?=($return_note) ? $return_note : 'Không có ghi chú kèm theo';?></label>
                    </div>
                 </div>
              </div>
           </div> 
           <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                    <table class="table table-hover table-bordered" style="width:100%" id=""><h4 class="box-title text-info">Thông tin thanh toán : </h4>
                       <thead>
                          <tr class="bg-purple " >
                             <th>#</th>
                             <th>Thời gian</th>
                             <th>Hình thức thanh toán</th>
                             <th>Ghi chú thanh toán</th>
                             <th>Số tiền thanh toán</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php 
                            if(isset($return_id)){
                              $q3 = $this->db->query("select * from db_salespaymentsreturn where return_id=$return_id");
                              if($q3->num_rows()>0){
                                $i=1;
                                $total_paid = 0;
                                foreach ($q3->result() as $res3) {
                                  echo "<tr class='text-center text-bold' id='payment_row_".$res3->id."'>";
                                  echo "<td>".$i++."</td>";
                                  echo "<td>".show_date($res3->payment_date)."</td>";
                                  echo "<td>".$res3->payment_type."</td>";
                                  echo "<td>".$res3->payment_note."</td>";
                                  echo "<td class='text-right'>".$CI->currency(number_format($res3->payment))."</td>";
                                  echo "</tr>";
                                  $total_paid +=$res3->payment;
                                }
                                echo "<tr class='text-right text-bold'><td colspan='4' >Tổng thanh toán</td><td>".$CI->currency(number_format($total_paid))."</td></tr>";
                              }
                              else{
                                echo "<tr><td colspan='5' class='text-center text-bold'>Không có dữ liệu thanh toán!!</td></tr>";
                              }

                            }
                            else{
                              echo "<tr><td colspan='5' class='text-center text-bold'>Dữ liệu thanh toán chưa khởi tạo!!</td></tr>";
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
                             <h4><b id="round_off_amt" name="tot_round_off_amt"><?=$round_off;?></b></h4>
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
      <!--div class="row no-print">
        <div class="col-xs-12">
          <?php if($CI->permissions('sales_edit')) { ?>
          <?php $str2= ($pos==1)? 'pos/edit/':'sales_return/edit/'; ?>
          <a href="<?php echo $base_url; ?><?=$str2;?><?php echo  $return_id ?>" class="btn btn-success">
            <i class="fa  fa-edit"></i> Edit
          </a>
        <?php } ?>


          <a href="<?php echo $base_url; ?>sales_return/print_invoice/<?php echo  $return_id ?>" target="_blank" class="btn btn-warning">
            <i class="fa fa-print"></i> 
          Print
        </a>

        


        <a href="<?php echo $base_url; ?>sales_return/pdf/<?php echo  $return_id ?>" target="_blank" class="btn btn-primary">
            <i class="fa fa-file-pdf-o"></i> 
          PDF
        </a>
        
       
          
          
        </div>
      </div-->

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
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

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".sales-return-list-active-li").addClass("active");</script>
</body>
</html>
