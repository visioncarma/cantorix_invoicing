<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
			$protocol_final = 'https';
		} else {
		  	$protocol_final = 'http';
		} ?>
		
(function($) {
  $('#autocomplete').autocomplete({
       source : "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>expenses/add1.json"
  });
})(jQuery);