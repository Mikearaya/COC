<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
    $this->load->library('pagination');
  }
//get candidate result
  function index_get($id = NULL) {
    
    $result = $this->result_model->get_result($id );
    $this->response($result,API::HTTP_OK);
}

//get candidate result by group
  function group_result_get($id = NULL) {

    $result = $this->result_model->get_group_result($config['per_page'],$page);
    $this->response($result, API::HTTP_OK);
    

  }
}
?>