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
          <button type="button" class="btn btn-sm btn-primary" id="editOrderBtn" style="display: none;">
            <i class="fa fa-edit"></i> Sửa
          </button>
          <button type="button" class="btn btn-sm btn-success" id="saveOrderBtn" style="display: none;">
            <i class="fa fa-save"></i> Lưu
          </button>
          <button type="button" class="btn btn-sm btn-default" id="cancelEditBtn" style="display: none;">
            <i class="fa fa-times"></i> Hủy
          </button>
        </div>
      </div>
      <div class="modal-body" id="orderInfoContent" style="max-height: 70vh; overflow-y: auto;">
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
</style>

<script>
// Global variables
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
function formatNumber(num) {
    if (isNaN(num) || num === null || num === undefined) {
        return '0';
    }
    // Format với dấu phẩy cho hàng nghìn và dấu chấm cho phần thập phân
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    }).format(num);
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
    $('#orderInfoContent').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Đang tải dữ liệu...</p></div>');
    resetEditMode();
    
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
                originalOrderData = response.data[0]; // Store original data
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
        cancelEdit();
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
    var originalOrderData = null;
    var isEditMode = false;
    
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
            url: "<?php echo site_url('sales/get_order_details'); ?>",
            type: "POST",
            data: {
                order_ids: selectedIds
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    originalOrderData = response.data[0]; // Store original data
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
});

// Function to build HTML from JSON data
function buildOrderInfoHTML(orders) {
    var html = '<div class="order-info-modal view-mode">';
    
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
        
        // Customer name - editable
        html += '<tr><td><strong>Khách hàng:</strong></td><td>';
        html += '<span class="view-only">' + (order.customer_name || 'N/A') + '</span>';
        html += '<input type="text" class="edit-only editable-field" id="edit_customer_name" value="' + (order.customer_name || '') + '">';
        html += '</td></tr>';
        
        // Mobile - editable
        html += '<tr><td><strong>Điện thoại:</strong></td><td>';
        html += '<span class="view-only">' + (order.mobile || 'N/A') + '</span>';
        html += '<input type="text" class="edit-only editable-field" id="edit_mobile" value="' + (order.mobile || '') + '">';
        html += '</td></tr>';
        
        // Address - always editable
        html += '<tr><td><strong>Địa chỉ:</strong></td><td>';
        html += '<textarea class="editable-field" id="edit_address" rows="2" style="width: 100%;">' + (order.address || '') + '</textarea>';
        html += '</td></tr>';
        
        html += '</table>';
        html += '</div>';
        
        // Financial info
        html += '<div class="col-md-6">';
        html += '<table class="table table-condensed">';
        html += '<tr><td><strong>Tổng tiền SP:</strong></td><td><span id="subtotal_display">' + formatCurrency(order.subtotal || order.grand_total) + '</span></td></tr>';
        
        // Invoice discount - editable
        html += '<tr><td><strong>Giảm giá HĐ:</strong></td><td>';
        html += '<div style="display: flex; align-items: center; gap: 10px;">';
        html += '<input type="number" class="editable-field" id="edit_invoice_discount_percent" value="' + (order.invoice_discount_percent || 0) + '" min="0" max="100" step="0.01" style="width: 70px; text-align: center;" placeholder="0">%';
        html += '<span style="margin: 0 5px;">-</span>';
        html += '<input type="text" class="editable-field" id="edit_invoice_discount_amount" value="' + formatNumber(order.invoice_discount_amount || 0) + '" style="width: 100px; text-align: right;" placeholder="0">';
        html += '</div>';
        html += '</td></tr>';
        
        html += '<tr><td><strong>Tổng tiền:</strong></td><td><span id="grand_total_display">' + formatCurrency(order.grand_total) + '</span></td></tr>';
        html += '<tr><td><strong>Đã thanh toán:</strong></td><td>' + formatCurrency(order.paid_amount) + '</td></tr>';
        html += '<tr><td><strong>Trạng thái TT:</strong></td><td>' + paymentStatus + '</td></tr>';
        html += '<tr><td><strong>Người tạo:</strong></td><td>' + (order.created_by || 'N/A') + '</td></tr>';
        html += '</table>';
        html += '</div>';
        html += '</div>';
        
        // Sales status - editable
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<table class="table table-condensed">';
        html += '<tr><td style="width: 120px;"><strong>Trạng thái đơn:</strong></td><td>';
        html += '<span class="view-only">' + statusLabel + '</span>';
        html += '<select class="edit-only editable-select form-control" id="edit_sales_status" style="width: 200px; display: inline-block;">';
        html += '<option value="Final"' + (order.sales_status == 'Final' ? ' selected' : '') + '>Đã giao hàng</option>';
        html += '<option value="Shipping"' + (order.sales_status == 'Shipping' ? ' selected' : '') + '>Đã xuất kho</option>';
        html += '<option value="Quotation"' + (order.sales_status == 'Quotation' ? ' selected' : '') + '>Đang giao dịch</option>';
        html += '</select>';
        html += '</td></tr>';
        html += '</table>';
        html += '</div>';
        html += '</div>';
        
        // Sales note - editable
        html += '<div class="row">';
        html += '<div class="col-md-12">';
        html += '<strong>Ghi chú:</strong><br>';
        html += '<span class="view-only">' + (order.sales_note || 'Không có ghi chú') + '</span>';
        html += '<textarea class="edit-only editable-field" id="edit_sales_note" rows="3" style="width: 100%;">' + (order.sales_note || '') + '</textarea>';
        html += '</div>';
        html += '</div>';
        
        // Items details - editable
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
            html += '<th>% Giảm giá SP</th>';
            html += '<th>Tiền giảm SP</th>';
            html += '<th>% Giảm giá HĐ</th>';
            html += '<th>Tiền giảm HĐ</th>';
            html += '<th>% Thuế</th>';
            html += '<th>Tiền thuế</th>';
            html += '<th>Thành tiền</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            order.items.forEach(function(item, index) {
                html += '<tr class="item-row" data-item-id="' + (item.item_id || index) + '">';
                html += '<td>' + (item.item_code || 'N/A') + '</td>';
                
                // Product name - editable
                html += '<td>';
                html += '<input type="text" class="editable-field item-name-input" value="' + (item.item_name || '') + '" style="width: 150px;">';
                html += '</td>';
                
                // Quantity - always editable
                html += '<td>';
                html += '<input type="number" class="editable-field item-qty-input" value="' + item.sales_qty + '" min="0" step="0.01">';
                html += '</td>';
                
                // Price - always editable
                html += '<td>';
                html += '<input type="text" class="editable-field item-price-input" value="' + formatNumber(item.price_per_unit) + '" min="0">';
                html += '</td>';
                
                // Discount percentage - editable
                html += '<td>';
                html += '<input type="number" class="editable-field item-discount-percent-input" value="' + (item.discount_percent || 0) + '" min="0" max="100" step="0.01" style="width: 60px;">';
                html += '</td>';
                
                // Discount amount - calculated
                html += '<td>';
                html += '<span class="item-discount-amount">' + formatCurrency(item.discount_amount || 0) + '</span>';
                html += '</td>';
                
                // Bill discount percentage for this item - calculated
                html += '<td>';
                html += '<span class="item-bill-discount-percent">0%</span>';
                html += '</td>';
                
                // Bill discount amount for this item - calculated
                html += '<td>';
                html += '<span class="item-bill-discount-amount">' + formatCurrency(0) + '</span>';
                html += '</td>';
                
                // Tax percentage - editable
                html += '<td>';
                html += '<input type="number" class="editable-field item-tax-percent-input" value="' + (item.tax_percent || 0) + '" min="0" max="100" step="0.01" style="width: 60px;">';
                html += '</td>';
                
                // Tax amount - calculated
                html += '<td>';
                html += '<span class="item-tax-amount">' + formatCurrency(item.tax_amount || 0) + '</span>';
                html += '</td>';
                
                // Total
                html += '<td>';
                html += '<span class="item-total">' + formatCurrency(item.total_cost) + '</span>';
                html += '</td>';
                
                html += '</tr>';
            });
            
            html += '</tbody>';
            html += '</table>';
            html += '</div>';
            html += '</div>';
            
            // Bill discount section
            html += '<div class="row" style="margin-top: 20px;">';
            html += '<div class="col-md-8">';
            html += '<div class="bill-discount-section">';
            html += '<h5><i class="fa fa-percent"></i> Giảm giá hóa đơn</h5>';
            html += '<div class="row">';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label>Giảm giá theo %:</label>';
            html += '<div class="input-group">';
            html += '<input type="number" class="form-control editable-field" id="bill_discount_percent" value="' + (order.bill_discount_percent || 0) + '" min="0" max="100" step="0.01">';
            html += '<span class="input-group-addon">%</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-6">';
            html += '<div class="form-group">';
            html += '<label>Giảm giá theo tiền:</label>';
            html += '<div class="input-group">';
            html += '<input type="text" class="form-control editable-field" id="bill_discount_amount" value="' + formatNumber(order.bill_discount_amount || 0) + '" min="0">';
            html += '<span class="input-group-addon">VNĐ</span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            
            // Summary section
            html += '<div class="col-md-4">';
            html += '<div class="summary-section">';
            html += '<h5><i class="fa fa-calculator"></i> Tổng kết hóa đơn</h5>';
            html += '<table class="table table-condensed">';
            html += '<tr>';
            html += '<td><strong>Tổng tiền SP:</strong></td>';
            html += '<td class="text-right"><span id="subtotal_amount">' + formatCurrency(order.subtotal_amount || 0) + '</span></td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td><strong>Giảm giá HĐ:</strong></td>';
            html += '<td class="text-right"><span id="total_bill_discount">' + formatCurrency(order.bill_discount_amount || 0) + '</span></td>';
            html += '</tr>';
            html += '<tr style="font-weight: bold; background-color: #e8f5e8; border-top: 2px solid #28a745;">';
            html += '<td><strong>Tổng thanh toán:</strong></td>';
            html += '<td class="text-right"><span id="final_total">' + formatCurrency(order.grand_total || 0) + '</span></td>';
            html += '</tr>';
            html += '</table>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
        }
        
        html += '</div>'; // Close panel-body
        html += '</div>'; // Close panel
    });
    
    html += '</div>'; // Close order-info-modal
    return html;
}


</script>
