<?php


class Admission extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('admission_model');
  }

  function index_get($id = NULL) {

    $result['result'] = $this->admission_model->get_admission($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}
}
?>