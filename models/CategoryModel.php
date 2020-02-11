<?php
Class CategoryModel extends CI_Model
{
	/*# add new #*/
	public function add_new($data)
	{
		return $this->db->insert('category', $data);
	}
	
	/*# update #*/
	public function update($data, $row_id){
		$this->db->where('category.category_id', $row_id);
		return $this->db->update('category', $data);
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
	
	/*# product result by category_id and sub_category_id for frontend archive view #*/
	public function archive_product($category_id,$per_page,$page,$sortby,$price_from=null,$price_to=null)
	{
		if($sortby=='rating_desc')
		{
			$this->db->select('*, AVG(review.rating) as rating_avg');
			$this->db->from('product');
			$this->db->join('term_relation', 'product.product_id = term_relation.product_id');
			$this->db->join('review', 'product.product_id = review.product_id');
			$this->db->where('term_relation.term_id', $category_id);
			$this->db->group_by('review.product_id');
			$this->db->order_by('rating_avg', 'DESC');
							$this->db->order_by('product.product_availability', 'ASC');

			$this->db->limit($per_page, ($page-1)*$per_page);
			$result = $this->db->get();
			return $result->result();
		}
		else
		{
			$this->db->select('*');
			$this->db->from('product');
			$this->db->join('term_relation', 'product.product_id = term_relation.product_id');
			$this->db->where('term_relation.term_id', $category_id);
						$this->db->where('product.status', 1);

			
			if($sortby=='price_asc')
			{
			$this->db->order_by('product.product_price', 'ASC');
		      
			//	$product_price_array = array('product.product_price !=' => '', 'product.product_price !=' => null, 'product.product_price !=' => 0);
				
			//	$this->db->where($product_price_array);
				
			
				
				$this->db->order_by('product.product_availability', 'ASC');

			}
			elseif($sortby=='price_desc')
			{
				$this->db->order_by('product.product_price', 'DESC');
				$this->db->order_by('product.product_availability', 'ASC');

			}
			elseif($sortby=='price_range')
			{
				$this->db->order_by('product.product_price', 'ASC');
				
			//	$product_price_array = array('product.product_price !=' => '', 'product.product_price !=' => null, 'product.product_price !=' => 0, 'product.product_price >=' => $price_from, 'product.product_price <=' => $price_to);
				
			//	$this->db->where($product_price_array);
				$this->db->order_by('product.product_availability', 'ASC');

			}
			elseif($sortby=='name_asc')
			{
				$this->db->order_by('product.product_title', 'ASC');
							
			}
			elseif($sortby=='name_desc')
			{
				$this->db->order_by('product.product_title', 'DESC');
				$this->db->order_by('product.product_availability', 'ASC');

			}
			else
			{
				$this->db->order_by('product.product_id', 'DESC');
			
			}
			
			$this->db->limit($per_page, ($page-1)*$per_page);
			$result = $this->db->get();
			return $result->result();
		}
    }
	
	/*# product result by category_id and sub_category_id for frontend archive view #*/
	public function total_rows($category_id)
	{
        $this->db->select('*');
        $this->db->from('product');
		$this->db->join('term_relation', 'product.product_id = term_relation.product_id');
		$this->db->where('term_relation.term_id', $category_id);
        $query=$this->db->get();
		return $query->num_rows();
    }
	
	/*# add new media #*/
	public function add_new_media($data)
	{
		$this->db->insert('media', $data);
		return $this->db->insert_id();
	}
}