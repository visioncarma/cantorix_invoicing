<?php $this->layout = 'error';?>
<div class="widget-main">
	<div class="parenterror">
	<div class="error404">405</div>
    	<div class="pagefound">Method Not Allowed</div>             
	</div>
	<div class="checkurl">
		HTTP method GET is not supported by this url.
	</div>
	<div class="margintop20 ">
		 <?php echo $this->Html->link('<i class="icon-arrow-left"></i>Go Back',$this->request->referer(),array('class'=>'btn btn-grey newbtn','escape'=>FALSE));?>
		<?php echo $this->Html->link('<i class="icon-dashboard"></i>Home',array('controller'=>'users','action'=>'login'),array('class'=>'btn btn-primary newbtn','escape'=>FALSE));?>
	</div>
</div>