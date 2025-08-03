/**
 * Hàm tạo dữ liệu test để debug nhanh
 * @returns {object} - Dữ liệu test giống như từ giao diện
 */
function getTestData() {
    var test_items = [
        {
            index: 1,
            item_name: "cá kho",
            item_quantity: 1,
            item_price: 20000,
            item_discount_item: 4000,
            item_tax_percent: 10,
            item_tax_amount: 1600,
            item_amount: 17600,
            item_amount_before_tax: 16000
        },
        {
            index: 2,
            item_name: "sản phẩm 2",
            item_quantity: 1,
            item_price: 100000,
            item_discount_item: 10000,
            item_tax_percent: 8,
            item_tax_amount: 7200,
            item_amount: 97200,
            item_amount_before_tax: 90000
        }
    ];
    
    var total_before_tax_value = 0;
    test_items.forEach(function(item) {
        total_before_tax_value += item.item_amount_before_tax;
    });
    
    return {
        items: test_items,
        total_before_tax_value: total_before_tax_value,
        invoice_discount_amount: 11836,
        invoice_service_amount: 0,
        invoice_amount: 95764
    };
}

/**
 * Hàm lấy thông tin các sản phẩm từ giao diện
 * @param {number} rowcount - Số dòng sản phẩm
 * @returns {object} - Chứa thông tin các sản phẩm và tổng tiền trước thuế
 */
function getItemsDataFromUI(rowcount) {
    var items_data = [];
    var total_before_tax_value = 0;
    
    for (var i = 1; i <= rowcount; i++) {   
        var item_name = $("#td_data_1_" + i).text().trim();
        var item_quantity = parseFloat($("#td_data_" + i + "_3").val().trim()) || 0;
        var item_price = parseFloat($("#td_data_" + i + "_10").val().trim()) || 0;
        var item_discount_item = parseFloat($("#td_data_" + i + "_8").val().trim()) || 0;
        var item_tax_percent = parseFloat($("#tr_tax_value_" + i).val().trim()) || 0;
        var item_tax_amount = parseFloat($("#td_data_" + i + "_11").val().trim()) || 0;
        var item_amount = parseFloat($("#td_data_" + i + "_9").val().trim()) || 0;
        
        // Tính tiền trước thuế ban đầu (sau giảm giá sản phẩm)
        var item_amount_before_tax = (item_quantity * item_price) - item_discount_item;
        total_before_tax_value += item_amount_before_tax;
        
        items_data.push({
            index: i,
            item_name: item_name,
            item_quantity: item_quantity,
            item_price: item_price,
            item_discount_item: item_discount_item,
            item_tax_percent: item_tax_percent,
            item_tax_amount: item_tax_amount,
            item_amount: item_amount,
            item_amount_before_tax: item_amount_before_tax
        });
    }
    
    return {
        items: items_data,
        total_before_tax_value: total_before_tax_value
    };
}

/**
 * Hàm tính toán phân bổ giảm giá và tính lại thuế
 * @param {array} items_data - Dữ liệu sản phẩm từ giao diện
 * @param {number} total_before_tax_value - Tổng tiền trước thuế
 * @param {number} invoice_discount_amount - Số tiền giảm giá hóa đơn
 * @returns {object} - Kết quả tính toán với các sản phẩm đã được xử lý
 */
function calculateDiscountAllocation(items_data, total_before_tax_value, invoice_discount_amount) {
    var data_items = [];
    var allocated_discount_total = 0;
    var rowcount = items_data.length;
    
    items_data.forEach(function(item, index) {
        var i = index + 1; // index bắt đầu từ 0, nhưng dòng bắt đầu từ 1
        
        // Tính giảm giá phân bổ dựa trên tỷ lệ tiền trước thuế
        var item_discount_from_all = 0;
        
        if (total_before_tax_value > 0 && invoice_discount_amount > 0) {
            // Nếu là dòng cuối cùng, gán phần giảm giá còn lại để tránh sai số làm tròn
            if (i === rowcount) {
                item_discount_from_all = invoice_discount_amount - allocated_discount_total;
            } else {
                // Phân bổ theo tỷ lệ tiền trước thuế của sản phẩm
                item_discount_from_all = (item.item_amount_before_tax / total_before_tax_value) * invoice_discount_amount;
                item_discount_from_all = Math.round(item_discount_from_all); // Làm tròn thành số nguyên
            }
            allocated_discount_total += item_discount_from_all;
        }
        
        // Tính lại sau khi có giảm giá phân bổ
        var item_amount_before_tax_final = item.item_amount_before_tax - item_discount_from_all;
        item_amount_before_tax_final = Math.round(item_amount_before_tax_final); // Làm tròn thành số nguyên
        
        // Làm tròn tiền thuế thành số nguyên (yêu cầu thuế)
        var item_tax_amount_recalc = (item_amount_before_tax_final * item.item_tax_percent) / 100;
        item_tax_amount_recalc = Math.round(item_tax_amount_recalc); // Làm tròn thành số nguyên
        
        // Làm tròn tổng tiền thành số nguyên (yêu cầu thuế)
        var item_amount_recalc = item_amount_before_tax_final + item_tax_amount_recalc;
        item_amount_recalc = Math.round(item_amount_recalc); // Làm tròn thành số nguyên
        
        data_items.push({
            item_name: item.item_name,
            item_quantity: item.item_quantity,
            item_price: item.item_price,
            item_discount_item: item.item_discount_item,
            item_discount_from_all: item_discount_from_all,
            item_tax_percent: item.item_tax_percent,
            item_tax_amount_original: item.item_tax_amount,
            item_tax_amount: item_tax_amount_recalc,
            item_amount_original: item.item_amount,
            item_amount_before_tax_original: item.item_amount_before_tax,
            item_amount_before_tax_final: item_amount_before_tax_final,
            item_amount: item_amount_recalc
        });
        
        // Log chi tiết từng sản phẩm để debug
        console.log('Sản phẩm ' + i + ': ' + item.item_name);
        console.log('  - Số lượng × Đơn giá:', item.item_quantity + ' × ' + item.item_price + ' = ' + (item.item_quantity * item.item_price));
        console.log('  - Giảm giá sản phẩm:', item.item_discount_item);
        console.log('  - Tiền trước thuế ban đầu:', item.item_amount_before_tax);
        console.log('  - Giảm giá phân bổ [LÀMTRÒN]:', item_discount_from_all);
        console.log('  - Tỷ lệ phân bổ:', (item.item_amount_before_tax / total_before_tax_value * 100).toFixed(2) + '%');
        console.log('  - Tiền trước thuế cuối [LÀMTRÒN]:', item_amount_before_tax_final);
        console.log('  - Thuế cũ (' + item.item_tax_percent + '%):', item.item_tax_amount);
        console.log('  - Thuế mới (' + item.item_tax_percent + '%) [LÀMTRÒN]:', item_tax_amount_recalc);
        console.log('  - Tổng tiền cũ:', item.item_amount);
        console.log('  - Tổng tiền mới [LÀMTRÒN]:', item_amount_recalc);
        console.log('  ⚠️  TẤT CẢ GIÁ TRỊ TIỀN ĐÃ LÀM TRÒN THÀNH SỐ NGUYÊN');
        console.log('  ---');
    });
    
    return {
        data_items: data_items,
        allocated_discount_total: allocated_discount_total
    };
}

/**
 * Hàm chính để tính toán hóa đơn điện tử - có thể gọi từ sales.js
 * @param {boolean} useTestData - true = sử dụng dữ liệu test, false = lấy từ giao diện
 * @param {number} roundingMethod - 1, 2, hoặc 3 để chọn phương án xử lý sai số
 * @returns {object} - Kết quả tính toán hóa đơn
 */
function processEInvoiceCalculation(useTestData = false, roundingMethod = 1) {
    // =================== CHẾ ĐỘ CẤU HÌNH ===================
    var USE_TEST_DATA = useTestData; // Được truyền từ tham số
    var ROUNDING_METHOD = roundingMethod; // Được truyền từ tham số
    
    console.log('🔧 E-INVOICE: Chế độ test =', USE_TEST_DATA, '| Phương án làm tròn =', ROUNDING_METHOD);
    
    // =================== PHƯƠNG ÁN XỬ LÝ SỐ LẺ ===================
    // Đã được truyền vào qua tham số roundingMethod
    
    var ui_data, invoice_discount_amount, invoice_service_amount, invoice_amount;
    
    if (USE_TEST_DATA) {
        console.log('🧪 CHẠY VỚI DỮ LIỆU TEST');
        var test_data = getTestData();
        ui_data = {
            items: test_data.items,
            total_before_tax_value: test_data.total_before_tax_value
        };
        invoice_discount_amount = test_data.invoice_discount_amount;
        invoice_service_amount = test_data.invoice_service_amount;
        invoice_amount = test_data.invoice_amount;
    } else {
        console.log('🌐 CHẠY VỚI DỮ LIỆU TỪ GIAO DIỆN');
        // Lấy số dòng của bảng có id sales_table
        var rowcount = $("#hidden_rowcount").val() - 1;
        
        // Lấy thông tin từ giao diện
        ui_data = getItemsDataFromUI(rowcount);
        invoice_discount_amount = parseFloat($("#discount_to_all_amt").text().trim()) || 0;
        invoice_service_amount = parseFloat($("#other_charges_amt").text().trim()) || 0;
        invoice_amount = parseFloat($("#total_amt").text().trim()) || 0;
    }
    
    // Bước 1: Hiển thị dữ liệu đầu vào
    console.log('=== DỮ LIỆU ĐẦU VÀO ===');
    console.log('Tổng tiền trước thuế ban đầu:', ui_data.total_before_tax_value);
    console.log('Số sản phẩm:', ui_data.items.length);
    console.log('Giảm giá hóa đơn:', invoice_discount_amount);
    console.log('Phí dịch vụ:', invoice_service_amount);
    console.log('Tổng hóa đơn:', invoice_amount);
    
    // Bước 2: Tính toán phân bổ giảm giá
    var calculation_result = calculateDiscountAllocation(ui_data.items, ui_data.total_before_tax_value, invoice_discount_amount);
    var data_items = calculation_result.data_items;
    var allocated_discount_total = calculation_result.allocated_discount_total;
    
    console.log('data_items', data_items);
    console.log('Total invoice discount:', invoice_discount_amount);
    console.log('Total allocated discount:', allocated_discount_total);
    
    // Bước 3: Kiểm tra tổng cộng
    
    // Tính tổng các giá trị
    var total_items_amount_recalc = 0;
    var total_discount_allocated = 0;
    var total_original_amount = 0;
    var total_tax_recalc = 0;
    var total_tax_original = 0;
    
    data_items.forEach(function(item) {
        total_items_amount_recalc += item.item_amount;
        total_discount_allocated += item.item_discount_from_all;
        total_original_amount += item.item_amount_original;
        total_tax_recalc += item.item_tax_amount;
        total_tax_original += item.item_tax_amount_original;
    });
    
    // Bước 4: Hiển thị kết quả kiểm tra
    console.log('=== KIỂM TRA TÍNH TOÁN ===');
    console.log('⚠️  LƯU Ý: Áp dụng quy tắc làm tròn thuế (tiền thuế & tổng tiền = số nguyên)');
    console.log('Tổng tiền trước thuế ban đầu:', ui_data.total_before_tax_value);
    console.log('Tổng item_amount gốc (từ giao diện):', total_original_amount);
    console.log('Tổng thuế gốc:', total_tax_original);
    console.log('Tổng thuế tính lại [LÀMTRÒN]:', total_tax_recalc);
    console.log('Tổng giảm giá đã phân bổ:', total_discount_allocated);
    console.log('Giảm giá tổng hóa đơn:', invoice_discount_amount);
    console.log('Chênh lệch giảm giá:', Math.abs(total_discount_allocated - invoice_discount_amount));
    console.log('Tổng tiền sản phẩm (sau tính lại) [LÀMTRÒN]:', total_items_amount_recalc);
    
    // Bước 5: Điều chỉnh sai số nếu cần
    console.log('=== KIỂM TRA TỔNG CỘNG ===');
    
    // So sánh với tổng hóa đơn thực tế (bao gồm phí dịch vụ)
    var expected_total_with_service = invoice_amount; // Tổng hóa đơn cuối cùng
    var actual_total_with_service = total_items_amount_recalc + invoice_service_amount;
    
    console.log('Tổng hóa đơn cuối cùng (mục tiêu): ' + expected_total_with_service);
    console.log('Tổng tính lại + phí dịch vụ: ' + actual_total_with_service);
    console.log('Chênh lệch với hóa đơn cuối: ' + Math.abs(actual_total_with_service - expected_total_with_service));
    
    // Điều chỉnh để đảm bảo tổng chính xác = invoice_amount
    var adjustment_needed = expected_total_with_service - actual_total_with_service;
    
    console.log('Cần điều chỉnh để khớp hóa đơn: ' + adjustment_needed);
    if (Math.abs(adjustment_needed) > 0.01) {
        console.log('=== ĐIỀU CHỈNH SAI SỐ ===');
        console.log('Cần điều chỉnh: ' + adjustment_needed);
        console.log('Phương án được chọn: ' + ROUNDING_METHOD);
        
        var last_item = data_items[data_items.length - 1];
        
        if (ROUNDING_METHOD === 1) {
            // Phương án 1: Điều chỉnh đơn giá sản phẩm cuối cùng
            console.log('=== PHƯƠNG ÁN 1: ĐIỀU CHỈNH ĐƠN GIÁ ===');
            console.log('Sai lệch cần điều chỉnh: ' + adjustment_needed);
            
            var old_price = last_item.item_price;
            
            // Cách đơn giản: Điều chỉnh đơn giá để bù sai số
            // Tính toán ngược từ số tiền cần thiết
            var price_adjustment = adjustment_needed / last_item.item_quantity;
            
            // Nếu có thuế, cần tính ngược qua thuế
            if (last_item.item_tax_percent > 0) {
                // adjustment_needed = (price_adjustment * quantity) * (1 + tax%)
                // => price_adjustment = adjustment_needed / (quantity * (1 + tax%))
                var tax_factor = 1 + (last_item.item_tax_percent / 100);
                price_adjustment = adjustment_needed / (last_item.item_quantity * tax_factor);
            }
            
            console.log('Điều chỉnh đơn giá tính toán: ' + price_adjustment);
            
            // Cập nhật đơn giá - làm tròn theo luật (tối đa 4 chữ số thập phân)
            last_item.item_price += price_adjustment;
            last_item.item_price = Math.round(last_item.item_price * 10000) / 10000; // Làm tròn 4 chữ số thập phân
            
            // Tính lại tất cả các giá trị từ đơn giá mới
            var new_subtotal_1 = last_item.item_quantity * last_item.item_price;
            var new_before_tax_1 = new_subtotal_1 - last_item.item_discount_item;
            new_before_tax_1 = Math.round(new_before_tax_1); // Làm tròn số nguyên
            var new_before_tax_final_1 = new_before_tax_1 - last_item.item_discount_from_all;
            new_before_tax_final_1 = Math.round(new_before_tax_final_1); // Làm tròn số nguyên
            var new_tax_1 = Math.round((new_before_tax_final_1 * last_item.item_tax_percent) / 100);
            var new_amount_1 = new_before_tax_final_1 + new_tax_1; // Không cần làm tròn vì đã là số nguyên
            
            // Kiểm tra xem có đạt mục tiêu chưa, nếu chưa thì điều chỉnh trực tiếp tổng tiền
            var actual_adjustment = new_amount_1 - last_item.item_amount;
            var remaining_adjustment = adjustment_needed - actual_adjustment;
            
            console.log('Điều chỉnh thực tế: ' + actual_adjustment);
            console.log('Còn lại cần điều chỉnh: ' + remaining_adjustment);
            
            if (Math.abs(remaining_adjustment) > 0.01) {
                console.log('⚠️ Điều chỉnh đơn giá chưa đủ, điều chỉnh trực tiếp tổng tiền');
                new_amount_1 += remaining_adjustment;
                // Cần điều chỉnh lại thuế để đảm bảo logic: tiền_trước_thuế + thuế = tổng_tiền
                new_tax_1 = new_amount_1 - new_before_tax_final_1;
                console.log('Thuế đã được điều chỉnh lại: ' + new_tax_1);
            }
            
            // Kiểm tra tính nhất quán cuối cùng
            var calculated_total = new_before_tax_final_1 + new_tax_1;
            if (Math.abs(calculated_total - new_amount_1) > 0.01) {
                console.log('⚠️ Phát hiện sai lệch logic: Tiền trước thuế + Thuế ≠ Tổng tiền');
                console.log('Tiền trước thuế cuối: ' + new_before_tax_final_1);
                console.log('Thuế: ' + new_tax_1);
                console.log('Tổng tính toán: ' + calculated_total);
                console.log('Tổng thực tế: ' + new_amount_1);
                console.log('Chênh lệch: ' + (calculated_total - new_amount_1));
                
                // Điều chỉnh thuế để đảm bảo tính nhất quán
                new_tax_1 = new_amount_1 - new_before_tax_final_1;
                console.log('Thuế đã được điều chỉnh để đảm bảo nhất quán: ' + new_tax_1);
            }
            
            // Cập nhật các giá trị
            last_item.item_amount_before_tax_original = new_before_tax_1;
            last_item.item_amount_before_tax_final = new_before_tax_final_1;
            last_item.item_tax_amount = new_tax_1;
            last_item.item_amount = new_amount_1;
            last_item.price_adjustment = last_item.item_price - old_price;
            
            console.log('Đơn giá cũ: ' + old_price.toFixed(4));
            console.log('Đơn giá mới (tuân thủ luật): ' + last_item.item_price.toFixed(4));
            console.log('Điều chỉnh đơn giá: ' + last_item.price_adjustment.toFixed(4));
            console.log('⚠️ Đơn giá đã được làm tròn tối đa 4 chữ số thập phân (theo luật)');
            console.log('Tiền trước thuế mới: ' + new_before_tax_1);
            console.log('Tiền trước thuế cuối mới: ' + new_before_tax_final_1);
            console.log('Thuế mới: ' + new_tax_1);
            console.log('Tổng tiền mới: ' + new_amount_1);
            
        } else if (ROUNDING_METHOD === 2) {
            // Phương án 2: Điều chỉnh giảm giá sản phẩm cuối cùng
            console.log('=== PHƯƠNG ÁN 2: ĐIỀU CHỈNH GIẢM GIÁ SẢN PHẨM ===');
            var old_discount = last_item.item_discount_item;
            last_item.item_discount_item -= adjustment_needed; // Trừ để tăng tổng tiền
            
            // Tính lại các giá trị liên quan
            var new_before_tax_2 = (last_item.item_quantity * last_item.item_price) - last_item.item_discount_item;
            new_before_tax_2 = Math.round(new_before_tax_2); // Làm tròn số nguyên
            var new_before_tax_final_2 = new_before_tax_2 - last_item.item_discount_from_all;
            new_before_tax_final_2 = Math.round(new_before_tax_final_2); // Làm tròn số nguyên
            var new_tax_2 = Math.round((new_before_tax_final_2 * last_item.item_tax_percent) / 100);
            var new_amount_2 = Math.round(new_before_tax_final_2 + new_tax_2);
            
            // Cập nhật các giá trị
            last_item.item_amount_before_tax_original = new_before_tax_2;
            last_item.item_amount_before_tax_final = new_before_tax_final_2;
            last_item.item_tax_amount = new_tax_2;
            last_item.item_amount = new_amount_2;
            last_item.discount_adjustment = -adjustment_needed;
            
            console.log('Giảm giá sản phẩm cũ: ' + old_discount);
            console.log('Giảm giá sản phẩm mới: ' + last_item.item_discount_item);
            console.log('Điều chỉnh giảm giá: ' + (-adjustment_needed));
            
        } else {
            // Phương án 3: Điều chỉnh tổng tiền sản phẩm cuối cùng (cách hiện tại)
            console.log('=== PHƯƠNG ÁN 3: ĐIỀU CHỈNH TỔNG TIỀN ===');
            last_item.item_amount += adjustment_needed;
            last_item.adjustment = adjustment_needed;
            console.log('Điều chỉnh tổng tiền: ' + adjustment_needed);
        }
        
        // Tính lại tổng
        total_items_amount_recalc = 0;
        data_items.forEach(function(item) {
            total_items_amount_recalc += item.item_amount;
        });
        
        console.log('Tổng sau điều chỉnh: ' + total_items_amount_recalc);
        console.log('Sản phẩm được điều chỉnh: ' + last_item.item_name);
    }
    
    // Bước 6: Kiểm tra kết quả cuối cùng
    console.log('=== SO SÁNH VỚI HÓA ĐƠN ===');
    console.log('Tổng tiền sản phẩm tính lại:', total_items_amount_recalc);
    console.log('Phí dịch vụ:', invoice_service_amount);
    console.log('Tổng hóa đơn mục tiêu:', invoice_amount);
    console.log('Tổng tính lại + phí dịch vụ:', total_items_amount_recalc + invoice_service_amount);
    console.log('Chênh lệch cuối cùng:', Math.abs((total_items_amount_recalc + invoice_service_amount) - invoice_amount));
    
    // Kiểm tra kết quả cuối cùng
    var final_difference = Math.abs((total_items_amount_recalc + invoice_service_amount) - invoice_amount);
    if (final_difference < 0.01) {
        console.log('✅ THÀNH CÔNG: Tổng khớp chính xác với hóa đơn!');
    } else {
        console.log('❌ VẪN CÒN SAI LỆCH: ' + final_difference);
        console.log('💡 Lưu ý: Cần kiểm tra lại dữ liệu test hoặc logic tính toán');
    }
    
    // Trả về kết quả để sử dụng ở nơi khác
    return {
        success: final_difference < 0.01,
        data_items: data_items,
        total_items_amount: total_items_amount_recalc,
        total_discount_allocated: allocated_discount_total,
        invoice_discount_amount: invoice_discount_amount,
        invoice_service_amount: invoice_service_amount,
        final_invoice_amount: invoice_amount,
        final_difference: final_difference,
        calculation_summary: {
            original_amount: total_original_amount,
            tax_original: total_tax_original,
            tax_recalculated: total_tax_recalc,
            total_before_tax: ui_data.total_before_tax_value
        }
    };
}

/**
 * Hàm tương thích với code cũ (backward compatibility)
 */
function get_data_einvoice() {
    return processEInvoiceCalculation(true, 1); // Sử dụng test data, phương án 1
}