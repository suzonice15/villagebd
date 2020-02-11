<?php
function get_review($product_id, $rating=null)
{
	$ci=get_instance();
	$ci->db->select('*');
	$ci->db->from('review');
	$ci->db->where('product_id', $product_id);
	$ci->db->order_by('review.review_id', 'DESC');
	if($rating!=null){$ci->db->where('rating', $rating);}
	$query=$ci->db->get();
	if($query->num_rows()>0)
	{
		return $query->result();
	}
}