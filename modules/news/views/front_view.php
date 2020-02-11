<?php
/*echo '<pre>'; print_r($data_row); echo '</pre>';*/
$cnews_id = $data_row->news_id;
$media_path = get_media_path($data_row->media_id);
$published_date = date('M d, Y', strtotime($data_row->created_time));
?>

<section id="mpart" class="newssingle" itemscope itemtype="http://schema.org/blog">
	<div class="container">
	
		<?=get_breadcrumb($data_row->news_id, 'news', $data_row->news_title)?>
		
		<div class="row mt20">
			<div class="col-md-8"> 
				<section id="blogfullpage">
					<div class="blogdetail">
						<h1 class="heading1" itemprop="name"><?=$data_row->news_title?></h1>
						<div class="blogicons">
							<div class="pull-left">
								<div class="mt20"><i class="fa fa-calendar"></i> <?=$published_date?></div>
							</div>
						</div>
						<div class="imagepopup mt20">
							<?=$data_row->media_id ? '<img src="'.$media_path.'" alt=""/>' : null?>
						</div>
						<div class="caption mt20">
							<?=nl2br($data_row->news_summary)?>

							<div class="author">by: <a>Computer Village</a></div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-md-4 mt5">
				<div class="mt70">
					<div class="special-pro">
						<h3 class="heading3 mt0">Popular news</h3>
						<?php
						$latest_news = get_result("SELECT * FROM `news` ORDER BY news_id DESC LIMIT 5");
						
						if(count($latest_news) > 0)
						{
							$html = '<ul class="special-pro-list">';
							
							foreach($latest_news as $lnews)
							{
								$news_media_path = !empty($lnews->media_id) ? get_media_path($lnews->media_id) : null;
								//$news_media_path = !empty($lnews->media_id) ? get_media_path($lnews->media_id) : base_url('images/noimage.jpg');
								//$news_media_path =get_media_path($lnews->media_id);
								$news_published = date('M d, Y', strtotime($lnews->created_time));
								
								$html .= '<li>';
									if(file_exists($news_media_path))
									{
										$html .= '<div class="img-box">
											<img src="'.$news_media_path.'" alt="'.$lnews->news_title.'" width="80" height="80"/>
											<br/><br/><br/>
										</div>';
									}
									
									$html .= '<div class="desc">
										<h3 class="pro-name">
											<a href="'.base_url('news/'.$lnews->news_id.'/'.$lnews->news_name).'">'.$lnews->news_title.'</a>
										</h3>
										<!--<p class="mr10"><i class="fa fa-calendar"></i> '.$news_published.'</p>-->
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