<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header page-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				<i class="icon-remove"></i>
			</button>
			<h1 class="modal-title" id="myModalLabel">View Expense Category</h1>
		</div>
		<div class="form-horizontal popup">
			<div class="modal-body">
				<div class="model-body-inner-content">
					<div class="form-group login-form-group">
						<label class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-top"> Category Name </label>
						<div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
							<p class="bold">
								<?php echo $category['AcpExpenseCategory']['category_name']; ?>
							</p>
						</div>
					</div>
					<div class="form-group login-form-group">
						<label class="col-lg-4 col-md-4 col-sm-6 col-xs-6 no-padding-top"> Description </label>
						<div class="col-lg-8 col-md-8 col-sm-6 col-xs-6">
							<p class="bold">
								<?php echo $category['AcpExpenseCategory']['description']; ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>