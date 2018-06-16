<?php
class Focal_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }/*
    
            */
     public function select_center($contact_person, $password){

        $this->db->where('contact_person',$contact_person);
        $this->db->where('password',$password);
        $query = $this->db->get('center');

        if($query->num_rows() > 0){
            return $query->row_array();
        }
        else{
            return false;
        }
     
    }
    
    public function checkOldPass_post($old_password)
    {
        $id = $this->input->post('id');
                $this->db->where('contact_person', $this->session->userdata('contact_person'));
                $this->db->where('id', $id);
        $this->db->where('password', $old_password);
        $query = $this->db->get('center');
        if($query->num_rows() > 0)
            return 1;
        else
            return 0;
    }

    public function saveNewPass_post($new_pass)
    {
        $data = array(
               'password' => $new_pass
            );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('center', $data);
        return true;
    }
    
    

}
?>
        
      