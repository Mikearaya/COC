<?php

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