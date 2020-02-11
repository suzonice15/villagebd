</br>
</br>

<style>
.codpon_code{
    background-color:
        #0EB04D;
    padding: 17px 10px;
    margin: 5px -4px;
    color:
        white;

}
    .codpon_code_use{
        height: 42px;
    }
    .copon_use{
        float: left;

        border: 2px solid
        #0EB04D;

        padding: 14px 6px;

        margin: -21px -4px auto;

        width: 66px;
    }
    .copon_code_name{
        border: 2px solid
        #0EB04D;

        float: right;

        margin: -20px -3px;

        width: 205px;

        padding: 19px 4px;
    }

.img-camp {
        position: absolute;
        background: url('images/crazyoffer.png');
       
        width: 92px;
        height: 23px;
        left: -22px;
        top: 212px;
    }
    .offer_coupon .pro-box { border: 1px solid
#e1e1e1;
text-align: center;
margin-bottom: 0px;
position: relative;
margin-bottom: 25px;
        
    }

    </style>

<div class="container">
    <div class="row">

        <ul class="row offer_coupon">
            
            <?php if(isset($products)) { 
            
            foreach($products as $row){ 
                $coupon_discount=0;
                $coupon_price=0;
              //  $sell_price=0;
               						//	$sell_price = !empty($row->discount_price) ? $row->discount_price : $row->product_price;
               							if($row->discount_price){
               							  $sell_price  =$row->discount_price;
               							} else {
               							     $sell_price  =$row->product_price;
               							}
             $coupon_status= $row->coupon_status;
	        $coupon_mony= $row->coupon_price;
	        
	        if($coupon_status=='percent'){
	            $coupon_discount=($coupon_mony * $sell_price)/100;
	        } else {
	            $coupon_discount=$coupon_mony;
	        }
	        $coupon_price=$sell_price - $coupon_discount;
	$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $row->product_id));
							
                	$wishlist_href = in_array($row->product_id, $wishlist) ? base_url('wishlist') : 'javascript:void(0)';
							
							$compare_href = in_array($row->product_id, $compare) ? base_url('compare') : 'javascript:void(0)';

                
            ?>
            <li class="col-sm-3">
                <div class="pro-box">
                    <div class="img-box">
<img style="width: 100px;height: 93px;margin-top: -25px;margin-left: 125px;position: absolute;"  src="<?php echo base_url();?>images/crazyoffer.png">
<h4 style="position: absolute;right: 9px;"><?php echo $row->coupon_name?> <br>Offer</h4>
                        <a href="<?php echo base_url()?><?php echo $row->product_name?>"><img
                                src="<?php echo get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list')?>"
                                alt="<?php echo $row->product_title?>">

                            <div class="pro-name" style="height: 36px;overflow: hidden;" ><a href="<?php echo base_url()?><?php echo $row->product_name?>"><?php echo strip_tags($row->product_title)?></a></div>
                        </a>

                        <div class="codpon_code">
                            <h5 style="color: black;font-weight: bold;font-size: 19px;"><?php echo $row->coupon_name?> Price: <?=formatted_price($coupon_price)?></h5>
                           


                        </div>
                        <div class="codpon_code_use">
                            <div class="copon_use">
                            <h5>Use <br>Code</h5>
                                </div>
                            <div class="copon_code_name" ><?php echo $row->coupon_code?></div>

                        </div>
                      	<div class="hover-view-action">
											<a href="javascript:void(0)" class="prod_quick_view" data-product_id="<?php echo $row->product_id ?>" title="Quick View">
												<i class="fa fa-eye"></i>
											</a>
											<a href="<?php echo $wishlist_href ?>" class="add_to_wish_list" data-product_id="<?php echo $row->product_id ?>" title="Wishlist">
												<i class="fa fa-heart"></i>
											</a>
											<a href="<?php echo $compare_href ?>" class="add_to_compare" data-product_id="<?php echo $row->product_id ?>" title="Compare">
												<i class="fa fa-signal"></i>
											</a>
										</div>
                    </div>
                    <div class="info-box">

                        <div style="margin-bottom: -16px;" class="price"><?=formatted_price($sell_price)?></div>
                    </div>
                    <div class="action-box"><a href="<?php echo base_url()?><?php echo $row->product_name?>">View
                            Detail</a><a href="javascript:void(0)" class="add_to_cart" data-product_id="<?php echo $row->product_id ?>" data-product_price="<?php echo $sell_price ?>" data-product_title="<?php echo $row->product_title ?>"> Buy
                            Now </a></div>
                </div>
            </li>


           <?php } }  ?>


        </ul>
    </div>
</div>