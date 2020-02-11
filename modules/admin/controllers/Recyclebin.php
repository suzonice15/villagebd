<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recyclebin extends CI_Controller
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
        $data['menu_group']  	= 'recyclebin';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Recycle Bin';

        // params
        $params = array();
        if ($this->input->get('query')) {
            $params['table_name like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'recyclebin.recyclebin_id', 'order' => 'DESC');

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('recyclebin', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/recyclebin', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('recyclebin', $params, '*', $limit_params, $order_by);
        $data['users']=$this->db->query('select * from users')->result();
      /*
      echo '<pre>';
      print_r($data['results']);
      exit();
      */
        // load the views
        $data['layout'] = $this->load->view('recyclebin/index', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function restore()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        if($this->input->get('table_name') && $this->input->get('field_name') && $this->input->get('table_id'))
        {
            if($this->global_model->update($this->input->get('table_name'), array('status' => '1'), array($this->input->get('field_name') => $this->input->get('table_id'))))
            {
                $this->global_model->delete('recyclebin', array('table_id' => $this->input->get('table_id')));
                
                $this->session->set_flashdata('success_msg', 'Restored successfully!');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'Failed to restore!');
            }
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'Invalid request!');
        }
        
        redirect('admin/recyclebin');
    }

    public function confirm_delete()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        if($this->input->get('table_name') && $this->input->get('field_name') && $this->input->get('table_id'))
        {
            if($this->global_model->delete($this->input->get('table_name'), array($this->input->get('field_name') => $this->input->get('table_id'))))
            {
                $this->global_model->delete('recyclebin', array('table_id' => $this->input->get('table_id')));

                $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'Failed to delete!');
            }
        }
        else
        {
            $this->session->set_flashdata('error_msg', 'Invalid request!');
        }
        
        redirect('admin/recyclebin');
    }
    public function notification_delete(){
       
        $this->db->where('recyclebin_status', 1);

           $result=   $this->db->delete('recyclebin');
           if($result){

                $this->session->set_flashdata('success_msg', 'Update Notification Deleted successfully!');
            }
            else
            {
                $this->session->set_flashdata('error_msg', 'Failed to delete!');
            }
       
        
        redirect('admin/recyclebin');
        
    }
}