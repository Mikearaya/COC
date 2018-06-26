<?php


class Admission extends API {


 
  public function __construct($config = 'rest') {
    parent::__construct($config);
    $this->load->model('admission_model');
  }


	function filter_get() {
		$filter_string = $this->input->get('filter');
		$result = $this->admission_model->get_admission($filter_string);
	 $this->response($result,API::HTTP_OK);
	}
}
?>