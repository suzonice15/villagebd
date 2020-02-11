<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
	}
	
	
	/*### universal delete ###*/
	function delete_all_row()
	{
		$row_ids = array_values(array_filter((explode(',', $this->input->get_post('row_id')))));
		$table = $this->input->post('table');		
		if($table == 'users')
		{
			$this->db->where_in('users.user_id', $row_ids);
		}
		else
		{
			$this->db->where_in($table.'_id', $row_ids);
		}
		$this->db->delete($table);
		die();
	}
	
	public function delete_row_by_id()
	{
		$row_id = $this->input->post('row_id');
		$table = $this->input->post('table');
		if($table == 'users')
		{
			$this->db->where('users.user_id', $row_id);
			echo $this->db->delete($table);
		}
		else
		{
			$this->db->where($table.'.'.$table.'_id', $row_id);
			echo $this->db->delete($table);
		}
		die();
	}
	
	
	/*### wishlist ###*/
	public function add_to_wish_list()
	{
		$wishlist = array();
		
		$product_id = $this->input->post('product_id');
		
		if($this->session->userdata('wishlist'))
		{
			$wishlist = $this->session->userdata('wishlist');
		}
		
		array_push($wishlist, $product_id);
		
		$wishlist = array_unique($wishlist);
		
		$this->session->set_userdata('wishlist', $wishlist);
		
		echo true;
		die();
	}

	public function remove_wish_list()
	{
		$wishlist=array();
		
		$product_id=$this->input->post('product_id');
		
		if($this->session->userdata('wishlist'))
		{
			$wishlist = $this->session->userdata('wishlist');
		}
		
		$key=array_search($product_id, $wishlist);
		
		unset($wishlist[$key]);
		
		$wishlist=array_values($wishlist);
		
		$this->session->set_userdata('wishlist', $wishlist);
		
		if(count($wishlist)==0){ echo 'empty_wishlist'; }
		else{ echo true; }
		die();
	}
	
	
	/*### compare ###*/
	public function add_to_compare()
	{
		$compare = array();
		
		$product_id = $this->input->post('product_id');
		
		if($this->session->userdata('compare'))
		{
			$compare = $this->session->userdata('compare');
		}
		
		array_push($compare, $product_id);
		
		$compare = array_unique($compare);
		
		if(count($compare)>3){ unset($compare[0]); }
		
		$compare=array_values($compare);
		
		$this->session->set_userdata('compare', $compare);
		
		echo true;
		die();
	}

	public function remove_compare()
	{
		$compare=array();
		
		$product_id=$this->input->post('product_id');
		
		if($this->session->userdata('compare'))
		{
			$compare = $this->session->userdata('compare');
		}
		
		$key=array_search($product_id, $compare);
		
		unset($compare[$key]);
		
		$compare=array_values($compare);
		
		$this->session->set_userdata('compare', $compare);
		
		if(count($compare)==0){ echo 'empty_compare'; }
		else{ echo true; }
		die();
	}
	
	
	/*### make order completed by ajax ###	*/
	public function make_order_done()
	{
		$row_id = $this->input->post('row_id');
		$table = $this->input->post('table');
		
		$data['order_status'] = 'completed';
		$this->db->where('order.order_id', $row_id);
		echo $this->db->update('order', $data);
		die();
	}
	
	
	/*### add to cart ###*/
	public function add_to_cart()
	{
		$product_id = $this->input->post('product_id');
		$product_qty = $this->input->post('product_qty');
		$product_price = $this->input->post('product_price');
		$product_title = $this->input->post('product_title');
		
		$data=array(
			'id'	=>	$product_id,
			'qty'	=>	$product_qty,
			'price'	=>	$product_price,
			'name'	=>	$product_id
		);

		$this->cart->insert($data);
		
		$cart_items=$cart_total=0;
		foreach($this->cart->contents() as $key=>$val)
		{
			$cart_items += $val['qty'];
			$cart_total += $val['subtotal'];
		}
		$html='<table class="table table-striped table-bordered">
			<tr>
				<td colspan="3" class="cart-heading">
					<span class="itemno">'.$cart_items.'</span> ITEMS
				</td>
			</tr>';
			foreach($this->cart->contents() as $items)
			{
			
					$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
			$featured_image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');
			
				
				$html.='<tr>
					<td class="total text-center">
						<a class="remove_from_cart" data-rowid="'.$items['rowid'].'"><i class="tooltip-test font24 fa fa-remove"></i></a>
					</td>
					<td class="product-item text-center">
						<a>
							<img src="'.$featured_image.'" height="30" width="30"/>
						</a>
						<div class="item-name-and-price">
							<div class="item-name">'.get_product_title($items['id']).'</div>
							<div class="item-price">
								৳ '.$this->cart->format_number($items['price']).' x '.$items['qty'].'
								<div class="quantity-action" data-rowid="'.$items['rowid'].'">
									<div class="qtyplus" data-action_type="plus">+</div>
									<div class="qtyminus" data-action_type="minus">-</div>
								</div>
							</div>
						</div>
					</td>
					<td>৳ '.$this->cart->format_number($items['subtotal']).'</td>
				</tr>';
			}
			$html.='<tr>
				<td colspan="3" class="cart-action">
					<a href="'.base_url().'">Continue Shopping</a>
					<a href="'.base_url('checkout').'">Place Order</a>
					<div class="cart-total text-right">৳ '.$this->cart->format_number($this->cart->total()).'</div>
				</td>
			</tr>
		</table>';
		
		echo json_encode(array(
			"html"=>$html,
			"current_cart_item"=>$cart_items,
			"current_cart_total"=>$this->cart->format_number($this->cart->total())
		));
		die();
	}

	public function remove_from_cart()
	{
		$rowid=$this->input->post('rowid');
		
		$data=array('rowid'=>$rowid, 'qty'=>0);

		$this->cart->update($data);
		
		$cart_items=$cart_total=0;
		foreach($this->cart->contents() as $key=>$val)
		{
			$cart_items += $val['qty'];
			$cart_total += $val['subtotal'];
		}
		$html='<table class="table table-striped table-bordered">
			<tr>
				<td colspan="3" class="cart-heading">
					<span class="itemno">'.$cart_items.'</span> ITEMS
				</td>
			</tr>';
			foreach($this->cart->contents() as $items)
			{
					$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
			$featured_image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');
			
				
				$html.='<tr>
					<td class="total text-center">
						<a class="remove_from_cart" data-rowid="'.$items['rowid'].'"><i class="tooltip-test font24 fa fa-remove"></i></a>
					</td>
					<td class="product-item text-center">
						<a>
							<img src="'.$featured_image.'" height="30" width="30"/>
						</a>
						<div class="item-name-and-price">
							<div class="item-name">'.get_product_title($items['id']).'</div>
							<div class="item-price">
								৳ '.$this->cart->format_number($items['price']).' x '.$items['qty'].'
								<div class="quantity-action" data-rowid="'.$items['rowid'].'">
									<div class="qtyplus" data-action_type="plus">+</div>
									<div class="qtyminus" data-action_type="minus">-</div>
								</div>
							</div>
						</div>
					</td>
					<td>৳ '.$this->cart->format_number($items['subtotal']).'</td>
				</tr>';
			}
			$html.='<tr>
				<td colspan="3" class="cart-action">
					<a href="'.base_url('checkout').'">Place Order</a>
					<div class="cart-total text-right">৳ '.$this->cart->format_number($this->cart->total()).'</div>
				</td>
			</tr>
		</table>';
		
		echo json_encode(array(
			"html"=>$html,
			"current_cart_item"=>$cart_items,
			"current_cart_total"=>$this->cart->format_number($this->cart->total())
		));
		die();
	}

	public function update_to_cart()
	{
		$action_type=$this->input->post('action_type');
		$rowid=$this->input->post('rowid');
		
		foreach($this->cart->contents() as $items)
		{
			if($rowid==$items['rowid'])
			{
				$action_qty = $items['qty'];
			}
		}

		if($action_type=='plus')
		{
			$action_qty = intval($action_qty) + 1;
		}
		else
		{
			$action_qty = intval($action_qty) - 1;
		}
		
		$data=array('rowid'=>$rowid, 'qty'=>$action_qty);

		$this->cart->update($data);

		//echo 'action_qty: '.$action_qty;

		$cart_items=$cart_total=0;

		foreach($this->cart->contents() as $key=>$val)
		{
			$cart_items += $val['qty'];
			$cart_total += $val['subtotal'];
		}

		$html='<table class="table table-striped table-bordered">
			<tr>
				<td colspan="3" class="cart-heading">
					<span class="itemno">'.$cart_items.'</span> ITEMS
				</td>
			</tr>';

			foreach($this->cart->contents() as $items)
			{
					$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
			$featured_image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');
			
				
				$html.='<tr>
					<td class="total text-center">
						<a class="remove_from_cart" data-rowid="'.$items['rowid'].'"><i class="tooltip-test font24 fa fa-remove"></i></a>
					</td>
					<td class="product-item text-center">
						<a>
							<img src="'.$featured_image.'" height="30" width="30"/>
						</a>
						<div class="item-name-and-price">
							<div class="item-name">'.get_product_title($items['id']).'</div>
							<div class="item-price">
								৳ '.$this->cart->format_number($items['price']).' x '.$items['qty'].'
								<div class="quantity-action" data-rowid="'.$items['rowid'].'">
									<div class="qtyplus" data-action_type="plus">+</div>
									<div class="qtyminus" data-action_type="minus">-</div>
								</div>
							</div>
						</div>
					</td>
					<td>৳ '.$this->cart->format_number($items['subtotal']).'</td>
				</tr>';
			}

			$html.='<tr>
				<td colspan="3" class="cart-action">
					<a href="'.base_url('checkout').'">Place Order</a>
					<div class="cart-total text-right">৳ '.$this->cart->format_number($this->cart->total()).'</div>
				</td>
			</tr>
		</table>';
		
		echo json_encode(array(
			"html"=>$html,
			"current_cart_item"=>$cart_items,
			"current_cart_total"=>$this->cart->format_number($this->cart->total())
		));
		die();
	}


	/*### pcbuilder ###*/
	public function add_to_pc_builder()
	{
		$product_id 		= $this->input->post('product_id');
		$component_slug 	= $this->input->post('component_slug');
		$component_id 		= $this->input->post('component_id');

		if(trim(strtolower($component_slug))=='cpu')
		{
			$this->session->set_userdata('pcbuilder', array());
			
			$prod_cats = array();

			$product_terms = product_terms($product_id);

			if($product_terms && is_array($product_terms))
			{
				foreach($product_terms as $pterm)
				{
					$pterm_name = get_category_title($pterm->term_id);

					if(strpos(trim(strtolower($pterm_name)), 'amd')!==false)
					{
						$this->session->set_userdata('pc_builder_processor', 'amd');
					}
					else
					{
						$this->session->set_userdata('pc_builder_processor', 'intel');
					}
				}
			}
		}
		
		if($this->session->userdata('pcbuilder'))
		{
			$pcbuilder = $this->session->userdata('pcbuilder');
		}

		$pcbuilder[$component_slug.'-'.$component_id] = $product_id;
		
		$this->session->set_userdata('pcbuilder', $pcbuilder);

		$this->session->set_userdata('pc_builder_processor_id', $product_id);
		
		echo true;
		die();
	}

	public function remove_from_pc_builder()
	{
		$component_slug 	= $this->input->post('component_slug');
		$component_id 		= $this->input->post('component_id');
		
		if($this->session->userdata('pcbuilder'))
		{
			$pcbuilder = $this->session->userdata('pcbuilder');
		}

		$pcbuilder[$component_slug.'-'.$component_id] = '';
		
		$this->session->set_userdata('pcbuilder', $pcbuilder);
		
		echo true;
		die();
	}

	public function delete_saved_pc()
	{
		$pc_id 	= $this->input->post('pc_id');
		$this->db->where('pc_id', $pc_id);
		echo $this->db->delete('saved_pc');

		echo true;
		die();
	}

	public function add_to_cart_from_pc_builder()
	{
		$cart_from 	= $this->input->post('cart_from');
		$pc_id 		= null;

		$pcbuilder = $this->session->userdata('pcbuilder');
		
		if($cart_from=='savedpc')
		{
			$pc_id 	= $this->input->post('pc_id');
			
			$pc 	= get_row('saved_pc', 'pc_id', $pc_id);

			$pcbuilder = unserialize($pc->components);
		}
	
		if(sizeof($pcbuilder)>0)
		{
			foreach($pcbuilder as $product_id)
			{
				$product_data 	= get_row('product', 'product_id', $product_id);
				
				if(sizeof($product_data)>0)
				{
					// product price
					$sell_price = !empty($product_data->discount_price) ? $product_data->discount_price : $product_data->product_price;

					$this->cart->insert(array(
						'id'	=> $product_id,
						'qty'	=> 1,
						'price'	=> $sell_price,
						'name'	=> $product_id
					));
				}
			}
		}
					
		$cart_items=$cart_total=0;

		foreach($this->cart->contents() as $key=>$val)
		{
			$cart_items += $val['qty'];
			$cart_total += $val['subtotal'];
		}

		$html='<table class="table table-striped table-bordered">
			<tr>
				<td colspan="3" class="cart-heading">
					<span class="itemno">'.$cart_items.'</span> ITEMS
				</td>
			</tr>';
			foreach($this->cart->contents() as $items)
			{
				$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $items['id']));
			$featured_image=get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','list');
			
				
				$html.='<tr>
					<td class="total text-center">
						<a class="remove_from_cart" data-rowid="'.$items['rowid'].'"><i class="tooltip-test font24 fa fa-remove"></i></a>
					</td>
					<td class="product-item text-center">
						<a>
							<img src="'.$featured_image.'" height="30" width="30"/>
						</a>
						<div class="item-name-and-price">
							<div class="item-name">'.get_product_title($items['id']).'</div>
							<div class="item-price">
								৳ '.$this->cart->format_number($items['price']).' x '.$items['qty'].'
								<div class="quantity-action" data-rowid="'.$items['rowid'].'">
									<div class="qtyplus" data-action_type="plus">+</div>
									<div class="qtyminus" data-action_type="minus">-</div>
								</div>
							</div>
						</div>
					</td>
					<td>৳ '.$this->cart->format_number($items['subtotal']).'</td>
				</tr>';
			}
			$html.='<tr>
				<td colspan="3" class="cart-action">
					<a href="'.base_url().'">Continue Shopping</a>
					<a href="'.base_url('checkout').'">Place Order</a>
					<div class="cart-total text-right">৳ '.$this->cart->format_number($this->cart->total()).'</div>
				</td>
			</tr>
		</table>';
		
		echo json_encode(array(
			"html"=>$html,
			"current_cart_item"=>$cart_items,
			"current_cart_total"=>$this->cart->format_number($this->cart->total())
		));
		die();
	}
	
	
	/*### review ###*/
	public function add_to_review()
	{		
		$rating = $this->input->post('rating');
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$comment = $this->input->post('comment');
		$product_id = $this->input->post('product_id');
		
		if(!empty($rating) && !empty($name) && !empty($email) && !empty($comment) && !empty($product_id))
		{
			$review_data['rating'] = $rating;
			$review_data['name'] = $name;
			$review_data['email'] = $email;
			$review_data['comment'] = $comment;
			$review_data['product_id'] = $product_id;
			$review_data['created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert('review', $review_data);
			echo $this->db->insert_id();
		}
		else
		{
			echo false;
		}
		die();
	}
	
	
	/*### contact ###*/
	public function contact_inquiry_action()
	{		
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		
		if(!empty($name) && !empty($phone) && !empty($subject) && !empty($message))
		{
			$inquiry_data['name'] = $name;
			$inquiry_data['phone'] = $phone;
			$inquiry_data['subject'] = $subject;
			$inquiry_data['message'] = $message;
			$inquiry_data['created_time'] = date("Y-m-d H:i:s");
			$inquiry_data['modified_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert('inquiry', $inquiry_data);
			echo $this->db->insert_id();
		}
		else
		{
			echo false;
		}
		die();
	}
	
	
	/*### feedback ###*/
	public function feedback_action()
	{		
		$content_rating = $this->input->post('content_rating');
		$design_rating = $this->input->post('design_rating');
		$easy_use_rating = $this->input->post('easy_use_rating');
		$overall_rating = $this->input->post('overall_rating');
		$page = $this->input->post('page');
		$review = $this->input->post('review');
		$email_or_phone = $this->input->post('email_or_phone');
		$purpose_of_visit = $this->input->post('purpose_of_visit');
		$where_of_visit = $this->input->post('where_of_visit');
		$how_of_visit = $this->input->post('how_of_visit');

		if(!empty($content_rating) && !empty($email_or_phone) && !empty($page) && !empty($purpose_of_visit))
		{
			$feedback_data['content_rating'] = $content_rating;
			$feedback_data['design_rating'] = $design_rating;
			$feedback_data['easy_use_rating'] = $easy_use_rating;
			$feedback_data['overall_rating'] = $overall_rating;
			$feedback_data['page'] = $page;
			$feedback_data['review'] = $review;
			$feedback_data['email_or_phone'] = $email_or_phone;
			$feedback_data['purpose_of_visit'] = $purpose_of_visit;
			$feedback_data['where_of_visit'] = $where_of_visit;
			$feedback_data['how_of_visit'] = $how_of_visit;
			$feedback_data['created_time'] = date("Y-m-d H:i:s");
			
			$this->db->insert('feedback', $feedback_data);
			echo $this->db->insert_id();
		}
		else
		{
			echo false;
		}
		die();
	}
	

	/*### change customer password ###*/
	public function changepw()
	{		
		$user_id = $this->input->post('user_id');
		$old_pass = $this->input->post('old_pass');
		$user_pass = $this->input->post('user_pass');
		$updated_date = date("Y-m-d H:i:s");

		if(!empty($user_id) && !empty($old_pass) && !empty($user_pass))
		{
			$data['user_pass'] = md5($user_pass);
			$data['updated_date'] = $updated_date;
			$this->db->where('users.user_id', $user_id);
			$this->db->where('users.user_pass', md5($old_pass));
			if($this->db->update('users', $data))
			{
				echo true;
			}
			else
			{
				echo false;
			}
		}
		else
		{
			echo false;
		}
		die();
	}
	
	
	/*### update customer information ###*/
	public function useredit()
	{		
		$user_id = $this->input->post('user_id');
		$user_name = $this->input->post('user_name');
		$user_phone = $this->input->post('user_phone');
		$user_email = $this->input->post('user_email');
		$updated_date = date("Y-m-d H:i:s");
		
		$user_address = $this->input->post('user_address');
		$user_city = $this->input->post('user_city');
		$user_state = $this->input->post('user_state');

		if(!empty($user_id) && !empty($user_name) && !empty($user_email))
		{
			$data['user_name'] = $user_name;
			$data['user_phone'] = $user_phone;
			$data['user_email'] = $user_email;
			$data['updated_date'] = $updated_date;
			$this->db->where('users.user_id', $user_id);
			if($this->db->update('users', $data))
			{
				update_user_meta($user_id, 'user_address', $user_address);
				update_user_meta($user_id, 'user_city', $user_city);
				update_user_meta($user_id, 'user_state', $user_state);
				
				echo true;
			}
			else
			{
				echo false;
			}
		}
		else
		{
			echo false;
		}
		die();
	}
	
	
	/*### remove category gallery img ###*/
	public function remove_category_gallery_img()
	{
		$category_id = $this->input->post('category_id');
		$gallery_img_id = $this->input->post('gallery_img_id');

		if($gallery_img_id==1)
		{
			$data['category_gallery1'] 	= null;
			$data['target_url1'] 		= null;
		}
		elseif($gallery_img_id==2)
		{
			$data['category_gallery2'] 	= null;
			$data['target_url2'] 		= null;
		}
		elseif($gallery_img_id==3)
		{
			$data['category_gallery3'] 	= null;
			$data['target_url3'] 		= null;
		}
		else
		{
			$data['category_banner'] 	= null;
			$data['banner_target_url'] 	= null;
		}

		$this->db->where('category.category_id', $category_id);
		if($this->db->update('category', $data))
		{
			echo true;
		}
		die();
	}
	
	
	/*### ajax search items ###*/
	public function ajax_search_items()
	{
		$q = $this->input->post('search_query');
		
		$queries = explode(' ', $q);
		//foreach($queries as $qs){ $product_search[] = "`product_title` LIKE '%$qs%'"; }
		foreach($queries as $qs){ $product_search[] = "LOCATE('$qs', product_title)"; }
		//$product_search = implode(" OR ", $product_search);
		$product_search = implode(" AND ", $product_search);
		
		//$sql = "SELECT * FROM `product` WHERE `product_title` LIKE '%$q%' OR $product_search OR `product_price` LIKE '%$q%' OR `product_summary` LIKE '%$q%' OR `product_description` LIKE '%$q%' OR `product_specification` LIKE '%$q%' ORDER BY product_title ASC";
		
		//$sql = "SELECT * FROM `product` WHERE `product_title` LIKE '%$q%' OR $product_search OR `product_price` LIKE '%$q%' OR `product_summary` LIKE '%$q%' OR `product_description` LIKE '%$q%' OR `product_specification` LIKE '%$q%'";
		
		$sql = "SELECT *, $product_search FROM product WHERE $product_search > 0 ORDER BY $product_search";
		
		$result = get_result($sql);
		
		$html='';
		if($result)
		{
			$i=1; foreach($result as $prod)
			{
				$featured_image = $this->global_model->get_row('media', array('media_type' => 'product_image', 'relation_id' => $prod->product_id));
				$product_link = base_url('products/'.$prod->product_name);

				// product price
				$sell_price = !empty($prod->discount_price) ? $prod->discount_price : $prod->product_price;
				
				if($i<=6)
				{
					$html.='<li class="search-item">
						<a href="'.$product_link.'">
							<div class="image">
								<img src="'.get_photo((isset($featured_image->media_path) ? $featured_image->media_path : null), 'uploads/product/','mini_thumbs').'">
							</div>
							<div class="name">'.$prod->product_title.'</div>
							<div class="price">'.formatted_price($sell_price).'</div>
						</a>
					</li>';
				}
				
				$i++;
			}

			if(sizeof($result)>6)
			{
				$html.='<li class="search-item remainder-count"><a href="'.base_url().'search?q='.$q.'">'.(sizeof($result) - 6).' more results</a></li>';
			}
		}
		else
		{
			$html.='<li style="padding:10px;">No results found!</li>';
		}
		
		echo json_encode(array("status"=>"success", "return_value"=>$html));
		die();
	}
	
	
	/*### make a dealer ###*/
	public function make_a_dealer()
	{
		$success = false;
		$type = '';
		
		$row_data						=	array();
		$row_data['user_name']			=	$this->input->post('dealer_name');
		$dealer_email					=	$this->input->post('dealer_email');
		$row_data['user_login']			=	$dealer_email;
		$row_data['user_email']			=	$dealer_email;
		$row_data['user_phone']			=	$this->input->post('dealer_phone');
		$row_data['user_pass']			=	md5(123456);
		$row_data['user_type']			=	'dealer';
		$row_data['registered_date']	=	date('Y-m-d H:i');
		$row_data['updated_date']		=	date('Y-m-d H:i');
		
		if(!email_exists($dealer_email))
		{
			$this->db->insert('users', $row_data);
			$user_id = $this->db->insert_id();
			if($user_id)
			{
				$dealer_address = $this->input->post('dealer_address');
				$dealer_state = $this->input->post('dealer_state');
				$dealer_comment = $this->input->post('dealer_comment');
				
				update_user_meta($user_id, 'user_address', $dealer_address);
				update_user_meta($user_id, 'user_city', '');
				update_user_meta($user_id, 'user_state', $dealer_state);
				update_user_meta($user_id, 'user_comment', $dealer_comment);
				
				$success = true;
			}
		}
		else
		{
			$type = 'duplicate';
		}
		
		echo json_encode(array(
			"success"=>$success,
			"type"=>$type
		));
		die();
	}
}