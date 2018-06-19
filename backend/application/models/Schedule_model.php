<?php 
 class Schedule_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_schedule($scheduleID = NULL) {
        $result = NULL;
            if(!is_null($scheduleID)) {
                $query = $this->db->get_where('schedule' , array('id' => $scheduleID));
                $result = $query->row_array();
            } else {
                $query = $this->db->get('schedule');
                $result = $query->result_array();
            }
          return $result;
        }  
 }
?>