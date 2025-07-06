# Hướng dẫn Test Tính năng "Thông tin đơn hàng"

## Tính năng đã được thêm:

1. **Nút "Thông tin đơn hàng"** trong DataTable toolbar
2. **Modal popup** hiển thị thông tin chi tiết đơn hàng được chọn
3. **AJAX endpoint** `/sales/get_order_details` để lấy dữ liệu

## Cách test:

### 1. Mở trang danh sách bán hàng
Truy cập: `http://your-domain/sales` hoặc click vào menu "Bán hàng" -> "Danh sách bán hàng"

### 2. Chọn đơn hàng
- Tích chọn một hoặc nhiều checkbox của các đơn hàng trong bảng
- Nút "Thông tin đơn hàng" (màu xanh) sẽ xuất hiện ở toolbar

### 3. Xem thông tin chi tiết
- Click vào nút "Thông tin đơn hàng"
- Modal popup sẽ mở ra hiển thị:
  - Thông tin cơ bản: Mã đơn hàng, ngày bán, khách hàng
  - Thông tin thanh toán: Tổng tiền, đã thanh toán, còn nợ
  - Chi tiết sản phẩm: Danh sách sản phẩm trong đơn hàng
  - Trạng thái đơn hàng và thanh toán

## Files đã được chỉnh sửa:

### 1. View: `application/views/sales-list.php`
- Thêm nút "Thông tin đơn hàng" vào DataTable buttons
- Thêm modal popup với styling
- Thêm JavaScript function `show_order_info()`

### 2. Controller: `application/controllers/Sales.php`
- Thêm method `get_order_details()` để xử lý AJAX request
- Tạo HTML response với thông tin chi tiết đơn hàng

### 3. Common JS: `application/views/comman/code_js_datatable.php`
- Cập nhật functions `show_delete_btn()` và `show_paid_all_btn()`
- Thêm logic hiển thị/ẩn nút "Thông tin đơn hàng"

## Cấu trúc dữ liệu trả về:

**JSON Response Format:**
```json
{
  "success": true,
  "data": [
    {
      "id": "1",
      "sales_code": "S0001",
      "sales_date": "2025-01-01 10:30:00",
      "sales_status": "Final",
      "grand_total": "500000",
      "paid_amount": "300000", 
      "due_amount": 200000,
      "sales_note": "Ghi chú đơn hàng",
      "customer_name": "Nguyễn Văn A",
      "mobile": "0123456789",
      "address": "123 Đường ABC, Quận 1, TP.HCM",
      "created_by": "admin",
      "items": [
        {
          "item_code": "SP001",
          "item_name": "Sản phẩm A",
          "sales_qty": "2",
          "price_per_unit": "150000",
          "total_cost": "300000"
        }
      ]
    }
  ]
}
```

## Kiến trúc mới:

### Backend (PHP):
- **Controller** chỉ trả về JSON thuần túy
- **Separation of concerns**: Logic xử lý dữ liệu tách biệt với presentation layer
- **Reusable API**: Endpoint có thể được sử dụng cho mobile app, API external

### Frontend (JavaScript):
- **Dynamic HTML generation** từ JSON data
- **Helper functions** cho format currency, date, status
- **Modular code structure** dễ maintain và extend
- **Client-side templating** linh hoạt hơn server-side rendering

## Các tính năng chính:

1. **Multi-select**: Có thể chọn nhiều đơn hàng cùng lúc
2. **Real-time data**: Dữ liệu được lấy real-time từ database
3. **Responsive design**: Modal responsive cho mobile và desktop
4. **Rich information**: Hiển thị đầy đủ thông tin đơn hàng và sản phẩm
5. **Status indicators**: Label màu sắc cho trạng thái đơn hàng và thanh toán

## CSS Classes được thêm:

- `.order-info-modal`: Container cho modal content
- Custom styling cho tables và panels trong modal

## Bảo mật:

- Sử dụng `permission_check_with_msg('sales_view')` để kiểm tra quyền
- Validate input data trước khi query
- Sanitize output data

## Lợi ích của kiến trúc JSON-based:

### 🚀 Performance:
- **Faster loading**: JSON nhẹ hơn HTML
- **Better caching**: JSON data có thể cache hiệu quả
- **Reduced bandwidth**: Chỉ truyền dữ liệu thô

### 🔧 Maintainability:
- **Separation of concerns**: Backend chỉ lo logic, Frontend lo presentation
- **Easy testing**: JSON response dễ test và validate
- **Code reusability**: Một API endpoint phục vụ nhiều client

### 📱 Scalability:
- **Multi-platform ready**: Cùng API cho web, mobile, desktop
- **Future-proof**: Dễ thay đổi UI mà không động đến backend
- **API-first approach**: Chuẩn bị sẵn cho microservices

### 🎨 Flexibility:
- **Dynamic UI**: Có thể thay đổi cách hiển thị dựa trên data
- **Conditional rendering**: Hiển thị component theo logic phức tạp
- **Real-time updates**: Dễ implement real-time với WebSocket

## Troubleshooting:

Nếu gặp lỗi:
1. Kiểm tra database connection
2. Đảm bảo user có quyền `sales_view`
3. Check browser console để xem lỗi JavaScript
4. Verify AJAX endpoint hoạt động: `/sales/get_order_details`
