<?php


class Result extends API {


  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('result_model');
    $this->load->library('pagination');
  }
//get candidate result
  function index_get($id = NULL) {
    
    $result['result'] = $this->result_model->get_result($id );
    $result['columns']=[];
    
    if(count($result)>0) {
        $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
        $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}

//get candidate result by group
  function group_result_get($id = NULL) {
    $config = array();
    $config['base_url'] = 'http://localhost/smart_coc/backend/index.php/api/result';
    $config['total_rows'] = $this->result_model->get_group_result($id);
    $config['per_page'] = 10;
    $config['uri_segment']=3;
    $choice = $config['total_rows']/$config['per_page'];
    $config['num_links']= round($choice);

$this->pagination->initialize($config);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    
    $result['result'] = $this->result_model->get_group_result($config['per_page'],$page);
    $result ['links'] = $this->pagination->create_links ();
  
    $this->response($result, API::HTTP_OK);
    

  }
}
?>