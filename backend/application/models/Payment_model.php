<?php 
 class Payment_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_payment(){
        
        $user = $this->session->get_userdata();
        $this->db->select('candidate.full_name, candidate.reg_no, assessment.paid,assessment.amount_paid ,assessment.registration_date,assessment.exam_id,
                         occupation.occ_name,occupation.level');
        $this->db->from('assessment');

		$this->db->where('assessment.paid', 1);
		$this->db->where('assessment.invoice_no', null);
        $this->db->where('assessment.center_code',  $this->session->userdata('center_code'));
        $this->db->join('candidate','candidate.reg_no = assessment.can_regno');
        $this->db->join('occupation','occupation.occ_code = assessment.occ_code');
        $this->db->order_by('assessment.registration_date','desc');         
        $query = $this->db->get(); 
            if($query->num_rows() != 0){
                return $query->result_array();
            } else {    
                return false;
            }
        
    }
    
    // save and update invoice number for payment
    public function save_invoice($invoice, $candidateIds) {
       if(isset($invoice['id'])){
           return $this->update_invoice($invoice);
       }else {
           var_dump($candidateIds);
           $this->db->insert('invoice',$invoice);
           $updatedCandidates = [];
           for($i = 0; $i < sizeof($candidateIds); $i++) {
               echo $candidateIds[$i];
                $updatedCandidate[] = array(
                    'exam_id' => $candidateIds[$i],
                    'invoice_no' => $invoice['invoice_no']
                );
           }

           $this->db->update_batch('assessment', $updatedCandidate, 'exam_id');
       }
       return ($this->db->affected_rows()) ? true : false;      
    }
    public function update_invoice($invoice) {    
          $this->db->where('id', $invoice['id']);
        return $this->db->update('invoice' , $invoice);
    }
    
 }
 ?>
