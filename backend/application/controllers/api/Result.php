<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
  }
//get candidate result
  function index_get($offset=0) {
    //$result['success']= true;

    $limit=$this->input->get('limit');
    $offset= $this->input->get('limit-offset');
    $result['success'] = ($this->result_model->get_result($limit,$offset)) ? true : false;

    $this->load->library('pagination');

   $config = array();
   $config['base_url'] = '';
   $config['total_rows'] = $result;
   $config['per_page'] = $limit;
   $config['uri_segment']=3;
   $result['pagination'] = $this->pagination->create_links();
  
    $this->response($result,API::HTTP_OK);
}

//get candidate result by group
  function group_result_get($offset=0) {
 

  $limit=$this->input->get('limit');
  $offset= $this->input->get('limit-offset');
  $result ['success'] = ($this->result_model->get_group_result($limit,$offset)) ? true : false;

  $this->load->library('pagination');

  $config = array();
  $config['base_url'] = '';
  $config['total_rows'] = $result;
  $config['per_page'] = $limit;
  $config['uri_segment']=3;
  $result['pagination'] = $this->pagination->create_links();
 
    $this->response($result, API::HTTP_OK);
    
    ;
  
  }}
?>