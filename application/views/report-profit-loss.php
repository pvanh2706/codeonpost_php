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
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Trang chủ</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-header">
            
           <div class="form-group">
             <label for="to_date" class="col-sm-2 control-label">Lựa chọn khoảng thời gian</label>
                <div class="col-sm-3">
                <div class="input-group">
                   <button type="button" class="btn btn-default pull-right " id="pl-daterange-btn" name="pl-daterange-btn">
                   <span>
                   <i class="fa fa-calendar"></i> Select Date Range
                   </span>
                   <i class="fa fa-caret-down"></i>
                   </button>
                </div>
             </div>
             <span id="sku_msg" style="display:none" class="text-danger"></span>
          </div>
          
          </div>
        </div>
        <!-- left column -->
                    <div class="col-md-12">
                     <div class="box">
                        <div class="box-header">
                           <?php $this->load->view('components/export_btn',array('tableId' => 'report-data-2'));?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover " id="report-data-2" >
                              <!-- Total Gross Profit -->
                              <tr>
                                 <td>Tổng lợi nhuận trừ vốn</td>
                                 <td class="text-right text-bold gross_profit"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Net Profit -->
                              <tr>
                                 <td>Lợi nhuận ròng (Đã trừ chi phí)</td>
                                 <td class="text-right text-bold tot_net_profit"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                           </table>
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                  </div>
                    <div class="col-md-6">
                     <div class="box">
                        <div class="box-header">
                           <?php $this->load->view('components/export_btn',array('tableId' => 'report-data'));?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover " id="report-data" >
                              <!-- Total Opening Stock -->
                              <tr>
                                 <td>Tổng vốn tồn kho</td>
                                 <td class="text-right text-bold opening_stock_price"><?php echo $CI->currency(number_format(0,0,'.','')); ?></td>
                              </tr>
                              <tr>
                                 <td colspan="2" class="text-bold font-italic text-primary">Nhập hàng</td>
                              </tr>
                              <!-- Total Purchase -->
                              <tr>
                                 <td>Tổng nhập hàng</td>
                                 <td class="text-right text-bold pur_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Tax -->
                              <tr>
                                 <td>Tổng thuế nhập</td>
                                 <td class="text-right text-bold purchase_tax_amt"><?php echo $CI->currency(number_format((0),2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Other Charges -->
                              <tr>
                                 <td>Tổng phụ phí nhập</td>
                                 <td class="text-right text-bold pur_other_charges_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Doscount -->
                              <tr>
                                 <td>Tổng chiếc khấu nhập</td>
                                 <td class="text-right text-bold purchase_discount_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Paid Amount -->
                              <tr>
                                 <td>Tổng nhập đã thanh toán</td>
                                 <td class="text-right text-bold text-success purchase_paid_amount"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Due -->
                              <tr>
                                 <td>Tổng nợ nhập chưa thanh toán</td>
                                 <td class="text-right text-bold text-danger purchase_due_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <tr>
                                 <td colspan="2" class="text-bold font-italic text-primary">Trả hàng nhập</td>
                              </tr>
                              <!-- Total Purchase Return -->
                              <tr>
                                 <td>Tổng trả hàng nhập</td>
                                 <td class="text-right text-bold pur_return_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase return Tax -->
                              <tr>
                                 <td>Tổng thuế trả hàng nhập</td>
                                 <td class="text-right text-bold purchase_return_tax_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase return Other Charges -->
                              <tr>
                                 <td>Tổng phụ phí trả hàng nhập</td>
                                 <td class="text-right text-bold pur_return_other_charges_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase return Doscount -->
                              <tr>
                                 <td>Tổng chiếc khấu trả hàng nhập</td>
                                 <td class="text-right text-bold purchase_return_discount_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase Return Paid Amount -->
                              <tr>
                                 <td>Tổng trả hàng nhập đã thanh toán</td>
                                 <td class="text-right text-bold text-success purchase_return_paid_amount"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Purchase returns Due -->
                              <tr>
                                 <td>Tổng nợ trả hàng chưa thanh toán</td>
                                 <td class="text-right text-bold text-danger purchase_return_due_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                           </table>
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                    </div>
                    <div class="col-md-6">
                     <div class="box">
                        <div class="box-header">
                           <?php $this->load->view('components/export_btn',array('tableId' => 'report-data-4'));?>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                           <table class="table table-bordered table-hover " id="report-data-4" >
                              <!-- Total Expenses -->
                              <tr>
                                 <td>Tổng chi phí vận hành</td>
                                 <td class="text-right text-bold exp_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <tr>
                                 <td colspan="2" class="text-bold font-italic text-primary">Bán hàng</td>
                              </tr>
                              <!-- Total Sales -->
                              <tr>
                                 <td>Tổng số đơn hàng</td>
                                 <td class="text-right text-bold sal_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Tax -->
                              <tr>
                                 <td>Tổng thuế đơn hàng</td>
                                 <td class="text-right text-bold sales_tax_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Other Charges -->
                              <tr>
                                 <td>Tổng phụ phí đơn hàng</td>
                                 <td class="text-right text-bold sal_other_charges_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Doscount -->
                              <tr>
                                 <td>Tổng chiếc khấu đơn hàng</td>
                                 <td class="text-right text-bold sales_discount_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Paid Amount -->
                              <tr>
                                 <td>Tổng đơn hàng đã thanh toán</td>
                                 <td class="text-right text-bold text-success sales_paid_amount"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Due -->
                              <tr>
                                 <td>Tổng nợ đơn hàng chưa thanh toán</td>
                                 <td class="text-right text-bold text-danger sales_due_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <tr>
                                 <td colspan="2" class="text-bold font-italic text-primary">Trả hàng bán</td>
                              </tr>
                              <!-- Total sales Return -->
                              <tr>
                                 <td>Tổng đơn trả hàng</td>
                                 <td class="text-right text-bold sal_return_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total sales return Tax -->
                              <tr>
                                 <td>Tổng thuế đơn trả hàng</td>
                                 <td class="text-right text-bold sales_return_tax_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales return Other Charges -->
                              <tr>
                                 <td>Tổng phụ phí đơn trả hàng</td>
                                 <td class="text-right text-bold sal_return_other_charges_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales return Doscount -->
                              <tr>
                                 <td>Tổng chiếc khấu đơn trả hàng</td>
                                 <td class="text-right text-bold sales_return_discount_amt"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales return Paid Amount -->
                              <tr>
                                 <td>Tổng đơn trả hàng đã hoàn tiền</td>
                                 <td class="text-right text-bold text-success sales_return_paid_amount"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                              <!-- Total Sales Return Due -->
                              <tr>
                                 <td>Tổng đơn trả hàng chưa hoàn tiền</td>
                                 <td class="text-right text-bold text-danger sales_return_due_total"><?php echo $CI->currency(number_format(0,2,'.','')); ?></td>
                              </tr>
                           </table>
                        </div>
                        <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                  </div>
                  <!-- right column -->
                  
       
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'profit-loss-report', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">      
        <div class="form-group">
                <label for="to_date" class="col-sm-2 control-label">Lựa chọn khoảng thời gian</label>
                <div class="col-sm-3">
                <div class="input-group">
                  <button type="button" class="btn btn-default pull-right daterange-btn" name="pl2-daterange-btn" id="pl2-daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Select Date Range
                    </span>
                    <i class="fa fa-caret-down"></i>
                  </button>
                </div>
              </div>
           
        <!-- Your Code -->
                </div> 
          <?= form_close(); ?>

             

            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                  
                  <div class="col-md-12">
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab">Sản phẩm</a></li>
                           <li><a href="#tab_2" data-toggle="tab">Đơn hàng</a></li>
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                       <?php $this->load->view('components/export_btn',array('tableId' => 'profit_by_item_table'));?>
                                          <br><br>
                                          <div class="table-responsive">
                                          <table class="table table-bordered table-hover " id="profit_by_item_table" >
                                              <thead>
                                              <tr class='bg-blue'>
                                                <th style="">#</th>
                                                <th style="">Sản phẩm</th>
                                                <th style="">Số lượng bán</th>
                                                <th style="">Tổng giá bán</th>
                                                <th style="">Giá nhập</th>
                                                <th style="">Lợi nhuận</th>
                                                <!-- <th style=""><?= $this->lang->line('purchase_return_quantity'); ?></th>
                                                <th style=""><?= $this->lang->line('purchase_return_price'); ?>(+)</th>
                                                <th style=""><?= $this->lang->line('sales_return_quantity'); ?></th>
                                                <th style=""><?= $this->lang->line('sales_return_price'); ?>(-)</th> -->
                                                <!-- <th style=""><?= $this->lang->line('net_profit'); ?></th> -->
                                              </tr>
                                              </thead>
                                              <tbody id="tbodyid">
                                              
                                              </tbody>
                                            </table>
                                          </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                          
                           <div class="tab-pane" id="tab_2">
                              <!--div class="row">
                                 <div class="col-md-12">
                                       
                                         <div class="alert alert-info text-left">
                                            <p>
                                             <strong>Long đẹp trai:</strong>
                                             Báo cáo này bỏ qua phần chiếc khấu của đơn hàng nha ông, tại chưa biết tính sao cho tối ưu
                                             <Item Wise & Invoice wise Reports total Gross Profit may worries,
                                             Invoice wise Report deducts Discount on Invoice.>
                                           </p>
                                         </div>
                                       </div>
                                 </div-->

                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                                          <?php $this->load->view('components/export_btn',array('tableId' => 'profit_by_invoice_table'));?>

                                          <br><br>
                                          <div class="table-responsive">
                                          <table class="table table-bordered table-hover " id="profit_by_invoice_table" >
                                              <thead>
                                              <tr class='bg-blue'>
                                                <th style="">#</th>
                                                <th style="">Mã hóa đơn</th>
                                                <th style="">Ngày bán</th>
                                                <th style="">Khách hàng</th>
                                                <th style="">Tổng đơn</th>
                                                <th style="">Giá trị nhập</th>
                                                <th style="">Chiếc khấu</th>
                                                <th style="">Lợi nhuận</th>
                                                
                                              </tr>
                                              </thead>
                                              <tbody id="tbodyid">
                                              
                                              </tbody>
                                            </table>
                                          </div>
                                       <!-- /.box-body -->
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
                  </div>
                  <!-- /.col -->
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      
      </div>

    </section>
  
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
<!-- TABLE EXPORT CODE -->
<?php include"comman/code_js_export.php"; ?>

<script>


function get_reports(report_type,table_name){
  $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  var base_url=$("#base_url").val();
  return $.post(base_url+'reports/'+report_type, {from_date: get_start_date('pl2-daterange-btn'), to_date: get_end_date('pl2-daterange-btn')}, function(result) {
    //console.log(result);
    $("#"+table_name+" tbody").html(result);
    $(".overlay").remove();
  });
}
function get_all_reports(){
  get_reports('get_profit_by_item','profit_by_item_table');
  get_reports('get_profit_by_invoice','profit_by_invoice_table');
}
jQuery(document).ready(function($) {
  get_pl_values();
   get_all_reports();
});

function get_pl_values(){
  var base_url=$("#base_url").val();
  $.post(base_url+"reports/get_profit_loss_report",{from_date: get_start_date('pl-daterange-btn'), to_date: get_end_date('pl-daterange-btn')},function(result){
      var data = jQuery.parseJSON(result);
      $.each(data, function(index, element) {
              $("."+index).html(element);
      });
  });
}

/*Date Range picker event 1*/
$('#pl-daterange-btn').on('apply.daterangepicker', function(ev, picker) {
    console.log("pl-daterange-btn");
  get_pl_values();
});
/*end*/
/*Date Range picker event 2*/
$('#pl2-daterange-btn').on('apply.daterangepicker', function(ev, picker) {
    console.log("pl2-daterange-btn");
  get_all_reports();
});
/*end*/

$(function() {
    //var start = moment().subtract(29, 'days');
    var start = moment();
    var end = moment();
    function cb(start, end) {
        //$('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //$('#pl-daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('.daterange-btn span').html(start.format('D-M-YYYY') + ' - ' + end.format('D-M-YYYY'));
        $('#pl-daterange-btn span').html(start.format('D-M-YYYY') + ' - ' + end.format('D-M-YYYY'));
    }
    cb(start, end);

});


//console.log('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa | ' + moment().subtract(1, 'days'));
//Date picker 1
    $('#pl-daterange-btn').daterangepicker(
      {
        ranges   : {
          'Hôm nay'       : [moment(), moment()],
          'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '07 ngày gần nhất' : [moment().subtract(6, 'days'), moment()],
          '30 ngày gần nhất': [moment().subtract(29, 'days'), moment()],
          'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
          'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        //startDate: moment().subtract(29, 'days'),
        startDate: moment(),
        endDate  : moment()
      },
      function (start, end) {
        
        $('#pl-daterange-btn span').html(start.format('<?php echo strtoupper($VIEW_DATE) ;?>') + ' - ' + end.format('<?php echo strtoupper($VIEW_DATE);?>'))
      }
    );
    
    
//End

</script>


<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
