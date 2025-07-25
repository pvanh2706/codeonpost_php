<!-- E-Invoice JSON Display Modal -->
<div class="modal fade" id="eInvoiceJsonModal" tabindex="-1" role="dialog" aria-labelledby="eInvoiceJsonModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 95%; max-width: 1400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="eInvoiceJsonModalLabel">
          <i class="fa fa-file-code-o"></i> Thông tin hóa đơn điện tử (JSON)
        </h4>
        <div class="pull-right" style="margin-top: -25px; margin-right: 30px;">
          <button type="button" class="btn btn-sm btn-success" id="copyJsonBtn">
            <i class="fa fa-copy"></i> Copy JSON
          </button>
          <button type="button" class="btn btn-sm btn-info" id="downloadJsonBtn">
            <i class="fa fa-download"></i> Tải xuống
          </button>
          <button type="button" class="btn btn-sm btn-warning" id="formatJsonBtn">
            <i class="fa fa-magic"></i> Format JSON
          </button>
          <button type="button" class="btn btn-sm btn-primary" id="refreshJsonBtn">
            <i class="fa fa-refresh"></i> Làm mới
          </button>
        </div>
      </div>
      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active">
            <a href="#json-display" aria-controls="json-display" role="tab" data-toggle="tab">
              <i class="fa fa-code"></i> JSON Data
            </a>
          </li>
          <li role="presentation">
            <a href="#json-preview" aria-controls="json-preview" role="tab" data-toggle="tab">
              <i class="fa fa-eye"></i> Preview
            </a>
          </li>
          <li role="presentation">
            <a href="#json-info" aria-controls="json-info" role="tab" data-toggle="tab">
              <i class="fa fa-info-circle"></i> Thông tin
            </a>
          </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" style="margin-top: 15px;">
          <!-- JSON Display Tab -->
          <div role="tabpanel" class="tab-pane active" id="json-display">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="jsonTextarea">
                    <i class="fa fa-file-code-o"></i> Dữ liệu JSON:
                  </label>
                  <textarea id="jsonTextarea" class="form-control" rows="25" readonly 
                            style="font-family: 'Courier New', monospace; font-size: 12px; background-color: #f8f9fa; border: 1px solid #ddd;">
                  </textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- JSON Preview Tab -->
          <div role="tabpanel" class="tab-pane" id="json-preview">
            <div class="row">
              <div class="col-md-6">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h5 class="panel-title">
                      <i class="fa fa-file-text-o"></i> Thông tin hóa đơn
                    </h5>
                  </div>
                  <div class="panel-body">
                    <table class="table table-condensed" id="invoiceHeaderTable">
                      <tbody>
                        <!-- Data will be populated by JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h5 class="panel-title">
                      <i class="fa fa-list"></i> Chi tiết sản phẩm
                    </h5>
                  </div>
                  <div class="panel-body" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-condensed table-bordered" id="invoiceItemsTable">
                      <thead>
                        <tr>
                          <th>Tên SP</th>
                          <th>SL</th>
                          <th>Đơn giá</th>
                          <th>Thành tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data will be populated by JavaScript -->
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- JSON Info Tab -->
          <div role="tabpanel" class="tab-pane" id="json-info">
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h5 class="panel-title">
                      <i class="fa fa-info-circle"></i> Thông tin metadata
                    </h5>
                  </div>
                  <div class="panel-body">
                    <table class="table table-condensed">
                      <tbody>
                        <tr>
                          <td><strong>Kích thước JSON:</strong></td>
                          <td><span id="jsonSize">-</span> bytes</td>
                        </tr>
                        <tr>
                          <td><strong>Số lượng sản phẩm:</strong></td>
                          <td><span id="itemCount">-</span></td>
                        </tr>
                        <tr>
                          <td><strong>Thời gian tạo:</strong></td>
                          <td><span id="createdAt">-</span></td>
                        </tr>
                        <tr>
                          <td><strong>Trạng thái:</strong></td>
                          <td><span id="invoiceStatus">-</span></td>
                        </tr>
                        <tr>
                          <td><strong>Tổng tiền:</strong></td>
                          <td><span id="grandTotalInfo">-</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          <i class="fa fa-times"></i> Đóng
        </button>
      </div>
    </div>
  </div>
</div>

<style>
/* E-Invoice JSON Modal Styles */
#eInvoiceJsonModal .modal-content {
  border-radius: 6px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

#eInvoiceJsonModal .modal-header {
  background-color: #3c8dbc;
  color: white;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
}

#eInvoiceJsonModal .modal-header .close {
  color: white;
  opacity: 0.8;
}

#eInvoiceJsonModal .modal-header .close:hover {
  opacity: 1;
}

#eInvoiceJsonModal .nav-tabs {
  border-bottom: 2px solid #3c8dbc;
}

#eInvoiceJsonModal .nav-tabs > li.active > a {
  background-color: #3c8dbc;
  color: white;
  border-color: #3c8dbc;
}

#eInvoiceJsonModal .nav-tabs > li > a {
  color: #3c8dbc;
}

#eInvoiceJsonModal .nav-tabs > li > a:hover {
  background-color: #f8f9fa;
  border-color: #ddd;
}

#eInvoiceJsonModal .panel {
  margin-bottom: 0;
}

#eInvoiceJsonModal .panel-heading {
  background-color: #f8f9fa;
  border-bottom: 1px solid #ddd;
}

#eInvoiceJsonModal .panel-title {
  font-size: 14px;
  font-weight: bold;
}

#eInvoiceJsonModal .table-condensed td {
  padding: 5px 8px;
  font-size: 12px;
}

#eInvoiceJsonModal .table-bordered th,
#eInvoiceJsonModal .table-bordered td {
  border: 1px solid #ddd;
  padding: 4px 6px;
  font-size: 11px;
}

#eInvoiceJsonModal .table-bordered th {
  background-color: #f8f9fa;
  font-weight: bold;
}

#jsonTextarea {
  white-space: pre-wrap;
  word-wrap: break-word;
}

#eInvoiceJsonModal .btn-group-xs > .btn {
  padding: 1px 5px;
  font-size: 11px;
  line-height: 1.5;
}

/* JSON syntax highlighting */
.json-key {
  color: #0066cc;
  font-weight: bold;
}

.json-string {
  color: #009900;
}

.json-number {
  color: #cc6600;
}

.json-boolean {
  color: #990099;
}

.json-null {
  color: #999999;
}

/* Loading spinner */
.json-loading {
  text-align: center;
  padding: 50px;
  color: #666;
}

.json-loading i {
  font-size: 24px;
  margin-bottom: 10px;
}

/* Error state */
.json-error {
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
  color: #721c24;
  padding: 15px;
  border-radius: 4px;
  margin: 10px 0;
}

/* Success state */
.json-success {
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
  color: #155724;
  padding: 15px;
  border-radius: 4px;
  margin: 10px 0;
}
</style>

<script>
// Global variables for JSON modal
var currentJsonData = null;
var currentOrderId = null;

$(document).ready(function() {
    // Event handlers for JSON modal
    $(document).on('click', '#copyJsonBtn', function() {
        copyJsonToClipboard();
    });
    
    $(document).on('click', '#downloadJsonBtn', function() {
        downloadJsonFile();
    });
    
    $(document).on('click', '#formatJsonBtn', function() {
        formatJsonDisplay();
    });
    
    $(document).on('click', '#refreshJsonBtn', function() {
        if (currentOrderId) {
            loadEInvoiceJson(currentOrderId);
        }
    });
});

// Function to show JSON modal and load data
function showEInvoiceJson(orderId) {
    if (!orderId) {
        alert('Không có ID đơn hàng để lấy dữ liệu!');
        return;
    }
    
    currentOrderId = orderId;
    $('#eInvoiceJsonModal').modal('show');
    loadEInvoiceJson(orderId);
}

// Function to load E-Invoice JSON data
function loadEInvoiceJson(orderId) {
    // Show loading state
    showJsonLoading();
    
    $.ajax({
        url: "<?php echo site_url('sales/get_einvoice_json'); ?>",
        type: "POST",
        data: {
            order_id: orderId
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                currentJsonData = response.data;
                displayJsonData(response.data);
                populatePreviewTabs(response.data);
                updateJsonInfo(response.data);
            } else {
                showJsonError('Không thể tải dữ liệu: ' + (response.message || 'Lỗi không xác định'));
            }
        },
        error: function(xhr, status, error) {
            showJsonError('Lỗi kết nối: ' + error);
        }
    });
}

// Function to show loading state
function showJsonLoading() {
    var loadingHtml = '<div class="json-loading">' +
                      '<i class="fa fa-spinner fa-spin"></i><br>' +
                      'Đang tải dữ liệu JSON...' +
                      '</div>';
    
    $('#jsonTextarea').val('');
    $('#json-display').html(loadingHtml);
    $('#invoiceHeaderTable tbody').html('<tr><td colspan="2" class="text-center">Đang tải...</td></tr>');
    $('#invoiceItemsTable tbody').html('<tr><td colspan="4" class="text-center">Đang tải...</td></tr>');
}

// Function to show error state
function showJsonError(message) {
    var errorHtml = '<div class="json-error">' +
                    '<i class="fa fa-exclamation-triangle"></i> ' + message +
                    '</div>';
    
    $('#json-display').html(errorHtml);
    $('#invoiceHeaderTable tbody').html('<tr><td colspan="2" class="text-center text-danger">Lỗi tải dữ liệu</td></tr>');
    $('#invoiceItemsTable tbody').html('<tr><td colspan="4" class="text-center text-danger">Lỗi tải dữ liệu</td></tr>');
}

// Function to display JSON data
function displayJsonData(data) {
    // Restore the textarea and populate with formatted JSON
    $('#json-display').html(`
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="jsonTextarea">
                        <i class="fa fa-file-code-o"></i> Dữ liệu JSON:
                    </label>
                    <textarea id="jsonTextarea" class="form-control" rows="25" readonly 
                              style="font-family: 'Courier New', monospace; font-size: 12px; background-color: #f8f9fa; border: 1px solid #ddd;">
                    </textarea>
                </div>
            </div>
        </div>
    `);
    
    // Format and display JSON
    var formattedJson = JSON.stringify(data, null, 2);
    $('#jsonTextarea').val(formattedJson);
}

// Function to populate preview tabs
function populatePreviewTabs(data) {
    // Populate header table
    var headerHtml = '';
    if (data.header) {
        var header = data.header;
        headerHtml += '<tr><td><strong>Mã đơn hàng:</strong></td><td>' + (header.sales_code || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Ngày hóa đơn:</strong></td><td>' + (header.invoice_date || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Khách hàng:</strong></td><td>' + (header.customer_name || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Điện thoại:</strong></td><td>' + (header.customer_phone || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Địa chỉ:</strong></td><td>' + (header.customer_address || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Mã số thuế:</strong></td><td>' + (header.customer_tax_code || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Mẫu số:</strong></td><td>' + (header.template_number || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Ký hiệu:</strong></td><td>' + (header.symbol || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Phương thức TT:</strong></td><td>' + (header.payment_method || '-') + '</td></tr>';
        headerHtml += '<tr><td><strong>Tổng tiền:</strong></td><td>' + formatCurrency(header.grand_total || 0) + '</td></tr>';
    }
    $('#invoiceHeaderTable tbody').html(headerHtml);
    
    // Populate items table
    var itemsHtml = '';
    if (data.items && data.items.length > 0) {
        data.items.forEach(function(item) {
            itemsHtml += '<tr>';
            itemsHtml += '<td>' + (item.item_name || '-') + '</td>';
            itemsHtml += '<td class="text-center">' + (item.quantity || 0) + '</td>';
            itemsHtml += '<td class="text-right">' + formatCurrency(item.unit_price || 0) + '</td>';
            itemsHtml += '<td class="text-right">' + formatCurrency(item.total_amount || 0) + '</td>';
            itemsHtml += '</tr>';
        });
    } else {
        itemsHtml = '<tr><td colspan="4" class="text-center">Không có sản phẩm</td></tr>';
    }
    $('#invoiceItemsTable tbody').html(itemsHtml);
}

// Function to update JSON info
function updateJsonInfo(data) {
    var jsonString = JSON.stringify(data);
    var jsonSize = new Blob([jsonString]).size;
    var itemCount = data.items ? data.items.length : 0;
    var createdAt = data.header && data.header.created_at ? formatDate(data.header.created_at) : '-';
    var status = data.header && data.header.status ? data.header.status : 'draft';
    var grandTotal = data.header && data.header.grand_total ? formatCurrency(data.header.grand_total) : '-';
    
    $('#jsonSize').text(jsonSize.toLocaleString());
    $('#itemCount').text(itemCount);
    $('#createdAt').text(createdAt);
    $('#invoiceStatus').html('<span class="label label-info">' + status + '</span>');
    $('#grandTotalInfo').text(grandTotal);
}

// Function to copy JSON to clipboard
function copyJsonToClipboard() {
    var jsonText = $('#jsonTextarea').val();
    
    if (!jsonText) {
        alert('Không có dữ liệu JSON để copy!');
        return;
    }
    
    // Create temporary textarea for copying
    var tempTextarea = $('<textarea>');
    $('body').append(tempTextarea);
    tempTextarea.val(jsonText).select();
    
    try {
        document.execCommand('copy');
        alert('Đã copy JSON vào clipboard!');
    } catch (err) {
        alert('Không thể copy. Vui lòng copy thủ công!');
    }
    
    tempTextarea.remove();
}

// Function to download JSON file
function downloadJsonFile() {
    if (!currentJsonData) {
        alert('Không có dữ liệu JSON để tải xuống!');
        return;
    }
    
    var jsonString = JSON.stringify(currentJsonData, null, 2);
    var filename = 'einvoice_' + (currentJsonData.header ? currentJsonData.header.sales_code : 'data') + '_' + 
                   new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.json';
    
    // Create blob and download
    var blob = new Blob([jsonString], { type: 'application/json' });
    var url = window.URL.createObjectURL(blob);
    
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Function to format JSON display
function formatJsonDisplay() {
    if (!currentJsonData) {
        alert('Không có dữ liệu JSON để format!');
        return;
    }
    
    // Toggle between compact and formatted view
    var currentText = $('#jsonTextarea').val();
    var isCompact = !currentText.includes('\n  ');
    
    if (isCompact) {
        // Format with indentation
        var formattedJson = JSON.stringify(currentJsonData, null, 2);
        $('#jsonTextarea').val(formattedJson);
        $('#formatJsonBtn').html('<i class="fa fa-compress"></i> Compact JSON');
    } else {
        // Compact format
        var compactJson = JSON.stringify(currentJsonData);
        $('#jsonTextarea').val(compactJson);
        $('#formatJsonBtn').html('<i class="fa fa-magic"></i> Format JSON');
    }
}
</script>
