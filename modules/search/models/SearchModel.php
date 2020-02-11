<?php
Class SearchModel extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }

    //fetch books
    function get_products($limit, $start, $q=null, $cat=null)
    {
		$queries 	= explode(' ', $q);

		foreach($queries as $qs){ $psearch[] = "LOCATE('$qs', product_title)"; }

		$psearch = implode(" AND ", $psearch);
		
		$sql 	= "SELECT *, $psearch FROM product WHERE $psearch > 0 ORDER BY $psearch LIMIT $start, $limit";

		if($cat)
		{
			$psearch2 	= array();
			$queries 	= explode(' ', $q);

			foreach($queries as $qs){ $psearch2[] = "LOCATE('$qs', product.product_title)"; }
			
			$psearch2 	= implode(" AND ", $psearch2);

			$sql 		= "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id AND term_relation.term_id = $cat ORDER BY $psearch2 LIMIT $start, $limit";
		}

        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_products_count($q=null, $cat=null)
    {
		$queries 	= explode(' ', $q);

		foreach($queries as $qs){ $psearch[] = "LOCATE('$qs', product_title)"; }

		$psearch = implode(" AND ", $psearch);
		
		$sql 	= "SELECT *, $psearch FROM product WHERE $psearch > 0 ORDER BY $psearch";

		if($cat)
		{
			$psearch2 	= array();
			$queries 	= explode(' ', $q);

			foreach($queries as $qs){ $psearch2[] = "LOCATE('$qs', product.product_title)"; }
			
			$psearch2 	= implode(" AND ", $psearch2);

			$sql 		= "SELECT *, $psearch2 FROM product INNER JOIN `term_relation` WHERE $psearch2 > 0 AND product.product_id = term_relation.product_id AND term_relation.term_id = $cat ORDER BY $psearch2";
		}

        $query = $this->db->query($sql);
        return $query->num_rows();
    }
}