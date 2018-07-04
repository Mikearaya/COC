<?php 
 class Schedule_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //get assessment schedule
    public function get_schedule($limit,$current_page) {
      
	  $this->db->select('candidate_group.gr_id , candidate_group.sch_id , center.center_name , 
	  				 schedule.scheduled_date, schedule.time, COUNT(schedule.group_no) as total,
      				assessment.occ_code');
			$this->db->from('assessment');
			$this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id');
			$this->db->join('schedule','schedule.group_no = candidate_group.gr_id');
            $this->db->join('center','assessment.center_code = center.center_code');
          $this->db->where('assessment.center_code', $this->session->userdata('center_code'));
			$this->db->group_by('schedule.sch_id');
			

	  $offset = $limit * ($current_page - 1);
	  $cloned_db = clone $this->db;
	  $result['total'] = $cloned_db->count_all_results();
		 $this->db->limit($limit,$offset);
	  $query = $this->db->get();
	  $result['rows'] = $query->result_array();
	  
	  return $result;
        } 
    //get group schedule
        public function get_group_schedule($id) {
            $this->db->select('candidate.full_name, candidate.sex, assessment.can_regno, assessment.exam_id, candidate_group.gr_id,
                                assessment.occ_code, center.center_code, center.center_name, assessment.practical_result,
                                schedule.sch_id, occupation.occ_name, schedule.scheduled_date, schedule.time ');
            $this->db->from('candidate');            
            $this->db->join('assessment', 'assessment.can_regno = candidate.reg_no');
            $this->db->join('occupation', 'assessment.occ_code = occupation.occ_code');
            $this->db->join('candidate_group', 'candidate_group.exam_id = assessment.exam_id');
            $this->db->join('schedule', 'candidate_group.sch_id = schedule.sch_id');
            $this->db->join('center', 'schedule.center_code = center.center_code');
            $this->db->where('candidate_group.gr_id', $id);
            $this->db->where('assessment.center_code', $this->session->userdata('center_code'));
			$query = $this->db->get();
			$result = $query->result_array();
			
            return $result;
        }
 }
?>
