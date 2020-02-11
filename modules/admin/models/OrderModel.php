<?php
Class OrderModel extends CI_Model
{
	/*# add new order #*/
	public function place_order($data)
	{
		$this->db->insert('order', $data);
		return $this->db->insert_id();
	}
	
	/*# add new #*/
	public function add_new($data)
	{
		return $this->db->insert('order', $data);
	}
	
	/*# update #*/
	public function update_order($data, $row_id){
		$this->db->where('order.order_id', $row_id);
		return $this->db->update('order', $data);
	}
	
	/*# order result by order_status #*/
	public function get_orders($order_status)
	{
        $this->db->select('*');
        $this->db->from('order');
       // $this->db->where('order_status', $order_status);
        $result = $this->db->get();
        return $result->row();
    }
	
	/*# single order result by order_id #*/
	public function order_view($order_id)
	{
        $this->db->select('*');
        $this->db->from('order');
		$this->db->where('order_id', $order_id);
        $result = $this->db->get();
        return $result->row();
    }
}