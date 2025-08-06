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
      $reference_no  =
      $other_charges_input          = $other_charges_tax_id =
      $discount_type  = $sales_note = '';
      $sales_date=show_date(date("d-m-Y"));
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
            <span style="font-weight: bold;" id="cusLV">Điều chỉnh tồn kho</span>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
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
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">

                          
                           <!--div class="box-body">
                              <div class="form-group">
                                 <label for="sales_date" class="col-sm-2 control-label">Ngày kiểm đếm <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control pull-right datepicker"  id="sales_date" name="sales_date" readonly onkeyup="shift_cursor(event,'sales_status')" value="<?= $sales_date;?>">
                                    </div>
                                    <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 
                                 <label for="reference_no" class="col-sm-2 control-label">Mã tham chiếu </label>
                                 <div class="col-sm-3">
                                    <input type="text" value="<?php echo  $reference_no; ?>" class="form-control " id="reference_no" name="reference_no" placeholder="" >
                                    <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                           </div-->
                           <!-- /.box-body -->
                           
                           <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-12">
                                  <div class="box">
                                    <div class="box-info">
                                      <div class="box-header">
                                        <div class="col-md-8 col-md-offset-2 d-flex justify-content" >
                                          <div class="input-group">
                                                <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                                 <input type="text" class="form-control " placeholder="Item name/Barcode/Itemcode" id="item_search">
                                              </div>
                                        </div>
                                      </div>
                                      <div class="box-body">
                                        <div class="table-responsive" style="width: 100%">
                                        <table class="table table-hover table-bordered" style="width:100%" id="sales_table">
                                             <thead class="custom_thead">
                                                <tr class="bg-primary" >
                                                    <!--th rowspan='2' style="width:20%">Mã ID</th-->
                                                   <th rowspan='2' style="width:50%">Tên sản phẩm</th>
                                                   <th rowspan='2' style="width:15%">Kho hiện có</th>
                                                   <th rowspan='2' style="width:15%">Số lượng kiểm đếm thực tế</th>
                                                   <th rowspan='2' colspan="2" style="width:15%">Thao tác</th>
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

                           </div>
                           
                           <div class="box-footer col-sm-12">
                              <center>
                                 <div class="col-md-12" style="font-weight: bold; color: red; text-align:left;">
                                    Lưu ý: <br>
                                    - Số lượng nhập vào là số hàng kiểm đếm thực tế. VD: kiểm đếm được 100 sản phẩm, thì nhập vào số 100.<br>
                                    - Chỉ kiểm đếm cuối ngày hoặc khi không thực hiện giao dịch. Quá trình kiểm đếm không thể thực hiện song song với việc bán hàng. 
                                 </div>
                                </div>
                              </center>
                           </div>
                           
                           <!-- /.box-body -->
                           <!--div class="box-footer col-sm-12">
                              <center>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="update-stock" class="btn bg-maroon btn-block btn-flat btn-lg payments_modal" title="Save Data">Cập nhật</button>
                                 </div>
                                 <div class="col-sm-3"><a href="<?= base_url()?>dashboard">
                                    <button type="button" class="btn bg-gray btn-block btn-flat btn-lg" title="Go Dashboard">Đóng</button>
                                  </a>
                                </div>
                              </center>
                           </div-->
                           
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

      <script src="<?php echo $theme_link; ?>js/sales-stock.js?v=<?= time(); ?>"></script>  
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  
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
               $("#amount").val(parseFloat(subtotal_round).toFixed(0));
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
      
      $("#sales_item2_finalprice0").val(item_pr0);
      $("#sales_item2_finalprice1").val(item_pr1);
      $("#sales_item2_finalprice2").val(item_pr2);
      $("#sales_item2_finalprice3").val(item_pr3);
      $("#sales_item2_finalprice").val(item_pr);
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
      if(parseFloat(item_qty)>parseFloat(available_qty)){
        $("#td_data_"+i+"_3").val(available_qty);
        toastr["warning"]("Oops! You have only "+available_qty+" items in Stock");
      }
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
</body>
</html>
