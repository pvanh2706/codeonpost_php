<?php
/*
 * Script to initialize default e-invoice templates and payment methods
 * Run this once after setting up the new configuration pages
 */

// Define default templates
$default_templates = [
    ['template_number' => '01GTKT', 'symbol' => 'HV/24E', 'description' => 'Hóa đơn GTGT - Mẫu chuẩn 2024'],
    ['template_number' => '02GTKT', 'symbol' => 'HV/24K', 'description' => 'Hóa đơn GTGT - Mẫu khách hàng doanh nghiệp'],
    ['template_number' => '01BHD', 'symbol' => 'BH/24E', 'description' => 'Biên lai thu tiền - Bán hàng'],
    ['template_number' => '01TEI', 'symbol' => 'TE/24E', 'description' => 'Tem điện tử - Xuất khẩu'],
];

// Define default payment methods
$default_payments = [
    ['payment_code' => 'TM', 'payment_name' => 'Tiền mặt', 'description' => 'Thanh toán bằng tiền mặt tại quầy'],
    ['payment_code' => 'CK', 'payment_name' => 'Chuyển khoản ngân hàng', 'description' => 'Thanh toán qua chuyển khoản ngân hàng'],
    ['payment_code' => 'TT', 'payment_name' => 'Thẻ tín dụng', 'description' => 'Thanh toán bằng thẻ tín dụng/ghi nợ'],
    ['payment_code' => 'MM', 'payment_name' => 'Ví điện tử', 'description' => 'Thanh toán qua ví điện tử (Momo, ZaloPay, ...)'],
    ['payment_code' => 'QR', 'payment_name' => 'QR Code', 'description' => 'Thanh toán bằng quét mã QR'],
    ['payment_code' => 'TH', 'payment_name' => 'Trả sau', 'description' => 'Thanh toán trả sau - công nợ'],
];

echo "Dữ liệu mặc định đã được chuẩn bị.\n";
echo "\nCác mẫu số ký hiệu:\n";
foreach ($default_templates as $template) {
    echo "- {$template['template_number']} / {$template['symbol']}: {$template['description']}\n";
}

echo "\nCác phương thức thanh toán:\n";
foreach ($default_payments as $payment) {
    echo "- {$payment['payment_code']}: {$payment['payment_name']}\n";
}

echo "\nHướng dẫn sử dụng:\n";
echo "1. Đăng nhập vào hệ thống POS\n";
echo "2. Vào menu 'Cài đặt chung'\n";
echo "3. Chọn 'Cấu hình Mẫu số, Ký hiệu HDDT' hoặc 'Cấu hình phương thức thanh toán HDDT'\n";
echo "4. Thêm các mẫu số và phương thức thanh toán theo yêu cầu\n";
echo "5. Dữ liệu sẽ được lưu trong bảng db_einvoice_templates và db_einvoice_payments\n";

?>
