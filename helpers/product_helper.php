<?php
function get_live_products($limit=null)
{
	date_default_timezone_set("Asia/Dhaka");

	$ci=get_instance();

	$today = date('Y-m-d');

	$params = array(
		'is_live_promo' => 1
	);

	$limit_params = array();

	if(!empty($limit))
	{
		$limit_params = array(
			'limit' => $limit,
			'start' => 0
		);		
	}

	$orderby_params = array(
		'field' => 'product_id',
		'order' => 'DESC'
	);

	return $ci->global_model->get('product', $params, '*', $limit_params, $orderby_params);
}

function product_terms($product_id)
{
	$ci=get_instance();
    $ci->db->select('term_id');
    $ci->db->from('term_relation');
    $ci->db->where('product_id', $product_id);
    $query = $ci->db->get();
    return $query->result();
}

function formatted_price($price, $show_money_symbole=true)
{
	if($show_money_symbole==true)
	{
		$html = '৳ '.number_format($price);
		
		if(empty(trim($price)) || trim($price)==null || trim($price)=='')
		{
			$html = get_option('price_alter_message');
		}
	}
	else
	{
		$html = '৳ '.number_format($price);
	}
	
	return $html;
}


/*# brands #*/
function get_brands()
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('brand');
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}


/*# get main categories #*/
function get_categories($sub='yes')
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('category');
	if($sub=='no'){$ci->db->where('parent_id', 0);}
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}

/*# get sub categories #*/
function get_subcategories($category_id, $pcbuilder_category=null)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('category');
	$ci->db->where('status', 1);
	$ci->db->where('parent_id', $category_id);
	if($pcbuilder_category!=null){ $ci->db->where('pcbuilder_category', $pcbuilder_category); }
	$ci->db->order_by('rank', 'ASC');
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}

/*# get category_id by category_name #*/
function get_category_id($category_name)
{
	$ci=get_instance();
	$ci->db->select('category_id');
	$ci->db->from('category');
	$ci->db->where('category_name', $category_name);
	$query=$ci->db->get();
	if($query->num_rows() > 0)
	{
		$row=$query->result();
		return $row[0]->category_id;
	}
}
function get_sub_category_id($parent_id, $category_name)
{
	$ci=get_instance();
	$ci->db->select('category_id');
	$ci->db->from('category');
	$ci->db->where('category_name', $category_name);
	$ci->db->where('parent_id', $parent_id);
	$query=$ci->db->get();
	if($query->num_rows() > 0)
	{
		$row=$query->result();
		return $row[0]->category_id;
	}
}
function get_category_title($category_id)
{
	$ci=get_instance();
	$ci->db->select('category_title');
	$ci->db->from('category');
	$ci->db->where('category_id', $category_id);
	$query=$ci->db->get();
	if($query->num_rows() > 0)
	{
		$row=$query->row();
		return $row->category_title;
	}
}
function get_category_name($category_id)
{
	$ci=get_instance();
	$ci->db->select('category_name');
	$ci->db->from('category');
	$ci->db->where('category_id', $category_id);
	$query=$ci->db->get();
	if($query->num_rows() > 0)
	{
		$row=$query->row();
		return $row->category_name;
	}
}
function get_category_info($category_id)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('category');
	$ci->db->where('category_id', $category_id);
	$query=$ci->db->get();
	if($query->num_rows() > 0)
	{
		return $query->row();
	}
}

/*# nested category list #*/
function nested_category_list($parent, $category)
{
	$html = "";
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<li class="'.$category['categories'][$cat_id]->category_name.'">
					<a href="'.base_url($category['categories'][$cat_id]->category_name).'">
						'.$category['categories'][$cat_id]->category_title.'
					</a>
				</li>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<li class="'.$category['categories'][$cat_id]->category_name.' dropdown dropdown-submenu">
					<a href="'.base_url($category['categories'][$cat_id]->category_name).'">
						'.$category['categories'][$cat_id]->category_title.' <span class="caret desktop"></span>
					</a>
					<ul class="dropdown-menu">';
						$html .= nested_category_list($cat_id, $category);
					$html .= '</ul>
					<span class="caret mobile"></span>
				</li>';
			}
		}
	}
	
	return $html;
}

/*# nested category checkbox list #*/
function check_is_checked($cat_id, $terms)
{
	foreach($terms as $term)
	{
		if($term->term_id == $cat_id){ return 'checked'; }
	}
}

function nested_category_checkbox_list($parent, $category, $terms)
{
	$html = "";
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_checked = check_is_checked($cat_id, $terms);
			
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<li><label><input type="checkbox" name="categories[]" value="'.$cat_id.'" '.$is_checked.'>'.$category['categories'][$cat_id]->category_title.'</label></li>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<li class="submenu"><label><input type="checkbox" name="categories[]" value="'.$cat_id.'" '.$is_checked.'>'.$category['categories'][$cat_id]->category_title.'</label><ul>';
					$html .= nested_category_checkbox_list($cat_id, $category, $terms);
				$html .= '</ul></li>';
			}
		}
	}
	
	return $html;
}

/*# nested category options #*/
function nested_category_options($parent, $category)
{
	$search_cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	
	if(!$search_cat)
	{
		$search_cat = isset($_GET['sortbycat']) ? $_GET['sortbycat'] : null;
	}

	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_selected = ($search_cat==$cat_id) ? 'selected' : '';
		
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>'.$category['categories'][$cat_id]->category_title.'</option>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>'.$category['categories'][$cat_id]->category_title.'</option>';
				
				$html .= nested_category_options2($cat_id, $category);
			}
			
		}
		
		return $html;
	}
	
}
function nested_category_options2($parent, $category)
{
	$search_cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	
	if(!$search_cat)
	{
		$search_cat = isset($_GET['sortbycat']) ? $_GET['sortbycat'] : null;
	}

	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_selected = ($search_cat==$cat_id) ? 'selected' : '';
			
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
				
				$html .= nested_category_options3($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_options3($parent, $category)
{
	$search_cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	
	if(!$search_cat)
	{
		$search_cat = isset($_GET['sortbycat']) ? $_GET['sortbycat'] : null;
	}

	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_selected = ($search_cat==$cat_id) ? 'selected' : '';
			
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
				
				$html .= nested_category_options4($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_options4($parent, $category)
{
	$search_cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	
	if(!$search_cat)
	{
		$search_cat = isset($_GET['sortbycat']) ? $_GET['sortbycat'] : null;
	}

	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_selected = ($search_cat==$cat_id) ? 'selected' : '';
			
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
				
				$html .= nested_category_options5($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_options5($parent, $category)
{
	$search_cat = isset($_GET['cat']) ? $_GET['cat'] : null;
	
	if(!$search_cat)
	{
		$search_cat = isset($_GET['sortbycat']) ? $_GET['sortbycat'] : null;
	}

	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			$is_selected = ($search_cat==$cat_id) ? 'selected' : '';
			
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html .= '<option value="'.$cat_id.'" '.$is_selected.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$category['categories'][$cat_id]->category_title.'</option>';
				
				$html .= nested_category_options5($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}


/*# nested category tr #*/
function nested_category_tr2($parent, $category)
{
	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>'.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>'.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
				
				$html .= nested_category_tr2a($cat_id, $category);
			}
			
		}
		
		return $html;
	}
	
}
function nested_category_tr2a($parent, $category)
{
	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
				
				$html .= nested_category_tr2b($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_tr2b($parent, $category)
{
	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;-- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;-- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
				
				$html .= nested_category_tr2c($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_tr2c($parent, $category)
{
	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;--- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;--- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
				
				$html .= nested_category_tr2d($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}
function nested_category_tr2d($parent, $category)
{
	$html=null;
	
	if(isset($category['parent_cats'][$parent]))
	{
		foreach($category['parent_cats'][$parent] as $cat_id)
		{
			if(!isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;---- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
			}
			
			if(isset($category['parent_cats'][$cat_id]))
			{
				$html.='<tr>
					<td>
						<input type="checkbox" name="checkbox[]" id="checkbox[]" class="checkbox1" value="'.$cat_id.'" />
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;---- '.$category['categories'][$cat_id]->category_title.'</td>
					<td>'.$category['categories'][$cat_id]->category_name.'</td>
					<td class="action text-right">
						<a href="'.base_url().'admin/category/update/'.$cat_id.'">Update</a>
						<a href="'.base_url().'admin/category/delete/'.$cat_id.'" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>
					</td>
				</tr>';
				
				$html .= nested_category_tr2d($cat_id, $category);
			}
		}
		
		return $html;
	}
	
}



/*
### product ###
*/
function get_product_title($product_id)
{
	$ci=get_instance();
	$ci->db->select('product_title');
	$ci->db->from('product');
	$ci->db->where('product_id', $product_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$row = $query->row();
		return $row->product_title;
	}
}
/*# get featured products #*/
function get_featured_products($order_type, $limit, $initial_limit=NULL)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->order_by('product_id', $order_type);
	
	if(!empty($initial_limit))
	{
		$ci->db->limit($initial_limit, $limit);
	}
	else
	{
		$ci->db->limit($limit);
	}
	
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}

/*# get category products #*/
function get_category_products($category_id, $limit, $initial_limit=NULL, $product_type=NUL)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->join('term_relation', 'product.product_id = term_relation.product_id');
	$ci->db->where('term_relation.term_id', $category_id);
	
	if(!empty($product_type))
	{
		$ci->db->where('product.product_type', $product_type);
	}
	
	$ci->db->order_by('product.modified_time', 'DESC');

	if(!empty($initial_limit))
	{
		$ci->db->limit($initial_limit, $limit);
	}
	else
	{
		$ci->db->limit($limit);
	}
	
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}

/*# get product detail by product_id #*/
function get_product($product_id)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->where('product_id', $product_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->row();
	}
}

/*# get default product image #*/
function get_default_product_image()
{
	return base_url('images/default_product_image.png');
}

/*# update discount #*/
function update_product_discount()
{
	$ci=get_instance();
	$ci->db->where('product.discount_to <', date('Y-m-d'));
	$ci->db->update('product', array('product_discount' => ''));
}

/*# get product detail by product_id #*/
function get_term_id_by_product_id($product_id)
{
	$ci=get_instance();
	$ci->db->select('term_id');
	$ci->db->from('term_relation');
	$ci->db->where('product_id', $product_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$row=$query->row();
		return $row->term_id;
	}
}

/*# get total products #*/
function get_products_total()
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('product');
	return $ci->db->count_all_results();
}

/*# set to customer recent view #*/
function set_to_customer_recent_view($product_id)
{
	$ci=get_instance();
	$recent_view = array();
	
	if($ci->session->userdata('recent_view'))
	{
		$recent_view = $ci->session->userdata('recent_view');
	}
	
	array_push($recent_view, $product_id);
	
	$recent_view = array_unique($recent_view);
	
	$ci->session->set_userdata('recent_view', $recent_view);
}

/*# get customer recent view products #*/
function get_customer_recent_view_products($product_ids)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->where_in('product_id', $product_ids);
	$ci->db->order_by('product_id', 'DESC');
	$ci->db->limit(6);
	
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}

/*# set product top view #*/
function set_product_top_view($product_id, $term_id)
{
	$ci = get_instance();
	$data['product_id'] = $product_id;
	$data['term_id'] = $term_id;
	$data['client_ip'] = $_SERVER["REMOTE_ADDR"];
	$data['date'] = date("Y-m-d");
	
	//$ci->db->insert('top_view_product', $data);
	
	$ci->db->select('view_id');
	$ci->db->from('top_view_product');
	$ci->db->where('product_id', $data['product_id']);
	$ci->db->where('client_ip', $data['client_ip']);
	$ci->db->where('date', $data['date']);
	$query = $ci->db->get();
	if($query->num_rows() <= 0)
	{
		$ci->db->insert('top_view_product', $data);
	}
}
function get_top_view_products()
{
	$ci = get_instance();
	$ci->db->select('*, COUNT(*) as top_view');
	$ci->db->from('top_view_product');
	$ci->db->group_by('product_id');
	$ci->db->order_by('top_view', 'DESC'); 
	$ci->db->limit(10);
	$query = $ci->db->get();
	return $query->result();
}
function get_top_view_products_by_terms($terms)
{
	$ci = get_instance();
	$ci->db->select('*, COUNT(*) as top_view');
	$ci->db->from('top_view_product');
	$ci->db->group_by('product_id');
	$ci->db->like('term_id', $terms, 'both');
	$ci->db->order_by('top_view', 'DESC'); 
	$ci->db->limit(10);
	$query = $ci->db->get();
	return $query->result();
}


/*# get total unread orders #*/
function get_total_unread_orders()
{
	$ci=get_instance();
	$ci->db->select('order_id');
	$ci->db->from('order');
	$ci->db->where('view_status', 'unread');
	$ci->db->where_in('order_status', array('new', 'processing'));
	$query=$ci->db->get();
	return $query->num_rows();
}


/*### pcbuilder ###*/
function get_component_name($component_id)
{
	$components = unserialize(get_option('pcbuilder_settings'));

	if(sizeof($components)>0)
	{
		foreach($components as $component)
		{
			if($component['component_id']==$component_id)
			{
				return $component['component_name'];
				break;
			}
		}
	}
}