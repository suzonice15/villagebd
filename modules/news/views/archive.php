<section id="mpart" class="newsarchive">
	<div class="container">
		<?=get_breadcrumb(null, null, 'News')?>
		
		<div class="row mt40">
			<div class="col-md-12 maincnt">
				<?php
				if(!empty($newses))
				{
					$html = '<div class="row news">';
							
					foreach($newses as $news)
					{
						$news_media_path = !empty($news->media_id) ? get_media_path($news->media_id) : base_url('images/noimage.jpg');
						$news_published = date('M d, Y', strtotime($news->created_time));
						
						$html .= '<div class="col-sm-4">
							<h3 class="heading3">
								<a href="'.base_url('news/'.$news->news_id.'/'.$news->news_name).'">'.$news->news_title.'</a>
							</h3>
							<div class="img-box">
								<p><a href="'.base_url('news/'.$news->news_id.'/'.$news->news_name).'">
									<img src="'.$news_media_path.'" alt="'.$news->news_title.'"/>
								</a></p>
							</div>
							<div class="desc">
								<p class="align-justify">'.nl2br($news->news_summary).'</p>
							</div>
						</div>';
					}
							
					$html .= '</div>';
					
					echo $html;
				}
				else
				{
					echo '<p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available news now!</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>