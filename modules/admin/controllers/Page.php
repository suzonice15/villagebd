<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
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
        $data['menu_group']  	= 'page';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Pages';

        $data['action_button'] = array('url' => site_url('admin/page/add_new'), 'title' => 'Add New Page');

        // params
        $params = array('status' => '1');

        if ($this->input->get('query')) {
            $params['post_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'post.post_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'post.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('post', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/page', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('post', $params, '*', $limit_params, $order_by);
			
        // load the views
        $data['layout'] = $this->load->view('page/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{	
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'page';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Page';

        $data['action_button'] = array('url' => site_url('admin/page'), 'title' => 'Manage Page');
		
		if($this->input->post())
		{			
			$this->form_validation->set_rules('post_title', 'page title', 'trim|required');
			$this->form_validation->set_rules('post_name', 'page name', 'trim|required');
			$this->form_validation->set_rules('post_content', 'page content', 'trim|required');

			if ($this->form_validation->run())
			{
				$row_data						=	array();
				$row_data['post_title']			=	$this->input->post('post_title');
				$row_data['post_name']			=	$this->input->post('post_name');
				$row_data['post_content']		=	$this->input->post('post_content');
				$row_data['post_excerpt']		=	$this->input->post('post_excerpt');

				$row_data['post_author']		=	1;
				$row_data['post_status']		=	'publish';
				$row_data['comment_status']		=	FALSE;
				$row_data['post_type']			=	'page';

				$template						=	$this->input->post('template');
				$seo_title						=	$this->input->post('seo_title');
				$seo_keywords					=	$this->input->post('seo_keywords');
				$seo_content					=	$this->input->post('seo_content');
			
				$row_data['created_time']		=	date("Y-m-d H:i:s");
				$row_data['modified_time']		=	date("Y-m-d H:i:s");

				if($page_id = $this->global_model->insert('post', $row_data))
				{
					update_post_meta($page_id, 'template', $template);
					update_post_meta($page_id, 'seo_title', $seo_title);
					update_post_meta($page_id, 'seo_keywords', $seo_keywords);
					update_post_meta($page_id, 'seo_content', $seo_content);

					$this->session->set_flashdata('success_msg', 'Successfully created.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to create.');
				}
				
				redirect('admin/page');
			}
		}

        // load the views
        $data['layout'] = $this->load->view('page/add_new', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function update($page_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

		$data 					= array();
        $data['menu_group']  	= 'page';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Page';

        $data['action_button']  = array('url' => site_url('admin/page'), 'title' => 'Manage Page');

		$data['page'] =	$this->global_model->get_row('post', array('post_id' => $page_id));
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('post_title', 'page title', 'trim|required');
			$this->form_validation->set_rules('post_name', 'page name', 'trim|required');
			$this->form_validation->set_rules('post_content', 'page content', 'trim|required');

			if($this->form_validation->run())
			{
				
											    	update_to_recycle_bin('post', $page_id);

				$row_data['post_title']			=	$this->input->post('post_title');
				$row_data['post_name']			=	$this->input->post('post_name');
				$row_data['post_content']		=	$this->input->post('post_content');
				$row_data['post_excerpt']		=	$this->input->post('post_excerpt');

				$row_data['post_author']		=	1;
				$row_data['post_status']		=	'publish';
				$row_data['comment_status']		=	FALSE;
				$row_data['post_type']			=	'page';

				$template						=	$this->input->post('template');
				$seo_title						=	$this->input->post('seo_title');
				$seo_keywords					=	$this->input->post('seo_keywords');
				$seo_content					=	$this->input->post('seo_content');
				
				$row_data['modified_time']		=	date("Y-m-d H:i:s");

				if($this->global_model->update('post', $row_data, array('post_id' => $page_id)))
				{
					update_post_meta($page_id, 'template', $template);
					update_post_meta($page_id, 'seo_title', $seo_title);
					update_post_meta($page_id, 'seo_keywords', $seo_keywords);
					update_post_meta($page_id, 'seo_content', $seo_content);

					$this->session->set_flashdata('success_msg', 'Successfully updated.');
					redirect('admin/page');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'Failed to update.');
					redirect('admin/page/update/'.$page_id);
				}
			}
		}

        // load the views
        $data['layout'] = $this->load->view('page/update', $data, TRUE);;
        $this->load->view('template', $data);
	}

    public function delete($page_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('post', array('status' => '0'), array('post_id' => $page_id));

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

			add_to_recycle_bin('post', $page_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
        	redirect('admin/page');
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

                foreach ($this->input->post('ids') as $id)
                {
                    if($this->global_model->update('post', array('status' => '0'), array('post_id' => $id)))
                    {
                    	add_to_recycle_bin('post', $id);

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

        redirect('admin/page');
    }
}