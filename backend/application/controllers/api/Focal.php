<?php
class Focal extends API {

    public function __construct($config = 'rest') {    
        parent::__construct($config);
        $this->load->model('focal_model');
    }
  
// log in function for focal person
    function log_in_post(){
        $result;

        $contact_person=$this->input->post('contact_person',true);
        $password=$this->input->post('password',true);
        $focal=$this->focal_model->select_focal($contact_person,$password);
        
        if(!$focal){
            $result['success']= false;

        } else {
            $this->session->set_userdata('center_id',$focal['center_id']);
            $this->session->set_userdata('center_name',$focal['center_name']);
            $this->session->set_userdata('contact_person',$focal['contact_person']);
            $result['success']= true;
            $result['focal_name'] = $this->session->userdata('contact_person');
            $result['center_id'] = $this->session->userdata('center_id');
            $result['center_name'] = $this->session->userdata('center_name');
        }
        $this->response($result, API::HTTP_OK);
}


    function log_out_get() {
        $this->session->sess_destroy();
    }

    function is_session_active_get(){

        $result;

        if($this->session->has_userdata('center_id') &&
            $this->session->has_userdata('center_name') &&
            $this->session->has_userdata('contact_person')) {
            $result['is_active']= true;
            $result['focal_name'] = $this->session->userdata('contact_person');
            $result['center_id'] = $this->session->userdata('center_id');
            $result['center_name'] = $this->session->userdata('center_name');

        } else {
            $result['is_active'] = false;
        }

        $this->response($result, API::HTTP_OK);
    }

}



?>
