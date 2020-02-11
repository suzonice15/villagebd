<?php
Class Offer_model extends CI_Model
{
    public function offer_data(){
         $today = date("Y-m-d");
       // WHERE coupon_start >='$today' and coupon_end <='$today'
            $this->db->join('coupon', 'product.coupon_code = coupon.coupon_id'); 
                    $this->db->where("coupon.coupon_start >=",'$today');
                 $this->db->or_where("coupon.coupon_end <=", '$today');
$query = $this->db->get('product');
return $query->result();
    }
    
     public function crazy(){
     //    SELECT * FROM `product` WHERE product_name like '%laptop%' limit 270

          $this->db->join('term_relation', 'term_relation.product_id = product.product_id'); 
                    $this->db->join('category', 'category.category_id = term_relation.term_id'); 
                                        $this->db->where("category.category_name",'laptop-notebook');


          
         // SELECT * FROM `product` join term_relation on term_relation.product_id=product.product_id JOIN category on category.category_id=term_relation.term_id
        //  WHERE category.category_name="laptop-notebook" order by product.modified_time desc

                    $this->db->like("product.product_name",laptop,'both');
                
$query = $this->db->get('product');
return $query->result();
    }
	
	  public function twenty(){
         $this->db->join('coupon', 'product.coupon_code = coupon.coupon_id'); 
                    $this->db->where("product.coupon_code !=",0);
                      $this->db->where("product.discount_price >=",50000);
                
$query = $this->db->get('product');
return $query->result();
    }
}