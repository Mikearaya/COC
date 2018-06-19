<?php

class Result_model extends MY_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
//get compitant candidate 
public function get_result() {
    
       $this->db->select('candidate.full_name,candidate.reg_no, CONCAT(assessment.practical_result, assessment.practical_result) as result');
       $this->db->from('assessment');
       $where = "practical_result='Satisfactory' AND knowledge_result >=36";
       $this->db->where($where);
       $this->db->join('candidate','candidate.id=assessment.exam_id','left');
    
        
        $query = $this->db->get(); 
            if($query->num_rows() != 0){
                return $query->result_array();
            } else {    
                return false;
        }
        
    }

   
}
?>
