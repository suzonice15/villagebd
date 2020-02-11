<?php
Class WishlistModel extends CI_Model
{
	public function get_products($ids=array())
	{
        $this->db->select('*');
        $this->db->from('product');
		$this->db->where_in('product_id', $ids);
		$query = $this->db->get();
		return $query->result();
    }
}