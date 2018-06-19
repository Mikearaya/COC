<?php 
 class Schedule_model extends MY_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_schedule($scheduleID = NULL) {
        $result = NULL;
            if(!is_null($scheduleID)) {
                $query = $this->db->get_where('schedule' , array('id' => $scheduleID));
                $result = $query->row_array();
            } else {
                $query = $this->db->get('schedule');
                $result = print_r($query->result_array());
            }
          return $result;

        /*$query = $this->db->query("select test.e_pos, test.e_name, inn.cnt 
        from test
        inner join 
            (SELECT e_pos, e_name, count(e_pos) as 'cnt' 
            FROM `test`
            group by e_pos ) inn on test.e_pos = inn.e_pos 
        order by test.e_pos");

        foreach ($query->result() as $row)
{*/
  // echo data as desired 
//$this->db->select('*');
//$this->db->from('schedule');
//$this->db->group_by('group_no'); 
//$this->db->order_by('group_no', 'desc'); 
//$this->db->get('schedule', 10);
//$query = $this->db->get('schedule');
              //->select('*')
              //->from('schedule')
              //->group_by('group_no')
              //->order_by('group_no', 'desc')
              //->get('schedule');
//print_r($query->result());
        } 
 }
?>