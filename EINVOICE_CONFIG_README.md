# Cấu hình Mẫu số, Ký hiệu và Phương thức thanh toán HDDT

## Tổng quan
Đã bổ sung thêm 2 chức năng cấu hình mới cho hệ thống hóa đơn điện tử:

1. **Cấu hình Mẫu số, Ký hiệu HDDT** - Quản lý các mẫu số và ký hiệu hóa đơn
2. **Cấu hình phương thức thanh toán HDDT** - Quản lý các phương thức thanh toán

## Vị trí menu
Cả 2 chức năng được đặt trong menu **Cài đặt chung**, ngay dưới **Cấu hình hóa đơn điện tử**:

```
Cài đặt chung
├── Doanh nghiệp
├── Cài đặt POS  
├── Cấu hình hóa đơn điện tử
├── Cấu hình Mẫu số, Ký hiệu HDDT (MỚI)
├── Cấu hình phương thức thanh toán HDDT (MỚI)
├── Danh sách thuế Admin
└── ...
```

## Cấu trúc cơ sở dữ liệu

### Bảng mẫu số ký hiệu (db_einvoice_templates)
```sql
CREATE TABLE `db_einvoice_templates` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `template_number` varchar(50) NOT NULL,
    `symbol` varchar(50) NOT NULL, 
    `description` text,
    `status` tinyint(1) DEFAULT '1',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `template_symbol` (`template_number`, `symbol`)
)
```

### Bảng phương thức thanh toán (db_einvoice_payments)
```sql
CREATE TABLE `db_einvoice_payments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `payment_code` varchar(50) NOT NULL,
    `payment_name` varchar(100) NOT NULL,
    `description` text,
    `status` tinyint(1) DEFAULT '1', 
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payment_code` (`payment_code`)
)
```

## Tính năng đã thực hiện

### 1. Cấu hình Mẫu số, Ký hiệu HDDT
- **URL**: `/sales/einvoice_template`
- **Chức năng**:
  - Hiển thị danh sách mẫu số ký hiệu dạng bảng
  - Thêm mới mẫu số ký hiệu qua popup
  - Sửa mẫu số ký hiệu qua popup  
  - Xóa mẫu số ký hiệu (xóa mềm)
  - Hỗ trợ nhiều mẫu số ký hiệu
- **Trường dữ liệu**:
  - Mẫu số (template_number): VD: 01GTKT
  - Ký hiệu (symbol): VD: HV/24E
  - Mô tả (description): Mô tả chi tiết

### 2. Cấu hình phương thức thanh toán HDDT  
- **URL**: `/sales/einvoice_payment`
- **Chức năng**:
  - Hiển thị danh sách phương thức thanh toán dạng bảng
  - Thêm mới phương thức qua popup
  - Sửa phương thức qua popup
  - Xóa phương thức (xóa mềm)
  - Hỗ trợ nhiều phương thức thanh toán
- **Trường dữ liệu**:
  - Mã phương thức (payment_code): VD: TM, CK, TT
  - Tên phương thức (payment_name): VD: Tiền mặt, Chuyển khoản
  - Mô tả (description): Mô tả chi tiết

## Files đã tạo/chỉnh sửa

### Controllers (1 file chỉnh sửa)
- `application/controllers/Sales.php`: Thêm 6 methods mới

### Models (1 file chỉnh sửa)  
- `application/models/Site_model.php`: Thêm 10 methods mới

### Views (3 files)
- `application/views/sidebar.php`: Thêm 2 menu items mới
- `application/views/einvoice-template.php`: Trang cấu hình mẫu số ký hiệu
- `application/views/einvoice-payment.php`: Trang cấu hình phương thức thanh toán

### Utility
- `init_einvoice_data.php`: Script khởi tạo dữ liệu mẫu

## Giao diện 

### Đặc điểm chung
- Sử dụng DataTables cho hiển thị dạng bảng
- Popup modal cho thêm/sửa  
- Xác nhận trước khi xóa
- Responsive design
- AJAX để tải dữ liệu và xử lý form
- Thông báo Toast

### Tính năng UI/UX
- Pagination và search tự động
- Sort theo các cột
- Validation form
- Loading states
- Error handling
- Breadcrumb navigation

## API Endpoints

### Mẫu số ký hiệu
- `GET /sales/einvoice_template` - Trang cấu hình
- `GET /sales/get_einvoice_templates` - Lấy danh sách
- `POST /sales/save_einvoice_template` - Lưu (thêm/sửa)
- `POST /sales/delete_einvoice_template` - Xóa

### Phương thức thanh toán  
- `GET /sales/einvoice_payment` - Trang cấu hình
- `GET /sales/get_einvoice_payments` - Lấy danh sách
- `POST /sales/save_einvoice_payment` - Lưu (thêm/sửa)  
- `POST /sales/delete_einvoice_payment` - Xóa

## Quyền truy cập
- Sử dụng permission `site_edit` (quyền đã có sẵn)
- Kiểm tra quyền truy cập ở tất cả các methods

## Dữ liệu mẫu

### Mẫu số ký hiệu phổ biến:
- 01GTKT / HV/24E: Hóa đơn GTGT - Mẫu chuẩn 2024
- 02GTKT / HV/24K: Hóa đơn GTGT - Mẫu khách hàng doanh nghiệp  
- 01BHD / BH/24E: Biên lai thu tiền - Bán hàng
- 01TEI / TE/24E: Tem điện tử - Xuất khẩu

### Phương thức thanh toán phổ biến:
- TM: Tiền mặt
- CK: Chuyển khoản ngân hàng
- TT: Thẻ tín dụng  
- MM: Ví điện tử
- QR: QR Code
- TH: Trả sau

## Hướng dẫn sử dụng

1. **Truy cập**: Đăng nhập hệ thống → Menu "Cài đặt chung"
2. **Cấu hình mẫu số**: Chọn "Cấu hình Mẫu số, Ký hiệu HDDT"
3. **Cấu hình thanh toán**: Chọn "Cấu hình phương thức thanh toán HDDT"  
4. **Thêm mới**: Click nút "Thêm mới" → Điền thông tin → Lưu
5. **Chỉnh sửa**: Click icon sửa trên bảng → Chỉnh sửa → Lưu
6. **Xóa**: Click icon xóa → Xác nhận xóa

## Lưu ý kỹ thuật
- Bảng được tạo tự động khi truy cập lần đầu
- Xóa mềm (cập nhật status = 0) thay vì xóa vật lý
- Ràng buộc UNIQUE để tránh trùng lặp
- Sử dụng transaction cho đảm bảo tính toàn vẹn dữ liệu
- Mã hóa SQL injection safe
- XSS protection
