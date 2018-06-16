<?php
class Focal extends API {

    public function __construct($config = 'rest') {
       
        parent::__construct($config);
        
      $this->load->model('focal_model');

}  


function index_post($id = NULL) {

    $this->load->library('form_validation');
    $result['success'] = false;

    $this->form_validation->set_rules("contact_person", "Contact Person", "required");
    $this->form_validation->set_rules("password", "Password", "required");
    if($this->form_validation->run() === FALSE ) {
        $this->response($this->validation_errors(), API::HTTP_OK);
    } else {

        $data = array(
            'id' => $id,
            'contact_person' => $this->input->post('contact_person'),
            'password' => $this->input->post('password'),
          
        );
        
      
}
   $result['success'] = ($this->focal_model->save_center($data)) ? true : false;
   $this->response($result, API::HTTP_OK);
}





}

?>
