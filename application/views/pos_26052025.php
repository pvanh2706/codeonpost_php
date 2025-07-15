<!DOCTYPE html>
<html>
<style>
    .swal-title {
        font-size: 15px;
    }
</style>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/square/blue.css">

  <style type="text/css">
    .select2-container--default .select2-selection--single{
      border-radius: 0px;
    }
    /*LEFT SIDE: ITEMS TABLE*/
    .table-striped > tbody > tr:nth-of-type(2n+1) {
      background-color: #ede3e3;
    }
    .table-striped > tbody > tr {
      background-color: #ddc8c8;
    }

    /*SET TOTAL FONT*/
    .tot_qty, .tot_amt, .tot_disc, .tot_grand {
      font-size: 19px;
      color: #023763 ;
    }
    /*CURSOR POINTER CLASS*/
    .pointer{
      cursor:pointer;
    }
    .navbar-nav > .user-menu > .dropdown-width-lg{
      /*width: 350px;*/
      width: 50vw;
    }
    .header-custom{
      background-image: -webkit-gradient(linear, left top, right top, from(#20b9ae), to(#006fd6)); color: white;
    }
    .border-custom-bottom{
      border-bottom: 1px solid;
      padding-top: 10px;
      padding-bottom: 5px;
    }
    .custom-font-size{
      font-size: 22px;
    }
    .search_item{
      text-transform: uppercase;
      font-size: 10px;
      color: #000000;
      text-align: center;
      text-overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }
    .item_image{
      min-width: 70px;
      min-height:  70px;
      max-width: 70px;
      max-height:  70px;
    }
    .item_box{
      border-top:none;
    }
    .min_width{
      min-width: 70px;
    }
  </style>
</head>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
  <script type="text/javascript">
    if(theme_skin!='skin-blue'){
      $("body").addClass(theme_skin);
      $("body").removeClass('skin-blue');
    }
    if(sidebar_collapse=='true'){
      $("body").addClass('sidebar-collapse');
    }
  </script> 
  <?php $CI =& get_instance(); ?>
<div class="wrapper">
  
  
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <span class="navbar-brand"><?php  echo $SITE_TITLE;?></span>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Treo đơn hàng">
             
              <span class="">Treo giữ đơn hàng</span>
              <span class="label label-danger hold_invoice_list_count"><?=$tot_count?></span>
            </a>

            <ul class="dropdown-menu dropdown-width-lg">
              
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-12 text-center " style="max-height:300px;overflow-y: scroll;">
                    <table class="table table-bordered" width="100%">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Thời gian</th>
                        <th>Mã nhớ đơn hàng</th>
                        <th>Hệ thống</th>
                      </tr>
                      </thead>
                      <tbody id="hold_invoice_list" >
                       <?=$result?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.row -->
              <!--</li>-->
            </ul>
          </li>
          
            <!--li class="hidden-xs" id="fullscreen"><a title="Fullscreen On/Off"><i class="fa fa-tv text-white" ></i> </a></li-->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($this->session->userdata('inv_username')); ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">

                <p>
                 <?php print ucfirst($this->session->userdata('inv_username')); ?>
                  <small>2015 - <?=date("Y");?></small>
                </p>
              </li>
            </ul>
          </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>

  <?php $css = ($this->session->userdata('language')=='Arabic' || $this->session->userdata('language')=='Urdu') ? 'margin-right: 0 !important;': '';?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="<?=$css;?>">

    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_pos_sales_item.php"; ?>
    <!-- **********************MODALS END***************** -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <!--div class="col-md-5">
              <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab">Tab 1</a></li>
                           <li class=""><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                           <li class=""><a href="#tab_3" data-toggle="tab">Tab 3</a></li>
                        </ul>
                    <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                               11111111111111111111111
                           </div>
                           <div class="tab-pane" id="tab_2">
                               22222222222222222222222
                           </div>
                           <div class="tab-pane" id="tab_3">
                               33333333333333333333333
                           </div>
                    </div>
              </div>
          </div-->
          
          
          
          
        <!-- left column -->
        <div class="col-md-5">
         
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <form class="form-horizontal" id="pos-form" >
            <div class="box-header with-border" style="padding-bottom: 0px;">
              <div class="row" >
                <div class="col-md-12" >
                <div class="col-md-4">
                  <!--h3 class="box-title text-primary">
                      <i class="fa fa-shopping-cart text-aqua"></i> Hóa đơn bán hàng
                      <span style="font-weight: bold;" id="customerLevel"></span>
                      <span style="font-weight: bold; color: red;" id="customerPoint"></span></h3-->
                </div>
                  
                <?php if(isset($sales_id)): ?>
                  <?php if($CI->permissions('sales_add')) { ?>
                  <div class="col-md-4 pull-right">
                    <a href='<?= $base_url;?>pos' class="btn btn-primary pull-right">New Invoice</a>
                  </div>
                  <?php } ?>
                <?php endif; ?>
                
              </div>
              </div>
               
            
            
            
          </div>
            <!-- /.box-header -->
            
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" value='0' id="hidden_rowcount" name="hidden_rowcount">
              <input type="hidden" value='' id="hidden_invoice_id" name="hidden_invoice_id">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">

              <input type="hidden" value='' id="temp_customer_id" name="temp_customer_id">
              <input type="hidden" value='0' id="hidden_cusLevel" name="hidden_cusLevel">
              
              <!-- **********************MODALS***************** -->
             <?php //include"modals_pos_payment/modal_payments_multi.php"; ?>
              <!-- **********************MODALS END***************** -->
              <!-- **********************MODALS***************** -->
              <div class="modal fade" id="discount-modal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Set Discount</h4>
                    </div>
                    <div class="modal-body">
                        <?php 
                            $discount_input = $this->db->select("sales_discount")->get('db_sitesettings')->row()->sales_discount;
                            $discount_input = ($discount_input==0) ? '' : $discount_input;
                        ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_input">Discount</label>
                                <input type="text" class="form-control" id="discount_input" name="discount_input" placeholder="" value="<?=$discount_input?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select class="form-control" id='discount_type' name="discount_type">
                                  <option value='in_percentage'>Per%</option>
                                  <option value='in_fixed'>Fixed</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Đóng</button>
                      <button type="button" class="btn btn-primary discount_update">Cập nhật</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              <!-- **********************MODALS END***************** -->
              <div class="box-body">   
              <?php if(isset($sales_id)){ ?>             
                <div class="row">
                <div class="col-md-6">
                  <div class="input-group date">
                     <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                     </div>
                     <input type="text" class="form-control pull-right datepicker"  id="sales_date" name="sales_date" readonly value="">
                  </div>
                  <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                </div>                
              </div><!-- row end -->
              <br>
            <?php } ?>
              <div class="row">
                <!-- Long hq chỗ để tên khách -->
                <div class="col-md-6">
                        <div class="input-group">
                        <span class="input-group-addon" title="Customer"><i class="fa fa-user"></i></span>
                         <select class="form-control select2" id="customer_id" name="customer_id"  style="width: 100%;" ></select>
                         <script>
                                /*$("#customer_id").change(function(){
                                    var $options = $(this).find('option:selected');
                                    var values = $options.val();
                                    if (values != 1) {
                                        var name = prompt('Vui lòng nhập mật khẩu cho chức năng này! \nMật khẩu thiết đặt trong POS -> Cài đặt chung -> Cài đặt POS');
                                        if (name == '<?= get_site_settings_config('pos_pass_price') ?>') {
                                            //a123@
                                            var conf = confirm('Muốn thay đổi khách hàng?');
                                            if(conf === true) {
                                                autoLoadFirstCustomer(values);
                                            } else {
                                                alert ('Hẹn gặp bạn lần sau! Tôi chưa thực hiện chức năng này! yên tâm');
                                            }
                                        } else {
                                            alert("Sai mật khẩu rồi! bye bye bạn nhé! không tiễn!");
                                            autoLoadFirstCustomer(1);
                                        }
                                    } else {
                                        //autoLoadFirstCustomer(values);
                                    }
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                });*/
                            
                             $("#customer_id").change(function(){
                                var $option = $(this).find('option:selected');
                                var value = $option.val();//customer ID
                                var text = $option.text();//Customer Name
                                    if (value != 1) {
                                        $.ajax({
                                            type: "GET",
                                            url: "<?= $base_url?>customers/getCustomers/"+value,
                                            dataType: "json"
                                        }).done(function(result){
                                            $("#customer_id").attr('data-level', result[0].level);
                                            var valueCheck = $("#priceLevel").attr("data-priceLevel");
                                            if (valueCheck != result[0].level){
                                                var checkRowCount = $("tr.itemrows").length;
                                                if (checkRowCount > 0){
                                                    if (confirm("Khách hàng này không thuộc chính sách giá " + get_price_level_name(result[0].level) + " đang chọn cho sản phẩm! Xác nhận thay đổi giá các sản phẩm đã chọn qua chính sách giá " + get_price_level_name(result[0].level) +"?") == true){
                                                        
                                                        for (var i=0; i<checkRowCount; i++) {
                                                            var A = i;
                                                            var Dr = $("tr.itemrows")[A].getAttribute('data-rowcount');
                                                            var Di = $("tr.itemrows")[A].getAttribute('data-item-id');
                                                            change_price_row_level(result[0].level, Dr, Di);
                                                            
                                                        }
                                                        
                                                    } 
                                                } else {
                                                    confirm("Khách hàng này không thuộc chính sách giá " + get_price_level_name(result[0].level) + " đang chọn cho sản phẩm! Vui lòng chọn chính sách giá trước!");
                                                }
                                                
                                            }
                                        })
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
                                                $("#sales_price_"+datarow).val(prlvs);
                                                
                                            })
                                            //adjust_payments();
                                            //calculate_payments();
                                }
                                
                                
                         </script>
                        <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                      </div>
                        <span class="customer_points text-success" style="display: none;"></span>
                    </div>
                    
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                     <input type="text" class="form-control" placeholder="Tên SP / Mã SP / Barcode [Ctrl+Shift+S]" id="item_search">
                  </div>
                </div>                
              </div><!-- row end -->
              <br>
              <div  class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12" style="overflow-y:auto; border:1px solid #337ab7; height:auto;" >
                      <table id="print_area" class="table table-condensed table-bordered table-striped table-responsive items_table" style="">
                        <thead class="bg-primary">
                          <!--th width="40%">Sản phẩm</th-->
                          <!--th width="5%">Kho</th-->
                          <th width="5%">S.Lượng</th>
                          <!--th width="20%">Phân loại</th-->
                          <th width="15%">Đ.Giá</th>
                          <th width="10%">C.Khấu</th>
                          <th width="10%" class='<?=tax_disable_class()?>'><?= $this->lang->line('tax'); ?></th>
                          <th width="20%">T.Tính</th>
                          <th width="5%" class="text-center"><i id="clearAllrow" class="fa fa-close" title="xóa hết cho nhanh" style="cursor: pointer;"></i></th>
                          <script>
                              $("#clearAllrow").click(function(){
                               var checkRowCount = $("tr.itemrows").length;
                                    if (checkRowCount > 0){
                                        for (var i=0; i<checkRowCount; i++) {
                                            var T = $("tr.itemrows")[0].getAttribute('data-rowcount');
                                            removerow(T);
                                        }
                                    } else {
                                        alert('Có cái gì đâu mà bấm xóa vậy cha nội!');
                                    }
                            });
                          </script>
                        </thead>
                        <tbody id="pos-form-tbody" class="itemcartrows" style="font-size: 1em;font-weight: bold;overflow: scroll;">
                          <!-- body code -->
                        </tbody>        
                        <tfoot>
                          <!-- footer code -->
                        </tfoot>              
                      </table>
                    </div>
                  </div>
                </div>
              </div>


            <!-- modal in tạm tính -->
            <div class="modal fade" id="inTamTinhModal" tabindex="-1" role="dialog" aria-labelledby="inTamTinhModalTitle" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="inTamTinhModalTitle">Hóa đơn tạm tính</h5>
                  </div>
                  <div class="modal-body">
                      <div class="col-sm-12" style="overflow-y:auto; border:1px solid #337ab7; height:auto;" >
                          
                          
                          
                          
                          
                          
                          
                    <table id="print_area" class="table table-condensed table-bordered table-striped table-responsive items_table" style="">
                                    <thead class="bg-primary">
                                      <th width="5%">S.Lượng</th>
                                      <th width="15%">Đ.Giá</th>
                                      <th width="20%">T.Tính</th>
                                    </thead>
                                    <tbody id="pos-form-tbody-modal" class="itemcartrows" style="font-size: 1em;font-weight: bold;overflow: scroll;">
                                        Dữ liệu có cái méo gì đâu mà in
                                    </tbody>        
                                    <tfoot>
                                    </tfoot>              
                                  </table>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button-->
                    <button type="button" class="btn btn-primary"><i class="fa  fa-print "></i> In hóa đơn</button>
                  </div>
                </div>
              </div>
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
                          $other_charges = '';//(isset($sales_id)) ? $other_charges : "";
                    ?>
                <div class="row">
                    <div class="col-xs-12 ">
                      <!--div class="col-md-6">
                           <div class="checkbox icheck">
                              <input type="checkbox" <?=$send_sms_checkbox;?> class="form-control" id="send_sms" name="send_sms" > <label for="sales_discount" class=" control-label"><label for='send_sms'><?= $this->lang->line('send_sms_to_customer'); ?></label>
                                <i class="hover-q " data-container="body" data-toggle="popover" data-placement="top" data-content="If checkbox is Disabled! You need to enable it from SMS -> SMS API <br><b>Note:<i>Walk-in Customer will not receive SMS!</i></b>" data-html="true" data-trigger="hover" data-original-title="" title="Do you wants to send SMS ?">
                                  <i class="fa fa-info-circle text-maroon text-black hover-q"></i>
                                </i>
                              </label>
                          </div>
                        </div-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="other_charges" class="col-sm-4 control-label">Thêm phụ phí khác <label class="text-danger">*</label></label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control text-left" id="other_charges" name="other_charges" placeholder="0"  value="<?=$other_charges?>" onkeyup="calculate_payments()">
                                    <span id="other_charges_msg" style="display:none" class="text-danger"></span>
                                </div>
                                <div class="col-sm-5">
                                    <span id="addServices" class="btn bg-maroon btn-block">Thêm dịch vụ</span>
                                </div>
                                <script>
                                    $("#addServices").click(function(){
                                        get_item_details(-1);
                                        //addrow(823);
                                    });
                                </script>
                            </div>
                        </div>
                    </div> 
                </div>
           
              </div>
              <!-- /.box-body -->

              <div class="box-footer bg-gray">
                <!--div class="row">
                  <div class="col-md-3 text-right">
                          <label> Số lượng:</label>
                          <div class="form-control"><span class="text-bold tot_qty"></span></div>
                  </div>
                  <div class="col-md-3 text-right">
                          <label> Tạm tính:</label>
                          <div class="form-control"><?= $CI->currency('<span style="font-size: 19px;" class="tot_amt text-bold"></span>');?></div>
                  </div>
                  <div class="col-md-3 text-right">
                          <label> Chiếc khấu thêm: <a class="fa fa-pencil-square-o cursor-pointer" data-toggle="modal" data-target="#discount-modal"></a></label>
                          <div class="form-control"><?= $CI->currency('<span style="font-size: 19px;" class="tot_disc text-bold"></span>');?></div>
                  </div>
                  <div class="col-md-3 text-right">
                          <label>Tổng hóa đơn:</label>
                          <div class="form-control"><?= $CI->currency('<span style="font-size: 19px;" class="tot_grand text-bold"></span>');?></div>
                          
                  </div>
                </div-->
               <br>
               <style>
                   .custom-font-sizes {
                       font-size:1em;
                   }
               </style>
               <div class="row">
                   <div class="col-md-6">
                      <div class="box box-solid bg-blue">
                          <div class="box-body">
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold ">Số lượng sản phẩm:</span>
                                <span class="col-md-5 text-right text-bold custom-font-sizes "><span class="sales_div_tot_qty">0</span></span>
                              </div>
                            </div>
            
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold ">Tổng tạm tính:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes "><span class="sales_div_tot_amt">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold " data-toggle="modal" data-target="#discount-modal">Chiếc khấu:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes " ><span class="sales_div_tot_discount">0</span>₫</span>
                              </div>
                            </div>
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold " >Phụ phí:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes " ><span class="sales_div_other_charges">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                            <div class="row bg-red">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold ">Tổng thanh toán:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes "><span class="sales_div_tot_payble">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold ">Thanh toán:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes "><span class="sales_div_tot_paid">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                            <!--  -->
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom">
                                <span class="col-md-7 text-right text-bold ">Công nợ:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes "><span class="sales_div_tot_balance">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                            <div class="row ">
                              <div class="col-md-12 border-custom-bottom bg-orange">
                                <span class="col-md-7 text-right text-bold ">Tiền thừa trả lại:</span>
                                <span class="col-md-5 text-right text-bold  custom-font-sizes "><span class="sales_div_change_return">0</span>₫</span>
                              </div>
                            </div>
                            <!--  -->
                                                  
                          </div>
                                <!-- /.box-body -->
                              </div>
                    </div>
                    <div class="col-md-6" style="font-size:1em;">
        <div>

        <?php 
            $atleast_one_payments = 'true';
            if(isset($sales_id) && $sales_id!='') { //For Save Operation or for new entry

            $q22=$this->db->query("select payment,payment_type,payment_note from db_salespayments where sales_id='$sales_id'");
            if($q22->num_rows()>0){
                $atleast_one_payments = 'false';
                $i=0;
                foreach ($q22->result() as $res22) { $i++;
        ?>   
            <div class="col-md-12 payments_div">
                <div class="box box-solid bg-gray">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <label for="amount_<?= $i;?>">Tổng tiền khách trả</label>
                                    <input type="text" class="form-control text-right payment only_currency" value='<?= $res22->payment;?>' id="amount_<?= $i;?>" name="amount_<?= $i;?>" placeholder="" onkeyup="calculate_payments()">
                                    <span id="amount_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="payment_type_<?= $i;?>">Hình thức thanh toán</label>
                                    <select class="form-control" id='payment_type_<?= $i;?>' name="payment_type_<?= $i;?>">
                                    <?php
                                        $q1=$this->db->query("select * from db_paymenttypes where status=1");
                                        if($q1->num_rows()>0){
                                            foreach($q1->result() as $res1){
                                                $selected=($res22->payment_type==$res1->payment_type) ? 'selected' : '';
                                                echo "<option $selected value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                                            }
                                        }
                                        else {
                                            echo "Không có dữ liệu";
                                        }
                                      ?>
                                    </select>
                                    <span id="payment_type_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <label for="payment_note_<?= $i;?>">Ghi chú thêm cho hóa đơn</label>
                                    <textarea type="text" class="form-control" id="payment_note_<?= $i;?>" name="payment_note_<?= $i;?>" placeholder="" ><?= $res22->payment_note;?></textarea>
                                    <span id="payment_note_<?= $i;?>_msg" style="display:none" class="text-danger"></span>
                                </div>
                            </div>
                      
                            <div class="clearfix"></div>
                        </div>   
                    </div>
                </div>
            </div><!-- col-md-12 -->
        <?php } //foreach() ?>
            <input type="hidden" data-var='inside_forech' name="payment_row_count" id='payment_row_count' value="<?= $i;?>">
        <?php } //num_rows if() 
            else{ $atleast_one_payments ='true'; }
        ?>
         
        <?php  } 
            if($atleast_one_payments=='true'){ ?>
                <input type="hidden" data-var='inside_else' name="payment_row_count" id='payment_row_count' value="1">
                <div class="col-md-12  payments_div">
                    <div class="box box-solid bg-gray">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <label for="amount_1">Tổng tiền nhận</label>
                                        <input type="text" class="form-control text-right payment" id="amount_1" name="amount_1" placeholder="" onkeyup="calculate_payments()">
                                        <span id="amount_1_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <label for="payment_type_1">Hình thức thanh toán</label>
                                        <select class="form-control" id='payment_type_1' name="payment_type_1">
                                            <?php
                                                $q1=$this->db->query("select * from db_paymenttypes where status=1");
                                                if($q1->num_rows()>0){
                                                    foreach($q1->result() as $res1){
                                                    echo "<option value='".$res1->payment_type."'>".$res1->payment_type ."</option>";
                                                }
                                            } else{ echo "Không có dữ liệu"; } ?>
                                        </select>
                                        <span id="payment_type_1_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <label for="payment_note_1">Ghi chú thêm cho hóa đơn</label>
                                        <textarea type="text" class="form-control" id="payment_note_1" name="payment_note_1" placeholder="" ></textarea>
                                        <span id="payment_note_1_msg" style="display:none" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>   
                        </div>
                    </div>
                </div><!-- col-md-12 -->
                <?php } ?>

            </div>
                    <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-block" id="add_payment_row">Thêm hình thức thanh toán</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
                    
               </div>
               <br>
                <div class="row">
                
                  <?php if(isset($sales_id)){ $btn_id='update';$btn_name="Cash"; ?>
                    <input type="hidden" name="sales_id" id="sales_id" value="<?php echo $sales_id;?>"/>
                  <?php } else{ $btn_id='save';$btn_name="Tiền mặt";} ?>

                  <div class="col-md-12 text-right">

                    <div class="col-sm-6">
                      <button type="button" id="hold_invoice" name="" class="btn bg-maroon btn-block btn-flat btn-lg" title="Giữ đơn và In tạm tính">
                      <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                       Giữ đơn & In tạm tính
                    </button>
                    </div>
                    
                    <!--div class="col-sm-3">
                        <button type="button" class="btn bg-primary btn-lg make_sale btn-lg btn-block" data-toggle="modal" data-target="#inTamTinhModal"><i class="fa  fa-save "></i> In tạm tính</button>
                    </div>
                    <script>
                        function print_alert(el){
                            var restorepage = $('body').html();
                            var printcontent = $('#' + el).clone();
                            $('body').empty().html(printcontent);
                            window.print();
                            $('body').html(restorepage);
                        }
                    </script-->
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-success btn-lg make_sale btn-lg btn-block" onclick="save(true)"><i class="fa  fa-print "></i> Lưu & In hóa đơn POS</button>
                    </div>
                    <!--div class="col-sm-6">
                      <button type="button" id="" name="" class="btn btn-primary btn-block btn-flat btn-lg show_payments_modal" title="Multiple Payments [Ctrl+Shift+M]">
                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                             Chốt đơn
                          </button>
                          
                         
                        
                    </div-->
                    <!--div class="col-sm-3">
                      <button type="button" id="<?php echo "show_cash_modal";?>" name="" class="btn btn-success btn-block btn-flat btn-lg shift_c" title="By Cash & Save [Ctrl+Shift+C]">
                            <i class="fa fa-money" aria-hidden="true"></i>
                             <?php echo $btn_name;?>
                          </button>
                    </div-->

                    <!--div class="col-sm-3">
                      <button type="button" id="pay_all" name="" class="btn bg-purple btn-block btn-flat btn-lg shift_a" title="By Cash & Save [Ctrl+Shift+A]">
                            <i class="fa fa-money" aria-hidden="true"></i>
                             Pay All
                          </button>
                    </div-->
                    

                          
                  </div>
                </div>
              </div>
            </form>
            
          </div>
          <!-- /.box -->
          
          
          
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-7">
          <!-- Horizontal Form -->
          <div class="box box-info" style="background: none; box-shadow: none;">
            <!-- form start -->
            
              <div class="box-body">
                
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="input-group" id="" >
                            <span class="input-group-addon" title="Giá theo nhóm giá"><i class="fa fa-file"></i></span>
                            <select class="form-control" id="priceLevel" name="priceLevel" data-priceLevel="-1">
                                <option value="-1">Giá bán lẻ niêm yết</option>
                                <option value="0">Giá tham chiếu Đại lý cấp 0</option>
                                <option value="1">Giá tham chiếu Đại lý cấp 1</option>
                                <option value="2">Giá tham chiếu Đại lý cấp 2</option>
                                <option value="3">Giá tham chiếu Đại lý cấp 3</option>
                            </select>
                            <script>
                                function change_price_row_level(lvs, datarow, itemid){
                                            $.ajax({
                                                type: "GET",
                                                url: "<?= $base_url?>items/getitemprice/"+itemid+"/"+lvs,
                                                dataType: "json"
                                            }).done(function(result){
                                                var prlvs = result[0].itemprice;
                                                //console.log('Result: '+ datarow + ' | ' + result[0].itemprice);
                                                $("#sales_price_"+datarow).val(prlvs);
                                                make_subtotal(itemid,datarow);
                                                calculate_payments();
                                                
                                            })
                                            //adjust_payments();
                                            //calculate_payments();
                                }
                                $("#priceLevel").change(function(){
                                    
                                    var name = prompt('Vui lòng nhập mật khẩu cho chức năng này! \nMật khẩu thiết đặt trong POS -> Cài đặt chung -> Cài đặt POS');
                                    if (name == '<?= get_site_settings_config('pos_pass_price') ?>') {
                                        var conf = confirm('Muốn thay đổi chính sách giá?');
                                        if(conf === true) {
                                            var $option = $(this).find('option:selected');
                                            var value = $option.val();
                                            var text = $option.text();
                                            $(this).attr("data-priceLevel", value);
                                            $("#customerLVP").attr("data-lv", value);
                                        
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
                                           
                                            $("#customerLVP").val("Đang chọn hiển thị chính sách giá của " + level);
                                            var reload_items_row = 1;
                                            get_details_lv(value, reload_items_row);
                                            
                                            var checkRowCount = $("tr.itemrows").length;
                                            if (checkRowCount > 0){
                                                for (var i=0; i<checkRowCount; i++) {
                                                        //var A = i;
                                                        var Dr = $("tr.itemrows")[i].getAttribute('data-rowcount');
                                                        var Di = $("tr.itemrows")[i].getAttribute('data-item-id');
                                                        change_price_row_level(value, Dr, Di);
                                                        
                                                    }
                                            }
                                            
                                            
                                            
                                        }else {
                                            alert ('Hẹn gặp bạn lần sau! Tôi chưa thực hiện chức năng này! yên tâm');
                                        }
                                    } else {
                                        alert("Sai mật khẩu rồi! bye bye bạn nhé! không tiễn!")
                                    }
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="input-group" id="" >
                            <span class="input-group-addon" title="Customer"><i class="fa fa-dollar"></i></span>
                            <input style="color: red;" class="form-control text-bold" type="text" readonly id="customerLVP" name="customerLVP" value="Đang chọn hiễn thị chính sách giá của Khách lẻ" />
                        </div>
                    </div>
                </div>
                <br>
                
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group input-group-md">
                      <select class="form-control select2" id="category_id" name="category_id"  style="width: 100%;"  >
                      <?php
                      $query1="select * from db_category where status=1";
                      $q1=$this->db->query($query1);
                      echo '<option value="">Tất cả danh mục</option>';
                      if($q1->num_rows($q1)>0)
                       {   
                           foreach($q1->result() as $res1)
                         {
                           echo "<option value='".$res1->id."'>".$res1->category_name."</option>";
                         }
                       }
                       else
                       {
                          ?>
                          <option value="">Chưa có dữ liệu</option>
                          <?php
                       }
                      ?>
                    </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_categories" title="Reset Brand" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>  
                <div class="col-md-6">
                  <div class="input-group input-group-md">
                      <select class="form-control select2" id="brand_id" name="brand_id"  style="width: 100%;"  >
                      <?php
                      $query1="select * from db_brands where status=1";
                      $q1=$this->db->query($query1);
                      echo '<option value="">Tất cả nhãn hàng</option>';
                      if($q1->num_rows($q1)>0)
                       {   
                           foreach($q1->result() as $res1)
                         {
                           echo "<option value='".$res1->id."'>".$res1->brand_name."</option>";
                         }
                       }
                       else
                       {
                          ?>
                          <option value="">Chưa có dữ liệu</option>
                          <?php
                       }
                      ?>
                    </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_brands" title="Reset Brand" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>
              </div><!-- row end -->
              
              <!--br>
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group input-group-md">
                      <select class="form-control select2" id="cLevel_id" name="cLevel_id"  style="width: 100%;"  onchange="getvalLevel(this);">
                      <?php
                      $query1="select * from db_customer_level where status=1";
                      $q1=$this->db->query($query1);
                      echo '<option value="">Vui lòng chọn phân loại khách hàng</option>';
                      if($q1->num_rows($q1)>0)
                       {   
                           foreach($q1->result() as $res1)
                         {
                           echo "<option value='".$res1->id."'>".$res1->customer_level_name."</option>";
                         }
                       }
                       else
                       {
                          ?>
                          <option value="">Chưa có dữ liệu</option>
                          <?php
                       }
                      ?>
                    </select>
                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_brands" title="Reset Brand" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>
              </div-->


              <br>
              <div class="row">

                <div class="col-md-12">
                  <div class="input-group input-group-md">
                   
                      <input type="text" class="form-control" data-toggle="tooltip" title="Enter Item Name" placeholder="Tên sản phẩm cần tìm" id="item_name" name="item_name">

                          <span class="input-group-btn">
                            <button type="button" class="btn text-blue btn-flat reset_item_name" title="Reset Item Name" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-undo"></i>
                            </button>
                          </span>
                    </div>
                </div>               

              </div><!-- row end -->
                <br>
             
              <div class="row">
                <div class="col-md-12">
                  <!-- <div class="form-group"> -->
                   <!--  <div class="col-sm-12"> -->
                      <!-- <style type="text/css">
                        
                      </style> -->
                            <section class="content" id="loadItems">
                              <div class="row search_div" style="overflow-y: scroll;min-height: 70vh;height: 70vh">
                                 
                              </div>
                            </section>
                            <div class="ajax-load text-center" style="display:none;">
                                <button type="button" class="btn btn-default btn-lrg ajax" title="Ajax Request">
                                <i class="fa fa-spin fa-refresh"></i>&nbsp; Tải thêm sản phẩm
                              </button>
                              </div>
                         
                    <!-- </div> -->
                  <!-- </div> -->
                </div>
              </div>
           
              </div>
              <!-- /.box-body -->

              
           
          </div>
          <!-- /.box -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include"footer.php";?>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>

<!-- iCheck -->
<script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo $theme_link; ?>js/fullscreen.js"></script>
<script src="<?php echo $theme_link; ?>js/modals.js"></script>
<script src="<?php echo $theme_link; ?>js/pos.js?v=<?= time(); ?>"></script>
<script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js?v=<?= time(); ?>"></script>  

<script>
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


<!-- DROP DOWN -->
<script src="<?php echo $theme_link; ?>dist/js/bootstrap3-typeahead.min.js"></script>  
<!-- DROP DOWN END-->


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

  $("#other_charges").keyup(function(event) {
    final_total();
  });
  //RIGHT SIT DIV:-> FILTER ITEM INTO THE ITEMS LIST
  function search_it(){
  
  var input = $("#search_it").val().trim();
  var item_count=$(".search_div .search_item").length;
  var error_count=item_count;
  for(i=0; i<item_count; i++){
    
    if($("#item_"+i).html().toUpperCase().indexOf(input.toUpperCase())>-1){
    
      $("#item_"+i).show();
      $("#item_parent_"+i).show();
    }
    else{
    
     $("#item_"+i).hide();
     $("#item_parent_"+i).hide();
     error_count--;
    }
    if(error_count==0){
      $(".error_div").show();
    }
    else{
      $(".error_div").hide();
    }
    
  }
  }


//REMOTELY FETCH THE ALL ITEMS OR CATEGORY WISE ITEMS.
function get_details(){
  /*$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $.post("<?php echo $base_url; ?>pos/get_details",{id:$("#category_id").val()},function(result){
    $(".search_div").html('');
    $(".search_div").html(result);
    $(".overlay").remove();
  });*/
}

//LEFT SIDE: ON CLICK ITEM ADD TO INVOICE LIST
function addrow(id='',item_obj=''){
        var itemhidden = false;
        if (item_obj.item_id ==  -1){
            itemhidden = true;
        }
        
        /*var priceLevels = $("#priceLevel")[0].getAttribute('data-priceLevel');
        var customerLevels = $("#customer_id")[0].getAttribute('data-level');
        var levelname = '';
        if (priceLevels != customerLevels && id != null) {
            toastr["error"]("Khách hàng đang chọn thuộc chính sách giá "+ get_price_level_name(customerLevels) +" ! Vui lòng chọn chính sách giá phù hợp!");
            return;
        }*/
    
        var item_id = (item_obj=='') ? $('#div_'+id).attr('data-item-id') : item_obj.item_id; 
        var item_check=check_same_item(item_id);
        if(!item_check){return false;}
        var rowcount        =$("#hidden_rowcount").val();//0,1,2...
        
        
        var item_name = (item_obj=='') ? $('#div_'+id).attr('data-item-name') : item_obj.item_name; 
    
        var stock   =(item_obj=='') ? $('#div_'+id).attr('data-item-available-qty') : item_obj.stock;
            stock     =(parseFloat(stock)).toFixed(0);
        
    
        var tax_type   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-type') : item_obj.tax_type;  
        var tax_id   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-id') : item_obj.tax_id;  
        var tax_value   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-value') : item_obj.tax;
    
        var tax_name   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-name'):item_obj.tax_name;  
        var tax_amt   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-amt') : item_obj.item_tax_amt; 
        var purchase_price   =(item_obj=='') ? $('#div_'+id).attr('data-purchase_price') : item_obj.purchase_price; 
        var discount_type   =(item_obj=='') ? $('#div_'+id).attr('data-discount_type') :item_obj.discount_type; 
        var discount   =(item_obj=='') ? $('#div_'+id).attr('data-discount') : item_obj.discount; 
    
        var item_cost     =(item_obj=='') ? $('#div_'+id).attr('data-item-cost') : item_obj.purchase_price;  
        var sales_price     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price') : item_obj.sales_price ; 
        var sales_price_temp=sales_price;
            sales_price     =(parseFloat(sales_price)).toFixed(0);
            
        var sales_price0     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price0') : item_obj.sales_price0 ; 
        var sales_price0_temp=sales_price0;
            sales_price0     =(parseFloat(sales_price0)).toFixed(0);
            
        var sales_price1     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price1') : item_obj.sales_price1 ; 
        var sales_price1_temp=sales_price1;
            sales_price1     =(parseFloat(sales_price1)).toFixed(0);
            
        var sales_price2     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price2') : item_obj.sales_price2 ; 
        var sales_price2_temp=sales_price2;
            sales_price2     =(parseFloat(sales_price2)).toFixed(0);
            
        var sales_price3     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price3') : item_obj.sales_price3 ; 
        var sales_price3_temp=sales_price3;
            sales_price3     =(parseFloat(sales_price3)).toFixed(0);
        /*if(stock>0){
          if(stock>1){
            qty = 1;
          }
          else{
            qty = stock;
          }
        }
        else{
          zero_stock();return;
        }*/
        
        qty = 1;
        
        
        
        var quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
            quantity       +='<input style="min-width: 30px;" type="text" value="'+qty+'" class="form-control no-padding text-center min_width" onchange="item_qty_input('+item_id+','+rowcount+')" id="item_qty_'+rowcount+'_'+item_id+'" name="item_qty_'+rowcount+'_'+item_id+'">';
            quantity       +='<span class="input-group-btn"><button onclick="increment_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
        var sub_total       =(parseFloat(1)*parseFloat(sales_price)).toFixed(0);//Initial
        var remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('+rowcount+')" title="Delete Item?"></a>';
        
        //var doubleItem = (!itemhidden) ? '<span id="plus_'+rowcount+'" onclick="addrow_gift('+ item_id +');"><i class="fa fa-plus-square" aria-hidden="true"></i></span> <span id="td_data_'+rowcount+'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;">'+ item_name     +'</span>' : item_name + ' <input id="td_data_'+rowcount+'_0" style="width: 80%; white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;" value="">';
        var doubleItem = (!itemhidden) ? '<span id="plus_'+rowcount+'" onclick="addrow_gift('+ item_id +');"><i class="fa fa-plus-square" aria-hidden="true"></i></span> <span id="td_data_'+rowcount+'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;">'+ item_name     +'</span>' : item_name ;
        var str='<tr id="tr_items_name_'+rowcount+'"><td colspan="5" id="td_'+rowcount+'_0">' + doubleItem + ' </td></tr>';
            str+='<tr id="tr_items_desc_'+rowcount+'"><td colspan="5" ><input type="text" class="form-control" name="td_description_'+rowcount+'" id="td_description_'+rowcount+'" placeholder="Ghi chú thêm cho sản phẩm '+ item_name +' (Nếu có)" /></td></tr>';
            str+='<tr  class="itemrows" data-rowcount="'+rowcount+'" id="row_'+rowcount+'" data-price-lv="" data-row="0" data-item-id='+item_id+'>';/*item id*/
            //str+='<td id="td_'+rowcount+'_0"><span id="plus_'+rowcount+'" onclick="addrow_gift('+ item_id +');"><i class="fa fa-plus-square" aria-hidden="true"></i></span> <span id="td_data_'+rowcount+'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;">'+ item_name     +'</span></td>';/* td_0_0 item name*/ 
            //str+='<td id="td_'+rowcount+'_0"><a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'+rowcount+'_0" onclick="show_sales_item_modal('+rowcount+')">'+ item_name     +'</a> <i onclick="show_sales_item_modal('+rowcount+')" class="fa fa-edit pointer"></i></td>';/* td_0_0 item name*/ 
            //str+='<td id="td_'+rowcount+'_1">'+ valstock +'</td>';/* td_0_1 item available qty*/
            str+='<td id="td_'+rowcount+'_2">'+quantity+'</td>';/* td_0_2 item available qty*/
            //str+='<td ><select class="form-control" id="setPrices_'+rowcount+'" onchange="getPrices('+rowcount+','+item_id+')"><option value="'+sales_price+'" data-price="'+sales_price+'">Giá bán lẻ</option><option value="'+sales_price0+'" data-price="'+sales_price0+'">Giá Đại lý Cấp 0</option><option value="'+sales_price1+'" data-price="'+sales_price1+'">Giá Đại lý Cấp 1</option><option value="'+sales_price2+'" data-price="'+sales_price2+'">Giá Đại lý Cấp 2</option><option value="'+sales_price3+'" data-price="'+sales_price3+'">Giá Đại lý Cấp 3</option></select></td>';
            
    
            //info='<input id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price+'">';
            
            //console.log("Check-data-level: " + $("#customerLVP")[0].getAttribute('data-lv'));
            //switch ($("#customerLVP")[0].getAttribute('data-lv')) {
            /*switch (priceLevels) {
                case '0':
                    info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price0+'">';
                    
                    break;
                case '1':
                    info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price1+'">';
                    
                    break;
                case '2':
                    info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price2+'">';
                   
                    break
                case '3':
                    info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price3+'">';
                    
                    break;
                default:
                    info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price+'">';
                    
                
                
            }*/
            
            info='<input  id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price+'">';
            
            
            str+='<td id="td_'+rowcount+'_3" class="text-right">'+ info   +'</td>';/* td_0_3 item sales price*/
    
            /*Discount*/
             info='<input data-toggle="tooltip" title="Giá trị chiết khấu" onclick="show_sales_item_modal('+rowcount+')" id="item_discount_'+rowcount+'" readonly name="item_discount_'+rowcount+'" type="text" class="form-control no-padding min_width pointer" value="0">';
             
            str+='<td id="td_'+rowcount+'_6" class="text-right">'+ info   +'</td>';
    
            /*Tax amt*/
            str+='<td id="td_'+rowcount+'_11" class="<?=tax_disable_class()?>"><input data-toggle="tooltip" title="Click to Change" id="td_data_'+rowcount+'_11" onclick="show_sales_item_modal('+rowcount+')" name="td_data_'+rowcount+'_11" type="text" class="form-control no-padding pointer min_width" readonly value="'+tax_amt+'"></td>';
    
            str+='<td id="td_'+rowcount+'_4" class="text-right"><input data-toggle="tooltip" title="Total" id="td_data_'+rowcount+'_4" name="td_data_'+rowcount+'_4" type="text" class="form-control no-padding pointer" readonly value="'+sub_total+'"></td>';/* td_0_4 item sub_total */
            str+='<td id="td_'+rowcount+'_5">'+ remove_btn    +'</td>';/* td_0_5 item gst_amt */
    
            str+='<input type="hidden" name="tr_item_id_'+rowcount+'" id="tr_item_id_'+rowcount+'" value="'+item_id+'">';
           // str+='<input type="hidden" id="tr_item_per_'+rowcount+'" name="tr_item_per_'+rowcount+'" value="'+gst_per+'">';
            str+='<input type="hidden" id="tr_sales_price_temp_'+rowcount+'" name="tr_sales_price_temp_'+rowcount+'" value="'+sales_price_temp+'">';
            str+='<input type="hidden" id="tr_tax_type_'+rowcount+'" name="tr_tax_type_'+rowcount+'" value="'+tax_type+'">';
            str+='<input type="hidden" id="tr_tax_id_'+rowcount+'" name="tr_tax_id_'+rowcount+'" value="'+tax_id+'">';
            str+='<input type="hidden" id="tr_tax_value_'+rowcount+'" name="tr_tax_value_'+rowcount+'" value="'+tax_value+'">';
            str+='<input type="hidden" id="description_'+rowcount+'" name="description_'+rowcount+'" value="">';
            str+='<input id="item_discount_type_'+rowcount+'" name="item_discount_type_'+rowcount+'" type="hidden" value="'+discount_type+'">';
             str+='<input id="item_discount_input_'+rowcount+'" name="item_discount_input_'+rowcount+'" type="hidden" value="'+discount+'">';
             str+='<input type="hidden" id="purchase_price_'+rowcount+'" name="purchase_price_'+rowcount+'" value="'+purchase_price+'">';
    
            str+='</tr>';   
            
    
        //LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
        $('#pos-form-tbody').append(str);
        //$('#pos-form-tbody-modal').append(str_temp);
    
        //LEFT SIDE: INCREMANT ROW COUNT
        $("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val())+1);
        failed.currentTime = 0;
        failed.play();
        //CALCULATE FINAL TOTAL AND OTHER OPERATIONS
        //final_total();
    
        make_subtotal(item_id,rowcount);
        calculate_payments();

    

  }
  
function addrow_gift(id='',item_obj=''){
    
        var item_id = (item_obj=='') ? $('#div_'+id).attr('data-item-id') : item_obj.item_id; 
        //var item_check=check_same_item(item_id);
        //if(!item_check){return false;}
        var rowcount        =$("#hidden_rowcount").val();//0,1,2...
        
        
        var item_name = (item_obj=='') ? $('#div_'+id).attr('data-item-name') : item_obj.item_name; 
    
        var stock   =(item_obj=='') ? $('#div_'+id).attr('data-item-available-qty') : item_obj.stock;
            stock     =(parseFloat(stock)).toFixed(0);
        
    
        var tax_type   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-type') : item_obj.tax_type;  
        var tax_id   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-id') : item_obj.tax_id;  
        var tax_value   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-value') : item_obj.tax;
    
        var tax_name   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-name'):item_obj.tax_name;  
        var tax_amt   =(item_obj=='') ? $('#div_'+id).attr('data-item-tax-amt') : item_obj.item_tax_amt; 
        var purchase_price   =(item_obj=='') ? $('#div_'+id).attr('data-purchase_price') : item_obj.purchase_price; 
        var discount_type   =(item_obj=='') ? $('#div_'+id).attr('data-discount_type') :item_obj.discount_type; 
        var discount   =(item_obj=='') ? $('#div_'+id).attr('data-discount') : item_obj.discount; 
    
        var item_cost     =(item_obj=='') ? $('#div_'+id).attr('data-item-cost') : item_obj.purchase_price;  
        var sales_price     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price-gift') : item_obj.sales_price ; 
        var sales_price_temp=sales_price;
            sales_price     =(parseFloat(sales_price)).toFixed(0);
            
        var sales_price0     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price-gift') : item_obj.sales_price0 ; 
        var sales_price0_temp=sales_price0;
            sales_price0     =(parseFloat(sales_price0)).toFixed(0);
            
        var sales_price1     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price-gift') : item_obj.sales_price1 ; 
        var sales_price1_temp=sales_price1;
            sales_price1     =(parseFloat(sales_price1)).toFixed(0);
            
        var sales_price2     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price-gift') : item_obj.sales_price2 ; 
        var sales_price2_temp=sales_price2;
            sales_price2     =(parseFloat(sales_price2)).toFixed(0);
            
        var sales_price3     =(item_obj=='') ? $('#div_'+id).attr('data-item-sales-price-gift') : item_obj.sales_price3 ; 
        var sales_price3_temp=sales_price3;
            sales_price3     =(parseFloat(sales_price3)).toFixed(0);
        /*if(stock>0){
          if(stock>1){
            qty = 1;
          }
          else{
            qty = stock;
          }
        }
        else{
          zero_stock();return;
        }*/
        
        qty = 1;
        
        var priceLevels = $("#priceLevel")[0].getAttribute('data-priceLevel');
        
        var quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
            quantity       +='<input style="min-width: 30px;" type="text" value="'+qty+'" class="form-control no-padding text-center min_width" onchange="item_qty_input('+item_id+','+rowcount+')" id="item_qty_'+rowcount+'_'+item_id+'" name="item_qty_'+rowcount+'_'+item_id+'">';
            quantity       +='<span class="input-group-btn"><button onclick="increment_qty('+item_id+','+rowcount+')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
        var sub_total       =(parseFloat(1)*parseFloat(sales_price)).toFixed(0);//Initial
        var remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('+rowcount+')" title="Delete Item?"></a>';
        
        var str='<tr id="tr_items_name_'+rowcount+'"><td colspan="5" id="td_'+rowcount+'_0"><span id="td_data_'+rowcount+'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;"><i class="fa fa-arrow-right"></i> '+ item_name     +'</span></td></tr>';
        str+='<tr id="tr_items_desc_'+rowcount+'"><td colspan="5" ><input type="text" class="form-control" name="td_description_'+rowcount+'" id="td_description_'+rowcount+'" placeholder="Ghi chú thêm cho sản phẩm '+ item_name +' (Nếu có)" /></td></tr>';
         str+='<tr class="itemrows" data-rowcount="'+rowcount+'" id="row_'+rowcount+'" data-price-lv="" data-row="0" data-item-id='+item_id+'>';/*item id*/
            //str+='<td id="td_'+rowcount+'_0"><span id="td_data_'+rowcount+'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;">'+ item_name     +'</span></td>';/* td_0_0 item name*/ 
            //str+='<td id="td_'+rowcount+'_0"><a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'+rowcount+'_0" onclick="show_sales_item_modal('+rowcount+')">'+ item_name     +'</a> <i onclick="show_sales_item_modal('+rowcount+')" class="fa fa-edit pointer"></i></td>';/* td_0_0 item name*/ 
            //str+='<td id="td_'+rowcount+'_1">'+ valstock +'</td>';/* td_0_1 item available qty*/
            str+='<td id="td_'+rowcount+'_2">'+quantity+'</td>';/* td_0_2 item available qty*/
            //str+='<td ><select class="form-control" id="setPrices_'+rowcount+'" onchange="getPrices('+rowcount+','+item_id+')"><option value="'+sales_price+'" data-price="'+sales_price+'">Giá bán lẻ</option><option value="'+sales_price0+'" data-price="'+sales_price0+'">Giá Đại lý Cấp 0</option><option value="'+sales_price1+'" data-price="'+sales_price1+'">Giá Đại lý Cấp 1</option><option value="'+sales_price2+'" data-price="'+sales_price2+'">Giá Đại lý Cấp 2</option><option value="'+sales_price3+'" data-price="'+sales_price3+'">Giá Đại lý Cấp 3</option></select></td>';
            
    
            info='<input id="sales_price_'+rowcount+'" onblur="set_to_original('+rowcount+','+item_cost+')" onkeyup="update_price('+rowcount+','+item_cost+')" name="sales_price_'+rowcount+'" type="text" class="form-control no-padding min_width priceset" value="'+sales_price+'">';
            
            
            
            
            
            
            str+='<td id="td_'+rowcount+'_3" class="text-right">'+ info   +'</td>';/* td_0_3 item sales price*/
    
            /*Discount*/
             info='<input data-toggle="tooltip" title="" id="item_discount_'+rowcount+'" readonly name="item_discount_'+rowcount+'" type="text" class="form-control no-padding min_width pointer" value="0">';
             
            str+='<td id="td_'+rowcount+'_6" class="text-right">'+ info   +'</td>';
    
            /*Tax amt*/
            str+='<td id="td_'+rowcount+'_11" class="<?=tax_disable_class()?>"><input data-toggle="tooltip" title="Click to Change" id="td_data_'+rowcount+'_11" onclick="show_sales_item_modal('+rowcount+')" name="td_data_'+rowcount+'_11" type="text" class="form-control no-padding pointer min_width" readonly value="'+tax_amt+'"></td>';
    
            str+='<td id="td_'+rowcount+'_4" class="text-right"><input data-toggle="tooltip" title="" id="td_data_'+rowcount+'_4" name="td_data_'+rowcount+'_4" type="text" class="form-control no-padding pointer" readonly value="'+sub_total+'"></td>';/* td_0_4 item sub_total */
            str+='<td id="td_'+rowcount+'_5">'+ remove_btn    +'</td>';/* td_0_5 item gst_amt */
    
            str+='<input type="hidden" name="tr_item_id_'+rowcount+'" id="tr_item_id_'+rowcount+'" value="'+item_id+'">';
           // str+='<input type="hidden" id="tr_item_per_'+rowcount+'" name="tr_item_per_'+rowcount+'" value="'+gst_per+'">';
            str+='<input type="hidden" id="tr_sales_price_temp_'+rowcount+'" name="tr_sales_price_temp_'+rowcount+'" value="'+sales_price_temp+'">';
            str+='<input type="hidden" id="tr_tax_type_'+rowcount+'" name="tr_tax_type_'+rowcount+'" value="'+tax_type+'">';
            str+='<input type="hidden" id="tr_tax_id_'+rowcount+'" name="tr_tax_id_'+rowcount+'" value="'+tax_id+'">';
            str+='<input type="hidden" id="tr_tax_value_'+rowcount+'" name="tr_tax_value_'+rowcount+'" value="'+tax_value+'">';
            str+='<input type="hidden" id="description_'+rowcount+'" name="description_'+rowcount+'" value="">';
            str+='<input id="item_discount_type_'+rowcount+'" name="item_discount_type_'+rowcount+'" type="hidden" value="'+discount_type+'">';
             str+='<input id="item_discount_input_'+rowcount+'" name="item_discount_input_'+rowcount+'" type="hidden" value="'+discount+'">';
             str+='<input type="hidden" id="purchase_price_'+rowcount+'" name="purchase_price_'+rowcount+'" value="'+purchase_price+'">';
    
            str+='</tr>';   
    
        //LEFT SIDE: ADD OR APPEND TO SALES INVOICE TERMINAL
        $('#pos-form-tbody').append(str);
        //$('#pos-form-tbody-modal').append(str);
    
        //LEFT SIDE: INCREMANT ROW COUNT
        $("#hidden_rowcount").val(parseFloat($("#hidden_rowcount").val())+1);
        failed.currentTime = 0;
        failed.play();
        //CALCULATE FINAL TOTAL AND OTHER OPERATIONS
        //final_total();
    
        make_subtotal(item_id,rowcount);
        calculate_payments();

    

  }

  
function update_price(row_id,item_cost){

  //Input
  /*var sales_price=$("#sales_price_"+row_id).val().trim();
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

  //Default set from item master
  var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

  if(sales_price<item_cost){
    //toastr["warning"]("Minimum Sales Price is "+item_cost);
    $("#sales_price_"+row_id).parent().addClass('has-error');
  }else{
    $("#sales_price_"+row_id).parent().removeClass('has-error');
  }*/

  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
  calculate_payments();
  
}

function set_to_original(row_id,item_cost) {
  return true;
  /*Input*/
  var sales_price=$("#sales_price_"+row_id).val().trim();
  if(sales_price!='' || sales_price==0) {sales_price = parseFloat(sales_price); }

  /*Default set from item master*/
  var item_price=parseFloat($("#tr_sales_price_temp_"+row_id).val().trim());

  if(sales_price<item_cost){
    toastr["success"]("Default Price Set "+item_price);
    $("#sales_price_"+row_id).parent().removeClass('has-error');
    $("#sales_price_"+row_id).val(item_price);
  }
  make_subtotal($("#tr_item_id_"+row_id).val(),row_id);
}



//INCREMENT ITEM
function increment_qty(item_id,rowcount){
  var item_qty=$("#item_qty_"+rowcount+"_"+item_id).val();
  var stock=$("#td_"+rowcount+"_1").html();
    
    new_item_qty=parseFloat(item_qty)+1;
    $("#item_qty_"+rowcount+"_"+item_id).val(parseFloat(new_item_qty).toFixed(0));
  /*if(parseFloat(item_qty)<parseFloat(stock)){
    new_item_qty=parseFloat(item_qty)+1;

    if(parseFloat(new_item_qty)>parseFloat(stock)){
      new_item_qty = stock;
    }

    $("#item_qty_"+item_id).val(parseFloat(new_item_qty).toFixed(0));
  }*/
  make_subtotal(item_id,rowcount);
  calculate_payments();
}
//DECREMENT ITEM
function decrement_qty(item_id,rowcount){
  var item_qty=parseFloat($("#item_qty_"+rowcount+"_"+item_id).val());
      item_qty = isNaN(item_qty) ? 0 : item_qty;
  var stock= parseFloat($("#td_"+rowcount+"_1").html());
      stock = isNaN(stock) ? 0 : stock;

  if(item_qty<1){
     $("#item_qty_"+rowcount+"_"+item_id).val((item_qty).toFixed(0));
     toastr["warning"]("Đặt tối thiểu là 1 hoặc xóa!");
     return;
  }
  if(item_qty<=1){
    $("#item_qty_"+rowcount+"_"+item_id).val((1).toFixed(0));
    toastr["warning"]("Đặt tối thiểu là 1 hoặc xóa!");
    return;
  }
  
  $("#item_qty_"+rowcount+"_"+item_id).val((parseFloat(item_qty)-1).toFixed(0));
  make_subtotal(item_id,rowcount);
  calculate_payments();
}
//LEFT SIDE: IF ITEM QTY CHANGED MANUALLY
function getPrices(rowcount, item_id) {
    var aPrice = document.getElementById("setPrices_"+rowcount).value;
    document.getElementById("sales_price_"+rowcount).value = aPrice;
    item_qty_input(item_id,rowcount);
}
function item_qty_input(item_id,rowcount){
  var item_qty=$("#item_qty_"+rowcount+"_"+item_id).val();
  var stock=$("#td_"+rowcount+"_1").html();
  if(stock==0){
    toastr["warning"]("item Not Available in stock!");
    //return;  
  }
  if(parseFloat(item_qty)>parseFloat(stock)){
    $("#item_qty_"+rowcount+"_"+item_id).val(stock);
    toastr["warning"]("Oops! You have only "+stock+" items in Stock");
   // return;
  }
  if(item_qty==0){
    $("#item_qty_"+rowcount+"_"+item_id).val(1);
    toastr["warning"]("You must have atlease one Quantity");
    //return; 
  }
  /*else{
    $("#item_qty_"+item_id).val(1);
    toastr["warning"]("You must have atlease one Quantity");
    return; 
  }*/
  make_subtotal(item_id,rowcount);
}

function zero_stock(){
  toastr["error"]("Hết hàng!");
  return;
}
//LEFT SIDE: REMOVE ROW 
function removerow(id){//id=Rowid  
    $("#row_"+id).remove();
    $("#tr_items_name_"+id).remove();
     $("#tr_items_desc_"+id).remove();
    failed.currentTime = 0;
    failed.play();
    final_total();
    calculate_payments();
}

//MAKE SUBTOTAL
function make_subtotal(item_id,rowcount){
  set_tax_value(rowcount);

   //Find the Tax type and Tax amount
   var tax_type = $("#tr_tax_type_"+rowcount).val();
   var tax_amount = $("#td_data_"+rowcount+"_11").val();

  var sales_price     =$("#sales_price_"+rowcount).val();
  //var gst_per         =$("#tr_item_per_"+rowcount).val();
  
  var item_qty        =$("#item_qty_"+rowcount+"_"+item_id).val();
  

  var tot_sales_price =parseFloat(item_qty)*parseFloat(sales_price);
  //var gst_amt=(tot_sales_price * gst_per)/100;

  var subtotal        =parseFloat(tot_sales_price);
  /*Discounr*/
  var discount_amt    =$("#item_discount_"+rowcount).val();

  subtotal = (tax_type=='Inclusive') ? subtotal : parseFloat(subtotal) + parseFloat(tax_amount);

  subtotal -= parseFloat(discount_amt);
  
  $("#td_data_"+rowcount+"_4").val(parseFloat(subtotal).toFixed(0));
  final_total();
}

function calulate_discount(discount_input,discount_type,total){
  if(discount_type=='in_percentage'){
    return parseFloat((total*discount_input)/100);
  }
  else{//in_fixed
    return parseFloat(discount_input);
  }
}
//LEFT SIDE: FINAL TOTAL
function final_total(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  var other_charges=parseFloat($("#other_charges").val());
      other_charges = (isNaN(other_charges)) ? parseFloat(0) :other_charges;

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
       // set_tax_value(i);
      //var tax_amt = parseFloat($("#td_data_"+i+"_11").val());
      item_id=$("#tr_item_id_"+i).val();
      
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(0);
      //console.log("==>total="+total);
      //console.log("==>tax_amt="+tax_amt);
     // total+=tax_amt;
      //console.log("==>total="+total);
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+i+"_"+item_id).val()).toFixed(0);
      //console.log('non reward :' +item_qty);
      }
    }//for end
  }//items_table
  
  total+=other_charges;
  total =round_off(total);
  
  var discount_amt=0;
  if(total>0){
    var discount_amt=calulate_discount(discount_input,discount_type,total);//return value 
  }


  set_total(item_qty,total,discount_amt,total-discount_amt);
}
function final_total_reward(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  var other_charges=parseFloat($("#other_charges").val());
      other_charges = (isNaN(other_charges)) ? parseFloat(0) :other_charges;

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
       // set_tax_value(i);
      //var tax_amt = parseFloat($("#td_data_"+i+"_11").val());
      item_id=$("#tr_item_id_"+i).val();
      
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(0);
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+i+"_"+item_id).val()).toFixed(0);
      console.log('reward :' +item_id);
      }
    }//for end
  }//items_table
  
  total+=other_charges;
  total =round_off(total);
  
  var discount_amt=0;
  if(total>0){
    var discount_amt=calulate_discount(discount_input,discount_type,total);//return value 
  }


  set_total(item_qty,total,discount_amt,total-discount_amt);
}
function set_total(tot_qty=0, tot_amt=0, tot_disc=0, tot_grand=0){
  $(".tot_qty   ").html(tot_qty);
  $(".tot_amt   ").html((round_off(tot_amt).toFixed(0)));
  $(".tot_disc  ").html((round_off(tot_disc).toFixed(0)));
  $(".tot_grand ").html((round_off(tot_grand)).toFixed(0));
}

//LEFT SIDE: FINAL TOTAL
function adjust_payments(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  var other_charges=parseFloat($("#other_charges").val());
      other_charges = (isNaN(other_charges)) ? parseFloat(0) :other_charges;

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(0);
      item_id=$("#tr_item_id_"+i).val();
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+i+"_"+item_id).val()).toFixed(0);
      }
    }//for end
  }//items_table
  total +=other_charges;
  total =round_off(total);
  //Find customers payment

  var payments_row =get_id_value("payment_row_count");
  //console.log("payments_row="+payments_row);
  var paid_amount =parseFloat(0);
  for (var i = 1; i <=payments_row; i++) {
    if(document.getElementById("amount_"+i)){
      var amount = parseFloat(get_id_value("amount_"+i));
          amount = isNaN(amount) ? 0 : amount;
          //console.log("amount_"+i+"="+amount);
      paid_amount += amount;
    }
  }
  
  //RIGHT SIDE DIV
  var discount_amt=calulate_discount(discount_input,discount_type,total);//return value


  var change_return = 0;
  var balance = total-discount_amt-paid_amount;
  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  $(".sales_div_tot_qty  ").html(Intl.NumberFormat().format(item_qty));
  $(".sales_div_tot_qty  ").attr('data-tot-qty', item_qty);
  $(".sales_div_tot_amt  ").html(Intl.NumberFormat().format(total));//Intl.NumberFormat().format(price)
  $(".sales_div_tot_amt  ").attr('data-tot-amt', total);
  $(".sales_div_tot_discount ").html(Intl.NumberFormat().format(discount_amt)); 
  $(".sales_div_tot_discount  ").attr('data-tot-discount', discount_amt);
  $(".sales_div_tot_payble ").html(Intl.NumberFormat().format(total-discount_amt)); 
  $(".sales_div_tot_payble  ").attr('data-tot-payble', total-discount_amt);
  $(".sales_div_tot_paid ").html(Intl.NumberFormat().format(paid_amount));
  $(".sales_div_tot_paid ").attr('data-paid-amount', paid_amount);
  $(".sales_div_tot_balance ").html(Intl.NumberFormat().format(balance)); 
  $(".sales_div_other_charges ").html(Intl.NumberFormat().format(other_charges));
    /*$(".sales_div_tot_qty  ").html(item_qty);
  $(".sales_div_tot_amt  ").html((round_off(total)).toFixed(0));
  $(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(0)); 
  $(".sales_div_tot_payble ").html((parseFloat(round_off(total-discount_amt))).toFixed(0)); 
  $(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(0));
  $(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(0)); */

  
  /**/
  $(".sales_div_change_return ").html((change_return).toFixed(0)); 
  
}

function adjust_payments2(){
  var total=0;
  var item_qty=0;
  var rowcount=$("#hidden_rowcount").val();
  var discount_input=$("#discount_input").val();
  var discount_type=$("#discount_type").val();
  var other_charges=parseFloat($("#other_charges").val());
      other_charges = (isNaN(other_charges)) ? parseFloat(0) :other_charges;

  if($(".items_table tr").length>1){
    for(i=0;i<rowcount;i++){
      if(document.getElementById('tr_item_id_'+i)){
      total=parseFloat(total)+ + +parseFloat($("#td_data_"+i+"_4").val()).toFixed(0);
      item_id=$("#tr_item_id_"+i).val();
      item_qty=parseFloat(item_qty)+ + +parseFloat($("#item_qty_"+i+"_"+item_id).val()).toFixed(0);
      }
    }//for end
  }//items_table
  total +=other_charges;
  total =round_off(total);
  //Find customers payment

  var payments_row =get_id_value("payment_row_count");
  console.log("payments_row="+payments_row);
  var paid_amount =parseFloat(0);
  for (var i = 1; i <=payments_row; i++) {
    if(document.getElementById("amount_"+i)){
      var amount = parseFloat(get_id_value("amount_"+i));
          amount = isNaN(amount) ? 0 : amount;
          console.log("amount_"+i+"="+amount);
      paid_amount += amount;
    }
  }
  
  //RIGHT SIDE DIV
  var discount_amt=calulate_discount(discount_input,discount_type,total);//return value


  var change_return = 0;
  var balance = total-discount_amt-paid_amount;
  if(balance < 0){
    //console.log("Negative");
    change_return = Math.abs(parseFloat(balance));
    balance = 0;
  }
  
  balance =round_off(balance);
  $(".sales_div_tot_qty  ").html(Intl.NumberFormat().format(item_qty));
  $(".sales_div_tot_amt  ").html(Intl.NumberFormat().format(total));//Intl.NumberFormat().format(price)
  $(".sales_div_tot_discount ").html(Intl.NumberFormat().format(discount_amt)); 
  $(".sales_div_tot_payble ").html(Intl.NumberFormat().format(total-discount_amt)); 
  $(".sales_div_tot_paid ").html(Intl.NumberFormat().format(paid_amount));
  $(".sales_div_tot_paid ").attr('data-paid-amount', paid_amount);
  $(".sales_div_tot_balance ").html(Intl.NumberFormat().format(balance)); 
    /*$(".sales_div_tot_qty  ").html(item_qty);
  $(".sales_div_tot_amt  ").html((round_off(total)).toFixed(0));
  $(".sales_div_tot_discount ").html((parseFloat(round_off(discount_amt))).toFixed(0)); 
  $(".sales_div_tot_payble ").html((parseFloat(round_off(total-discount_amt))).toFixed(0)); 
  $(".sales_div_tot_paid ").html((round_off(paid_amount)).toFixed(0));
  $(".sales_div_tot_balance ").html((parseFloat(round_off(balance))).toFixed(0)); */

  
  /**/
  $(".sales_div_change_return ").html((change_return).toFixed(0)); 
  
}

function check_same_item(item_id){

  if($(".items_table tr").length>1){
    var rowcount=$("#hidden_rowcount").val();
    for(i=0;i<=rowcount;i++){
            if($("#tr_item_id_"+i).val()==item_id){
              increment_qty(item_id,i);
              failed.currentTime = 0;
              failed.play();
              return false;
            }
      }//end for
  }
  return true;
}

$(document).ready(function(){
  //FIRST TIME: LOAD
  //get_details();
  //alert($("section").height());//600+
  //alert($(".items_table").height());//29.76
  //alert($(".content-wrapper").height());//629
  get_details_lv(-1);

  var first_div= parseFloat($(".content-wrapper").height());
  var second_div= parseFloat($("section").height());
  var items_table= parseFloat($(".items_table").height());
  $(".items_table").parent().css("height",(first_div-second_div)+items_table+250);/**/
  $(".search_div").parent().css("height",((second_div-items_table)>500) ? 500 : (second_div-items_table) );/**/


  //FIRST TIME: SET TOTAL ZERO
  set_total();

  //RIGHT DIV: FILTER INPUT BOX
  $("#search_it").on("keyup",function(){
    search_it();
  });

 //CATEGORY WISE ITEM FETCH FROM SERVER
  var show_only_searched=true;
  $("#category_id,#brand_id").on("change",function () {
      var pLV = $("#priceLevel").attr("data-priceLevel");
      get_details_lv(pLV,show_only_searched);
      //get_details(null,show_only_searched);
  });

  $("#item_name").on("keyup",function () {
      var pLV = $("#priceLevel").attr("data-priceLevel");
      get_details_lv(pLV,show_only_searched);
      //get_details(null,show_only_searched);
  });

  //DISCOUNT UPDATE
  $(".discount_update").on("click",function () {
      final_total();
      $('#discount-modal').modal('toggle');    
  });



  //RIGHT SIDE: CLEAR SEARCH BOX
 /* $(".show_all").on("click",function(){
    $("#search_it").val('').trigger("keyup");
    $("#category_id").val('').trigger("change");
  });*/

  //Reset Category & brand
  $(".reset_categories").on("click",function(){
      $("#category_id").val('').trigger("change");
  });
  $(".reset_brands").on("click",function(){
      $("#brand_id").val('').trigger("change");
  });
  $(".reset_item_name").on("click",function(){
      $("#item_name").val('');
      $("#brand_id").val('').trigger("change");
      
      
  });


  //UPDATE PROCESS START
 <?php if(isset($sales_id) && !empty($sales_id)){ ?>

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.get("<?php echo $base_url ?>pos/fetch_sales/<?php echo $sales_id ?>",{},function(result){
     // console.log(result);
      result=result.split("<<<###>>>");
      $('#pos-form-tbody').append(result[0]);
      //$('#pos-form-tbody-modal').append(result[0]);
      $('#discount_input').val(result[1]);
      $('#discount_type').val(result[2]);
      //$('#customer_id').val(result[3]).select2();
      $('#temp_customer_id').val(result[3]);
      $('#other_charges').val(result[4]);
      $('#sales_date').val(result[5]);
      $("#hidden_rowcount").val(parseFloat($(".items_table tr").length)-1);
      
      $(".overlay").remove();
      //$("#customer_id").trigger("change");
      if(result[5]==1){
        $( "#binvoice" ).prop( "checked", true );
        $('#binvoice').parent('div').addClass('checked');
      }

      final_total();
      adjust_payments();

    });
      //DISABLE THE HOLD BUTTON
      $("#hold_invoice,#show_cash_modal").attr('disabled',true).removeAttr('id');

 <?php } ?>
  //UPDATE PROCESS END

 // hold_invoice_list();
});//ready() end


function get_item_details(item_id){

  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $.post("<?php echo $base_url; ?>pos/get_item_details",{item_id:item_id},function(result){
    //console.log(result);
    var item = jQuery.parseJSON(result);

    var obj = {};
    obj['item_id']        = item['id'];
    obj['item_name']      = item['item_name'];
    obj['stock']          = item['stock'];
    obj['sales_price']    = item['sales_price'];
    
    
    
    obj['purchase_price'] = item['purchase_price'];
    obj['tax_id']         = item['tax_id'];
    obj['tax_type']       = item['tax_type'];
    obj['tax']            = item['tax'];
    obj['tax_name']       = item['tax_name'];
    obj['item_tax_amt']   = item['item_tax_amt'];
    obj['discount_type']  = item['discount_type'];
    obj['discount']       = item['discount'];
    addrow(null,obj);
    $(".overlay").remove();
  });

}

function get_item_details_lv(item_id, item_lv){

  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  $.post("<?php echo $base_url; ?>pos/get_item_details",{item_id:item_id},function(result){
    //console.log(result);
    var item = jQuery.parseJSON(result);

    var obj = {};
    obj['item_id']        = item['id'];
    obj['item_name']      = item['item_name'];
    obj['stock']          = item['stock'];
    
    switch (item_lv) {
        case 0:
            obj['sales_price']    = item['final_price0'];break;
        case 1:
            obj['sales_price']    = item['final_price1'];break;
        case 2:
            obj['sales_price']    = item['final_price2'];break;
        case 3:
            obj['sales_price']    = item['final_price3'];break;
        default:
            obj['sales_price']    = item['final_price'];
    }
    
    
    obj['purchase_price'] = item['purchase_price'];
    obj['tax_id']         = item['tax_id'];
    obj['tax_type']       = item['tax_type'];
    obj['tax']            = item['tax'];
    obj['tax_name']       = item['tax_name'];
    obj['item_tax_amt']   = item['item_tax_amt'];
    obj['discount_type']  = item['discount_type'];
    obj['discount']       = item['discount'];
    addrow(null,obj);
    $(".overlay").remove();
  });

}

$('#item_search').keypress(function (e) {
 var key = e.which;
 // the enter key code
 if(key == 13){
    $("#item_search").autocomplete('search');
  }
});  

$("#item_search").bind("paste", function(e){
    $("#item_search").autocomplete('search');
} );

$("#item_search").autocomplete({

    source: function(data, cb){
        $.ajax({
          autoFocus:true,
            url: $("#base_url").val()+'items/get_json_items_details',
            method: 'GET',
            dataType: 'json',

            showHintOnFocus: true,
            autoSelect: true, 
            selectInitial :true,
      
            data: {
                name: data.term,
                /*warehouse_id:$("#warehouse_id").val().trim(),*/
            },
            success: function(res){
              //console.log(res);
                var result;
                result = [
                    {
                        //label: 'No Records Found '+data.term,
                        label: 'Không có dữ liệu ',
                        value: ''
                    }
                ];

                if (res.length) {
                  
                    result = $.map(res, function(el){
                        return {
                            //label: el.item_code +'--[SL:'+el.stock+'] --'+ el.label,
                            label: el.label +' ('+el.stock+')',
                            value: '',
                            id: el.id,
                            item_name: el.value,
                            stock: el.stock,
                           // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,

                        };

                    });
                }
                cb(result);
            }
        });
    },

        response:function(e,ui){
          if(ui.content.length==1){
            $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
            $(this).autocomplete("close");
          }
          //console.log(ui.content[0].id);
        },
        //loader start
        search: function (e, ui) {
          
        },
        select: function (e, ui) { 
         // console.log('inside select');
            //$("#mobile").val(ui.item.mobile)
            //$("#item_search").val(ui.item.value);
            //$("#customer_dob").val(ui.item.customer_dob)
            //$("#address").val(ui.item.address)

            //console.log("stock="+$(this).val()); //Input box value

            if(typeof ui.content!='undefined'){
              //console.log("Autoselected first");
              if(isNaN(ui.content[0].id)){
                return;
              }
              var stock=ui.content[0].stock;
              var item_id=ui.content[0].id;

            }
            else{
              //console.log("manual Selected");
              var stock=ui.item.stock;
              var item_id=ui.item.id;
            }
            
            /*if(parseFloat(stock)==0){
              toastr["error"]("Out of Stock!");
              $("#item_search").val('');
              return;
            }*/
            //addrow(item_id);
            get_item_details(item_id);
            $("#item_search").val('');
            
            
        },   
        //loader end
});


//DATEPICKER INITIALIZATION
$('#order_date,#delivery_date,#cheque_date').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy',
      todayHighlight: true
    });
    $('#customer_dob,#birthday_person_dob').datepicker({
      calendarWeeks: true,
      todayHighlight: true,
      autoclose: true,
      format: 'dd-mm-yyyy',
      startView: 2
    });
    
    //Datemask dd-mm-yyyy
    //$("#customer_dob,#birthday_person_dob").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

    //Timepicker
    /*$('.timepicker').timepicker({
      showInputs: false,
    });*/

    //Sale Items Modal Operations Start
    function show_sales_item_modal(row_id){
      $('#sales_item').modal('toggle');
      //$("#popup_tax_id").select2();

      //Find the item details
      var item_name = $("#td_data_"+row_id+"_0").html();
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
      $("#popup_row_id").val(row_id);
      $("#popup_description").val(description);
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
      $("#description_"+row_id).val(description);
      $("#tr_tax_value_"+row_id).val(tax);//%
      //$("#td_data_"+row_id+"_12").html(tax_type+" "+tax_name);
      
      var item_id=$("#tr_item_id_"+row_id).val();
      make_subtotal(item_id,row_id);
      //calculate_tax(row_id);
      $('#sales_item').modal('toggle');
    }
    function set_tax_value(row_id){
      //get the sales price of the item
      var tax_type = $("#tr_tax_type_"+row_id).val();
      var tax = $("#tr_tax_value_"+row_id).val(); //%
      var item_id=$("#tr_item_id_"+row_id).val();
      var qty=($("#item_qty_"+row_id+"_"+item_id).val());
          qty = (isNaN(qty)) ? 0 :qty;

      var sales_price = parseFloat($("#sales_price_"+row_id).val());
          sales_price = (isNaN(sales_price)) ? 0 :sales_price;
          sales_price = sales_price * qty;

      /*Discount*/
      var item_discount_type = $("#item_discount_type_"+row_id).val();
      var item_discount_input = parseFloat($("#item_discount_input_"+row_id).val());
          item_discount_input = (isNaN(item_discount_input)) ? 0 :item_discount_input;
      
      //Calculate discount      
      var discount_amt=(item_discount_type=='Percentage') ? ((sales_price) * item_discount_input)/100 : (item_discount_input*qty);
     
      sales_price-=parseFloat(discount_amt);

      var tax_amount = (tax_type=='Inclusive') ? calculate_inclusive(sales_price,tax) : calculate_exclusive(sales_price,tax);
      
      $("#item_discount_"+row_id).val(discount_amt);
      $("#td_data_"+row_id+"_11").val(tax_amount);
    }
    //Sale Items Modal Operations End


</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script type="text/javascript">
 

  shortcut.add("Ctrl+Shift+m",function(e) {
        e.preventDefault();
        $(".show_payments_modal").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });

  shortcut.add("Ctrl+Shift+h",function(e) {
        e.preventDefault();
        $("#hold_invoice").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });
  shortcut.add("Ctrl+Shift+c",function(e) {
        e.preventDefault();
        $(".shift_c").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });
  shortcut.add("Ctrl+Shift+a",function(e) {
        e.preventDefault();
        $(".shift_a").trigger('click');
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });

  shortcut.add("Ctrl+Shift+s",function(e) {
        e.preventDefault();
        $("#item_search").focus();
    },{
        'type':'keydown',
        'propagate':true,
        'target':document
      });

</script>
<script>

//Reset Tooltip
function reset_tooltip() {
  $('[data-toggle="tooltip"]').tooltip("destroy");
  $('[data-toggle="tooltip"]').tooltip(); // re-enabling 
}
$('.search_div').on('scroll', function() {
    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
        load_next_details();      
    }
});

function load_next_details(){
  var last_id = $(".item_box:last").attr("data-item-id");
  var pLV = $("#priceLevel").attr("data-priceLevel");
  get_details_lv(pLV,last_id);
}



function get_details(last_id='',show_only_searched=false){
  $.ajax({
      url: '<?php echo $base_url; ?>pos/get_details',
      type: "post",
      data:{
        last_id       : (!show_only_searched) ? last_id : '',
        id            : $("#category_id").val(),
        item_name  : $("#item_name").val(),
        brand_id  : $("#brand_id").val(),
      },
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      
      if(data=='') {
        $(".error_div").show();
      }
      else{
        $(".error_div").hide();
      }


      if(show_only_searched){
        $(".search_div").html('');
      }
      $(".search_div").append(data);
      reset_tooltip();
  }).fail(function(jqXHR, ajaxOptions, thrownError){
      alert('server not responding...');
  });
}
function get_details_lv(lv='',reload=0,last_id='',show_only_searched=false,reload_items_row=false){
    //$('.ajax-load').remove();
     
  $.ajax({
      url: '<?php echo $base_url; ?>pos/get_details_lv/' + lv,
      type: "post",
      data:{
        last_id       : (!show_only_searched) ? last_id : '',
        id            : $("#category_id").val(),
        item_name  : $("#item_name").val(),
        brand_id  : $("#brand_id").val(),
      },
      beforeSend: function(){
          $('.ajax-load').show();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      
      if(data=='') {
        $(".error_div").show();
      }
      else{
        $(".error_div").hide();
      }


      if(show_only_searched){
        $(".search_div").html('');
      }
      
      /*if(reload == 1){ 
          $(".search_div").html(data);
      } else {
           $(".search_div").append(data);
      }*/
      
      $(".search_div").html(data);
      
      
      
      
      
      reset_tooltip();
  }).fail(function(jqXHR, ajaxOptions, thrownError){
      alert('server not responding...');
  });
}
</script> 
<script type="text/javascript">
  function print_invoice(id){
  window.open("https://pos.sieuthithuysinh.com/pos/print_invoice_temp/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
</script> 
</body>
</html>
