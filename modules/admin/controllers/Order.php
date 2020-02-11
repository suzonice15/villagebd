<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller
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
        $data['menu_group']  	= 'order';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Orders';

        // get the roles
        $data['order_status'] = get_order_status();

        // where clause params
        $params = array('status' => '1');
        if ($this->input->get('query')) {
            $params['order.order_id like'] = '%' . $this->input->get('query') . '%';
        }
        if ($this->input->get('status') && $this->input->get('status') != 'all') {
            $params['order_status'] = $this->input->get('status');
        }

        // order by
        $order_by = array('field' => 'order.order_id', 'order' => 'DESC');

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'order.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('order', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/order', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('order', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('order/index', $data, TRUE);;
        $this->load->view('template', $data);
	}

	public function order_view($order_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'order';
        $data['page_active'] 	= 'order_view';
		$data['page_title']		= 'Order('.$order_id.')';
		$data['order'] 			=  $this->global_model->get_row('order', array('order_id' => $order_id));
		
        // load the views
        $data['layout'] = $this->load->view('order/order_view', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update_order($order_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'order';
        $data['page_active'] 	= 'update_order';
		$data['page_title']		= 'Order('.$order_id.')';
		
		$row_data =	array();
		$row_data['order_status'] = $this->input->post('order_status');
		
		if($this->global_model->update('order', $row_data, array('order_id' => $order_id)))
		{
			$this->session->set_flashdata('success_msg', 'Order updated successfully');
		}
		else
		{
			$this->session->set_flashdata('error_msg', 'Order failed to update');
		}
		
		redirect('admin/order/order_view/'.$order_id);
		
        // load the views
        $data['layout'] = $this->load->view('order/order_view', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($order_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('order', array('status' => '0'), array('order_id' => $order_id));

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE)
        {
            $this->db->trans_rollback();

            $this->session->set_flashdata('error_msg', 'Failed to delete!');
            redirect($this->_module);
        }
        else
        {
            $this->db->trans_commit();

            add_to_recycle_bin('order', $order_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/order');
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

                foreach ($this->input->post('ids') as $order_id)
                {
                    if($this->global_model->update('order', array('status' => '0'), array('order_id' => $order_id)))
                    {
                        add_to_recycle_bin('order', $order_id);

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

        redirect('admin/order');
    }
}