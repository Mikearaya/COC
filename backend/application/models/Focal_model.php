<?php
class Focal_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function select_focal($contact_person,$password){
        $where=array(
            'contact_person'=>$contact_person,
            'password'=>$password
        );
        $this->db->select('*')->from('center')->where($where);
        $query=$this->db->get();
        return $query->first_row('array');
    }
 
   
    

}
?>
        
      