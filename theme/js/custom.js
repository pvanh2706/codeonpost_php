/*Check XSS Code*/
function xss_validation(data) {
	if(typeof data=='object'){
		for (var value of data.values()) {
		   if(typeof value!='object' && (value.trim()!='' && value.indexOf("<script>") != -1)){
		   	toastr["error"]("Failed!! to Continue! XSS Code found as Input!");
		   	return false;
		   }
		}
		return true;
	}
	else{
		if(typeof value!='object' && (data.trim()!='' && data.indexOf("<script>") != -1)){
		   	toastr["error"]("Failed!! to Continue! XSS Code found as Input!");
		   	return false;
		}
		return true;
	}
}
//end
function calculate_inclusive(amount,tax){
	amount = parseFloat(amount);
	tax = parseFloat(tax);
 	return (amount * tax / (100+ tax)).toFixed(0);//By tally
}
function calculate_exclusive(amount,tax){
	amount = parseFloat(amount);
	tax = parseFloat(tax);
	return ((amount*tax)/parseFloat(100)).toFixed(0);
}
function app_number_format(num=0, currency='VND'){
	// Format as currency with proper locale
	if(currency === 'VND') {
		return new Intl.NumberFormat('vi-VN', {
			style: 'currency',
			currency: 'VND',
			minimumFractionDigits: 0,
			maximumFractionDigits: 0
		}).format(num);
	}
	
	// Default currency formatting
	return new Intl.NumberFormat('en-US', {
		style: 'currency',
		currency: 'USD',
		minimumFractionDigits: 2,
		maximumFractionDigits: 2
	}).format(num);
}
function get_float_type_data(location=''){
  var res = $(location).val();
  return (isNaN(parseFloat(res))) ? parseFloat(0) : parseFloat(res);
 }