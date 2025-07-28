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

function save(print=false,pay_all=false){

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
				isProcessing = false;
				resetUIButton(); // Reset UI button
		   },
		   error: function(xhr, status, error) {
		   	    // Xử lý lỗi AJAX
		   	    toastr['error']("Có lỗi xảy ra: " + error);
		   	    $("."+this_btn).attr('disabled',false);
		   	    $(".overlay").remove();
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
