<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
        
		$this->load->library('cart');
	}

	function add_new_career()
	{
		if($this->input->post())
		{
			$row_data					= array();
			$row_data['name']			= $this->input->post('name');
			$row_data['email']			= $this->input->post('email');
			$row_data['created_time']	= date("Y-m-d H:i:s");
			
			$this->form_validation->set_rules('name', 'name', 'trim|required');
			$this->form_validation->set_rules('email', 'email', 'trim|required');

			if ($this->form_validation->run())
			{
				if((($_FILES["cv"]["type"]=="application/pdf") || ($_FILES["cv"]["type"]=="application/msword")))
				{
					if($_FILES["cv"]["error"] > 0)
					{
						echo "Return Code: " . $_FILES["cv"]["error"] . "<br />";
					}
					else
					{
						$file_name 				= 'cv_'.time().'_'.$_FILES['cv']['name'];
						$uploaded_image_path 	= './uploads/'.$file_name;
						$uploaded_file_path 	= 'uploads/'.$file_name;

						$row_data['cv'] 		= $uploaded_file_path;

						move_uploaded_file($_FILES["cv"]["tmp_name"], $uploaded_image_path);

						if($career_id = $this->global_model->insert('career', $row_data))
						{
							$message = array(
								'status'  	=> 'success',
								'message'  	=> 'You have successfully submitted.'
							);
						}
						else
						{
							$message = array(
								'status'  	=> 'failed',
								'message'  	=> 'You have failed to submit.'
							);
						}
					}
				}
				else
				{
					$message = array(
						'status'  	=> 'failed',
						'message'  	=> 'You must upload yor cv.'
					);
				}

			}
		}
		else
		{
			$message = array(
				'status'  	=> 'failed',
				'message'  	=> 'You must fill all required fields and upload cv.'
			);
		}

		$this->session->set_userdata('message', $message);
		redirect('career', 'refresh');
	}

	function weekly_offer()
	{
		$data 				= array();
		$data['page_name']	= 'weekly_offer';
		$data['page_title']	= 'Weekly Offer';
		$data['sidebar'] 	= $this->load->view('sidebar', $data, true);

		$date_from  = date('Y-m-d 00:00:00');
		$date_to 	= date('Y-m-d 23:59:59', strtotime('+6 day'));

		// where clause params
		$params = array(
			'discount_price !=' => 0,
			'discount_date_from >=' => $date_from,
			'discount_date_to <=' => $date_to
		);

		$data['products'] = $this->global_model->get('product', $params, '*');
		
		$this->load->view('header', $data);
		$this->load->view('weekly_offer', $data);
		$this->load->view('footer', $data);
	}
}