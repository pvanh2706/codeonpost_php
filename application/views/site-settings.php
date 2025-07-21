<!DOCTYPE html>
<html>
   
   <head>
  <!-- TABLES CSS CODE -->
  <?php include"comman/code_css_form.php"; ?>
  <!-- </copy> -->  
  <script>
      varpinpos = "<?= get_site_settings_config('pos_pass_price') ?>";
  </script>
  </head>

   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <h1>
                  <?= $this->lang->line('site_settings'); ?>
                  <small><?= $this->lang->line('add_or_update'); ?> <?= $this->lang->line('site_settings'); ?></small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Site Settings</li>
               </ol>
            </section>
            
            <!-- Main content -->
  <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'site-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
            <section class="content">
               <div class="row">
                  <!-- ********** ALERT MESSAGE START******* -->
                <?php include"comman/code_flashdata.php"; ?>
                  <!-- ********** ALERT MESSAGE END******* -->

                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab">Bán hàng POS</a></li>
                           <li><a href="#tab_2" data-toggle="tab">Cài đặt chung</a></li>
                           <li><a href="#tab_3" data-toggle="tab">Dữ liệu hệ thống</a></li>
                           
                        </ul>
                        <div class="tab-content">
                            
                           <div class="tab-pane" id="tab_2">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                       <div class="box-body">
                                          <div class="row">
                                             <div class="col-md-5">
                                                <input type="hidden" value="<?php print $site_name; ?>" id="site_name" name="site_name" >
                                                <!--div class="form-group">
                                                   <label for="site_name" class="col-sm-4 control-label">Tên POS<label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="site_name" name="site_name" placeholder="" onkeyup="shift_cursor(event,'mobile')" value="<?php print $site_name; ?>" >
                                                      <span id="site_name_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div-->
                                                <div class="form-group">
                                                   <label for="timezone" class="col-sm-4 control-label">Múi giờ hiện tại<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="timezone" name="timezone"  style="width: 100%;">
                                                         <?php
                                                            $query2="select * from db_timezone where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 if((isset($timezone) && !empty($timezone)) && trim($timezone)==trim($res1->timezone)){$selected='selected';}else{$selected='';}
                                                                 echo "<option ".$selected." value='".$res1->timezone."'>".$res1->timezone."</option>";
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
                                                      <span id="timezone_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="date_format" class="col-sm-4 control-label">Định dạng ngày tháng<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="date_format" name="date_format"  style="width: 100%;">
                                                         <option value="dd-mm-yyyy">dd-mm-yyyy</option>
                                                         <option value="mm/dd/yyyy">mm/dd/yyyy</option>
                                                      </select>
                                                      <span id="date_format_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="time_format" class="col-sm-4 control-label">Định dạng thời gian<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="time_format" name="time_format"  style="width: 100%;">
                                                         <option value="12">12 giờ</option>
                                                         <option value="24">24 giờ</option>
                                                      </select>
                                                      <span id="time_format_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <div class="form-group">
                                                   <label for="currency" class="col-sm-4 control-label">Định dạng tiền tệ<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="currency" name="currency"  style="width: 100%;">
                                                         <?php
                                                            $query2="select * from db_currency where status=1";
                                                            $q2=$this->db->query($query2);
                                                            if($q2->num_rows()>0)
                                                             {
                                                              
                                                              foreach($q2->result() as $res1)
                                                               {
                                                                 if((isset($currency_id) && !empty($currency_id)) && $currency_id==$res1->id){$selected='selected';}else{$selected='';}
                                                                 echo "<option ".$selected." value='".$res1->id."'>".$res1->currency_name.' '.$res1->currency_code.' ('.$res1->currency.")</option>";
                                                               }
                                                             }
                                                             else
                                                             {
                                                                ?>
                                                         <option value="">Không có dữ liệu</option>
                                                         <?php
                                                            }
                                                            ?>
                                                      </select>
                                                      <span id="currency_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                                <div class="form-group">
                                                   <label for="number_to_words" class="col-sm-4 control-label">Định dạng chữ số<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="number_to_words" name="number_to_words"  style="width: 100%;">
                                                         <option value="Default">Mặc định</option>
                                                      </select>
                                                      <span id="number_to_words_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>

                                      
                                             


                                                <div class="form-group">
                                                   <label for="currency_placement" class="col-sm-4 control-label">Ví trí ký hiệu tiền tệ<label class="text-danger">*</label> </label>
                                                   <div class="col-sm-8">
                                                      <select class="form-control select2" id="currency_placement" name="currency_placement"  style="width: 100%;">
                                                         <option value="Right">Bên phải dãy số</option>
                                                         <option value="Left">Bên trái dãy số</option>
                                                      </select>
                                                      <span id="currency_placement_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                                <input type="hidden" value="17" id="language_id" name="language_id" >
                                                <input type="hidden" value="1" id="round_off" name="round_off" >
                                                <input type="hidden" value="1" id="disable_tax" name="disable_tax" >

                                             </div>
                                             <div class="col-md-5">
                                                
                                                  
                                                <!--div class="form-group">
                                                   <label for="address" class="col-sm-4 control-label"><?= $this->lang->line('site_logo'); ?></label>
                                                   <div class="col-sm-8">
                                                      <input type="file" id="logo" name="logo">
                                                      <span id="logo_msg" style="display:block;" class="text-danger">Max Width/Height: 300px * 300px & Size: 300px </span>
                                                   </div>
                                                </div-->
                                            
                                                <!--div class="form-group">
                                                   <div class="col-sm-8 col-sm-offset-4">
                                                      <img class='img-responsive' style='border:3px solid #d2d6de;' src="<?php echo $base_url; ?>uploads/<?= $logo;?>">
                                                   </div>
                                                </div-->
                                             </div>
                                             <!-- ########### -->
                                          </div>
                                       </div>
                                       <!-- /.box-body -->
                                       <!-- /.box-footer -->
                                    
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                           <?php 
                           //Change Return
                           $change_return_checkbox ='';
                           if($change_return==1){
                            $change_return_checkbox='checked';
                           }

                           //Show UPI Code
                           $show_upi_code_checkbox ='';
                           if($show_upi_code==1){
                            $show_upi_code_checkbox='checked';
                           }

                          
                            ?>
                            <div class="tab-pane active" id="tab_1">
                                <div class="row">
                                 <!-- right column -->
                                    <div class="col-md-6">
                                        <div class="box-body">
                                            <div class="row">
                                                <input type="hidden" value="1" id="change_return" name="change_return" >
                                                <input type="hidden" value="1" id="show_upi_code" name="show_upi_code" >
                                                <input type="hidden" value="1" id="sales_invoice_format_id" name="sales_invoice_format_id" >
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="sales_discount" class="col-sm-4 control-label">Tỷ lệ giảm giá toàn sàn %</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="sales_discount" name="sales_discount" placeholder="" value="<?php print $sales_discount; ?>" >
                                                            <span id="sales_discount_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="show_due" class="col-sm-4 control-label">Hiện công nợ <label class="text-danger">*</label> </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select2" id="show_due" name="show_due"  style="width: 100%;">
                                                                <option value="0">Ẩn đi</option>
                                                                <option value="1">Hiển thị</option>
                                                            </select>
                                                            <span id="show_due_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="show_invoice_barcode" class="col-sm-4 control-label">Hiện Mã vạch hóa đơn <label class="text-danger">*</label> </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select2" id="show_invoice_barcode" name="show_invoice_barcode"  style="width: 100%;">
                                                                <option value="0">Ẩn đi</option>
                                                                <option value="1">Hiển thị</option>
                                                            </select>
                                                            <span id="show_invoice_barcode_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="show_payment_qrcode" class="col-sm-4 control-label">Hiện QR code thanh toán <label class="text-danger">*</label> </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select2" id="show_payment_qrcode" name="show_payment_qrcode"  style="width: 100%;">
                                                                <option value="0">Ẩn đi</option>
                                                                <option value="1">Hiển thị</option>
                                                            </select>
                                                            <span id="show_payment_qrcode_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (get_site_settings_config('show_payment_qrcode') == 1) { ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="bank_name_qrcode" class="col-sm-4 control-label">Tên ngân hàng<label class="text-danger">*</label> </label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control select2" id="bank_name_qrcode" name="bank_name_qrcode"  style="width: 100%;" data-bbin="970436"></select>
                                                            
                                                            <script type="application/javascript">
                                                                const defaultApiKey = '88cffd04-ba98-491a-b4ed-1674db422bc1';
                                                                const defaultClientId = 'bc254f1e-c9fd-4652-b8cc-f135547cce48';
                                                    
                                                                $('#bank_name_qrcode').on('change', function (e) {
                                                                    var optionSelected = $("option:selected", this);
                                                                    var valueSelected = this.value;
                                                                    $('#bank_name_qrcode').attr("data-bbin", valueSelected);
                                                                    $("#bank_logo").attr("src", $("#bank_name_qrcode").attr("data-image"));
                                                                });
                                                                
                                                                function load_bank() {
                                                                    var url = "https://api.vietqr.io/v2/banks";
                                                                    var request;
                                                                 
                                                                    if(window.XMLHttpRequest) {
                                                                        request=new XMLHttpRequest();
                                                                    } else if(window.ActiveXObject){
                                                                        request=new ActiveXObject("Microsoft.XMLHTTP");
                                                                    }
                                                                    request.onreadystatechange  = function(){
                                                                        if (request.readyState == 4) {
                                                                            var jsonObj = JSON.parse(request.responseText);
                                                                			var select = document.getElementById('bank_name_qrcode');
                                                                			for (var i = 0; i<jsonObj.data.length; i++){
                                                                				var opt = document.createElement('option');
                                                                				opt.value = jsonObj.data[i]['bin'];
                                                                				opt.innerHTML = jsonObj.data[i]['name'] + ' (' + jsonObj.data[i]['code'] + '-' + jsonObj.data[i]['shortName'] +  ')';
                                                                				opt.setAttribute("data-image", jsonObj.data[i]['logo']);
                                                                				if (jsonObj.data[i]['bin'] == <?= $bank_name_qrcode ?>) {opt.setAttribute("selected", "selected"); $("#bank_logo").attr("src", jsonObj.data[i]['logo']) }
                                                                				select.appendChild(opt);
                                                                			}
                                                                        }
                                                                    }
                                                                    request.open("GET", url, true);
                                                                    request.send();
                                                                }
                                                                
                                                                $(document).ready(function(){
                                                                    load_bank();
                                                                });
                                                            </script>
                                                            <span id="bank_name_qrcode_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                        <div class="col-sm-2 text-center">
                                                            <img id="bank_logo" height="38px" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="bank_number_qrcode" class="col-sm-4 control-label">Tài khoản ngân hàng <label class="text-danger">*</label> </label>
                                                        <div class="col-sm-6">
                                                            <input type="number" class="form-control" id="bank_number_qrcode" name="bank_number_qrcode" placeholder="" value="<?php print $bank_number_qrcode; ?>" >
                                                            <span id="bank_number_qrcode_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <span class=" btn btn-block btn-success" onClick="findAccountName()">Kiểm tra</span>
                                                            <!--img id="bank_logo" height="50px" /-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    function findAccountName() {
                                                        var accountNumber = $('#bank_number_qrcode').val();
                                                        var bankId = $('#bank_name_qrcode').attr("data-bbin");
                                                        var xmlhttp = new XMLHttpRequest();
                                                        let params = {
                                                            accountNumber: accountNumber,
                                                            bin: bankId
                                                        }
                                                        xmlhttp.onreadystatechange = function () {
                                                            if (xmlhttp.readyState == 4) { // XMLHttpRequest.DONE == 4
                                                                if (xmlhttp.status == 200) {
                                                                    console.log(JSON.parse(xmlhttp.responseText))
                                                                    let data = JSON.parse(xmlhttp.responseText)
                                                                    if (data.code == "00") {
                                                                        document.getElementById("bank_account_qrcode").value = data.data.accountName;
                                                                        console.log(data.data.accountName);
                                                                    } else {
                                                                        document.getElementById("error").innerText = `${data.code} - ${data.desc}`;
                                                                        document.getElementById("bank_account_qrcode").value = '';
                                                                        
                                                                    }
                                                                } else if (xmlhttp.status == 400) {
                                                                    alert('Error 400');
                                                                } else {
                                                                    alert('Error 200');
                                                                }
                                                            }
                                                        };
                                                    
                                                        xmlhttp.open("POST", "https://api.vietqr.io/v2/lookup", true);
                                                        xmlhttp.setRequestHeader("Content-Type", "application/json");
                                                        xmlhttp.setRequestHeader("x-api-key", "88cffd04-ba98-491a-b4ed-1674db422bc1");
                                                        xmlhttp.setRequestHeader("x-client-id", "bc254f1e-c9fd-4652-b8cc-f135547cce48");
                                                        xmlhttp.send(JSON.stringify(params));
                                                    }
                                                    
                                                    
                                                </script>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="bank_account_qrcode" class="col-sm-4 control-label">Tên tài khoản ngân hàng <label class="text-danger">*</label> </label>
                                                        <div class="col-sm-8">
                                                            <input readonly type="text" class="form-control" id="bank_account_qrcode" name="bank_account_qrcode" placeholder="" value="<?php print $bank_account_qrcode; ?>" >
                                                            <span id="bank_account_qrcode_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="pos_pass_price" class="col-sm-4 control-label">Mã PIN tham chiếu POS</label>
                                                        <div class="col-sm-8">
                                                            <input placeholder="Bỏ trống nội dung nếu không sử dụng mật khẩu" class="form-control" id="pos_pass_price" name="pos_pass_price" value="<?= $pos_pass_price;?>">
                                                            <span id="pos_pass_price_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="sales_invoice_footer_text" class="col-sm-4 control-label">Nội dung phần chân trang hóa đơn</label>
                                                        <div class="col-sm-8">
                                                            <textarea placeholder="Bỏ trống nội dung nếu không muốn hiển thị" class="form-control" id="sales_invoice_footer_text" name="sales_invoice_footer_text"><?= $sales_invoice_footer_text;?></textarea>
                                                            <span id="sales_invoice_footer_text_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="print_ip" class="col-sm-4 control-label">Cài đặt IP máy in wifi</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="print_ip" name="print_ip" placeholder="" value="<?php print $print_ip; ?>" >
                                                            <span id="sales_discount_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="print_port" class="col-sm-4 control-label">Cài đặt Port máy in wifi</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="print_port" name="print_port" placeholder="" value="<?php print $print_port; ?>" >
                                                            <span id="sales_discount_msg" style="display:none" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div-->
                                            </div>
                                             
                                             <!--div class="col-md-8">
                                                <div class="form-group">
                                                   <label for="sales_terms_and_conditions" class="col-sm-4 control-label">Nội dung Điều khoản / Điều kiện trên hóa đơn</label>
                                                   <div class="col-sm-8">
                                                      <textarea class="form-control" id="sales_terms_and_conditions" name="sales_terms_and_conditions"><?= $sales_terms_and_conditions;?></textarea>
                                                      <span id="sales_terms_and_conditions_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div-->
                                             


                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <iframe class="col-md-8" height="600" src="<?php echo $base_url; ?>pos/print_invoice_pos/<?php print $language_id; ?>" title="description"></iframe>
                                    </div>
                                </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                           <div class="tab-pane" id="tab_3">
                             <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                       <div class="box-body">
                                          <div class="row">
                                              <input type="hidden" value="DM" id="category_init" name="category_init">
                                              <input type="hidden" value="SP" id="item_init" name="item_init">
                                              <input type="hidden" value="CC" id="supplier_init" name="supplier_init">
                                              <input type="hidden" value="NH" id="purchase_init" name="purchase_init">
                                              <input type="hidden" value="HT" id="purchase_return_init" name="purchase_return_init">
                                              <input type="hidden" value="KH" id="customer_init" name="customer_init">
                                              <input type="hidden" value="HD" id="sales_init" name="sales_init">
                                              <input type="hidden" value="LN" id="sales_return_init" name="sales_return_init">
                                              <input type="hidden" value="CP" id="expense_init" name="expense_init">
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label">Lưu ý tích điểm<label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control"  placeholder="Hệ thống tự làm tròn số điểm tích là 1 số nguyên dương." disabled >
                                                   </div>
                                                </div>
                                             </div>
                                              <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label">Hệ thống tích điểm<label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                       
                                                       <select class="form-control select2" id="point_system" name="point_system" style="width:100%;">
                                                           <option <?php echo ($point_system == 1) ? 'selected' : ''; ?> value="1">Mở tích điểm</option>
                                                           <option <?php echo ($point_system == 0) ? 'selected' : ''; ?> value="0">Đóng tích điểm</option>
                                                       </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label">Nhận tích điểm khi thanh toán tối thiểu<label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="minpaid_get_point" name="minpaid_get_point" placeholder="" value="<?php print $minpaid_get_point; ?>" >
                                                      <span id="minpaid_get_point_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label">Số điểm nhận được khi thanh toán <?php print number_format($minpaid_get_point); ?>₫<label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="point_get_per_minpaid" name="point_get_per_minpaid" placeholder="" value="<?php print $point_get_per_minpaid; ?>" >
                                                      <span id="point_get_per_minpaid_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label text-danger">Reset số điểm tất cả khách hàng</label>
                                                   <div class="col-sm-8">
                                                       <button type="button" class=" btn btn-block btn-danger" id="resetallpoint">Reset điểm tích lũy tất cả khách hàng về 0 - Không thể khôi phục! Lưu ý khi sử dụng!</button>
                                                   </div>
                                                </div>
                                             </div>
                                             <hr>
                                             <?php if($this->session->userdata('inv_userid') == '1') : ?>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label class="col-sm-4 control-label text-danger">Xóa dữ liệu cache quá thời hạn sử dụng</label>
                                                   <div class="col-sm-1">
                                                          <input class="form-control" type="checkbox" value="1" id="checkItems">
                                                          <label class="control-label" for="checkItems"> Sản phẩm</label>
                                                   </div>
                                                   <div class="col-sm-1">
                                                          <input class="form-control" type="checkbox" value="1" id="checkSales">
                                                          <label class="control-label" for="checkSales"> Bán hàng</label>
                                                   </div>
                                                   <div class="col-sm-1">
                                                        <div class="form-check">
                                                          <input class="form-control" type="checkbox" value="1" id="checkReturn">
                                                          <label class="control-label" for="checkReturn"> Nhập hàng</label>
                                                        </div>
                                                   </div>
                                                   <div class="col-sm-1">
                                                        <div class="form-check">
                                                          <input class="form-control" type="checkbox" value="1" id="checkLogs">
                                                          <label class="control-label" for="checkLogs"> Hệ thống</label>
                                                        </div>
                                                   </div>
                                                   
                                                   
                                                   <div class="col-sm-4">
                                                       <button type="button" class=" btn btn-block btn-danger" id="resetalldata">Reset dữ liệu!</button>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php endif; ?>
                                             <hr>
                                             <div class="col-md-12">
                                                <div class="form-group">
                                                   <label class="col-sm-4 control-label text-danger">Remap dữ liệu hệ thống, xóa các dữ liệu trùng lập</label>
                                                   <div class="col-sm-8">
                                                       <button type="button" class=" btn btn-block btn-success" id="remapalldata">Bắt đầu tái thiết lập dữ liệu hệ thống!</button>
                                                   </div>
                                                </div>
                                             </div>
                                             <!--div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="category_init" class="col-sm-4 control-label"><?= $this->lang->line('category'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="category_init" name="category_init" placeholder="" value="<?php print $category_init; ?>" >
                                                      <span id="category_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="item_init" class="col-sm-4 control-label"><?= $this->lang->line('item'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="item_init" name="item_init" placeholder="" value="<?php print $item_init; ?>" >
                                                      <span id="item_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="supplier_init" class="col-sm-4 control-label"><?= $this->lang->line('supplier'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="supplier_init" name="supplier_init" placeholder="" value="<?php print $supplier_init; ?>" >
                                                      <span id="supplier_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_init" name="purchase_init" placeholder="" value="<?php print $purchase_init; ?>" >
                                                      <span id="purchase_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="purchase_return_init" class="col-sm-4 control-label"><?= $this->lang->line('purchase_return'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="purchase_return_init" name="purchase_return_init" placeholder="" value="<?php print $purchase_return_init; ?>" >
                                                      <span id="purchase_return_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="customer_init" class="col-sm-4 control-label"><?= $this->lang->line('customer'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="customer_init" name="customer_init" placeholder="" value="<?php print $customer_init; ?>" >
                                                      <span id="customer_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_init" class="col-sm-4 control-label"><?= $this->lang->line('sales'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_init" name="sales_init" placeholder="" value="<?php print $sales_init; ?>" >
                                                      <span id="sales_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="sales_return_init" class="col-sm-4 control-label"><?= $this->lang->line('sales_return'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="sales_return_init" name="sales_return_init" placeholder="" value="<?php print $sales_return_init; ?>" >
                                                      <span id="sales_return_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                   <label for="expense_init" class="col-sm-4 control-label"><?= $this->lang->line('expense'); ?><label class="text-danger">*</label></label>
                                                   <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="expense_init" name="expense_init" placeholder="" value="<?php print $expense_init; ?>" >
                                                      <span id="expense_init_msg" style="display:none" class="text-danger"></span>
                                                   </div>
                                                </div>
                                             </div-->
                                          </div>
                                       </div>
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                     <div>
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                           <center>
                              <?php
                                 if($site_name!=""){
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
                                <a href="<?=base_url('dashboard');?>">
                                 <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Đóng</button>
                               </a>
                              </div>
                           </center>
                        </div>
                     </div>
                  </div>
                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
            <?= form_close(); ?>
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      
      <?php include'comman/code_js_language.php'; ?>

      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js_form.php"; ?>

      <script type="text/javascript">
         $(document).submit(function(event) {
           event.preventDefault();
           if($("#update").length){
             $("#update").trigger('click');
           }
         });
      </script>
      <script src="<?php echo $theme_link; ?>js/site-settings.js?v=<?= time(); ?>" ></script>
     
      <script type="text/javascript">
         $("#number_to_words").val('<?= $number_to_words;?>').select2();
         $("#currency_placement").val('<?= $currency_placement;?>').select2();
         $("#date_format").val('<?= $date_format;?>').select2();
         $("#time_format").val('<?= $time_format;?>').select2();
         $("#show_due").val('<?= $show_due;?>').select2();
         $("#show_invoice_barcode").val('<?= $show_invoice_barcode;?>').select2();
         $("#show_payment_qrcode").val('<?= $show_payment_qrcode;?>').select2();
         $("#bank_name_qrcode").val('<?= $bank_name_qrcode;?>').select2();
         //$("#sales_invoice_format_id").val('<?= $sales_invoice_format_id;?>').select2();
      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
