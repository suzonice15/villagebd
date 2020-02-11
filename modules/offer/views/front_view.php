<?php
/*echo '<pre>'; print_r($data_row); echo '</pre>';*/
$coffer_id = $data_row->offer_id;
$media_path = get_media_path($data_row->media_id);
$published_date = date('M d, Y', strtotime($data_row->created_time));
?>

<section id="mpart" class="offersingle" itemscope itemtype="http://schema.org/blog">
	<div class="container">
	
		<?=get_breadcrumb($data_row->offer_id, 'offer', $data_row->offer_title)?>
		
		<div class="row mt20">
			<div class="col-md-8"> 
				<section id="blogfullpage">
					<div class="blogdetail">
						<h1 class="heading1" itemprop="name"><?=$data_row->offer_title?></h1>
						<div class="blogicons">
							<div class="pull-left">
								<div class="mt20"><i class="fa fa-calendar"></i> <?=$published_date?></div>
							</div>
						</div>
						<div class="imagepopup mt20">
							<?=$data_row->media_id ? '<img src="'.$media_path.'" alt=""/>' : null?>
						</div>
						<div class="caption mt20">
							<?=nl2br($data_row->offer_summary)?>

							<div class="author">by: <a>Computer Village</a></div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4 mt5">
				<div class="mt70">
					<div class="special-pro">
						<h3 class="heading3 mt0">Popular Offer</h3>
						<?php
						$latest_offer = get_result("SELECT * FROM `offer` ORDER BY offer_id DESC LIMIT 5");
						
						if(count($latest_offer) > 0)
						{
							$html = '<ul class="special-pro-list">';
							
							foreach($latest_offer as $loffer)
							{
								$offer_media_path = !empty($loffer->media_id) ? get_media_path($loffer->media_id) : null;
								//$offer_media_path = !empty($loffer->media_id) ? get_media_path($loffer->media_id) : base_url('images/noimage.jpg');
								//$offer_media_path =get_media_path($loffer->media_id);
								$offer_published = date('M d, Y', strtotime($loffer->created_time));
								
								$html .= '<li>';
									if(file_exists($offer_media_path))
									{
										$html .= '<div class="img-box">
											<img src="'.$offer_media_path.'" alt="'.$loffer->offer_title.'" width="80" height="80"/>
											<br/><br/><br/>
										</div>';
									}
									
									$html .= '<div class="desc">
										<h3 class="pro-name">
											<a href="'.base_url('offer/'.$loffer->offer_id.'/'.$loffer->offer_name).'">'.$loffer->offer_title.'</a>
										</h3>
										<!--<p class="mr10"><i class="fa fa-calendar"></i> '.$offer_published.'</p>-->
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