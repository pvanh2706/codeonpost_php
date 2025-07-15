<!DOCTYPE html>
<html>

<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
<style type="text/css">
 table.table-bordered > thead > tr > th {
 /* border:1px solid black;*/
 text-align: center;
 }
 .table > tbody > tr > td, 
 .table > tbody > tr > th, 
 .table > tfoot > tr > td, 
 .table > tfoot > tr > th, 
 .table > thead > tr > td, 
 .table > thead > tr > th 
 {
 padding-left: 2px;
 padding-right: 2px;  
 }
 
 /* Style cho ô tìm kiếm */
 #item_search {
   font-size: 16px;
   padding: 10px;
   border: 2px solid #ddd;
   border-radius: 5px;
 }
 
 #item_search:focus {
   border-color: #3c8dbc;
   box-shadow: 0 0 5px rgba(60, 141, 188, 0.5);
 }
 
 /* Style cho autocomplete loading */
 .ui-autocomplete-loader-center {
   background-image: url('<?= base_url(); ?>theme/images/loading.gif');
   background-repeat: no-repeat;
   background-position: center right;
   background-size: 20px 20px;
 }
 
 /* Style cho bảng sản phẩm */
 #sales_table {
   margin-top: 15px;
 }
 
 .pointer {
   cursor: pointer;
 }
 
 .text-center {
   text-align: center;
 }
 
 .text-right {
   text-align: right;
 }
</style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 
 <?php include"sidebar.php"; ?>
 
 <?php
    $sales_code=$customer_name='';
    if($oper=='return_against_sales'){
         //NEW
          $return_id='';
          $q2 = $this->db->query("select * from db_sales where id=$sales_id");
          $customer_id=$q2->row()->customer_id;
          $return_date=show_date(date("d-m-Y"));
          $sales_code=$q2->row()->sales_code;
          $return_status=$q2->row()->sales_status;
          $warehouse_id=$q2->row()->warehouse_id;
          $reference_no='';
          $discount_input=$q2->row()->discount_to_all_input;
          $discount_type=$q2->row()->discount_to_all_type;
          $other_charges_input=$q2->row()->other_charges_input;
          $other_charges_tax_id=$q2->row()->other_charges_tax_id;
          $return_note='';

          $items_count = $this->db->query("select count(*) as items_count from db_salesitems where sales_id=$sales_id")->row()->items_count;
          $save_operation = true;
    }
    if($oper=='edit_existing_return'){
      //EDIT
          $q2 = $this->db->query("select * from db_salesreturn where id=$return_id");
          $sales_id=$q2->row()->sales_id;
          $customer_id=$q2->row()->customer_id;
          $return_date=show_date(date("d-m-Y"));
          $return_status=$q2->row()->return_status;
          $return_code=$q2->row()->return_code;
          $warehouse_id=$q2->row()->warehouse_id;
          $reference_no=$q2->row()->reference_no;
          $discount_input=$q2->row()->discount_to_all_input;
          $discount_type=$q2->row()->discount_to_all_type;
          $other_charges_input=$q2->row()->other_charges_input;
          $other_charges_tax_id=$q2->row()->other_charges_tax_id;
          $return_note=$q2->row()->return_note;

          $items_count = $this->db->query("select count(*) as items_count from db_salesitemsreturn where return_id=$return_id")->row()->items_count;
          $sales_code = (!empty($sales_id)) ? $this->db->query("select * from db_sales where id=$sales_id")->row()->sales_code : '';
          $save_operation = false;
    }
    if($oper=='create_new_return'){
      //NEW
          $customer_id  = $return_date = $return_status = $warehouse_id =
          $reference_no  =
          $other_charges_input          = $other_charges_tax_id =
          $discount_input = $discount_type  = $return_note='';
          $return_date=show_date(date("d-m-Y"));
          $save_operation = true;
    }

    if(!empty($customer_id)){
      $customer_name=$this->db->select('customer_name')->where('id',$customer_id)->get('db_customers')->row()->customer_name;
      $customer_mobile=$this->db->select('mobile')->where('id',$customer_id)->get('db_customers')->row()->mobile;
    }
 
    
    ?>

 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_pos_sales_item.php"; ?>
    <!-- **********************MODALS END***************** -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
         <h1>
            Trả hàng
            <small>Sản phẩm hoàn trả</small>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="<?php echo $base_url; ?>sales_return">Thống kê trả hàng</a></li>
            <li><a href="<?php echo $base_url; ?>sales_return/create">Trả hàng</a></li>
            <li class="active"><?= $sales_code;?></li>
         </ol>
      </section>

    <!-- Main content -->
     <section class="content">
               <div class="row">
                <!-- ********** ALERT MESSAGE START******* -->
               <?php include"comman/code_flashdata.php"; ?>
               <!-- ********** ALERT MESSAGE END******* -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info " >
                        <!-- style="background: #68deac;" -->
                        
                        <!-- form start -->
                         <!-- OK START -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'sales-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">
                           <?php if(!empty($sales_id)) { ?>
                           <input type="hidden" id="sales_id" name="sales_id" value="<?= $sales_id; ?>">
                           <?php } ?>
                           <?php if(!empty($return_id)) { ?>
                           <input type="hidden" id="return_id" name="return_id" value="<?= $return_id; ?>">
                           <?php } ?>

                          
                           <div class="box-body">

                                <div class="form-group">
                                    
                                
                                
                                
                                
                                </div>

                                <div class="form-group">
                                    <?php if(!empty($return_code)) { ?>
                                        <label for="" class="col-sm-2 control-label"><?= $this->lang->line('invoice'); ?><label class="text-danger">*</label> </label>
                                        <label class="col-sm-3 control-label" style="text-align: left;">#<?= $return_code;?></label>
                                    <?php } ?>
    
                                    <?php if(empty($customer_id)) {?>
                                        <label for="customer_id" class="col-sm-2 control-label">Khách hàng <label class="text-danger">*</label></label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;"></select>
                                                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                                </div>
                                                <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                    <?php } ?>

                              

                                    <label for="return_date" class="col-sm-2 control-label">Ngày lập <label class="text-danger">*</label></label>
                                    <div class="col-sm-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right datepicker"  id="return_date" name="return_date" readonly onkeyup="shift_cursor(event,'return_status')" value="<?= $return_date;?>">
                                        </div>
                                        <span id="return_date_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                    
                                    <?php if(!empty($sales_code)) { ?>
                                        <label for="" class="col-sm-2 control-label">Mã hóa đơn <label class="text-danger">*</label> </label>
                                        <label class="col-sm-3 control-label" style="text-align: left;"><?= $sales_code;?></label>
                                    <?php } ?>
                                </div>

                              
                              <div class="form-group">
                                 <label for="return_status" class="col-sm-2 control-label">Trạng thái <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                       <select class="form-control select2" id="return_status" name="return_status"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                                          <!-- <option value="">-Select-</option> -->
                                          <?php 
                                               $return_select = ($return_status=='Return') ? 'selected' : ''; 
                                               $cancel_select = ($return_status=='Cancel') ? 'selected' : ''; 
                                          ?>
                                            <option <?= $return_select; ?> value="Return">Hoàn trả</option>
                                            <!--option <?= $cancel_select; ?> value="Cancel">Hủy đơn hàng</option-->
                                       </select>
                                    <span id="return_status_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                    <!--label for="reference_no" class="col-sm-2 control-label"><?= $this->lang->line('reference_no'); ?> </label>
                                    <div class="col-sm-3">
                                        <input type="text" value="<?php echo  $reference_no; ?>" class="form-control " id="reference_no" name="reference_no" placeholder="" >
                                    <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                    </div-->
                                 <input type="hidden" id="reference_no" name="reference_no" value="none"/>
                                 <?php if(!empty($customer_name)) { ?>
                                    <label for="" class="col-sm-2 control-label">Khách hàng <label class="text-danger">*</label> </label>
                                    <label class="col-sm-3 control-label" style="text-align: left; color: blue;"><?= $customer_name;?> | <?= $customer_mobile; ?></label>
                                    <input type="hidden" name="customer_id" id='customer_id' value="<?=$customer_id;?>">
                                <?php } ?>
                              </div>
                           </div>
                           <!-- /.box-body -->
                           
                           <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-12">
                                  <div class="box">
                                    <div class="box-info">
                                      <div class="box-header">
                                        <div class="col-md-8 col-md-offset-2 d-flex justify-content" >
                                          <div class="input-group">
                                                <span class="input-group-addon" title="Quét mã vạch hoặc tìm kiếm sản phẩm"><i class="fa fa-barcode"></i></span>
                                                 <input type="text" class="form-control " placeholder="Quét mã vạch hoặc nhập tên sản phẩm để tìm kiếm..." id="item_search" name="item_search" autocomplete="off">
                                                 <span class="input-group-addon" title="Tìm kiếm"><i class="fa fa-search"></i></span>
                                              </div>
                                        </div>
                                      </div>
                                      <div class="box-body">
                                        <div class="table-responsive" style="width: 100%">
                                        <table class="table table-hover table-bordered" style="width:100%" id="sales_table">
                                             <thead class="custom_thead">
                                                <tr class="bg-primary" >
                                                   <th rowspan='2' style="width:15%">Sản phẩm</th>
                                                   <th rowspan='2' style="width:10%;min-width: 180px;">Số lượng</th>
                                                   <th rowspan='2' style="width:10%">Đơn giá</th> 
                                                   <th rowspan='2' style="width:10%">Chiết khấu</th>
                                                   <th class="<?=tax_disable_class()?>" rowspan='2' style="width:5%"><?= $this->lang->line('tax'); ?></th>
                                                   <th class="<?=tax_disable_class()?>" rowspan='2' style="width:10%"><?= $this->lang->line('tax_amount'); ?></th>
                                                   <th rowspan='2' style="width:7.5%">Tạm tính</th>
                                                   <th rowspan='2' style="width:7.5%">Thao tác</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                               
                                             </tbody>
                                          </table>
                                      </div>
                                      </div>
                                    </div>
                                  </div>
                                  

                                </div>
                              </div>
                              
                              
                              <div class="col-md-6">
                                <!--div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="" class="col-sm-4 control-label"><?= $this->lang->line('quantity'); ?></label>    
                                          <div class="col-sm-4">
                                             <label class="control-label total_quantity text-success" style="font-size: 15pt;">0</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div-->
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="other_charges_input" class="col-sm-4 control-label">Phụ phí khác</label>    
                                          <div class="col-sm-8">
                                             <input type="text" class="form-control text-right only_currency" id="other_charges_input" name="other_charges_input" onkeyup="final_total();" value="<?php echo  $other_charges_input; ?>">
                                          </div>
                                          <!--div class="col-sm-4">
                                             <select class="form-control " id="other_charges_tax_id" name="other_charges_tax_id" onchange="final_total();" style="width: 100%;">
                                                <?php
                                                   $q1="select * from db_tax where status=1";
                                                   $q1=$this->db->query($q1);
                                                    if($q1->num_rows()>0)
                                                    {
                                                     echo "<option>None</option>";
                                                     foreach($q1->result() as $res1)
                                                      {
                                                        $selected=($other_charges_tax_id==$res1->id) ? 'selected' : '';
                                                        echo "<option $selected data-tax='".$res1->tax."' value='".$res1->id."'>".$res1->tax_name."</option>";
                                                      }
                                                    }
                                                    else
                                                    {
                                                       ?>
                                                <option value="">No Records Found</option>
                                                <?php
                                                   }
                                                   ?>
                                             </select>
                                          </div-->
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="discount_to_all_input" class="col-sm-4 control-label">Chiết khấu</label>    
                                          <div class="col-sm-4">
                                             <input type="text" class="form-control  text-right only_currency" id="discount_to_all_input" name="discount_to_all_input" onkeyup="enable_or_disable_item_discount();" value="<?php echo  $discount_input; ?>">
                                          </div>
                                          <div class="col-sm-4">
                                             <select class="form-control" onchange="final_total();" id='discount_to_all_type' name="discount_to_all_type">
                                                <option value='in_percentage'>Phần trăm (%)</option>
                                                <option value='in_fixed'>Cố định (₫)</option>
                                             </select>
                                          </div>
                                          <!-- Dynamicaly select Supplier name -->
                                          <script type="text/javascript">
                                             <?php if($discount_type!=''){ ?>
                                                 document.getElementById('discount_to_all_type').value='<?php echo  $discount_type; ?>';
                                             <?php }?>
                                          </script>
                                          <!-- Dynamicaly select Supplier name end-->
                                       </div>
                                    </div>
                                 </div>
                                <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="return_note" class="col-sm-4 control-label">Ghi chú đơn hàng</label>    
                                          <div class="col-sm-8">
                                             <textarea class="form-control text-left" id='return_note' name="return_note"><?= $return_note; ?></textarea>
                                            <span id="return_note_msg" style="display:none" class="text-danger"></span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 
                              </div>
                              

                              <div class="col-md-6">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                           
                                          <table  class="col-md-9">
                                              <tr>
                                                <th class="text-right" style="font-size: 17px;">Số lượng</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b class="total_quantity">0</b></h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Tổng tạm tính</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="subtotal_amt" name="subtotal_amt">0.00</b></h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Phụ phí khác</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="other_charges_amt" name="other_charges_amt">0.00</b></h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Tổng chiêt khấu</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="discount_to_all_amt" name="discount_to_all_amt">0.00</b></h4>
                                                </th>
                                             </tr>
                                             <!--tr style="<?= (!is_enabled_round_off()) ? 'display: none;' : '';?>">
                                                <th class="text-right" style="font-size: 17px;"><?= $this->lang->line('round_off'); ?>
                                                  <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="Go to Site Settings-> Site -> Disable the Round Off(Checkbox)." data-html="true" data-trigger="hover" data-original-title="" title="Do you wants to Disable Round Off ?">
                                                      <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                                    </i>
                                                </th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="round_off_amt" name="tot_round_off_amt">0.00</b></h4>
                                                </th>
                                             </tr-->
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Tổng thanh toán</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="total_amt" name="total_amt">0.00</b></h4>
                                                </th>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-xs-12 ">
                                 <div class="col-sm-12">
                                       <div class="box-body ">
                                        <div class="col-md-12">
                                          <table class="table table-hover table-bordered" style="width:100%" id="payments_table"><h4 class="box-title text-info">Thông tin hoàn tiền </h4>
                                             <thead>
                                                <tr class="bg-gray " >
                                                   <th>#</th>
                                                   <th>Thời gian</th>
                                                   <th>Phân loại</th>
                                                   <th>Ghi chú</th>
                                                   <th>Số tiền</th>
                                                   <th>Thao tác</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php 
                                                  if(!empty($return_id)){
                                                    $q3 = $this->db->query("select * from db_salespaymentsreturn where return_id=$return_id");
                                                    if($q3->num_rows()>0){
                                                      $i=1;
                                                      $total_paid = 0;
                                                      foreach ($q3->result() as $res3) {
                                                        echo "<tr class='text-center text-bold' id='payment_row_".$res3->id."'>";
                                                        echo "<td>".$i."</td>";
                                                        echo "<td>".show_date($res3->payment_date)."</td>";
                                                        echo "<td>".$res3->payment_type."</td>";
                                                        echo "<td>".$res3->payment_note."</td>";
                                                        echo "<td class='text-right' id='paid_amt_$i'>".$res3->payment."</td>";
                                                        echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_payment('.$res3->id.')"> Delete</i></td>';
                                                        echo "</tr>";
                                                        $total_paid +=$res3->payment;
                                                        $i++;
                                                      }
                                                      echo "<tr class='text-right text-bold'><td colspan='4' >Total</td><td data-rowcount='$i' id='paid_amt_tot'>".number_format($total_paid,2,'.','')."</td><td></td></tr>";
                                                    }
                                                    else{
                                                      echo "<tr><td colspan='6' class='text-center text-bold'>Chưa có dữ liệu thanh toán!!</td></tr>";
                                                    }

                                                  }
                                                  else{
                                                    echo "<tr><td colspan='6' class='text-center text-bold'>Dữ liệu thanh toán chưa khởi tạo!!</td></tr>";
                                                  }
                                                ?>
                                             </tbody>
                                          </table>
                                        </div>
                                       </div>
                                       <!-- /.box-body -->
                                    </div>
                                 <!-- /.box -->
                              </div>

                              <div class="col-xs-12 ">
                                 <div class="col-sm-12">
                                       <div class="box-body ">

                                          <div class="col-md-12 payments_div payments_div_">
                                          <div class="box box-solid bg-gray">
                                            <div class="box-body">
                                              <div class="row">
                                         
                                                <div class="col-md-6">
                                                  <div class="">
                                                  <label for="amount">Số tiền thanh toán sau khi đã trừ hoàn trả</label>
                                                    <input type="text" class="form-control text-right paid_amt only_currency" id="amount" name="amount" placeholder="" >
                                                      <span id="amount_msg" style="display:none" class="text-danger"></span>
                                                </div>
                                               </div>
                                                <div class="col-md-6">
                                                  <div class="">
                                                    <label for="payment_type">Hình thức hoàn tiền</label>
                                                    <select class="form-control select2" id='payment_type' name="payment_type">
                                                      <?php
                                                        $q1=$this->db->query("select * from db_paymenttypes where status=1");
                                                         if($q1->num_rows()>0){
                                                             foreach($q1->result() as $res1){
                                                             echo "<option value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                                                           }
                                                         }
                                                         else{
                                                            echo "<option>None</option>";
                                                         }
                                                        ?>
                                                    </select>
                                                    <span id="payment_type_msg" style="display:none" class="text-danger"></span>
                                                  </div>
                                                </div>
                                            <div class="clearfix"></div>
                                        </div>  
                                        <div class="row">
                                               <div class="col-md-12">
                                                  <div class="">
                                                    <label for="payment_note">Ghi chú hoàn tiền</label>
                                                    <textarea type="text" class="form-control" id="payment_note" name="payment_note" placeholder="" ></textarea>
                                                    <span id="payment_note_msg" style="display:none" class="text-danger"></span>
                                                  </div>
                                               </div>
                                                
                                            <div class="clearfix"></div>
                                        </div>   
                                        </div>
                                        </div>
                                        </div><!-- col-md-12 -->
                                       </div>
                                       <!-- /.box-body -->
                                    </div>
                                 <!-- /.box -->
                              </div>

                           </div>
                           
                           <!-- /.box-body -->
                           <div class="box-footer col-sm-12">
                              <center>
                                <?php

                                if($oper=='return_against_sales'){
                                  $btn_id='save';
                                  $btn_name="Lưu";
                                  echo '<input type="hidden" name="sales_id" id="sales_id" value="'.$sales_id.'"/>';
                                }
                                if($oper=='edit_existing_return'){
                                  $btn_id='update';
                                  $btn_name="Cập nhật";
                                  echo '<input type="hidden" name="return_id" id="return_id" value="'.$return_id.'"/>';
                                  echo '<input type="hidden" name="sales_id" id="sales_id" value="'.$sales_id.'"/>';
                                }
                                if($oper=='create_new_return'){
                                  $btn_id='create';
                                  $btn_name="Tạo mới";
                                }

                                /*if(isset($sales_id)){
                                  $btn_id='update';
                                  $btn_name="Cập nhật";
                                  echo '<input type="hidden" name="sales_id" id="sales_id" value="'.$sales_id.'"/>';
                                }
                                else{
                                  $btn_id='save';
                                  $btn_name="Lưu";
                                }*/

                                ?>
                                 
                                 <?php if($oper=='edit_existing_return') { ?>
                                 <!-- Nút in hóa đơn chỉ hiển thị khi chỉnh sửa đơn trả hàng -->
                                 <div class="col-md-2">
                                    <button type="button" onclick="print_return_invoice(<?= $return_id; ?>)" class="btn btn-warning btn-block btn-flat btn-lg" title="In hóa đơn trả hàng (Ctrl+P)">
                                       <i class="fa fa-print"></i> In hóa đơn
                                    </button>
                                 </div>
                                 <div class="col-md-2">
                                    <button type="button" onclick="print_return_invoice_pos(<?= $return_id; ?>)" class="btn btn-info btn-block btn-flat btn-lg" title="In hóa đơn POS (Ctrl+Shift+P)">
                                       <i class="fa fa-print"></i> In POS
                                    </button>
                                 </div>
                                 <div class="col-md-2">
                                    <button type="button" onclick="export_return_pdf(<?= $return_id; ?>)" class="btn btn-primary btn-block btn-flat btn-lg" title="Xuất PDF (Ctrl+D)">
                                       <i class="fa fa-file-pdf-o"></i> PDF
                                    </button>
                                 </div>
                                 <div class="col-md-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class="btn bg-maroon btn-block btn-flat btn-lg payments_modal" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn bg-gray btn-block btn-flat btn-lg" title="Go Dashboard">Đóng</button>
                                  </a>
                                </div>
                                 <?php } else { ?>
                                 <!-- Layout cũ cho các trường hợp khác -->
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class="btn bg-maroon btn-block btn-flat btn-lg payments_modal" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn bg-gray btn-block btn-flat btn-lg" title="Go Dashboard">Đóng</button>
                                  </a>
                                </div>
                                 <?php } ?>
                              </center>
                           </div>
                           

                           <?= form_close(); ?>
                           <!-- OK END -->
                     </div>
                  </div>
                  <!-- /.box-footer -->
                 
               </div>
               <!-- /.box -->
             </section>
            <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/modals.js"></script>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

      <script src="<?php echo $theme_link; ?>js/sales-return.js"></script>  
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  
      <script>
         //Customer Selection Box Search
         function load_customer_select2(){
            var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";
            
            if(customer_id != ""){
               //If has customer id in customer_id variable
               //Then don't load the customer select2
               return false;
            }
            //Load customer select2
            return true;
         }
         function getCustomerSelectionId() {
           return '#customer_id';
         }

         $(document).ready(function () {

            var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";
            
            autoLoadFirstCustomer(customer_id);
            
            // Phím tắt in hóa đơn
            $(document).keydown(function(e) {
              <?php if($oper=='edit_existing_return') { ?>
              // Ctrl + P: In hóa đơn A4
              if (e.ctrlKey && e.keyCode == 80) {
                e.preventDefault();
                print_return_invoice(<?= $return_id; ?>);
                return false;
              }
              
              // Ctrl + Shift + P: In hóa đơn POS
              if (e.ctrlKey && e.shiftKey && e.keyCode == 80) {
                e.preventDefault();
                print_return_invoice_pos(<?= $return_id; ?>);
                return false;
              }
              
              // Ctrl + D: Xuất PDF
              if (e.ctrlKey && e.keyCode == 68) {
                e.preventDefault();
                export_return_pdf(<?= $return_id; ?>);
                return false;
              }
              <?php } ?>
            });

         });
         //Customer Selection Box Search - END

         function save_operation() {
            <?php if($save_operation){ ?>
               return true;
            <?php }else{ ?>
               return false;
            <?php } ?>
         }
         $(".close_btn").on("click",function(){
           if(confirm('Are you sure you want to navigate away from this page?')){
               window.location='<?php echo $base_url; ?>dashboard';
             }
         });
         //Initialize Select2 Elements
             $(".select2").select2();
         //Date picker
             $('.datepicker').datepicker({
               autoclose: true,
            format: 'dd-mm-yyyy',
              todayHighlight: true
             });
          
        /*if($("#warehouse_id").val().trim()==''){
          $("#item_search").attr({
            disabled: true,
          });
          toastr["warning"]("Please Select Warehouse!!");
          failed.currentTime = 0; 
          failed.play();
         
        }*/
         
         /* ---------- CALCULATE TAX -------------*/
         function calculate_tax(i){ //i=Row
            set_tax_value(i);

           //Find the Tax type and Tax amount
           var tax_type = $("#tr_tax_type_"+i).val();
           var tax_amount = parseAmount($("#td_data_"+i+"_11").val());

           var qty=$("#td_data_"+i+"_3").val().trim();
           var sales_price = parseAmount($("#td_data_"+i+"_10").val());
           $("#td_data_"+i+"_4").val(sales_price);
           /*Discounr*/
           var discount_amt = parseAmount($("#td_data_"+i+"_8").val());

           var amt=parseFloat(qty) * sales_price;//Taxable

           var total_amt=amt-discount_amt;
           total_amt = (tax_type=='Inclusive') ? total_amt : parseFloat(total_amt) + parseFloat(tax_amount);
           
           //Set Unit cost - format tiền tệ
           $("#td_data_"+i+"_9").val(formatCurrency(total_amt));
        
           final_total();
         }
         /* ---------- CALCULATE GST END -------------*/

        
         /* ---------- Final Description of amount ------------*/
         function final_total(){
           var rowcount=$("#hidden_rowcount").val();
           var subtotal=parseFloat(0);
           
           var other_charges_per_amt=parseFloat(0);
           var other_charges_total_amt=0;
           var taxable=0;
          if($("#other_charges_input").val()!=null && $("#other_charges_input").val()!=''){
             
              other_charges_tax_id =$('option:selected', '#other_charges_tax_id').attr('data-tax');
             var other_charges_input = parseAmount($("#other_charges_input").val());
             if(other_charges_tax_id>0){

               other_charges_per_amt=(other_charges_tax_id * other_charges_input)/100;
             }
             
             taxable=parseFloat(other_charges_per_amt)+parseFloat(other_charges_input);//Other charges input
             other_charges_total_amt=parseFloat(other_charges_per_amt)+parseFloat(other_charges_input);
           }
           else{
             //$("#other_charges_amt").html('0.00');
           }
           
         
           var tax_amt=0;
           var actual_taxable=0;
           var total_quantity=0;
         
           for(i=1;i<=rowcount;i++){
         
             if(document.getElementById("td_data_"+i+"_3")){
               //customer_id must exist
               if($("#td_data_"+i+"_3").val()!=null && $("#td_data_"+i+"_3").val()!=''){
                    var unit_cost = parseAmount($("#td_data_"+i+"_13").val());
                    var total_cost = parseAmount($("#td_data_"+i+"_9").val());
                    var tax_amt_item = parseAmount($("#td_data_"+i+"_7").val());
                    
                    actual_taxable=actual_taxable + (unit_cost * parseFloat($("#td_data_"+i+"_3").val()));
                    subtotal=subtotal + total_cost;
                    if(tax_amt_item >= 0){
                      tax_amt=tax_amt + tax_amt_item;
                    }   
                    total_quantity +=parseInt($("#td_data_"+i+"_3").val().trim());
                }
                   
             }//if end
           }//for end
           
          
          //Show total Sales Quantitys
           $(".total_quantity").html(total_quantity);

           //Apply Output on screen
           //subtotal
           if((subtotal!=null || subtotal!='') && (subtotal!=0)){
             
             //subtotal
             $("#subtotal_amt").html(formatCurrency(subtotal));
             
             //other charges total amount
             $("#other_charges_amt").html(formatCurrency(other_charges_total_amt));
             
             //other charges total amount
            

             taxable=taxable+subtotal;
             
             //discount_to_all_amt
            // if($("#discount_to_all_input").val()!=null && $("#discount_to_all_input").val()!=''){
                 var discount_input = parseAmount($("#discount_to_all_input").val());
                 var discount=0;
                 if(discount_input>0){
                     var discount_type=$("#discount_to_all_type").val();
                     if(discount_type=='in_fixed'){
                       taxable-=discount_input;
                       discount=discount_input;
                       //Minus
                     }
                     else if(discount_type=='in_percentage'){
                         discount=(taxable*discount_input)/100;
                        taxable-=discount;
             
                     }
                 }
                 else{
                    //discount += $("#")
                 }
                   
                    $("#discount_to_all_amt").html(formatCurrency(discount));  
                    $("#hidden_discount_to_all_amt").val(discount);  
             //}
             //subtotal_round=Math.round(taxable);
             subtotal_round=round_off(taxable);//round_off() method custom defined
             subtotal_diff=subtotal_round-taxable;
         
             $("#round_off_amt").html(formatCurrency(subtotal_diff)); 
             $("#total_amt").html(formatCurrency(subtotal_round)); 
             if(save_operation()){
               $("#amount").val(formatCurrency(subtotal_round));
             }
             $("#hidden_total_amt").val(subtotal_round); 
           }
           else{
             $("#subtotal_amt").html(formatCurrency(0)); 
             
             $("#tax_amt").html('0.00'); 
             $("#amount").val('0.00');  
           }
           
          // adjust_payments();
          //alert("final_total() end");
         }
         /* ---------- Final Description of amount end ------------*/
          
         function removerow(id){//id=Rowid
           
         $("#row_"+id).remove();
         final_total();
         failed.currentTime = 0;
        failed.play();
         }
               
     

    function enable_or_disable_item_discount(){
      /*var discount_input=parseFloat($("#discount_to_all_input").val());
      discount_input = isNaN(discount_input) ? 0 : discount_input;
      if(discount_input>0){
        $(".item_discount").attr({
          'readonly': true,
          'style': 'border-color:red;cursor:no-drop',
        });
      }
      else{
        $(".item_discount").attr({
          'readonly': false,
          'style': '',
        });
      }*/

      var rowcount=$("#hidden_rowcount").val();
      for(k=1;k<=rowcount;k++){
       if(document.getElementById("tr_item_id_"+k)){
         calculate_tax(k);
       }//if end
     }//for end

      //final_total();
    }


    //Sale Items Modal Operations Start
    function show_sales_item_modal(row_id){
      $('#sales_item').modal('toggle');
      $("#popup_tax_id").select2();

      //Find the item details
      var item_name = $("#td_data_"+row_id+"_1").html();
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax_id = $("#tr_tax_id_"+row_id).val();
      var description = $("#description_"+row_id).val();

      /*Discount*/
      var item_discount_input = $("#item_discount_input_"+row_id).val();
      var item_discount_type = $("#item_discount_type_"+row_id).val();

      //Set to Popup
      $("#item_discount_input").val(item_discount_input);
      $("#item_discount_type").val(item_discount_type).select2();

      $("#popup_item_name").html(item_name);
      $("#popup_tax_type").val(tax_type).select2();
      $("#popup_tax_id").val(tax_id).select2();
      $("#popup_description").val(description);
      $("#popup_row_id").val(row_id);
    }

    function set_info(){
      var row_id = $("#popup_row_id").val();
      var tax_type = $("#popup_tax_type").val();
      var tax_id = $("#popup_tax_id").val();
      var description = $("#popup_description").val();
      var tax_name = ($('option:selected', "#popup_tax_id").attr('data-tax-value'));
      var tax = parseFloat($('option:selected', "#popup_tax_id").attr('data-tax'));

      /*Discounr*/
      var item_discount_input = $("#item_discount_input").val();
      var item_discount_type = $("#item_discount_type").val();

      //Set it into row 
      $("#item_discount_input_"+row_id).val(item_discount_input);
      $("#item_discount_type_"+row_id).val(item_discount_type);

      $("#tr_tax_type_"+row_id).val(tax_type);
      $("#tr_tax_id_"+row_id).val(tax_id);
      $("#tr_tax_value_"+row_id).val(tax);//%
      $("#description_"+row_id).val(description);
      $("#td_data_"+row_id+"_12").html(tax_name);
      
      calculate_tax(row_id);
      $('#sales_item').modal('toggle');
    }
    function set_tax_value(row_id){
      //get the sales price of the item
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax = $("#tr_tax_value_"+row_id).val(); //%
      var qty=$("#td_data_"+row_id+"_3").val();
          qty = (isNaN(qty)) ? 0 :qty;
      // Parse số tiền từ input đã format
      var sales_price = parseAmount($("#td_data_"+row_id+"_10").val());
          sales_price = sales_price * qty;

      /*Discount*/
      var item_discount_type = $("#item_discount_type_"+row_id).val();
      var item_discount_input = parseFloat($("#item_discount_input_"+row_id).val());
          item_discount_input = (isNaN(item_discount_input)) ? 0 :item_discount_input;

      //Calculate discount      
      var discount_amt=(item_discount_type=='Percentage') ? ((sales_price) * item_discount_input)/100 : (item_discount_input * qty);
      sales_price-=parseFloat(discount_amt);

      var tax_amount = (tax_type=='Inclusive') ? calculate_inclusive(sales_price,tax) : calculate_exclusive(sales_price,tax);
      
      $("#td_data_"+row_id+"_8").val(formatNumber(discount_amt));

      $("#td_data_"+row_id+"_11").val(formatNumber(tax_amount));

    }
    //Sale Items Modal Operations End

    // Hàm format input tiền tệ khi nhập
    $(document).on('input', '#amount', function() {
      var value = $(this).val().replace(/[^0-9]/g, '');
      if (value) {
        var formatted = new Intl.NumberFormat('vi-VN').format(value);
        $(this).val(formatted);
      }
    });
    
    // Hàm format các input có class only_currency
    $(document).on('input', '.only_currency', function() {
      var value = $(this).val().replace(/[^0-9]/g, '');
      if (value) {
        var formatted = new Intl.NumberFormat('vi-VN').format(value);
        $(this).val(formatted);
      }
    });

    // Hàm chuyển đổi string có format tiền tệ thành số
    function parseAmount(value) {
      if (typeof value === 'string') {
        return parseFloat(value.replace(/[^\d]/g, '')) || 0;
      }
      return parseFloat(value) || 0;
    }
    
    // Hàm format tiền tệ theo chuẩn Việt Nam
    function formatCurrency(amount) {
      if (isNaN(amount) || amount === null || amount === undefined) {
        return '0';
      }
      
      // Chuyển về số và làm tròn
      var num = parseFloat(amount);
      
      // Format theo chuẩn Việt Nam (dấu . phân cách hàng nghìn)
      return num.toLocaleString('vi-VN', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      });
    }
    
    // Hàm format số (không có ký hiệu tiền tệ)
    function formatNumber(amount) {
      if (isNaN(amount) || amount === null || amount === undefined) {
        return '0';
      }
      
      // Chuyển về số
      var num = parseFloat(amount);
      
      // Format theo chuẩn Việt Nam (dấu . phân cách hàng nghìn)
      return num.toLocaleString('vi-VN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }
    
    // Hàm làm tròn (tương thích với cấu hình hệ thống)
    function round_off(input = 0) {
      <?php if(function_exists('is_enabled_round_off') && is_enabled_round_off()){ ?>
        return Math.round(input);
      <?php } else { ?>
        return input;
      <?php } ?>
    }
    
    // Hàm bật/tắt chiết khấu item
    function enable_or_disable_item_discount(){
      var discount_to_all_input = $("#discount_to_all_input").val();
      if(discount_to_all_input != '' && discount_to_all_input != 0){
        $(".item_discount").attr("readonly", true);
        $(".item_discount").val(0);
      } else {
        $(".item_discount").attr("readonly", false);
      }
      final_total();
    }

      // Hàm in hóa đơn trả hàng A4
      function print_return_invoice(return_id) {
        if (!return_id) {
          toastr["error"]("Không tìm thấy ID đơn trả hàng!");
          return;
        }
        
        var base_url = $("#base_url").val();
        var print_url = base_url + "sales_return/print_invoice/" + return_id;
        
        window.open(print_url, "_blank", "scrollbars=1,resizable=1,height=600,width=800");
      }
      
      // Hàm in hóa đơn POS
      function print_return_invoice_pos(return_id) {
        if (!return_id) {
          toastr["error"]("Không tìm thấy ID đơn trả hàng!");
          return;
        }
        
        var base_url = $("#base_url").val();
        var print_url = base_url + "sales_return/print_invoice_pos/" + return_id;
        
        window.open(print_url, "_blank", "scrollbars=1,resizable=1,height=500,width=400");
      }
      
      // Hàm xuất PDF
      function export_return_pdf(return_id) {
        if (!return_id) {
          toastr["error"]("Không tìm thấy ID đơn trả hàng!");
          return;
        }
        
        var base_url = $("#base_url").val();
        var pdf_url = base_url + "sales_return/pdf/" + return_id;
        
        window.open(pdf_url, "_blank");
      }

      </script>


      <!-- Return against sales Entry -->
      <script type="text/javascript">
        <?php if($oper=='return_against_sales') { ?>
          $(document).ready(function(){
                var base_url='<?= base_url();?>';
                var sales_id='<?= $sales_id;?>';
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $.post(base_url+"sales_return/sales_list/"+sales_id,{},function(result){
                  //alert(result);
                  $('#sales_table tbody').append(result);
                  $("#hidden_rowcount").val(parseInt(<?=$items_count;?>)+1);
                  success.currentTime = 0;
                  success.play();
                  enable_or_disable_item_discount();
                  $(".overlay").remove();
              }); 
             });
        <?php } ?>
      </script>
      <!-- EDIT OPERATIONS -->
      <script type="text/javascript">
         <?php if($oper=='edit_existing_return') { ?> 
             $(document).ready(function(){
                var base_url='<?= base_url();?>';
                var return_id='<?= $return_id;?>';
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $.post(base_url+"sales_return/return_sales_list/"+return_id,{},function(result){
                  //alert(result);
                  $('#sales_table tbody').append(result);
                  $("#hidden_rowcount").val(parseInt(<?=$items_count;?>)+1);
                  success.currentTime = 0;
                  success.play();
                  enable_or_disable_item_discount();
                  $(".overlay").remove();
              }); 
             });
         <?php }?>
      </script>
      <!-- UPDATE OPERATIONS end-->

      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
