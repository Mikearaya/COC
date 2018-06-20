<?php

class Payment extends API {
    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('payment_model');
    }
    //get function for payment
    function index_get($id = NULL) {

        $result['result'] = $this->payment_model->get_payment($id);
        $result['columns']=[];
        
        if(count($result)>0) {
            $first_record= isset($result['result'][0]) ? $result['result'][0] : $result['result'];                      
            $result['columns']=array_keys((array)$first_record);
        }
        $this->response($result,API::HTTP_OK);
    }
    // post function for save invoice 
    function index_post($id = NULL) {
        $this->load->library('form_validation');
        $result['success'] = false;
    
        $this->form_validation->set_rules("invoice_no", "Invoice Number", "required");
               
            if($this->form_validation->run() === FALSE ) {
                $this->response($this->validation_errors(), API::HTTP_OK);
            } else {
                $data = array(
                    'id' => $id, 
                    'invoice_no' => $this->input->post('invoice_no'),
                    'date' => $this->input->post('date'),                                   
            );    
                $result['success'] = ($this->payment_model->save_invoice($data)) ? true : false;
                $this->response($result, API::HTTP_OK);
            }
    }

    function add_invoice_post(){
        $this->load->library('form_validation');
        $result['success'] = false;
        $this->form_validation->set_rules("invoice_no", "Invoice Number", "required");
               
            if($this->form_validation->run() === FALSE ) {
                $this->response($this->validation_errors(), API::HTTP_OK);
            } else {
                $data = array( 
                    'invoice_no' => $this->input->post('invoice_no'),
                    'date' => $this->input->post('date'),   
                    'amount' => $this->input->post('totalAmount'),  
                    'center_code' => '00'                                 
            );    
                $result['success'] = ($this->payment_model->save_invoice($data, $this->input->post('examIds'))) ? true : false;
                $this->response($result, API::HTTP_OK);
            }
    }

}
?>