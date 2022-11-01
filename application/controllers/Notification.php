<?php 
class Notification extends CI_Controller{
    public function __construct(){

        parent::__construct();

        $this->load->model('Profile');
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('Welcome/index');

        }

        $this->load->model('Notification_model');
        
    }



    public function send_notification_ho(){

        if(!empty($this->input->post())){
            $this->input->post('title');
            $this->input->post('date');
            $this->input->post('message');


            // $this->Notification_model->f_insert($table_name, $data_array);
        }else{
            $select=array('branch_name','id');
            $data['distdata']=$this->Notification_model->f_get_notification("md_branch", $select, $where=NULL, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho',$data);
            $this->load->view('post_login/footer');
            
        }

    }
}

?>