<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");

        if (ENVIRONMENT == 'development' || $this->input->get('profiler')) {
            $this->output->enable_profiler(TRUE);
        }

        if(check_admin_login())
        {
			if($this->session->user_type != 'admin'&& $this->session->user_type != 'super-admin')
			{
				redirect('authentication-failure', 'refresh');
			}
        }
	}

	public function index()
	{
		$this->load->view('login');
	}
}