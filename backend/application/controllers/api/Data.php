<?php
<<<<<<< HEAD

    class Data extends API {


       function __construct($config = 'rest') {
            parent::__construct($config);
            $this->load->model("data_model");
        }


        function occupation($id = NULL) {
            $result["data"] = $this->data_model->get_occupation($id);
            $this->response($result, API::HTTP_OK);
        }

        function sector($id = NULL) {
            $result["data"] = $this->data_model->get_sector($id);
            $this->response($result, API::HTTP_OK);
        }

        function uc($id = NULL) {
            $result["data"] = $this->data_model->get_uc($id);
            $this->response($result, API::HTTP_OK);
        }

        function fee($id = NULL) {
            $result["data"] = $this->data_model->get_fee($id);
            $this->response($result, API::HTTP_OK);
        }

    }


?>
=======
 class Data extends API {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('data_model');
    }
    function index_get($id = NULL) {
        $result['result'] = $this->data_model->get_sector($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}

function occupation_get($id = NULL){
    $result['result'] = $this->data_model->get_occupation($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
}
function unit_of_competency_get($id = NULL) {

    $result['result'] = $this->data_model->get_unit_of_competency($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);

}

function assessment_price_get($id = NULL) {
    $result['result'] = $this->data_model->get_assessment_price($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);


}
}
>>>>>>> de33f06517428cd2ebd1c4d8f22cc3d685ab01a5
