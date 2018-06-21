<?php 
 class Admission_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_admission($val = NULL){
        $this->db->select('candidate.full_name, candidate.reg_no,candidate.print_admission,assessment.registered_by,center.center_name,occupation.occ_name,occupation.level,
                          assessment.paid,assessment.amount_paid ');
                           
		$this->db->from('candidate');
		$this->db->like('full_name', $val );
		$this->db->where('paid', 0);
		$this->db->limit(20);
        $this->db->where('candidate.print_admission','no');
        $this->db->join('assessment','candidate.reg_no = assessment.can_regno');
        $this->db->join('center','center.center_code = assessment.center_code');
        $this->db->join('occupation','occupation.occ_code = assessment.occ_code');       
        $query = $this->db->get(); 
		return $query->result_array();
            
    }
 }
 ?>
