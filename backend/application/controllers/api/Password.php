<?php
class Password extends API {

    public function __construct($config = 'rest') {
       
        parent::__construct($config);
        
      $this->load->model('password_model');

}  
// password change function
function index_post($centerId = NULL){
    $this->load->library('form_validation');
   

    $this->form_validation->set_rules('password','password','required');
    $this->form_validation->set_rules('newpassword','newpassword','required');
    $this->form_validation->set_rules('repassword','repassword','required');
    if($this->form_validation->run()) {
    
     $cur_password= $this->input->post('password');
     $new_password= $this->input->post('newpassword');
     $re_password= $this->input->post('repassword');
     
    
     $password=$this->password_model->get_password($centerId);
     
     if($password->password == $cur_password){
        if($new_password == $re_password){
            if($this->password_model->update_password($new_password,$centerId)){
                echo 'password updated';
            }
            else{
                echo 'failed to update password';
            }
        }
        else{
            echo 'sorry new password & repassword is not matching';
        }
     }else{
         echo 'sorry current password is not matching';
     }
   
    }
    else{
        echo 'error';
    }
}
}



?>
