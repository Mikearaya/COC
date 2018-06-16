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

function index_post($id = NULL) {

    $this->load->library('form_validation');
    $result['success'] = false;

    $this->form_validation->set_rules("full_name", "Full Name", "required");
    if($this->form_validation->run() === FALSE ) {
        $this->response($this->validation_errors(), API::HTTP_OK);
    } else {

        $data = array(
            'id' => $id,
            'full_name' => $this->input->post('full_name'),
            'reg_no' => $this->input->post('reg_no'),
            'gender' => $this->input->post('gender'),
            'date_of_birth' => $this->input->post('date_of_birth'),
            'nationality' => $this->input->post('nationality'),
            'zone' => $this->input->post('zone'),
            'wereda' => $this->input->post('wereda'),
            'home_phone' => $this->input->post('home_phone'),
            'office_phone' => $this->input->post('office_phone'),
            'cell_phone' => $this->input->post('cell_phone'),
            'marital_status' => $this->input->post('marital_status'),
            'disablity' => $this->input->post('disablity'),
            'disablity_nature' => $this->input->post('disablity_nature'),
            'institute_type' => $this->input->post('institute_type'),
            'institute_name' => $this->input->post('institute_name'),
            'region' => $this->input->post('region'),
            'city' => $this->input->post('city'),
            'training_start' => $this->input->post('training_start'),
            'training_end' => $this->input->post('training_end'),
            'mode_of_training' => $this->input->post('mode_of_training'),
            'type_of_training' => $this->input->post('type_of_training'),
            'occupation_trained_on' => $this->input->post('occupation_trained_on'),
            'education_background' => $this->input->post('education_background'),
            'cooprative_training_center' => $this->input->post('cooprative_training_center'),
            'status_of_cooprative_center' => $this->input->post('status_of_cooprative_center'),
            'employment_condition' => $this->input->post('employment_condition'),
            'status_of_company' => $this->input->post('status_of_company'),
            'company_type' => $this->input->post('company_type'),
            'company_name' => $this->input->post('company_name'),
            'service_year' => $this->input->post('service_year'),
            'field_of_employment' => $this->input->post('field_of_employment'),
            'password' => $this->input->post('cell_phone'),
            'email' => $this->input->post('email'),
            'current_level' => $this->input->post('current_level'),
            'graduated_level' => $this->input->post('graduated_level'),
            

             );
             
           
    }
        $result['success'] = ($this->candidate_model->save_candidate($data)) ? true : false;
        $this->response($result, API::HTTP_OK);
    }
}
?>