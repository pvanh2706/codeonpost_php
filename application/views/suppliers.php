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
 
  <?php
	
	if(!isset($supplier_name)){
    $supplier_name=$mobile=$phone=$email=$country_id=$state_id=$city=
    $postcode=$address=$supplier_code=$gstin=$pan=$state_code=
    $company_name=$company_mobile=$tax_number=$country_id=$state_id=$opening_balance='';
	}
 ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Quản lý Nhà cung cấp</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li><a href="<?php echo $base_url; ?>suppliers">Thống kê Nhà cung cấp</a></li>
        <li class="active"><?=$page_title;?></li>
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
          <div class="box box-info ">
           

            <!-- form start -->
              <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'suppliers-form', 'enctype'=>'multipart/form-data', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>

              
                <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="supplier_name" class="col-sm-4 control-label">Tên Nhà cung cấp <label class="text-danger">*</label></label>
        
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder=""  value="<?php print $supplier_name; ?>" autofocus>
                                    <span id="supplier_name_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                          
        
                        
                            
                          
                            
                          
                            <input type="hidden" id="email" name="email" value="">
                            <input type="hidden" id="phone" name="phone" value="">
                            <input type="hidden" id="gstin" name="gstin" value="">
                            <input type="hidden" id="tax_number" name="tax_number" value="">
                            <input type="hidden" id="opening_balance" name="opening_balance" value="">
                            <input type="hidden" id="city" name="city" value="">
                            <input type="hidden" id="postcode" name="postcode" value="">
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="mobile" class="col-sm-4 control-label">Điện thoại liên hệ</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="" value="<?php print $mobile; ?>" >
                                    <span id="mobile_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">Địa chỉ NCC</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?php print $address; ?>" >
                                    <span id="address_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <?php
                                    if($supplier_name!=""){
                                         $btn_name="Cập nhật";
                                         $btn_id="update";
                                         ?>
                                 <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                                 <?php
                                    }
                                              else{
                                                  $btn_name="Lưu";
                                                  $btn_id="save";
                                              }
                                    
                                              ?>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Đóng</button>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->

            <?= form_close(); ?>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
        <!--div class="col-md-12">
         
                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title text-blue"><?= $this->lang->line('opening_balance_payments'); ?></h3>
                      </div>
                      <div class="box-body table-responsive no-padding">
                        
                        <table class="table table-bordered table-hover " id="report-data" >
                          <thead>
                          <tr class="bg-gray">
                            <th style="">#</th>
                            <th style=""><?= $this->lang->line('payment_date'); ?></th>
                            <th style=""><?= $this->lang->line('payment'); ?></th>
                            <th style=""><?= $this->lang->line('payment_type'); ?></th>
                            <th style=""><?= $this->lang->line('payment_note'); ?></th>
                            <th style=""><?= $this->lang->line('action'); ?></th>
                          </tr>
                          </thead>
                          <tbody>
                              <?php 
                                if(isset($q_id)){
                                  //sop - Supplier Opening Balance
                                  $q3 = $this->db->query("select * from db_sobpayments where supplier_id=$q_id");
                                  if($q3->num_rows()>0){
                                    $i=1;
                                    $total_paid = 0;
                                    foreach ($q3->result() as $res3) {
                                      $total_paid +=$res3->payment;
                                      echo "<td>".$i."</td>";
                                      echo "<td>".show_date($res3->payment_date)."</td>";
                                      echo "<td class='text-right'>".$CI->currency($res3->payment)."</td>";
                                      echo "<td>".$res3->payment_type."</td>";
                                      echo "<td>".$res3->payment_note."</td>";
                                      echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_opening_balance_entry('.$res3->id.')"> Delete</i></td>';
                                      echo "</tr>";
                                      $i++;
                                    }
                                    echo "<tr class='text-bold'>
                                            <td colspan=2 class='text-right '>Total</td>
                                            <td class='text-right'>".$CI->currency($total_paid)."</td>
                                            <td colspan=3></td>
                                          </tr>";
                                  }
                                  else{
                                    echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Stock Entry Found!!</td></tr>";
                                  }
                                }
                                else{
                                  echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Stock Entry Found!!</td></tr>";
                                }
                              ?>
                           </tbody>
                        </table>
                        
                        
                      </div>
                    </div>
                  </div-->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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

<script src="<?php echo $theme_link; ?>js/suppliers.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
