<?php 
class Assessment_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
//get assessment for candidate registration
public function get_assessment($assessmentID = NULL) {
    $result = NULL;
        if(!is_null($assessmentID)) {
            $query = $this->db->get_where('assessment' , array('id' => $assessmentID));
            $result = $query->row_array();
        } else {
            $query = $this->db->get('assessment');
            $result = $query->result_array();
        }
      return $result;
    }  

//save assessment
public function save_assessment($assessment, $candidateId) {
    $assessment['reg_no'] =$candidateId;
        $this->db->insert('assessment' , $assessment);
    return ($this->db->affected_rows()) ? true : false; 
}

//update assessment
public function update_assessment($assessment) {
    
      $this->db->where('id', $assessment['id']);
    return $this->db->update('assessment' , $assessment);
}
}
?>
}