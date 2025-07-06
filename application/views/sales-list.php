<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_datatable.php"; ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Left side column. contains the logo and sidebar -->
  
  <?php include"sidebar.php"; ?>

  <?php 
      /*Total Invoices*/
      $total_invoice=$this->db->query("SELECT COUNT(*) as total FROM db_sales")->row()->total;
      /*Total Invoices Total*/
      $sal_total=$this->db->query("SELECT COALESCE(sum(grand_total),0) AS tot_sal_grand_total FROM db_sales")->row()->tot_sal_grand_total;

      /*PAID AMOUNT*/
      $tot_received_amt=$this->db->select("COALESCE(SUM(paid_amount),0) AS paid_amount")->from("db_sales")->get()->row()->paid_amount;

      $sales_due_total=$this->db->query("SELECT COALESCE(SUM(sales_due),0) AS sales_due FROM db_customers")->row()->sales_due;
      //$sales_due_total = $sal_total - $sal_return_total;
     
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small>Thống kê tất cả các đơn bán hàng</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <div class="pay_now_modal">
    </div>
    <div class="view_payments_modal">
    </div>
    
    <!-- Order Info Modal -->
    <div class="modal fade" id="orderInfoModal" tabindex="-1" role="dialog" aria-labelledby="orderInfoModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="orderInfoModalLabel">Thông tin chi tiết đơn hàng</h4>
          </div>
          <div class="modal-body" id="orderInfoContent" style="max-height: 600px; overflow-y: auto;">
            <div class="text-center">
              <i class="fa fa-spinner fa-spin fa-2x"></i>
              <p>Đang tải dữ liệu...</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>
    </div>
    
    <style>
      .order-info-modal .panel {
        margin-bottom: 15px;
      }
      .order-info-modal .panel-heading {
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
      }
      .order-info-modal .table-condensed td {
        padding: 5px 8px;
        border: none;
      }
      .order-info-modal .table-condensed tr:nth-child(even) {
        background-color: #f9f9f9;
      }
    </style>

    <!-- Main content -->
    <?= form_open('#', array('class' => '', 'id' => 'table_form')); ?>
    <input type="hidden" id='base_url' value="<?=$base_url;?>">
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">

              <div class="row">
                <div class="col-md-12">
                <div class="col-md-2 pull-right">
                  <?php if ($CI->permissions('sales_add')) {?>
                  <div class="box-tools">
                <a class="btn btn-block btn-info" href="<?php echo $base_url; ?>sales/add">
                <i class="fa fa-plus"></i> <?=$this->lang->line('new_sales');?></a>
              </div>
                 <?php }?>
                </div>
                </div>
              </div>

              <div class="row">

                <div class="col-md-12">

                <div class="col-md-3">
                    <div class="form-group">
                       <label for="search_customer_id">Tên khách hàng </label></label>
                       <select class="form-control select2" id="search_customer_id" name="search_customer_id"  style="width: 100%;">
                     </select>
                       <span id="search_customer_id_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                       <label for="user_created_by">Sắp xếp theo trạng thái </label></label>
                       <select class="form-control select2" id="user_created_by" name="user_created_by"  style="width: 100%;">
                        <option value="">- Tất cả -</option>
                        <option value="Final">- Đã giao hàng -</option>
                        <option value="Shipping">- Đã xuất kho -</option>
                        <option value="Quotation">- Đang giao dịch -</option>
                        <option value="Paid">- Đã thanh toán -</option>
                        <option value="Unpaid">- Chưa thanh toán -</option>
                        
                        
                        
                        <?php
                                             
                           /*$query1="select * from db_users where status=1";
                           $q1=$this->db->query($query1);
                           if($q1->num_rows($q1)>0)
                              { 
                               // echo "<option value=''>-Select-</option>";
                                foreach($q1->result() as $res1)
                              {
                                echo "<option value='".$res1->username."'>".$res1->username ."</option>";
                              }
                            }*/
                           
                               ?>
                     </select>
                       <span id="user_created_by_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                       <label for="sales_from_date">Từ ngày </label></label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" class="form-control pull-right datepicker"  id="sales_from_date" name="sales_from_date" value="<?php echo date('d-m-Y', strtotime('-7 days'));?>">
                      </div>
                       <span id="sales_from_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                       <label for="sales_to_date">Đến ngày </label></label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <input type="text" class="form-control pull-right datepicker"  id="sales_to_date" name="sales_to_date" value="<?php echo show_date(date('d-m-Y'));?>">
                      </div>
                       <span id="sales_to_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  

                </div>
              </div>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped" width="100%">
                <thead class="bg-primary ">
                <tr>
                  <th class="text-center"><input type="checkbox" class="group_check checkbox" ></th>
                  
                  
                  <th>Thời gian / Người bán</th>
                  <th>Mã hóa đơn</th>
                  
                  <!--th>Mã tham chiếu</th-->
                  <th>Khách hàng</th>
                  <!-- <th>Warehouse</th> -->
                  <th>Tổng đơn</th>
                  <th>Đã thanh toán</th>
                  <th>Còn nợ</th>
                  <th>Trạng thái</th>
                  <th>Thanh toán</th>
                  <!--th>Tạo bởi</th-->
                  <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
				
                </tbody>
               <tfoot>
                  <tr class="bg-gray">
                      <th colspan="4" style="text-align:right">#</th><!-- 6 -->
                      <th></th><!-- 7 -->
                      <th></th><!-- 8 -->
                      <th></th><!-- 8 -->
                      <th></th><!-- 7 -->
                      <!--th></th--><!-- 8 -->
                      <th></th><!-- 8 -->
                      <th></th>
                  </tr>
              </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <?= form_close();?>
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
<?php include"comman/code_js_datatable.php"; ?>
<!-- bootstrap datepicker -->
<script src="<?php echo $theme_link; ?>plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  

<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: 'dd-mm-yyyy',
     todayHighlight: true
    });
</script>
<script type="text/javascript">
  //Customer Selection Box Search
      function getCustomerSelectionId() {
        return '#search_customer_id';
      }
      //Customer Selection Box Search - END


  function load_datatable(argument) {
    //datatables
   var table = $('#example2').DataTable({ 
       "pageLength": 100,

      /* FOR EXPORT BUTTONS START*/
  dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr><"pull-right margin-left-10 "B>>>tip',
 /* dom:'<"row"<"col-sm-12"<"pull-left"B><"pull-right">>> <"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',*/
      buttons: {
        buttons: [
            {
                className: 'btn bg-green color-palette btn-flat hidden paid_all_btn pull-left',
                text:'Thanh toán nợ',
                action: function ( e, dt, node, config ) {
                    multi_paid();
                }
            },
            {
                className: 'btn bg-red color-palette btn-flat hidden delete_btn pull-left',
                text: 'Xóa đơn hàng',
                action: function ( e, dt, node, config ) {
                    multi_delete();
                }
            },
            {
                className: 'btn bg-blue color-palette btn-flat hidden order_info_btn pull-left',
                text: 'Thông tin đơn hàng',
                action: function ( e, dt, node, config ) {
                    show_order_info();
                }
            },
            { extend: 'copy', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10]} },
            { extend: 'excel', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10]} },
            { extend: 'pdf', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10]} },
            { extend: 'print', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10]} },
            { extend: 'csv', className: 'btn bg-teal color-palette btn-flat',exportOptions: { columns: [1,2,3,4,5,6,7,8,9,10]} },
            { extend: 'colvis', className: 'btn bg-teal color-palette btn-flat',text:'Columns' },  

            ]
        },
        /* FOR EXPORT BUTTONS END */

        "processing": true, //Feature control the processing indicator.
        "serverSide": false, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "responsive": true,
        language: {
            processing: '<div class="text-primary bg-primary" style="position: relative;z-index:100;overflow: visible;">Đang xử lý dữ liệu...</div>'
        },
        

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('sales/ajax_list')?>",
            "type": "POST",
            "data": {
                      sales_from_date: $("#sales_from_date").val(),
                      sales_to_date: $("#sales_to_date").val(),
                      user_created_by: $("#user_created_by").val(),
                      customer_id: $("#search_customer_id").val(),
                    },
            complete: function (data) {
             $('.column_checkbox').iCheck({
                checkboxClass: 'icheckbox_square-orange',
                /*uncheckedClass: 'bg-white',*/
                radioClass: 'iradio_square-orange',
                increaseArea: '10%' // optional
              });
             call_code();
              //$(".delete_btn").hide();
             },

        },



        
        //Set column definition initialisation properties.
        "columnDefs": [
            { 
                "targets": [ 0,9], //first column / numbering column
                "orderable": false, //set not orderable
            },
            {
                "targets" :[0],
                "className": "text-center",
            },
        ],
        
        /*Start Footer Total*/
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var total = api
                .column( 4, { page: 'none'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var paid = api
                .column( 5, { page: 'none'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var due = api
                .column( 6, { page: 'none'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
           
            //$( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(app_number_format(total));
            $( api.column( 5 ).footer() ).html(app_number_format(paid));
            $( api.column( 6 ).footer() ).html(app_number_format(due));
           
        },
        /*End Footer Total*/
    });
    new $.fn.dataTable.FixedHeader( table );
  }
$(document).ready(function() {
    load_datatable();
});

$("#sales_from_date,#sales_to_date,#user_created_by,#search_customer_id").on("change",function(){
          $('#example2').DataTable().destroy();
          load_datatable();
      });

// Function to show order information
function show_order_info() {
    var selectedIds = [];
    $(".column_checkbox:checked").each(function() {
        selectedIds.push($(this).val());
    });
    
    if (selectedIds.length === 0) {
        alert("Vui lòng chọn ít nhất một đơn hàng!");
        return;
    }
    
    // Show modal
    $('#orderInfoModal').modal('show');
    
    // Reset modal content
    $('#orderInfoContent').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Đang tải dữ liệu...</p></div>');
    
    // AJAX call to get order details
    $.ajax({
        url: "<?php echo site_url('sales/get_order_details'); ?>",
        type: "POST",
        data: {
            order_ids: selectedIds
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                var html = buildOrderInfoHTML(response.data);
                $('#orderInfoContent').html(html);
            } else {
                $('#orderInfoContent').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + response.message + '</div>');
            }
        },
        error: function() {
            $('#orderInfoContent').html('<div class="alert alert-danger">Không thể tải thông tin đơn hàng. Vui lòng thử lại!</div>');
        }
    });
}

// Function to build HTML from JSON data
function buildOrderInfoHTML(orders) {
    var html = '<div class="order-info-modal">';
    
    orders.forEach(function(order) {
        // Build status label
        var statusLabel = getStatusLabel(order.sales_status);
        var paymentStatus = getPaymentStatus(order.due_amount);
        
        html += '<div class="panel panel-default">';
        html += '<div class="panel-heading">';
        html += '<h4 class="panel-title">';
        html += '<strong>Đơn hàng: ' + order.sales_code + '</strong>';
        html += '<span class="pull-right">' + statusLabel + '</span>';
        html += '</h4>';
        html += '</div>';
        html += '<div class="panel-body">';
        
        // Basic info row
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<table class="table table-condensed">';
        html += '<tr><td><strong>Ngày bán:</strong></td><td>' + formatDate(order.sales_date) + '</td></tr>';
        html += '<tr><td><strong>Khách hàng:</strong></td><td>' + (order.customer_name || 'N/A') + '</td></tr>';
        html += '<tr><td><strong>Điện thoại:</strong></td><td>' + (order.mobile || 'N/A') + '</td></tr>';
        html += '<tr><td><strong>Địa chỉ:</strong></td><td>' + (order.address || 'N/A') + '</td></tr>';
        html += '</table>';
        html += '</div>';
        
        // Financial info
        html += '<div class="col-md-6">';
        html += '<table class="table table-condensed">';
        html += '<tr><td><strong>Tổng tiền:</strong></td><td>' + formatCurrency(order.grand_total) + '</td></tr>';
        html += '<tr><td><strong>Đã thanh toán:</strong></td><td>' + formatCurrency(order.paid_amount) + '</td></tr>';
        html += '<tr><td><strong>Trạng thái TT:</strong></td><td>' + paymentStatus + '</td></tr>';
        html += '<tr><td><strong>Người tạo:</strong></td><td>' + (order.created_by || 'N/A') + '</td></tr>';
        html += '</table>';
        html += '</div>';
        html += '</div>';
        
        // Sales note
        if (order.sales_note && order.sales_note.trim() !== '') {
            html += '<div class="row">';
            html += '<div class="col-md-12"><strong>Ghi chú:</strong> ' + order.sales_note + '</div>';
            html += '</div>';
        }
        
        // Items details
        if (order.items && order.items.length > 0) {
            html += '<div class="row">';
            html += '<div class="col-md-12">';
            html += '<h5><strong>Chi tiết sản phẩm:</strong></h5>';
            html += '<table class="table table-bordered table-condensed">';
            html += '<thead>';
            html += '<tr>';
            html += '<th>Mã SP</th>';
            html += '<th>Tên sản phẩm</th>';
            html += '<th>Số lượng</th>';
            html += '<th>Đơn giá</th>';
            html += '<th>Thành tiền</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            order.items.forEach(function(item) {
                html += '<tr>';
                html += '<td>' + (item.item_code || 'N/A') + '</td>';
                html += '<td>' + (item.item_name || 'N/A') + '</td>';
                html += '<td>' + item.sales_qty + '</td>';
                html += '<td>' + formatCurrency(item.price_per_unit) + '</td>';
                html += '<td>' + formatCurrency(item.total_cost) + '</td>';
                html += '</tr>';
            });
            
            html += '</tbody>';
            html += '</table>';
            html += '</div>';
            html += '</div>';
        }
        
        html += '</div>'; // Close panel-body
        html += '</div>'; // Close panel
    });
    
    html += '</div>'; // Close order-info-modal
    return html;
}

// Helper functions
function getStatusLabel(status) {
    switch(status) {
        case 'Final':
            return '<span class="label label-success">Đã giao hàng</span>';
        case 'Shipping':
            return '<span class="label label-info">Đã xuất kho</span>';
        case 'Quotation':
            return '<span class="label label-warning">Đang giao dịch</span>';
        default:
            return '<span class="label label-default">' + status + '</span>';
    }
}

function getPaymentStatus(dueAmount) {
    if (dueAmount <= 0) {
        return '<span class="label label-success">Đã thanh toán</span>';
    } else {
        return '<span class="label label-danger">Còn nợ: ' + formatCurrency(dueAmount) + '</span>';
    }
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
}

function formatDate(dateString) {
    var date = new Date(dateString);
    return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});
}
</script>
<script src="<?php echo $theme_link; ?>js/sales.js?v=<?= time(); ?>"></script>
<script type="text/javascript">
  function print_invoice(id){
  window.open("<?= base_url();?>pos/print_invoice_pos/"+id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}
</script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
		
</body>
</html>
