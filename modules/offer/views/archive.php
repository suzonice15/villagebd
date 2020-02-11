<section id="mpart" class="offerarchive">
	<div class="container">
		<?=get_breadcrumb(null, null, 'Offer')?>
		
		<div class="row mt40">
			<div class="col-md-12 maincnt">
				<?php
				if(!empty($offers))
				{
					$html = '<div class="row offer">';
							
					foreach($offers as $offer)
					{
						$offer_media_path = !empty($offer->media_id) ? get_media_path($offer->media_id) : base_url('images/noimage.jpg');
						$offer_published = date('M d, Y', strtotime($offer->created_time));
						
						$html .= '<div class="col-sm-4">
							<h3 class="heading3">
								<a href="'.base_url('offer/'.$offer->offer_id.'/'.$offer->offer_name).'">'.$offer->offer_title.'</a>
							</h3>
							<div class="img-box">
								<p><a href="'.base_url('offer/'.$offer->offer_id.'/'.$offer->offer_name).'">
									<img src="'.$offer_media_path.'" alt="'.$offer->offer_title.'"/>
								</a></p>
							</div>
							<div class="desc">
								<p class="align-justify">'.nl2br($offer->offer_summary).'</p>
							</div>
						</div>';
					}
							
					$html .= '</div>';
					
					echo $html;
				}
				else
				{
					echo '<p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available offer now!</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>