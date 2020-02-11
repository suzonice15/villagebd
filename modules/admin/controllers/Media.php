<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller
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
        
        $data                   = array();
        $data['menu_group']     = 'media';
        $data['page_active']    = 'manage';
        $data['page_title']     = 'Media Files';

        $data['action_button'] = array('url'   => site_url('admin/media/add_new'),
            'title' => 'Add New Media'
        );

        // params
        $params = array('status' => 1);
        if ($this->input->get('query')) {
            $params['media_title like'] = '%' . $this->input->get('query') . '%';
        }

        // order by
        $order_by = array('field' => 'media.media_id',
            'order' => 'DESC'
        );

        if ($this->input->get('orderby')) {
            $order_by = array('field' => 'media.'.$this->input->get('orderby'),
                'order' => $this->input->get('order')
            );
        }

        // pagination
        $per_page      = 20;
        $offset        = ($this->input->get('page')) ? ($per_page * ($this->input->get('page') - 1)) : 0;
        $data['total'] = $total_rows    = $this->global_model->get_count('media', $params);

        $limit_params = array('limit' => $per_page, 'start' => $offset);

        createPagging('admin/media', $total_rows, $per_page);

        // get the results
        $data['results'] = $this->global_model->get('media', $params, '*', $limit_params, $order_by);

        // load the views
        $data['layout'] = $this->load->view('media/index', $data, TRUE);;
        $this->load->view('template', $data);
    }
    
    function add_new()
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }
        
        $data                   = array();
        $data['menu_group']     = 'media';
        $data['page_active']    = 'add_new';
        $data['page_title']     = 'Add New Media';

        if($this->input->post())
        {
            $this->form_validation->set_rules('media_title', 'Media Title', 'trim|required');
            
            if ($this->form_validation->run())
            {
                $row_data                   =   array();
                $row_data['media_title']    =   $this->input->post('media_title');
            
                if($_FILES["featured_image"]["error"] == 0)
                {
                    if($_FILES["featured_image"]["error"] > 0)
                    {
                        echo "Return Code: " . $_FILES["featured_image"]["error"] . "<br />";
                    }
                    else
                    {
                        $uploaded_image_path = "./uploads/".$_FILES["featured_image"]["name"];
                        $uploaded_file_path = "uploads/".$_FILES["featured_image"]["name"];
                        move_uploaded_file($_FILES["featured_image"]["tmp_name"], $uploaded_image_path);
                        
                        $data['media_path'] = $uploaded_file_path;
                        $row_data['media_path'] = $uploaded_file_path;
                    }
                }
                
                if(isset($row_data['media_path']) && !empty($row_data['media_path']))
                {
                    $row_data['created_time']  = date("Y-m-d H:i:s");
                    $row_data['modified_time'] = date("Y-m-d H:i:s");

                    if($this->global_model->insert('media', $row_data))
                    {
                        $this->session->set_flashdata('success_msg', 'You have successfully created new media file.');
                    }
                    else
                    {
                        $this->session->set_flashdata('error_msg', 'You have failed to create new media file.');
                    }

                    redirect('admin/media');
                }
            }
        }
        
        // load the views
        $data['layout'] = $this->load->view('media/add_new', $data, TRUE);;
        $this->load->view('template', $data);
    }

    public function delete($media_id)
    {
        // check the permission
        if(!has_permission($this->router->fetch_class(), $this->router->fetch_method())) {
            redirect('admin/permission_denied');
        }

        $this->db->trans_start();

        $this->global_model->update('media', array('status' => '0'), array('media_id' => $media_id));

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

            add_to_recycle_bin('media', $media_id);

            $this->session->set_flashdata('success_msg', 'Deleted successfully!');
            redirect('admin/media');
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

                foreach ($this->input->post('ids') as $media_id)
                {
                    if($this->global_model->update('media', array('status' => '0'), array('media_id' => $media_id)))
                    {
                        add_to_recycle_bin('media', $media_id);

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

        redirect('admin/media');
    }
}