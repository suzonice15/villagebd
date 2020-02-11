<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST" action="<?=base_url('admin/warrantypolicy')?>" enctype="multipart/form-data">
					<div class="box-body">								
						<div class="form-group <?=form_error('warrantypolicy') ? 'has-error' : ''?>">
							<textarea class="form-control" rows="20" name="warrantypolicy"><?=get_option('warrantypolicy')?></textarea>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>