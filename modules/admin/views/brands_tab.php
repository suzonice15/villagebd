<div class="box">
	<div class="box-body">
		<form method="POST" enctype="multipart/form-data">
			<div class="box-body">								
				<div class="form-group <?=form_error('brands_tab') ? 'has-error' : ''?>">
					<textarea class="form-control" rows="20" name="brands_tab"><?=get_option('brands_tab')?></textarea>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>