<?php
class Focal_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    


        public function save_center($center) {
            if(!is_null($center['id'])) {
                return $this->update_center($center);
            } else {
                $this->db->insert('center' , $center);
            }
            return ($this->db->affected_rows()) ? true : false; 
        }
        
        public function update_center($center) {
            
              $this->db->where('id', $center['id']);
            return $this->db->update('center' , $center);
        }
    
    }
?>
        
      