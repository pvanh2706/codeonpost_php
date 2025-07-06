<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  

</head>
<body class="hold-transition skin-blue sidebar-mini">
    
    <?php 
                $this->load->database('default2', TRUE);
                $this->db2 = $this->load->database('default2', true);
                $transaction = $this->db2->select('*')->order_by('id', 'desc')->get('transaction')->result(); 
    ?>


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
            <div class="box box-info ">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover " id="report-data" >
                                                    <thead>
                                                        <tr class="bg-blue">
                                                          <th style="">Đơn hàng</th>
                                                          <th style="">Khách hàng</th>
                                                          <th style="">Tạm tính</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyid">
                                                        <?php foreach ($transaction as $row) : ?>
                                                                    
                                                                    <tr style="<?= ($row->status == 0) ? 'background-color: #decccf;' : 'background-color: #d4e3d2;' ?>">
                                                                        <td>Mã: <?= 'SHOPVN-0000'.$row->id ?><br>Ngày: <?= date('d/m/Y h:m:s', $row->created) ?><br>Trạng thái: <?= ($row->status == 0) ? '<span class="text-red text-bold">Chưa xử lý</span>' : '<span class="text-green text-bold">Đã xử lý</span>' ?></td>
                                                                        <td>Khách hàng: <span class="text-blue text-bold"><?= $row->user_name ?></span><br>Liên hệ: <span class="text-blue text-bold"><?= $row->user_phone ?></span><br>Địa chỉ: <span class="text-blue text-bold"><?= $row->address ?></span><br>Lời nhắn: <?= $row->message ?></td>
                                                                        <td><?= number_format($row->amount) ?>đ<br>Phí ship: <?= ($row->phi > 0) ? number_format($row->phi).'đ' : 'Liên hệ' ?><br><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#order_<?= $row->id ?>">Xem đơn hàng</button></td>
                                                                    </tr>
                                                                    
                                                                    <div class="modal fade" id="order_<?= $row->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                      <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                          <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Đơn hàng <?= 'SHOPVN-0000'.$row->id ?></h5>
                                                                          </div>
                                                                          <div class="modal-body">
                                                                                <div class="row">
                                                                                    <div class="col-xs-4">
                                                                                        Ngày: <?= date('d/m/Y h:m:s', $row->created) ?><br>
                                                                                        Tạm tính: <?= number_format($row->amount) ?>đ<br>
                                                                                        Phí ship: <?= ($row->phi > 0) ? number_format($row->phi).'đ' : 'Liên hệ' ?>
                                                                                    </div>
                                                                                    <div class="col-xs-8">
                                                                                        Khách hàng: <?= $row->user_name ?><br>
                                                                                        ĐT Liên hệ: <?= $row->user_phone ?><br>
                                                                                        Địa chỉ: <?= $row->address ?>
                                                                                        
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="col-xs-12">
                                                                                        Ghi chú: <?= $row->message ?>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                              
                                                                              <?php $orders = $this->db2->select('*')->where('transaction_id', $row->id)->get('order')->result(); ?>
                                                                              <div class="row" style="border-bottom: dotted 1px; font-weight: bold;">
                                                                                  <div class="col-xs-6">Sản phẩm</div>
                                                                                  <div class="col-xs-2">Số lượng</div>
                                                                                  <div class="col-xs-4">Thành tiền</div>
                                                                                </div>
                                                                                  <?php foreach ($orders as $rows) : ?>
                                                                                <div class="row" style="border-bottom: dotted 1px;">
                                                                                  <div class="col-xs-6"><?= $rows->product_name ?></div>
                                                                                  <div class="col-xs-2"><?= $rows->qty ?></div>
                                                                                  <div class="col-xs-4"><?= number_format($rows->amount) ?></div>
                                                                                </div>
                                                                              <?php endforeach;    ?>
                                                                              
                                                                                
                                                                          </div>
                                                                          <div class="modal-footer">
                                                                                <?php if ($row->status == 0): ?><button onClick="orderok(<?= $row->id ?>)" class="btn btn-primary">Đánh dấu đã xử lý</button><?php endif; ?>
                                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                                                              </div>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                    
                                                        <?php endforeach;    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                       <!-- /.box-body -->
                                 </div></div>
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

    function orderok(orderid) {
    
        var name = prompt('Vui lòng nhập mật khẩu cho chức năng này! MK: ok');
        if (name == 'ok') {
            var conf = confirm('Xác nhận đơn hàng này đã được xử lý?');
            if(conf === true) {
                var base_url=$("#base_url").val().trim();
                 $.ajax({
                                                                                type: "GET",
                                                                                url: base_url+'site/order_ok/'+orderid,
                                                                				success: function(result){
                                                                				    console.log(result);
                                                                					if(result=="success")
                                                                					{
                                                                						toastr["success"]("Đã xác nhận xử lý đơn hàng!");
                                                                						success.currentTime = 0; 
                                                                				  		success.play();
                                                                				  		location.reload();
                                                                					}
                                                                					else if(result=="failed")
                                                                					{
                                                                					   toastr["error"]("Đã xảy ra lỗi vui lòng thử lại!");
                                                                					   failed.currentTime = 0; 
                                                                				  	   failed.play();
                                                                					}
                                                                					else
                                                                					{
                                                                						 toastr["error"](result);
                                                                						 failed.currentTime = 0; 
                                                                				  	   	 failed.play();
                                                                					}
                                                                					return;
                                                            			        }}
                                                            			) 
            } else {
                alert ('Hẹn gặp bạn lần sau! Tôi chưa thực hiện bất cứ hành động nào đâu! yên tâm');
            }
        } else {
            alert("Sai mật khẩu rồi! bye bye bạn nhé! không tiễn!")
        }
    
    
    }




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
    var start = moment().subtract(29, 'days');
    var end = moment();
    function cb(start, end) {
        $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#pl-daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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
        startDate: moment().subtract(29, 'days'),
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
