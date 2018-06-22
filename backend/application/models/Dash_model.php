<?php
class Dash_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_payment($center_id){

        //$user = $this->session->get_userdata();
        $this->db->select('COUNT(assessment.can_regno) as total');
        $this->db->from('assessment');
        $this->db->where('assessment.paid',1);
       // $this->db->where('assessment.center_code',00);
        $this->db->group_by('assessment.center_code');
        $this->db->where('assessment.center_code',  $center_id);
        $query = $this->db->get(); 
        return $query->num_rows();
    }
    public function get_admission($center_id){

        $this->db->select('count(candidate.reg_no) as total');
        $this->db->from('candidate');
        $this->db->where('candidate.print_admission', 'No' );
        $this->db->join('assessment','candidate.reg_no = assessment.can_regno');
        $this->db->where('assessment.center_code',$center_id);
        $this->db->group_by('assessment.center_code');
        $query = $this->db->get(); 
        return $query->num_rows();
    }

    public function get_schedule($center_id){

        $user = $this->session->get_userdata();
        $this->db->select('count(candidate_group.gr_id) as total');
        $this->db->from('schedule');
        $this->db->join('candidate_group','schedule.group_no = candidate_group.gr_id','left');

        $this->db->join('assessment','assessment.exam_id = candidate_group.exam_id','left');
        $this->db->where('schedule.center_code', $center_id);
        $this->db->where('schedule.scheduled_date <=', date('YYYY-mm-dd') );

        $this->db->group_by('candidate_group.gr_id');
        $query = $this->db->get(); 

    return $query->num_rows();
    }
        public function get_result($center_id) {
            $this->db->select('count(assessment.can_regno) as total');
            $this->db->from('assessment');
            $this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id','left');
            $this->db->join('schedule','schedule.group_no = candidate_group.gr_id','left');
            $this->db->join('center','assessment.center_code = center.center_code','left');
            $this->db->where('assessment.center_code',  $center_id);
            $this->db->group_by('assessment.center_code');        
            $query = $this->db->get(); 
            return $query->num_rows();
        }
}
?>
        
      