<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datatables/dataTables.bootstrap.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include"sidebar.php"; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $page_title; ?>
            <small>Quản lý phương thức thanh toán hóa đơn điện tử</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li><a href="<?php echo $base_url; ?>sales/einvoice_config"><i class="fa fa-file-text-o"></i> Cấu hình HDDT</a></li>
            <li class="active"><?= $page_title; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Payment Methods Management Box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách phương thức thanh toán</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="showAddModal()">
                                <i class="fa fa-plus"></i> Thêm mới
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="paymentsTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">STT</th>
                                        <th width="20%">Mã phương thức</th>
                                        <th width="25%">Tên phương thức</th>
                                        <th width="30%">Mô tả</th>
                                        <th width="15%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Information Box -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Thông tin tham khảo</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>Các mã phương thức thanh toán phổ biến:</strong></h5>
                                <ul>
                                    <li><strong>TM:</strong> Tiền mặt</li>
                                    <li><strong>CK:</strong> Chuyển khoản</li>
                                    <li><strong>TT:</strong> Thẻ tín dụng</li>
                                    <li><strong>CC:</strong> Credit Card</li>
                                    <li><strong>DC:</strong> Debit Card</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5><strong>Lưu ý:</strong></h5>
                                <ul>
                                    <li>Mã phương thức không được trùng lặp</li>
                                    <li>Mã phương thức nên ngắn gọn và dễ nhớ</li>
                                    <li>Tên phương thức nên mô tả rõ ràng</li>
                                    <li>Phương thức đã xóa sẽ không hiển thị trong danh sách</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add/Edit Payment Method Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalTitle">Thêm phương thức thanh toán</h4>
            </div>
            <form id="paymentForm">
                <div class="modal-body">
                    <input type="hidden" id="paymentId" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    
                    <div class="form-group">
                        <label for="paymentCode">Mã phương thức <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="paymentCode" name="payment_code" required 
                               placeholder="Ví dụ: TM, CK, TT" maxlength="50" style="text-transform: uppercase;">
                        <small class="help-block">Mã phương thức nên ngắn gọn, ví dụ: TM (Tiền mặt), CK (Chuyển khoản)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="paymentName">Tên phương thức <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="paymentName" name="payment_name" required 
                               placeholder="Ví dụ: Tiền mặt, Chuyển khoản ngân hàng" maxlength="100">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                placeholder="Mô tả chi tiết về phương thức thanh toán"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="fa fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa phương thức thanh toán này?</p>
                <input type="hidden" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fa fa-trash"></i> Xóa
                </button>
            </div>
        </div>
    </div>
</div>

<?php include"comman/code_js_form.php"; ?>

<!-- DataTables -->
<script src="<?php echo $theme_link; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $theme_link; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#paymentsTable').DataTable({
        "ajax": {
            "url": "<?php echo $base_url; ?>sales/get_einvoice_payments",
            "type": "GET"
        },
        "columns": [
            { 
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "payment_code" },
            { "data": "payment_name" },
            { "data": "description" },
            { 
                "data": null,
                "render": function(data, type, row) {
                    return '<button class="btn btn-xs btn-warning" onclick="editPayment(' + row.id + ', \'' + row.payment_code + '\', \'' + row.payment_name + '\', \'' + (row.description || '') + '\')" title="Sửa">' +
                           '<i class="fa fa-edit"></i></button> ' +
                           '<button class="btn btn-xs btn-danger" onclick="deletePayment(' + row.id + ')" title="Xóa">' +
                           '<i class="fa fa-trash"></i></button>';
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        },
        "responsive": true,
        "autoWidth": false,
        "processing": true
    });

    // Auto uppercase payment code
    $('#paymentCode').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Form submission
    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = '<?php echo $base_url; ?>sales/save_einvoice_payment';
        
        $('#saveBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#paymentModal').modal('hide');
                    table.ajax.reload();
                    $('#paymentForm')[0].reset();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
            },
            complete: function() {
                $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Lưu');
            }
        });
    });
});

function showAddModal() {
    $('#paymentForm')[0].reset();
    $('#paymentId').val('');
    $('#modalTitle').text('Thêm phương thức thanh toán');
    $('#paymentModal').modal('show');
}

function editPayment(id, paymentCode, paymentName, description) {
    $('#paymentId').val(id);
    $('#paymentCode').val(paymentCode);
    $('#paymentName').val(paymentName);
    $('#description').val(description);
    $('#modalTitle').text('Sửa phương thức thanh toán');
    $('#paymentModal').modal('show');
}

function deletePayment(id) {
    $('#deleteId').val(id);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    var id = $('#deleteId').val();
    
    $.ajax({
        url: '<?php echo $base_url; ?>sales/delete_einvoice_payment',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                $('#deleteModal').modal('hide');
                $('#paymentsTable').DataTable().ajax.reload();
            } else {
                toastr.error(response.message);
            }
        },
        error: function() {
            toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
}
</script>

</body>
</html>
