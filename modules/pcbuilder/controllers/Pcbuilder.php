<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pcbuilder extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('cart');
        $this->load->library('pagination');
		$this->load->library('Pdfgenerator');
		$this->load->model('PcbuilderModel', 'pcbuilder');
	}

	public function index()
	{
		$data 				= array();
		$data['page_title'] = 'PC Builder';
		$data['page_name'] 	= 'pc-builder nologged';
		
		if($this->session->user_id)
		{
			$data['page_name'] 		= 'pc-builder logged';
		}
		
		$this->load->view('header', $data);
		$this->load->view('pcbuilder', $data);
		$this->load->view('footer', $data);
	}

	public function choose($cat, $page=1)
	{
		$component_name		= get_component_name($cat);
		$catinfo			= get_category_info($cat);

		$component_slug 	= strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));

		$filter_category	= $this->input->get('filter_category') ? $this->input->get('filter_category') : null;
    	$search 			= $this->input->get('filter_name') ? $this->input->get('filter_name') : null;
    	$sortby 			= isset($_COOKIE['sortby']) ? $_COOKIE['sortby'] : 'price_asc';

    	$category_id 		= $filter_category ? $filter_category : $cat;

        $config['base_url']			= base_url('pcbuilder/choose/'.$cat);
        $config['total_rows'] 		= $this->pcbuilder->get_products_count($search, $category_id, $component_slug);
        $config['per_page']			= 50;
        $config["uri_segment"]		= 4;
        $choice						= $config["total_rows"]/$config["per_page"];
        $config["num_links"]		= floor($choice);
		$config['use_page_numbers'] = true;

        $config['full_tag_open']	= '<ul class="pagination">';
        $config['full_tag_close']	= '</ul>';
        $config['first_link']		= false;
        $config['last_link']		= false;
        $config['first_tag_open']	= '<li>';
        $config['first_tag_close']	= '</li>';
        $config['prev_link']		= '«';
        $config['prev_tag_open']	= '<li class="prev">';
        $config['prev_tag_close']	= '</li>';
        $config['next_link']		= '»';
        $config['next_tag_open']	= '<li>';
        $config['next_tag_close']	= '</li>';
        $config['last_tag_open']	= '<li>';
        $config['last_tag_close']	= '</li>';
        $config['cur_tag_open']		= '<li class="active"><a href="#">';
        $config['cur_tag_close']	= '</a></li>';
        $config['num_tag_open']		= '<li>';
        $config['num_tag_close']	= '</li>';
		if($this->input->get('filter_category') || $this->input->get('filter_name'))
		{
			$config['suffix']		=  '/?'.http_build_query($this->input->get(), '', "&");
		}
        $this->pagination->initialize($config);

		$data 						= array();
		$data['page_title'] 		= 'Choose Component: '.$component_name;
		$data['page_name'] 			= 'pc-builder choose-component nologged';

		$data['component_id'] 		= $cat;
		$data['component_name'] 	= $component_name;
		
		if($this->session->user_id)
		{
			$data['page_name'] 		= 'pc-builder choose-component logged';
		}

        $data['page']       = $page;
        $data['total_rows'] = $config['total_rows'];
        $data['products']   = $this->pcbuilder->get_products($config["per_page"], $data['page'], $search, $category_id, $sortby, $component_slug);
        $data['pagination'] = $this->pagination->create_links();
		$data['sidebar']	= $this->load->view('sidebar', $data, true);

		$this->load->view('header', $data);
		$this->load->view('choose', $data);
		$this->load->view('footer', $data);
	}

	public function save()
	{		
		if(!$this->session->user_id)
		{
			redirect('account/?redirect_url='.base_url('pcbuilder/save'), 'refresh');
		}

		$data 					= array();
		$data['page_title'] 	= 'Save Your PC';
		$data['page_name'] 		= 'pc-builder save-component account logged';
		
		if($this->input->post())
		{
			$row_data					=	array();
			$row_data['user_id']		=	$this->session->user_id;
			$row_data['name']			=	$this->input->post('name');
			$row_data['description']	=	$this->input->post('description');
			$row_data['created_time']	=	date("Y-m-d H:i:s");
			$row_data['modified_time']	=	date("Y-m-d H:i:s");
			
			$this->form_validation->set_rules('name', 'pc name', 'trim|required');
			
			if ($this->form_validation->run())
			{
				$pcbuilder = $this->session->userdata('pcbuilder') ? $this->session->userdata('pcbuilder') : array();
				
				$row_data['components'] = serialize($pcbuilder);

				if(sizeof($pcbuilder)>0)
				{
					$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));

					if(sizeof($pcbuilder_settings)>0)
					{
						$required_empty_elm = 0;
						$redirect_empty_elm = '';

						foreach($pcbuilder_settings as $component)
						{
							$component_name = $component['component_name'];
							$component_id 	= $component['component_id'];
							$required 		= $component['required'];
							$component_slug = strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));
							$component_key 	= $component_slug.'-'.$component_id;

							if($redirect_empty_elm=='')
							{
								if($required==1 && (!isset($pcbuilder[$component_key]) || (isset($pcbuilder[$component_key]) && empty($pcbuilder[$component_key]))))
								{
									$redirect_empty_elm = 'pcbuilder/?message=field-empty&ref=quote&field='.$component_name;

									$required_empty_elm++;
								}
							}
						}
					}

					if($required_empty_elm > 0)
					{
						redirect($redirect_empty_elm, 'refresh');
					}
					else
					{
						if($this->pcbuilder->add_new_pc($row_data))
						{
							redirect('pcbuilder/savedpc/?message=success&purpose=save', 'refresh');
						}
						else
						{
							redirect('pcbuilder/savedpc/?message=false&msg=failed+to+save', 'refresh');
						}
					}
				}
				else
				{
					redirect('pcbuilder/savedpc/?message=false&msg=failed+to+save', 'refresh');
				}
			}
		}

		$this->load->view('header', $data);
		$this->load->view('save', $data);
		$this->load->view('footer', $data);
	}

	public function savedpc()
	{
		if(!$this->session->user_id)
		{
			redirect('account/?redirect_url='.base_url('pcbuilder/savedpc'), 'refresh');
		}

		$data = array();
		$data['page_title'] 	= 'Saved PC';
		$data['page_name'] 		= 'pc-builder save-component account logged';

		if($this->input->get('pc_id'))
		{
			$data['saved_pc']	= $this->pcbuilder->get_saved_pc($this->session->user_id, $this->input->get('pc_id'));
		}
		else
		{
			$data['saved_pcs']	= $this->pcbuilder->get_saved_pcs($this->session->user_id);
		}

		$this->load->view('header', $data);
		$this->load->view('savedpc', $data);
		$this->load->view('footer', $data);
	}

	public function quote()
	{		
		if(!$this->session->user_id)
		{
			redirect('account/?redirect_url='.base_url('pcbuilder/savedpc'), 'refresh');
		}

		$pcbuilder 	= $this->session->userdata('pcbuilder') ? $this->session->userdata('pcbuilder') : array();

		$row_data					= array();
		$row_data['user_id']		= $this->session->user_id;
		$row_data['components'] 	= serialize($pcbuilder);
		$row_data['created_time']	= date("Y-m-d H:i:s");
		$row_data['modified_time']	= date("Y-m-d H:i:s");

		if(!sizeof($pcbuilder))
		{
			redirect('pcbuilder/?message=false&ref=quote', 'refresh');
		}

		$pcbuilder_settings = unserialize(get_option('pcbuilder_settings'));

		if(sizeof($pcbuilder_settings)>0)
		{
			$required_empty_elm = 0;
			$redirect_empty_elm = '';

			foreach($pcbuilder_settings as $component)
			{
				$component_name = $component['component_name'];
				$component_id 	= $component['component_id'];
				$required 		= $component['required'];
				$component_slug = strtolower(str_replace(array('_', ' ', '---'), array('-', '-', '-'), $component_name));
				$component_key 	= $component_slug.'-'.$component_id;

				if($redirect_empty_elm=='')
				{
					if($required==1 && (!isset($pcbuilder[$component_key]) || (isset($pcbuilder[$component_key]) && empty($pcbuilder[$component_key]))))
					{
						$redirect_empty_elm = 'pcbuilder/?message=field-empty&ref=quote&field='.$component_name;

						$required_empty_elm++;
					}
				}
			}
		}

		if($required_empty_elm > 0)
		{
			redirect($redirect_empty_elm, 'refresh');
		}
		else
		{
			if($this->pcbuilder->add_new_quote($row_data))
			{
				redirect('pcbuilder/?message=success&ref=quote', 'refresh');
			}
			else
			{
				redirect('pcbuilder/?message=false&ref=quote', 'refresh');
			}
		}
	}

	public function admin_quote()
	{
		if(!$this->session->user_id)
		{
			redirect('admin', 'refresh');
		}

		$data 					= array();
		$data['page_title']		= 'PC Builder Quote';
		$data['form_title']		= 'Update';
		$data['user_sidebar']	= $this->load->view('admin/sidebar', $data, true);

		$data['quotes']			= $this->pcbuilder->get_quotes();
		
		if($this->session->user_type=='admin' || $this->session->user_type=='super-admin')
		{
			$this->load->view('header', $data);
			$this->load->view('quote', $data);
			$this->load->view('footer', $data);
		}
		else
		{
			redirect('authentication-failure', 'refresh');
		}
	}

	public function admin_quote_view($quote_id)
	{
		if($this->session->user_id)
		{
			$data['page_title']		= 'PC Builder Quote: '.$quote_id;
			$data['form_title']		= 'Update';
			$data['user_sidebar']	= $this->load->view('admin/sidebar', $data, true);

			$data['quote']			= $this->pcbuilder->get_quote($quote_id);
			
			if($this->session->user_type=='admin' || $this->session->user_type=='super-admin')
			{
				if($this->input->post())
				{
					// $row_data						= array();
					// $componentes					= $this->input->post('component');
					// $row_data['pcbuilder_settings']	= serialize($componentes);
					// $data['componentes']			= $componentes;
					
					// foreach($row_data as $key=>$val)
					// {
					// 	update_option($key, $val);
					// }
					
					// redirect('admin/pcbuilder/settings/?message=success&purpose=update+options', 'refresh');
				}
				else
				{
					$this->load->view('header', $data);
					$this->load->view('quote_view', $data);
					$this->load->view('footer', $data);
				}
			}
			else
			{
				redirect('authentication-failure', 'refresh');
			}
		}
		else
		{
			redirect('admin', 'refresh');
		}
	}

	public function settings()
	{
		if($this->session->user_id)
		{
			$data['page_title']		= 'PC Builder Settings';
			$data['form_title']		= 'Update';
			$data['user_sidebar']	= $this->load->view('admin/sidebar', $data, true);
			
			if($data['user_type']=='admin' || $data['user_type']=='super-admin')
			{
				if($this->input->post())
				{
					$row_data						= array();
					$amd_motherboard_ids			= $this->input->post('amd_motherboard_ids');
					$amd_ram_ids					= $this->input->post('amd_ram_ids');
					$intel_motherboard_ids			= $this->input->post('intel_motherboard_ids');
					$intel_ram_ids					= $this->input->post('intel_ram_ids');
					$cpu_id							= $this->input->post('cpu_id');
					$componentes					= $this->input->post('component');

					$row_data['amd_motherboard_ids']	= $amd_motherboard_ids;
					$row_data['amd_ram_ids']			= $amd_ram_ids;
					$row_data['intel_motherboard_ids']	= $intel_motherboard_ids;
					$row_data['intel_ram_ids']			= $intel_ram_ids;
					$row_data['cpu_id']					= $cpu_id;

					$row_data['pcbuilder_settings']	= serialize($componentes);
					$data['componentes']			= $componentes;
					
					foreach($row_data as $key=>$val)
					{
						update_option($key, $val);
					}
					
					redirect('admin/pcbuilder/settings/?message=success&purpose=update+options', 'refresh');
				}
				else
				{
					$this->load->view('header', $data);
					$this->load->view('settings', $data);
					$this->load->view('footer', $data);
				}
			}
			else
			{
				redirect('authentication-failure', 'refresh');
			}
		}
		else
		{
			redirect('admin', 'refresh');
		}
	}

	public function product_mapping()
	{
		if($this->session->user_id)
		{
			$data['page_title']		= 'PC Builder Product Mapping';
			$data['user_sidebar']	= $this->load->view('admin/sidebar', $data, true);

			$cpu_id 				= get_option('cpu_id');

			$data['cpu_products']   = $this->pcbuilder->get_products(null, null, null, $cpu_id);
			
			if($data['user_type']=='admin' || $data['user_type']=='super-admin')
			{
				if($this->input->post())
				{
					$row_data = $this->input->post();

					foreach($row_data as $key=>$val)
					{
						update_option($key, $val);
					}
					
					redirect('admin/pcbuilder/product_mapping/?message=success&purpose=update+product+mapping', 'refresh');
				}
				else
				{
					$this->load->view('header', $data);
					$this->load->view('product_mapping', $data);
					$this->load->view('footer', $data);
				}
			}
			else
			{
				redirect('authentication-failure', 'refresh');
			}
		}
		else
		{
			redirect('admin', 'refresh');
		}
	}

	function makepdf($pc_id=null)
	{
		$page_title 			= 'Download SavedPC';
		$data['user_id']		= $this->session->user_id;
		$data['page_title']		= $page_title;

		if(!empty($pc_id))
		{
			$saved_pc = $this->pcbuilder->get_saved_pc($this->session->user_id, $pc_id);

			if(!empty($saved_pc))
			{
				$pc_componentes = unserialize($saved_pc->components);

				$filename = 'pcbuilder_items_'.time();

				ob_start();
				include('villageapp/modules/pcbuilder/views/download_savedpc.php');
				$html = ob_get_clean();

				$this->pdfgenerator->generate($html, $filename);
			}
		}
		else
		{
			if($this->session->userdata('pcbuilder'))
			{
				$pc_componentes = $this->session->userdata('pcbuilder');

				if(!empty($pc_componentes))
				{
					$filename 	= time().'_pcbuilder.pdf';
					ob_start();
					include('villageapp/modules/pcbuilder/views/download_savedpc.php');
					$html = ob_get_clean();

					$this->pdfgenerator->generate($html, $filename);
				}
			}
		}
	}
}