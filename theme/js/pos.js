//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}
/*Email validation code*/
function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}

$("#pay_all").on("click",function(){
	save(print=true,pay_all=true);
});


// Hàm reset UI button
function resetUIButton() {
    $('.prevent-double-click').removeClass('processing').prop('disabled', false);
}

// Biến flag để ngăn chặn double-click
var isProcessing = false;

// Helper function để remove dấu phẩy từ các input trước khi submit
function prepareFormDataForSubmit() {
    // Remove commas from all sales_price fields
    $('input[id^="sales_price_"]').each(function() {
        var $this = $(this);
        var rawValue = $this.attr('data-raw-value');
        if (rawValue) {
            $this.val(rawValue);
        } else {
            var cleanValue = removeCommasFromNumber($this.val());
            $this.val(cleanValue);
        }
    });
    
    // Remove commas from all subtotal fields
    $('input[id^="td_data_"][id$="_5"]').each(function() {
        var $this = $(this);
        var rawValue = $this.attr('data-raw-value');
        if (rawValue) {
            $this.val(rawValue);
        } else {
            var cleanValue = removeCommasFromNumber($this.val());
            $this.val(cleanValue);
        }
    });
}

// Helper function để restore format sau khi submit
function restoreFormDataFormat() {
    // Restore format for sales_price fields
    $('input[id^="sales_price_"]').each(function() {
        var $this = $(this);
        var rawValue = parseNumberSafely($this.val());
        if (!isNaN(rawValue)) {
            var formattedValue = formatNumberWithCommas(rawValue);
            $this.val(formattedValue);
            $this.attr('data-raw-value', rawValue);
        }
    });
    
    // Restore format for subtotal fields  
    $('input[id^="td_data_"][id$="_5"]').each(function() {
        var $this = $(this);
        var rawValue = parseNumberSafely($this.val());
        if (!isNaN(rawValue)) {
            var formattedValue = formatNumberWithCommas(rawValue);
            $this.val(formattedValue);
            $this.attr('data-raw-value', rawValue);
        }
    });
}
// Hàm bỏ dấu chấm, dấu phẩy trong text
function removeCommasAndDots(text) {
    if (text === null || text === undefined) {
        return -1;
    }
    return text.replace(/[,\.]/g, '');
}

function save(print=false,pay_all=false){
    // // Tìm các tr có class itemrows trong bảng có id là print_area
    // var itemRows = $('#print_area .itemrows');
    // // Lặp qua từng dòng để lấy dữ liệu
    // itemRows.each(function() {
    //     var row = $(this);
    //     // Lấy giá trị của thuộc tính "data-item-id" trong thẻ tr
    //     var itemId = row.attr('data-item-id');
    //     // Nếu itemID = -1 thì lấy value trong thẻ td đầu tiên
    //     // Nếu itemID != -1 thì lấy value trong thẻ span thứ hai trong thẻ td đầu tiên
    //     let itemName = '';
    //     if(itemId == -1) {
    //         itemName = row.find('td:first').text();
    //     } else {
    //         itemName = row.find('td:first span:nth-child(2)').text();
    //     }
    //     // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ hai làm số lượng
    //     let itemQuantity = row.find('td:nth-child(2) input').val();
    //     // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ ba làm đơn giá
    //     let itemPrice = row.find('td:nth-child(3) input').val();
    //     // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ tư làm chiết khấu
    //     let itemDiscount = row.find('td:nth-child(4) input').val();
    //     // Lấy giá trị của thuộc tính "data-raw-value" trong thẻ input đầu tiên trong thẻ td thứ sáu làm thành tiền
    //     // Input trên dom <input data-toggle="tooltip" title="Total" id="td_data_0_5" name="td_data_0_5" type="text" class="form-control no-padding pointer" readonly="" value="50,000" data-raw-value="55000">
    //     let itemTotal = row.find('td:nth-child(6) input').attr('data-raw-value');
    //     // let itemTotal = row.find('td:nth-child(5) input').attr('data-raw-value') || row.find('td:nth-child(5) input').val();
    //     // Lấy thẻ input thứ 5 trong tr(row) làm phần trăm thuế
    //     let itemTaxPercent = row.find('input:nth-child(12)').val();
    //     // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ năm làm thuế
    //     let itemTaxAmount = row.find('td:nth-child(5) input').val();


    //     console.log('📦 SALES: ID sản phẩm:', itemId);
    //     console.log('📦 SALES: Tên sản phẩm:', itemName);
    //     console.log('📦 SALES: Số lượng sản phẩm:', itemQuantity);
    //     console.log('📦 SALES: Giá sản phẩm:', removeCommasAndDots(itemPrice));
    //     console.log('📦 SALES: Chiết khấu sản phẩm:', removeCommasAndDots(itemDiscount));
    //     console.log('📦 SALES: Thành tiền sản phẩm:', removeCommasAndDots(itemTotal));
    //     console.log('📦 SALES: Phần trăm thuế sản phẩm:', removeCommasAndDots(itemTaxPercent));
    //     console.log('📦 SALES: Số tiền thuế sản phẩm:', removeCommasAndDots(itemTaxAmount));

    //     //let itemTaxPercent = row.find('td:nth-child(5) input').val();
    // });

    // return;


//$('.make_sale').on("click",function (e) {
	
	// Kiểm tra nếu đang xử lý thì không cho phép thực hiện lại
	if(isProcessing) {
		toastr["warning"]("Đang xử lý, vui lòng đợi...");
		return;
	}
	
	var base_url=$("#base_url").val().trim();
    
    // Kiểm tra validation sản phẩm - sử dụng tr.itemrows để chính xác hơn
    var productCount = $("tr.itemrows").length;
    if(productCount == 0){
    	toastr["warning"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
		return;
    }

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


	console.log('Số lượng sản phẩm:', productCount);
	// var rowcount = productCount;
	// for (var i = 0; i < rowcount; i++) {   
    //     var item_name = $("#td_data_" + i + "_0").text().trim();
	// 	console.log('so luowng:', $("#item_qty_" + i + "_1"));
    //     var item_quantity = parseFloat($("#item_qty_" + i + "_1").val().trim()) || 0;
    //     var item_price = parseFloat($("#sales_price_" + i).val().trim().replace(/,/g, '') || 0);
    //     var item_discount_item = parseFloat($("#item_discount_" + i).val().trim()) || 0;
    //     var item_tax_percent = parseFloat($("#tr_tax_value_" + i).val().trim()) || 0;
    //     var item_tax_amount = parseFloat($("#td_data_" + i + "_4").val().trim()) || 0;
    //     var item_amount = parseFloat($("#td_data_" + i + "_5").val().trim().replace(/,/g, '') || 0);
    //     console.log('Sản phẩm ' + i + ': ' + item_name);
    //     console.log('  - Số lượng:', item_quantity);
    //     console.log('  - Đơn giá:', item_price);
    //     console.log('  - Giảm giá sản phẩm:', item_discount_item);
    //     console.log('  - Thuế:', item_tax_percent);
    //     console.log('  - Tiền thuế:', item_tax_amount);
    //     console.log('  - Tổng tiền:', item_amount);

    //     // Tính tiền trước thuế ban đầu (sau giảm giá sản phẩm)
    //     var item_amount_before_tax = (item_quantity * item_price) - item_discount_item;
    //     total_before_tax_value += item_amount_before_tax;
    
    // }

	// return;
	//RETRIVE ALL DYNAMIC HTML VALUES
    //var tot_qty=$(".tot_qty").text();//
    //var tot_amt=$(".tot_amt").text();
    //var tot_disc=$(".tot_disc").text();
    //var tot_grand=$(".tot_grand").text();
	
    var tot_qty=$(".sales_div_tot_qty").attr('data-tot-qty');//sales_div_tot_qty
    var tot_amt=$(".sales_div_tot_amt").attr('data-tot-amt');
    var tot_disc=$(".sales_div_tot_discount").attr('data-tot-discount');
    var tot_grand=$(".sales_div_tot_payble").attr('data-tot-payble');
    var paid_amt=(pay_all) ? tot_grand : $(".sales_div_tot_paid").attr('data-paid-amount');
    var balance=(pay_all) ? 0 : parseFloat($(".sales_div_tot_balance").text());
    
    //paid_amt = paid_amt.replace(/\,/g,'');
    //paid_amt = parseInt(paid_amt,10);

   /* console.log("tot_grand="+tot_grand);
    console.log("balance="+balance);
    console.log("paid_amt="+paid_amt);
    return;*/
    /*if($("#customer_id").val().trim()==1 && balance!=0){
    	toastr["warning"]("Khách lẻ không cho ghi nợ, vui lòng thanh toán toàn bộ hóa đơn!!");
		return;
    }*/
    if(document.getElementById("sales_id")){
    	var command = 'update';
    }
    else{
    	var command = 'save';
    }
    var this_btn='make_sale';

	//swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			//  if(sure) {//confirmation start

		// Đặt flag đang xử lý
		isProcessing = true;
		$("#"+this_btn).attr('disabled',true);  //Enable Save or Update button
		
		// Chuẩn bị dữ liệu form - remove dấu phẩy trước khi submit
		prepareFormDataForSubmit();
		
		//e.preventDefault();
		var data = new Array(2);
		data= new FormData($('#pos-form')[0]);//form name
		/*Check XSS Code*/
		if(!xss_validation(data)){ 
			isProcessing = false; // Reset flag nếu có lỗi
			$("#"+this_btn).attr('disabled',false);
			return false; 
		}
		
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
			type: 'POST',
			//https://pos.sieuthithuysinh.com/pos/pos_save_update?command=save&tot_qty=2&tot_amt=186000&tot_disc=0&tot_grand=186000&paid_amt=0&balance=186&pay_all=false
			url: base_url+'pos/pos_save_update?command='+command+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&paid_amt="+paid_amt+'&balance='+balance+"&pay_all="+pay_all,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				//console.log(result);return;
				result=result.trim().split("<<<###>>>");
				console.log("result[0]"+result[0]);
				//return;

				console.log("result[0]="+result[0]);
				console.log("result[1]="+result[1]);
				console.log("result[2]="+result[2]);
				if(result[0]){
					
					if(result[0]=="success")
					{
						 // Gọi hàm lưu thông tin hóa đơn điện tử
						if (typeof einvoice_result !== 'undefined') {
							var sales_id_create = result[1];
							einvoice_result.invoice_info.sales_id = sales_id_create; // Cập nhật sales_id vào invoice_info
							save_info_data_einvoice(einvoice_result);
						}
						var print_done=true;
						if(print){
							//var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450");
							var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=0");
							
						}
						if(print_done){
						
							if(command=='update'){
								console.log("inside update");
								window.location=base_url+"sales";		
							}
							else{
								console.log("inside else");
								success.currentTime = 0;
								success.play();
								toastr['success']("Lập hóa đơn thành công!");
								
								//window.location=base_url+"pos";		
								$(".items_table > tbody").empty();
								$(".discount_input").val(0);
								
								$('#multiple-payments-modal').modal('hide');
								var rc=$("#payment_row_count").val();
								while(rc>1){
									remove_row(rc);
									rc--;
								}
								console.log('inside form');
								$("#pos-form")[0].reset();

								autoLoadFirstCustomer(1);

								//$("#customer_id").val(1).select2();

								final_total();

								get_details(null,true);

								//get_details();
								//hold_invoice_list();
								//window.location=base_url+"pos";

							}
							
						}
						
					}
					else if(result[0]=="failed")
					{
					   toastr['error']("Mã lỗi 11368. Vui lòng thử lại!!");
					}
					else
					{
						alert(result);
					}
				} // data.result end
				
				if(result[2]){
					$("#hold_invoice_list").html('').html(result[2]);
    				$(".hold_invoice_list_count").html('').html(result[3]);
				}
				
				

				$("."+this_btn).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
				
				// Restore format cho các input field
				restoreFormDataFormat();
				
				// Reset flag đang xử lý sau khi hoàn thành
				isProcessing = false;
				resetUIButton(); // Reset UI button
		   },
		   error: function(xhr, status, error) {
		   	    // Xử lý lỗi AJAX
		   	    toastr['error']("Có lỗi xảy ra: " + error);
		   	    $("."+this_btn).attr('disabled',false);
		   	    $(".overlay").remove();
		   	    
		   	    // Restore format cho các input field
		   	    restoreFormDataFormat();
		   	    
		   	    // Reset flag đang xử lý khi có lỗi
		   	    isProcessing = false;
		   	    resetUIButton(); // Reset UI button
		   }
	   });
	//} //confirmation sure
	//	}); //confirmation end

//e.preventDefault


//});
}//Save End

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

// Biến flag để ngăn chặn double-click cho hàm savetam
var isProcessingTam = false;

function savetam(print=false,pay_all=false,in_tam){

//$('.make_sale').on("click",function (e) {
	
	// Kiểm tra nếu đang xử lý thì không cho phép thực hiện lại
	if(isProcessingTam) {
		toastr["warning"]("Đang xử lý, vui lòng đợi...");
		return;
	}
	
	// Đặt flag đang xử lý
	isProcessingTam = true;
	
	var base_url=$("#base_url").val().trim();
    
    // Kiểm tra validation sản phẩm - sử dụng tr.itemrows để chính xác hơn
    var productCount = $("tr.itemrows").length;
    if(productCount == 0){
    	toastr["warning"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
		isProcessingTam = false; // Reset flag khi có lỗi
		return;
    }


	//RETRIVE ALL DYNAMIC HTML VALUES
    //var tot_qty=$(".tot_qty").text();//
    //var tot_amt=$(".tot_amt").text();
    //var tot_disc=$(".tot_disc").text();
    //var tot_grand=$(".tot_grand").text();
    
    var tot_qty=$(".sales_div_tot_qty").attr('data-tot-qty');//sales_div_tot_qty
    var tot_amt=$(".sales_div_tot_amt").attr('data-tot-amt');
    var tot_disc=$(".sales_div_tot_discount").attr('data-tot-discount');
    var tot_grand=$(".sales_div_tot_payble").attr('data-tot-payble');
    var paid_amt=(pay_all) ? tot_grand : $(".sales_div_tot_paid").attr('data-paid-amount');
    var balance=(pay_all) ? 0 : parseFloat($(".sales_div_tot_balance").text());
    
    //paid_amt = paid_amt.replace(/\,/g,'');
    //paid_amt = parseInt(paid_amt,10);

   /* console.log("tot_grand="+tot_grand);
    console.log("balance="+balance);
    console.log("paid_amt="+paid_amt);
    return;*/
    if($("#customer_id").val().trim()==1 && balance!=0){
    	toastr["warning"]("Khách lẻ không cho ghi nợ, vui lòng thanh toán toàn bộ hóa đơn!!");
		return;
    }
    if(document.getElementById("sales_id")){
    	var command = 'update';
    }
    else{
    	var command = 'save';
    }
    var this_btn='make_sale';

	//swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			//  if(sure) {//confirmation start

		
		$("#"+this_btn).attr('disabled',true);  //Enable Save or Update button
		//e.preventDefault();
		var data = new Array(2);
		data= new FormData($('#pos-form')[0]);//form name
		/*Check XSS Code*/
		if(!xss_validation(data)){ return false; }
		
		$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
		$.ajax({
			type: 'POST',
			//https://pos.sieuthithuysinh.com/pos/pos_save_update?command=save&tot_qty=2&tot_amt=186000&tot_disc=0&tot_grand=186000&paid_amt=0&balance=186&pay_all=false
			url: base_url+'pos/pos_save_update?command='+command+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&paid_amt="+paid_amt+'&balance='+balance+"&pay_all="+pay_all+"&in_tam="+in_tam,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				//console.log(result);return;
				result=result.trim().split("<<<###>>>");
				console.log("result[0]"+result[0]);
				//return;

				console.log("result[0]="+result[0]);
				console.log("result[1]="+result[1]);
				console.log("result[2]="+result[2]);
				if(result[0]){
					
					if(result[0]=="success")
					{
						var print_done=true;
						if(print){
							//var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=1,resizable=1,height=300,width=450");
							var print_done =window.open(base_url+"pos/print_invoice_pos/"+result[1], "_blank", "scrollbars=0");
							
						}
						if(print_done){
						
							if(command=='update'){
								console.log("inside update");
								window.location=base_url+"sales";		
							}
							else{
								console.log("inside else");
								success.currentTime = 0;
								success.play();
								toastr['success']("Lập hóa đơn thành công!");
								
								//window.location=base_url+"pos";		
								$(".items_table > tbody").empty();
								$(".discount_input").val(0);
								
								$('#multiple-payments-modal').modal('hide');
								var rc=$("#payment_row_count").val();
								while(rc>1){
									remove_row(rc);
									rc--;
								}
								console.log('inside form');
								$("#pos-form")[0].reset();

								autoLoadFirstCustomer(1);

								//$("#customer_id").val(1).select2();

								final_total();

								get_details(null,true);

								//get_details();
								//hold_invoice_list();
								//window.location=base_url+"pos";

							}
							
						}
						
					}
					else if(result[0]=="failed")
					{
					   toastr['error']("Mã lỗi 11368. Vui lòng thử lại!!");
					}
					else
					{
						alert(result);
					}
				} // data.result end
				
				if(result[2]){
					$("#hold_invoice_list").html('').html(result[2]);
    				$(".hold_invoice_list_count").html('').html(result[3]);
				}
				
				

				$("."+this_btn).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
				
				// Reset flag đang xử lý sau khi hoàn thành
				isProcessingTam = false;
		   },
		   error: function(xhr, status, error) {
		   	    // Xử lý lỗi AJAX
		   	    toastr['error']("Có lỗi xảy ra: " + error);
		   	    $("."+this_btn).attr('disabled',false);
		   	    $(".overlay").remove();
		   	    // Reset flag đang xử lý khi có lỗi
		   	    isProcessingTam = false;
		   }
	   });
	//} //confirmation sure
	//	}); //confirmation end

//e.preventDefault


//});
}//Save End




/* *********************** HOLD INVOICE START****************************/
$('#hold_invoice').on("click",function (e) {

	//table should not be empty
	var productCount = $("tr.itemrows").length;
	if(productCount == 0){
    	toastr["error"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    
    var $cus_option = $('#customer_id').find('option:selected');
                                var cus_value = $cus_option.val();//customer ID
                                var cus_text = $cus_option.text();//Customer Name
                                
                                //if (cus_text == 'Khách Lẻ'){
                                //    cus_text = '';
                                //} 

	swal({
		title: "Lưu ý - Đơn hàng có [Mã nhớ] trùng nhau sẽ thay thế nhau!",icon: "warning",buttons: true,dangerMode: true,
		content: {
			element: "input",attributes: 
			{
				placeholder: "Nhập vào [Mã nhớ] để phân biệt đơn giữ khác nhau!",
				type: "text",
				
				//id: "hold_name",
				//disabled: (cus_text == 'Khách Lẻ') ? "none" : "disabled",
				value:(cus_text == 'Khách Lẻ') ? "" : cus_text,
				inputAttributes: {
				    maxlength: '50'
				  }
			},},
		}).then(name => {
			//If input box blank Throw Error
			//if (!name.trim()){ throw null; return false; }
			
			
			if (cus_text == 'Khách Lẻ') {
			    if (!name.trim()){ throw null; return false; }
			    var reference_id = name;
			} else {
			    var reference_id = cus_text;
			}
			
			
			
			/* ********************************************************** */
			var base_url=$("#base_url").val().trim();
    
			//RETRIVE ALL DYNAMIC HTML VALUES
			var tot_qty=$(".sales_div_tot_qty").attr('data-tot-qty');//sales_div_tot_qty
            var tot_amt=$(".sales_div_tot_amt").attr('data-tot-amt');
            var tot_disc=$(".sales_div_tot_discount").attr('data-tot-discount');
            var tot_grand=$(".sales_div_tot_payble").attr('data-tot-payble');
            
            //var customer_name=$("#customer_id").
            
            //calculate_payments();
    
    
		    //var tot_qty=$(".tot_qty").text();
		    //var tot_amt=$(".tot_amt").text();
		    //var tot_disc=$(".tot_disc").text();
		    //var tot_grand=$(".tot_grand").text();
		    var hidden_rowcount=$("#hidden_rowcount").val();

		    var this_id=this.id;//id=save or id=update

				e.preventDefault();
				data = new FormData($('#pos-form')[0]);//form name
				/*Check XSS Code*/
				if(!xss_validation(data)){ return false; }
				
				$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
				$("#"+this_id).attr('disabled',true);  //Enable Save or Update button				
				$.ajax({
					type: 'POST',
					url: base_url+'pos/hold_invoice?command='+this_id+'&tot_qty='+tot_qty+'&tot_amt='+tot_amt+'&tot_disc='+tot_disc+'&tot_grand='+tot_grand+"&reference_id="+reference_id,
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(result){
						//alert(result);return;
						$("#hidden_invoice_id").val('');
						result=result.trim().split("<<<###>>>");
						
							if(result[0]=="success")
							{
								$('#pos-form-tbody').html('');
								//CALCULATE FINAL TOTAL AND OTHER OPERATIONS

								hold_invoice_list();
								success.currentTime = 0;
								success.play();
								$("#other_charges").val('');
		    					final_total();
							}
							else if(result[0]=="failed")
							{
							   toastr['error']("Mã lỗi 240788. Vui lòng thử lại!!");
							}
							else
							{
								alert(result);
							}
						
						$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
						$(".overlay").remove();
				   }
			   });
			/* ********************************************************** */

		}) //name end
	.catch(err => {
	    toastr['error']("Mã lỗi 380900! <br/>Vui lòng nhập mã nhớ");
	    failed.currentTime = 0;
		failed.play();
	});//swal end

}); //hold_invoice end

function hold_invoice_list(){
	var base_url=$("#base_url").val().trim();
  $.post(base_url+"pos/hold_invoice_list",{},function(result){
  	//alert(result);
  	var data = jQuery.parseJSON(result)
    $("#hold_invoice_list").html('').html(data['result']);
    $(".hold_invoice_list_count").html('').html(data['tot_count']);
  });
}
function hold_invoice_delete(invoice_id){
	swal({ title: "Xác nhận?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
			  if(sure) {//confirmation start
	var base_url=$("#base_url").val().trim();
  $.post(base_url+"pos/hold_invoice_delete/"+invoice_id,{},function(result){
  	result=result.trim();
    if(result=='success'){
    	toastr["success"]("Đã xóa thành công!!");
	    success.currentTime = 0;
		success.play();
	    hold_invoice_list();
    }
    else{
    	toastr['error']("Mã lỗi 140289. Vui lòng thử lại!!");
    	failed.currentTime = 0;
		failed.play();
    }
  });
  } //confirmation sure
		}); //confirmation end
}

function hold_invoice_edit(id){

	swal({ title: "Xác nhận mở đơn treo?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
	if(sure) {//confirmation start
	var base_url=$("#base_url").val().trim();

	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
	$.post(base_url+"pos/hold_invoice_edit",{hold_id:id},function(result){

    		//console.log(result);

      result=result.split("<<<###>>>");
      $('#pos-form-tbody').html('').append(result[0]);
      $('#discount_input').val(result[1]);
      $('#discount_type').val(result[2]);

      autoLoadFirstCustomer(result[3]);
      //$('#customer_id').val(result[3]).select2();
      
      $("#other_charges").val(result[4]);
      $("#hidden_invoice_id").val(result[5]);
      $("#hidden_rowcount").val(parseInt($(".items_table tr").length)-1);
      //$(".sales_div_tot_qty").html(Intl.NumberFormat().format(result[6]));
      //$(".sales_div_tot_qty").attr('data-tot-qty', result[6]);
      
      calculate_payments();
      //adjust_payments();
      //adjust_payments2();
      final_total();
      get_details(null,true);
      $(".overlay").remove();
      
    	});

				
		} //confirmation sure
	}); //confirmation end
}
/* *********************** HOLD INVOICE END****************************/
/* *********************** ORDER INVOICE START****************************/
function get_id_value(id){
	return $("#"+id).val().trim();
}
$('#collect_customer_info').on("click",function (e) {
	
	//table should not be empty
	var productCount = $("tr.itemrows").length;
	if(productCount == 0){
    	toastr["error"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    if(get_id_value('customer_id')==1){
    	//$('#customer-modal').modal('toggle');
    	toastr["error"]("Chưa có khách hàng!!");
    	failed.currentTime = 0;
		failed.play();
    	return false;
    }
    else{
    	$('#delivery-info').modal('toggle');
    }
}); //hold_invoice end
$('.show_payments_modal').on("click",function (e) {
	
	//table should not be empty
	var productCount = $("tr.itemrows").length;
	if(productCount == 0){
    	toastr["error"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    else{
    	adjust_payments();
    	$("#add_payment_row,#payment_type_1").parent().show();
    	$("#amount_1").parent().parent().removeClass('col-md-12').addClass('col-md-6');
    	$('#multiple-payments-modal').modal('toggle');
    }
}); //hold_invoice end
$('#show_cash_modal').on("click",function (e) {
	//table should not be empty
	var productCount = $("tr.itemrows").length;
	if(productCount == 0){
    	toastr["error"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    else{
    	adjust_payments();
    	$("#add_payment_row,#payment_type_1").parent().hide();
    	$("#amount_1").focus();
    	$("#amount_1").parent().parent().removeClass('col-md-6').addClass('col-md-12');
    	$('#multiple-payments-modal').modal('toggle');
    }
}); //hold_invoice end

$('#add_payment_row').on("click",function (e) {
	
	var base_url=$("#base_url").val().trim();
	//table should not be empty
	var productCount = $("tr.itemrows").length;
	if(productCount == 0){
    	toastr["error"]("Vui lòng thêm ít nhất một sản phẩm vào đơn hàng!");
    	failed.currentTime = 0;
		failed.play();
		return;
    }
    /*if(get_id_value('customer_id')==1){
    	//$('#customer-modal').modal('toggle');
    	toastr["error"]("Please Select Customer!!");
    	failed.currentTime = 0;
failed.play();
    	return false;
    }*/
    else{
    	/*BUTTON LOAD AND DISABLE START*/
    	var this_id=this.id;
    	var this_val=$(this).html();
    	$("#"+this_id).html('<i class="fa fa-spinner fa-spin"></i> Vui lòng chờ xíu ..');
    	$("#"+this_id).attr('disabled',true);  
    	/*BUTTON LOAD AND DISABLE END*/

    	var payment_row_count=get_id_value("payment_row_count");
    	$.post(base_url+"pos/add_payment_row",{payment_row_count:payment_row_count},function(result){
    		$('.payments_div').parent().append(result);
    		
    		$("#payment_row_count").val(parseFloat(payment_row_count)+1);

    		/*BUTTON LOAD AND DISABLE START*/
    		$("#"+this_id).html(this_val);
    		$("#"+this_id).attr('disabled',false); 
    		/*BUTTON LOAD AND DISABLE END*/    	
    		failed.currentTime = 0;
			failed.play();
    		adjust_payments();
    	});
    }
}); //hold_invoice end
function remove_row(id){
	$(".payments_div_"+id).html('');
	failed.currentTime = 0;
	failed.play();
	adjust_payments();
}
function calculate_payments(){
	adjust_payments();
}



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
    
    // for (var i = 0; i < rowcount; i++) {   
    //     var item_name = $("#td_data_" + i + "_0").text().trim();
    //     var item_quantity = parseFloat($("#item_qty_" + i + "_1").val().trim()) || 0;
    //     var item_price = parseFloat($("#sales_price_" + i).val().trim().replace(/,/g, '') || 0);
    //     var item_discount_item = parseFloat($("#item_discount_" + i).val().trim()) || 0;
    //     var item_tax_percent = parseFloat($("#tr_tax_value_" + i).val().trim()) || 0;
    //     var item_tax_amount = parseFloat($("#td_data_" + i + "_4").val().trim()) || 0;
    //     var item_amount = parseFloat($("#td_data_" + i + "_5").val().trim().replace(/,/g, '') || 0);
    //    	console.log('Sản phẩm ' + i + ': ' + item_name);
    //     console.log('  - Số lượng:', item_quantity);
    //     console.log('  - Đơn giá:', item_price);
    //     console.log('  - Giảm giá sản phẩm:', item_discount_item);
    //     console.log('  - Thuế:', item_tax_percent);
    //     console.log('  - Tiền thuế:', item_tax_amount);
    //     console.log('  - Tổng tiền:', item_amount);

    //     // Tính tiền trước thuế ban đầu (sau giảm giá sản phẩm)
    //     var item_amount_before_tax = (item_quantity * item_price) - item_discount_item;
    //     total_before_tax_value += item_amount_before_tax;
        
    //     items_data.push({
    //         index: i,
    //         item_name: item_name,
    //         item_quantity: item_quantity,
    //         item_price: item_price,
    //         item_discount_item: item_discount_item,
    //         item_tax_percent: item_tax_percent,
    //         item_tax_amount: item_tax_amount,
    //         item_amount: item_amount,
    //         item_amount_before_tax: item_amount_before_tax
    //     });
    // }

    // Tìm các tr có class itemrows trong bảng có id là print_area
    var itemRows = $('#print_area .itemrows');
    // Lặp qua từng dòng để lấy dữ liệu
    itemRows.each(function() {
        var row = $(this);
        // Lấy giá trị của thuộc tính "data-item-id" trong thẻ tr
        var itemId = row.attr('data-item-id');
        // Nếu itemID = -1 thì lấy value trong thẻ td đầu tiên
        // Nếu itemID != -1 thì lấy value trong thẻ span thứ hai trong thẻ td đầu tiên
        let itemName = '';
        if(itemId == -1) {
            itemName = row.find('td:first').text();
        } else {
            itemName = row.find('td:first span:nth-child(2)').text();
        }
        // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ hai làm số lượng
        let itemQuantity = row.find('td:nth-child(2) input').val();
        // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ ba làm đơn giá
        let itemPrice = row.find('td:nth-child(3) input').val();
        // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ tư làm chiết khấu
        let itemDiscount = row.find('td:nth-child(4) input').val();
        // Lấy giá trị của thuộc tính "data-raw-value" trong thẻ input đầu tiên trong thẻ td thứ sáu làm thành tiền
        // Input trên dom <input data-toggle="tooltip" title="Total" id="td_data_0_5" name="td_data_0_5" type="text" class="form-control no-padding pointer" readonly="" value="50,000" data-raw-value="55000">
        let itemTotal = row.find('td:nth-child(6) input').attr('data-raw-value');
        // let itemTotal = row.find('td:nth-child(5) input').attr('data-raw-value') || row.find('td:nth-child(5) input').val();
        // Lấy thẻ input thứ 5 trong tr(row) làm phần trăm thuế
        let itemTaxPercent = row.find('input:nth-child(12)').val();
        // Lấy giá trị của thẻ input đầu tiên trong thẻ td thứ năm làm thuế
        let itemTaxAmount = row.find('td:nth-child(5) input').val();


        // console.log('📦 SALES: ID sản phẩm:', itemId);
        // console.log('📦 SALES: Tên sản phẩm:', itemName);
        // console.log('📦 SALES: Số lượng sản phẩm:', itemQuantity);
        // console.log('📦 SALES: Giá sản phẩm:', removeCommasAndDots(itemPrice));
        // console.log('📦 SALES: Chiết khấu sản phẩm:', removeCommasAndDots(itemDiscount));
        // console.log('📦 SALES: Thành tiền sản phẩm:', removeCommasAndDots(itemTotal));
        // console.log('📦 SALES: Phần trăm thuế sản phẩm:', removeCommasAndDots(itemTaxPercent));
        // console.log('📦 SALES: Số tiền thuế sản phẩm:', removeCommasAndDots(itemTaxAmount));

        var item_name = removeCommasAndDots(itemName);
        var item_quantity = removeCommasAndDots(itemQuantity);
        var item_price = removeCommasAndDots(itemPrice);
        var item_discount_item = removeCommasAndDots(itemDiscount);
        var item_tax_percent = removeCommasAndDots(itemTaxPercent);
        var item_tax_amount = removeCommasAndDots(itemTaxAmount);
        var item_amount = removeCommasAndDots(itemTotal);

        //let itemTaxPercent = row.find('td:nth-child(5) input').val();
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
    });


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
        var rowcount = $("tr.itemrows").length;

        // Lấy thông tin từ giao diện
        ui_data = getItemsDataFromUI(rowcount);
        invoice_discount_amount = parseFloat($(".sales_div_tot_discount").text().trim()) || 0;
        invoice_service_amount = parseFloat($("#other_charges_amt").text().trim()) || 0;
        invoice_amount = parseFloat($(".sales_div_tot_payble").text().trim().replace('đ', '').replace('.', '').replace(',', '')) || 0;
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
