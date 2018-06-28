<?php
class Password extends API {

    public function __construct($config = 'rest') {
       
        parent::__construct($config);
        
      $this->load->model('password_model');

}  
// password change function
function change_post(){
    $this->load->library('form_validation');
   

    $this->form_validation->set_rules('password','password','required');
    $this->form_validation->set_rules('newpassword','new password','required');
    $this->form_validation->set_rules('repassword','New Password Doesnt Match','required');
    if($this->form_validation->run()) {
  
     $cur_password= $this->input->post('password');
     $new_password= $this->input->post('newpassword');
     $re_password= $this->input->post('repassword');
     
    
     $password= $this->password_model->get_password($this->session->userdata('center_code'));
     if($password->password == $cur_password){
        if($new_password == $re_password){
            if($this->password_model->update_password($new_password, $this->session->userdata('center_code'))){
                $result['success'] = true;
            }
            else{
                $result['success'] = false;
                $result['message'] = 'failed to update password';
            }
        }
        else{
            $result['success'] = false;
           $result['message'] = 'sorry new password & repassword is not matching';
        }
     }else{
        $result['success'] = false;
        $result['message'] = 'sorry current password is not matching';
     }
   
    }
    else{
        $result['message'] = $validation_errors();
        $result['success'] = false;
    }

    $this->response($result, API::HTTP_OK);
}
}



?>
