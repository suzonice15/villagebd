<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer extends CI_Controller
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
        $data['menu_group']  	= 'offer';
        $data['page_active'] 	= 'manage';
		$data['page_title']		= 'Offers';

        $data['action_button'] = array('url'   => site_url('admin/offer/add_new'),
            'title' => 'Add New Offer'
        );

        // params
        $params = array('status' => 1);

        if ($this->input->get('query')) {
            $params['media_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'offer.offer_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'offer.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('offer', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/offer', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('offer', $params, '*', $limit_params, $order_by);

        // load the views
        $data['layout'] = $this->load->view('offer/index', $data, TRUE);;
        $this->load->view('template', $data);
	}
	
	function add_new()
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'offer';
        $data['page_active'] 	= 'add_new';
		$data['page_title']		= 'Add New Offer';

		if($this->input->post())
		{
			$this->form_validation->set_rules('offer_title', 'Title', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$row_data						=	array();
				$row_data['offer_title']		=	$this->input->post('offer_title');
				$row_data['offer_name']			=	$this->input->post('offer_name');
				$row_data['offer_summary']		=	$this->input->post('offer_summary');
				$row_data['created_time']		=	date('Y-m-d H:i:s');
				$row_data['modified_time']		=	date('Y-m-d H:i:s');

				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['offer_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$media_id = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['media_id'] = $media_id;
				}
				
				if($this->global_model->insert('offer', $row_data))
				{
					$this->session->set_flashdata('success_msg', 'You have successfully created.');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'You have failed to create.');
				}
				
				redirect('admin/offer');
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('offer/add_new', $data, TRUE);
        $this->load->view('template', $data);
	}
	
	function update($offer_id)
	{
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
		$data 					= array();
        $data['menu_group']  	= 'offer';
        $data['page_active'] 	= 'update';
		$data['page_title']		= 'Update Offer';

		$data['data_row']		= $this->global_model->get_row('offer', array('offer_id' => $offer_id));

		if($this->input->post())
		{
			$this->form_validation->set_rules('offer_title', 'Title', 'trim|required');
			
			if($this->form_validation->run())
			{
				$row_data						=	array();
				$row_data['offer_title']		=	$this->input->post('offer_title');
				$row_data['offer_name']			=	$this->input->post('offer_name');
				$row_data['offer_summary']		=	$this->input->post('offer_summary');
				$row_data['modified_time']		=	date('Y-m-d H:i:s');
			
				if(isset($_FILES["featured_image"]) && $_FILES["featured_image"]["size"] > 1000)
				{
					$uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
					$uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
					move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
					$media_id = get_media_id($uploaded_file_path);
					
					if(!$media_id)
					{
						$media_data = array();
						$media_data['media_title'] 	= $row_data['offer_title'];
						$media_data['media_path'] 	= $uploaded_file_path;
						$media_data['created_time']	= date("Y-m-d H:i:s");
						$media_data['modified_time']= date("Y-m-d H:i:s");
						
						if($this->global_model->insert('media', $media_data))
						{
							$media_id = get_media_id($uploaded_file_path);
						}
					}
					
					$row_data['media_id'] = $media_id;
				}
				
				if($this->global_model->update('offer', $row_data, array('offer_id' => $offer_id)))
				{
					$this->session->set_flashdata('success_msg', 'You have successfully updated.');
					redirect('admin/offer');
				}
				else
				{
					$this->session->set_flashdata('error_msg', 'You have failed to update.');
					redirect('admin/offer/update/'.$offer_id);
				}
			}
		}
		
        // load the views
        $data['layout'] = $this->load->view('offer/update', $data, TRUE);
        $this->load->view('template', $data);
	}
	
    public function delete($offer_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('offer', array('status' => '0'), array('offer_id' => $offer_id));

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

            add_to_recycle_bin('offer', $offer_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/offer');
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

                foreach ($this->input->post('ids') as $offer_id)
                {
                    if($this->global_model->update('offer', array('status' => '0'), array('offer_id' => $offer_id)))
                    {
                        add_to_recycle_bin('offer', $offer_id);

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

        redirect('admin/offer');
    }
}