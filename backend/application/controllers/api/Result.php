<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
  }
//get candidate result
  function index_get($offset=0) {

    $limit=$this->input->get('limit');
    $offset= $this->input->get('limit-offset');
    $result = $this->result_model->get_result($limit,$offset);
  
    $this->response($result,API::HTTP_OK);
}

//get candidate result by group
  function group_result_get($group_id) {
 

  $limit=$this->input->get('limit');
  $offset= $this->input->get('limit-offset');
  $result = $this->result_model->get_group_result($group_id);

  $this->load->library('pagination');
    $this->response($result, API::HTTP_OK);
    
    ;
  
  }}
?>
