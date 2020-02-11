<?php
/*### get uri not found data ###*/
function get_uri_not_found_data($uri)
{
	$ci=get_instance();

	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->where('product_name', $uri);
	$query=$ci->db->get();

	if($query->num_rows()>0)
	{
		return $query->row();
	}
	else
	{
		$ci->db->select('*');
		$ci->db->from('post');
		$ci->db->where('post_name', $uri);	
		$query=$ci->db->get();

		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			$ci->db->select('*');
			$ci->db->from('category');
			$ci->db->where('category_name', $uri);	
			$query=$ci->db->get();
			return $query->row();
		}
	}
}


/*
### custom methods ###
*/
/*# nl2p #*/
function nl2p($string, $line_breaks = true, $xml = true)
{
    $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);
 
    if($line_breaks == true)
	{
        return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
	}
    else
	{
        return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
	}
}

/*
### pagination ###
*/
function create_pagination($base_url, $total_rows, $per_page)
{
	$ci=get_instance();
	$ci->load->library('pagination');
	$config['base_url'] 		= $base_url;
	$config['total_rows'] 		= $total_rows;
	$config['per_page'] 		= $per_page;
	$config['use_page_numbers'] = TRUE;
	$config['full_tag_open'] 	= '<ul class="pagination pull-right">';
	$config['full_tag_close'] 	= '</ul>';
	$config['first_link'] 		= '&laquo; First';
	$config['first_tag_open'] 	= '<li class="prev page">';
	$config['first_tag_close'] 	= '</li>';
	$config['last_link'] 		= 'Last &raquo;';
	$config['last_tag_open'] 	= '<li class="next page">';
	$config['last_tag_close'] 	= '</li>';
	$config['next_link'] 		= 'Next &rarr;';
	$config['next_tag_open'] 	= '<li class="next page">';
	$config['next_tag_close'] 	= '</li>';
	$config['prev_link'] 		= '&larr; Previous';
	$config['prev_tag_open'] 	= '<li class="prev page">';
	$config['prev_tag_close'] 	= '</li>';
	$config['cur_tag_open'] 	= '<li class="active"><a href="">';
	$config['cur_tag_close'] 	= '</a></li>';
	$config['num_tag_open'] 	= '<li class="page">';
	$config['num_tag_close'] 	= '</li>';
	$config['enable_query_strings'] 	= true;
	$ci->pagination->initialize($config);
	return $ci->pagination->create_links();
}

function search_pagination($search, $total_rows, $per_page)
{
	$ci=get_instance();
	$ci->load->library('pagination');

    $search = ($ci->uri->segment(3)) ? $ci->uri->segment(3) : $search;

    // pagination settings
    $config = array();
    $config['base_url'] = site_url("pagination/search/$search");
    $config['total_rows'] = $total_rows;
    $config['per_page'] = $per_page;
    $config["uri_segment"] = 4;
    $choice = $config["total_rows"]/$config["per_page"];
    $config["num_links"] = floor($choice);

    // integrate bootstrap pagination
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = false;
    $config['last_link'] = false;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = 'Prev';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $ci->pagination->initialize($config);
	return $ci->pagination->create_links();
}


/*### options ###*/
function get_option($option_name)
{
	$ci=get_instance();
	$ci->db->select('option_value');
	$ci->db->from('options');
	$ci->db->where('option_name', $option_name);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$result = $query->result();
		return $result[0]->option_value;
	}
}
function update_option($option_name, $option_value)
{
	$ci=get_instance();
	$ci->db->select('option_name');
	$ci->db->from('options');
	$ci->db->where('option_name', $option_name);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$ci->db->where('option_name', $option_name);
		$ci->db->update('options', array('option_value'=>$option_value));
	}
	else
	{
		$ci->db->insert('options', array('option_name'=>$option_name, 'option_value'=>$option_value));
	}
}



/*
### media ###
*/
/*# get media path by media_path #*/
function get_media_id($media_path)
{
	$ci=get_instance();
	$ci->db->select('media_id');
	$ci->db->from('media');
	$ci->db->where('media_path', $media_path);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$row=$query->row();
		return $row->media_id;
	}
}
function get_media_path($media_id, $size=NULL)
{
	$ci=get_instance();
	$ci->db->select('media_path');
	$ci->db->from('media');
	$ci->db->where('media_id', $media_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$result = $query->result();
		$media_path = $result[0]->media_path;
		
		if($size=='thumb')
		{
			if(file_exists($media_path))
			{
				$image_info = @getimagesize($media_path);
				$extension = image_type_to_extension($image_info[2]);
				
				$base_url = base_url(str_replace(array('.jpg', '.jpeg', '.png', '.gif', '.JPG', '.JPEG', '.PNG', '.GIF'), array('_thumb.jpg', '_thumb.jpeg', '_thumb.png', '_thumb.gif', '_thumb.JPG', '_thumb.JPEG', '_thumb.PNG', '_thumb.GIF'), $media_path));
				
				return $base_url;
			}
		}
		else
		{
			return base_url($media_path);
		}
	}
}
function get_media_short_path($media_id)
{
	$ci=get_instance();
	$ci->db->select('media_path');
	$ci->db->from('media');
	$ci->db->where('media_id', $media_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$media = $query->row();
		return $media->media_path;
	}
}
function get_adds($type='sidebar', $limit=NULL)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('adds');
	$ci->db->where('adds_type', $type);
		$ci->db->where('status', 1);

	
	$ci->db->order_by('adds_id', 'DESC');
	
	if($limit){ $ci->db->limit($limit); }
	
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}


/*# breadcrumb # */


function get_breadcrumb($id=null, $page='product', $title=null)
{
	$ci = get_instance();
	$res_html = $sub_category_title = NULL;
	
	if($page == 'product')
	{
		$category_title = $product_title = null;
		
		$ci->db->select('term_id');
		$ci->db->from('term_relation');
		$ci->db->where('product_id', $id);
		$query = $ci->db->get();
		if($query->num_rows()>0)
		{
			$categories = $query->result();
			foreach($categories as $cat)
			{
				$category[] = $cat->term_id;
			}
			
			$product_title = '<li >
				<span  >'.$title.'</span>
			</li>';
			
			$ci->db->select('category_title, category_name');
			$ci->db->from('category');
			$ci->db->where_in('category_id', $category);
			$ci->db->order_by('rank_order', 'ASC');
			$ci->db->order_by('category_id', 'ASC');
			$ci->db->limit(2);
			$query=$ci->db->get();
			if($query->num_rows()>0)
			{
				$result = $query->result();
				foreach($result as $row)
				{
					$category_title .= '<li >
						<a href="'.base_url($row->category_name).'"  >
							<span  >'.$row->category_title.'</span>
						</a>
					</li>';
				}
			}
			
			$res_html = $category_title.$product_title;
		}
	}
	elseif($page == 'category')
	{
		$ci->db->select('category_title, parent_id');
		$ci->db->from('category');
		$ci->db->where('category_id', $id);
		$query = $ci->db->get();
		if($query->num_rows()>0)
		{
			$result = $query->result();
			$parent_category_title = '';
			$category_title = '<li >
				<span itemprop="name">'.$result[0]->category_title.'</span>
			</li>';
			
			$parent_id = $result[0]->parent_id;
			
			if($parent_id != 0)
			{
				$ci->db->select('category_title, category_name');
				$ci->db->from('category');
				$ci->db->where('category_id', $parent_id);
				$query=$ci->db->get();
				if($query->num_rows()>0)
				{
					$result = $query->result();
					$parent_category_title = '<li >
						<a href="'.base_url($result[0]->category_name).'" >
							<span >'.$result[0]->category_title.'</span>
						</a>
					</li>';
					
				}
			}
			
			$res_html = $parent_category_title.$category_title;
		}
	}
	elseif($page == 'news')
	{
		$res_html = '<li >
			<a href="'.base_url('news').'" >
				<span >News</span>
			</a>
		</li>
		<li >
			<span >'.$title.'</span>
		</li>';
	}
	elseif($page == 'blog')
	{
		$res_html = '<li >
			<a href="'.base_url('blog').'" itemprop="item">
				<span >Blog</span>
			</a>
		</li>
		<li >
			<span >'.$title.'</span>
		</li>';
	}
	else
	{
		$res_html = '<li >
			<span >'.$title.'</span>
		</li>';
	}
	
	$home = 'you are in: <li >
		<a href="'.base_url().'" >
			<span >Home</span>
		</a>
	</li>';
	
	return '<ul class="breadcrumb" >'.$home.$res_html.'</ul>';
}


/*### query ###*/
# check duplicate entry
function is_duplicate($sql)
{
	$ci=get_instance();
	$query=$ci->db->query($sql);
	if($query->num_rows()>0){ return TRUE; }else{ return FALSE; }
}

# get table data
function get_result($sql)
{
	$ci=get_instance();
	$query=$ci->db->query($sql);
	if($query->num_rows()>0){ return $query->result(); }
}

# get row data of a table
function get_row($table, $field, $value)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from($table);
	$ci->db->where($field, $value);
	$query=$ci->db->get();
	return $query->row();
}

# create new row in a table
function insert($table, $data)
{
	$ci=get_instance();
	if($ci->db->insert($table, $data)){ return $ci->db->insert_id(); }
}

/*
### users info ###
*/
function get_notification($user_id){
	$ci=get_instance();
	$ci->db->select('type');
	$ci->db->from('notification');
	$ci->db->where('user_id', $user_id);
	$ci->db->where('viewed', '0');
	$query=$ci->db->get();
	return count($query->result());
}


/*
### users helpers ###
@ user - it can be user id or username
@ if user is user id then need not second parameter
@ if user is username the second parameter should be true
*/
function is_user($user, $user_login=FALSE)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('users');
	if($user_login==TRUE){ $ci->db->where('user_login', $user); }else{ $ci->db->where('user_id', $user); }
	$query=$ci->db->get();
	if($query->num_rows()>0){ return TRUE; }else{ return FALSE; }
}
function is_used_username($username)
{
	$ci=get_instance();
	$ci->db->select('user_name');
	$ci->db->from('users');
	$ci->db->where('user_login', $username);
	$query=$ci->db->get();
	$result=$query->result();
	if(!empty($result[0]->user_name)){ return TRUE; }else{ return FALSE; }
}
function get_user_id_by_user_login($user_login)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('users');
	$ci->db->where('user_login', $user_login);
	$query=$ci->db->get();
	if($query->num_rows()>0){
		$user=$query->result();
		return $user[0]->user_id;
	}
}
function get_user_name($user_id)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('users');
	$ci->db->where('user_id', $user_id);
	$query=$ci->db->get();
	if($query->num_rows()>0){
		$user=$query->result();
		return $user[0]->user_name;
	}
}
function get_user($user_id, $field)
{
	$ci=get_instance();
	$ci->db->select($field);
	$ci->db->from('users');
	$ci->db->where('user_id', $user_id);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$user=$query->result();
		return $user[0]->$field;
	}
}
function email_exists($user_login)
{
	$ci=get_instance();
	$ci->db->select('user_login');
	$ci->db->from('users');
	$ci->db->where('user_login', $user_login);
	$total_users = $ci->db->count_all_results();
	if($total_users>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function insert_user_meta($user_id, $meta_key, $meta_value)
{
	$ci=get_instance();
	$ci->db->select('meta_value');
	$ci->db->from('usermeta');
	$ci->db->where('user_id', $user_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()==0)
	{
		$ci->db->insert('usermeta', array(
			'user_id'=>$user_id,
			'meta_key'=>$meta_key,
			'meta_value'=>$meta_value
		));
	}
}
function update_user_meta($user_id, $meta_key, $meta_value)
{
	$ci=get_instance();
	$ci->db->select('meta_value');
	$ci->db->from('usermeta');
	$ci->db->where('user_id', $user_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$ci->db->where('user_id', $user_id);
		$ci->db->where('meta_key', $meta_key);
		$ci->db->update('usermeta', array('meta_value'=>$meta_value));
	}
	else
	{
		$ci->db->insert('usermeta', array(
			'user_id'=>$user_id,
			'meta_key'=>$meta_key,
			'meta_value'=>$meta_value
		));
	}
}
function get_user_meta($user_id, $meta_key)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('usermeta');
	$ci->db->where('user_id', $user_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$usermeta=$query->result();
		return $usermeta[0]->meta_value;
	}
}

/*# get total users #*/
function get_users_total($user_type)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('users');
	$ci->db->where('user_type', $user_type);
	return $ci->db->count_all_results();
}


/*
### table page ###
*/
function is_page_link($page_link)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('page');
	$ci->db->where('page_link', $page_link);
	$query=$ci->db->get();
	if($query->num_rows()>0){ return TRUE; }
}

function get_page_link($page_id)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('page');
	$ci->db->where('page_id', $page_id);
	$query=$ci->db->get();
	if($query->num_rows()>0){ $page=$query->result(); return $page[0]->page_link; }
}

function get_page_data($page_field, $page_link, $page_id=FALSE)
{
	$ci=get_instance();
	$ci->db->select($page_field);
	$ci->db->from('page');
	if($page_id==TRUE){ $ci->db->where('page_id', $page_link); }
	else{ $ci->db->where('page_link', $page_link); }
	$query=$ci->db->get();
	if($query->num_rows()>0){ $page=$query->result(); return $page[0]->$page_field; }
}


/*
	### formatted date ###
*/
function formatted_date($date)
{
	$strtotime=strtotime($date);
	$day=date("d",$strtotime);
	$month=date("F",$strtotime);
	$year=date("Y",$strtotime);
	echo $month.' '.$day.' '.$year;
}
function get_formatted_date($date)
{
	$strtotime=strtotime($date);
	$day=date("d",$strtotime);
	$month=date("F",$strtotime);
	$year=date("Y",$strtotime);
	return $month.' '.$day.' '.$year;
}


/*
### front-end settings ###
*/
function social_link($req)
{
	return '#';
}


/*
### hitcounter ###
*/
function create_hitcounter()
{
	$ci = get_instance();
	$data['client_ip'] = $_SERVER["REMOTE_ADDR"];
	$data['date'] = date("Y-m-d");
	
	$ci->db->select('hitcounter_id');
	$ci->db->from('hitcounter');
	$ci->db->where('client_ip', $data['client_ip']);
	$ci->db->where('date', $data['date']);
	$query = $ci->db->get();
	
	
	
}
function get_hitcounters($date)
{
	$ci = get_instance();
	$ci->db->select('*');
	$ci->db->from('hitcounter');
	$ci->db->where('date', $date);
	$query = $ci->db->get();
	return $query->result();
}
function get_hitcounters_by_limit($date, $date_to)
{
	$ci = get_instance();
	$ci->db->select('*');
	$ci->db->from('hitcounter');
	$ci->db->where('date >=', $date);
	$ci->db->where('date <=', $date_to);
	$query = $ci->db->get();
	return $query->result();
}

function get_assign_terms($user_id)
{
	$ci = get_instance();

	$access_terms = array('0');

	$product_manager_access_terms = $ci->global_model->get('product_manager_access_terms', array('user_id' => $user_id));

	if(!empty($product_manager_access_terms))
	{
		foreach ($product_manager_access_terms as $access_term)
		{
			$access_terms[] = $access_term->term_id;
		}
	}

	return $access_terms;
}

function category_name_show($parent_id)
{
	$ci = get_instance();
	$ci->db->select('*');
	$ci->db->from('category');
	$ci->db->where('category_id', $parent_id);
	$query = $ci->db->get();
$result= $query->row();
return $result->category_title;
}