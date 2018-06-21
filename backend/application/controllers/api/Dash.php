<?php

 class Dash extends API {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('dash_model');
    }
   //get candidate how are not paid
   function index_get($id = NULL) {

    $result['result'] = $this->dash_model->get_payment($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}

//get candidate how are not paid
function admission_get($id = NULL) {

    $result['result'] = $this->dash_model->get_admission($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}
//get candidate how are not paid
function schedule_get($id = NULL) {

    $result['result'] = $this->dash_model->get_schedule($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}
//get candidate how are not paid
function result_get($id = NULL) {

    $result['result'] = $this->dash_model->get_result($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}
 }
?>