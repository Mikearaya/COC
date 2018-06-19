<?php 
 class Admission_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_admission(){
        $this->db->select('candidate.full_name, candidate.reg_no,assessment.registered_by,center.center_name,occupation.occ_name,occupation.level,
                          assessment.paid,assessment.amount_paid ,assessment.registration_date,assessment.invoice_no');
                           
        $this->db->from('center');
        $this->db->where('paid',1);
        $this->db->join('assessment','center.center_code=assessment.center_code');
        $this->db->join('candidate','candidate.reg_no = assessment.can_regno');
        $this->db->join('occupation','occupation.occ_code = assessment.occ_code');
        $this->db->order_by('assessment.registration_date','desc');         
        $query = $this->db->get(); 
             print_r($query->result());
            
    }
 }
 ?>