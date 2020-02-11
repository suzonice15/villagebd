<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body">
				<form method="POST">
					<button type="submit" name="regenerate" class="btn btn-primary">Regenerate Now</button>
				</form>
				
				<?php
				if($regenerate && $regenerate=='yes')
				{
					?><img src="<?=base_url('images/loading.gif')?>" style="position:absolute;left:140px;top:9px;"><?php
				}
				?>
			</div>
		</div>
	</div>
</div>