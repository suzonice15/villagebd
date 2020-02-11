<section id="mpart" class="servicearchive">
	<div class="container">
		<?=get_breadcrumb(null, null, 'service')?>
		
		<div class="row mt40">
			<div class="col-md-12 maincnt">
				<?php
				if(!empty($services))
				{
					$html = '<div class="row service">';
							
					foreach($services as $service)
					{
						$service_media_path = !empty($service->media_id) ? get_media_path($service->media_id) : base_url('images/noimage.jpg');
						$service_published = date('M d, Y', strtotime($service->created_time));
						
						$html .= '<div class="col-sm-4">
							<h3 class="heading3">
								<a href="'.base_url('service/'.$service->service_id.'/'.$service->service_name).'">'.$service->service_title.'</a>
							</h3>
							<div class="img-box">
								<p><a href="'.base_url('service/'.$service->service_id.'/'.$service->service_name).'">
									<img src="'.$service_media_path.'" alt="'.$service->service_title.'"/>
								</a></p>
							</div>
							<div class="desc">
								<p class="align-justify">'.nl2br($service->service_summary).'</p>
							</div>
						</div>';
					}
							
					$html .= '</div>';
					
					echo $html;
				}
				else
				{
					echo '<p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available service now!</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>