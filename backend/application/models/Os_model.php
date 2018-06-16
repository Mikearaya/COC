<?php
 class Os_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_os($os_type = NULL, $os_code = NULL) {
        $result = NULL;
        $query = '';
            if(!is_null($os_code) && !is_null($os_type) ) {
                $key_name = '';
                switch ($os_type) {
                    case 'sector': $key_name = 'parent';
                    break;
                    case 'occupation': $key_name = 'sector_id';
                    break;
                    case 'unit_of_competency':  $key_name = 'occ_code';
                    break;
                    default : $key_name = NULL;
                }
                    $query = $this->db->get_where($os_type, array($key_name => $os_code));            
                $result = $query->result_array();
            } else {
                if($os_type == 'sector') {
                    $query = $this->db->get_where($os_type, array('parent' => $os_code));
                } else {
                $query = $this->db->get($os_type);
                }
                $result = $query->result_array();
            }
          return $result;
        }

    public function get_occupation($sector_id = NULL) {
            $result = NULL;
                if(!is_null($sector_id)) {
                    $query = $this->db->get_where('occupation' , array('sector_id' => $sector_id));
                    $result = $query->row_array();
                } else {
                    $query = $this->db->get('occupation');
                    $result = $query->result_array();
                }
              return $result;
            }

    public function get_unit_of_competency($occupation_id = NULL) {
                $result = NULL;
                    if(!is_null($occupation_id)) {
                        $query = $this->db->get_where('unit_of_competency' , array('occ_code' => $occupation_id));
                        $result = $query->row_array();
                    } else {
                        $query = $this->db->get('unit_of_competency');
                        $result = $query->result_array();
                    }
                  return $result;
                }
    public function get_assessment_price($occupation_id = NULL) {
                    $result = NULL;
                        if(!is_null($occupation_id)) {
                            $query = $this->db->get_where('assessment_price' , array('occ_code' => $occupation_id));
                            $result = $query->row_array();
                        } else {
                            $query = $this->db->get('assessment_price');
                            $result = $query->result_array();
                        }
                      return $result;
                    }
 }
?>

