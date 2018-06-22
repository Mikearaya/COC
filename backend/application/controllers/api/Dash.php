<?php

 class Dash extends API {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('dash_model');
    }
   //get candidate how are not paid
   function payment_get($id = NULL) {

    $result = $this->dash_model->get_payment($id);
    $this->response($result,API::HTTP_OK);
}

//get candidate how are not paid
function admission_get($id = NULL) {

    $result = $this->dash_model->get_admission($id);
    $this->response($result,API::HTTP_OK);
}
//get candidate how are not paid
function schedule_get($id = NULL) {

    $result = $this->dash_model->get_schedule($id);
    $this->response($result,API::HTTP_OK);
}
//get candidate how are not paid
function result_get($id = NULL) {

    $result = $this->dash_model->get_result($id);
    $this->response($result,API::HTTP_OK);
}
 }
?>