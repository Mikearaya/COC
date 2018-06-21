<?php

class Result_model extends MY_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
//get compitant candidate 
public function get_result() {
    
       $this->db->select('candidate_group.gr_id , candidate_group.sch_id , center.center_name ,  schedule.scheduled_date, schedule.time, COUNT(candidate_group.exam_id) as total,
       assessment.occ_code');
       $this->db->from('assessment');
       $this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id','left');
       $this->db->join('schedule','schedule.group_no = candidate_group.gr_id','left');
       $this->db->join('center','assessment.center_code = center.center_code','left');
       
       $this->db->group_by('candidate_group.gr_id');
    
        
        $query = $this->db->get(); 
            if($query->num_rows() != 0){
                return $query->result_array();
            } else {    
                return false;
        }
        
    }

public function get_group_result($id = NULL) {

    $this->db->select('candidate.full_name, assessment.can_regno, assessment.exam_id, candidate_group.gr_id,
                        assessment.occ_code, center.center_code, center.center_name, assessment.practical_result, knowledge_result, schedule.sch_id, occupation.occ_name, schedule.scheduled_date ');
    $this->db->from('candidate');
    $this->db->where('candidate_group.gr_id', $id);
    $this->db->join('assessment', 'assessment.can_regno = candidate.reg_no', 'left');

    $this->db->join('occupation', 'assessment.occ_code = occupation.occ_code', 'left');
    $this->db->join('candidate_group', 'candidate_group.exam_id = assessment.exam_id', 'left');
    $this->db->join('schedule', 'candidate_group.sch_id = schedule.sch_id', 'left');
    $this->db->join('center', 'schedule.center_code = center.center_code');
    $result = $this->db->get();
    return $result->result_array();
}

   
}
?>
