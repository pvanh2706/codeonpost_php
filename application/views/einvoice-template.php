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
            <small>Quản lý mẫu số và ký hiệu hóa đơn điện tử</small>
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
                <!-- Template Management Box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách mẫu số ký hiệu</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-primary btn-sm" onclick="showAddModal()">
                                <i class="fa fa-plus"></i> Thêm mới
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="templatesTable" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">STT</th>
                                        <th width="20%">Mẫu số</th>
                                        <th width="20%">Ký hiệu</th>
                                        <th width="35%">Mô tả</th>
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
            </div>
        </div>
    </section>
</div>

<!-- Add/Edit Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modalTitle">Thêm mẫu số ký hiệu</h4>
            </div>
            <form id="templateForm">
                <div class="modal-body">
                    <input type="hidden" id="templateId" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    
                    <div class="form-group">
                        <label for="templateNumber">Mẫu số <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="templateNumber" name="template_number" required 
                               placeholder="Ví dụ: 01GTKT" maxlength="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="symbol">Ký hiệu <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="symbol" name="symbol" required 
                               placeholder="Ví dụ: HV/24E" maxlength="50">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                placeholder="Mô tả chi tiết về mẫu số ký hiệu"></textarea>
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
                <p>Bạn có chắc chắn muốn xóa mẫu số ký hiệu này?</p>
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
    var table = $('#templatesTable').DataTable({
        "ajax": {
            "url": "<?php echo $base_url; ?>sales/get_einvoice_templates",
            "type": "GET"
        },
        "columns": [
            { 
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "template_number" },
            { "data": "symbol" },
            { "data": "description" },
            { 
                "data": null,
                "render": function(data, type, row) {
                    return '<button class="btn btn-xs btn-warning" onclick="editTemplate(' + row.id + ', \'' + row.template_number + '\', \'' + row.symbol + '\', \'' + (row.description || '') + '\')" title="Sửa">' +
                           '<i class="fa fa-edit"></i></button> ' +
                           '<button class="btn btn-xs btn-danger" onclick="deleteTemplate(' + row.id + ')" title="Xóa">' +
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

    // Form submission
    $('#templateForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        var url = '<?php echo $base_url; ?>sales/save_einvoice_template';
        $('#saveBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log('Success response:', response);
                if (response.success) {
                    toastr.success(response.message);
                    $('#templateModal').modal('hide');
                    table.ajax.reload();
                    $('#templateForm')[0].reset();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error status:', status);
                console.log('Error:', error);
                console.log('Response text:', xhr.responseText);
                console.log('Status code:', xhr.status);
                
                if (xhr.status === 403) {
                    toastr.error('Lỗi 403: Không có quyền truy cập. Vui lòng kiểm tra đăng nhập.');
                } else if (xhr.status === 404) {
                    toastr.error('Lỗi 404: Không tìm thấy URL. Vui lòng kiểm tra đường dẫn.');
                } else {
                    toastr.error('Có lỗi xảy ra: ' + error + ' (Status: ' + xhr.status + ')');
                }
            },
            complete: function() {
                $('#saveBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Lưu');
            }
        });
    });
});

function showAddModal() {
    $('#templateForm')[0].reset();
    $('#templateId').val('');
    $('#modalTitle').text('Thêm mẫu số ký hiệu');
    $('#templateModal').modal('show');
}

function editTemplate(id, templateNumber, symbol, description) {
    $('#templateId').val(id);
    $('#templateNumber').val(templateNumber);
    $('#symbol').val(symbol);
    $('#description').val(description);
    $('#modalTitle').text('Sửa mẫu số ký hiệu');
    $('#templateModal').modal('show');
}

function deleteTemplate(id) {
    $('#deleteId').val(id);
    $('#deleteModal').modal('show');
}

function confirmDelete() {
    var id = $('#deleteId').val();
    
    $.ajax({
        url: '<?php echo $base_url; ?>sales/delete_einvoice_template',
        type: 'POST',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                $('#deleteModal').modal('hide');
                $('#templatesTable').DataTable().ajax.reload();
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
