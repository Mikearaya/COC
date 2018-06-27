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
	// save assessment
	public function save_assessment($assessment, $candidate) {
		$result = false;
		try {
				$this->db->trans_start();
						if(trim($candidate['reg_no'])) {
							$assessment['can_regno'] =$candidate['reg_no'];
						} else {
							$candidate['reg_no'] = $candidate['cell_phone'];
							$this->db->insert('candidate' , $candidate);        
						}
						$selected_uc = [];
						if(isset($assessment['selected_uc'])) {
							$selected_uc = $assessment['selected_uc'];
							unset($assessment['selected_uc']);
						}
						$assessment['can_regno'] = $candidate['cell_phone'];
						$assessment['registered_by'] = $this->session->userdata('focal_name');
						$assessment['center_code'] = $this->session->userdata('center_code');
						$assessment['payment_status'] = 'PENDING';
				$assessment['apply_for_uc'] = ($assessment['apply_for_uc'] = 'true') ? 'Yes' : 'No';	
							
						$this->db->insert('assessment' , $assessment);    
						$assessment_id = $this->db->insert_id();
						if($assessment['apply_for_uc'] = 'Yes') {
							$ucs = [];
							for($i = 0; $i < count($selected_uc); $i++) {
								$this->db->insert('uc_application',array('exam_id' => $assessment_id,
											'uc_code' => $selected_uc[$i]));
								//$ucs[$i]['exam_id'] = $assessment_id;
								//$ucs[$i]['uc_code'] = $selected_uc[$i];
							}
							//$this->db->insert_batch('uc_application',array($ucs));
						}
			$this->db->trans_complete();

					if($this->db->trans_status() === false ) {
						$result = false;
					} else {
						$result = true;
					}
						
		} catch (Exception $e) {
			$result = false;
		}
	return $result; 
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
