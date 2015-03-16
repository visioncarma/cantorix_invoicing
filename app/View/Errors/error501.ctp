<?php $this->layout = 'error';?>
<div class="widget-main">
	<div class="parenterror">
	<div class="error404">501</div>
    	<div class="pagefound">Method Not Implemented</div>             
	</div>
	<div class="checkurl">
		The requested url on the server is not found.
	</div>
	<div class="margintop20 ">
		 <?php echo $this->Html->link('<i class="icon-arrow-left"></i>Go Back',$this->request->referer(),array('class'=>'btn btn-grey newbtn','escape'=>FALSE));?>
		<?php echo $this->Html->link('<i class="icon-dashboard"></i>Home',array('controller'=>'users','action'=>'login'),array('class'=>'btn btn-primary newbtn','escape'=>FALSE));?>
	</div>
</div>