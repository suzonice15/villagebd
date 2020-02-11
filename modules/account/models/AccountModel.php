<?php
Class AccountModel extends CI_Model
{
	function login($user_email, $user_pass)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_email', $user_email);
		$this->db->where('user_pass', MD5($user_pass));
		//$this->db->where('visible', 'yes');
		$this->db->limit(1);

		$query=$this->db->get();

		if($query->num_rows()==1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	/* users */
	public function create_user($data)
	{
		return $this->db->insert('users', $data);
	}
	public function update_user($data,$user_login)
	{
		$this->db->where('users.user_login',$user_login);
		return $this->db->update('users', $data);
	}
	
	/* users meta */
	public function create_user_meta($data){
		return $this->db->insert('usermeta', $data);
	}
	public function update_user_meta($user_id, $meta_key, $data){
		$this->db->where('usermeta.user_id',$user_id);
		$this->db->where('usermeta.meta_key',$meta_key);
		return $this->db->update('usermeta', $data);
	}
	
	public function get_teacher(){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type', 'teacher');
        $query=$this->db->get();
		return $query->result();
	}
	
	public function create_notification($data){
		return $this->db->insert('notification', $data);
	}
	
	public function reset_password($data, $user_login){
		$this->db->where('users.user_login',$user_login);
		return $this->db->update('users', $data);
	}
	
	/*
	### delete studentshp ###
	*/
	public function delete_student($user_id)
	{
		$where=array('user_id'=>$user_id);
		$this->db->where($where);
		return $this->db->delete(array('users', 'usermeta', 'diary'));
	}
	public function delete_student_other($user_id)
	{
		$where=array('student_id'=>$user_id);
		$this->db->where($where);
		return $this->db->delete(array('admit', 'mcqresult'));
	}
	public function delete_invoice($invoice)
	{
		$sql="DELETE FROM `invoice` WHERE `invoice`='{$invoice}'";
		return $this->db->query($sql);
	}
}