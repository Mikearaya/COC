<?php
 class Data_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_sector($sectorID = NULL) {
        $result = NULL;
            if(!is_null($sectorID)) {
                $query = $this->db->get_where('sector' , array('id' => $sectorID));
                $result = $query->row_array();
            } else {
                $query = $this->db->get('sector');
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