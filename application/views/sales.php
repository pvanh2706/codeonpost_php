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

/* Border styling for tax columns */
.tax-column {
    border-left: 2px solid #3c8dbc !important;
    border-right: 2px solid #3c8dbc !important;
}
.tax-percent-column {
    border-left: 2px solid #3c8dbc !important;
}
.tax-total-column {
    border-right: 2px solid #3c8dbc !important;
}
</style>

</head>

<?php
// Hàm format tiền tệ Việt Nam
function formatCurrency($amount) {
    return number_format($amount, 0, '.', '.') . '₫';
}

// Hàm format số (không có ký hiệu tiền tệ)
function formatNumber($amount) {
    return number_format($amount, 0, '.', '.');
}

// Hàm làm tròn theo cấu hình hệ thống
function round_off($amount) {
    // Lấy cấu hình làm tròn từ database
    global $CI;
    if (!isset($CI)) {
        $CI = &get_instance();
    }
    
    $round_off_to = $CI->db->select('round_off_to')->get('db_sitesettings')->row()->round_off_to;
    
    if ($round_off_to > 0) {
        return round($amount / $round_off_to) * $round_off_to;
    }
    return $amount;
}
?>

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
      $order_price_level = -1;
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
      $order_price_level=$q2->row()->order_price_level;

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
            <?//= $page_title;?>
            <span style="" id="cusLV" data-lv="-1">Áp dụng chính sách giá: Khách lẻ</span>
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
                           <input type="hidden" name="order_price_level" id="order_price_level" value="<?= $order_price_level ?>">
                           <input type="hidden" id="hidden_total_amt" name="hidden_total_amt" value="0">
                           <input type="hidden" id="hidden_discount_to_all_amt" name="hidden_discount_to_all_amt" value="0">
                           <input type="hidden" id="hidden_round_off_amt" name="hidden_round_off_amt" value="0">
                          
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
                                            <div class="col-md-8">
                                                <select class="form-control" id="priceLevel" name="priceLevel" data-priceLevel="-1"  style="width: 100%;" >
                                                    <option value="-1" <?= ($order_price_level == -1) ? 'selected' : '' ?> >Giá bán lẻ niêm yết</option>
                                                    <option value="0" <?= ($order_price_level == 0) ? 'selected' : '' ?> >Giá Đại lý cấp 0</option>
                                                    <option value="1" <?= ($order_price_level == 1) ? 'selected' : '' ?> >Giá Đại lý cấp 1</option>
                                                    <option value="2" <?= ($order_price_level == 2) ? 'selected' : '' ?> >Giá Đại lý cấp 2</option>
                                                    <option value="3" <?= ($order_price_level == 3) ? 'selected' : '' ?> >Giá Đại lý cấp 3</option>
                                                </select>
                                                <script>
                                                $( document ).ready(function() {
                                                    var $optionss = $("#priceLevel").find('option:selected');
                                                    var valuess = $optionss.val();
                                                    var textss = $optionss.text();
                                                    switch (valuess) {
                                                           case '0':
                                                               levelss = 'Đại lý Cấp 0';
                                                               break;
                                                            case '1':
                                                                levelss = 'Đại lý Cấp 1';
                                                                break;
                                                            case '2':
                                                                levelss = 'Đại lý Cấp 2';
                                                                break;
                                                            case '3':
                                                                levelss = 'Đại lý Cấp 3';
                                                               break;
                                                            default:
                                                                levelss = 'Khách lẻ';
                                                                
                                                       }
                                                    $("#cusLV").attr('data-lv', valuess);
                                                    $("#cusLV").html('Áp dụng chính sách giá: ' + levelss);
                                                });
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
                                                       $("#cusLV").html('Áp dụng chính sách giá: ' + level);
                                                       $("#order_price_level").val(value);
                                                       
                                                       var checkRowCount = $("tr.itemsrows").length;
                                                       //console.log('Testsssssssssss' + checkRowCount);
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
                                                                // Format giá khi hiển thị trong input
                                                                $("#td_data_"+datarow+"_10").val(formatNumber(prlvs));
                                                                calculate_tax(datarow);
                                                                
                                                            })
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
                                   <div class="col-md-6" style="display: none;">
                                       <div class="form-group">
                                           <label for="" class="col-md-4 control-label hidden-xs">Chính sách thuế <label class="text-danger">*</label></label>
                                           <div class="col-md-8>
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
                                   
                                   
                                   
                                   <?php
                                        if(isset($sales_id)){
                                          $btn_id='update';
                                          $btn_name="Cập nhật";
                                          echo '<input type="hidden" name="sales_id" id="sales_id" value="'.$sales_id.'"/>';
                                        }
                                        else{
                                          $btn_id='save';
                                          $btn_name="Lưu";
                                          //echo '<input type="hidden" name="sales_id_price" id="sales_id_price" value="'.$sales_id.'"/>';
                                        }
        
                                        ?>
                                   
                                    <div class="col-md-12 text-center ">
                                        <div class="form-group">
                                            <div class="col-md-6" style="float: left; width:50%;">
                                                <!--span style="width: 90%;" class="form-control btn btn-success" onClick="return_row_with_data(-1)">Dịch vụ thêm (F9)</span-->
                                                <button type="button" class="btn btn-success btn-block" title="Thêm dịch vụ" onClick="return_row_with_data(-1)">Dịch vụ thêm (F9)</button>
                                            </div>
                                            <div class="col-md-6" style="float: right; width:50%;">
                                                <!--span style="width: 90%;" class="form-control btn btn-success bg-maroon payments_modal" id="<?php echo $btn_id;?>"><?php echo $btn_name;?> (F1)</span-->
                                                <button type="button" class="btn bg-maroon payments_modal btn-block" title="<?php echo $btn_name;?>" id="<?php echo $btn_id;?>"><?php echo $btn_name;?> (F1)</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                   
                                    <div class="col-md-12 d-flex justify-content">
                                       <div class="form-group">
                                           <div class="input-group">
                                                <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                                 <input type="text" class="form-control " placeholder="Item name/Barcode/Itemcode (F3)" id="item_search">
                                                 
                                              </div>
                                       </div>
                                       
                                    </div>
                                   
                                    <div class="col-md-12 d-flex justify-content">
                                        <div class="form-group">
                                            <div class="table-responsive" style="width: 100%; border: dashed 1px;">
                                                <table class="table table-hover table-bordered" style="width:100%; display: block; max-height: 450px; overflow: auto;" id="sales_table">
                                                    <thead class="custom_thead">
                                                        <tr class="bg-primary" >
                                                           <th rowspan='2' style="width:20%">S.Phẩm</th>
                                                           <th rowspan='2' style="width:8%;min-width: 120px;">S.Lượng</th>
                                                           <th rowspan='2' style="width:10%">Đ.Giá (<?= $CI->currency() ?>)</th>
                                                           <th rowspan='2' style="width:10%">C.Khấu (<?= $CI->currency() ?>)</th>
                                                           <th rowspan='2' style="width:8%" class="tax-percent-column">Thuế (%)</th>
                                                           <th rowspan='2' style="width:10%" class="tax-column">T.Tiền thuế (<?= $CI->currency() ?>)</th>
                                                           <th rowspan='2' style="width:10%" class="tax-column">T.Trước thuế (<?= $CI->currency() ?>)</th>
                                                           <th rowspan='2' style="width:12%" class="tax-total-column">T.Sau thuế (<?= $CI->currency() ?>)</th>
                                                           <th rowspan='2' style="width:8%">T.Tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style=""></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                   </div>
                                    
                                    <div class="col-md-12 d-flex justify-content">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label for="other_charges_input" class="col-md-4 control-label">Phụ phí khác</label>    
                                              <div class="col-md-8">
                                                 <input onclick="this.select();" type="text" class="form-control text-right only_currency" id="other_charges_input" name="other_charges_input" onkeyup="final_total();" value="<?php echo formatNumber($other_charges_input); ?>">
                                              </div>
                                              
                                           </div>
                                           
                                           <div class="form-group">
                                          <label for="discount_to_all_input" class="col-md-4 control-label">Chiết khấu</label>    
                                          <div class="col-md-4">
                                             <input type="text" class="form-control  text-right only_currency" id="discount_to_all_input" name="discount_to_all_input" onkeyup="enable_or_disable_item_discount();" value="<?php echo formatNumber($discount_input); ?>">
                                          </div>
                                          <div class="col-md-4">
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
                                       
                                        <div class="form-group">
                                          <label for="sales_note" class="col-md-4 control-label">Ghi chú đơn hàng (F8)</label>    
                                          <div class="col-md-8>
                                             <textarea rows="3" class="form-control text-left" id='sales_note' name="sales_note"><?= $sales_note; ?></textarea>
                                            <span id="sales_note_msg" style="display:none" class="text-danger"></span>
                                          </div>
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Số lượng | <span class="total_quantity text-danger" >0</span></span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng tạm tính | <span class="text-danger" id="subtotal_amt" name="subtotal_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng chiết khấu | <span class="text-danger" id="discount_to_all_amt" name="discount_to_all_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng trước thuế | <span class="text-danger" id="total_before_tax_amt" name="total_before_tax_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng tiền thuế | <span class="text-danger" id="total_tax_amt" name="total_tax_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng sau thuế | <span class="text-danger" id="total_after_tax_amt" name="total_after_tax_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Phụ phí (có thuế) | <span class="text-danger" id="other_charges_amt" name="other_charges_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Làm tròn | <span class="text-danger" id="round_off_amt" name="round_off_amt">0</span> ₫</span>
                                                <span style="text-align: left; font-weight: bold;" class="form-control btn btn-file" >Tổng thanh toán | <span style="font-size:1.3em;" class="text-danger" id="total_amt" name="total_amt" >0</span> ₫</span>
                                                <!-- Công thức: Tổng thanh toán = Tổng sau thuế + Phụ phí (có thuế) - Chiết khấu + Làm tròn -->
                                                <div style="font-size: 11px; color: #666; margin-top: 5px; padding: 5px; border-top: 1px solid #ddd;">
                                                    <strong>Công thức:</strong> Tổng sau thuế + Phụ phí (có thuế) - Chiết khấu + Làm tròn
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 d-flex justify-content">
                                        <div class="box-body form-group">
                                            <div class="col-md-12 payments_div payments_div_">
                                                <div class="box box-solid bg-gray">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="amount">Số tiền thanh toán</label>
                                                                <input onclick="this.select();" type="text" class="form-control text-right paid_amt only_currency" id="amount" name="amount" placeholder=""  >
                                                                <span id="amount_msg" style="display:none" class="text-danger"></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="payment_type">Hình thức thanh toán</label>
                                                                <select style="width:100%;" class="form-control select2" id='payment_type' name="payment_type">
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
                                                            <div class="clearfix"></div>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="payment_note">Ghi chú thanh toán</label>
                                                                <textarea type="text" class="form-control" id="payment_note" name="payment_note" placeholder="" ></textarea>
                                                                <span id="payment_note_msg" style="display:none" class="text-danger"></span>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div><!-- col-md-12 -->
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
                                                                                        echo "<td class='text-right' id='paid_amt_$i'>".formatCurrency($res3->payment)."</td>";
                                                                                        echo '<td><i class="fa fa-trash text-red pointer" onclick="delete_payment('.$res3->id.')"> Xóa</i></td>';
                                                                                        echo "</tr>";
                                                                                        $total_paid +=$res3->payment;
                                                                                        $i++;
                                                                                      }
                                                                                      echo "<tr class='text-right text-bold'><td colspan='4' >Total</td><td data-rowcount='$i' id='paid_amt_tot'>".formatCurrency($total_paid)."</td><td></td></tr>";
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
                           
                           <!-- /.box-body -->
                           <div class="box-footer col-md-12">
                              <center>
                                 <div class="col-md-6" style="float: left;">
                                    <button type="button" id="" class="btn bg-olive btn-block btn-flat btn-lg" title="Lịch sử thanh toán" data-toggle="modal" data-target="#paymentHistoryModal">Lịch sử thanh toán</button>
                                 </div>
                                 <div class="col-md-6" style="float: right;"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn bg-gray-active btn-block btn-flat btn-lg" title="Go Dashboard">Đóng</button>
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
            
            // Format các input có sẵn khi load trang
            $('.only_currency').each(function() {
                var rawValue = $(this).val().replace(/[^0-9]/g, '');
                if (rawValue) {
                    $(this).val(formatNumber(rawValue));
                }
            });
            
            // Event listener cho input currency
            $(document).on('input', '.only_currency', function() {
                var rawValue = $(this).val().replace(/[^0-9]/g, '');
                if (rawValue) {
                    $(this).val(formatNumber(rawValue));
                }
            });
            
            $(document).on('blur', '.only_currency', function() {
                var rawValue = $(this).val().replace(/[^0-9]/g, '');
                if (rawValue) {
                    $(this).val(formatNumber(rawValue));
                }
            });
            
            // Thêm event listener cho việc tạo dòng mới
            $(document).on('DOMNodeInserted', '#sales_table tbody tr', function() {
                updateRowTaxColumns(this);
            });
            
            // Sửa chữa các cột thuế cho dòng hiện có sau khi trang load
            setTimeout(function() {
                fixAllTaxColumns();
                final_total();
            }, 500);

         });
         
         // Hàm chuyển đổi format tiền tệ về số
         function parseCurrency(value) {
             if (!value) return 0;
             return parseFloat(value.toString().replace(/[^0-9]/g, '')) || 0;
         }
         
         // Hàm format số thành tiền tệ VN
         function formatCurrency(amount) {
             return formatNumber(amount) + '₫';
         }
         
         // Hàm format số
         function formatNumber(amount) {
             return parseFloat(amount || 0).toLocaleString('vi-VN');
         }
         
         // Hàm cập nhật các cột thuế cho dòng mới
         function updateRowTaxColumns(row) {
             var $row = $(row);
             var rowId = $row.attr('id');
             if (!rowId || !rowId.startsWith('row_')) return;
             
             var rowNum = rowId.replace('row_', '');
             
             // Kiểm tra xem dòng đã có đủ cột thuế chưa
             if ($row.find('#td_' + rowNum + '_tax_rate').length === 0) {
                 // Tìm vị trí cột chiết khấu để thêm các cột thuế sau đó
                 var existingCells = $row.find('td');
                 
                 // Nếu có ít nhất 4 cột (sản phẩm, số lượng, đơn giá, chiết khấu)
                 if (existingCells.length >= 4) {
                     var discountCell = existingCells.eq(3); // Cột chiết khấu (index 3)
                     
                     // Thêm cột thuế % sau cột chiết khấu
                     discountCell.after('<td id="td_' + rowNum + '_tax_rate" class="text-center tax-percent-column" style="vertical-align: middle;">0%</td>');
                     
                     // Thêm cột tiền thuế
                     $('#td_' + rowNum + '_tax_rate').after('<td id="td_' + rowNum + '_tax_amount" class="text-center tax-column" style="vertical-align: middle;">0 ₫</td>');
                     
                     // Thêm cột tổng trước thuế
                     $('#td_' + rowNum + '_tax_amount').after('<td id="td_' + rowNum + '_before_tax" class="text-center tax-column" style="vertical-align: middle;">0 ₫</td>');
                     
                     // Thêm cột tổng sau thuế
                     $('#td_' + rowNum + '_before_tax').after('<td id="td_' + rowNum + '_after_tax" class="text-center tax-total-column" style="vertical-align: middle;">0 ₫</td>');
                     
                     console.log('Tax columns added for row ' + rowNum);
                 }
             }
             
             // Tính toán ngay sau khi thêm cột
             setTimeout(function() {
                 calculate_tax(rowNum);
             }, 100);
         }
         
         // Hàm kiểm tra và sửa chữa các cột thuế cho tất cả dòng
         function fixAllTaxColumns() {
             var rowcount = $('#hidden_rowcount').val();
             console.log('Fixing tax columns for ' + rowcount + ' rows');
             
             for (var i = 1; i <= rowcount; i++) {
                 if (document.getElementById('row_' + i)) {
                     var $row = $('#row_' + i);
                     
                     // Kiểm tra xem dòng đã có đủ cột thuế chưa
                     if ($row.find('#td_' + i + '_tax_rate').length === 0) {
                         console.log('Adding tax columns to row ' + i);
                         updateRowTaxColumns($row[0]);
                     } else {
                         console.log('Row ' + i + ' already has tax columns');
                         // Tính lại thuế cho dòng này
                         calculate_tax(i);
                     }
                 }
             }
         }
         
         // Hàm tính lại thuế cho tất cả dòng
         function recalculateAllTax() {
             var rowcount = $('#hidden_rowcount').val();
             console.log('Recalculating tax for ' + rowcount + ' rows');
             
             for (var i = 1; i <= rowcount; i++) {
                 if (document.getElementById('td_data_' + i + '_3')) {
                     calculate_tax(i);
                 }
             }
         }
         
         // Hàm tính thuế chi tiết cho từng dòng
         function calculateDetailedTax(rowId) {
             var qty = parseFloat($('#td_data_' + rowId + '_3').val()) || 0;
             var unitPrice = parseCurrency($('#td_data_' + rowId + '_10').val());
             var discount = parseCurrency($('#td_data_' + rowId + '_8').val());
             var taxRate = parseFloat($('#tr_tax_value_' + rowId).val()) || 0;
             
             var lineTotal = qty * unitPrice;
             var afterDiscount = lineTotal - discount;
             var taxAmount = (afterDiscount * taxRate) / 100;
             var totalWithTax = afterDiscount + taxAmount;
             
             // Cập nhật các cột thuế (chỉ sử dụng formatNumber, ký hiệu ₫ đã có trong HTML)
             $('#td_' + rowId + '_tax_rate').html(taxRate + '%');
             $('#td_' + rowId + '_tax_amount').html(formatNumber(taxAmount) + ' ₫');
             $('#td_' + rowId + '_before_tax').html(formatNumber(afterDiscount) + ' ₫');
             $('#td_' + rowId + '_after_tax').html(formatNumber(totalWithTax) + ' ₫');
             
             // Debug log
             console.log('Row ' + rowId + ' - Qty: ' + qty + ', Unit Price: ' + unitPrice + ', Discount: ' + discount + ', Tax Rate: ' + taxRate + '%');
             console.log('Row ' + rowId + ' - Line Total: ' + lineTotal + ', After Discount: ' + afterDiscount + ', Tax Amount: ' + taxAmount + ', Total With Tax: ' + totalWithTax);
             
             // Trả về giá trị số nguyên để tính toán
             return {
                 lineTotal: lineTotal,
                 afterDiscount: afterDiscount,
                 taxAmount: taxAmount,
                 totalWithTax: totalWithTax
             };
         }
         
         // Override calculate_tax function để sử dụng tính toán chi tiết
         function calculate_tax(i) {
             set_tax_value(i);
             var result = calculateDetailedTax(i);
             
             // Cập nhật tổng cuối cùng (lưu dạng số)
             $('#td_data_' + i + '_9').val(result.totalWithTax);
             
             final_total();
         }
         
         // Hàm tính tổng chi tiết
         function calculateDetailedTotals() {
             var rowcount = $('#hidden_rowcount').val();
             var totals = {
                 quantity: 0,
                 subtotal: 0,
                 totalBeforeTax: 0,
                 totalTax: 0,
                 totalAfterTax: 0
             };
             
             for (var i = 1; i <= rowcount; i++) {
                 if (document.getElementById('td_data_' + i + '_3')) {
                     var qty = parseFloat($('#td_data_' + i + '_3').val()) || 0;
                     if (qty > 0) {
                         var unitPrice = parseCurrency($('#td_data_' + i + '_10').val());
                         var discount = parseCurrency($('#td_data_' + i + '_8').val());
                         var taxRate = parseFloat($('#tr_tax_value_' + i).val()) || 0;
                         
                         var lineTotal = qty * unitPrice;
                         var afterDiscount = lineTotal - discount;
                         var taxAmount = (afterDiscount * taxRate) / 100;
                         var totalWithTax = afterDiscount + taxAmount;
                         
                         totals.quantity += qty;
                         totals.subtotal += lineTotal;
                         totals.totalBeforeTax += afterDiscount;
                         totals.totalTax += taxAmount;
                         totals.totalAfterTax += totalWithTax;
                     }
                 }
             }
             
             console.log('Totals:', totals);
             return totals;
         }
         
         // Override final_total function
         function final_total() {
             var totals = calculateDetailedTotals();
             
             // Hiển thị tổng (chỉ sử dụng formatNumber để tránh ký hiệu tiền tệ trùng lặp)
             $('.total_quantity').html(totals.quantity);
             $('#subtotal_amt').html(formatNumber(totals.subtotal));
             $('#total_before_tax_amt').html(formatNumber(totals.totalBeforeTax));
             $('#total_tax_amt').html(formatNumber(totals.totalTax));
             $('#total_after_tax_amt').html(formatNumber(totals.totalAfterTax));
             
             // Tính phụ phí với thuế
             var otherChargesInput = parseCurrency($('#other_charges_input').val());
             var otherChargesTaxId = $('#other_charges_tax_id').val();
             var otherChargesWithTax = otherChargesInput;
             
             // Tính thuế cho phụ phí nếu có
             if (otherChargesInput > 0 && otherChargesTaxId && otherChargesTaxId !== '') {
                 var taxRate = 0;
                 $('#other_charges_tax_id option:selected').each(function() {
                     var taxText = $(this).text();
                     var matches = taxText.match(/\((\d+(?:\.\d+)?)\%\)/);
                     if (matches) {
                         taxRate = parseFloat(matches[1]);
                     }
                 });
                 
                 if (taxRate > 0) {
                     otherChargesWithTax = otherChargesInput + (otherChargesInput * taxRate / 100);
                 }
             }
             
             $('#other_charges_amt').html(formatNumber(otherChargesWithTax));
             
             // Tính chiết khấu
             var discountInput = parseCurrency($('#discount_to_all_input').val());
             var discountType = $('#discount_to_all_type').val();
             var discount = 0;
             
             if (discountInput > 0) {
                 if (discountType === 'in_fixed') {
                     discount = discountInput;
                 } else if (discountType === 'in_percentage') {
                     discount = (totals.totalAfterTax * discountInput) / 100;
                 }
             }
             
             $('#discount_to_all_amt').html(formatNumber(discount));
             $('#hidden_discount_to_all_amt').val(discount);
             
             // Tính tổng cuối cùng
             var grandTotal = totals.totalAfterTax + otherChargesWithTax - discount;
             var roundedTotal = round_off(grandTotal);
             var roundDiff = roundedTotal - grandTotal;
             
             // Hiển thị (chỉ sử dụng formatNumber để tránh ký hiệu tiền tệ trùng lặp)
             $('#round_off_amt').html(formatNumber(roundDiff));
             $('#total_amt').html(formatNumber(roundedTotal));
             
             // Lưu giá trị số cho tính toán
             $('#hidden_total_amt').val(roundedTotal);
             $('#hidden_round_off_amt').val(roundDiff);
             
             if (save_operation()) {
                 $('#amount').val('0');
             }
         }
         
         // Hàm round_off sử dụng logic tương tự như PHP
         function round_off(amount) {
             // Tạm thời sử dụng Math.round, có thể tùy chỉnh logic làm tròn sau
             return Math.round(amount);
         }
         
         // Hàm enable_or_disable_item_discount
         function enable_or_disable_item_discount() {
             var discountInput = parseCurrency($('#discount_to_all_input').val());
             var rowcount = $('#hidden_rowcount').val();
             
             if (discountInput > 0) {
                 // Nếu có chiết khấu tổng, có thể disable item discount
                 $('.item_discount').attr({
                     'style': 'border-color:red;cursor:no-drop',
                 });
             } else {
                 // Nếu không có chiết khấu tổng, cho phép item discount
                 $('.item_discount').attr({
                     'style': '',
                 });
             }
             
             // Sửa chữa cột thuế trước khi tính lại
             fixAllTaxColumns();
             
             // Tính lại thuế cho tất cả các dòng
             recalculateAllTax();
         }
         
         // Hàm set_tax_value (nếu chưa có)
         function set_tax_value(rowId) {
             // Hàm này có thể được sử dụng để set giá trị thuế
             // Tạm thời để trống, có thể implement sau
         }
         
         // Hàm save_operation
         function save_operation() {
             <?php if($save_operation){ ?>
                return true;
             <?php } else { ?>
                return false;
             <?php } ?>
         }
         
         // Hàm removerow (xóa dòng)
         function removerow(id) {
             $('#row_' + id).remove();
             $('#doublerow_' + id).remove();
             final_total();
             
             // Play sound effect nếu có
             if (typeof failed !== 'undefined') {
                 failed.currentTime = 0;
                 failed.play();
             }
         }
         
         // Hàm increment_qty (tăng số lượng)
         function increment_qty(rowcount) {
             var item_qty = parseFloat($('#td_data_' + rowcount + '_3').val()) || 0;
             var new_item_qty = item_qty + 1;
             $('#td_data_' + rowcount + '_3').val(new_item_qty);
             calculate_tax(rowcount);
         }
         
         // Hàm decrement_qty (giảm số lượng)
         function decrement_qty(rowcount) {
             var item_qty = parseFloat($('#td_data_' + rowcount + '_3').val()) || 0;
             
             if (item_qty <= 1) {
                 $('#td_data_' + rowcount + '_3').val(1);
                 if (typeof toastr !== 'undefined') {
                     toastr["warning"]("Giá trị nhỏ nhất là 1!");
                 }
                 return;
             }
             
             $('#td_data_' + rowcount + '_3').val(item_qty - 1);
             calculate_tax(rowcount);
         }
         
         // Hàm item_qty_input (xử lý input số lượng)
         function item_qty_input(i) {
             calculate_tax(i);
         }
         
         // Hàm shift_cursor (di chuyển con trỏ khi nhấn Enter)
         function shift_cursor(kevent, target) {
             if (kevent.keyCode == 13) {
                 $('#' + target).focus();
             }
         }
         
         // Hàm return_row_with_data (thêm dòng sản phẩm mới)
         function return_row_with_data(item_id) {
             $('#item_search').addClass('ui-autocomplete-loader-center');
             var base_url = $('#base_url').val().trim();
             var rowcount = $('#hidden_rowcount').val();
             var cusLvs = $('#cusLV')[0].getAttribute('data-lv');
             
             $.post(base_url + "sales/return_row_with_data2/" + cusLvs + "/" + rowcount + "/" + item_id, {}, function(result) {
                 $('#sales_table tbody').prepend(result);
                 $('#hidden_rowcount').val(parseFloat(rowcount) + 1);
                 
                 // Play success sound
                 if (typeof success !== 'undefined') {
                     success.currentTime = 0;
                     success.play();
                 }
                 
                 enable_or_disable_item_discount();
                 
                 // Format tiền tệ cho các input trong dòng mới
                 if (typeof formatNewRowInputs !== 'undefined') {
                     formatNewRowInputs(rowcount);
                 }
                 
                 $('#item_search').removeClass('ui-autocomplete-loader-center');
                 $('#td_data_' + rowcount + '_3').focus();
                 $('#td_data_' + rowcount + '_3').select();
             });
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
