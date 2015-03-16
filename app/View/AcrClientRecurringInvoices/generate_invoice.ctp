<?php
	if($saveInvoice){
		echo '<div class="alert alert-block alert-success">A new invoice# '.$invoiceNumber.' is generated for this recurrence.</div>';
	}else{
		echo '<div class="alert alert-danger">Sorry! Invoice could not be created.</div>';
	} 
	
?>