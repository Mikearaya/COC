<?php 
 class Payment_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // list candidate who are paid for assessment
    public function get_payment(){
        $this->db->select('exam_id,can_regno,amount_paid,payment_status,registration_date,paid');
        $this->db->from('assessment');
        $this->db->where('paid',1);
        $this->db->join('invoice','invoice.id=assessment.exam_id','left');
       
        //$this->db->join('assessment on assessment.can_regno=candidate.reg_no');
        //$this->db->join('join occupation on occupation.occ_code=assessment.occ_code');
       // $this->db->join('candidate','candidate.id = assessment.exam_id');
       // $this->db->join('occupation','occupation.id = invoice.id');
        $this->db->order_by('assessment.exam_id','asc');         
        $query = $this->db->get(); 
            if($query->num_rows() != 0){
                return $query->result_array();
            } else {    
                return false;
}
        //$this->db->orderd_by('registration_date','desc');
        
        //$query=$this->db->get();
        //return $query->result_array();
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