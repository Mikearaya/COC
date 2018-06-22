<?php
 class Schedule extends API {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('schedule_model');
    }
    function index_get($id = NULL) {
        $result = $this->schedule_model->get_schedule($id);
        $this->response($result,API::HTTP_OK);
 }


        function group_schedule_get($id) {
            $result = $this->schedule_model->get_group_schedule($id);
            $this->response($result, API::HTTP_OK);
        }
}
?>