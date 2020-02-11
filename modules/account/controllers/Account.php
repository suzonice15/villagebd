<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->model('AccountModel', 'account');
	}

	public function index()
	{
		$data 				= array();
		$data['page_title'] = 'Account';
		$data['page_name']  = $this->session->user_id ? 'account logged' : 'account nologged';

		$this->load->view('header', $data);
		$this->load->view('account', $data);
		$this->load->view('footer', $data);
	}

	public function signup()
	{
		if(!$this->session->user_id)
		{
			$data = array();
			$data['page_title'] 			= 	'Signup';
			$data['page_name'] 				= 	'account signup';
			$this->load->view('header', $data);
			$this->load->view('signup', $data);
			$this->load->view('footer', $data);
		}
		else
		{
			redirect('account', 'refresh');
		}
	}
	
	public function signup_process()
	{
		if($this->session->user_id)
		{
			redirect('account/?q=true&msg=you+already+a+signup+user', 'refresh');
		}
		
		$data = array();
		$data['page_title'] 			= 	'Signup';
		$data['page_name'] 				= 	'account signup';
		$data['sidebar'] 				=	$this->load->view('sidebar', $data, true);
		
		$row_data						=	array();
		$row_data['user_name']			=	$this->input->post('user_name');
		$row_data['user_phone']			=	$this->input->post('user_phone');
		$row_data['user_login']			=	$this->input->post('user_email');
		$row_data['user_email']			=	$this->input->post('user_email');
		$row_data['user_pass']			=	md5($this->input->post('user_pass'));
		$row_data['user_type']			=	'customer';
		$row_data['user_status']		=	'visible';
		$row_data['registered_date']	=	date('Y-m-d H:i');
		$row_data['updated_date']		=	date('Y-m-d H:i');
		
		$this->form_validation->set_rules('user_name', 'name', 'trim|required');
		$this->form_validation->set_rules('user_phone', 'phone', 'trim|required|regex_match[/^[+.0-9().-]+$/]|is_unique[users.user_phone]');
		$this->form_validation->set_rules('user_email', 'email', 'trim|required|valid_email|is_unique[users.user_email]');
		$this->form_validation->set_rules('user_pass', 'password', 'trim|required');
		
		if($this->form_validation->run($this))
		{
			if($user_id = $this->account->create_user($row_data))
			{
				update_user_meta($user_id, 'user_address', '');
				update_user_meta($user_id, 'user_city', '');
				update_user_meta($user_id, 'user_state', '');
			
				$session=array(
					'user_id'			=>	$user_id,
					'user_name'			=>	$row_data['user_name'],
					'user_phone'		=>	$row_data['user_phone'],
					'user_email'		=>	$row_data['user_email'],
					'user_login'		=>	$row_data['user_email'],
					'user_type'			=>	$row_data['user_type'],
					'user_status'		=>	$row_data['user_status'],
					'registered_date'	=>	$row_data['registered_date'],
					'updated_date'		=>	$row_data['updated_date']
				);
				
				$this->session->set_userdata($session);
				
				redirect('account/?q=true&ref=signup&msg=successfully+created+your+account', 'refresh');
			}
		}

		$this->load->view('header', $data);
		$this->load->view('signup', $data);
		$this->load->view('footer', $data);
	}

	public function update_account()
	{
		if($this->session->user_id)
		{
			$userdata=$this->session->user_id;
			$data['user_id']		=	$userdata['user_id'];
			$data['user_name']		=	$userdata['user_name'];
			$data['user_phone']		=	$userdata['user_phone'];
			$data['user_type']		=	$userdata['user_type'];
			$data['user_login']		=	$userdata['user_login'];
			$data['user_detail']	=	get_user_meta($userdata['user_id'], 'user_detail');
			$data['user_email']		=	get_user_meta($userdata['user_id'], 'user_email');
			$data['user_school']	=	get_user_meta($userdata['user_id'], 'user_school');
			$data['page_title']		=	'Academic Classes';
			$data['req']			=	'update';
			
			$user_data						=	array();
			$user_data['user_name']			=	$this->input->post('user_name');
			$user_data['user_phone']		=	$this->input->post('user_phone');
			$user_data['updateddate']		=	date('Y-m-d H:i');
			
			$user_email=$user_school=$user_detail=$student_class=array();
			$user_email['meta_value']		=	$this->input->post('user_email');
			$user_school['meta_value']		=	$this->input->post('user_school');
			$user_detail['meta_value']		=	$this->input->post('user_detail');
			
			$this->form_validation->set_rules('user_name', 'Name', 'required');
			$this->form_validation->set_rules('user_phone', 'Phone', 'required');
			if(trim($data['user_type'])=='student')
			{
				$student_class['meta_value']=$this->input->post('student_class');
				$this->form_validation->set_rules('student_class', 'Class Name', 'required');
			}
			
			if ($this->form_validation->run())
			{
				if($this->user->update_user($user_data, $data['user_login'])){
					$session=array(
						'user_id'=>$data['user_id'],
						'user_name'=>$user_data['user_name'],
						'user_login'=>$data['user_login'],
						'user_phone'=>$user_data['user_phone'],
						'user_type'=>$data['user_type']
					);
					$this->session->set_userdata($session);
				}
				
				$this->user->update_user_meta($data['user_id'], 'user_email', $user_email);
				$this->user->update_user_meta($data['user_id'], 'user_school', $user_school);
				$this->user->update_user_meta($data['user_id'], 'user_detail', $user_detail);
				
				if(trim($data['user_type'])=='student'){ $this->user->update_user_meta($data['user_id'], 'student_class', $student_class); }
				
				redirect('/account/?q=true&msg=successfully+updated+your+account', 'refresh');
			}
		}
		else{ redirect('login', 'refresh'); }
	}
	
	public function notifications()
	{
		if($this->session->user_id)
		{
			$userdata=$this->session->user_id;
			$data['user_id']		=	$userdata['user_id'];
			$data['user_name']		=	$userdata['user_name'];
			$data['user_phone']		=	$userdata['user_phone'];
			$data['user_type']		=	$userdata['user_type'];
			$data['user_login']		=	$userdata['user_login'];
			$data['user_detail']	=	get_user_meta($userdata['user_id'], 'user_detail');
			$data['user_email']		=	get_user_meta($userdata['user_id'], 'user_email');
			$data['user_school']	=	get_user_meta($userdata['user_id'], 'user_school');
			$data['page_title']		=	'Notifications';
			
			if($data['user_type']=='teacher' || $data['user_type']=='schooling24')
			{
				$this->load->view('header', $data);
				$this->load->view('notifications', $data);
				$this->load->view('footer', $data);
			}
			else
			{
				redirect('authentication-failure/?page=Lecture', 'refresh');
			}
		}
		else
		{
			redirect('users/login', 'refresh');
		}
	}

	public function reset_password()
	{
		$data['page_title']='Reset Password';
		$data['user']=NULL;
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('user_login', 'Username', 'required');
			$this->form_validation->set_rules('user_old_pass', 'Old Password', 'required|callback_check_user_to_reset_pass');
			$this->form_validation->set_rules('user_pass', 'Password', 'required');
			if($this->form_validation->run())
			{
				$user_login=$this->input->post('user_login');
				$user_pass=$this->input->post('user_pass');
				
				$reset_data['user_pass']=md5($user_pass);
				if($this->user->reset_password($reset_data, $user_login))
				{
					$result=$this->user->login($user_login, $user_pass);
					if($result)
					{
						$session=array();
						foreach($result as $row)
						{
							$session=array(
								'user_id'=>$row->user_id,
								'user_name'=>$row->user_name,
								'user_login'=>$row->user_login,
								'user_phone'=>$row->user_phone,
								'user_type'=>$row->user_type
							);
							$this->session->set_userdata($session);
						}
						redirect('account/?q=true&msg=you+have+successfully+reseted+your+password', 'refresh');
					}
				}
			}
		}
		else
		{
			$this->load->view('header', $data);
			$this->load->view('reset_password', $data);
			$this->load->view('footer', $data);
		}
	}
	
	public function check_user_to_reset_pass($user_pass)
	{
		$user_login=$this->input->post('user_login');
		$result=$this->user->login($user_login, $user_pass);
		if($result){ return true; }else{ $this->form_validation->set_message('check_user_to_reset_pass', 'Invalid username or password'); return false; }
	}
}