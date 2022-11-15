<?php 
class Notification_model extends CI_Model{


    public function f_get_notification($table_name, $select=NULL, $where=NULL, $flag) {

        if(isset($select)) {

            $this->db->select($select);

        }

        if(isset($where)) {

            $this->db->where($where);

        }

        $result		=	$this->db->get($table_name);

        if($flag == 1) {

            return $result->row();
            
        }else {

            return $result->result();

        }

    }

    
    public function f_insert($table_name, $data_array) {

        $this->db->insert($table_name, $data_array);
        return $this->db->insert_id();

    }


    //For Editing row

    public function f_edit($table_name, $data_array, $where) {

        $this->db->where($where);
        $this->db->update($table_name, $data_array);

        return;

    }

    //For Deliting row

    public function f_delete($table_name, $where) {

        $this->db->delete($table_name, $where);

        return;

    }

    public function notificationcount(){
        $this->db->where('branch_id',$this->session->userdata['loggedin']['branch_id']);
        $this->db->where_in('view_status', ["","0",0,null]);
        return $this->db->get('td_notification_status')->num_rows();
    }

    public function notification_shortList(){
        $this->db->select('td_notification.msg_title,td_notification.sl_no');
        $this->db->from('td_notification_status')->join('td_notification', 'td_notification.sl_no = td_notification_status.notification_id');
        $this->db->where('branch_id',$this->session->userdata['loggedin']['branch_id']);
        $this->db->where_in('view_status', ["","0",0,null]);
        $this->db->limit(10);
        return $this->db->get()->result();
    }
    function get_my_notification(){
        $this->db->select('td_notification.*');
        $this->db->from('td_notification_status')->join('td_notification', 'td_notification.sl_no = td_notification_status.notification_id');
        $this->db->where('branch_id',$this->session->userdata['loggedin']['branch_id']);
        
        return $this->db->get()->result();
    }
}

?>