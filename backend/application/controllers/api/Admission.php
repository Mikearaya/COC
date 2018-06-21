<?php


class Admission extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('admission_model');
  }

  function index_get($id = NULL) {

    $result = $this->admission_model->get_admission($id);
   
    $this->response($result,API::HTTP_OK);
}
}
?>
