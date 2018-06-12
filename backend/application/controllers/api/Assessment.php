<?php
 class Assessment extends API {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('assessment_model');
    }
    function index_get($id = NULL) {
        $result['result'] = $this->assessment_model->get_assessment($id);
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

    $this->form_validation->set_rules("amount_paid", "Amount_paid", "required");
    
    if($this->form_validation->run() === FALSE ) {
        $this->response($this->validation_errors(), API::HTTP_OK);
    } else {
        $data = array(
            'exam_id' => $id,
            'occ_code' => $this->input->post('assessment[occ_code]'),
            'center_code' => $this->input->post('assessment[center_code]'),
            'application' => $this->input->post('assessment[application]'),
            'registered_by' => $this->input->post('assessment[registered_by]'),
            'applied_by' => $this->input->post('assessment[applied_by]'),
            'branch_code' => $this->input->post('assessment[branch_code]'),
            'amount_paid' => $this->input->post('assessment[amount_paid]'),
            'apply_for_uc' => $this->input->post('assessment[apply_for_uc]'),
            'excuse_payment' => $this->input->post('assessment[excuse_payment]'),
            'paid' => $this->input->post('assessment[paid]'),
        );
    }
        $result['success'] = ($this->assessment_model->save_assessment($data)) ? true : false;
        $this->response($result, API::HTTP_OK);
    }
 }
?>