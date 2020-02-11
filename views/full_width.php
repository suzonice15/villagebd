<section id="content" class="aboutpage">
	<div class="container">
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
			<?=$post->post_content?>
		</article>
	</div>
</section>