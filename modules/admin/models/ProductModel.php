<?php
Class ProductModel extends CI_Model
{
/*	public function add_new($data)
	{
		$this->db->insert('product', $data);
		return $this->db->insert_id();
	}

	public function update($data, $row_id){
		$this->db->where('product.product_id', $row_id);
		return $this->db->update('product', $data);
	}

	public function get_products($product_id=null)
	{
        $this->db->select('*');
        $this->db->from('product');
		if($product_id!=null)
		{
			$this->db->where('product_id', $product_id);
			$query = $this->db->get();
			return $query->row();
		}
		else
		{
			$this->db->order_by("product_id", "DESC");
			$query = $this->db->get();
			return $query->result();
		}
    }*/

/*	public function get_products($where = false, $limit = false, $order_by = false, $join_term=false, $count = false)
	{
        $this->db->select('product.*, term_relation.term_id')->from('product');
		
		if($join_term)
		{
			$this->db->join('term_relation', 'product.product_id = term_relation.product_id');
		}

        if (!empty($where)) {
            $this->db->where($where);
        }

        if($this->session->user_type == 'product-manager')
        {
            $this->db->where_in('term_relation.term_id', get_assign_terms($this->session->user_id));
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['start']);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['field'], $order_by['order']);
        }

        $query = $this->db->get();
        if ($query->result()) {
        	if(!empty($count))
        	{
            	return $query->num_rows();
        	}
        	else
        	{
            	return $query->result();
        	}
        } else {
            return false;
        }
    }*/

/*	public function product_terms($product_id)
	{
        $this->db->select('*');
        $this->db->from('term_relation');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->result();
    }
	
	public function front_view($product_name){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_name', $product_name);
        $result = $this->db->get();
        $prod_row = $result->row();
        return $prod_row;
    }
	
	public function quick_view($product_id){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get();
        $prod_row = $result->row();
        return $prod_row;
    }
	
	/*# term relations #*/
/*	public function add_new_term_relation($data)
	{
		return $this->db->insert('term_relation', $data);
	}

	public function delete_term_relation($product_id)
	{
		$this->db->where('term_relation.product_id', $product_id);
		return $this->db->delete('term_relation');
	}*/
	
	/*# media #*/
	/*public function add_new_media($data)
	{
		$this->db->insert('media', $data);
		return $this->db->insert_id();
	}*/
}