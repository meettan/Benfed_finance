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
           


$inputData=array(
    "send_dt"=>$this->input->post("date"),
     "send_user"=>$this->session->userdata['loggedin']['user_name'],
     "msg_title"=>$this->input->post("title"),
     "msg_text"=>$this->input->post("message"),
     "receive_branch"=>implode(",",$this->input->post('branch_id')),
     "create_at"=>date('Y-m-d H:i:s'),

);
            $this->Notification_model->f_insert("td_notification", $inputData);
            redirect(site_url('notification'));
        }else{
            $select=array('branch_name','id');
            $data['distdata']=$this->Notification_model->f_get_notification("md_branch", $select, $where=NULL, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho',$data);
            $this->load->view('post_login/footer');
            
        }

    }


    public function notification(){
       
        // $where=array('br_id in('.$this->session->userdata('loggedin')['branch_id'].',0)' => Null);
        $data['notification']=$this->Notification_model->f_get_notification("td_notification", null, $where=NULL, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('notification/notification_list',$data);
        $this->load->view('post_login/footer');
    }


    public function delete($id){
        $this->Notification_model->f_delete("td_notification",array('sl_no'=>$id));
        redirect(site_url('notification'));

    }



    public function edit($id){

        if(!empty($this->input->post())){
           


            $inputData=array(
                "send_dt"=>$this->input->post("date"),
                "send_user"=>$this->session->userdata['loggedin']['user_name'],
                "msg_title"=>$this->input->post("title"),
                "msg_text"=>$this->input->post("message"),
                "receive_branch"=>implode(",",$this->input->post('branch_id')),
                "create_at"=>date('Y-m-d H:i:s'),

            );
            $this->Notification_model->f_edit("td_notification", $inputData, array('sl_no'=>$id));
            redirect(site_url('notification'));

        }else{

        $data['notification']=$this->Notification_model->f_get_notification("td_notification", null, array('sl_no'=>$id), 0);
            $select=array('branch_name','id');
            $data['distdata']=$this->Notification_model->f_get_notification("md_branch", $select, $where=NULL, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho_edit',$data);
            $this->load->view('post_login/footer');
            
        }

    }
}

?>