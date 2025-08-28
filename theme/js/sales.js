// Hàm format tiền tệ Việt Nam
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + '₫';
}

// Hàm format số (không có ký hiệu tiền tệ)
function formatNumber(amount) {
    return parseFloat(amount).toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
}

// Hàm parse tiền tệ về số (xử lý format VN)
function parseCurrency(str) {
    if (!str) return 0;
    
    var stringValue = str.toString();
    console.log('parseCurrency JS input:', stringValue);
    
    // Xóa bỏ ký hiệu tiền tệ và khoảng trắng
    stringValue = stringValue.replace(/[₫\s]/g, '');
    
    // Xử lý format tiền tệ Việt Nam với dấu chấm phân cách hàng nghìn
    // Ví dụ: "100.000" -> "100000", "1.000.000" -> "1000000"
    var parts = stringValue.split('.');
    
    if (parts.length > 1) {
        // Kiểm tra xem có phải là format hàng nghìn không
        var isThousandSeparator = true;
        for (var i = 1; i < parts.length; i++) {
            if (parts[i].length !== 3) {
                isThousandSeparator = false;
                break;
            }
        }
        
        if (isThousandSeparator) {
            // Format hàng nghìn: nối tất cả các phần
            stringValue = parts.join('');
        } else {
            // Có thể là số thập phân, giữ nguyên
            stringValue = stringValue;
        }
    }
    
    // Chỉ giữ lại số
    var cleanValue = stringValue.replace(/[^0-9.]/g, '');
    var result = parseFloat(cleanValue) || 0;
    
    console.log('parseCurrency JS output:', result);
    return result;
}

// Format input tiền tệ cho dòng mới
function formatNewRowInputs(rowcount) {
    $('#td_data_' + rowcount + '_10').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value) {
            $(this).val(formatNumber(value));
        }
    });
    
    $('#td_data_' + rowcount + '_8').on('input', function() {
        var value = $(this).val().replace(/[^0-9]/g, '');
        if (value) {
            $(this).val(formatNumber(value));
        }
    });
}

//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {
    if (kevent.keyCode == 13) {
        $("#" + target).focus();
    }
}

$("#save,#update").on("click", function (e) {
    var this_id = this.id;

    var base_url = $("#base_url").val().trim();

    //Initially flag set true
    var flag = true;

    function check_field(id) {
        if (
            !$("#" + id)
                .val()
                .trim()
        ) {
            //Also check Others????
            $("#" + id + "_msg")
                .fadeIn(200)
                .show()
                .html("Required Field")
                .addClass("required");
            // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag = false;
        } else {
            $("#" + id + "_msg")
                .fadeOut(200)
                .hide();
            //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }

    //Validate Input box or selection box should not be blank or empty
    check_field("customer_id");
    check_field("sales_date");
    check_field("sales_status");
    //check_field("warehouse_id");
    /*if(!isNaN($("#amount").val().trim()) && parseFloat($("#amount").val().trim())==0){
          toastr["error"]("You have entered Payment Amount! <br>Please Select Payment Type!");
          return;
      }*/
    if (flag == false) {
        toastr["error"]("You have missed Something to Fillup!");
        return;
    }

    //Atleast one record must be added in sales table
    var rowcount = document.getElementById("hidden_rowcount").value;
    var flag1 = false;
    for (var n = 1; n <= rowcount; n++) {
        if (
            $("#td_data_" + n + "_3").val() != null &&
            $("#td_data_" + n + "_3").val() != ""
        ) {
            flag1 = true;
        }
    }

    if (flag1 == false) {
        toastr["warning"]("Vui lòng chọn lựa sản phẩm!!");
        $("#item_search").focus();
        return;
    }
    //end

    /*if(this_id=='save' && $("#customer_id").val().trim()==1){
        if(parseFloat($("#total_amt").text())!=parseFloat($("#amount").val())){
          $("#amount").focus();
          toastr["warning"]("Khách lẻ không phải là thượng đế nha!!");
      var total_amount = parseCurrency($("#total_amt").text());
      var payment_amount = parseCurrency($("#amount").val());
      if(total_amount != payment_amount){
        $("#amount").focus();
        toastr["warning"]("Khách lẻ không phải là thượng đế nha!!");
        return;
      }
        if($("#payment_type").val()==''){
          toastr["warning"]("Lựa chọn hình thức thanh toán!!");
          return;
        }
          if($("#payment_type").val()==''){
            toastr["warning"]("Lựa chọn hình thức thanh toán!!");
            return;
          }
      }*/

    // Parse về số trước khi gửi đi
    var tot_subtotal_amt=parseCurrency($("#subtotal_amt").text());
    var other_charges_amt=parseCurrency($("#other_charges_amt").text());//other_charges include tax calcualated amount
    var tot_discount_to_all_amt=parseCurrency($("#discount_to_all_amt").text());
    var tot_round_off_amt=parseCurrency($("#round_off_amt").text());
    var tot_total_amt=parseCurrency($("#total_amt").text());


    //if(confirm("Do You Wants to Save Record ?")){
    e.preventDefault();
    data = new FormData($("#sales-form")[0]); //form name
    /*Check XSS Code*/
    if (!xss_validation(data)) {
        return false;
    }

    $(".box").append(
        '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    

    //if(confirm("Bạn có chắc chắn muốn lưu không ??")){
        e.preventDefault();
        data = new FormData($('#sales-form')[0]);//form name
        /*Check XSS Code*/
        if(!xss_validation(data)){ return false; }
    // =================== TÍNH TOÁN HÓA ĐƠN ĐIỆN TỬ ===================
    // Gọi hàm tính toán từ einvoice.js
    try {
        console.log('🧾 SALES: Bắt đầu tính toán hóa đơn điện tử...');
        
        // Gọi hàm tính toán với dữ liệu thực từ giao diện (useTestData = false)
        // Sử dụng phương án 1 (điều chỉnh đơn giá) để xử lý sai số
        var einvoice_result = processEInvoiceCalculation(false, 1);
        console.log('📊 SALES: Kết quả tính toán hóa đơn điện tử:', einvoice_result);
        if (einvoice_result.success) {
            console.log('✅ SALES: Tính toán hóa đơn điện tử thành công!');
            console.log('📊 SALES: Tổng tiền sản phẩm sau tính lại:', einvoice_result.total_items_amount);
            console.log('💰 SALES: Tổng giảm giá phân bổ:', einvoice_result.total_discount_allocated);
            console.log('🎯 SALES: Sai lệch cuối cùng:', einvoice_result.final_difference);
        } else {
            console.warn('⚠️ SALES: Tính toán hóa đơn có sai lệch:', einvoice_result.final_difference);
        }
        
        // Có thể sử dụng kết quả einvoice_result.data_items để cập nhật giao diện nếu cần
        // hoặc gửi kèm trong AJAX request
        
    } catch (error) {
        console.error('❌ SALES: Lỗi khi tính toán hóa đơn điện tử:', error);
        console.log('💡 SALES: Đảm bảo file einvoice.js đã được load trước sales.js');
    }
    // =================== KẾT THÚC TÍNH TOÁN HÓA ĐƠN ===================
    $("#" + this_id).attr("disabled", true); //Enable Save or Update button
    $.ajax({
        type: "POST",
        url:
            base_url +
            "sales/sales_save_and_update?command=" +
            this_id +
            "&rowcount=" +
            rowcount +
            "&tot_subtotal_amt=" +
            tot_subtotal_amt +
            "&tot_discount_to_all_amt=" +
            tot_discount_to_all_amt +
            "&tot_round_off_amt=" +
            tot_round_off_amt +
            "&tot_total_amt=" +
            tot_total_amt +
            "&other_charges_amt=" +
            other_charges_amt,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            // alert(result);return;
            result = result.split("<<<###>>>");
            if (result[0] == "success") {
                // Gọi hàm lưu thông tin hóa đơn điện tử
                if (typeof einvoice_result !== 'undefined') {
                    var sales_id_create = result[1];
                    einvoice_result.invoice_info.sales_id = sales_id_create; // Cập nhật sales_id vào invoice_info
                    save_info_data_einvoice(einvoice_result);
                }
                setTimeout(() => {
                     location.href = base_url + "sales/invoice/" + result[1];
                }, 1000);
            } else if (result[0] == "failed") {
                toastr["error"]("Chưa thể tạo đơn hàng mới!");
            } else if (result[0] == "unvalidate") {
                toastr["error"](
                    "Đã hết thời gian sử dụng phần mềm, vui lòng gia hạn thêm!"
                );
            } else {
                alert(result);
            }
            $("#" + this_id).attr("disabled", false); //Enable Save or Update button
            $(".overlay").remove();
        },
    });
    //}
});

// Hàm gọi api lưu thông tin hóa đơn điện tử
function save_info_data_einvoice(einvoice_result) {
    var base_url = $("#base_url").val().trim();
    $.ajax({
        type: "POST",
        url: base_url + "sales/save_info_einvoice_data",
        data: {
            invoice_info: einvoice_result.invoice_info,
            invoice_items: einvoice_result.invoice_items,
        },
        success: function (response) {
            console.log("E-Invoice data saved successfully:", response);
        },
        error: function (error) {
            console.error("Error saving E-Invoice data:", error);
        }
    });
}

$("#item_search").keypress(function (e) {
    var key = e.which;
    // the enter key code
    if (key == 13) {
        $("#item_search").autocomplete("search");
    }
});

$("#item_search").bind("paste", function (e) {
    $("#item_search").autocomplete("search");
});

$("#item_search").autocomplete({
    source: function (data, cb) {
        $.ajax({
            autoFocus: true,
            url: $("#base_url").val() + "items/get_json_items_details",
            method: "GET",
            dataType: "json",
            /*showHintOnFocus: true,
            autoSelect: true, 
            
            selectInitial :true,*/

            data: {
                name: data.term,
                /*warehouse_id:$("#warehouse_id").val().trim(),*/
            },
            success: function (res) {
                //console.log(res);
                var result;
                result = [
                    {
                        //label: 'No Records Found '+data.term,
                        label: "No Records Found ",
                        value: "",
                    },
                ];

                if (res.length) {
                    result = $.map(res, function (el) {
                        var Levelprice = $("#cusLV").attr("data-lv");
                        var fi_level = Levelprice;
                        var fi_price = el.final_price;
                        switch (Levelprice) {
                            case "0":
                                fi_price = el.final_price0;
                                fi_level = "Giá Cấp 0: ";
                                break;
                            case "1":
                                fi_price = el.final_price1;
                                fi_level = "Giá Cấp 1: ";
                                break;
                            case "2":
                                fi_price = el.final_price2;
                                fi_level = "Giá Cấp 2: ";
                                break;
                            case "3":
                                fi_price = el.final_price3;
                                fi_level = "Giá Cấp 3: ";
                                break;
                            default:
                                fi_price = el.final_price;
                                fi_level = "Giá Lẻ: ";
                        }
                        return {
                            label: el.item_code +'--[Số lượng:'+el.stock+'] --'+ el.label,
                            label: el.label + ' (Kho: ' + el.stock + ')' + ' - có thể bán: ' + el.cansold + ' - ' + fi_level  + fi_price,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                            stock: el.stock,
                            unit_name: el.unit_name,
                            // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,
                        };
                    });
                }
                // log tên hàm callback
                //console.log(result);
                // Trả về kết quả cho hàm callback
               
                cb(result);
            },
        });
    },
    response: function (e, ui) {
        if (ui.content.length == 1) {
            $(this)
                .data("ui-autocomplete")
                ._trigger("select", "autocompleteselect", ui);
            $(this).autocomplete("close");
        }
        //console.log(ui.content[0].id);
    },
    //loader start
    search: function (e, ui) { },
    select: function (e, ui) {
        //$("#mobile").val(ui.item.mobile)
        //$("#item_search").val(ui.item.value);
        //$("#customer_dob").val(ui.item.customer_dob)
        //$("#address").val(ui.item.address)
        //alert("id="+ui.item.id);

        if (typeof ui.content != "undefined") {
            console.log("Autoselected first");
            if (isNaN(ui.content[0].id)) {
                return;
            }
            var stock = ui.content[0].stock;
            var item_id = ui.content[0].id;
        } else {
            console.log("manual Selected");
            var stock = ui.item.stock;
            var item_id = ui.item.id;
            var item_unit_name = ui.item.unit_name;
        }

        /*(parseFloat(stock)<=0){
                  toastr["warning"](stock+" Items in Stock!!");
                  failed.currentTime = 0; 
                  failed.play();
                  return false;
                }*/
        if (restrict_quantity(item_id)) {
            return_row_with_data(item_id, item_unit_name);
        }
        $("#item_search").val("");
    },
    //loader end
});

function return_row_with_data(item_id, item_unit_name = ""){
  $("#item_search").addClass('ui-autocomplete-loader-center');
	var base_url=$("#base_url").val().trim();
	var rowcount=$("#hidden_rowcount").val();
	var cusLvs=$("#cusLV")[0].getAttribute('data-lv');
	//console.log("aaaaaaaaaaaa "+cusLvs);
	$.post(base_url+"sales/return_row_with_data2/"+cusLvs+"/"+rowcount+"/"+item_id,{},function(result){
	    //$.post(base_url+"sales/return_row_with_data/"+rowcount+"/"+item_id,{},function(result){
        //alert(result);
        //$('#sales_table tbody').append(result);
        if (item_unit_name) {
            result += '<input type="hidden" name="item_unit_name_' + rowcount + '" value="' + item_unit_name + '">';
        }
        $('#sales_table tbody').prepend(result);
       	$("#hidden_rowcount").val(parseFloat(rowcount)+1);
        success.currentTime = 0;
        success.play();
        // enable_or_disable_item_discount();
        
        // Format tiền tệ cho các input trong dòng mới
        formatNewRowInputs(rowcount);
        
        $("#item_search").removeClass('ui-autocomplete-loader-center');
        $("#td_data_"+rowcount+"_3").focus();
        $("#td_data_"+rowcount+"_3").select();
    }); 
}
//INCREMENT ITEM
function increment_qty(rowcount) {
    var flag = restrict_quantity(
        $("#tr_item_id_" + rowcount)
            .val()
            .trim()
    );
    if (!flag) {
        return false;
    }

    var item_qty = $("#td_data_" + rowcount + "_3").val();
    var available_qty = $("#tr_available_qty_" + rowcount + "_13").val();
    //if(parseFloat(item_qty)<parseFloat(available_qty)){

    new_item_qty = parseFloat(item_qty) + 1;

    //if(parseFloat(new_item_qty)>parseFloat(available_qty)){
    //  new_item_qty = available_qty;
    //}

    $("#td_data_" + rowcount + "_3").val(new_item_qty);
    //}
    calculate_tax(rowcount);
}
//DECREMENT ITEM
function decrement_qty(rowcount) {
    var item_qty = $("#td_data_" + rowcount + "_3").val();

    if (item_qty < 1) {
        $("#td_data_" + rowcount + "_3").val(item_qty);
        toastr["warning"]("Giá trị nhỏ nhất là 1!");
        return;
    }

    if (item_qty <= 1) {
        $("#td_data_" + rowcount + "_3").val(1);
        toastr["warning"]("Giá trị nhỏ nhất là 1!!");
        return;
    }
    $("#td_data_" + rowcount + "_3").val(parseFloat(item_qty) - 1);
    calculate_tax(rowcount);
}

function update_paid_payment_total() {
  var rowcount=$("#paid_amt_tot").attr("data-rowcount");
  var tot=0;
  for(i=1;i<rowcount;i++){
    if(document.getElementById("paid_amt_"+i)){
      tot += parseFloat($("#paid_amt_"+i).html().replace(/[^0-9]/g, ''));
    }
  }
  $("#paid_amt_tot").html(formatCurrency(tot));
}
function delete_payment(payment_id){
 if(confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")){
    var base_url=$("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"sales/delete_payment",{payment_id:payment_id},function(result){
   //alert(result);return;
   result=result.trim();
     if(result=="success")
        { 
          toastr["success"]("Record Deleted Successfully!");
          $("#payment_row_"+payment_id).remove();
          success.currentTime = 0; 
          success.play();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
          failed.currentTime = 0; 
          failed.play();
        }
        else{
          toastr["error"](result);
          failed.currentTime = 0; 
          failed.play();
        }
        $(".overlay").remove();
        update_paid_payment_total();
   });
   }//end confirmation   
  }

  //Delete Record start
function delete_sales(q_id)
{
  
   if(confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")){
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("sales/delete_sales",{q_id:q_id},function(result){
   //alert(result);return;
     if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
        }
        else{
           toastr["error"](result);
        }
        $(".overlay").remove();
        return false;
   });
   }//end confirmation
}
//Delete Record end
function multi_delete(){
  //var base_url=$("#base_url").val().trim();
    var this_id=this.id;
    
    if(confirm("Bạn có chắc chắn không??")){
      data = new FormData($('#table_form')[0]);//form name
      /*Check XSS Code*/
      if(!xss_validation(data)){ return false; }
      
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $("#"+this_id).attr('disabled',true);  //Enable Save or Update button
      $.ajax({
      type: 'POST',
      url: 'sales/multi_delete',
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function(result){
        result=result.trim();
  //alert(result);return;
        if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          success.currentTime = 0; 
            success.play();
          $('#example2').DataTable().ajax.reload();
          $(".delete_btn").hide();
          $(".group_check").prop("checked",false).iCheck('update');
        }

        $(".box").append(
            '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
        );
        $("#" + this_id).attr("disabled", true); //Enable Save or Update button
        $.ajax({
            type: "POST",
            url: "sales/multi_delete",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                result = result.trim();
                //alert(result);return;
                if (result == "success") {
                    toastr["success"]("Record Deleted Successfully!");
                    success.currentTime = 0;
                    success.play();
                    $("#example2").DataTable().ajax.reload();
                    $(".delete_btn").hide();
                    $(".group_check").prop("checked", false).iCheck("update");
                } else if (result == "failed") {
                    toastr["error"]("Sorry! Failed to save Record.Try again!");
                    failed.currentTime = 0;
                    failed.play();
                } else {
                    toastr["error"](result);
                    failed.currentTime = 0;
                    failed.play();
                }
                $("#" + this_id).attr("disabled", false); //Enable Save or Update button
                $(".overlay").remove();
            },
        });
    }
    //e.preventDefault
      });
    }
}

function multi_paid() {
    //var base_url=$("#base_url").val().trim();
    var this_id = this.id;

    if (confirm("Bạn có chắc chưa?")) {
        data = new FormData($("#table_form")[0]); //form name
        /*Check XSS Code*/
        if (!xss_validation(data)) {
            return false;
        }

        $(".box").append(
            '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
        );
        $("#" + this_id).attr("disabled", true); //Enable Save or Update button
        $.ajax({
            type: "POST",
            url: "sales/multi_paid",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                result = result.trim();
                //alert(result);return;
                if (result == "success") {
                    toastr["success"]("Đã hoàn tất thanh toán!");
                    success.currentTime = 0;
                    success.play();
                    $("#example2").DataTable().ajax.reload();
                    $(".paid_all_btn").hide();
                    $(".group_check").prop("checked", false).iCheck("update");
                } else if (result == "failed") {
                    toastr["error"]("Lỗi CMNR!");
                    failed.currentTime = 0;
                    failed.play();
                } else {
                    toastr["error"](result);
                    failed.currentTime = 0;
                    failed.play();
                }
                $("#" + this_id).attr("disabled", false); //Enable Save or Update button
                $(".overlay").remove();
            },
        });
    }
    //e.preventDefault
}

function pay_now(sales_id) {
    $.post("sales/show_pay_now_modal", { sales_id: sales_id }, function (result) {
        $(".pay_now_modal").html("").html(result);
        //Date picker
        $(".datepicker").datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
        });
        $("#pay_now").modal("toggle");
    });
}

function stt_now(sales_id) {
    $.post("sales/show_stt_now_modal", { sales_id: sales_id }, function (result) {
        $(".pay_now_modal").html("").html(result);
        //Date picker
        $(".datepicker").datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
        });
        $("#pay_now").modal("toggle");
    });
}
function view_payments(sales_id) {
    $.post(
        "sales/view_payments_modal",
        { sales_id: sales_id },
        function (result) {
            $(".view_payments_modal").html("").html(result);
            console.log(result);
            $("#view_payments_modal").modal("toggle");
        }
    );
}

function save_payment(sales_id) {
    var base_url = $("#base_url").val().trim();

    //Initially flag set true
    var flag = true;

    function check_field(id) {
        if (
            !$("#" + id)
                .val()
                .trim()
        ) {
            //Also check Others????
            $("#" + id + "_msg")
                .fadeIn(200)
                .show()
                .html("Required Field")
                .addClass("required");
            // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag = false;
        } else {
            $("#" + id + "_msg")
                .fadeOut(200)
                .hide();
            //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }

    //Validate Input box or selection box should not be blank or empty
    check_field("amount");
    check_field("payment_date");

    // var payment_date = $("#payment_date").val().trim();
    // var amount = $("#amount").val().trim(); //tiền thanh toán
    // var payment_type = $("#payment_type").val().trim();
    // var payment_note = $("#payment_note").val().trim();


    var payment_date=$("#payment_date").val().trim();
    var amount_input=$("#amount").val().trim();//tiền thanh toán input
    var amount = parseCurrency(amount_input); // Chuyển đổi từ format VN về số
    var payment_type=$("#payment_type").val().trim();
    var payment_note=$("#payment_note").val().trim();
    
    console.log('Payment processing - input:', amount_input, 'parsed:', amount);
    

    var getPoint = Math.floor(amount / 1000);

    if (amount == 0) {
        toastr["error"]("Số tiền nhập vào không hợp lệ!");
        return false;
    }

    var longdeptrai = $("#due_amount_temp")[0].getAttribute(
        "data-due_amount_temp"
    );
    //if(amount > parseFloat($("#due_amount_temp").html().trim())){
    if (amount > parseFloat(longdeptrai.trim())) {
        //console.log('AAAA ' + parseFloat($("#due_amount_temp").html().trim()));
        toastr["error"]("Số tiền nhập vào không được lớn hơn số nợ");
        return false;
    }

    $(".box").append(
        '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $(".payment_save").attr("disabled", true); //Enable Save or Update button
    $.post(
        "sales/save_payment",
        {
            sales_id: sales_id,
            payment_type: payment_type,
            amount: amount,
            payment_date: payment_date,
            payment_note: payment_note,
        },
        function (result) {
            result = result.trim();
            //alert(result);return;
            if (result == "success") {
                $("#pay_now").modal("toggle");
                toastr["success"]("Hoàn thành!");
                success.currentTime = 0;
                success.play();
                $("#example2").DataTable().ajax.reload();
            } else if (result == "failed") {
                toastr["error"]("Sorry! Failed to save Record.Try again!");
                failed.currentTime = 0;
                failed.play();
            } else {
                toastr["error"](result);
                failed.currentTime = 0;
                failed.play();
            }
            $(".payment_save").attr("disabled", false); //Enable Save or Update button
            $(".overlay").remove();
        }
    );
}

function save_stt(sales_id) {
    var base_url = $("#base_url").val().trim();
    $.post("sales/save_stt", { sales_id: sales_id }, function (result) {
        result = result.trim();
        if (result == "success") {
            $("#pay_now").modal("toggle");
            toastr["success"]("Hoàn thành!");
            success.currentTime = 0;
            success.play();
            $("#example2").DataTable().ajax.reload();
        } else if (result == "failed") {
            toastr["error"]("Đã có lỗi xảy ra! Vui lòng liên hệ Admin!");
            failed.currentTime = 0;
            failed.play();
        } else {
            toastr["error"](result);
            failed.currentTime = 0;
            failed.play();
        }
        $(".payment_save").attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
    });
}

function delete_sales_payment(payment_id) {
    if (confirm("Do You Wants to Delete Record ?")) {
        var base_url = $("#base_url").val().trim();
        $(".box").append(
            '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
        );
        $.post(
            base_url + "sales/delete_payment",
            { payment_id: payment_id },
            function (result) {
                //alert(result);return;
                result = result.trim();
                if (result == "success") {
                    $("#view_payments_modal").modal("toggle");
                    toastr["success"]("Record Deleted Successfully!");
                    success.currentTime = 0;
                    success.play();
                    $("#example2").DataTable().ajax.reload();
                } else if (result == "failed") {
                    toastr["error"]("Failed to Delete .Try again!");
                    failed.currentTime = 0;
                    failed.play();
                } else {
                    toastr["error"](result);
                    failed.currentTime = 0;
                    failed.play();
                }
                $(".overlay").remove();
            }
        );
    } //end confirmation
}

// function delete_sales_payment(payment_id){
//  if(confirm("Bạn có chắc chắn muốn xóa bản ghi này không?")){
//     var base_url=$("#base_url").val().trim();
//     $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
//    $.post(base_url+"sales/delete_payment",{payment_id:payment_id},function(result){
//    //alert(result);return;
//    result=result.trim();
//      if(result=="success")
//         {
//           $('#view_payments_modal').modal('toggle');
//           toastr["success"]("Record Deleted Successfully!");
//           success.currentTime = 0; 
//           success.play();
//           $('#example2').DataTable().ajax.reload();
//              }
//     } //end for
//     /*if(available_qty!=0 && count_item_qty>=available_qty){
//           toastr["warning"]("Only "+available_qty+" Items in Stock!!");
//           failed.currentTime = 0; 
//           failed.play();
//               return false;
//         }*/
//     }
// }
function restrict_quantity(item_id) {
    var rowcount = $("#hidden_rowcount").val();
    var available_qty = 0;
    var count_item_qty = 0;
    var selected_item_id = 0;
    for (i = 1; i <= rowcount; i++) {
        if (document.getElementById("tr_item_id_" + i)) {
            selected_item_id = $("#tr_item_id_" + i)
                .val()
                .trim();
            if (parseFloat(item_id) == parseFloat(selected_item_id)) {
                available_qty = parseFloat(
                    $("#tr_available_qty_" + i + "_13")
                        .val()
                        .trim()
                );
                count_item_qty += parseFloat(
                    $("#td_data_" + i + "_3")
                        .val()
                        .trim()
                );
            }
        }
    } //end for
    /*if(available_qty!=0 && count_item_qty>=available_qty){
          toastr["warning"]("Only "+available_qty+" Items in Stock!!");
          failed.currentTime = 0; 
          failed.play();
              return false;
        }*/
    return true;
}

/*$("#warehouse_id").on("change",function(event) {
    $('#sales_table tbody').html('');
    final_total();
    if($("#warehouse_id").val().trim()!=''){
      $("#item_search").attr({ disabled: false,});
    }
    else{
     $("#item_search").attr({ disabled: true,}); 
    }
  });*/


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
        var item_name = $("#td_data_" + i + "_1").text().trim();
        var item_quantity = parseFloat($("#td_data_" + i + "_3").val().trim()) || 0;
        var item_price = parseFloat($("#td_data_" + i + "_10").val().trim()) || 0;
        var item_discount_item = parseFloat($("#td_data_" + i + "_8").val().trim()) || 0;
        var item_tax_percent = parseFloat($("#tr_tax_value_" + i).val().trim()) || 0;
        var item_tax_amount = parseFloat($("#td_data_" + i + "_11").val().trim()) || 0;
        var item_amount = parseFloat($("#td_data_" + i + "_9").val().trim()) || 0;
        console.log('Sản phẩm ' + i + ': ' + item_name);
        console.log('  - Số lượng:', $("#td_data_" + i + "_3").val().trim());
        console.log('  - Đơn giá:', $("#td_data_" + i + "_10").val().trim());
        console.log('  - Giảm giá sản phẩm:', $("#td_data_" + i + "_8").val().trim());
        console.log('  - Thuế:', $("#tr_tax_value_" + i).val().trim());
        console.log('  - Tiền thuế:', $("#td_data_" + i + "_11").val().trim());
        console.log('  - Tổng tiền:', $("#td_data_" + i + "_9").val().trim());

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
        invoice_amount = parseFloat($("#total_amt").text().trim().replace('đ', '').replace('.', '').replace(',', '.')) || 0;
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

    var invoice_info = {
        sales_id: '', // Chưa có thông tin sales_id
        ten_khach_hang: $('#select2-customer_id-container').text(), // Chưa có thông tin khách hàng
        dia_chi_khách_hang: $('#KHaddress').val(), // Chưa có thông tin địa chỉ khách hàng
        so_dien_thoai_khach_hang: '', // Chưa có thông tin
        email_khach_hang: '', // Chưa có thông tin email khách hàng
        ma_so_thue: '', // Chưa có thông tin mã số thuế
        ten_cong_ty: '', // Chưa có thông tin tên công ty
        can_cuoc_cong_dan: '', // Chưa có thông tin căn cước công dân
        so_ho_chieu: '', // Chưa có thông tin số hộ chiếu
        ghi_chu: '', // Chưa có thông tin ghi chú
    };
    var invoice_items = data_items.map(function(item) {
        return {
            ten_san_pham: item.item_name,
            so_luong: item.item_quantity,
            don_gia: item.item_price,
            thanh_tien: item.item_amount * item.item_quantity,
            giam_gia: item.item_discount_item,
            giam_gia_phan_bo: item.item_discount_from_all,
            tong_giam_gia: item.item_discount_item + item.item_discount_from_all,
            thanh_tien_truoc_thue: item.item_amount_before_tax_final,
            phan_tram_thue: item.item_tax_percent,
            thue: item.item_tax_amount,
            tong_tien: item.item_amount,
            tong_tien_goc: item.item_amount_original,
            thanh_tien_truoc_thue_goc: item.item_amount_before_tax_original,
            price_adjustment: item.price_adjustment || 0, // Chỉ có trong phương án 1
            discount_adjustment: item.discount_adjustment || 0, // Chỉ có trong phương án 2
            adjustment: item.adjustment || 0 // Chỉ có trong phương án 3    
        };
    });
    console.log('Thông tin hóa đơn:', invoice_info);
    console.log('Danh sách sản phẩm hóa đơn:', invoice_items);
    // Trả về kết quả để sử dụng ở nơi khác
    return {
        success: final_difference < 0.01,
        data_items: data_items,
        invoice_info: invoice_info,
        invoice_items: invoice_items,
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