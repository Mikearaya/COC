<?php

 class Dash extends API {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('dash_model');
    }
   //get candidate how are not paid for assessment 
   function payment_get($id = NULL) {

    $result = $this->dash_model->get_payment($id);
    $this->response($result,API::HTTP_OK);
}

//get candidate how don't have admission card
function admission_get($id = NULL) {

    $result = $this->dash_model->get_admission($id);
    $this->response($result,API::HTTP_OK);
}
//get new sechedule for assessment 
function schedule_get($id = NULL) {

    $result = $this->dash_model->get_schedule($id);
    $this->response($result,API::HTTP_OK);
}
//get candidate new result
function result_get($id = NULL) {

    $result = $this->dash_model->get_result($id);
    $this->response($result,API::HTTP_OK);
}
 }
?>