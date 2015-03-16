$(window).on('resize load', function() {
$('body').css({"padding-top": $(".navbar").height() + "px"});
});

$(document).ready(function(){
	
	var rootDirectory = 'cantorix';
	var windoheight = $(window).height();
	var headeheightr = $('div.navbar').height();
	var footerheigh = $('div#footer').height();
	
	var middleheight = $('div.full_container').height();
	
	var minusedhei = parseInt(windoheight) - parseInt(headeheightr) - parseInt(footerheigh) ;
	
	
	
	if(middleheight < minusedhei)
	{
		//alert("ddd");
		$('div#footer').css("position","absolute");
		
	}
	
	//start of sign up validations
	$("#organizationForm").validate({
		rules: {
			'data[organizationForm][organization_name]': "required",
			'data[organizationForm][email_address]': {
				required: true,
				email: true,
				checkEmailAvailability: true			
			},
			'data[organizationForm][time_zone]': "required"
		},
		messages: {
			'data[organizationForm][organization_name]': "Please Enter Company Name",
			'data[organizationForm][email_address]': {
				required: "Please Enter Email Address",
				email: "Please Enter Valid Email Address",
				checkEmailAvailability:"Email Address Already Exist"				
			},
			'data[organizationForm][time_zone]': "Please Select Time Zone"
		}
	});	
	
	$("#subscriberForm").validate({
		rules: {
			'data[subscriberForm][name]': "required",
			'data[subscriberForm][surname]': "required",
			'data[subscriberForm][username]': {				
				checkUsernameAvailability: true			
			},			
			'data[subscriberForm][tc]': "required",
			'data[subscriberForm][policy]': "required"
			
		},
		messages: {
			'data[subscriberForm][name]': "Please Enter Name",
			'data[subscriberForm][surname]': "Please Enter Surname",
			'data[subscriberForm][username]': {				
				checkUsernameAvailability:"Username Already Exist"			
			},
			'data[subscriberForm][tc]': "Please Accept Terms & Conditions",
			'data[subscriberForm][policy]': "Please Accept Policy Information"
		},
		errorPlacement: function(error, element) {
    		$(element).closest('label.block').find('.error-placement').html(error); 
    	}
	});	
	
	$("#paymentForm").validate({
		rules: {			
			"data[paymentForm][cc_fname]": {
				required: true,
				alphabetOnly:true
			},
			"data[paymentForm][cc_lname]": {
				required: true,
				alphabetOnly:true
			},
			"data[paymentForm][cc_number]": {
				required: true,												
				creditcard: true,
				verifyCCCard:true
			},  
			"data[paymentForm][cc_exp_year]": "required",
			"data[paymentForm][cc_exp_month]": {
				required:true,
				verifyCCMonYear:true
			},
			"data[paymentForm][cc_cvv]": {
				required: true,
				digits: true,
				rangelength: [3, 4]
			},
			"data[paymentForm][billing_address_line1]": "required",
			"data[paymentForm][billing_city]": "required",
			"data[paymentForm][billing_state]": "required",
			"data[paymentForm][billing_country]": "required",
			"data[paymentForm][billing_zip]": {
				required: true,
				digits: true,
				rangelength: [3, 7]
			}
			
		},
		messages: {			
			"data[paymentForm][cc_fname]": {
				required: "Enter First Name",								
				alphabetOnly:"Please Enter Only Alphabets"				
			},
			"data[paymentForm][cc_lname]": {
				required: "Enter Last Name",								
				alphabetOnly:"Please Enter Only Alphabets"			
			},
			"data[paymentForm][cc_number]": {
				required: "Please Enter Credit Card Number",								
				creditcard: "Please Enter valid Credit Card Number",
				verifyCCCard: "Please Enter valid Credit Card Number"				
			},
			"data[paymentForm][cc_exp_month]": {
				required:"Please Select Expiry Month",
				verifyCCMonYear:"Invalid Expiration Date"
			},
			"data[paymentForm][cc_exp_year]": "Please Select Expiry Year",
			"data[paymentForm][cc_cvv]": {
				required: "Please Enter CVV code",
				digits: "Enter Numeric value only",
				rangelength:"Invalid CVV Code"
				
			},
			"data[paymentForm][billing_address_line1]": "Please Enter Address",
			"data[paymentForm][billing_city]": "Please Enter City",
			"data[paymentForm][billing_state]": "Please Enter State",
			"data[paymentForm][billing_country]": "Please select the Country",
			"data[paymentForm][billing_zip]": {
				required: "Please Enter Zip/Postal Code"								
			}
		}
	});
	
	// custom validation for signup	
	$.validator.addMethod("checkEmailAvailability",function(value,element){				
	 var x= $.ajax({
	    url: "/"+rootDirectory+"/users/isEmailExist",
	    type: 'GET',
	    async: false,
	    data: "emailaddress=" + value + "&checking=true",
	 }).responseText;	 	
	 if(x=="true") return false;
	 else return true;
	},"Sorry, this email is not available");	
	
	$.validator.addMethod("checkUsernameAvailability",function(value,element){		
	 var x= $.ajax({
	    url: "/"+rootDirectory+"/users/isUsernameExist",
	    type: 'GET',
	    async: false,
	    data: "username=" + value + "&checking=true",
	 }).responseText;	 	
	 if(x=="true") return false;
	 else return true;
	},"Sorry, this username is not available");
	
	$.validator.addMethod("alphabetOnly", 
          function(value, element) {
            return/^[A-Z]*$/i.test(value);                            
          }, 
          "Alphabets Characters Only.");
          
    $.validator.addMethod("verifyCCCard",function(value,element){		
	 var x= $.ajax({
	    url: "/"+rootDirectory+"/users/verifyCard",
	    type: 'GET',
	    async: false,
	    data: "cc_number=" + value + "&checking=true",
	 }).responseText;	
	 if(x=="true") return false;
	 else return true;
	},"Invalid");
	
	$.validator.addMethod("verifyCCMonYear",function(value,element){		
	 var cc_year =  $('#expYear').val();	
	 var x= $.ajax({
	    url: "/"+rootDirectory+"/users/monthYear",
	    type: 'GET',
	    async: false,
	    data: "cc_year=" + cc_year + "&cc_month=" + value + "&checking=true",
	 }).responseText;	
	 if(x=="true") return false;
	 else return true;
	},"Invalid");      
	
	//card hint
	$('.hint img').hover(function(){
		$('.hint .card-show').toggle();
	});
	
	// end of sign up validations
	
}); //end of document ready


	

			
