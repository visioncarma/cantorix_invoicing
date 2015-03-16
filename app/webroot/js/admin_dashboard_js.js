/*Script for only Admin Dashboard*/
$(document).ready(function(){
	$( document.body).on( 'click', '.dropdown-toggle', function(event) {
		var disabledvalue = $(".text:contains('|--')").addClass( "disabledclass");
		$(disabledvalue).click(function(event) {
			return false;
		});
	});

	
	$(document).keyup(function(event) {
		if(event.which === 27) {
	        $('.email_body_items').hide();
	        $('.email_body_items2').hide();
	    }
	});

	$(".selectpicker").change(function() {
		$(this).parent().find('span').addClass('imactive');
	});	

	$('#email_body_item_field').click(function(){
		$('#email_body_items').show(function(){
			document.body.addEventListener('click', boxCloser, false);
	});

	function boxCloser(e){
		if(e.target.id != 'email_body_items'){
			document.body.removeEventListener('click', boxCloser, false);
			$('#email_body_items').hide();
		}
	}
	});
	
	$('#email_body_item_field2').click(function(){
	$('#email_body_items2').show(function(){
		document.body.addEventListener('click', boxCloser, false);
	});
	
	function boxCloser(e){
		if(e.target.id != 'email_body_items2'){
			document.body.removeEventListener('click', boxCloser, false);
			$('#email_body_items2').hide();
			}
		}
	});

	$('.tags_select1 a').click(function() {
	    var value = $(this).text();
	    var input = $('#email_body');
	    input.val(input.val() +'[' + value + '] ');
	    input.focus();
	    return false;
	});

	$('.tags_select2 a').click(function() {
	    var value = $(this).text();
	    var input = $('#email_body');
	    input.val(input.val() +'[' + value + '] ');
	    input.focus();
	    return false;
	});


	$('.tags_select3 a').click(function() {
	    var value = $(this).text();
	    var input = $('#email_subject');
	    input.val(input.val() +'[' + value + '] ');
	    input.focus();
	    return false;
	});

	$('.tags_select4 a').click(function() {
	    var value = $(this).text();
	    var input = $('#email_subject');
	    input.val(input.val() +'[' + value + '] ');
	    input.focus();
	    return false;
	});

	$('.close_it2').click(function () {
		$('.email_body_items2').hide();

	});
	$('.close_it').click(function () {
		$('.email_body_items').hide();
	});

  // Tooltip for action button
  function isTouchDevice(){
    return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
  }
  if(isTouchDevice()===false)
  {
   $( ".edit" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".delete" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".view" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".close-action" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".submit" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".invoice" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	}
	$('[data-rel=popover]').popover({container:'body'});
	//Select all for checkbox for table
	$('table th input:checkbox').on('click' , function(){
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
			
	});
	//Edit row for table
	$('body').on('click', '.editable-table .edit-row', function(){
		$(this).parents('tr').find('.on-load').hide();
		$(this).parents('tr').find('.on-edit').fadeIn();
		$(this).parents('tr').addClass('highlighted');
	});
	
	$('body').on('click', '.close-action', function(){
		var cval = $(this).parents('.highlighted2').find('.cname-edit').attr('value');
		$(this).parents('.highlighted2').find('.cname-load').text(cval);
		
		var cval2 = $(this).parents('.highlighted2').find('.ccode-edit').attr('value');
		$(this).parents('.highlighted2').find('.ccode-load').text(cval2);
		
		$(this).parents('tr').removeClass('highlighted2');	
		
		//$('.cname-load').text(cval);
		//alert(cval);
		
		$(this).parents('tr').find('.on-edit').hide();
		$(this).parents('tr').find('.on-load').fadeIn();
		$(this).parents('tr').removeClass('highlighted');		
	});
	
	//Delete row for Table
	$('body').on('click','.delete-row', function(){
		$(this).parents('tr').fadeOut(400, function(){
			$(this).remove();
		});
	});
	
	$(document).ajaxSuccess(function(){
	 	$('table th input:checkbox').on('click' , function(){
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
		
			
	});
	 	
	});
});//End of document ready

$(document).ready(function(){
	//credit card hint
	$('.hint img').hover(function(){
		$('.hint .card-show').toggle();
	});	
});
// for fixing footer

$(window).load(function(){
	var windowHeight = $(window).outerHeight();
	var headerHeight = $('div.navbar').outerHeight();
	var footerHeight = $('div#footer').outerHeight();
	var middleHeight = $('div.full_container').outerHeight();
	$('div.full_container').css("min-height",middleHeight);
	$('div.full_container').css("padding-bottom",70);
	var minimumUsedHeight = parseInt(windowHeight) - parseInt(headerHeight) - parseInt(footerHeight) ;
	if(middleHeight < minimumUsedHeight)
	{
		$('div#footer').css("position","absolute");
		$('div#footer').css("bottom",0);
	}
});