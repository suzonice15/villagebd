<section id="mpart" class="blogarchive">
	<div class="container">
		<?=get_breadcrumb(null, null, 'Blogs')?>
		
		<div class="row mt40">
			<div class="col-md-12 maincnt">
				<?php
				if(!empty($blogs))
				{
					$html = '<div class="row blog">';
							
					foreach($blogs as $blog)
					{
						$blog_media_path = !empty($blog->media_id) ? get_media_path($blog->media_id) : base_url('images/noimage.jpg');
						$blog_published = date('M d, Y', strtotime($blog->created_time));
						
						$html .= '<div class="col-sm-4">
							<h3 class="heading3">
								<a href="'.base_url('blog/'.$blog->blog_id.'/'.$blog->blog_name).'">'.$blog->blog_title.'</a>
							</h3>
							<div class="img-box">
								<p><a href="'.base_url('blog/'.$blog->blog_id.'/'.$blog->blog_name).'">
									<img src="'.$blog_media_path.'" alt="'.$blog->blog_title.'"/>
								</a></p>
							</div>
							<div class="desc">
								<p class="align-justify">'.nl2br($blog->blog_summary).'</p>
							</div>
						</div>';
					}
							
					$html .= '</div>';
					
					echo $html;
				}
				else
				{
					echo '<p style="border:1px solid green;padding:5px;width:100%;font-size:16px;">No available blog now!</p>';
				}
				?>
			</div>
		</div>
	</div>
</section>