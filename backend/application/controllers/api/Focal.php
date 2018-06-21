<?php
class Focal extends API {

    public function __construct($config = 'rest') {
       
        parent::__construct($config);
        
      $this->load->model('focal_model');

}  
// 
function index_post(){
    $data['error']=0;
    if($_POST){
        $contact_person=$this->input->post('contact_person',true);
        $password=$this->input->post('password',true);
        $focal=$this->focal_model->select_focal($contact_person,$password);
        if(!$focal){
            $data['error']=1;
        }
        else{
            $this->session->set_userdata('center_id',$focal['center_id']);
            $this->session->set_userdata('center_name',$focal['center_name']);
            $this->response('sucssus');
        }
    }

    //echo 'not found';
}

}



?>
