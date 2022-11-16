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


        if($this->session->userdata['loggedin']['user_type']=='A'||$this->session->userdata['loggedin']['user_type']=='M'||$this->session->userdata['loggedin']['user_type']=='D'){

        

        if(!empty($this->input->post())){
            $inputData=array(
                "send_dt"=>$this->input->post("date"),
                "send_user"=>$this->session->userdata['loggedin']['user_name'],
                "msg_title"=>$this->input->post("title"),
                "msg_text"=>$this->input->post("message"),
                "receive_branch"=>implode(",",$this->input->post('branch_id')),
                "create_at"=>date('Y-m-d H:i:s')
            );

            $notification_id=$this->Notification_model->f_insert("td_notification", $inputData);

            // send_notification_ho
            $branch_id=$this->input->post('branch_id');

            for($i=0;$i < count($branch_id);$i++){
                $status_id=array(
                    'notification_id'=>$notification_id,
                    'branch_id'=> $branch_id[$i],
                    'view_status'=>0,
                    'create_by'=>$this->session->userdata['loggedin']['user_name'],
                    'create_at'=>date('Y-m-d H:i:s')
                );
                $this->Notification_model->f_insert("td_notification_status", $status_id);
            }
            
            redirect(site_url('notification'));
        }else{
            $select=array('branch_name','id');
            $data['distdata']=$this->Notification_model->f_get_notification("md_branch", $select, $where=NULL, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho',$data);
            $this->load->view('post_login/footer');
            
        }
    }else{
        redirect(site_url('dashboard'));
    }

    }


    public function notification(){

        if($this->session->userdata['loggedin']['user_type']=='A'||$this->session->userdata['loggedin']['user_type']=='M'||$this->session->userdata['loggedin']['user_type']=='D'){
        if(!empty($this->input->post())){

        $start_date=$this->input->post('fr_dt');
        $end_date=$this->input->post('to_dt');
        }else{
            $start_date=date('Y-m-d');
            $end_date=date('Y-m-d');
        }
       
        $where=array('send_dt BETWEEN "'. $start_date. '" and "'. $end_date.'"' => null);

        $data['notification']=$this->Notification_model->f_get_notification("td_notification", null, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('notification/notification_list',$data);
        $this->load->view('post_login/footer');

    }else{
        redirect(site_url('dashboard'));
    }

    }


    public function delete($id){
        if($this->session->userdata['loggedin']['user_type']=='A'||$this->session->userdata['loggedin']['user_type']=='M'||$this->session->userdata['loggedin']['user_type']=='D'){
        
        $this->Notification_model->f_delete("td_notification",array('sl_no'=>$id));
        $this->Notification_model->f_delete("td_notification_status",array('notification_id'=>$id));
        redirect(site_url('notification'));
    }else{
        redirect(site_url('dashboard'));
    }


    }



    public function edit($id){

        if($this->session->userdata['loggedin']['user_type']=='A'||$this->session->userdata['loggedin']['user_type']=='M'||$this->session->userdata['loggedin']['user_type']=='D'){

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


            $branch_id=$this->input->post('branch_id');


            $this->Notification_model->f_delete("td_notification_status",array('notification_id'=>$id));

            for($i=0;$i < count($branch_id);$i++){
                $status_id=array(
                    'notification_id'=>$id,
                    'branch_id'=> $branch_id[$i],
                    'view_status'=>0,
                    'create_by'=>$this->session->userdata['loggedin']['user_name'],
                    'create_at'=>date('Y-m-d H:i:s')
                );
                $this->Notification_model->f_insert("td_notification_status", $status_id);
            }


            redirect(site_url('notification'));

            

        }else{

        $data['notification']=$this->Notification_model->f_get_notification("td_notification", null, array('sl_no'=>$id), 0);
            $select=array('branch_name','id');
            $data['distdata']=$this->Notification_model->f_get_notification("md_branch", $select, $where=NULL, 0);
            $this->load->view('post_login/finance_main');
            $this->load->view('notification/send_notification_ho_edit',$data);
            $this->load->view('post_login/footer');
            
        }
    }else{
        redirect(site_url('dashboard'));
    }


    }


    public function branch_notification_view($id){

        if($this->session->userdata['loggedin']['user_type']=='U'|| $this->session->userdata['loggedin']['user_type']=='A'){
        
        $where=array('a.sl_no'=>$id,
        'b.notification_id=a.sl_no'=>null,
        "b.branch_id"=>$this->session->userdata['loggedin']['branch_id'],
        
        );
        $inputData=array(
            'view_status'=>"1",
            'update_at'=>date('Y-m-d H:i:s'),

        );

        $this->Notification_model->f_edit("td_notification_status", $inputData, array('branch_id'=>$this->session->userdata['loggedin']['branch_id'],'notification_id'=>$id));

        $data['notification']=$this->Notification_model->f_get_notification("td_notification a, td_notification_status b", null, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('notification/branch/view_notification',$data);
        $this->load->view('post_login/footer');

    }else{
        redirect(site_url('dashboard'));
    }

    }




    public function notification_view($id){

        if($this->session->userdata['loggedin']['user_type']=='A'||$this->session->userdata['loggedin']['user_type']=='M'||$this->session->userdata['loggedin']['user_type']=='D'){
        $where=array('a.sl_no'=>$id,
        // 'b.notification_id=a.sl_no'=>null,
        // "b.branch_id"=>$this->session->userdata['loggedin']['branch_id'],
        
        );
        $inputData=array(
            'view_status'=>"1",
            'update_at'=>date('Y-m-d H:i:s'),

        );

        // $this->Notification_model->f_edit("td_notification_status", $inputData, array('branch_id'=>$this->session->userdata['loggedin']['branch_id'],'notification_id'=>$id));

        $data['notification']=$this->Notification_model->f_get_notification("td_notification a", null, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('notification/branch/view_notification',$data);
        $this->load->view('post_login/footer');

    }else{
        redirect(site_url('dashboard'));
    }

    }


    public function count_notification(){

        $data=$this->Notification_model->notificationcount();
        if($data>10){
            echo json_encode("10"."+");
        }else{
            echo json_encode($data);
        }

        
    }


    public function notification_list_10(){
        

        $data=$this->Notification_model->notification_shortList();
       
        $output='';

        foreach ($data as $key) {
        //    $key->msg_title;sl_no
        $click="'".site_url('notification/').$key->sl_no."'";
        $output.='<li onclick="window.location.href='.$click.'" class="list-group-item" style="color: black;">'.$key->msg_title.'</li>';
        }



       
        if(empty($output)){
            echo json_encode("Nodata Fount");
        }else{
            echo json_encode($output);
        }

        
    }


    public function my_notification(){

        if($this->session->userdata['loggedin']['user_type']=='U' || $this->session->userdata['loggedin']['user_type']=='A'){

        $data['notification']=$this->Notification_model->get_my_notification("td_notification", null, $where=NULL, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('notification/branch/my_notification',$data);
        $this->load->view('post_login/footer');

    }else{
        redirect(site_url('dashboard'));
    }

    }
}
