<?php

class Candidate extends API {
    
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('candidate_model');
    }
    function index_get($id = NULL) {
        $result['result'] = $this->candidate_model->get_candidate($id);
        $result['columns'] = [];

        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
    }
    $this->response($result,API::HTTP_OK);
    }


    public function register_assessment($assessment, $candidateId) {
        $this->load->library('form_validation');
        $result['success'] = false;

    

        $data;
        if($this->form_validation->run() === FALSE ) {
            $this->response($this->validation_errors(), API::HTTP_OK);
        } else {                

        
            $result['success'] = ($this->candidate_model->save_assessment($assessment, $candidateId)) ? true : false;
			$this->response($result, API::HTTP_OK);
		}

    }

    function index_post($id = NULL) {

        $this->load->library('form_validation');
        $result['success'] = false;

        $this->form_validation->set_rules("basic_info[full_name]", "Full Name", "required");

    
        if($this->form_validation->run() === FALSE ) {
            $this->response($this->validation_errors(), API::HTTP_OK);
        } else {
                $candidate_info = $this->input->post('basic_info');
                $assessment = $this->input->post('assessment'); 
        
            try {
				$candidate_id = $candidate_info['reg_no'];
					if(!trim($candidate_id)) { 
                    	$candidate_id = $this->candidate_model->save_candidate($candidate_info);						
					} 
						$this->register_assessment($assessment, $candidate_id);
					
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            $this->response($result, API::HTTP_OK);
        }
	}
	
	public function has_account_get($phoneNumber) {
		$result = $this->candidate_model->candidate_has_account($phoneNumber);
		$this->response($result, API::HTTP_OK);
	}

}

?>
