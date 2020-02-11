<?php
// product image
$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod_row->product_id));
$featured_image_path = get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');


/*# category #*/
$category=null;
$categories=get_result("SELECT term_id FROM term_relation WHERE product_id=$prod_row->product_id");
if(count($categories)>0)
{
	foreach($categories as $cat)
	{
		$category[]=$cat->term_id;
		$term_id=$cat->term_id;
	}
	$categories_array=$category;
	$categories=implode(",", $category);
}


/*# product stock availability #*/
$product_availability = $prod_row->product_availability ? $prod_row->product_availability : 'In Stock';
$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));


/*# wishlist #*/
$wishlist = array();
if($this->session->userdata('wishlist'))
{
	$wishlist = $this->session->userdata('wishlist');
}

$wishlist_href = 'javascript:void(0)';
if(in_array($prod_row->product_id, $wishlist))
{
	$wishlist_href = base_url('wishlist');
}


/*# compare #*/
$compare = array();
if($this->session->userdata('compare'))
{
	$compare = $this->session->userdata('compare');
}

$compare_href = 'javascript:void(0)';
if(in_array($prod_row->product_id, $compare))
{
	$compare_href = base_url('compare');
}


/*# review rating #*/
$total_rating = $total_review = $avg_rating = null;
$reviews = get_review($prod_row->product_id);
if(count($reviews)>0)
{
	foreach($reviews as $review){ $rating[] = $review->rating; }
	$total_rating = array_sum($rating);
	$total_review = count($reviews);
	$avg_rating = number_format((($total_rating) / ($total_review)),2);
}

$five_star = count(get_review($prod_row->product_id, 5));
$four_star = count(get_review($prod_row->product_id, 4));
$three_star = count(get_review($prod_row->product_id, 3));
$two_star = count(get_review($prod_row->product_id, 2));
$one_star = count(get_review($prod_row->product_id, 1));
?>


<section id="mpart" class="singleproduct" >
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-5 col-xs-12 col-sm-12">
				<ul class="thumbnails mainimage clearfix ">
					<li><img class="my-foto-container" src="<?php echo $featured_image_path; ?>" data-large="<?php echo $featured_image_path; ?>" data-title="<?php echo $prod_row->product_title; ?>" data-help="<?php echo $prod_row->product_title; ?>" title="<?php echo $prod_row->product_title; ?>"/></li>
				</ul>
				<ul class="thumbnails mainimage clearfix row">
					<?php
					$gallery_image_meta = get_post_meta($prod_row->product_id, 'gallery_image');
					if(!empty($gallery_image_meta))
					{
						$gallery_image=explode(",", $gallery_image_meta);
						if(count($gallery_image)>0)
						{
							?><li class="producthtumb col-lg-3 col-md-3 col-xs-3 col-sm-3"><img class="zoom" src="<?php echo $featured_image; ?>" data-large="<?php echo $featured_image; ?>" data-title="<?php echo $prod_row->product_title; ?>" data-help="<?php echo $prod_row->product_title; ?>" title="<?php echo $prod_row->product_title; ?>"></li><?php
							
							foreach($gallery_image as $gallery_id)
							{
								$gallery=get_media_path($gallery_id);
								
								?><li class="producthtumb col-lg-3 col-md-3 col-xs-3 col-sm-3">
									<img class="zoom" src="<?php echo $gallery; ?>" data-large="<?php echo $gallery; ?>" data-title="<?php echo $prod_row->product_title; ?>" data-help="<?php echo $prod_row->product_title; ?>" title="<?php echo $prod_row->product_title; ?>">
								</li><?php
							}
						}
					}
					?>
				</ul>
			</div>
			<div class="col-lg-7 col-md-7 col-xs-12 col-sm-12 mt40column">
				<div class="titles">
					<h1 class="headinglefttitle"><?php echo $prod_row->product_title; ?></h1>
				</div>
				<div class="specification">
					<?php
					$specifications = json_decode($prod_row->product_specification);
					if(count($specifications)>0)
					{
						echo '<ul class="productinfo">';
						
						$i=1; foreach($specifications as $key=>$val)
						{
							echo '<li><span class="productinfoleft">'.$key.'</span> <span>:</span> '.$val.'</li>';
							
							if($i==5){break;}
							
							$i++;
						}
						
						echo '</ul>';
					}
					?>
				</div>
				<div class="productbox">
					<div class="productprice">
						<div class="addreview">
							<?=($avg_rating!=null) ? '<div class="rating"><span style="width:'.($avg_rating*20).'%"></span></div>' : null?>
						</div>

						<?php
						// product price
						$sell_price = !empty($prod_row->discount_price) ? $prod_row->discount_price : $prod_row->product_price;
						?>
						
						<div class="productpageprice"><?php echo formatted_price($sell_price); ?></div>
						
						<div class="availability <?=$product_availability_index?>">Availability: <span><?=$product_availability?></span></div>
						
						<br/>
						
						<div class="productbtn">
							<a href="<?=$wishlist_href?>" data-product_id="<?=$prod_row->product_id?>" class="btn btn-new add_to_wish_list"><i class="fa fa-heart fa-white"></i></a>
							
							<a href="<?=$compare_href?>" data-product_id="<?=$prod_row->product_id?>" class="btn btn-new add_to_compare"><i class="fa fa-signal"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 mt40"> 
				<div class="titles">
					<div class="headingsubtitle"><?php echo $prod_row->product_summary; ?></div>
				</div>
				<div class="features">
					<ul>
						<li><i class="fa fa-thumbs-up"></i> 100% Original Products</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- start update seo part --->

         <?php 
            $query_category="SELECT category_title,category_name FROM `category` join term_relation on term_relation.term_id=category.category_id WHERE term_relation.product_id=$prod_row->product_id limit 1";
            $category_title=get_result($query_category);
           $category_name= base_url().$category_title[0]->category_name;
            $category_title= $category_title[0]->category_title;
         // echo $category_name;
            
            ?>
            <?php
        $url=base_url().$prod_row->product_name;
        $end_date = date('Y-m-d', strtotime('+1 years'));
      // $recent_url= current_url();
//echo $recent_url;
        ?>
        
<script type="application/ld+json">
    {"itemListElement":[{"item":{"name":"<?php echo $category_title;?>","@id":"<?php echo $url;?>"},"@type":"ListItem","position":<?php echo $prod_row->product_id; ?>},{"item":{"name":"<?php echo $prod_row->product_title; ?>","@id":" <?php echo $url; ?>"},"@type":"ListItem","position":4}],"@type":"BreadcrumbList","@context":"https://schema.org"}


</script>

<script type="application/ld+json">
    {"offers":{"priceCurrency":"BDT","@type":"Offer","price":<?php echo $prod_row->product_price; ?>,"priceValidUntil":"<?php echo $end_date;?>","warranty":{"@type":"WarrantyPromise","durationOfWarranty":{"@type":"QuantitativeValue","unitCode":"ANN","value":"No warranty"}},"availability":"https://schema.org/InStock","url":"<?php echo $url;?>"},"image":"<?php echo $featured_image_path; ?>","@type":"Product","review":[{"datePublished":"<?php echo date('Y-m-d', strtotime($review->created_time)); ?>","@type":"Review","author":"<?php  if($review->name) { echo $review->name; } else { echo "Village Customer";}  ?>","reviewBody":"<?php echo $review->comment;?>","reviewRating":{"@type":"Rating","ratingValue":"<?php if($review->rating){ echo $review->rating; } else {  echo '5';  } ?>"}}],"mpn":<?php echo $prod_row->product_id; ?>,"name":"<?php echo $prod_row->product_title; ?>","description":"<?php echo $prod_row->product_description; ?>","sku":"<?php echo $prod_row->product_id; ?>","category":"<?php echo $category_title;?>","aggregateRating":{"bestRating":5,"@type":"AggregateRating","ratingValue":"4.2","ratingCount":"52","worstRating":1},"@context":"https://schema.org","brand":{"@type":"Brand","name":"No Brand","url":"<?php echo base_url();?>/no-brand-1/"}}

<!-- end  update seo part --->


<style>
body{padding-top:0;}
header{display:none!important;}
footer{display:none!important;}
.footersticky{display:none!important;}
#gotop{display:none!important;}
#aside_social{display:none!important;}

.col-md-5{width:41.66666667%;}
.col-md-7{width:58.33333333%;}

.headinglefttitle{font-size:20px;margin:0 0 10px 0;}
.productbox{padding:15px;}
.addreview{position:initial;margin-bottom:5px;}
.singleproduct .productpageprice{padding:0px 0px 7px;font-size:16px;}

ul.productinfo{margin-bottom:5px;}
ul.productinfo li .productinfoleft{min-width:80px;width:auto;}
ul.productinfo li .productinfoleft+span{width:25px;}
ul.productinfo li+li{border-top:1px solid #ddd;}

.zopim{display:none;}
</style>