<section id="content" class="aboutpage">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="adsbox">
					<?php
					$adds = get_adds();
					if(count($adds)>0)
					{
						$side_html='<ul>';
						
						foreach($adds as $add)
						{
							$side_html.='<li>
								<a href="'.$add->adds_link.'">
									<img src="'.get_media_path($add->media_id).'">
								</a>
							</li>';
						}
						
						$side_html.='</ul>';
						
						echo $side_html;
					}
					?>
				</div>
			</div>
			<div class="col-sm-9">
				<div class="subheader">
					<ul class="breadcrumb">
						<li><a href="<?=base_url()?>">Home</a></li>
						<li class="active"><?=$page_title?></li>
					</ul>
					
					<div class="page-title">
						<h1><?=$page_title?></h1>
					</div>
				</div>
				<article class="txt">
					<?php
					$career_form_html = null;

					$message = $this->session->userdata('message');
					
					if(!empty($message))
					{
						$message_type = isset($message['status']) ? $message['status'] : null;
						$message_text = isset($message['message']) ? $message['message'] : null;

						if($message_type=='success')
						{
							$career_form_html.='<p style="margin:15px 0;padding:10px;background:#eee;color:green;border-radius:3px;">'.$message_text.'</p>';
						}
						else
						{
							$career_form_html.='<p style="margin:15px 0;padding:10px;background:#eee;color:#d00;border-radius:3px;">'.$message_text.'</p>';
						}

						$this->session->set_userdata('message', null);
					}
					?>

					<?php
					$career_form_html.='<form method="post" action="'.base_url().'general/add_new_career" enctype="multipart/form-data">
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" class="form-control field-name" name="name" placeholder="Name*"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
									<input type="text" class="form-control field-email" name="email" placeholder="Email*"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-upload"></i></span>
									<input type="file" class="form-control field-upload" name="cv"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default form-control">Send <span class="glyphicon glyphicon-send"></span></button>
						</div>
					</form>';

					echo str_replace('[career_form]', $career_form_html, $post->post_content);
					?>
				</article>
			</div>
		</div>
	</div>
</section>