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
</style>

</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 
 <?php include"sidebar.php"; ?>
 
 <?php
    if(!isset($sales_id)){
      $customer_id  = $sales_date = $sales_status = $warehouse_id =
      $reference_no  = $customer_address =
      $other_charges_input          = $other_charges_tax_id =
      $discount_type  = $sales_note = '';
      $sales_date=show_date(date("d-m-Y h:m:s"));
      $discount_input = $this->db->select("sales_discount")->get('db_sitesettings')->row()->sales_discount;
      $discount_input = ($discount_input==0) ? '' : $discount_input;
      $save_operation = true;
      
    }
    else{
      $q2 = $this->db->query("select * from db_sales where id=$sales_id");
      $customer_id=$q2->row()->customer_id;
      $sales_date=show_date($q2->row()->sales_date);
      $sales_status=$q2->row()->sales_status;
      $warehouse_id=$q2->row()->warehouse_id;
      $reference_no=$q2->row()->reference_no;
      $discount_input=$q2->row()->discount_to_all_input;
      $discount_type=$q2->row()->discount_to_all_type;
      $other_charges_input=$q2->row()->other_charges_input;
      $other_charges_tax_id=$q2->row()->other_charges_tax_id;
      $sales_note=$q2->row()->sales_note;

      $items_count = $this->db->query("select count(*) as items_count from db_salesitems where sales_id=$sales_id")->row()->items_count;
      $save_operation = false;
      
      $customer_address = getCustomerAddress($customer_id);
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
            <?=$page_title;?>
            <span style="" id="cusLV" data-lv="-1">Đang chọn chính sách giá cho Khách lẻ</span>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="<?php echo $base_url; ?>sales"><?= $this->lang->line('sales_list'); ?></a></li>
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
                     <div class="box box-info " >
                        <!-- style="background: #68deac;" -->
                        
                        <!-- form start -->
                         <!-- OK START -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'sales-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">
                            
                          
                           <div class="box-body">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <label for="customer_id" class="col-md-4 control-label hidden-xs">Khách hàng<label class="text-danger">*</label></label>
                                         <div class="col-md-8">
                                            <div class="input-group">
                                               <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')"></select>
                                               <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                            </div>
                                            <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                         </div>
                                       </div>
                                        
                                   </div>
                                   <div class="col-md-6">
                                       <div class="form-group">
                                        <label for="sales_date" class="col-md-4 control-label hidden-xs">Ngày bán hàng <label class="text-danger">*</label></label>
                                         <div class="col-md-8">
                                            <div class="input-group date">
                                               <div class="input-group-addon">
                                                  <i class="fa fa-calendar"></i>
                                               </div>
                                               <input type="text" class="form-control pull-right datepicker"  id="sales_date" name="sales_date" readonly onkeyup="shift_cursor(event,'sales_status')" value="<?= $sales_date;?>">
                                            </div>
                                            <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                                         </div>
                                         </div>
                                   </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sales_status" class="col-md-4 control-label hidden-xs">Trạng thái <label class="text-danger">*</label></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" id="sales_status" name="sales_status"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                                                  <?php 
                                                       $received_select = ($sales_status=='Final') ? 'selected' : ''; 
                                                       $pending_select = ($sales_status=='Quotation') ? 'selected' : '';
                                                       $shipping_select = ($sales_status=='Shipping') ? 'selected' : '';
                                                  ?>
                                                    <option <?= $pending_select; ?> value="Quotation">Gửi báo giá - Soạn hàng</option>
                                                    <?php if ($sales_status=='Quotation') { ?> <option <?= $shipping_select; ?> value="Shipping">Đã xuất kho - Đang giao hàng</option> <?php }?>
                                                    <option <?= $received_select; ?> value="Final">Hoàn thành</option>
                                                    
                                                </select>
                                                <span id="sales_status_msg" style="display:none" class="text-danger"></span>
                                                <script>
                                                    $("#sales_status").change(function(){
                                                        var $option = $(this).find('option:selected');
                                                        var value = $option.val();
                                                        //var text = $option.text();
                                                        if (value == 'Quotation') {
                                                            //$("#amount").attr('readonly', 'readonly');
                                                            $("#amount").val('0');
                                                        } else {
                                                            $("#amount").removeAttr("readonly");
                                                        }
                                                        //console.log(value);
                                                        
                                                        });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="reference_no" value="">
                                        <div class="form-group">
                                            <label for="reference_no" class="col-md-4 control-label hidden-xs">Địa chỉ khách hàng</label>
                                            <div class="col-md-8">
                                                <input readonly type="text" value="" class="form-control " id="KHaddress" name="" placeholder="Địa chỉ khách hàng" data-address="<?php echo $customer_address; ?>">
                                                <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                        </div>
                                             <script>
                                                $(document).ready(function(){
                                                     $('#KHaddress').click(function(){
                                                         if ($(this).val() != '') {
                                                             navigator.clipboard.writeText($(this).val());
                                                            alert ('Đã copy địa chỉ: ' + $(this).val());
                                                         } 
                                                         
                                                     });
                                                });
                                             
                                             
                                             </script>
                                   </div>
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="priceLevel" class="col-md-4 control-label hidden-xs">Chính sách giá <label class="text-danger">*</label></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="priceLevel" name="priceLevel" data-priceLevel="-1"  style="width: 100%;" >
                                                    <option value="-1">Giá bán lẻ niêm yết</option>
                                                    <option value="0">Giá Đại lý cấp 0</option>
                                                    <option value="1">Giá Đại lý cấp 1</option>
                                                    <option value="2">Giá Đại lý cấp 2</option>
                                                    <option value="3">Giá Đại lý cấp 3</option>
                                                </select>
                                                <script>
                                                $("#priceLevel").change(function(){
                                                    var $option = $(this).find('option:selected');
                                                    var value = $option.val();
                                                    //$("#priceLevel").attr("data-priceLevel") = value;
                                                    var text = $option.text();
                                                       switch (value) {
                                                           case '0':
                                                               level = 'Đại lý Cấp 0';
                                                               break;
                                                            case '1':
                                                                level = 'Đại lý Cấp 1';
                                                                break;
                                                            case '2':
                                                                level = 'Đại lý Cấp 2';
                                                                break;
                                                            case '3':
                                                                level = 'Đại lý Cấp 3';
                                                                break;
                                                            default:
                                                                level = 'Khách lẻ';
                                                                
                                                       }
                                                       $("#cusLV").attr('data-lv', value);
                                                       $("#cusLV").html('Đang chọn chính sách giá cho ' + level);
                                                       
                                                       var checkRowCount = $("tr.itemsrows").length;
                                                       console.log('Testsssssssssss' + checkRowCount);
                                                        if (checkRowCount > 0){
                                                            if (confirm("Bạn vừa chọn chính sách giá " + get_price_level_name(value) + " cho sản phẩm! Xác nhận thay đổi giá các sản phẩm trong giỏ hàng qua chính sách giá " + get_price_level_name(value) +"?") == true){
                                                                
                                                                for (var i=0; i<checkRowCount; i++) {
                                                                    var A = i;
                                                                    var Dr = $("tr.itemsrows")[A].getAttribute('data-row');
                                                                    var Di = $("tr.itemsrows")[A].getAttribute('data-item-id');
                                                                    if (Di != -1){
                                                                        change_price_row_level(value, Dr, Di);
                                                                    }
                                                                    
                                                                    
                                                                }
                                                                
                                                            } 
                                                        } 
                                                    
                                                    });
                                                    
                                                function change_price_row_level(lvs, datarow, itemid){
                                                            $.ajax({
                                                                type: "GET",
                                                                url: "<?= $base_url?>items/getitemprice/"+itemid+"/"+lvs,
                                                                dataType: "json"
                                                            }).done(function(result){
                                                                var prlvs = result[0].itemprice;
                                                                console.log('Result: '+ datarow + ' | ' + result[0].itemprice);
                                                                $("#td_data_"+datarow+"_10").val(prlvs);
                                                                //$("#td_data_"+datarow+"_9").val(prlvs * $("#td_data_"+datarow+"_3").val());
                                                                calculate_tax(datarow);
                                                                
                                                            })
                                                            //adjust_payments();
                                                            //calculate_payments();
                                                }
                                                
                                                function get_price_level_name(level){
                                                    var levelname = '';
                                                    switch (level) {
                                                        case '0':
                                                           levelname = 'Đại lý cấp 0'; break; 
                                                          case '1':
                                                              levelname = 'Đại lý cấp 1'; break; 
                                                              case '2':
                                                                  levelname = 'Đại lý cấp 2'; break; 
                                                                  case '3':
                                                                      levelname = 'Đại lý cấp 3'; break; 
                                                                      default:
                                                                        levelname = 'Khách lẻ';
                                                    }
                                                    return levelname;
                                                }
                                                    
                                            </script>
                                                <span id="priceLevel_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                        </div>
                                   </div>
                              <!--div class="form-group">
                                 <label for="customer_id" class="col-sm-2 control-label">Khách hàng<label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group">
                                       <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')"></select>
                                       <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                    </div>
                                    <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 <label for="sales_date" class="col-sm-2 control-label">Ngày bán hàng <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control pull-right datepicker"  id="sales_date" name="sales_date" readonly onkeyup="shift_cursor(event,'sales_status')" value="<?= $sales_date;?>">
                                    </div>
                                    <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div-->
                              <!--div class="form-group">
                                 <label for="sales_status" class="col-sm-2 control-label">Trạng thái <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                       <select class="form-control select2" id="sales_status" name="sales_status"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                                          <?php 
                                               $received_select = ($sales_status=='Final') ? 'selected' : ''; 
                                               $pending_select = ($sales_status=='Quotation') ? 'selected' : '';
                                               $shipping_select = ($sales_status=='Shipping') ? 'selected' : '';
                                          ?>
                                            <option <?= $pending_select; ?> value="Quotation">Gửi báo giá - Soạn hàng</option>
                                            <?php if ($sales_status=='Quotation') { ?> <option <?= $shipping_select; ?> value="Shipping">Đã xuất kho - Đang giao hàng</option> <?php }?>
                                            <option <?= $received_select; ?> value="Final">Hoàn thành</option>
                                            
                                       </select>
                                    <span id="sales_status_msg" style="display:none" class="text-danger"></span>
                                    <script>
                                        $("#sales_status").change(function(){
                                            var $option = $(this).find('option:selected');
                                            var value = $option.val();
                                            //var text = $option.text();
                                            if (value == 'Quotation') {
                                                //$("#amount").attr('readonly', 'readonly');
                                                $("#amount").val('0');
                                            } else {
                                                $("#amount").removeAttr("readonly");
                                            }
                                            //console.log(value);
                                            
                                            });
                                    </script>
                                 </div>
                                 <input type="hidden" name="reference_no" value="">
                                 
                                 <label for="reference_no" class="col-sm-2 control-label">Địa chỉ khách hàng</label>
                                 <div class="col-sm-3">
                                    <input readonly type="text" value="" class="form-control " id="KHaddress" name="" placeholder="<?php echo $customer_address; ?>" data-address="<?php echo $customer_address; ?>">
                                    <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 
                                 <script>
                                    $(document).ready(function(){
                                         $('#KHaddress').click(function(){
                                             if ($(this).val() != '') {
                                                 navigator.clipboard.writeText($(this).val());
                                                alert ('Đã copy địa chỉ: ' + $(this).val());
                                             } 
                                             
                                         });
                                    });
                                 
                                 
                                 </script>
                                
                              </div-->
                              <div class="form-group">
                                  
                           </div>
                           
                           <?php
                                        if(isset($sales_id)){
                                          $btn_id='update';
                                          $btn_name="Cập nhật";
                                          echo '<input type="hidden" name="sales_id" id="sales_id" value="'.$sales_id.'"/>';
                                        }
                                        else{
                                          $btn_id='save';
                                          $btn_name="Lưu";
                                        }
        
                                        ?>
                           
                           
                           <!-- /.box-body -->
                           
                           <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-12">
                                  <div class="box">
                                    <div class="box-info">
                                      <div class="box-header">
                                        <div class="col-md-6 col-md-offset-1 d-flex justify-content" >
                                          <div class="input-group">
                                                <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                                 <input type="text" class="form-control " placeholder="Item name/Barcode/Itemcode (F3)" id="item_search">
                                                 
                                              </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="form-control btn btn-success" onClick="return_row_with_data(-1)">Dịch vụ thêm (F9)</span>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="form-control btn btn-success bg-maroon payments_modal" id="<?php echo $btn_id;?>"><?php echo $btn_name;?> (F1)</span>
                                        </div>
                                      </div>
                                      <div class="box-body">
                                        <div class="table-responsive" style="width: 100%">
                                        <table class="table table-hover table-bordered" style="width:100%; display: block; max-height: 450px; overflow: auto;" id="sales_table">
                                             <thead class="custom_thead">
                                                <tr class="bg-primary" >
                                                   <th rowspan='2' style="width:15%">Sản phẩm</th>
                                                   <th rowspan='2' style="width:10%;min-width: 180px;">Số lượng</th>
                                                   <th rowspan='2' style="width:10%">Đơn giá (<?= $CI->currency() ?>)</th> 
                                                   <th rowspan='2' style="width:10%">Chiết khấu (<?= $CI->currency() ?>)</th>
                                                   <th rowspan='2' style="width:10%" class="<?=tax_disable_class()?>"><?= $this->lang->line('tax_amount'); ?></th>
                                                   <th rowspan='2' style="width:5%" class="<?=tax_disable_class()?>"><?= $this->lang->line('tax'); ?></th>
                                                   <th rowspan='2' style="width:7.5%">Tạm tính (<?= $CI->currency() ?>)</th>
                                                   <th rowspan='2' style="width:7.5%">Thao tác</th>
                                                </tr>
                                             </thead>
                                             <tbody style="">
                                               
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
                                          <label for="" class="col-sm-4 control-label">Số lượng</label>    
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
                                          <div class="col-sm-4">
                                             <input onclick="this.select();" type="text" class="form-control text-right only_currency" id="other_charges_input" name="other_charges_input" onkeyup="final_total();" value="<?php echo  $other_charges_input; ?>">
                                          </div>
                                          <div class="col-sm-4">
                                             <select class="form-control " id="other_charges_tax_id" name="other_charges_tax_id" onchange="final_total();" style="width: 100%;">
                                                <?php
                                                   $q1="select * from db_tax where status=1";
                                                   $q1=$this->db->query($q1);
                                                    if($q1->num_rows()>0)
                                                    {
                                                     echo "<option>Không áp dụng thuế</option>";
                                                     foreach($q1->result() as $res1)
                                                      {
                                                        $selected=($other_charges_tax_id==$res1->id) ? 'selected' : '';
                                                        echo "<option $selected data-tax='".$res1->tax."' value='".$res1->id."'>".$res1->tax_name."</option>";
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
                                          </div>
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
                                                 <option value='in_fixed'>Cố định (₫)</option>
                                                <option value='in_percentage'>Phần trăm (%)</option>
                                                
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
                                          <label for="sales_note" class="col-sm-4 control-label">Ghi chú đơn hàng (F8)</label>    
                                          <div class="col-sm-8">
                                             <textarea class="form-control text-left" id='sales_note' name="sales_note"><?= $sales_note; ?></textarea>
                                            <span id="sales_note_msg" style="display:none" class="text-danger"></span>
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
                                                   <h4><b class="total_quantity  text-success" >0</b></h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Tổng tạm tính</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="subtotal_amt" name="subtotal_amt">0</b>₫</h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Tổng chiết khấu</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="discount_to_all_amt" name="discount_to_all_amt">0</b>₫</h4>
                                                </th>
                                             </tr>
                                             <tr>
                                                <th class="text-right" style="font-size: 17px;">Phụ phí khác</th>
                                                <th class="text-right" style="padding-left:10%;font-size: 17px;">
                                                   <h4><b id="other_charges_amt" name="other_charges_amt">0</b>₫</h4>
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
                                                   <h4><b id="total_amt" name="total_amt">0</b>₫</h4>
                                                </th>
                                             </tr>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>


<!-- Modal -->
<div class="modal fade" id="paymentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lịch sử thanh toán</h5>
        <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button-->
      </div>
      <div class="modal-body">
        
                                          <table class="table table-hover table-bordered" style="width:100%" id="payments_table">
                                             <thead>
                                                <tr class="bg-gray " >
                                                   <th>#</th>
                                                   <th>Thời gian</th>
                                                   <th>Hình thức thanh toán</th>
                                                   <th>Ghi chú</th>
                                                   <th>Thanh toán</th>
                                                   <th>#####</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php 
                                                  if(isset($sales_id)){
                                                    $q3 = $this->db->query("select * from db_salespayments where sales_id=$sales_id");
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
                                                        echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_payment('.$res3->id.')"> Xóa</i></td>';
                                                        echo "</tr>";
                                                        $total_paid +=$res3->payment;
                                                        $i++;
                                                      }
                                                      echo "<tr class='text-right text-bold'><td colspan='4' >Total</td><td data-rowcount='$i' id='paid_amt_tot'>".number_format($total_paid)."</td><td></td></tr>";
                                                    }
                                                    else{
                                                      echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Payments Found!!</td></tr>";
                                                    }

                                                  }
                                                  else{
                                                    echo "<tr><td colspan='6' class='text-center text-bold'>Dữ liệu được cập nhật!!</td></tr>";
                                                  }
                                                ?>
                                             </tbody>
                                          </table>
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div-->
    </div>
  </div>
</div>




                              <div class="col-xs-12 ">
                                 <div class="col-sm-12">
                                       <div class="box-body ">
                                        <!--div class="col-md-6">
                                          <table class="table table-hover table-bordered" style="width:100%" id="payments_table"><h4 class="box-title text-info">Lịch sử thanh toán: </h4>
                                             <thead>
                                                <tr class="bg-gray " >
                                                   <th>#</th>
                                                   <th>Thời gian</th>
                                                   <th>Hình thức thanh toán</th>
                                                   <th>Ghi chú</th>
                                                   <th>Thanh toán</th>
                                                   <th>#####</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php 
                                                  if(isset($sales_id)){
                                                    $q3 = $this->db->query("select * from db_salespayments where sales_id=$sales_id");
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
                                                        echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_payment('.$res3->id.')"> Xóa</i></td>';
                                                        echo "</tr>";
                                                        $total_paid +=$res3->payment;
                                                        $i++;
                                                      }
                                                      echo "<tr class='text-right text-bold'><td colspan='4' >Total</td><td data-rowcount='$i' id='paid_amt_tot'>".number_format($total_paid)."</td><td></td></tr>";
                                                    }
                                                    else{
                                                      echo "<tr><td colspan='6' class='text-center text-bold'>No Previous Payments Found!!</td></tr>";
                                                    }

                                                  }
                                                  else{
                                                    echo "<tr><td colspan='6' class='text-center text-bold'>Dữ liệu được cập nhật!!</td></tr>";
                                                  }
                                                ?>
                                             </tbody>
                                          </table>
                                        </div-->
                                        
                                        <div class="col-md-12 payments_div payments_div_">
                                            <h4 class="box-title text-info">Tổng cộng: </h4>
                                          <div class="box box-solid bg-gray">
                                            <div class="box-body">
                                              <div class="row">
                                         
                                                <div class="col-md-6">
                                                  <div class="">
                                                  <label for="amount">Số tiền thanh toán</label>
                                                    <input onclick="this.select();" type="text" class="form-control text-right paid_amt only_currency" id="amount" name="amount" placeholder=""  >
                                                      <span id="amount_msg" style="display:none" class="text-danger"></span>
                                                </div>
                                               </div>
                                                <div class="col-md-6">
                                                  <div class="">
                                                    <label for="payment_type">Hình thức thanh toán</label>
                                                    <select class="form-control select2" id='payment_type' name="payment_type">
                                                      <?php
                                                        $q1=$this->db->query("select * from db_paymenttypes where status=1");
                                                         if($q1->num_rows()>0){
                                                            //echo "<option value=''>- Lựa chọn -</option>";
                                                             foreach($q1->result() as $res1){
                                                             echo "<option value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                                                           }
                                                         }
                                                         else{
                                                            echo "<option>Biết chết liền!</option>";
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
                                                    <label for="payment_note">Ghi chú thanh toán</label>
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

                              <div class="col-xs-12 ">
                                 <div class="col-sm-12">
                                       <div class="box-body ">

                                          
                                       </div>
                                       <!-- /.box-body -->
                                    </div>
                                 <!-- /.box -->
                              </div>

                              <!-- SMS Sender while saving -->
                                <?php 
                                   //Change Return
                                    $send_sms_checkbox='disabled';
                                    if($CI->is_sms_enabled()){
                                      if(!isset($sales_id)){
                                        $send_sms_checkbox='checked';  
                                      }else{
                                        $send_sms_checkbox='';
                                      }
                                    }

                              ?>
                             
                              <!--div class="col-xs-12 ">
                                 <div class="col-sm-12">
                                       <div class="box-body ">
                                          <div class="col-md-12">
                                            <div class="checkbox icheck">
                                      <label>
                                        <input type="checkbox" <?=$send_sms_checkbox;?> class="form-control" id="send_sms" name="send_sms" > <label for="sales_discount" class=" control-label"><?= $this->lang->line('send_sms_to_customer'); ?>
                                          <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="If checkbox is Disabled! You need to enable it from SMS -> SMS API <br><b>Note:<i>Walk-in Customer will not receive SMS!</i></b>" data-html="true" data-trigger="hover" data-original-title="" title="Do you wants to send SMS ?">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i>
                                        </label>
                                      </label>
                                    </div>
                                        </div>
                                       </div>
                                    </div>
                              </div--> 
                           </div>
                           
                           <!-- /.box-body -->
                           <div class="box-footer col-sm-12">
                              <center>
                                <?php
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
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="" class="btn bg-maroon btn-block btn-flat btn-lg payments_modal" title="Lịch sử thanh toán" data-toggle="modal" data-target="#paymentHistoryModal">Lịch sử thanh toán</button>
                                 </div>
                                 <div class="col-sm-3" style="float: right;"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn bg-gray btn-block btn-flat btn-lg" title="Go Dashboard">Đóng</button>
                                  </a>
                                </div>
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

      <script src="<?php echo $theme_link; ?>js/sales.js?v=<?= time(); ?>"></script>  
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js?v=<?= time() ?>"></script>  
      <script>
         
         //Customer Selection Box Search
         function getCustomerSelectionId() {
           return '#customer_id';
         }

         $(document).ready(function () {

            var customer_id = "<?= (!empty($customer_id)) ? $customer_id : '';  ?>";

            autoLoadFirstCustomer(customer_id);

         });
         //Customer Selection Box Search - END

         function save_operation() {
            <?php if($save_operation){ ?>
               return true;
            <?php }else{ ?>
               return false;
            <?php } ?>
         }

         //Initialize Select2 Elements
             $(".select2").select2();
         //Date picker
             $('.datepicker').datepicker({
               autoclose: true,
            format: 'dd-mm-yyyy',
              todayHighlight: true
             });
          
      
         

        /* function update_price(row_id,item_cost){
        
          var sales_price=$("#sales_price_"+row_id).val().trim();
          if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

        
          var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

          if(sales_price<item_cost){
        
            $("#sales_price_"+row_id).parent().addClass('has-error');
          }else{
            $("#sales_price_"+row_id).parent().removeClass('has-error');
          }

          make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
        }*/

        /*function set_to_original(i,purchase_price) {
                    var sales_price=parseFloat($("#td_data_"+i+"_10").val().trim());
          if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

                    var item_price=parseFloat($("#tr_purchase_price_"+i).val().trim());

          if(sales_price<purchase_price){
            toastr["success"]("Default Price Set "+item_price);
            $("#td_data_"+i+"_10").parent().removeClass('has-error');
            $("#td_data_"+i+"_10").val(item_price);
          }
          calculate_tax(i);
        }*/

         /* ---------- CALCULATE TAX -------------*/
         function calculate_tax(i){ //i=Row
            set_tax_value(i);

           //Find the Tax type and Tax amount
           var tax_type = $("#tr_tax_type_"+i).val();
           var tax_amount = $("#td_data_"+i+"_11").val();

           var qty=$("#td_data_"+i+"_3").val().trim();
           var sales_price=parseFloat($("#td_data_"+i+"_10").val().trim());
           $("#td_data_"+i+"_4").val(sales_price);
           /*Discounr*/
           var discount_amt=$("#td_data_"+i+"_8").val().trim();
               discount_amt   =(isNaN(parseFloat(discount_amt)))    ? 0 : parseFloat(discount_amt);

           var amt=parseFloat(qty) * sales_price;//Taxable

           var total_amt=amt-discount_amt;
           total_amt = (tax_type=='Inclusive') ? total_amt : parseFloat(total_amt) + parseFloat(tax_amount);
           
           //Set Unit cost
           $("#td_data_"+i+"_9").val('').val(total_amt.toFixed(0));
        
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
             other_charges_input=$("#other_charges_input").val();
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
                    actual_taxable=actual_taxable+ + +(parseFloat($("#td_data_"+i+"_13").val()).toFixed(0) * parseFloat($("#td_data_"+i+"_3").val()));
                    subtotal=subtotal+ + +parseFloat($("#td_data_"+i+"_9").val()).toFixed(0);
                    if($("#td_data_"+i+"_7").val()>=0){
                      tax_amt=tax_amt+ + +$("#td_data_"+i+"_7").val();
                    }   
                    total_quantity +=parseFloat($("#td_data_"+i+"_3").val().trim());
                }
                   
             }//if end
           }//for end
           
          
          //Show total Sales Quantitys
           $(".total_quantity").html(total_quantity);

           //Apply Output on screen
           //subtotal
           if((subtotal!=null || subtotal!='') && (subtotal!=0)){
             
             //subtotal
             $("#subtotal_amt").html(subtotal.toFixed(0));
             
             //other charges total amount
             $("#other_charges_amt").html(parseFloat(other_charges_total_amt).toFixed(0));
             
             //other charges total amount
            

             taxable=taxable+subtotal;
             
             //discount_to_all_amt
            // if($("#discount_to_all_input").val()!=null && $("#discount_to_all_input").val()!=''){
                 var discount_input=parseFloat($("#discount_to_all_input").val());
                 discount_input = isNaN(discount_input) ? 0 : discount_input;
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
                   discount=parseFloat(discount).toFixed(0);
                   
                    $("#discount_to_all_amt").html(discount);  
                    $("#hidden_discount_to_all_amt").val(discount);  
             //}
             //subtotal_round=Math.round(taxable);
             subtotal_round=round_off(taxable);//round_off() method custom defined
             subtotal_diff=subtotal_round-taxable;
         
             $("#round_off_amt").html(parseFloat(subtotal_diff).toFixed(0)); 
             $("#total_amt").html(parseFloat(subtotal_round).toFixed(0)); 
             if(save_operation()){
               //$("#amount").val(parseFloat(subtotal_round).toFixed(0));
               $("#amount").val('0');
             }
             $("#hidden_total_amt").val(parseFloat(subtotal_round).toFixed(0)); 
           }
           else{
             $("#subtotal_amt").html('0'); 
             $("#tax_amt").html('0'); 
             $("#round_off_amt").html('0'); 
             $("#total_amt").html('0'); 
             $("#amount").val('0');
             $("#hidden_total_amt").html('0'); 
             $("#discount_to_all_amt").html('0'); 
             $("#hidden_discount_to_all_amt").html('0'); 
             $("#subtotal_amt").html('0'); 
             $("#other_charges_amt").html('0');  
             $("#amount").val('0');  
           }
           
          // adjust_payments();
          //alert("final_total() end");
         }
         /* ---------- Final Description of amount end ------------*/
          
         function removerow(id){//id=Rowid
           
         $("#row_"+id).remove();
         $("#doublerow_"+id).remove();
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
    
    function show_sales_item_modal_price(row_id){
      $('#sales_item2').modal('toggle');
      //$("#popup_tax_id").select2();

      //Find the item details
      var item_name = $("#td_data_"+row_id+"_1").html();
      //var tax_type = $("#tr_tax_type_"+row_id).val();
      //var tax_id = $("#tr_tax_id_"+row_id).val();
      //var description = $("#description_"+row_id).val();
      
      var item_pr0 = $("#row_"+row_id).attr("data-p0");
      var item_pr1 = $("#row_"+row_id).attr("data-p1");
      var item_pr2 = $("#row_"+row_id).attr("data-p2");
      var item_pr3 = $("#row_"+row_id).attr("data-p3");
      var item_pr = $("#row_"+row_id).attr("data-p");
      

      /*Discount*/
      //var item_discount_input = $("#item_discount_input_"+row_id).val();
      //var item_discount_type = $("#item_discount_type_"+row_id).val();

      //Set to Popup
      //$("#item_discount_input").val(item_discount_input);
      //$("#item_discount_type").val(item_discount_type).select2();

      $("#popup_item_name").html(item_name);
      //$("#popup_tax_type").val(tax_type).select2();
      //$("#popup_tax_id").val(tax_id).select2();
      //$("#popup_description").val(description);
      //$("#popup_row_id").val(row_id);
      
      $("#sales_item2_finalprice0").val(item_pr0+'₫');
      $("#sales_item2_finalprice1").val(item_pr1+'₫');
      $("#sales_item2_finalprice2").val(item_pr2+'₫');
      $("#sales_item2_finalprice3").val(item_pr3+'₫');
      $("#sales_item2_finalprice").val(item_pr+'₫');
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
      var qty=$("#td_data_"+row_id+"_3").val().trim();
          qty = (isNaN(qty)) ? 0 :qty;
      var sales_price = parseFloat($("#td_data_"+row_id+"_10").val());
          sales_price = (isNaN(sales_price)) ? 0 :sales_price;
          sales_price = sales_price * qty;

      /*Discount*/
      var item_discount_type = $("#item_discount_type_"+row_id).val();
      var item_discount_input = parseFloat($("#item_discount_input_"+row_id).val());
          item_discount_input = (isNaN(item_discount_input)) ? 0 :item_discount_input;

      //Calculate discount      
      var discount_amt=(item_discount_type=='Percentage') ? ((sales_price) * item_discount_input)/100 : (item_discount_input * qty);
      
      sales_price-=parseFloat(discount_amt);

      var tax_amount = (tax_type=='Inclusive') ? calculate_inclusive(sales_price,tax) : calculate_exclusive(sales_price,tax);
      
      $("#td_data_"+row_id+"_8").val(discount_amt);

      $("#td_data_"+row_id+"_11").val(tax_amount);
    }
    //Sale Items Modal Operations End

  
    function item_qty_input(i){
   
      var item_qty=$("#td_data_"+i+"_3").val();
      var available_qty=$("#tr_available_qty_"+i+"_13").val();
      /*if(parseFloat(item_qty)>parseFloat(available_qty)){
        $("#td_data_"+i+"_3").val(available_qty);
        toastr["warning"]("Oops! You have only "+available_qty+" items in Stock");
      }*/
      calculate_tax(i);
    }

      </script>


      <!-- UPDATE OPERATIONS -->
      <script type="text/javascript">
         <?php if(isset($sales_id)){ ?> 
             $(document).ready(function(){
                var base_url='<?= base_url();?>';
                var sales_id='<?= $sales_id;?>';
                $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                $.post(base_url+"sales/return_sales_list/"+sales_id,{},function(result){
                  //alert(result);
                  $('#sales_table tbody').append(result);
                  $("#hidden_rowcount").val(parseFloat(<?=$items_count;?>)+1);
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
      
      <style>
          .input-selected { user-select: all; }
      </style>
      
        <script>
            var util = { };
            document.addEventListener('keydown', function(e){
            
                var key = util.key[e.which];
                if( key ){
                    e.preventDefault();
                }
            
                switch (key) {
                    case 'F1': $(".payments_modal").click(); break;
                    case 'F3': $("#item_search").focus(); break;
                    case 'F9': return_row_with_data(-1); break;
                    case 'F8': $("#sales_note").focus(); break;
                }
            })
    
            util.key = { 
              112: "F1",
              113: "F2",
              114: "F3",
              115: "F4",
              116: "F5",
              117: "F6",
              118: "F7",
              119: "F8",
              120: "F9",
              121: "F10",
              122: "F11",
              123: "F12"
            }

        </script>
</body>
</html>
