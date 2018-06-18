<?php

class Result_model extends MY_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

public function get_result() {
    
       $this->db->select('exam_id,can_regno,occ_code,practical_result,knowledge_result');
       $this->db->from('assessment');
       $where = "practical_result='Satisfactory' AND knowledge_result >=20 ";
       $this->db->where($where);
       $this->db->join('candidate','candidate.id=assessment.exam_id','left');
    
      
       //$query = $this->db->query("SELECT `exam_id`, `can_regno`, `occ_code`, `practical_result`, `knowledge_result` FROM assessment WHERE (`practical_result` = `Satisfactory` AND `knowledge_result` >= 50 FROM assessment ) AS COMPITANT");
        
        //$this->db->get($query);
      
        // $this->db->orderd_by('registration_date','desc');
       // $this->db->join('candidate','candidate.full_name = assessment.exam_id','left');
        $query=$this->db->get();
        return $query->result_array();
    }

   
}
?>
