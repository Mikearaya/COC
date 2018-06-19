<?php
class Focal extends API {

    public function __construct($config = 'rest') {
       
        parent::__construct($config);
        
      $this->load->model('focal_model');

}  

//focal person login
function index_post() {

    $this->load->library('form_validation');
    $result['success'] = false;

    $this->form_validation->set_rules("contact_person", "Contact Person", "required");
    $this->form_validation->set_rules("password", "Password", "required");
    if($this->form_validation->run() === FALSE ) {
        $this->response($this->validation_errors(), API::HTTP_OK);
        if($this->focal_model->select_center($contact_person,$password)){

            $session_data = array(
                
                'contact_person' => $this->input->post('contact_person'),
                'password' => $this->input->post('password'), 
            );
            $this->session->set_userdata($session_data);
            return true;
        }
        else {
            $this->session->set_flashdata('error','Invalid login. User not found');
        }
    } else {

        $this->post();
       
        
      
}
   $result['success'] = ($this->focal_model->select_center($contact_person,$password)) ? true : false;
   $this->response($result, API::HTTP_OK);
}
// change password
public function changePassword()
{
    $pass=$this->input->post('old_password');
    $npass=$this->input->post('newpassword');
    $rpass=$this->input->post('re_password');
    if($npass!=$rpass){
        return "false";
    }else{
        $this->db->select('*');
        $this->db->from('center');
        $this->db->where('contact_person',$this->session->userdata('contact_person'));
        $this->db->where('password',md5($pass));
        $query = $this->db->get();
        if($query->num_rows()==1){
            $data = array(
                           'password' => md5($npass)
                        );
            $this->db->where('contact_person', $this->session->userdata('contact_person'));
            $this->db->update('center', $data); 
            return "true";
        }else{
            return "false";
        }
    }
}

}

?>
