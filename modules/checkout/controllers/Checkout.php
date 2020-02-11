<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
        
		$this->load->library('email');
		$this->load->library('cart');
		$this->load->model('CheckoutModel', 'checkout');
	}

	public function index()
	{		
		$data 						= array();
		$data['page_title'] 		= 'Checkout';
		
		if($this->input->post())
		{			
			$this->form_validation->set_rules('billing_name', 'customer name', 'trim|required')
			->set_rules('billing_phone', 'customer phone', 'trim|required')
			->set_rules('billing_email', 'customer email', 'trim|required')
			->set_rules('billing_address', 'customer address', 'trim|required')
			->set_rules('billing_city', 'customer city', 'trim|required')
			->set_rules('billing_state', 'customer state', 'trim|required')
			->set_rules('payment_type', 'payment type', 'trim|required')
			->set_rules('terms_and_conditions', 'terms & conditions', 'trim|required')
			->set_rules('emi', 'emi', 'trim|required')
			;
			
			if ($this->form_validation->run())
			{
				$posts 				= $this->input->post();
				//echo '<pre>'; print_r($posts); echo '</pre>';exit;
				$this->session->set_userdata('checkout_form_data', $posts);
				
				$shipping_charge 	= $this->input->post('shipping_charge');
				$order_note 		= $this->input->post('order_note');
				$payment_type 		= $this->input->post('payment_type');
				$emi 				= $this->input->post('emi');
				$order_total 		= $this->input->post('order_total');
				$products 			= $this->input->post('products');

				$billing_name		= $this->input->post('billing_name');
				$billing_phone		= $this->input->post('billing_phone');
				$billing_email		= $this->input->post('billing_email');
				$billing_address	= $this->input->post('billing_address');
				$billing_city		= $this->input->post('billing_city');
				$billing_state		= $this->input->post('billing_state');
				$coupon_code		= $this->input->post('coupon_code');

				$billing_country	= 'Bangladesh';
				
				$row_data						= array();
				$row_data['order_total']		= $order_total;
				$row_data['emi']				= $emi == 'with_emi' ? 1 : 0;
				$row_data['products']			= serialize($products);
				$row_data['payment_type']		= $payment_type;
				$row_data['billing_name']		= $billing_name;
				$row_data['billing_phone']		= $billing_phone;
				$row_data['billing_email']		= $billing_email;
				$row_data['billing_address']	= $billing_address;
				$row_data['billing_city']		= $billing_city;
				$row_data['billing_state']		= $billing_state;
				$row_data['billing_country']	= $billing_country;
				$row_data['shipping_charge']	= $shipping_charge;
				$row_data['order_note']			= $order_note;
				$row_data['coupon_code']		= $coupon_code;

				$row_data['created_time']		= date("Y-m-d H:i:s");
				$row_data['modified_time']		= date("Y-m-d H:i:s");

				// update user meta
				if($this->session->user_id)
				{
					update_user_meta($this->session->user_id, 'billing_name', $billing_name);
					update_user_meta($this->session->user_id, 'billing_phone', $billing_phone);
					update_user_meta($this->session->user_id, 'billing_email', $billing_email);
					update_user_meta($this->session->user_id, 'billing_address', $billing_address);
					update_user_meta($this->session->user_id, 'billing_city', $billing_city);
					update_user_meta($this->session->user_id, 'billing_state', $billing_state);
				}

				if($payment_type=='cash_on_delivery')
				{
					$order_id = $this->checkout->place_order($row_data);

					if($order_id)
					{
						redirect('checkout/thank-you/?order_id='.$order_id, 'refresh');
					}
					else
					{
						redirect('checkout/thank-you/?order_id=', 'refresh');
					}
				}
				else
				{ 
					$post_data 					= array();
					$post_data['store_id'] 		= SSLCZ_STORE_ID;
					$post_data['store_passwd'] 	= SSLCZ_STORE_PASSWD;
					$post_data['total_amount'] 	= str_replace(',', '', $order_total);
					$post_data['currency'] 		= "BDT";
					$post_data['tran_id'] 		= uniqid()."_sslc";
					$post_data['success_url'] 	= base_url('sslcommerz/validate');
					$post_data['fail_url']		= base_url('sslcommerz/failed');
					$post_data['cancel_url']	= base_url('sslcommerz/cancled');
					
					# $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

					# EMI INFO
					# $post_data['emi_option'] = "0"; 	if "1" then remove comment emi_max_inst_option and emi_selected_inst
					# $post_data['emi_max_inst_option'] = "9";
					# $post_data['emi_selected_inst'] = "9";

					# CUSTOMER INFORMATION
					$post_data['cus_name'] 		= $billing_name;
					$post_data['cus_email'] 	= $billing_email;
					$post_data['cus_add1'] 		= $billing_address;
					$post_data['cus_add2'] 		= "";
					$post_data['cus_city'] 		= $billing_city;
					$post_data['cus_state'] 	= $billing_state;
					$post_data['cus_country'] 	= $billing_country;
					$post_data['cus_phone'] 	= $billing_phone;
					$post_data['cus_fax'] 		= "";

					# SHIPMENT INFORMATION
					$post_data['ship_name'] 	= $billing_name;
					$post_data['ship_add1 '] 	= $billing_address;
					$post_data['ship_add2'] 	= "";
					$post_data['ship_city'] 	= $billing_city;
					$post_data['ship_state'] 	= $billing_state;
					$post_data['ship_country'] 	= $billing_country;

					# OPTIONAL PARAMETERS
					// $post_data['value_a'] 		= "ref001";
					// $post_data['value_b '] 		= "ref002";
					// $post_data['value_c'] 		= "ref003";
					// $post_data['value_d'] 		= "ref004";

					# CART PARAMETERS
					$cart_items = array();

					if(isset($products['items']) && sizeof($products['items'])>0)
					{
						foreach($products['items'] as $item_id=>$item)
						{
							$cart_items[] = array('product'=>$item['name'], 'amount'=>str_replace(',', '', $item['subtotal']));
						}
					}

					$post_data['cart'] = json_encode($cart_items);

					$post_data['product_amount'] = "100";
					$post_data['vat'] = "5";
					$post_data['discount_amount'] = "5";
					$post_data['convenience_fee'] = "3";

					$this->session->set_userdata('tarndata', array(
						'tran_id' 	=> $post_data['tran_id'],
						'amount' 	=> $post_data['total_amount'],
						'currency' 	=> $post_data['currency']
					));

					// echo '<pre>'; print_r($products); echo '</pre>';
					// echo '<pre>'; print_r($post_data['cart']); echo '</pre>';
					// echo '<pre>'; print_r($post_data); echo '</pre>';
					// exit;

					if($this->sslcommerz->RequestToSSLC($post_data))
					{
						echo "Pending";
						/***************************************
						# Change your database status to Pending.
						****************************************/
					}
				}
			}
		}

		$this->load->view('header', $data);
		$this->load->view('checkout', $data);
		$this->load->view('footer', $data);
	}
	
	public function coupon_check(){
	    
	   $product_ids=$this->input->post('product_ids');
	           $product_ids_array = explode(",", $this->input->get_post('product_ids'));

	   $product_qtys = explode(",", $this->input->get_post('quantitys'));
	   $pqty = array_combine($product_ids_array, $product_qtys);


	   $coupon_code=$this->input->post('coupon_code');
	   $total_coupon_price=0;
	    $total_product_price=0;
	    $coupon_discount=0;
	    $total=0;
	    $result=$this->checkout->coupon_check($coupon_code);
	    if($result){
	     $products=$this->checkout->coupon_product($product_ids,$coupon_code);
	     if($products){
	         
	         foreach($products as $results){ 
	             $qty = $pqty[$results->product_id];
	         
	          $discont_price=$results->discount_price;
	           $product_price=$results->product_price;
	          if($discont_price){
	              $total_product_price=$discont_price;
	          } else {
	               $total_product_price=$product_price;
	          }
	         
	        $coupon_status= $results->coupon_status;
	        $coupon_mony= $results->coupon_price;
	        if($coupon_status=='percent'){
	            $coupon_discount=$qty*(($coupon_mony * $total_product_price)/100 );
	        } else {
	            $coupon_discount=$qty*$coupon_mony;
	        }
	        
	        $total =$total+$coupon_discount; 
	      }
	      
	      echo '-'.$total;
	    } else {
	        echo 'There are no discount in this coupon.';
	    }
	    
	    }
	    else {
	           echo $result;
	    }

	 
	    
	    }


	public function thank_you()
	{
		$data 						= array();
		$data['sidebar'] 			= $this->load->view('sidebar', $data, true);
		$data['page_title'] 		= 'Thank You';
		
		$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

		$cfdata = $this->session->userdata('checkout_form_data');
		//echo '<pre>'; print_r($cfdata); echo '</pre>';

		$row_data						= array();
		$row_data['order_total']		= $cfdata['order_total'];
		$row_data['emi']				= $cfdata['emi'] == 'with_emi' ? 1 : 0;
		$row_data['order_status']		= 'processing';
		$row_data['payment_type']		= $cfdata['payment_type'];
		$row_data['products']			= serialize($cfdata['products']);
		$row_data['billing_name']		= $cfdata['billing_name'];
		$row_data['billing_phone']		= $cfdata['billing_phone'];
		$row_data['billing_email']		= $cfdata['billing_email'];
		$row_data['billing_address']	= $cfdata['billing_address'];
		$row_data['billing_city']		= $cfdata['billing_city'];
		$row_data['billing_state']		= $cfdata['billing_state'];
		$row_data['order_note']			= $cfdata['order_note'];
		$row_data['billing_country']	= 'Bangladesh';
		$row_data['created_time']		= date("Y-m-d H:i:s");
		$row_data['modified_time']		= date("Y-m-d H:i:s");
		
		if(isset($_GET['directpay']) && $_GET['directpay']=='success')
		{
			if($this->session->userdata('sslcommerz_data'))
			{
				$ssldata 	= $this->session->userdata('sslcommerz_data');
				//echo '<pre>'; print_r($ssldata); echo '</pre>';

				$row_data['sslcommerz'] = serialize($ssldata);

				$order_id = $this->checkout->place_order($row_data);
			}
		}

		if($order_id)
		{
			$order 			= $this->checkout->order_items_review($order_id);
			$data['order'] 	= $order;
			$product_items 	= unserialize($order->products);

			// send order confirmation email to customer and admin
			$shipping_charge 		= $order->shipping_charge;
			$shipping_charge 		= ($shipping_charge!='') ? $shipping_charge : 0;
			
			$order_note 			= $order->order_note;

			$customer_email 		= $row_data['billing_email'];
			$admin_emails 			= 'esell@village-bd.com,obaida@village-bd.com,taufiq@village-bd.com,babu.village@gmail.com,sujon@village-bd.com';

			$customer_email_heading = '<h1>Thank you. Your order has been received. please wait for phone call.</h1>';
			$admin_email_heading 	= '<h1>New Order Notification</h1>';
			
			$email_body='<div class="row">
				<div class="col-sm-12">
					<div style="border:1px solid #ddd;">
						<div style="padding:10px;color:#333;background-color:#f5f5f5;border-color:#ddd;">
							<h3 style="margin-top:0;margin-bottom:0;font-size:16px;color:inherit;">Customer Details</h3>
						</div>
						<div style="padding:15px;">
							<table class="table table-striped table-bordered table-hover">
							<tbody>
								<tr>
									<td>
										<p><b>Name:</b> '.$order->billing_name.'</p>
										<p><b>Phone:</b> '.$order->billing_phone.'</p>
										<p><b>Email:</b> '.$order->billing_email.'</p>
										<p>
											<b>Address:</b><br/>
											'.$order->billing_address.'<br/>
											'.$order->billing_city.',<br/>
											'.$order->billing_state.', Bangladesh
										</p>
									</td>
								</tr>
							</tbody>
							</table>
						</div>
					</div>
					<div style="border:1px solid #ddd;">
						<div style="padding:10px;color:#333;background-color:#f5f5f5;border-color:#ddd;">
							<h3 style="margin-top:0;margin-bottom:0;font-size:16px;color:inherit;">Order Details</h3>
						</div>
						<div style="padding:15px;">
							<div class="cart-info">
								<table cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #ddd;">
									<tr style="background:#f9f9f9;">
										<th style="width:50%;padding:8px;border:1px solid #ddd;">Product</th>
										<th style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">Price</th>
									</tr>';
									
									foreach($product_items['items'] as $product_id=>$item)
									{
										$featured_image = isset($item['featured_image']) ? $item['featured_image'] : null;
										
										$email_body.='<tr>
											<td style="width:50%;padding:8px;border:1px solid #ddd;">
												<img src="'.$featured_image.'" height="50" width="50" style="float:left;margin-right:10px;"/>
												<div class="item-name-and-price">
													<div class="item-name">'.$item['name'].'</div>
													<div class="item-price">Tk '.$item['price'].' x '.$item['qty'].'</div>
												</div>
											</td>
											<td style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">Tk '.$item['subtotal'].'</td>
										</tr>';
									}
									
								$email_body.='</table>
								<table cellpadding="0" cellspacing="0" style="width:100%;border:1px solid #ddd;">
									<tbody>
										<tr style="background:#f9f9f9;">
											<td style="width:50%;padding:8px;border:1px solid #ddd;">
												<span class="extra bold">Payment method</span>
											</td>
											<td style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">
												<span class="bold">'.ucwords(str_replace("_", " ", $order->payment_type)).'</span>
											</td>
										</tr>
										<tr>
											<td style="width:50%;padding:8px;border:1px solid #ddd;">
												<span class="extra bold">Order number</span>
											</td>
											<td style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">
												<span class="bold">'.($order_id < 10 ? 0 : '').$order_id.'</span>
											</td>
										</tr>
										<tr style="background:#f9f9f9;">
											<td style="width:50%;padding:8px;border:1px solid #ddd;">
												<span class="extra bold totalamout">Shipping Charge</span>
											</td>
											<td style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">
												<span class="bold totalamout">Tk '.$shipping_charge.'</span>
											</td>
										</tr>
										<tr style="background:#f9f9f9;">
											<td style="width:50%;padding:8px;border:1px solid #ddd;">
												<span class="extra bold totalamout">Total</span>
											</td>
											<td style="width:50%;padding:8px;border:1px solid #ddd;text-align:right;">
												<span class="bold totalamout">Tk '.$order->order_total.'</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>';
			
			// customer email
			$config['protocol'] = 'sendmail';
			$config['charset'] 	= 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$customer_email_body 	= $customer_email_heading.$email_body;
			$admin_email_body 		= $admin_email_heading.$email_body;

			$this->email->from("info@village-bd.com", 'Computer Village');
			$this->email->to($customer_email);
			$this->email->subject('Order Confirmation');
			
			$this->email->message($customer_email_body); 
			$this->email->send();
			$this->email->clear(TRUE);
			
			// admin email
			$config['protocol'] = 'sendmail';
			$config['charset'] 	= 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			
			$this->email->from("info@village-bd.com", 'Computer Village');
			$this->email->to($admin_emails);
			$this->email->subject('New Order Notification');
			
			$this->email->message($admin_email_body); 
			$this->email->send();
			$this->email->clear(TRUE);

			$this->session->set_userdata('checkout_form_data', null);
			$this->session->set_userdata('sslcommerz_data', null);

			$this->cart->destroy();
		}
		
		$this->load->view('header', $data);
		$this->load->view('thank_you', $data);
		$this->load->view('footer', $data);
	}
}