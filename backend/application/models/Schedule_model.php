<?php 
 class Schedule_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_schedule($scheduleID = NULL) {
      // assessment schedule
        $this->db->select('*');
        $this->db->from('schedule');
        $this->db->join('candidate_group','candidate_group.sch_id=schedule.sch_id','left');
        $this->db->group_by('gr_id'); 

        $query = $this->db->get();
              
            print_r($query->result());
        } 
 }
?>