<?php
/*echo '<pre>'; print_r($data_row); echo '</pre>';*/
$cservice_id = $data_row->service_id;
$media_path = get_media_path($data_row->media_id);
$published_date = date('M d, Y', strtotime($data_row->created_time));
?>

<section id="mpart" class="servicesingle" itemscope itemtype="http://schema.org/blog">
	<div class="container">
	
		<?=get_breadcrumb($data_row->service_id, 'service', $data_row->service_title)?>
		
		<div class="row mt20">
			<div class="col-md-8"> 
				<section id="blogfullpage">
					<div class="blogdetail">
						<h1 class="heading1" itemprop="name"><?=$data_row->service_title?></h1>
						<div class="blogicons">
							<div class="pull-left">
								<div class="mt20"><i class="fa fa-calendar"></i> <?=$published_date?></div>
							</div>
						</div>
						<div class="imagepopup mt20">
							<?=$data_row->media_id ? '<img src="'.$media_path.'" alt=""/>' : null?>
						</div>
						<div class="caption mt20">
							<?=nl2br($data_row->service_summary)?>

							<div class="author">by: <a>Computer Village</a></div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4 mt5">
				<div class="mt70">
					<div class="special-pro">
						<h3 class="heading3 mt0">Popular service</h3>
						<?php
						$latest_service = get_result("SELECT * FROM `service` ORDER BY service_id DESC LIMIT 5");
						
						if(count($latest_service) > 0)
						{
							$html = '<ul class="special-pro-list">';
							
							foreach($latest_service as $lservice)
							{
								$service_media_path = !empty($lservice->media_id) ? get_media_path($lservice->media_id) : null;
								//$service_media_path = !empty($lservice->media_id) ? get_media_path($lservice->media_id) : base_url('images/noimage.jpg');
								//$service_media_path =get_media_path($lservice->media_id);
								$service_published = date('M d, Y', strtotime($lservice->created_time));
								
								$html .= '<li>';
									if(file_exists($service_media_path))
									{
										$html .= '<div class="img-box">
											<img src="'.$service_media_path.'" alt="'.$lservice->service_title.'" width="80" height="80"/>
											<br/><br/><br/>
										</div>';
									}
									
									$html .= '<div class="desc">
										<h3 class="pro-name">
											<a href="'.base_url('service/'.$lservice->service_id.'/'.$lservice->service_name).'">'.$lservice->service_title.'</a>
										</h3>
										<!--<p class="mr10"><i class="fa fa-calendar"></i> '.$service_published.'</p>-->
									</div>
								</li>';
							}
							
							$html .= '</ul>';
							
							echo $html;
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>