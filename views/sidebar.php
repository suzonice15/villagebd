<div class="adsbox">
	<?php
	$adds = get_adds();
	//echo '<pre>'; print_r($adds); echo '</pre>';
	if(count($adds) > 0)
	{
		$side_html='<ul>';
		
		foreach($adds as $add)
		{
			$side_html.='<li>
				<h4>'.$add->adds_title.'</h4>
				<a href="'.$add->adds_link.'">
					<img src="'.get_media_path($add->media_id).'">
				</a>
			</li>';
		}
		
		$side_html.='</ul>';
		
		echo $side_html;
	}
	?>
	
	
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- village-web -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6232518162579727"
     data-ad-slot="6836414201"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
	
</div>