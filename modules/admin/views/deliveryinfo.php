<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">								
				<div class="form-group <?=form_error('deliveryinfo') ? 'has-error' : ''?>">
					<textarea class="form-control" rows="20" name="deliveryinfo"><?=get_option('deliveryinfo')?></textarea>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>