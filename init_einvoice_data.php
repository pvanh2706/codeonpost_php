<?php
/**
 * E-invoice Migration Script
 * Chạy file này để khởi tạo tất cả cấu hình hóa đơn điện tử
 * Truy cập: http://localhost/codeonposphp/init_einvoice_data.php
 */

defined('BASEPATH') OR define('BASEPATH', '');

// Load CodeIgniter
require_once 'index.php';

$CI =& get_instance();
$CI->load->model('site_model', 'site');

echo "<!DOCTYPE html>";
echo "<html><head><title>Khởi tạo dữ liệu E-invoice</title>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;}table{border-collapse:collapse;width:100%;}th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#f2f2f2;}.success{color:green;}.error{color:red;}</style>";
echo "</head><body>";

echo "<h1>🚀 Khởi tạo dữ liệu E-invoice</h1>";

$errors = array();
$success_count = 0;

try {
    // 1. Tạo bảng cấu hình hóa đơn điện tử
    echo "<h2>1. Tạo các bảng cần thiết</h2>";
    
    if ($CI->site->create_einvoice_config_table()) {
        echo "<span class='success'>✓ Tạo bảng db_einvoice_config thành công</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi tạo bảng db_einvoice_config</span><br>";
        $errors[] = "Không thể tạo bảng db_einvoice_config";
    }
    
    if ($CI->site->create_einvoice_template_table()) {
        echo "<span class='success'>✓ Tạo bảng db_einvoice_templates thành công</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi tạo bảng db_einvoice_templates</span><br>";
        $errors[] = "Không thể tạo bảng db_einvoice_templates";
    }
    
    if ($CI->site->create_einvoice_payment_table()) {
        echo "<span class='success'>✓ Tạo bảng db_einvoice_payments thành công</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi tạo bảng db_einvoice_payments</span><br>";
        $errors[] = "Không thể tạo bảng db_einvoice_payments";
    }
    
    // 2. Thêm cột vào bảng db_sales
    echo "<h2>2. Cập nhật bảng db_sales</h2>";
    if ($CI->site->add_einvoice_fields_to_sales_table()) {
        echo "<span class='success'>✓ Thêm các cột E-invoice vào bảng db_sales thành công</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi thêm cột vào bảng db_sales</span><br>";
        $errors[] = "Không thể thêm cột vào bảng db_sales";
    }
    
    // 3. Khởi tạo dữ liệu mặc định
    echo "<h2>3. Khởi tạo dữ liệu mặc định</h2>";
    
    if ($CI->site->init_default_einvoice_templates()) {
        $templates = $CI->site->get_einvoice_templates();
        echo "<span class='success'>✓ Khởi tạo " . count($templates) . " mẫu số/ký hiệu mặc định</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi khởi tạo mẫu số/ký hiệu</span><br>";
        $errors[] = "Không thể khởi tạo mẫu số/ký hiệu";
    }
    
    if ($CI->site->init_default_einvoice_payments()) {
        $payments = $CI->site->get_einvoice_payments();
        echo "<span class='success'>✓ Khởi tạo " . count($payments) . " phương thức thanh toán mặc định</span><br>";
        $success_count++;
    } else {
        echo "<span class='error'>✗ Lỗi khởi tạo phương thức thanh toán</span><br>";
        $errors[] = "Không thể khởi tạo phương thức thanh toán";
    }
    
    // 4. Hiển thị dữ liệu đã tạo
    echo "<h2>4. Dữ liệu mẫu số/ký hiệu</h2>";
    $templates = $CI->site->get_einvoice_templates();
    if (count($templates) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Mẫu số</th><th>Ký hiệu</th><th>Mô tả</th><th>Trạng thái</th></tr>";
        foreach ($templates as $template) {
            echo "<tr>";
            echo "<td>{$template['id']}</td>";
            echo "<td>{$template['template_number']}</td>";
            echo "<td>{$template['symbol']}</td>";
            echo "<td>{$template['description']}</td>";
            echo "<td>Hoạt động</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<span class='error'>Không có dữ liệu mẫu số/ký hiệu</span>";
    }
    
    echo "<h2>5. Dữ liệu phương thức thanh toán</h2>";
    $payments = $CI->site->get_einvoice_payments();
    if (count($payments) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Mã</th><th>Tên</th><th>Mô tả</th><th>Trạng thái</th></tr>";
        foreach ($payments as $payment) {
            echo "<tr>";
            echo "<td>{$payment['id']}</td>";
            echo "<td>{$payment['payment_code']}</td>";
            echo "<td>{$payment['payment_name']}</td>";
            echo "<td>{$payment['description']}</td>";
            echo "<td>Hoạt động</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<span class='error'>Không có dữ liệu phương thức thanh toán</span>";
    }
    
    // 5. Kiểm tra cấu trúc bảng db_sales
    echo "<h2>6. Kiểm tra cấu trúc bảng db_sales</h2>";
    $query = $CI->db->query("DESCRIBE db_sales");
    $columns = $query->result_array();
    
    $einvoice_columns = array('template_number', 'symbol', 'payment_method', 'tax_code');
    echo "<table>";
    echo "<tr><th>Tên cột</th><th>Kiểu dữ liệu</th><th>Giá trị mặc định</th><th>Trạng thái</th></tr>";
    
    foreach ($einvoice_columns as $expected_column) {
        $found = false;
        foreach ($columns as $column) {
            if ($column['Field'] == $expected_column) {
                echo "<tr>";
                echo "<td>{$column['Field']}</td>";
                echo "<td>{$column['Type']}</td>";
                echo "<td>{$column['Default']}</td>";
                echo "<td><span class='success'>✓ Tồn tại</span></td>";
                echo "</tr>";
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "<tr>";
            echo "<td>{$expected_column}</td>";
            echo "<td colspan='2'>-</td>";
            echo "<td><span class='error'>✗ Không tồn tại</span></td>";
            echo "</tr>";
            $errors[] = "Cột {$expected_column} không tồn tại trong bảng db_sales";
        }
    }
    echo "</table>";
    
    // 6. Tóm tắt kết quả
    echo "<h2>7. Tóm tắt kết quả</h2>";
    echo "<p><strong>Số thao tác thành công:</strong> <span class='success'>{$success_count}</span></p>";
    echo "<p><strong>Số lỗi:</strong> <span class='error'>" . count($errors) . "</span></p>";
    
    if (count($errors) > 0) {
        echo "<h3>Chi tiết lỗi:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li class='error'>{$error}</li>";
        }
        echo "</ul>";
    } else {
        echo "<div style='background-color:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:15px;border-radius:5px;margin:20px 0;'>";
        echo "<h3>🎉 Khởi tạo hoàn tất!</h3>";
        echo "<p>Tất cả dữ liệu E-invoice đã được khởi tạo thành công. Bây giờ bạn có thể:</p>";
        echo "<ul>";
        echo "<li>Sử dụng API <code>get_order_details</code> để lấy thông tin đơn hàng với cấu hình E-invoice</li>";
        echo "<li>Cấu hình thông tin kết nối API E-invoice trong giao diện</li>";
        echo "<li>Tạo và quản lý hóa đơn điện tử</li>";
        echo "</ul>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background-color:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:15px;border-radius:5px;margin:20px 0;'>";
    echo "<h3>❌ Lỗi nghiêm trọng!</h3>";
    echo "<p>Đã xảy ra lỗi trong quá trình khởi tạo: <strong>" . $e->getMessage() . "</strong></p>";
    echo "</div>";
}

echo "<br><br>";
echo "<p><em>Script hoàn thành lúc: " . date('Y-m-d H:i:s') . "</em></p>";
echo "</body></html>";
?>
