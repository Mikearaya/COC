<?php 
class Init_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	function initialize_registration() {
		$this->db->select('LOWER(lookup_type) as field , UPPER(lookup_value) as value');
		$this->db->where('lookup_type !=', null);
		$query = $this->db->get_where('lookup');
		$result = $query->result_array();
		$fixed = [];

		for($i = 0 ; $i < $query->num_rows(); $i++){
			foreach ($result[$i] as $key => $value) {
				$key2 = '';
			if($key == 'field') {
				$value2 = preg_replace('/\s+/', '_', $value);
			
				$fixed[$i][$key] = $value2;
			} else {
				$fixed[$i][$key] =  $value;
			}
		
		
			}

	}
	return $fixed;
	}
}

?>
