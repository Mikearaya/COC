<?php

 class OS extends API {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('os_model');
    }

function occupation_get($id = NULL){
    $result = $this->os_model->get_occupation($id);
    $this->response($result,API::HTTP_OK);
}
function unit_of_competency_get($id = NULL) {

    $result = $this->os_model->get_unit_of_competency($id);
    $this->response($result,API::HTTP_OK);

}

function assessment_price_get($id = NULL) {
    $result = $this->os_model->get_assessment_price($id);
    $this->response($result,API::HTTP_OK);
}


function sector_get($id = NULL) {
    $result = $this->os_model->get_sector($id);
    $this->response($result, API::HTTP_OK);
}

}
