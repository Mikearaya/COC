<?php
 class Schedule extends API {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('schedule_model');
    }
    //get schedule 
    function index_get($id = NULL,$offset=0) {

    $limit=$this->input->get('limit');
    $offset= $this->input->get('limit-offset');
    $result = $this->schedule_model->get_schedule($limit,$offset);

    $this->load->library('pagination');

   $config = array();
   $config['base_url'] = '';
   $config['total_rows'] = $result;
   $config['per_page'] = $limit;
   $config['uri_segment']=3;
   $result['pagination'] = $this->pagination->create_links();
  
    $this->response($result,API::HTTP_OK);

       // $result = $this->schedule_model->get_schedule($id);
       // $this->response($result,API::HTTP_OK);
 }

    //get schedule by group
    function group_schedule_get($id,$offset=0) {

        $limit=$this->input->get('limit');
        $offset= $this->input->get('limit-offset');
        $result = $this->schedule_model->get_group_schedule($limit,$offset);

        $this->load->library('pagination');

        $config = array();
        $config['base_url'] = '';
        $config['total_rows'] = $result;
        $config['per_page'] = $limit;
        $config['uri_segment']=3;
        $result['pagination'] = $this->pagination->create_links();


        
        //$result = $this->schedule_model->get_group_schedule($id);
        $this->response($result, API::HTTP_OK);
        }
}
?>