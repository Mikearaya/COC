<?php
 class Schedule extends API {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('schedule_model');
    }
    function index_get($id = NULL) {
        $result['result'] = $this->schedule_model->get_schedule($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
 }
}
?>