<?php 
 class Schedule_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_schedule($scheduleID = NULL) {
      // assessment schedule
      $this->db->select('candidate_group.gr_id , candidate_group.sch_id , center.center_name ,  schedule.scheduled_date, schedule.time, COUNT(candidate_group.exam_id) as total,
      assessment.occ_code');
      $this->db->from('assessment');
      $this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id','left');
      $this->db->join('schedule','schedule.group_no = candidate_group.gr_id','left');
      $this->db->join('center','assessment.center_code = center.center_code','left');
      
      $this->db->group_by('candidate_group.gr_id');

        $query = $this->db->get();
              
            return $query->result_array();
        } 
 }
?>