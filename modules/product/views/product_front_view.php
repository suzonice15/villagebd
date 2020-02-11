<style>

    #gallery_09 img {
        border: 1px solid #ddd;
        margin-bottom: 5px
    }

    #youtubeVideo {

    }
</style>

<?php
/*# set to customer recent view #*/
set_to_customer_recent_view($prod_row->product_id);

// product image
$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod_row->product_id));
$featured_image_path = get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/');
$featured_image_thumb = get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/', 'mini_thumbs');

// gallery images
$gallery = array();
$gallery_images = $this->global_model->get('media', array('status' => 1, 'media_type' => 'product_gallery', 'relation_id' => $prod_row->product_id));

/*# category #*/
$category = null;

$categories = get_result("SELECT term_id FROM term_relation WHERE product_id=$prod_row->product_id");
if (count($categories) > 0) {
    foreach ($categories as $cat) {
        $category[] = $cat->term_id;
        $term_id = $cat->term_id;
    }
    $categories_array = $category;
    $categories = implode(",", $category);
}
//echo '<pre>'; print_r($categories_array); echo '</pre>';


/*# product stock availability #*/
$product_availability = $prod_row->product_availability ? $prod_row->product_availability : 'In Stock';
$product_availability_index = strtolower(str_replace(" ", "-", $product_availability));


/*# wishlist #*/
$wishlist = array();
if ($this->session->userdata('wishlist')) {
    $wishlist = $this->session->userdata('wishlist');
}

$wishlist_href = 'javascript:void(0)';
if (in_array($prod_row->product_id, $wishlist)) {
    $wishlist_href = base_url('wishlist');
}


/*# compare #*/
$compare = array();
if ($this->session->userdata('compare')) {
    $compare = $this->session->userdata('compare');
}

$compare_href = 'javascript:void(0)';
if (in_array($prod_row->product_id, $compare)) {
    $compare_href = base_url('compare');
}


/*# review rating #*/
$total_rating = $total_review = $avg_rating = null;
$reviews = get_review($prod_row->product_id);
if (count($reviews) > 0) {
    foreach ($reviews as $review) {
        $rating[] = $review->rating;
    }
    $total_rating = array_sum($rating);
    $total_review = count($reviews);
    $avg_rating = number_format((($total_rating) / ($total_review)), 2);
}

$five_star = count(get_review($prod_row->product_id, 5));
$four_star = count(get_review($prod_row->product_id, 4));
$three_star = count(get_review($prod_row->product_id, 3));
$two_star = count(get_review($prod_row->product_id, 2));
$one_star = count(get_review($prod_row->product_id, 1));

// product price
$sell_price = !empty($prod_row->discount_price) ? $prod_row->discount_price : $prod_row->product_price;
?>


<?php
/*# set product top view #*/
set_product_top_view($prod_row->product_id, $categories);
?>



<article id="mpart" class="singleproduct" >
    <div class="container">
        <?php echo get_breadcrumb($prod_row->product_id, 'product', $prod_row->product_title); ?>

        <div class="row">
            <div class="col-sm-5">

                <?php
                $has_gallery = false;

                if (empty($gallery_images)) {

                    ?>

                    <ul style="border:1px solid #ddd" class="thumbnails  singlemainimg clearfix ">
                        <li><img id="originalImage"  src="<?php echo $featured_image_path; ?>"
                                 title="<?php echo $prod_row->product_title; ?>"/></li>
                    </ul>

                <?php } else {
                    ?>
                    <ul class="thumbnails mainimage singlemainimg clearfix ">
                        <li><img id="originalImage" src="<?php echo $featured_image_path; ?>"
                                 title="<?php echo $prod_row->product_title; ?>"/></li>
                    </ul>
                <?php } ?>
                <ul class="thumbnails mainimage clearfix row">
                    <div class="desktopslider">
                        <?php
                        $has_gallery = false;

                        if (!empty($gallery_images)) {
                            $has_gallery = true;

                            ?>
                            <div id="gallery_09" style="width:50px;  position:relative;  left: 52px;top: 10px;">
                        <a href="javascript:void(0)" class="elevatezoom-gallery"
                           alt="<?php echo $prod_row->product_title; ?>" data-image="<?= $featured_image_path ?>"
                           data-zoom-image="<?= $featured_image_path ?>"><img
                                alt="<?php echo $prod_row->product_title; ?>" class="my_image"
                                src="<?= $featured_image_path ?>" width="100"></a><?php

                            foreach ($gallery_images as $gallery) {
                                $gallery_path = get_photo((isset($gallery->media_path) ? $gallery->media_path : null), 'uploads/product/');
                                $gallery_thumb = get_photo((isset($gallery->media_path) ? $gallery->media_path : null), 'uploads/product/', 'mini_thumbs');

                                ?><a href="javascript:void(0)" class="elevatezoom-gallery"
                                     data-image="<?= $gallery_path ?>"  alt="<?php echo $prod_row->product_title; ?>"
                                     data-zoom-image="<?= $gallery_path ?>"><img
                                    alt="<?php echo $prod_row->product_title; ?>" class="my_image"
                                    src="<?= $gallery_path ?>" width="100"></a><?php
                            }
                            ?>
                            </div><?php
                        }
                        ?>
                    </div>

                    <?php
                    if (!empty(trim($prod_row->product_video))) {
                        ?><a href="javascript:void(0)" class="show_product_video_tab"><img
                                style="position: absolute; top: 216px; left: 58px;"
                                src="https://www.village-bd.com/images/social-icons/yt.png"></a><?php
                    }
                    ?>
                </ul>
            </div>
            
          

            <div class="col-sm-5">
                <div class="titles">
                    <h1 class="headinglefttitle"><?php echo $prod_row->product_title; ?></h1>
                    <div class="headingsubtitle"><?php echo $prod_row->product_summary; ?></div>
                </div>
                <div class="productbox">
                    <div class="productprice">
                        <div class="addreview">
                            <?= ($avg_rating != null) ? '<div class="rating"><span style="width:' . ($avg_rating * 20) . '%"></span></div>' : null ?>
                            <a class="clkaddreview" href="javascript:void(0)">Write a Review</a>
                        </div>
                        <div class="productpageprice regular-price">Regular
                            Price: <?php echo formatted_price($prod_row->product_price); ?></div>

                        <?php
                        if (!empty($prod_row->discount_price)) {
                            ?>
                            <div class="productpageprice">Cash Discount
                            Price: <?php echo formatted_price($prod_row->discount_price); ?></div><?php
                        }
                        ?>

                        <div class="availability <?= $product_availability_index ?>">Availability:
                            <span><?= $product_availability ?></span></div>

                        <?php
                        if (!empty($prod_row->product_price) && $product_availability_index == 'in-stock') {
                            ?>
                            <div class="action-btns">
                            <div class="cell-qty text-center">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" id="btnMinus" class="btn btn-gray minus"></button>
                                    </div>
                                    <div class="quantity">
                                        <input type="text" name="product_qty" id="product_qty" value="1"
                                               class="input-text qty text">
                                    </div>
                                    <div class="input-group-btn">
                                        <button type="button" id="btnPlus" class="btn btn-gray plus"></button>
                                    </div>
                                </div>
                            </div>

                            <a href="javascript:void(0)" data-product_id="<?= $prod_row->product_id ?>"
                               data-product_price="<?= $sell_price ?>"
                               data-product_title="<?= $prod_row->product_title ?>" class="btn btn-primary add_to_cart">Add
                                to Cart</a>
                            </div><?php
                        }
                        ?>

                        <div class="productbtn">
                            <a href="<?= $wishlist_href ?>" data-product_id="<?= $prod_row->product_id ?>"
                               class="btn btn-new add_to_wish_list" title="Wishlist"><i
                                    class="fa fa-heart fa-white"></i></a>

                            <a href="<?= $compare_href ?>" data-product_id="<?= $prod_row->product_id ?>"
                               class="btn btn-new add_to_compare" title="Compare"><i class="fa fa-signal"></i></a>

                            <button onclick="printFunction()" class="btn btn-new print_btn" title="Print"><i
                                    class="fa fa-print"></i></button>
							
							<span class="sharethis" href="#">
								<img src="<?= base_url('images/social-icons/sharethis.png') ?>" alt="ShareThis">
								<span class="sharebtns">
									<a href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F&t="
                                       target="_blank"
                                       onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(document.URL)+'&t='+encodeURIComponent(document.URL));return false;"
                                       title="FaceBook Share">
                                        <img src="<?= base_url('images/social-icons/fb.png') ?>" alt="FBShare">
                                    </a>
									<a href="https://twitter.com/intent/tweet?source=http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F&text=:%20http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F"
                                       target="_blank"
                                       onclick="window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(document.title)+':%20'+encodeURIComponent(document.URL));return false;"
                                       title="Tweet">
                                        <img src="<?= base_url('images/social-icons/tw.png') ?>" alt="Tweet"/>
                                    </a>
									<a href="https://plus.google.com/share?url=http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F"
                                       target="_blank"
                                       onclick="window.open('https://plus.google.com/share?url='+encodeURIComponent(document.URL));return false;"
                                       title="Google+ Share">
                                        <img src="<?= base_url('images/social-icons/gp.png') ?>" alt="GoogleShare"/>
                                    </a>
									<a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F&title=&summary=&source=http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F"
                                       target="_blank"
                                       onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(document.URL)+'&title='+encodeURIComponent(document.title));return false;"
                                       title="Linked In Share">
                                        <img src="<?= base_url('images/social-icons/in.png') ?>" alt="LinkedInShare">
                                    </a>
									<a href="mailto:?subject=&body=:%20http%3A%2F%2Fvillage-bd.com%2Fvillagenew%2F"
                                       target="_blank"
                                       onclick="window.open('mailto:?subject='+encodeURIComponent(document.title)+'&body='+encodeURIComponent(document.URL));return false;"
                                       title="SendEmail">
                                        <img src="<?= base_url('images/social-icons/mail.png') ?>" alt="SendEmail"/>
                                    </a>
								</span>
							</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-optional">
                <div class="features">
                    <ul>
                        <li><i class="fa fa-thumbs-up"></i> 100% original products</li>
                        <li><i class="fa fa-money"></i> Pay cash on delivery</li>
                        <li><i class="fa fa-shopping-cart"></i> Delivery within: 2-3 business days</li>
                    </ul>
                </div>
                <div class="featured-products">
                    <?php
                    $featured_products = get_featured_products('DESC', 3);
                    if ($featured_products) {
                        echo '<div class="title">Recent Products</div>';
                        echo '<ul>';

                        foreach ($featured_products as $recent_prod) {
                            $recent_prod_featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $recent_prod->product_id));
                            $recent_prod_product_link = base_url($recent_prod->product_name);

                            echo '<li class="featured-item">
									<a href="' . $recent_prod_product_link . '">
										<div class="image"><img  alt="<?php echo $recent_prod->product_title; ?>" src="' . get_photo((isset($recent_prod_featured_image->media_path) ? $recent_prod_featured_image->media_path : null), 'uploads/product/', 'mini_thumbs') . '"></div>
										<div class="name">' . $recent_prod->product_title . '</div>
									</a>
								</li>';
                        }

                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>


        <!-- Product Description tab & comments-->
        <div class="productdesc mt50">
            <ul class="nav nav-tabs" id="myTab">
                <li class="specification active"><a href="#specification">Specifications</a></li>
                <li class="description"><a href="#description">Description</a></li>
                <li class="product_video"><a id="#product_videoShow" href="#product_video">Video</a></li>
                <li class="review"><a href="#review">Review &amp Ratings</a></li>
                <li class=""><a href="#"><img src="https://www.village-bd.com/uploads/logo_thumb.png"
                                              alt="Computer Village"></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="description">
                    <?= nl2br($prod_row->product_description) ?>
                </div>
                <div class="tab-pane active" id="specification">
                    <?php
                    $specifications = json_decode($prod_row->product_specification);
                    if (count($specifications) > 0) {
                        echo '<table class="productinfo table">';

                        $i = 1;

                        foreach ($specifications as $key => $val) {
                            $tdcls = ($i % 2 == 0) ? 'info' : 'warning';

                            echo '<tr class="' . $tdcls . '">
									<th class="vmiddle">' . $key . '</th>
									<td>' . $val . '</td>
								</tr>';

                            $i++;
                        }

                        echo '</table>';
                    }
                    ?>
                </div>
                <div class="tab-pane" id="product_video">
                    <?php
                    /*if(!empty(trim($prod_row->product_video)))
                    {
                        echo '<div data-type="youtube" data-video-id="'.$prod_row->product_video.'"></div>';
                    }*/
                    ?>

                    <div style="position:relative;height:0;padding-bottom:56.25%">
                        <iframe
                            src="https://www.youtube.com/embed/<?= $prod_row->product_video ?>?rel=0&amp;&amp;showinfo=0?ecver=2"
                            width="640" height="360" frameborder="0"
                            style="position:absolute;width:100%;height:100%;left:0"></iframe>
                    </div>
                </div>
                <div class="tab-pane" id="review">
                    <div class="row reviews">
                        <div class="col-sm-3 review-left">
                            <div class="rating-overall">
                                <div>5 stars
                                    <div class="track"><span style="width:80%"></span></div>
                                    (<?= $five_star ?>)
                                </div>
                                <div>4 stars
                                    <div class="track"><span style="width:60%"></span></div>
                                    (<?= $four_star ?>)
                                </div>
                                <div>3 stars
                                    <div class="track"><span style="width:40%"></span></div>
                                    (<?= $three_star ?>)
                                </div>
                                <div>2 stars
                                    <div class="track"><span style="width:20%"></span></div>
                                    (<?= $two_star ?>)
                                </div>
                                <div>1 star
                                    <div class="track one-star"><span style="width:5%"></span></div>
                                    (<?= $one_star ?>)
                                </div>
                            </div>

                            <h3 class="heading3 mt30">Write a Review</h3>
                            <form class="form-vertical reviewform">
                                <fieldset class="field field-rating srating">
                                    <input type="radio" id="star5" name="rating" value="5"/>
                                    <label class="full" for="star5" title="5 stars"></label>
                                    <input type="radio" id="star4" name="rating" value="4"/>
                                    <label class="full" for="star4" title="4 stars"></label>
                                    <input type="radio" id="star3" name="rating" value="3"/>
                                    <label class="full" for="star3" title="3 stars"></label>
                                    <input type="radio" id="star2" name="rating" value="2"/>
                                    <label class="full" for="star2" title="2 stars"></label>
                                    <input type="radio" id="star1" name="rating" value="1"/>
                                    <label class="full" for="star1" title="1 star"></label>
                                </fieldset>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control field field-name"
                                           placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control field field-email"
                                           placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <textarea rows="3" name="comment" class="form-control field field-comment"
                                              placeholder="Comments"></textarea>
                                </div>

                                <input type="hidden" name="product_id" value="<?= $prod_row->product_id ?>">
                                <button type="button" id="reviewbtn" class="btn btn-new form-control">continue</button>
                            </form>
                        </div>
                        <div class="col-sm-9 review-right">
                            <div class="rating-overall-desc">
                                <div class="rating"><span style="width:<?= $avg_rating * 20 ?>%"></span></div>
                                <?php
                                if ($total_review > 0) {
                                    echo '<p>' . $avg_rating . ' of ' . $total_review . ' stars</p>';
                                }
                                ?>
                            </div>
                            <?php
                            if (count($reviews) > 0) {
                                echo '<ul class="commentlist">';

                                foreach ($reviews as $review) {
                                    echo '<li class="comment even thread-even depth-1">
										<div class="review-user review-header">
											<div class="rating">
												<span style="width:' . (($review->rating) * (20)) . '%"></span>
											</div>
											<h5 itemprop="author">' . $review->name . '</h5>			
											<em class="verified">verified</em>
											<small>' . date('d M Y', strtotime($review->created_time)) . '</small>
										</div>
										<div class="review-body">
											<div class="review-text" >
												<p itemprop="description">' . $review->comment . '</p>
											</div>
										</div>
									</li>';
                                }

                                echo '</ul>';
                            } else {
                                echo '<br><h4>No reviews found!</h4>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- start update seo part --->

         <?php 
            $query_category="SELECT category_title,category_name FROM `category` join term_relation on term_relation.term_id=category.category_id WHERE term_relation.product_id=$prod_row->product_id limit 1";
            $category_title=get_result($query_category);
           $category_name= base_url().$category_title[0]->category_name;
            $category_title= $category_title[0]->category_title;
             $description = strip_tags($prod_row->product_description);
                $description = str_replace('"', '', $description);
            
            ?>
            <?php
        $url=base_url().$prod_row->product_name;
        $end_date = date('Y-m-d', strtotime('+1 years'));
       $recent_url= current_url();
        ?>
        
<script type="application/ld+json">
    {"itemListElement":[{"item":{"name":"<?php echo $category_title;?>","@id":"<?php echo $url;?>"},"@type":"ListItem","position":<?php echo $prod_row->product_id; ?>},{"item":{"name":"<?php echo $prod_row->product_title; ?>","@id":" <?php echo $recent_url; ?>"},"@type":"ListItem","position":4}],"@type":"BreadcrumbList","@context":"https://schema.org"}


</script>

<script type="application/ld+json">
    {"offers":{"priceCurrency":"BDT","@type":"Offer","price":<?php echo $prod_row->product_price; ?>,"priceValidUntil":"<?php echo $end_date;?>","warranty":{"@type":"WarrantyPromise","durationOfWarranty":{"@type":"QuantitativeValue","unitCode":"ANN","value":"No warranty"}},"availability":"https://schema.org/InStock","url":"<?php echo $url;?>"},"image":"<?php echo $featured_image_path; ?>","@type":"Product","review":[{"datePublished":"<?php echo date('Y-m-d', strtotime($review->created_time)); ?>","@type":"Review","author":"<?php  if($review->name) { echo $review->name; } else { echo "Village Customer";}  ?>","reviewBody":"<?php echo $review->comment;?>","reviewRating":{"@type":"Rating","ratingValue":"<?php if($review->rating){ echo $review->rating; } else {  echo '5';  } ?>"}}],"mpn":<?php echo $prod_row->product_id; ?>,"name":"<?php echo $prod_row->product_title; ?>","description":"<?php echo $description; ?>","sku":"<?php echo $prod_row->product_id; ?>","category":"<?php echo $category_title;?>","aggregateRating":{"bestRating":5,"@type":"AggregateRating","ratingValue":"4.2","ratingCount":"52","worstRating":1},"@context":"https://schema.org","brand":{"@type":"Brand","name":"No Brand","url":"<?php echo base_url();?>/no-brand-1/"}}

<!-- end  update seo part --->

</script>
        <div class="mobile w999">
            <div class="features">
                <ul>
                    <li><i class="fa fa-thumbs-up"></i> 100% original products</li>
                    <li><i class="fa fa-money"></i> Pay cash on delivery</li>
                    <li><i class="fa fa-shopping-cart"></i> Delivery within: 2-3 business days</li>
                </ul>
            </div>
            <div class="featured-products">
                <?php
                $featured_products = get_featured_products('DESC', 3);
                if ($featured_products) {
                    echo '<div class="title">Recent Products</div>';
                    echo '<ul>';

                    foreach ($featured_products as $recent_prod) {
                        $recent_prod_featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $recent_prod->product_id));;
                        $recent_prod_product_link = base_url($recent_prod->product_name);

                        echo '<li class="featured-item">
								<a href="' . $recent_prod_product_link . '">
									<div class="image"><img  alt="<?php echo $recent_prod->product_title; ?>" src="' . get_photo((isset($recent_prod_featured_image->media_path) ? $recent_prod_featured_image->media_path : null), 'uploads/product/', 'mini_thumbs') . '"></div>
									<div class="name">' . $recent_prod->product_title . '</div>
								</a>
							</li>';
                    }

                    echo '</ul>';
                }
                ?>
            </div>
        </div>


        <!-- related products -->
        <section id="related-products" class="mt70">
            <h2 class="heading3">Related Products</h2>
            <?php
            $sql = "SELECT * FROM `product` INNER JOIN `term_relation` WHERE product.product_id = term_relation.product_id AND term_relation.term_id IN($categories) AND product.product_id != $prod_row->product_id LIMIT 5";
            $related_products = get_result($sql);

            //echo '<pre>'; print_r($categories); echo '</pre>';

            if (count($related_products) > 0) {
                $html = '<ul class="mt30 row five-cols">';

                $i = 1;
                foreach ($related_products as $prod) {
                    $featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));

                    $product_link = base_url($prod->product_name);

                    // product price
                    $sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;

                    $wishlist_href = 'javascript:void(0)';
                    if (in_array($prod->product_id, $wishlist)) {
                        $wishlist_href = base_url('wishlist');
                    }

                    $compare_href = 'javascript:void(0)';
                    if (in_array($prod->product_id, $compare)) {
                        $compare_href = base_url('compare');
                    }

                    $html .= '<li class="col-md-1">
						<div class="pro-box">
							<div class="img-box">
								<a href="' . base_url($prod->product_name) . '">
									<img  alt="<?php echo $recent_prod->product_title; ?>" src="' . get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/', 'list') . '" alt="' . $prod->product_title . '"/>
								</a>
								<div class="hover-view-action">
									<a href="javascript:void(0)" class="prod_quick_view" data-product_id="' . $prod->product_id . '" title="Quick View">
										<i class="fa fa-eye"></i>
									</a>
									<a href="' . $wishlist_href . '" class="add_to_wish_list" data-product_id="' . $prod->product_id . '" title="Wishlist">
										<i class="fa fa-heart"></i>
									</a>
									<a href="' . $compare_href . '" class="add_to_compare" data-product_id="' . $prod->product_id . '" title="Compare">
										<i class="fa fa-signal"></i>
									</a>
								</div>
							</div>
							<div class="info-box">
								<div class="pro-name">';

                    $_product_title = strip_tags($prod->product_title);
                    //if(strlen($_product_title) >= 20){ $_product_title = substr($_product_title, 0, 17).'...'; }

                    $html .= '<a href="' . base_url($prod->product_name) . '">' . $_product_title . '</a>
									
								</div>
								<div class="price">' . formatted_price($sell_price) . '</div>
							</div>
							<div class="action-box">
								<a href="' . $product_link . '">
									View Detail
								</a>
								<a href="javascript:void(0)" class="add_to_cart" data-product_id="' . $prod->product_id . '" data-product_price="' . $sell_price . '" data-product_title="' . $prod->product_title . '">
									Add to Cart
								</a>
							</div>
						</div>
					</li>';

                    $i++;

                    if ($i == 6) {
                        break;
                    }
                }

                $html .= '</ul>';

                echo $html;
            }
            ?>
        </section>
    </div>
    </section>

    <style>
        @media print {
            header {
                display: none !important;
            }

            .breadcrumb {
                display: none !important;
            }

            #catnav {
                display: none !important;
            }

            #aside_social {
                display: none !important;
            }

            footer {
                display: none !important;
            }

            .footersticky {
                display: none !important;
            }

            .sidebar {
                display: none !important;
            }

            .zoomtext {
                display: none !important;
            }

            .zoomtext + .thumbnails {
                display: none !important;
            }

            .productbox {
                margin: 0px;
                padding: 0px;
            }

            .addreview {
                display: none !important;
            }

            .availability {
                display: none !important;
            }

            .productbtn {
                display: none !important;
            }

            .features {
                display: none !important;
            }

            .nav-tabs {
                display: none !important;
            }

            .tab-content {
                padding: 0px;
            }

            .print_btn {
                display: none !important;
            }

            #gotop {
                display: none !important;
            }
        }

        body {
            margin: 0px;
        }
    </style>

    <script>function printFunction() {
            window.print();
            return false;
        }</script>

    <script>
        $('.my_image').on({
            'click': function () {
                var image = ($(this).attr('src'));
                $('#originalImage').attr('src', image);
            }
        });

        jQuery(document).ready(function () {
            jQuery('.show_product_video_tab').on('click', function () {
                jQuery('.nav-tabs li').removeClass('active');
                jQuery('.nav-tabs li.product_video').addClass('active');

                jQuery('.tab-content .tab-pane').removeClass('active');
                jQuery('.tab-content #product_video').addClass('active');

                jQuery("html, body").animate({scrollTop: jQuery('.tab-content #product_video').offset().top}, 1000);
            });
        });
    </script>