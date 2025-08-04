<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/datepicker/datepicker3.css">
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
            <small>Cấu hình kết nối API hóa đơn điện tử</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
            <li class="active"><?= $page_title; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

<style>
    .config-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 4px;
        margin-bottom: 30px;
        border-left: 4px solid #007bff;
    }
    
    .config-info h4 {
        color: #007bff;
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .config-info ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    
    .config-info li {
        margin-bottom: 5px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }
    
    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="url"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }
    
    .password-field {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        font-size: 16px;
    }
    
    .password-toggle:hover {
        color: #007bff;
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    
    .alert-einvoice-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .alert-einvoice-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .alert-einvoice-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
    
    .btn {
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: 10px;
        border-radius: 4px;
        border: 1px solid transparent;
    }
    
    .btn-info {
        color: #fff;
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }
    
    .btn-default {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }
    
    .btn-default:hover {
        background-color: #e6e6e6;
        border-color: #adadad;
    }
    
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
            margin-left: 0;
            margin-bottom: 10px;
        }
    }
</style>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-file-text-o"></i> Cấu hình hóa đơn điện tử</h3>
    </div>
    <div class="box-body">
            <div class="config-info">
                <h4><i class="fa fa-info-circle"></i> Thông tin cấu hình</h4>
                <p>Vui lòng nhập thông tin kết nối để tích hợp với hệ thống hóa đơn điện tử:</p>
                <ul>
                    <li><strong>Link kết nối API:</strong> URL endpoint kết nối Hóa đơn điện tử của phần mềm</li>
                    <li><strong>Link API nhà cung cấp:</strong> URL endpoint của nhà cung cấp hóa đơn điện tử</li>
                    <li><strong>Tài khoản:</strong> Username được cấp bởi nhà cung cấp</li>
                    <li><strong>Mật khẩu:</strong> Password tương ứng với tài khoản</li>
                    <li><strong>Mã số thuế doanh nghiệp:</strong> Mã số thuế của doanh nghiệp để xác thực</li>
                    <li><strong>Mã nhà cung cấp:</strong> Mã định danh doanh nghiệp trong hệ thống</li>
                </ul>
            </div>
            
            <div id="alert-container"></div>
        
        <form id="einvoice-config-form">
            <div class="form-group">
                <label for="api_url_einvoice">
                    <i class="fa fa-link"></i> Link kết nối API *
                </label>
                <input type="url" id="api_url_einvoice" name="api_url_einvoice" required 
                       placeholder="https://api.einvoice.example.com/v1"
                       value="<?php echo isset($einvoice_config['api_url_einvoice']) ? $einvoice_config['api_url_einvoice'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="api_url">
                    <i class="fa fa-link"></i> Link API nhà cung cấp *
                </label>
                <input type="url" id="api_url" name="api_url" required 
                       placeholder="https://api.einvoice.example.com/v1"
                       value="<?php echo isset($einvoice_config['api_url']) ? $einvoice_config['api_url'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="username">
                    <i class="fa fa-user"></i> Tài khoản *
                </label>
                <input type="text" id="username" name="username" required 
                       placeholder="Nhập tài khoản được cấp"
                       value="<?php echo isset($einvoice_config['username']) ? $einvoice_config['username'] : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fa fa-lock"></i> Mật khẩu *
                </label>
                <div class="password-field">
                    <input type="password" id="password" name="password" required 
                           placeholder="Nhập mật khẩu"
                           value="<?php echo isset($einvoice_config['password']) ? $einvoice_config['password'] : ''; ?>">
                    <i class="fa fa-eye password-toggle" id="password-toggle"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="tax_code">
                    <i class="fa fa-id-card"></i> Mã số thuế doanh nghiệp *
                </label>
                <input type="text" id="tax_code" name="tax_code" required 
                       placeholder="Nhập mã số thuế doanh nghiệp"
                       value="<?php echo isset($einvoice_config['tax_code']) ? $einvoice_config['tax_code'] : ''; ?>">
            
            <div class="form-group">
                <label for="provider_code">
                    <i class="fa fa-building"></i> Mã nhà cung cấp *
                </label>
                <select id="provider_code" name="provider_code" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; transition: border-color 0.3s ease;">
                    <option value="">-- Chọn nhà cung cấp --</option>
                    <option value="2" <?php echo (isset($einvoice_config['provider_code']) && $einvoice_config['provider_code'] == '2') ? 'selected' : ''; ?>>MInvoice</option>
                    <option value="4" <?php echo (isset($einvoice_config['provider_code']) && $einvoice_config['provider_code'] == '4') ? 'selected' : ''; ?>>Viettel</option>
                    <option value="6" <?php echo (isset($einvoice_config['provider_code']) && $einvoice_config['provider_code'] == '6') ? 'selected' : ''; ?>>Misa</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="button" id="btn-health-check" class="btn btn-info">
                    <i class="fa fa-heartbeat"></i>
                    <span class="loading-spinner"></span>
                    Kiểm tra kết nối
                </button>
                <button type="button" id="btn-test-connection" class="btn btn-default">
                    <i class="fa fa-plug"></i>
                    <span class="loading-spinner"></span>
                    Test kết nối
                </button>
                <button type="button" id="btn-save-config" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    <span class="loading-spinner"></span>
                    Lưu cấu hình
                </button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle hiển thị mật khẩu
    $('#password-toggle').click(function() {
        var passwordField = $('#password');
        var icon = $(this);
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Kiểm tra kết nối Health Check
    $('#btn-health-check').click(function() {
        var btn = $(this);
        var spinner = btn.find('.loading-spinner');
        
        // Validate form trước khi kiểm tra
        if (!validateForm()) {
            return;
        }
        
        btn.prop('disabled', true);
        spinner.show();
        
        var formData = {
            api_url_einvoice: $('#api_url_einvoice').val().trim(),
            api_url: $('#api_url').val().trim(),
            username: $('#username').val().trim(),
            password: $('#password').val().trim(),
            provider_code: $('#provider_code').val().trim(),
            tax_code: $('#tax_code').val().trim()
        };
        
        $.ajax({
            url: '<?php echo site_url("sales/health_check_einvoice"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var message = '<i class="fa fa-check-circle"></i> ' + response.message;
                    if (response.response && response.response.data) {
                        message += '<br><small>Response Data: ' + JSON.stringify(response.response.data) + '</small>';
                    }
                    showAlert('success', message);
                } else {
                    var errorMessage = '<i class="fa fa-exclamation-circle"></i> ' + response.message;
                    if (response.http_code) {
                        errorMessage += '<br><small>HTTP Code: ' + response.http_code + '</small>';
                    }
                    if (response.error_details) {
                        errorMessage += '<br><small>Chi tiết lỗi: ' + response.error_details + '</small>';
                    }
                    showAlert('danger', errorMessage);
                }
            },
            error: function(xhr, status, error) {
                showAlert('danger', '<i class="fa fa-exclamation-circle"></i> Có lỗi xảy ra khi kiểm tra kết nối: ' + error);
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.hide();
            }
        });
    });
    
    // Test kết nối API
    $('#btn-test-connection').click(function() {
        var btn = $(this);
        var spinner = btn.find('.loading-spinner');
        
        // Validate form trước khi test
        if (!validateForm()) {
            return;
        }
        
        btn.prop('disabled', true);
        spinner.show();
        
        var formData = {
            api_url: $('#api_url').val().trim(),
            username: $('#username').val().trim(),
            password: $('#password').val().trim(),
            provider_code: $('#provider_code').val().trim()
        };
        
        $.ajax({
            url: '<?php echo site_url("sales/test_einvoice_connection"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert('success', '<i class="fa fa-check-circle"></i> ' + response.message);
                } else {
                    showAlert('danger', '<i class="fa fa-exclamation-circle"></i> ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                showAlert('danger', '<i class="fa fa-exclamation-circle"></i> Có lỗi xảy ra khi test kết nối: ' + error);
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.hide();
            }
        });
    });
    
    // Lưu cấu hình
    $('#btn-save-config').click(function() {
        var btn = $(this);
        var spinner = btn.find('.loading-spinner');
        
        // Validate form trước khi lưu
        if (!validateForm()) {
            return;
        }
        
        btn.prop('disabled', true);
        spinner.show();
        
        var formData = {
            api_url_einvoice: $('#api_url_einvoice').val().trim(),
            api_url: $('#api_url').val().trim(),
            username: $('#username').val().trim(),
            password: $('#password').val().trim(),
            provider_code: $('#provider_code').val().trim(),
            tax_code: $('#tax_code').val().trim()
        };

        $.ajax({
            url: '<?php echo site_url("sales/save_einvoice_config"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert('success', '<i class="fa fa-check-circle"></i> ' + response.message);
                } else {
                    showAlert('danger', '<i class="fa fa-exclamation-circle"></i> ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                showAlert('danger', '<i class="fa fa-exclamation-circle"></i> Có lỗi xảy ra khi lưu cấu hình: ' + error);
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.hide();
            }
        });
    });
    
    // Validate form
    function validateForm() {
        var isValid = true;
        var fields = ['api_url', 'username', 'password', 'provider_code'];
        
        // Xóa alert cũ
        $('#alert-container').empty();
        
        // Reset border color
        $('#einvoice-config-form input').removeClass('error');
        
        fields.forEach(function(field) {
            var value = $('#' + field).val().trim();
            if (!value) {
                $('#' + field).addClass('error');
                isValid = false;
            }
        });
        
        // Validate URL format
        var apiUrl = $('#api_url').val().trim();
        if (apiUrl && !isValidURL(apiUrl)) {
            $('#api_url').addClass('error');
            isValid = false;
        }
        
        if (!isValid) {
            showAlert('danger', '<i class="fa fa-exclamation-triangle"></i> Vui lòng điền đầy đủ thông tin và đảm bảo URL hợp lệ.');
        }
        
        return isValid;
    }
    
    // Kiểm tra URL hợp lệ
    function isValidURL(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Hiển thị alert
    function showAlert(type, message) {
        // Đảm bảo alert container tồn tại
        if ($('#alert-container').length === 0) {
            console.log('Alert container not found, creating one');
            $('.box-body').prepend('<div id="alert-container"></div>');
        }
        
        var alertHtml = '<div class="alert alert-einvoice-' + type + ' alert-dismissible" role="alert" style="display: none;">' +
                        message +
                        '<button type="button" class="close" onclick="$(this).parent().fadeOut();" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>';
        
        // Xóa alert cũ và thêm alert mới
        $('#alert-container').html(alertHtml);
        $('#alert-container .alert').fadeIn();
        
        // Scroll to top để thấy alert
        if ($('#alert-container').offset()) {
            $('html, body').animate({
                scrollTop: $('#alert-container').offset().top - 100
            }, 500);
        }
        
        // Tự động ẩn alert sau 8 giây
        setTimeout(function() {
            $('#alert-container .alert').fadeOut();
        }, 8000);
    }
    
    // Thêm style cho input lỗi
    $('<style>').prop('type', 'text/css').html(
        '.form-group input.error { border-color: #dc3545 !important; box-shadow: 0 0 0 2px rgba(220,53,69,0.25) !important; }'
    ).appendTo('head');
});
</script>

            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</body>
</html>
