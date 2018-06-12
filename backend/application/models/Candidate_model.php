<?php 
 class Candidate_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

public function get_candidate($candidateID = NULL) {
    $result = NULL;
        if(!is_null($candidateID)) {
            $query = $this->db->get_where('candidate' , array('id' => $candidateID));
            $result = $query->row_array();
        } else {
            $query = $this->db->get('candidate');
            $result = $query->result_array();
        }
      return $result;
    }  
public function save_candidate($candidate) {
    if(!is_null($candidate['id'])) {
        return $this->update_candidate($candidate);
    } else {
        $this->db->insert('candidate' , $candidate);
    }
    return ($this->db->affected_rows()) ? true : false; 
}

public function update_candidate($candidate) {
    
      $this->db->where('id', $candidate['id']);
    return $this->db->update('candidate' , $candidate);
}
}
?>