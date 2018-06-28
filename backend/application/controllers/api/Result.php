<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
  }
//get candidate result
  function index_get($id = NULL) {


    $result = $this->result_model->get_result($id);
   


    $this->response($result,API::HTTP_OK);
}

//get candidate result by group
  function group_result_get($id = NULL) {
/* $this->load->library('pagination');
    
    $config = array();
    $config['base_url'] = 'http://localhost/smart_coc/backend/index.php/api/result';
    $config['total_rows'] = $this->result_model->get_group_result($id);
    $config['per_page'] = 10;
    $config['uri_segment']=3;
    $choice = $config['total_rows'] / $config['per_page'];
    $config['num_links']= round($choice);

    $this->pagination->initialize($choice=array());
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    
    $result['result'] = $this->result_model->get_group_result($id,$config['per_page'],$page);
    //$result ['links'] = $this->pagination->create_links ();
  
    $this->response($result, API::HTTP_OK);
     */
    $result = $this->result_model->get_group_result($id);

    $this->response($result, API::HTTP_OK);
  }
}
?>