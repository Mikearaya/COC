<?php 
 class Payment_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_payment(){
        $this->db->select('candidate.full_name, candidate.reg_no, assessment.paid,assessment.amount_paid ,assessment.registration_date,assessment.exam_id, invoice.id,invoice.invoice_no,invoice.date,invoice.amount,occupation.occ_name,occupation.level');
        $this->db->from('assessment');
        $this->db->where('paid',1);
        $this->db->join('invoice','invoice.id=assessment.exam_id','left');
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
    
    // save and update invoice number 
    public function save_invoice($invoice) {
       if(!is_null($invoice['id'])){
           return $this->update_invoice($invoice);
       }else {
           $this->db->insert('invoice',$invoice);
       }
       return ($this->db->affected_rows()) ? true : false; 
     
    }
    public function update_invoice($invoice) {    
          $this->db->where('id', $invoice['id']);
        return $this->db->update('invoice' , $invoice);
    }
    
 }
 ?>