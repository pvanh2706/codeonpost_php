
/*Email validation code end*/
$('#sendemail').on("click",function (e) {
	var base_url=$("#base_url").val().trim();
    /*Initially flag set true*/
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             $('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


    //Validate Input box or selection box should not be blank or empty
	check_field("mobile");
	check_field("subject");
	check_field("message");
	

    
	if(flag==false)
    {
		toastr["warning"]("Nội dung yêu cầu không đủ!")
		return;
    }

    var this_id=this.id;

    

			swal({ title: "Xác nhận gửi mail này?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
	            if(sure) {//confirmation start
    				$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    				//$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
    				e.preventDefault();
    				data = new FormData($('#email-form')[0]);//form name
    				$.ajax({
    				type: 'POST',
    				url: base_url+'email/send_email',
    				data: data,
    				cache: false,
    				contentType: false,
    				processData: false,
    				success: function(result){
     // alert(result);//return;
     			result=result.trim();
					if(result=="success")
					{
						toastr["success"]("Đã gửi Email!");
						$("#mobile,#message").val('');
						//return;
					}
					else if(result=="failed")
					{
					   toastr["error"]("Email chưa được gửi! Vui lòng thử lại");
					}
					else
					{
						toastr["error"](result);
					}
					//$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
					$(".overlay").remove();
			   }
			   });
		} //confirmation sure
	}); //confirmation end


   

});


//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}
