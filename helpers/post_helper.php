<?php
/*### post ###*/
function get_post($by, $val)
{
	$ci=get_instance();

	$ci->db->select('*');
	$ci->db->from('product');
	$ci->db->where('product_name', $val);	
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->row();
	}
	else
	{
		$ci->db->select('*');
		$ci->db->from('post');
		$ci->db->where($by, $val);	
		$query=$ci->db->get();
		return $query->row();
	};
}


/*### post meta ###*/
function insert_post_meta($post_id, $meta_key, $meta_value)
{
	$ci=get_instance();
	$ci->db->select('meta_value');
	$ci->db->from('postmeta');
	$ci->db->where('post_id', $post_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()==0)
	{
		$ci->db->insert('postmeta', array(
			'post_id'=>$post_id,
			'meta_key'=>$meta_key,
			'meta_value'=>$meta_value
		));
	}
}
function update_post_meta($post_id, $meta_key, $meta_value)
{
	$ci=get_instance();
	$ci->db->select('meta_value');
	$ci->db->from('postmeta');
	$ci->db->where('post_id', $post_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$ci->db->where('post_id', $post_id);
		$ci->db->where('meta_key', $meta_key);
		$ci->db->update('postmeta', array('meta_value'=>$meta_value));
	}
	else
	{
		$ci->db->insert('postmeta', array(
			'post_id'=>$post_id,
			'meta_key'=>$meta_key,
			'meta_value'=>$meta_value
		));
	}
}
function get_post_meta($post_id, $meta_key)
{
	$ci=get_instance();
	$ci->db->select('meta_value');
	$ci->db->from('postmeta');
	$ci->db->where('post_id', $post_id);
	$ci->db->where('meta_key', $meta_key);
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		$row=$query->row();
		return $row->meta_value;
	}
}