<!-- Order Info Modal -->
<div class="modal fade" id="orderInfoModal" tabindex="-1" role="dialog" aria-labelledby="orderInfoModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 90%; max-width: 1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="orderInfoModalLabel">Thông tin chi tiết đơn hàng</h4>
        <div class="pull-right" style="margin-top: -25px; margin-right: 30px;">
          <!-- <button type="button" class="btn btn-sm btn-info" id="createJsonEInvoiceBtn">
            <i class="fa fa-cog"></i> Tạo Json
          </button>
          <button type="button" class="btn btn-sm btn-info" id="configEInvoiceBtn">
            <i class="fa fa-cog"></i> Cấu hình HĐ điện tử
          </button> -->
          <button type="button" class="btn btn-sm btn-primary" id="saveEInvoiceBtn">
            <i class="fa fa-paper-plane"></i> Phát hành hóa đơn điện tử
          </button>
          <!-- <button type="button" class="btn btn-sm btn-success" id="viewEInvoiceJsonBtn">
            <i class="fa fa-file-code-o"></i> Xem JSON
          </button> -->
           <button type="button" class="btn btn-sm btn-success" id="viewEInvoicePdfBtn">
             <i class="fa fa-file-pdf-o"></i> Xem PDF
           </button>
          <!-- <button type="button" class="btn btn-sm btn-primary" id="editOrderBtn" style="display: none;">
            <i class="fa fa-edit"></i> Sửa
          </button>
          <button type="button" class="btn btn-sm btn-success" id="saveOrderBtn" style="display: none;">
            <i class="fa fa-save"></i> Lưu
          </button> -->
          <button type="button" class="btn btn-sm btn-danger" id="cancelEditBtn" style="display: none;">
            <i class="fa fa-times"></i> Hủy
          </button>
        </div>
      </div>
      <div class="modal-body" id="orderInfoContent" style="max-height: 70vh; overflow-y: auto;">
        <!-- Alert container for notifications -->
        <div id="alert-container"></div>
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

<!-- E-Invoice Configuration Modal -->
<div class="modal fade" id="eInvoiceConfigModal" tabindex="-1" role="dialog" aria-labelledby="eInvoiceConfigModalLabel">
  <div class="modal-dialog modal-md" role="document" style="width: 70%; max-width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="eInvoiceConfigModalLabel">
          <i class="fa fa-cog"></i> Cấu hình kết nối hóa đơn điện tử
        </h4>
      </div>
      <div class="modal-body">
        <form id="eInvoiceConfigForm">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h5 class="panel-title">
                    <i class="fa fa-plug"></i> Thông tin kết nối API
                  </h5>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <label for="api_url">
                      <i class="fa fa-link"></i> Link kết nối API <span class="text-danger">*</span>
                    </label>
                    <input type="url" class="form-control" id="api_url" name="api_url" 
                           placeholder="https://api.example.com/einvoice" required>
                    <small class="help-block">Nhập đường dẫn API đầy đủ của nhà cung cấp hóa đơn điện tử</small>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="api_username">
                          <i class="fa fa-user"></i> Tài khoản kết nối API <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="api_username" name="api_username" 
                               placeholder="username" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="api_password">
                          <i class="fa fa-lock"></i> Mật khẩu kết nối API <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                          <input type="password" class="form-control" id="api_password" name="api_password" 
                                 placeholder="••••••••" required>
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default" id="togglePassword">
                              <i class="fa fa-eye"></i>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="provider_code">
                      <i class="fa fa-building"></i> Mã nhà cung cấp <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="provider_code" name="provider_code" 
                           placeholder="PROVIDER_CODE" required>
                    <small class="help-block">Mã định danh do nhà cung cấp hóa đơn điện tử cấp</small>
                  </div>
                </div>
              </div>
              
              <div class="panel panel-warning">
                <div class="panel-heading">
                  <h5 class="panel-title">
                    <i class="fa fa-test-tube"></i> Kiểm tra kết nối
                  </h5>
                </div>
                <div class="panel-body">
                  <div class="form-group">
                    <button type="button" class="btn btn-warning" id="testConnectionBtn">
                      <i class="fa fa-plug"></i> Kiểm tra kết nối API
                    </button>
                    <div id="connectionStatus" class="mt-2"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <i class="fa fa-times"></i> Đóng
        </button>
        <button type="button" class="btn btn-primary" id="saveEInvoiceConfigBtn">
          <i class="fa fa-save"></i> Lưu cấu hình
        </button>
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
  .order-info-modal .editable-field {
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 3px 8px;
    border-radius: 3px;
    min-width: 100px;
  }
  .order-info-modal .editable-field:focus {
    border-color: #3c8dbc;
    box-shadow: 0 0 5px rgba(60, 141, 188, 0.3);
  }
  .order-info-modal .item-qty-input {
    width: 60px;
    text-align: center;
  }
  .order-info-modal .item-price-input {
    width: 120px;
    text-align: right;
  }
  .order-info-modal .item-name-input {
    width: 180px;
  }
  .order-info-modal .item-discount-percent-input,
  .order-info-modal .item-tax-percent-input {
    width: 70px;
    text-align: center;
  }
  .order-info-modal .table-bordered {
    font-size: 12px;
  }
  .order-info-modal .table-bordered th,
  .order-info-modal .table-bordered td {
    padding: 8px 4px;
    vertical-align: middle;
  }
  .order-info-modal .table-bordered th {
    font-size: 11px;
  }
  .order-info-modal .item-bill-discount-percent,
  .order-info-modal .item-bill-discount-amount {
    font-size: 11px;
    color: #e74c3c;
    font-weight: bold;
  }
  .order-info-modal .form-group {
    margin-bottom: 10px;
  }
  .order-info-modal .form-group label {
    font-weight: bold;
    font-size: 13px;
  }
  .order-info-modal .input-group {
    margin-bottom: 0;
  }
  .order-info-modal .input-group .form-control {
    text-align: right;
  }
  .order-info-modal .table-condensed {
    font-size: 13px;
  }
  .order-info-modal .table-condensed th {
    background-color: #f8f9fa;
    font-weight: bold;
  }
  .order-info-modal .summary-section {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-top: 10px;
  }
  .order-info-modal .bill-discount-section {
    background-color: #fff;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-top: 10px;
  }
  .order-info-modal .bill-discount-section h5 {
    margin-top: 0;
    color: #3c8dbc;
  }
  .edit-mode .view-only {
    display: none;
  }
  .view-mode .edit-only {
    display: none;
  }
  /* Address and item fields are always editable */
  #edit_address,
  .item-qty-input,
  .item-price-input,
  .item-name-input,
  .item-discount-percent-input,
  .item-tax-percent-input,
  #bill_discount_percent,
  #bill_discount_amount {
    display: block !important;
  }
  
  /* E-Invoice Config Modal Styles */
  #eInvoiceConfigModal .panel {
    margin-bottom: 20px;
  }
  #eInvoiceConfigModal .panel-heading {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
  }
  #eInvoiceConfigModal .panel-title {
    font-size: 14px;
    font-weight: bold;
  }
  #eInvoiceConfigModal .form-group label {
    font-weight: bold;
    color: #495057;
  }
  #eInvoiceConfigModal .text-danger {
    color: #dc3545 !important;
  }
  #eInvoiceConfigModal .help-block {
    color: #6c757d;
    font-size: 12px;
  }
  #eInvoiceConfigModal .input-group-btn .btn {
    border-left: none;
  }
  #connectionStatus {
    margin-top: 10px;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 13px;
  }
  #connectionStatus.success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
  }
  #connectionStatus.error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
  }
  #connectionStatus.testing {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
  }
</style>

<script>
// Global variables
console.log('Order Info Modal Script Loaded');
var originalOrderData = null;
var isEditMode = false;

// Ensure jQuery is loaded before running
$(document).ready(function() {
    console.log('Order Info Modal Script Loaded');
    
    // Check if required functions exist
    if (typeof formatNumber === 'undefined') {
        console.error('formatNumber function not defined');
    }
    if (typeof updateGrandTotal === 'undefined') {
        console.error('updateGrandTotal function not defined');
    }
});

// Utility functions
function formatNumber(num, decimals = 0) {
    if (isNaN(num) || num === null || num === undefined) {
        return '0';
    }
    
    // Round the number to specified decimal places
    var roundedNum = Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
    
    // Format with comma for thousands separator
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: decimals
    }).format(roundedNum);
}

// Loading overlay functions
function showLoadingOverlay(title, subtitle) {
    title = title || 'Đang xử lý...';
    subtitle = subtitle || 'Vui lòng đợi trong giây lát';
    
    var loadingOverlay = '<div id="globalLoadingOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">' +
                         '<div style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">' +
                         '<i class="fa fa-spinner fa-spin fa-3x" style="color: #007bff; margin-bottom: 15px;"></i>' +
                         '<h4 style="margin: 0; color: #333;">' + title + '</h4>' +
                         '<p style="margin: 5px 0 0 0; color: #666;">' + subtitle + '</p>' +
                         '</div></div>';
    
    // Remove existing overlay if any
    $('#globalLoadingOverlay').remove();
    $('body').append(loadingOverlay);
}

function hideLoadingOverlay() {
    $('#globalLoadingOverlay').remove();
}

function formatCurrency(amount) {
    if (isNaN(amount) || amount === null || amount === undefined) {
        return '0 đ';
    }
    // Format với dấu phẩy cho hàng nghìn và dấu chấm cho phần thập phân
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    }).format(amount) + ' đ';
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    var date = new Date(dateString);
    return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'});
}

// Show alert function
function showAlert(type, message) {
    // Đảm bảo alert container tồn tại
    if ($('#alert-container').length === 0) {
        console.log('Alert container not found, creating one');
        // Tìm modal body để thêm alert container
        var modalBody = $('#orderInfoContent');
        if (modalBody.length === 0) {
            modalBody = $('.modal-body').first();
        }
        if (modalBody.length === 0) {
            modalBody = $('.box-body');
        }
        if (modalBody.length === 0) {
            modalBody = $('body');
        }
        modalBody.prepend('<div id="alert-container"></div>');
    }
    
    var alertClass = 'alert-' + type;
    if (type === 'success') {
        alertClass = 'alert-success';
    } else if (type === 'danger') {
        alertClass = 'alert-danger';
    } else if (type === 'warning') {
        alertClass = 'alert-warning';
    } else if (type === 'info') {
        alertClass = 'alert-info';
    }
    
    var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible" role="alert" style="display: none; margin: 10px 0;">' +
                    message +
                    '<button type="button" class="close" onclick="$(this).parent().fadeOut();" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '</div>';
    
    // Xóa alert cũ và thêm alert mới
    $('#alert-container').html(alertHtml);
    $('#alert-container .alert').fadeIn();
    
    // Scroll to top để user có thể thấy alert
    $('#orderInfoContent').scrollTop(0);
    
    // Tự động ẩn alert sau 5 giây
    setTimeout(function() {
        $('#alert-container .alert').fadeOut();
    }, 9000);
}

// Calculate subtotal of all items
function calculateSubtotal() {
    var subtotal = 0;
    $('.item-row').each(function() {
        var qty = parseFloat($(this).find('.item-qty-input').val()) || 0;
        var price = parseFloat($(this).find('.item-price-input').val().replace(/,/g, '')) || 0;
        var discountPercent = parseFloat($(this).find('.item-discount-percent-input').val()) || 0;
        var taxPercent = parseFloat($(this).find('.item-tax-percent-input').val()) || 0;
        
        // Calculate item subtotal
        var itemSubtotal = qty * price;
        
        // Calculate item discount amount
        var itemDiscountAmount = (itemSubtotal * discountPercent) / 100;
        
        // Calculate after item discount
        var afterItemDiscount = itemSubtotal - itemDiscountAmount;
        
        // Calculate item tax amount
        var itemTaxAmount = (afterItemDiscount * taxPercent) / 100;
        
        // Calculate item total
        var itemTotal = afterItemDiscount + itemTaxAmount;
        
        subtotal += itemTotal;
    });
    
    return subtotal;
}

// Calculate item total for a specific row
function calculateItemTotal(row) {
    var qty = parseFloat(row.find('.item-qty-input').val()) || 0;
    var price = parseFloat(row.find('.item-price-input').val().replace(/,/g, '')) || 0;
    var discountPercent = parseFloat(row.find('.item-discount-percent-input').val()) || 0;
    var taxPercent = parseFloat(row.find('.item-tax-percent-input').val()) || 0;
    
    // Calculate subtotal
    var subtotal = qty * price;
    
    // Calculate discount amount
    var discountAmount = (subtotal * discountPercent) / 100;
    
    // Calculate after discount
    var afterDiscount = subtotal - discountAmount;
    
    // Calculate tax amount
    var taxAmount = (afterDiscount * taxPercent) / 100;
    
    // Calculate final total
    var total = afterDiscount + taxAmount;
    
    // Update display
    row.find('.item-discount-amount').text(formatCurrency(discountAmount));
    row.find('.item-tax-amount').text(formatCurrency(taxAmount));
    row.find('.item-total').text(formatCurrency(total));
    
    // Calculate bill discount allocation for this item
    calculateBillDiscountAllocation(row);
}

// Calculate bill discount allocation for each item
function calculateBillDiscountAllocation(row) {
    var billDiscountAmount = parseFloat($('#bill_discount_amount').val().replace(/,/g, '')) || 0;
    
    if (billDiscountAmount > 0) {
        // Get this item's subtotal (before item discount)
        var qty = parseFloat(row.find('.item-qty-input').val()) || 0;
        var price = parseFloat(row.find('.item-price-input').val().replace(/,/g, '')) || 0;
        var itemSubtotal = qty * price;
        
        // Calculate total subtotal of all items
        var totalSubtotal = 0;
        $('.item-row').each(function() {
            var itemQty = parseFloat($(this).find('.item-qty-input').val()) || 0;
            var itemPrice = parseFloat($(this).find('.item-price-input').val().replace(/,/g, '')) || 0;
            totalSubtotal += itemQty * itemPrice;
        });
        
        if (totalSubtotal > 0) {
            // Calculate this item's share of bill discount
            var itemBillDiscountAmount = (itemSubtotal / totalSubtotal) * billDiscountAmount;
            var itemBillDiscountPercent = itemSubtotal > 0 ? (itemBillDiscountAmount / itemSubtotal) * 100 : 0;
            
            // Update display
            row.find('.item-bill-discount-percent').text(itemBillDiscountPercent.toFixed(2) + '%');
            row.find('.item-bill-discount-amount').text(formatCurrency(itemBillDiscountAmount));
        } else {
            row.find('.item-bill-discount-percent').text('0%');
            row.find('.item-bill-discount-amount').text(formatCurrency(0));
        }
    } else {
        row.find('.item-bill-discount-percent').text('0%');
        row.find('.item-bill-discount-amount').text(formatCurrency(0));
    }
}

// Update all items bill discount allocation
function updateAllBillDiscountAllocation() {
    $('.item-row').each(function() {
        calculateBillDiscountAllocation($(this));
    });
}

// Update grand total with bill discount
function updateGrandTotal() {
    var subtotal = calculateSubtotal();
    
    // Bill discount
    var billDiscountAmount = parseFloat($('#bill_discount_amount').val().replace(/,/g, '')) || 0;
    
    // Grand total after bill discount
    var grandTotal = subtotal - billDiscountAmount;
    
    // Update displays
    if ($('#subtotal_amount').length) {
        $('#subtotal_amount').text(formatCurrency(subtotal));
    }
    if ($('#total_bill_discount').length) {
        $('#total_bill_discount').text(formatCurrency(billDiscountAmount));
    }
    if ($('#final_total').length) {
        $('#final_total').text(formatCurrency(grandTotal));
    }
    
    // Update item totals
    $('.item-row').each(function() {
        calculateItemTotal($(this));
    });
    
    // Update bill discount allocation for all items
    updateAllBillDiscountAllocation();
    
    // Also update old displays if they exist
    if ($('#grand_total_display').length) {
        $('#grand_total_display').text(formatCurrency(grandTotal));
    }
}

// Helper functions for status labels
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
    
    if (selectedIds.length > 1) {
        alert("Chỉ có thể sửa một đơn hàng tại một thời điểm!");
        return;
    }
    
    // Show modal
    $('#orderInfoModal').modal('show');
    
    // Reset modal content and buttons
    
    resetEditMode();
    
    // AJAX call to get order details
    $.ajax({
        url: "<?php echo site_url('sales/get_vatinvoice_data'); ?>",
        type: "POST",
        data: {
            order_ids: selectedIds
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                originalOrderData = response.data; // Store original data
                var html = buildOrderInfoHTML(response.data);
                $('#orderInfoContent').html(html);
                $('#editOrderBtn').show();
                
                // Auto enable edit mode for address and items
                enablePartialEditMode();
                
                // Calculate initial totals for all items
                setTimeout(function() {
                    if (typeof calculateItemTotal === 'function' && typeof updateGrandTotal === 'function') {
                        $('.item-row').each(function() {
                            calculateItemTotal($(this));
                        });
                        updateGrandTotal();
                        
                        // Format price inputs
                        $('.item-price-input').each(function() {
                            var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                            if (value > 0 && typeof formatNumber === 'function') {
                                $(this).val(formatNumber(value));
                            }
                        });
                    } else {
                        console.error('Required functions not available');
                    }
                }, 100);
            } else {
                $('#orderInfoContent').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + response.message + '</div>');
            }
        },
        error: function() {
            $('#orderInfoContent').html('<div class="alert alert-danger">Không thể tải thông tin đơn hàng. Vui lòng thử lại!</div>');
        }
    });
}

function hide_order_info() {
    $('#editOrderBtn').modal('hide');
    resetEditMode();
    originalOrderData = null; // Clear original data
}

function closePopup() {
    $('#orderInfoModal').modal('hide');
    resetEditMode();
    originalOrderData = null; // Clear original data
}

// Edit mode functions
function enablePartialEditMode() {
    // Address and items are already editable by default
    // Just ensure they're not readonly
    $('#edit_address').prop('readonly', false);
    $('.item-qty-input, .item-price-input, .item-name-input, .item-discount-percent-input, .item-tax-percent-input').prop('readonly', false);
    
    // Enable invoice discount fields
    $('#edit_invoice_discount_percent, #edit_invoice_discount_amount').prop('readonly', false);
    
    // Show save and cancel buttons
    $('#saveOrderBtn, #cancelEditBtn').show();
}

function toggleEditMode() {
    isEditMode = !isEditMode;
    
    if (isEditMode) {
        $('#orderInfoContent').addClass('edit-mode').removeClass('view-mode');
        $('#editOrderBtn').hide();
        $('#saveOrderBtn, #cancelEditBtn').show();
        
        // Enable all editable fields
        $('.editable-field').prop('readonly', false);
        $('.editable-select').prop('disabled', false);
    } else {
        $('#orderInfoContent').addClass('view-mode').removeClass('edit-mode');
        $('#editOrderBtn').show();
        $('#saveOrderBtn, #cancelEditBtn').hide();
        
        // Disable all editable fields
        $('.editable-field').prop('readonly', true);
        $('.editable-select').prop('disabled', true);
        
        // But keep address and items editable
        enablePartialEditMode();
    }
}

function resetEditMode() {
    isEditMode = false;
    $('#orderInfoContent').removeClass('edit-mode').addClass('view-mode');
    $('#editOrderBtn').hide();
    $('#saveOrderBtn, #cancelEditBtn').show(); // Keep save/cancel buttons visible
}

function cancelEdit() {
    if (originalOrderData) {
        var html = buildOrderInfoHTML([originalOrderData]);
        $('#orderInfoContent').html(html);
        // Reset to partial edit mode instead of full view mode
        enablePartialEditMode();
        
        // Recalculate totals
        setTimeout(function() {
            $('.item-row').each(function() {
                calculateItemTotal($(this));
            });
            updateGrandTotal();
            
            // Format price inputs
            $('.item-price-input').each(function() {
                var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                if (value > 0) {
                    $(this).val(formatNumber(value));
                }
            });
        }, 100);
    }
}

function saveOrderChanges() {
    if (!originalOrderData) {
        alert("Không có dữ liệu gốc để lưu!");
        return;
    }
    
    // Collect updated data
    var updatedOrder = {
        id: originalOrderData.id,
        customer_name: $('#edit_customer_name').val(),
        mobile: $('#edit_mobile').val(),
        address: $('#edit_address').val(),
        sales_note: $('#edit_sales_note').val(),
        sales_status: $('#edit_sales_status').val(),
        bill_discount_percent: parseFloat($('#bill_discount_percent').val()) || 0,
        bill_discount_amount: parseFloat($('#bill_discount_amount').val().replace(/,/g, '')) || 0,
        items: []
    };
    
    // Collect updated items
    $('.item-row').each(function() {
        var itemId = $(this).data('item-id');
        var itemName = $(this).find('.item-name-input').val();
        var qty = parseFloat($(this).find('.item-qty-input').val()) || 0;
        var price = parseFloat($(this).find('.item-price-input').val().replace(/,/g, '')) || 0;
        var discountPercent = parseFloat($(this).find('.item-discount-percent-input').val()) || 0;
        var taxPercent = parseFloat($(this).find('.item-tax-percent-input').val()) || 0;
        
        // Calculate amounts
        var subtotal = qty * price;
        var discountAmount = (subtotal * discountPercent) / 100;
        var afterDiscount = subtotal - discountAmount;
        var taxAmount = (afterDiscount * taxPercent) / 100;
        var totalCost = afterDiscount + taxAmount;
        
        updatedOrder.items.push({
            item_id: itemId,
            item_name: itemName,
            sales_qty: qty,
            price_per_unit: price,
            discount_percent: discountPercent,
            discount_amount: discountAmount,
            tax_percent: taxPercent,
            tax_amount: taxAmount,
            total_cost: totalCost
        });
    });
    
    // Calculate subtotal and grand total
    var subtotal = updatedOrder.items.reduce(function(sum, item) {
        return sum + item.total_cost;
    }, 0);
    
    updatedOrder.subtotal_amount = subtotal;
    updatedOrder.grand_total = subtotal - updatedOrder.bill_discount_amount;
    
    // Show loading
    $('#saveOrderBtn').html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');
    
    // AJAX call to save changes
    $.ajax({
        url: "<?php echo site_url('sales/update_order_details'); ?>",
        type: "POST",
        data: {
            order_data: updatedOrder
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert("Cập nhật thành công!");
                // Refresh the order data
                originalOrderData = response.data;
                var html = buildOrderInfoHTML([response.data]);
                $('#orderInfoContent').html(html);
                
                // Keep partial edit mode active
                enablePartialEditMode();
                
                // Recalculate totals
                setTimeout(function() {
                    $('.item-row').each(function() {
                        calculateItemTotal($(this));
                    });
                    updateGrandTotal();
                    
                    // Update bill discount allocation
                    updateAllBillDiscountAllocation();
                    
                    // Format price inputs
                    $('.item-price-input').each(function() {
                        var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                        if (value > 0) {
                            $(this).val(formatNumber(value));
                        }
                    });
                }, 100);
                
                // Refresh the main table
                $('#example2').DataTable().ajax.reload();
            } else {
                alert("Có lỗi xảy ra: " + response.message);
            }
        },
        error: function() {
            alert("Không thể lưu thay đổi. Vui lòng thử lại!");
        },
        complete: function() {
            $('#saveOrderBtn').html('<i class="fa fa-save"></i> Lưu');
        }
    });
}

// Event handlers - using document ready to ensure DOM is loaded
$(document).ready(function() {
    // Event handlers
    $(document).on('click', '#editOrderBtn', function() {
        toggleEditMode();
    });

    $(document).on('click', '#saveOrderBtn', function() {
        saveOrderChanges();
    });

    $(document).on('click', '#cancelEditBtn', function() {
      //  cancelEdit();
        closePopup();
        hide_order_info();
    });

    // Auto calculate item total when qty or price changes
    $(document).on('input change', '.item-qty-input, .item-price-input, .item-discount-percent-input, .item-tax-percent-input', function() {
        var row = $(this).closest('.item-row');
        calculateItemTotal(row);
        updateGrandTotal();
    });

    // Auto calculate when bill discount changes
    $(document).on('input change', '#bill_discount_percent, #bill_discount_amount', function() {
        var field = $(this).attr('id');
        
        if (field === 'bill_discount_percent') {
            var discountPercent = parseFloat($(this).val()) || 0;
            var subtotal = parseFloat($('#subtotal_amount').text().replace(/[^\d.,]/g, '').replace(/,/g, '')) || 0;
            var discountAmount = subtotal * (discountPercent / 100);
            $('#bill_discount_amount').val(formatNumber(discountAmount));
        } else if (field === 'bill_discount_amount') {
            var discountAmount = parseFloat($(this).val().replace(/,/g, '')) || 0;
            var subtotal = parseFloat($('#subtotal_amount').text().replace(/[^\d.,]/g, '').replace(/,/g, '')) || 0;
            var discountPercent = subtotal > 0 ? (discountAmount / subtotal) * 100 : 0;
            $('#bill_discount_percent').val(discountPercent.toFixed(2));
        }
        
        updateGrandTotal();
    });

    // Format price input with thousand separator
    $(document).on('blur', '.item-price-input, #bill_discount_amount', function() {
        var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
        $(this).val(formatNumber(value));
    });

    // Remove formatting when focus for easy editing
    $(document).on('focus', '.item-price-input, #bill_discount_amount', function() {
        var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
        if (value > 0) {
            $(this).val(value.toString());
        } else {
            $(this).val('');
        }
    });
});

// Calculate item total for a specific row
// Calculate item total for a specific row (second instance)
function calculateItemTotal(row) {
    var qty = parseFloat(row.find('.item-qty-input').val()) || 0;
    var price = parseFloat(row.find('.item-price-input').val().replace(/,/g, '')) || 0;
    var discountPercent = parseFloat(row.find('.item-discount-percent-input').val()) || 0;
    var taxPercent = parseFloat(row.find('.item-tax-percent-input').val()) || 0;
    
    // Calculate subtotal
    var subtotal = qty * price;
    
    // Calculate discount amount
    var discountAmount = (subtotal * discountPercent) / 100;
    
    // Calculate after discount
    var afterDiscount = subtotal - discountAmount;
    
    // Calculate tax amount
    var taxAmount = (afterDiscount * taxPercent) / 100;
    
    // Calculate final total
    var total = afterDiscount + taxAmount;
    
    // Update display
    row.find('.item-discount-amount').text(formatCurrency(discountAmount));
    row.find('.item-tax-amount').text(formatCurrency(taxAmount));
    row.find('.item-total').text(formatCurrency(total));
    
    // Calculate bill discount allocation for this item
    calculateBillDiscountAllocation(row);
}

// Main modal initialization
$(document).ready(function() {
    // Global variables
    console.log('Order Info Modal Script Loaded originalOrderData');
    originalOrderData = null;
    isEditMode = false;
    
    // Function to show order information
    window.show_order_info = function() {
        var selectedIds = [];
        $(".column_checkbox:checked").each(function() {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length === 0) {
            alert("Vui lòng chọn ít nhất một đơn hàng!");
            return;
        }
        
        if (selectedIds.length > 1) {
            alert("Chỉ có thể sửa một đơn hàng tại một thời điểm!");
            return;
        }
        
        // Show modal
        $('#orderInfoModal').modal('show');
        
        // Reset modal content and buttons
        $('#orderInfoContent').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Đang tải dữ liệu...</p></div>');
        resetEditMode();
        
        // AJAX call to get order details
        $.ajax({
            url: "<?php echo site_url('sales/get_vatinvoice_data'); ?>",
            type: "POST",
            data: {
                order_ids: selectedIds
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    originalOrderData = response.data; // Store original data
                    console.log('Original Order Data:', originalOrderData);
                    console.log('Response Data:', response.data);
                    var html = buildOrderInfoHTML(response.data);
                    $('#orderInfoContent').html(html);
                    $('#editOrderBtn').show();
                    
                    // Auto enable edit mode for address and items
                    enablePartialEditMode();
                    
                    // Calculate initial totals for all items
                    $('.item-row').each(function() {
                        calculateItemTotal($(this));
                    });
                    updateGrandTotal();
                    
                    // Update bill discount allocation
                    updateAllBillDiscountAllocation();
                    
                    // Format price inputs
                    $('.item-price-input').each(function() {
                        var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                        $(this).val(formatNumber(value));
                    });
                } else {
                    $('#orderInfoContent').html('<div class="alert alert-danger">Có lỗi xảy ra: ' + response.message + '</div>');
                }
            },
            error: function() {
                $('#orderInfoContent').html('<div class="alert alert-danger">Không thể tải thông tin đơn hàng. Vui lòng thử lại!</div>');
            }
        });
    }
    
    // Edit mode functions
    function enablePartialEditMode() {
        // Address and items are already editable by default
        // Just ensure they're not readonly
        $('#edit_address').prop('readonly', false);
        $('.item-qty-input, .item-price-input, .item-name-input, .item-discount-percent-input, .item-tax-percent-input').prop('readonly', false);
        
        // Enable invoice discount fields
        $('#edit_invoice_discount_percent, #edit_invoice_discount_amount').prop('readonly', false);
        
        // Show save and cancel buttons
        $('#saveOrderBtn, #cancelEditBtn').show();
    }
    
    function toggleEditMode() {
        isEditMode = !isEditMode;
        
        if (isEditMode) {
            $('#orderInfoContent').addClass('edit-mode').removeClass('view-mode');
            $('#editOrderBtn').hide();
            $('#saveOrderBtn, #cancelEditBtn').show();
            
            // Enable all editable fields
            $('.editable-field').prop('readonly', false);
            $('.editable-select').prop('disabled', false);
        } else {
            $('#orderInfoContent').addClass('view-mode').removeClass('edit-mode');
            $('#editOrderBtn').show();
            $('#saveOrderBtn, #cancelEditBtn').hide();
            
            // Disable all editable fields
            $('.editable-field').prop('readonly', true);
            $('.editable-select').prop('disabled', true);
            
            // But keep address and items editable
            enablePartialEditMode();
        }
    }
    
    function resetEditMode() {
        isEditMode = false;
        $('#orderInfoContent').removeClass('edit-mode').addClass('view-mode');
        $('#editOrderBtn').hide();
        $('#saveOrderBtn, #cancelEditBtn').show(); // Keep save/cancel buttons visible
    }
    
    function cancelEdit() {
        if (originalOrderData) {
            var html = buildOrderInfoHTML([originalOrderData]);
            $('#orderInfoContent').html(html);
            // Reset to partial edit mode instead of full view mode
            enablePartialEditMode();
            
            // Recalculate totals
            $('.item-row').each(function() {
                calculateItemTotal($(this));
            });
            updateGrandTotal();
            
            // Update bill discount allocation
            updateAllBillDiscountAllocation();
            
            // Format price inputs
            $('.item-price-input').each(function() {
                var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                $(this).val(formatNumber(value));
            });
        }
    }
    

    function saveOrderChanges() {
        console.log('org ==> ', originalOrderData)
        if (!originalOrderData) {
            alert("Không có dữ liệu gốc để lưu!");
            return;
        }
        
        // Collect updated data
        var updatedOrder = {
            id: originalOrderData.id,
            customer_name: $('#edit_customer_name').val(),
            mobile: $('#edit_mobile').val(),
            address: $('#edit_address').val(),
            sales_note: $('#edit_sales_note').val(),
            sales_status: $('#edit_sales_status').val(),
            // Thêm các trường E-invoice
            template_number: $('#edit_template_number').val(),
            symbol: $('#edit_symbol').val(),
            payment_method: $('#edit_payment_method').val(),
            tax_code: $('#edit_tax_code').val(),
            items: []
        };
        
        // Collect updated items
        $('.item-row').each(function() {
            var itemId = $(this).data('item-id');
            var itemName = $(this).find('.item-name-input').val();
            var qty = parseFloat($(this).find('.item-qty-input').val()) || 0;
            var price = parseFloat($(this).find('.item-price-input').val().replace(/,/g, '')) || 0;
            var discountPercent = parseFloat($(this).find('.item-discount-percent-input').val()) || 0;
            var taxPercent = parseFloat($(this).find('.item-tax-percent-input').val()) || 0;
            
            // Calculate amounts
            var subtotal = qty * price;
            var discountAmount = (subtotal * discountPercent) / 100;
            var afterDiscount = subtotal - discountAmount;
            var taxAmount = (afterDiscount * taxPercent) / 100;
            var totalCost = afterDiscount + taxAmount;
            
            updatedOrder.items.push({
                item_id: itemId,
                item_name: itemName,
                sales_qty: qty,
                price_per_unit: price,
                discount_percent: discountPercent,
                discount_amount: discountAmount,
                tax_percent: taxPercent,
                tax_amount: taxAmount,
                total_cost: totalCost
            });
        });
        
        // Show loading
        $('#saveOrderBtn').html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');
        
        // AJAX call to save changes
        $.ajax({
            url: "<?php echo site_url('sales/update_order_details'); ?>",
            type: "POST",
            data: {
                order_data: updatedOrder
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert("Cập nhật thành công!");
                    // Refresh the order data
                    originalOrderData = response.data;
                    var html = buildOrderInfoHTML([response.data]);
                    $('#orderInfoContent').html(html);
                    
                    // Keep partial edit mode active
                    enablePartialEditMode();
                    
                    // Recalculate totals
                    $('.item-row').each(function() {
                        calculateItemTotal($(this));
                    });
                    updateGrandTotal();
                    
                    // Update bill discount allocation
                    updateAllBillDiscountAllocation();
                    
                    // Format price inputs
                    $('.item-price-input').each(function() {
                        var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                        $(this).val(formatNumber(value));
                    });
                    
                    // Refresh the main table
                    $('#example2').DataTable().ajax.reload();
                } else {
                    alert("Có lỗi xảy ra: " + response.message);
                }
            },
            error: function() {
                alert("Không thể lưu thay đổi. Vui lòng thử lại!");
            },
            complete: function() {
                $('#saveOrderBtn').html('<i class="fa fa-save"></i> Lưu');
            }
        });
    }
    
    // Event handlers
    $(document).on('click', '#editOrderBtn', function() {
        toggleEditMode();
    });
    
    $(document).on('click', '#saveOrderBtn', function() {
        saveOrderChanges();
    });
    
    $(document).on('click', '#cancelEditBtn', function() {
        cancelEdit();
    });
    
    // Event handlers for bill discount and price formatting
    $(document).on('change', '.item-qty-input, .item-price-input, .item-discount-percent-input, .item-tax-percent-input', function() {
        var row = $(this).closest('tr');
        calculateItemTotal(row);
        updateGrandTotal();
    });
    
    // Format price input on blur
    $(document).on('blur', '.item-price-input', function() {
        var value = $(this).val();
        if (value) {
            var numericValue = parseFloat(value.replace(/,/g, ''));
            if (!isNaN(numericValue)) {
                $(this).val(formatNumber(numericValue));
            }
        }
    });
    
    // Remove formatting on focus
    $(document).on('focus', '.item-price-input', function() {
        var value = $(this).val();
        if (value) {
            var numericValue = parseFloat(value.replace(/,/g, ''));
            if (!isNaN(numericValue)) {
                $(this).val(numericValue.toString());
            }
        }
    });
    
    // Bill discount event handlers
    $(document).on('change', '#bill_discount_percent', function() {
        var discountPercent = parseFloat($(this).val()) || 0;
        if (discountPercent > 0) {
            // Calculate discount amount based on percentage
            var subtotal = parseFloat($('#subtotal_amount').text().replace(/[^\d.,]/g, '').replace(/,/g, '')) || 0;
            var discountAmount = subtotal * (discountPercent / 100);
            $('#bill_discount_amount').val(formatNumber(discountAmount));
        } else {
            $('#bill_discount_amount').val('0');
        }
        updateGrandTotal();
    });
    
    $(document).on('change', '#bill_discount_amount', function() {
        var discountAmount = parseFloat($(this).val().replace(/,/g, '')) || 0;
        if (discountAmount > 0) {
            // Calculate discount percentage based on amount
            var subtotal = parseFloat($('#subtotal_amount').text().replace(/[^\d.,]/g, '').replace(/,/g, '')) || 0;
            var discountPercent = subtotal > 0 ? (discountAmount / subtotal) * 100 : 0;
            $('#bill_discount_percent').val(discountPercent.toFixed(2));
        } else {
            $('#bill_discount_percent').val('0');
        }
        updateGrandTotal();
    });
    
    // Format bill discount amount on blur
    $(document).on('blur', '#bill_discount_amount', function() {
        var value = $(this).val();
        if (value) {
            var numericValue = parseFloat(value.replace(/,/g, ''));
            if (!isNaN(numericValue)) {
                $(this).val(formatNumber(numericValue));
            }
        }
    });
    
    // Remove formatting on focus
    $(document).on('focus', '#bill_discount_amount', function() {
        var value = $(this).val();
        if (value) {
            var numericValue = parseFloat(value.replace(/,/g, ''));
            if (!isNaN(numericValue)) {
                $(this).val(numericValue.toString());
            }
        }
    });
    
    // Initial calculation on modal show
    setTimeout(function() {
        updateGrandTotal();
    }, 500);
    
    // E-Invoice Configuration Modal Event Handlers
    $(document).on('click', '#configEInvoiceBtn', function() {
        $('#eInvoiceConfigModal').modal('show');
        loadEInvoiceConfig();
    });
    
    $(document).on('click', '#togglePassword', function() {
        var passwordField = $('#api_password');
        var icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    $(document).on('click', '#testConnectionBtn', function() {
        testEInvoiceConnection();
    });
    
    $(document).on('click', '#saveEInvoiceConfigBtn', function() {
        saveEInvoiceConfig();
    });
    
    $(document).on('click', '#saveEInvoiceBtn', function() {
        saveEInvoiceData();
    });
    
    $(document).on('click', '#viewEInvoiceJsonBtn', function() {
        viewEInvoiceJson();
    });

    $(document).on('click', '#viewEInvoicePdfBtn', function() {
        viewEInvoicePdf();
    });
});

// E-Invoice Configuration Functions
function loadEInvoiceConfig() {
    // Show loading
    $('#connectionStatus').removeClass('success error testing').html('<i class="fa fa-spinner fa-spin"></i> Đang tải cấu hình...');
    
    $.ajax({
        url: "<?php echo site_url('sales/get_einvoice_config'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.success && response.data) {
                $('#api_url').val(response.data.api_url || '');
                $('#api_username').val(response.data.api_username || '');
                $('#api_password').val(response.data.api_password || '');
                $('#provider_code').val(response.data.provider_code || '');
                $('#connectionStatus').removeClass('success error testing').html('');
            } else {
                $('#connectionStatus').removeClass('success error testing').html('');
            }
        },
        error: function() {
            $('#connectionStatus').removeClass('success error testing').addClass('error')
                .html('<i class="fa fa-exclamation-triangle"></i> Không thể tải cấu hình!');
        }
    });
}

function testEInvoiceConnection() {
    var apiUrl = $('#api_url').val().trim();
    var apiUsername = $('#api_username').val().trim();
    var apiPassword = $('#api_password').val().trim();
    var providerCode = $('#provider_code').val().trim();
    
    // Validate required fields
    if (!apiUrl || !apiUsername || !apiPassword || !providerCode) {
        $('#connectionStatus').removeClass('success error testing').addClass('error')
            .html('<i class="fa fa-exclamation-triangle"></i> Vui lòng điền đầy đủ thông tin!');
        return;
    }
    
    // Show testing status
    $('#connectionStatus').removeClass('success error').addClass('testing')
        .html('<i class="fa fa-spinner fa-spin"></i> Đang kiểm tra kết nối...');
    
    $('#testConnectionBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang kiểm tra...');
    
    $.ajax({
        url: "<?php echo site_url('sales/test_einvoice_connection'); ?>",
        type: "POST",
        data: {
            api_url: apiUrl,
            api_username: apiUsername,
            api_password: apiPassword,
            provider_code: providerCode
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $('#connectionStatus').removeClass('testing error').addClass('success')
                    .html('<i class="fa fa-check-circle"></i> Kết nối thành công! ' + (response.message || ''));
            } else {
                $('#connectionStatus').removeClass('testing success').addClass('error')
                    .html('<i class="fa fa-exclamation-triangle"></i> Kết nối thất bại: ' + (response.message || 'Lỗi không xác định'));
            }
        },
        error: function(xhr, status, error) {
            $('#connectionStatus').removeClass('testing success').addClass('error')
                .html('<i class="fa fa-exclamation-triangle"></i> Lỗi kết nối: ' + error);
        },
        complete: function() {
            $('#testConnectionBtn').prop('disabled', false).html('<i class="fa fa-plug"></i> Kiểm tra kết nối API');
        }
    });
}

function saveEInvoiceConfig() {
    var apiUrl = $('#api_url').val().trim();
    var apiUsername = $('#api_username').val().trim();
    var apiPassword = $('#api_password').val().trim();
    var providerCode = $('#provider_code').val().trim();
    
    // Validate required fields
    if (!apiUrl || !apiUsername || !apiPassword || !providerCode) {
        alert('Vui lòng điền đầy đủ tất cả thông tin bắt buộc!');
        return;
    }
    
    // Show loading
    $('#saveEInvoiceConfigBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang lưu...');
    
    $.ajax({
        url: "<?php echo site_url('sales/save_einvoice_config'); ?>",
        type: "POST",
        data: {
            api_url: apiUrl,
            api_username: apiUsername,
            api_password: apiPassword,
            provider_code: providerCode
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert('Lưu cấu hình thành công!');
                $('#eInvoiceConfigModal').modal('hide');
            } else {
                alert('Có lỗi xảy ra: ' + (response.message || 'Lỗi không xác định'));
            }
        },
        error: function(xhr, status, error) {
            alert('Không thể lưu cấu hình: ' + error);
        },
        complete: function() {
            $('#saveEInvoiceConfigBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Lưu cấu hình');
        }
    });
}

// Function to build HTML from JSON data
function buildOrderInfoHTML(dataVATInvoice) {
    var vat_invoice = dataVATInvoice.vat_invoice;
    var vat_invoice_items = dataVATInvoice.vat_invoice_items;
    var einvoice_templates = dataVATInvoice.einvoice_templates || [];
    var einvoice_payments = dataVATInvoice.einvoice_payments || [];
    var einvoice_config = dataVATInvoice.einvoice_config || {};
    var order = {};

    var so_hoa_don = vat_invoice.so_hoa_don_dt;
    if (so_hoa_don) {
        $('#saveEInvoiceBtn').hide();
    }
    var html = '<div class="order-info-modal view-mode">';
    // Build status label
    var statusLabel = ""
    var paymentStatus = "";
    
    html += '<div class="panel panel-default">';
    html += '<div class="panel-heading">';
    html += '<h4 class="panel-title">';
    if (so_hoa_don) {
        html += '<strong>Số hóa đơn điện tử: ' + so_hoa_don + '</strong>';
    }
    html += '<span class="pull-right">' + statusLabel + '</span>';
    html += '</h4>';
    html += '</div>';
    html += '<div class="panel-body">';
    
    // Basic info row
    html += '<div class="row">';
    html += '<div class="col-md-6">';
    html += '<div class="panel panel-info">';
    html += '<div class="panel-heading"><h5 class="panel-title"><i class="fa fa-user"></i> Thông tin khách hàng</h5></div>';
    html += '<div class="panel-body">';
    html += '<table class="table table-condensed">';
    html += '<tr><td style="width: 35%; font-weight: bold;"><i class="fa fa-calendar"></i> Ngày hóa đơn:</td><td>';
    var salesDateValue = new Date().toISOString().slice(0, 10);
    html += '<input type="date" class="form-control editable-field" id="edit_sales_date" value="' + salesDateValue + '" style="width: 160px; height: 32px;">';
    html += '</td></tr>';
    
    // Customer name - editable
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-user"></i> Tên khách hàng:</td><td>';
    html += '<input type="text" class="form-control editable-field" id="edit_customer_name" value="' + (vat_invoice.ten_khach_hang || '') + '" style="height: 32px;">';
    html += '</td></tr>';
    
    // Mobile - editable
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-phone"></i> Điện thoại:</td><td>';
    html += '<input type="text" class="form-control editable-field" id="edit_mobile" value="' + (vat_invoice.so_dien_thoai_khach_hang || '') + '" style="height: 32px;">';
    html += '</td></tr>';
    
    // Address - always editable
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-map-marker"></i> Địa chỉ:</td><td>';
    html += '<textarea class="form-control editable-field" id="edit_address" rows="3" style="resize: vertical;">' + (vat_invoice.dia_chi_khach_hang || '') + '</textarea>';
    html += '</td></tr>';
    
    html += '</table>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    
    // Financial info
    html += '<div class="col-md-6">';
    html += '<div class="panel panel-warning">';
    html += '<div class="panel-heading"><h5 class="panel-title"><i class="fa fa-file-invoice"></i> Thông tin hóa đơn điện tử</h5></div>';
    html += '<div class="panel-body">';
    html += '<table class="table table-condensed">';
    
    html += '<tr><td style="width: 30%; font-weight: bold; vertical-align: middle;"><i class="fa fa-list-ol"></i> Mẫu số:</td>';
    html += '<td style="width: 20%; vertical-align: middle;">';
    html += '<select class="form-control editable-field" id="edit_template_number" style="height: 32px;">';
    // Sử dụng dữ liệu động từ API
    if (einvoice_templates && einvoice_templates.length > 0) {
        var templateNumbers = [];
        einvoice_templates.forEach(function(template) {
        if (templateNumbers.indexOf(template.template_number) === -1) {
            templateNumbers.push(template.template_number);
        }
        });
        templateNumbers.forEach(function(templateNum) {
        html += '<option value="' + templateNum + '"' + (vat_invoice.mau_so == templateNum ? ' selected' : '') + '>' + templateNum + '</option>';
        });
    } else {
        // Fallback nếu không có dữ liệu
        html += '<option value="1"' + (vat_invoice.mau_so == '1' ? ' selected' : '') + '>1</option>';
        html += '<option value="2"' + (vat_invoice.mau_so == '2' ? ' selected' : '') + '>2</option>';
    }
    html += '</select>';
    html += '</td>';
    html += '<td style="width: 25%; font-weight: bold; vertical-align: middle;"><i class="fa fa-tag"></i> Ký hiệu:</td>';
    html += '<td style="vertical-align: middle;">';
    html += '<select class="form-control editable-field" id="edit_symbol" style="height: 32px;">';
    // Sử dụng dữ liệu động từ API
    if (einvoice_templates && einvoice_templates.length > 0) {
        var symbols = [];
        einvoice_templates.forEach(function(template) {
        if (symbols.indexOf(template.symbol) === -1) {
            symbols.push(template.symbol);
        }
        });
        symbols.forEach(function(symbol) {
        html += '<option value="' + symbol + '"' + (vat_invoice.ky_hieu == symbol ? ' selected' : '') + '>' + symbol + '</option>';
        });
    } else {
        // Fallback nếu không có dữ liệu
        html += '<option value="C24"' + (vat_invoice.ky_hieu == 'C24' ? ' selected' : '') + '>C24</option>';
        html += '<option value="C25"' + (vat_invoice.ky_hieu == 'C25' ? ' selected' : '') + '>C25</option>';
    }
    html += '</select>';
    html += '</td></tr>';
    
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-barcode"></i> Mã số thuế:</td><td colspan="3">';
    html += '<input type="text" class="form-control editable-field" id="customer_tax_code" value="' + (vat_invoice.ma_so_thue || '') + '" style="height: 32px;" placeholder="Nhập mã số thuế khách hàng">';
    html += '</td></tr>';
    
    // Thêm 1 dòng phương thức thanh toán
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-credit-card"></i> Phương thức TT:</td><td colspan="3">';
    html += '<select class="form-control editable-field" id="edit_payment_method" style="height: 32px;">';
    // Sử dụng dữ liệu động từ API
    if (einvoice_payments && einvoice_payments.length > 0) {
        einvoice_payments.forEach(function(payment) {
        html += '<option value="' + payment.payment_code + '"' + (vat_invoice.payment_method == payment.payment_code ? ' selected' : '') + '>' + payment.payment_name + '</option>';
        });
    } else {
        // Fallback nếu không có dữ liệu
        html += '<option value="TM"' + (vat_invoice.payment_method == 'TM' ? ' selected' : '') + '>Tiền mặt</option>';
        html += '<option value="CK"' + (vat_invoice.payment_method == 'CK' ? ' selected' : '') + '>Chuyển khoản</option>';
    }
    html += '</select>';
    html += '</td></tr>';
    // Thêm 1 dòng ghi chú
    html += '<tr><td style="font-weight: bold;"><i class="fa fa-comment"></i> Ghi chú:</td><td colspan="3">';
    html += '<textarea class="form-control editable-field" id="customer_note" rows="3" style="width: 100%;">' + (vat_invoice.ghi_chu || '') + '</textarea>';
    html += '</td></tr>';
    html += '</table>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';


    // Items details - editable
    if (vat_invoice_items && vat_invoice_items.length > 0) {
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<h5><strong>Chi tiết sản phẩm:</strong></h5>';
        html += '<table class="table table-bordered table-condensed">';
        html += '<thead>';
        html += '<tr>';
        html += '<th>Tên sản phẩm</th>';
        html += '<th>Số lượng</th>';
        html += '<th>Đơn giá</th>';
        html += '<th>Giảm giá</th>';
        html += '<th>% Thuế</th>';
        html += '<th>Tiền thuế</th>';
        html += '<th>Thành tiền</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';

        vat_invoice_items.forEach(function(item, index) {
            html += '<tr class="item-row" data-item-id="' + (item.id || index) + '">';
            
            // Product name - editable
            html += '<td>';
            html += '<input type="text" class="editable-field item-name-input" value="' + (item.ten_san_pham || '') + '" style="width: 150px;">';
            html += '</td>';
            
            // Quantity - always editable
            html += '<td>';
            html += '<input type="number" class="editable-field item-qty-input" value="' + formatNumber(item.so_luong) + '" min="0" step="0.01">';
            html += '</td>';
            
            // Price - always editable
            html += '<td>';
            html += '<input type="text" class="editable-field item-price-input" value="' + formatNumber(item.don_gia) + '" min="0">';
            html += '</td>';
            
            
            // Discount amount - calculated
            html += '<td>';
            // html += '<span class="item-discount-amount">' + item.giam_gia + '</span>';
            html += '<input type="text" class="editable-field item-discount-amount" value="' + formatNumber(item.giam_gia) + '" min="0">';
            html += '</td>';
            
            // Tax percentage - editable
            html += '<td>';
            html += '<input type="number" class="editable-field item-tax-percent-input" value="' + formatNumber(item.phan_tram_thue || 0) + '" min="0" max="100" step="0.01" style="width: 60px;">';
            html += '</td>';
            
            // Tax amount - calculated
            html += '<td>';
            // html += '<span class="item-tax-amount">' + formatNumber(item.thue || 0) + '</span>';
            html += '<input type="text" class="editable-field item-tax-amount" value="' + formatNumber(item.thue || 0) + '" min="0">';
            html += '</td>';
            
            // Total
            html += '<td>';
            // html += '<span class="item-total">' + formatNumber(item.tong_tien) + '</span>';
            html += '<input type="text" class="editable-field item-total" value="' + formatNumber(item.tong_tien) + '" min="0">';
            html += '</td>';
            
            html += '</tr>';
        });
        
        html += '</tbody>';
        html += '</table>';
        html += '</div>';
        html += '</div>';
        
        // // Bill discount section
        // html += '<div class="row" style="margin-top: 20px;">';
        // html += '<div class="col-md-8">';
        // html += '<div class="bill-discount-section">';
        // html += '<h5><i class="fa fa-percent"></i> Giảm giá hóa đơn</h5>';
        // html += '<div class="row">';
        // html += '<div class="col-md-6">';
        // html += '<div class="form-group">';
        // html += '<label>Giảm giá theo %:</label>';
        // html += '<div class="input-group">';
        // html += '<input type="number" class="form-control editable-field" id="bill_discount_percent" value="' + (order.discount_all_bill_percent || 0) + '" min="0" max="100" step="0.01">';
        // html += '<span class="input-group-addon">%</span>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
        // html += '<div class="col-md-6">';
        // html += '<div class="form-group">';
        // html += '<label>Giảm giá theo tiền:</label>';
        // html += '<div class="input-group">';
        // html += '<input type="text" class="form-control editable-field" id="bill_discount_amount" value="' + formatNumber(order.discount_all_bill_amount || 0) + '" min="0">';
        // html += '<span class="input-group-addon">VNĐ</span>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
        
        // // Summary section
        // html += '<div class="col-md-4">';
        // html += '<div class="summary-section">';
        // html += '<h5><i class="fa fa-calculator"></i> Tổng kết hóa đơn</h5>';
        // html += '<table class="table table-condensed">';
        // html += '<tr>';
        // html += '<td><strong>Tổng tiền SP:</strong></td>';
        // html += '<td class="text-right"><span id="subtotal_amount">' + formatCurrency(order.subtotal_amount || 0) + '</span></td>';
        // html += '</tr>';
        // html += '<tr>';
        // html += '<td><strong>Giảm giá HĐ:</strong></td>';
        // html += '<td class="text-right"><span id="total_bill_discount">' + formatCurrency(order.bill_discount_amount || 0) + '</span></td>';
        // html += '</tr>';
        // html += '<tr style="font-weight: bold; background-color: #e8f5e8; border-top: 2px solid #28a745;">';
        // html += '<td><strong>Tổng thanh toán:</strong></td>';
        // html += '<td class="text-right"><span id="final_total">' + formatCurrency(order.grand_total || 0) + '</span></td>';
        // html += '</tr>';
        // html += '</table>';
        // html += '</div>';
        // html += '</div>';
        // html += '</div>';
    }
    
    html += '</div>'; // Close panel-body
    html += '</div>'; // Close panel

    html += '</div>'; // Close order-info-modal
    return html;
}

 $('#createJsonEInvoiceBtn').click(function() {
        var btn = $(this);
        var spinner = btn.find('.loading-spinner');
        
        btn.prop('disabled', true);
        spinner.show();
        
        var formData = {
            // api_url: $('#api_url').val().trim(),
            // username: $('#username').val().trim(),
            // password: $('#password').val().trim(),
            // provider_code: $('#provider_code').val().trim()
            api_url: '',
            username: '',
            password: '',
            provider_code: ''
        };
        
        $.ajax({
            url: '<?php echo site_url("sales/create_and_publish_einvoice"); ?>',
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
function createAndPublishInvoice(invoiceData, einvoiceConfig) {
    // Hiển thị loading overlay với nội dung tùy chỉnh
    showLoadingOverlay('Đang tạo hóa đơn điện tử...', 'Đang gửi dữ liệu đến cơ quan thuế');
            
        var formData = {
            // api_url: $('#api_url').val().trim(),
            // username: $('#username').val().trim(),
            // password: $('#password').val().trim(),
            // provider_code: $('#provider_code').val().trim()
           invoice_data: invoiceData,
           einvoice_config: einvoiceConfig
        };
        console.log('Creating and publishing invoice with data:', invoiceData);
        $.ajax({
            url: '<?php echo site_url("sales/create_and_publish_einvoice"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                     console.log('Response HDDT:', response);
                    if (response.response && response.response.Status === 200) {
                        console.log('Response Data:', response.response.Data);
                    } else {
                        showAlert('danger', 'No Data in response: ' + response.response.Status + ' - Nội dung lỗi: ' + response.response.Message);
                    }
                    var message = '<i class="fa fa-check-circle"></i> ' + response.message + ' Số hóa đơn: ' + response.response.Data?.ThirdPartyInvoiceNumber;
                    
                    if (response.response && response.response.data) {
                        message += '<br><small>Response Data: ' + JSON.stringify(response.response.data) + '</small>';
                    }
                    showAlert('success', message);
                    setTimeout(() => {
                        show_order_info(); // Refresh order info after creating invoice
                    }, 1500);
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
                // Ẩn loading overlay
                hideLoadingOverlay();
            }
        });
}

// Function to save E-Invoice data
function saveEInvoiceData() {
    console.log('Saving E-Invoice data...', originalOrderData);
    if (!originalOrderData) {
        alert("Không có dữ liệu đơn hàng để lưu!");
        return;
    }
    
    // Hiển thị loading overlay
    showLoadingOverlay('Đang lưu thông tin hóa đơn...', 'Đang xử lý dữ liệu hóa đơn điện tử');
    
    // Collect invoice data from form
    var invoiceData = {
        order_id: originalOrderData.vat_invoice.sales_id,
        sales_code: originalOrderData.sales_code,
        invoice_date: $('#edit_sales_date').val(),
        template_number: $('#edit_template_number').val(),
        symbol: $('#edit_symbol').val(),
        customer_name: $('#edit_customer_name').val(),
        customer_phone: $('#edit_mobile').val(),
        customer_address: $('#edit_address').val(),
        customer_tax_code: $('#customer_tax_code').val(),
        payment_method: $('#edit_payment_method').val(),
        sales_note: $('#customer_note').val(),
        subtotal_amount: 0,
        bill_discount_amount: 0,
        grand_total: 0,
        items: [],
        formNo: $('#edit_template_number').val(),
        serial: $('#edit_symbol').val(),
        tax_group_summary: [],
    };
    
    // Collect items data
    $('.item-row').each(function() {
        var itemId = $(this).data('item-id');
        var itemName = $(this).find('.item-name-input').val() || 'sp1';
        var qty = parseFloat($(this).find('.item-qty-input').val()) || 0;
        var unitPrice = parseFloat($(this).find('.item-price-input').val().replace(/,/g, '').replace('.', '')) || 0;
        var discountPercent = parseFloat($(this).find('.item-discount-percent-input').val()) || 0;
        var taxPercent = parseFloat($(this).find('.item-tax-percent-input').val()) || 0;
        
        // Calculate amounts
        var subtotal = qty * unitPrice;
        var discountAmount = parseFloat($(this).find('.item-discount-amount').val().replace(/,/g, '').replace('.', '')) || 0;
        var afterDiscount = subtotal - discountAmount;
        var taxAmount = parseFloat($(this).find('.item-tax-amount').val().replace(/,/g, '').replace('.', '')) || 0;
        var totalAmount = parseFloat($(this).find('.item-total').val().replace(/,/g, '').replace('.', '')) || 0;
        console.log('discountAmount:', discountAmount, 'taxAmount:', taxAmount, 'totalAmount:', totalAmount);

        invoiceData.items.push({
            item_id: itemId,
            item_name: itemName,
            quantity: qty,
            unit_price: unitPrice,
            discount_percent: discountPercent,
            discount_amount: discountAmount,
            tax_percent: taxPercent,
            tax_amount: taxAmount,
            total_amount: totalAmount
        });
        invoiceData.subtotal_amount += subtotal;
        invoiceData.bill_discount_amount += discountAmount;
        invoiceData.grand_total += totalAmount;
        // Update tax group summary
        var taxGroup = invoiceData.tax_group_summary.find(tg => tg.tax_percent === taxPercent);
        if (!taxGroup) {
            taxGroup = {
                tax_percent: taxPercent,
                total_tax_amount: taxAmount,
                total_amount: totalAmount,
                before_tax_amount: afterDiscount
            };
            invoiceData.tax_group_summary.push(taxGroup);
        } else {
            taxGroup.total_amount += totalAmount;
            taxGroup.total_tax_amount += taxAmount;
            taxGroup.before_tax_amount += afterDiscount;
        }
    });
    
    console.log('Invoice data to save:', invoiceData);
    return;
    // AJAX call to save e-invoice data
    $.ajax({
        url: "<?php echo site_url('sales/save_einvoice_data'); ?>",
        type: "POST",
        data: {
            invoice_data: invoiceData
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert("Lưu thông tin hóa đơn điện tử thành công!");
                if (response.tables_created) {
                   // alert("Đã tạo bảng dữ liệu hóa đơn điện tử thành công!");
                }
            } else {
                alert("Có lỗi xảy ra: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert("Không thể lưu thông tin hóa đơn điện tử: " + error);
        },
        complete: function() {
           // $('#saveEInvoiceBtn').html('<i class="fa fa-file-invoice"></i> Lưu HĐ điện tử').prop('disabled', false);
            createAndPublishInvoice(invoiceData, originalOrderData.einvoice_config);
        }
    });
}

// Function to view E-Invoice PDF
function viewEInvoicePdf() {
    if (!originalOrderData) {
        alert("Không có dữ liệu đơn hàng!");
        return;
    }
    // Hiển thị loading overlay với nội dung tùy chỉnh
    showLoadingOverlay('Đang lấy thông tin PDF...', 'Đang tải hóa đơn điện tử');
    $.ajax({
        url: "<?php echo site_url('sales/view_pdf_invoice'); ?>", 
        type: "POST",
        data: {
            order_id: originalOrderData.id,
            einvoice_data: originalOrderData.vat_invoice || null,
            einvoice_config: originalOrderData.einvoice_config || null
        },
        dataType: "json",
        success: function(response) {
            console.log('Response from server:', response);
            if (response.success) {
                if (response.pdf_url) {
                    // Check if it's a base64 string
                    if (response.pdf_url.indexOf('data:application/pdf;base64,') === 0) {
                        // Handle base64 PDF
                        var base64Data = response.pdf_url;
                        var newWindow = window.open();
                        newWindow.document.write('<iframe src="' + base64Data + '" style="width:100%;height:100%;border:none;"></iframe>');
                    } else {
                        // Handle regular URL
                        window.open(response.pdf_url, '_blank');
                    }
                } else if (response.pdf_base64) {
                    // Handle separate base64 field
                    var base64Data = 'data:application/pdf;base64,' + response.pdf_base64;
                    var newWindow = window.open();
                    newWindow.document.write('<iframe src="' + base64Data + '" style="width:100%;height:100%;border:none;"></iframe>');
                } else {
                    alert("Không có dữ liệu PDF để hiển thị!");
                }
            } else {
                alert("Không thể xem PDF: " + response.message);
            }
        },
        complete: function() {
            hideLoadingOverlay();
        },
        error: function(xhr, status, error) {
            alert("Có lỗi xảy ra khi xem PDF: " + error);
        }
    });
}

// Function to view E-Invoice JSON data
function viewEInvoiceJson() {
    if (!originalOrderData) {
        alert("Không có dữ liệu đơn hàng!");
        return;
    }
    
    // Use the showEInvoiceJson function from the imported modal
    if (typeof showEInvoiceJson === 'function') {
        showEInvoiceJson(originalOrderData.id);
    } else {
        alert("Chức năng xem JSON chưa được tải. Vui lòng tải lại trang!");
    }
}

</script>

<!-- Import E-Invoice JSON Modal -->
<?php $this->load->view('einvoice-json-modal'); ?>
