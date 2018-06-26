<?php 
 class Candidate_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

//get candidate 
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
//save candidate  
public function save_candidate($candidate) {
    if(false) {
        return $this->update_candidate($candidate);
      
    } else {
        $candidate['reg_no'] = $candidate['cell_phone'];
        $this->db->insert('candidate' , $candidate);        
    }


    return ($this->db->affected_rows()) ? $candidate['cell_phone'] : false; 
}
// save assessment
public function save_assessment($assessment, $candidateId) {
    $assessment['can_regno'] =$candidateId;
	$assessment['registered_by'] = $this->session->userdata('focal_name');
	$assessment['center_code'] = $this->session->userdata('center_code');
	$assessment['payment_status'] = 'PENDING';
    $assessment['paid'] = ($assessment['paid'] == 'true') ? 1 : 0;
         
    $this->db->insert('assessment' , $assessment);
return ($this->db->affected_rows()) ? $candidateId : false; 
}
//update candidate
public function update_candidate($candidate) {    
      $this->db->where('reg_no', $candidate['reg_no']);
    return $this->db->update('candidate' , $candidate);
}

//check candidate is registerd
public function check_candidate_exist($cell) {
        $this->db->where('cell_phone', $cell);
        $this->db->select('reg_no', 'cell_phone');
        $result = $this->db->get('candidate');
        if($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
	}
    
//get candidate phone number
	public function candidate_has_account($phoneNumber) {
		$result = $this->db->get_where('candidate', array('cell_phone' => trim($phoneNumber)));
				if($this->db->affected_rows() === 1) {
						return $result->row_array();	
				} else {
					return false;
				}
	}

}
?>
