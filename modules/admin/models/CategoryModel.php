<?php
Class CategoryModel extends CI_Model
{
	/*
		### add new category ###
	*/
	public function add_new($data)
	{
		return $this->db->insert('category', $data);
	}
	
	
	public function category_result_by_id($category_id)
	{
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $category_id);
        $result = $this->db->get();
        $cat_row = $result->row();
        return $cat_row;
    }
}