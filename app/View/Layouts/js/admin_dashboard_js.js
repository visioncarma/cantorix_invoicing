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
	$('body').on('click', '.editable-table .save-row', function(){
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
				
});//End of document ready



$(document).ready(function(){
	
	var windoheight = $(window).height();
	var headeheightr = $('div.navbar').height();
	var footerheigh = $('div#footer').height();
	

	
	var middleheight = $('div.full_container').height();
	
	var minusedhei = parseInt(windoheight) - parseInt(headeheightr) - parseInt(footerheigh) ;
	
	
	
	if(middleheight < minusedhei)
	{
		$('div#footer').css("position","absolute");
		
	}
	
	//credit card hint
	$('.hint img').hover(function(){
		$('.hint .card-show').toggle();
	});		
});

$(document).ready(function(){
	$('.select-dropdown>ul a').on('click', function(){    
		$('.btn-select').html($(this).html() + '<span class="caret"></span>');    
	});
	
	$('#exampleInputFile').change(function() {
		var inputvalue = $(this).val().split('\\').pop();
		$('.current_file_size').text(inputvalue);
	});
	$('.close-it, .btn-rmv').click(function(){
		$(".display-thumbnail").hide();
		$('#exampleInputFile').empty(); 
	});
	
	$('.display-thumbnail input[type=file]').removableFileUpload();
});

$(document).ready(function(){
	Plugins.AutosizeInput.getDefaultOptions().space = 5;
    $(".resizeit").autosizeInput();
});

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img_prev').attr('src', e.target.result);
				$('.display-thumbnail').show();
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#exampleInputFile").change(function(){
        readURL(this);
		
    });

	$('#exampleInputFile').bind('change', function() {

  //this.files[0].size gets the size of your file.
  //alert(this.files[0].size);
	
});

$(document).ready(function(){
$('#aging_buckets').on('change', function() {
    if (this.value != '') {
        var val = parseInt(this.value, 10);
        for (var i = 0; i < val; i++) {
						
        }
    }
});
});
