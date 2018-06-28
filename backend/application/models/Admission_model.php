<?php 
 class Admission_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_admission($val = NULL){
        $this->db->select("candidate.full_name, invoice.date, candidate.reg_no,candidate.print_admission,assessment.registered_by,center.center_name,occupation.occ_name,occupation.level,
						  assessment.paid,assessment.amount_paid, schedule.supervisor, invoice.invoice_no, schedule.scheduled_date, schedule.time,
						  assessor.full_name as 'assessor' ");
                           
		$this->db->from('candidate');
		$this->db->like('candidate.full_name', $val);

		$this->db->limit(20);
       // $this->db->where('LOWER(assessment.payment_status)','paid');
        $this->db->join('assessment','candidate.reg_no = assessment.can_regno');
        $this->db->join('center','center.center_code = assessment.center_code');
		$this->db->join('occupation','occupation.occ_code = assessment.occ_code'); 
		$this->db->join('invoice','invoice.invoice_no = assessment.invoice_no');
		$this->db->join('candidate_group','candidate_group.exam_id = assessment.exam_id', 'left'); 
		$this->db->join('schedule','candidate_group.gr_id = schedule.group_no','left');
		$this->db->join('assessor','assessor.ass_id = schedule.assr_id','left'); 
        $this->db->where('assessment.center_code', $this->session->userdata('center_code'));     
        $query = $this->db->get(); 
		return $query->result_array();
            
    }

    function get_admission_card_info($assessment_ids) {

        $this->db->select("candidate.full_name, candidate.reg_no,candidate.print_admission,assessment.registered_by,center.center_name,occupation.occ_name,occupation.level,
                          assessment.paid,assessment.amount_paid, center.center_name, schedule.sch_id,  schedule.scheduled_date, schedule.time, schedule.supervisor, assessor.full_name as 'assessor' ");
                           
		$this->db->from('candidate');
		$this->db->limit(20);
      
        $this->db->join('assessment','candidate.reg_no = assessment.can_regno', 'left');
        $this->db->join('center','center.center_code = assessment.center_code', 'left');
        $this->db->join('candidate_group', 'candidate_group.exam_id = assessment.exam_id', 'left');
        $this->db->join('schedule', 'schedule.group_no = candidate_group.gr_id', 'left');
        $this->db->join('assessor', 'assessor.ass_id = schedule.assr_id', 'left');
        $this->db->join('occupation','occupation.occ_code = assessment.occ_code', 'left');     
        //$this->db->where('assessment.payment_status','Paid');
        //$this->db->where('assessment.exam_id', $assessment_ids[$i]);
        //$this->db->where('assessment.center_code', $this->session->userdata('center_code') );     
        
    }

    function update_print_stat($assessment_ids) {

/*
        for($i = 0; $i < count($assessment_ids); $i++) {
            $this->db->where('exam_id', $assessment_ids[$ids]);
            $this->db->update('assessment', array('print_admission' => 'Yes','no_of_print', 'no_of_print + 1' ));
        }
        $query = $this->db->get(); 
		return $query->result_array();
*/

    }
    
 }


 ?>
