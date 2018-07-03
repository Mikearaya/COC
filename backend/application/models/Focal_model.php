<?php
class Focal_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //login function for focal
    function select_focal($center_code,$password){
        $where=array(
            'center_code'=>$center_code,
            'password'=>sha1($password)
        );
        $this->db->select('*')->from('center')->where($where);
        $query=$this->db->get();
        return $query->first_row('array');
    }
 

}
?>
        
      