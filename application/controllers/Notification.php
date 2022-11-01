<?php 
class Notification extends CI_Controller{
    public function __construct(){

        parent::__construct();

        $this->load->model('Profile');
        if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('Welcome/index');

        }
        
    }



    public function send_notification_ho(){

        if(!empty($this->input->post())){

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho');
            $this->load->view('post_login/footer');
            
        }

    }
}

?>