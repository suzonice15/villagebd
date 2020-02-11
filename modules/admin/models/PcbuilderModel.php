<?php
Class PcbuilderModel extends CI_Model
{
	/*# product result by category_id and sub_category_id for frontend archive view #*/
	public function get_products($limit, $start, $q=null, $cat=null, $sortby=null, $component_slug=null)
	{
    	$in_sql = null;
    	$w_in_sql = null;

		if($component_slug=='motherboard')
		{
			$processor_id 	= $this->session->userdata('pc_builder_processor_id');
			$processor 		= $this->session->userdata('pc_builder_processor');

			if($processor=='amd')
			{
				$not_in_ids = get_option('amd_motherboard_ids');

				if(!empty($processor_id))
				{
					$amd_motherboard_ids = get_option('product_mapping_amd_motherboard_ids_'.$processor_id);

					if(!empty($amd_motherboard_ids))
					{
						$not_in_ids = $amd_motherboard_ids;
					}
				}
			}
			else
			{
				$not_in_ids = get_option('intel_motherboard_ids');

				if(!empty($processor_id))
				{
					$intel_motherboard_ids = get_option('product_mapping_intel_motherboard_ids_'.$processor_id);

					if(!empty($intel_motherboard_ids))
					{
						$not_in_ids = $intel_motherboard_ids;
					}
				}
			}

			$in_sql = "AND term_relation.term_id in ($not_in_ids)";

			$w_in_sql = "WHERE term_relation.term_id in ($not_in_ids)";
		}
		elseif($component_slug=='ram-1' || $component_slug=='ram-1')
		{
			$processor_id 	= $this->session->userdata('pc_builder_processor_id');
			$processor 		= $this->session->userdata('pc_builder_processor');

			if($processor=='amd')
			{
				$not_in_ids = get_option('amd_ram_ids');

				if(!empty($processor_id))
				{
					$amd_ram_ids = get_option('product_mapping_amd_ram_ids_'.$processor_id);

					if(!empty($amd_ram_ids))
					{
						$not_in_ids = $amd_ram_ids;
					}
				}
			}
			else
			{
				$not_in_ids = get_option('intel_ram_ids');

				if(!empty($processor_id))
				{
					$intel_ram_ids = get_option('product_mapping_amd_ram_ids_'.$processor_id);

					if(!empty($intel_ram_ids))
					{
						$not_in_ids = $intel_ram_ids;
					}
				}
			}

			$in_sql = "AND term_relation.term_id in ($not_in_ids)";

			$w_in_sql = "WHERE term_relation.term_id in ($not_in_ids)";
		}

		if($q != null)
		{
			$queries = explode(' ', $q);

			foreach($queries as $qs){ $psearch[] = "LOCATE('$qs', product_title)"; }

			$psearch = implode(" AND ", $psearch);
			
			if(!empty($limit))
			{
				$sql = "SELECT *, $psearch FROM product WHERE $psearch > 0 $in_sql ORDER BY $psearch LIMIT $start, $limit";
			}
			else
			{
				$sql = "SELECT *, $psearch FROM product WHERE $psearch > 0 $in_sql ORDER BY $psearch";
			}

			if($cat)
			{
				$psearch2 = array();
				$queries = explode(' ', $q);

				foreach($queries as $qs){ $psearch2[] = "LOCATE('$qs', product.product_title)"; }
				
				$psearch2 = implode(" AND ", $psearch2);

				if($in_sql)
				{
					if(!empty($limit))
					{
						$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id $in_sql ORDER BY $psearch2 LIMIT $start, $limit";
					}
					else
					{
						$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id $in_sql ORDER BY $psearch2";
					}
				}
				else
				{
					if(!empty($limit))
					{
						$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id AND term_relation.term_id = $cat ORDER BY $psearch2 LIMIT $start, $limit";
					}
					else
					{
						$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id AND term_relation.term_id = $cat ORDER BY $psearch2";
					}
				}
			}

	        $query = $this->db->query($sql);
	        return $query->result();
		}
		else
		{
			if($sortby=='rating_desc')
			{
				$this->db->select('*, AVG(review.rating) as rating_avg');
				$this->db->from('product');
				$this->db->join('term_relation', 'product.product_id = term_relation.product_id');
				$this->db->join('review', 'product.product_id = review.product_id');
				$this->db->where('term_relation.term_id', $cat);
				$this->db->group_by('review.product_id');
				$this->db->order_by('rating_avg', 'DESC');

				if(!empty($limit))
				{
					$this->db->limit($limit, $start);
				}

				$query = $this->db->get();
				return $query->result();
			}
			else
			{
				$order_by_sql = 'ORDER BY product.product_id DESC';

				if($sortby=='price_asc')
				{
					$order_by_sql = 'ORDER BY product.product_price ASC';
				}
				elseif($sortby=='price_desc')
				{
					$order_by_sql = 'ORDER BY product.product_price DESC';
				}
				elseif($sortby=='name_asc')
				{
					$order_by_sql = 'ORDER BY product.product_title ASC';
				}
				elseif($sortby=='name_desc')
				{
					$order_by_sql = 'ORDER BY product.product_title DESC';
				}
			
				if(!empty($limit))
				{
					$sql = "SELECT * FROM product $w_in_sql $order_by_sql LIMIT $start, $limit";
				}
				else
				{
					$sql = "SELECT * FROM product $w_in_sql $order_by_sql";
				}

				if($cat)
				{
					if($in_sql)
					{
						if(!empty($limit))
						{
							$sql = "SELECT * FROM product INNER JOIN `term_relation` WHERE product.product_id = term_relation.product_id $in_sql $order_by_sql LIMIT $start, $limit";
						}
						else
						{
							$sql = "SELECT * FROM product INNER JOIN `term_relation` WHERE product.product_id = term_relation.product_id $in_sql $order_by_sql";
						}
					}
					else
					{
						if(!empty($limit))
						{
							$sql = "SELECT * FROM product INNER JOIN `term_relation` WHERE product.product_id = term_relation.product_id AND term_relation.term_id = $cat $order_by_sql LIMIT $start, $limit";
						}
						else
						{
							$sql = "SELECT * FROM product INNER JOIN `term_relation` WHERE product.product_id = term_relation.product_id AND term_relation.term_id = $cat $order_by_sql";
						}
					}
				}

				$query = $this->db->query($sql);
				return $query->result();
			}
		}
    }

    function get_products_count($q=null, $cat=null, $component_slug=null)
    {
    	$in_sql = null;
    	$w_in_sql = null;

		if($component_slug=='motherboard')
		{
			$pc_builder_processor = $this->session->userdata('pc_builder_processor');

			if($pc_builder_processor=='amd')
			{
				$not_in_ids = get_option('amd_motherboard_ids');
			}
			else
			{
				$not_in_ids = get_option('intel_motherboard_ids');
			}

			$in_sql = "AND term_relation.term_id in ($not_in_ids)";

			$w_in_sql = "WHERE term_relation.term_id in ($not_in_ids)";
		}
		elseif($component_slug=='ram-1' || $component_slug=='ram-1')
		{
			$pc_builder_processor = $this->session->userdata('pc_builder_processor');

			if($pc_builder_processor=='amd')
			{
				$not_in_ids = get_option('amd_ram_ids');
			}
			else
			{
				$not_in_ids = get_option('intel_ram_ids');
			}

			$in_sql = "AND term_relation.term_id in ($not_in_ids)";

			$w_in_sql = "WHERE term_relation.term_id in ($not_in_ids)";
		}

		$queries = explode(' ', $q);

		foreach($queries as $qs){ $psearch[] = "LOCATE('$qs', product_title)"; }

		$psearch = implode(" AND ", $psearch);
		
		$sql = "SELECT *, $psearch FROM product WHERE $psearch > 0 $in_sql ORDER BY $psearch";

		if($cat)
		{
			$psearch2 	= array();
			$queries 	= explode(' ', $q);

			foreach($queries as $qs){ $psearch2[] = "LOCATE('$qs', product.product_title)"; }
			
			$psearch2 	= implode(" AND ", $psearch2);

			if($in_sql)
			{
				$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id $in_sql ORDER BY $psearch2";
			}
			else
			{
				$sql = "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id AND term_relation.term_id = $cat ORDER BY $psearch2";
			}
		}

        $query = $this->db->query($sql);
        return $query->num_rows();
    }
}