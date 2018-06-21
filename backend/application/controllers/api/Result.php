<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
  }

  function index_get($id = NULL) {

    $result['result'] = $this->result_model->get_result($id);
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}


  function group_result_get($id = NULL) {
    $result = $this->result_model->get_group_result($id);
    $this->response($result, API::HTTP_OK);
  }
}
?>