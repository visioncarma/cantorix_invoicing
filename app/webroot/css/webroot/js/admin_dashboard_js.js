/*Script for only Admin Dashboard*/	
$(document).ready(function(){
	
  // Tooltip for action button	
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
	
	//Selected checkbox row to highlight for table
	$('th .ace').change(function(){
		 //if($(this).prop('checked')==false){
    		$(this).parents('.table').find('tr').removeClass('highlighted');
    	//}
	});
	$('td .ace').change(function(){
    	 if($(this).prop('checked')==true)
    	 {
    	 	$(this).parents('tr').addClass('highlighted');
    	    if($(this).parents('table').hasClass('role'))
    	    {	
    		     $(this).parents('tr').removeClass('highlighted');
    		}
    	 }
    	 else
    	    $(this).parents('tr').removeClass('highlighted');
    });
	
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
		$('.mange_group_tax_p .icon-double-angle-right').hide();
	});
	$('body').on('click', '.editable-table .save-row', function(){
		
		$(this).parents('tr').find('.on-edit').hide();
		$(this).parents('tr').find('.on-load').fadeIn();
		$(this).parents('tr').removeClass('highlighted');
		$('.mange_group_tax_p .icon-double-angle-right').hide();
				
	});
	
	//Edit row for table responsive
	$('body').on('click', '.table-small-view .edit-row', function(){
	
		$(this).parents('.contentrow').find('.on-load').hide();
		$(this).parents('.contentrow').find('.on-edit').fadeIn();
		//$(this).parents('tr').addClass('highlighted');
		//$('.mange_group_tax_p .icon-double-angle-right').hide();
	});
	$('body').on('click', '.table-small-view .save-row', function(){
		$(this).parents('.contentrow').find('.on-load').fadeIn();
		$(this).parents('.contentrow').find('.on-edit').hide();
		//$(this).parents('tr').removeClass('highlighted');
		//$('.mange_group_tax_p .icon-double-angle-right').hide();
				
	});
	
	$('body').on('click', '.submit', function(){
		$(this).parents('tr').removeClass('highlighted');
	});
	//Delete row for Table
	$('body').on('click','.delete-row', function(){
		$(this).parents('tr').fadeOut(400, function(){
			$(this).remove();
		});
	});
	
	$('.popup-cancel').click(function(){
	  $('.close').trigger('click');
	});


// for fixing footer

	var windoheight = $(window).height();
	var headeheightr = $('div.navbar').height();
	var footerheigh = $('div#footer').height();	
	var middleheight = $('div.full_container').height();
	var minusedhei = parseInt(windoheight) - parseInt(headeheightr) - parseInt(footerheigh) ;
	if(middleheight < minusedhei)
	{
		$('div#footer').css("position","absolute");
	}
    $('input, textarea').placeholder();
    
    /*for fixing help button popover*/
    var winwidth = $(window).width();
    if(winwidth <= 767){
    	$('.help-button').attr('data-placement','left');
    	$('.help-button.customer-help-button').attr('data-placement','right');    	
    }
				
});//End of document ready


