<?php

class Result_model extends MY_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
  }
//get compitant candidate 
public function get_result($limit,$current_page) {
    
			 $this->db->select('assessment.exam_id,candidate_group.gr_id , candidate_group.sch_id , center.center_name , 
			  schedule.scheduled_date, schedule.time, COUNT(candidate_group.exam_id) as total,
       assessment.occ_code');
       $this->db->from('assessment');
       $this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id' );
       $this->db->join('schedule','schedule.group_no = candidate_group.gr_id');
			 $this->db->join('center','assessment.center_code = center.center_code');
			 $this->db->where('assessment.center_code', $this->session->userdata('center_code'));
			 $this->db->where('LOWER(schedule.evaluated)', 'yes');
			 $this->db->group_by('candidate_group.gr_id');
	
			 $offset = $limit * ($current_page - 1);
			 $cloned_db = clone $this->db;
			 $result['total'] = $cloned_db->count_all_results();
						 $this->db->limit($limit,$offset);
			 $query = $this->db->get();
			 $result['rows'] = $query->result_array();
			 
						 return $result;
        
    }

public function get_group_result($id = NULL) {

    $this->db->select("candidate.full_name, assessment.can_regno, assessment.exam_id, candidate_group.gr_id,
												assessment.occ_code, center.center_code, center.center_name, 
										IF(practical_result < 50 , 
														IF(practical_result = NULL OR practical_result = '', 'NA', 'NS')
														 , 'S') as 'practical_result', 
														 IF(knowledge_result < 50 ,'NS', 'S') as 'knowledge_result',
												schedule.sch_id, occupation.occ_name, schedule.scheduled_date, schedule.time ");
    $this->db->from('assessment');
    $this->db->join('candidate', 'assessment.can_regno = candidate.reg_no');
    $this->db->join('occupation', 'assessment.occ_code = occupation.occ_code');
    $this->db->join('candidate_group', 'candidate_group.exam_id = assessment.exam_id');
    $this->db->join('schedule', 'candidate_group.sch_id = schedule.sch_id');
		$this->db->join('center', 'schedule.center_code = center.center_code');
		$this->db->where('candidate_group.gr_id', $id);
		$result = $this->db->get();
			$result_array = $result->result_array();
			for($i = 0; $i < $result->num_rows(); $i++) {
			
				if($result_array[$i]['practical_result'] === 'S' && $result_array[$i]['knowledge_result'] === 'S' ) {
					$result_array[$i]['status'] = 'S';
				} else if(($result_array[$i]['practical_result'] === 'S' && $result_array[$i]['knowledge_result'] === 'NS' )
										||
								($result_array[$i]['practical_result'] === 'NS' && $result_array[$i]['knowledge_result'] === 'S' )  ){
							
							$result_array[$i]['status'] = 'NS';
				} else if($result_array[$i]['practical_result'] === 'NA' && $result_array[$i]['knowledge_result'] === 'S' ) {
								$result_array[$i]['status'] = 'S';
				} else if($result_array[$i]['practical_result'] == 'NA' && $result_array[$i]['knowledge_result'] == 'NS' ) {
					$result_array[$i]['status'] = 'NS';
			
				} else if($result_array[$i]['practical_result'] == 'NS' && $result_array[$i]['knowledge_result'] == 'NS' ) {
					$result_array[$i]['status'] = 'NS';
				}
			}

    return $result_array; 
}

   
}
?>
