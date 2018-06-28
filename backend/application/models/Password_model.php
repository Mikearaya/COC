<?php
class Password_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //get current password
 function get_password($centerId){
    $query =$this->db->where(['center_code'=>$centerId])
                        ->get('center');
    if($query->num_rows() > 0){
        return $query->row();
    }

}
//update password
    function update_password($new_password,$centerId){
        $data = array(
            'password'=> $new_password
        );
		return  $this->db->where('center_code',$centerId)->update('center',$data);
    }

}
?>
