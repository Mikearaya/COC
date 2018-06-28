<?php 
class Init extends API {

	function __construct($config = 'rest') {
		parent::__construct($config);
		$this->load->model('init_model');
	}

	function registration_get() {
		$result = $this->init_model->initialize_registration();
		$this->response($result, API::HTTP_OK);
	}
}

?>
