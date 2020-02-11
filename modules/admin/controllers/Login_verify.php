<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_Verify extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('AdminModel', 'admin', TRUE);
	}
	 
	function index(){
	    	

		$this->form_validation->set_rules('user_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|callback_check_database');
	
		if($this->form_validation->run())
		{
		     
			if($this->session->user_id)
			{
		    
				if($this->session->user_type == 'product-manager')
				{
					redirect('admin/product');
				}

				redirect('admin');
			}
			
		}
	}
	 
	function check_database($user_pass)
	{
		$user_email = $this->input->post('user_email');
		$result = $this->global_model->get_row('users', array('user_type !=' => 'customer', 'user_email' => $user_email, 'user_pass' => md5($user_pass)));
	

		if(!empty($result))
		{
		
		
	
			$session=array(
				'user_id'			=> $result->user_id,
				'user_name'			=> $result->user_name,
				'user_login'		=> $result->user_login,
				'user_email'		=> $result->user_email,
				'user_phone'		=> $result->user_phone,
				'user_type'			=> $result->user_type,
				'user_status'		=> $result->user_status,
				'registered_date'	=> $result->registered_date,
				'updated_date'		=> $result->updated_date
			);
			
		
			if($result->user_type != 'customer')
			{
				$this->session->set_userdata($session);
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('check_database', 'This is not authorised access!');
				return false;
			}
		}
		else
		{
			
			
			$this->form_validation->set_message('check_database', 'Invalid username or password!');
			return false;
		}
	}
}