<?php
Class CheckoutModel extends CI_Model
{
	/*# add new order #*/
	public function place_order($data)
	{
		$this->db->insert('order', $data);
		return $this->db->insert_id();
	}
	
	/*# order items review #*/
	public function order_items_review($order_id)
	{
        $this->db->select('*');
        $this->db->from('order');
		$this->db->where('order_id', $order_id);
        $result = $this->db->get();
        return $result->row();
    }
    
    public function coupon_check($code){
         
        date_default_timezone_set('Asia/Dhaka');
        
        $today = date("Y-m-d");
            $result=$this->db->where("coupon_start <=",$today)
                  ->where("coupon_end >=",$today)
                  ->where("coupon_code",$code)
                  ->where("coupon_status",1)
                  ->get("coupon")->row();
                  
                   if($result){
            return true;
        } else {
            echo 'InValid Coupon Code';
        }
        
                  
    }
    
    public function coupon_product($product_ids,$coupon_code){
        
        /* $this->db->where_in("product_id",$product_ids);
                 $this->db->or_where("coupon_code",$coupon_code);
                $result=$this->db->get("product");
                  return $result->result();*/
                  $this->db->join('coupon', 'product.coupon_code = coupon.coupon_id','left'); 
                  $this->db->where_in("product.product_id",$product_ids);
                  $this->db->or_where("coupon.coupon_code",$coupon_code);
                 $query = $this->db->get('product');
                 return $query->result();
    }
}