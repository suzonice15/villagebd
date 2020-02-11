<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_verify extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('AccountModel', 'account', TRUE);
	}
	 
	function index(){
		$data = array();
		$data['page_title'] 			= 	'Account';
		$data['page_name'] 				= 	'account nologged';
		
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|callback_check_database');
		if($this->form_validation->run())
		{
			if($this->session->user_id)
			{
				if($this->input->post('redirect_url'))
				{
					$redirect_url=$this->input->post('redirect_url');
					
					redirect($redirect_url, 'refresh');
				}
				else
				{
					redirect('account', 'refresh');
				}
			}
		}
	}
	 
	function check_database($user_pass)
	{
		$user_email = $this->input->post('user_email');
		$result 	= $this->account->login($user_email, $user_pass);
		
		if($result)
		{
			$session = array();

			foreach($result as $row)
			{
				$session = array
				(
					'user_id'			=> $row->user_id,
					'user_name'			=> $row->user_name,
					'user_login'		=> $row->user_login,
					'user_email'		=> $row->user_email,
					'user_phone'		=> $row->user_phone,
					'user_type'			=> $row->user_type,
					'user_status'		=> $row->user_status,
					'registered_date'	=> $row->registered_date,
					'updated_date'		=> $row->updated_date
				);
				
				$this->session->set_userdata($session);
				
				return TRUE;
			}
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			
			return false;
		}
	}
}