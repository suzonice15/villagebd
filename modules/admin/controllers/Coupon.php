<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dhaka");
		
        if (ENVIRONMENT == 'development' || $this->input->get('profiler')) {
            $this->output->enable_profiler(TRUE);
        }

        if(!check_admin_login())
        {
            $this->session->set_userdata('return_url', current_url());
            $this->session->set_flashdata('error_msg', 'Please login first!!');
            redirect('admin/login');
        }
	}

	public function index()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'Coupon';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Coupons';

        $data['action_button'] = array('url'   => site_url('admin/Coupon/add_new'),
            'title' => 'Add New Coupon'
        );
       $order_by = array('field' => 'coupon_id',
                'order' => 'desc'
                );
      
        $data['results'] = $this->global_model->get('coupon', '', '*', '', $order_by);
        
			
        // load the views
        $data['layout'] = $this->load->view('Coupon/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'brand';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Coupon';
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('coupon_name', 'name', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data						= array();
				$row_data['coupon_name']			= $this->input->post('coupon_name');
				$row_data['coupon_code']			= $this->input->post('coupon_code');
				$row_data['coupon_status']			= $this->input->post('coupon_status');
				$row_data['coupon_note']			= $this->input->post('coupon_note');
				$row_data['coupon_start']			= date('Y-m-d',strtotime($this->input->post('coupon_start')));
				$row_data['coupon_end']			=  date('Y-m-d',strtotime($this->input->post('coupon_end')));
				$row_data['coupon_name']			= $this->input->post('coupon_name');




				$row_data['created_time']		= date('Y-m-d H:i:s');
				$row_data['modified_time']		= date('Y-m-d H:i:s');

			
				if($this->global_model->insert('coupon', $row_data))
				{
					$this->session->set_flashdata('success_msg', 'Successfully created.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to create.');
				}
				
				redirect('admin/Coupon');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('Coupon/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($brand_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'Coupon';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Coupon';

		$data['data_row']		= $this->global_model->get_row('coupon', array('coupon_id' => $brand_id));
		
		if($this->input->post())
		{
			$row_data					= array();
			$this->form_validation->set_rules('coupon_name', 'Coupon Name', 'trim|required');
			
			if ($this->form_validation->run())
			{
				
						$row_data['coupon_name']			= $this->input->post('coupon_name');
				$row_data['coupon_code']			= $this->input->post('coupon_code');
				$row_data['coupon_status']			= $this->input->post('coupon_status');
				$row_data['coupon_note']			= $this->input->post('coupon_note');
				$row_data['coupon_start']			= date('Y-m-d',strtotime($this->input->post('coupon_start')));
				$row_data['coupon_end']			=  date('Y-m-d',strtotime($this->input->post('coupon_end')));
				$row_data['coupon_name']			= $this->input->post('coupon_name');




				$row_data['created_time']		= date('Y-m-d H:i:s');
				$row_data['modified_time']		= date('Y-m-d H:i:s');
		    
				
				if($this->global_model->update('coupon', $row_data, array('coupon_id' => $brand_id)))
				{
					$this->session->set_flashdata('success_msg', 'Successfully updated.');
					redirect('admin/Coupon');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to update.');
					redirect('admin/Coupon/update/'.$brand_id);
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('Coupon/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($brand_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();
        
        $this->db->where('coupon_id',$brand_id);
                $this->db->delete('coupon');
       
       $result= $this->db->trans_complete();
     
        if ($this->db->trans_status() == FALSE)
        {
            $this->db->trans_rollback();

            $this->session->set_flashdata('error_msg', 'Failed to delete!');
            redirect($this->_module);
        }
        else
        {
            $this->db->trans_commit();

          

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/Coupon');
        }
    }

    public function bulk_action()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method()))
        {
            redirect('admin/permission_denied');
        }

        if ($this->input->post('action'))
        {
            if ($this->input->post('ids'))
            {
                $items = 0;

                foreach ($this->input->post('ids') as $brand_id)
                {
                    if($this->global_model->update('brand', array('status' => '0'), array('brand_id' => $brand_id)))
                    {
                        add_to_recycle_bin('brand', $brand_id);

                        $items++;
                    }
                }

                if(!empty($items))
                {
                    $this->session->set_flashdata('success_msg', $items . ' item(s) deleted successfully');
                }
                else
                {
                    $this->session->set_flashdata('error_msg', 'Failed to delete');
                }
            }
        }

        redirect('admin/brand');
    }
}