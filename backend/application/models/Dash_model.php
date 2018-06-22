<?php
class Dash_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_payment(){

        //$user = $this->session->get_userdata();
        $this->db->select('COUNT(assessment.can_regno) as total');
        $this->db->from('assessment');
        $this->db->where('assessment.paid',1);
       // $this->db->where('assessment.center_code',00);
        $this->db->group_by('assessment.center_code');
        // $this->db->where('assessment.center_code',  $user['center_code']);
        $query = $this->db->get(); 
        if($query->num_rows() != 0){
            return $query->result_array();
        } else {    
            return false;
        }
    }
    public function get_admission(){

      //  $user = $this->session->get_userdata();
        $this->db->select('count(candidate.reg_no) as total');
        $this->db->from('candidate');
        $this->db->where('candidate.print_admission', 'No' );
       // $this->db->where('assessment.center_code',  $user['center_code']);
        $this->db->join('assessment','candidate.reg_no = assessment.can_regno');
       // $this->db->where('assessment.center_code',00);
        $this->db->group_by('assessment.center_code');
        $query = $this->db->get(); 
        if($query->num_rows() != 0){
            return $query->result_array();
        } else {    
            return false;
        }
    }

    public function get_schedule(){

        $user = $this->session->get_userdata();
        $this->db->select('count(schedule.sch_id) as total');
        $this->db->from('schedule');
        $this->db->join('candidate_group','schedule.group_no = candidate_group.gr_id','left');
        //$this->db->where('assessment.center_code',  $user['center_code']);
        
        $this->db->group_by('candidate_group.gr_id');
        $query = $this->db->get(); 
        if($query->num_rows() != 0){
            return $query->result_array();
        } else {    
            return false;
        }}
        public function get_result(){

            //$user = $this->session->get_userdata();
            $this->db->select('count(assessment.can_regno) as total');
            $this->db->from('assessment');
            $this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id','left');
            $this->db->join('schedule','schedule.group_no = candidate_group.gr_id','left');
           //$this->db->join('assessment','candidate.reg_no = assessment.can_regno');
            $this->db->join('center','assessment.center_code = center.center_code','left');
            //$this->db->where('assessment.center_code',00);
            $this->db->group_by('assessment.center_code');        
           // $this->db->where('assessment.center_code',  $user['center_code']);
            $query = $this->db->get(); 
            if($query->num_rows() != 0){
                return count($query->result_array());
            } else {    
                return false;
            }
        }
}
?>
        
      