<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Report_Model');
        // $this->load->helper('paddyrate');

        // $this->session->userdata('fin_yr');

        
    }
 
    public function advjrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // $frm_date = $this->input->post('from_date');
            // $to_date  = $this->input->post('to_date');

            $frm_date    =   $_POST['from_date'];

            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
             $fin_yr= $this->session->userdata['loggedin']['fin_id'];

           $data['advance']     = $this->Report_Model->f_get_advjnl($frm_date,$to_date,$fin_yr);

            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl.php',$data);
        
           $this->load->view('post_login/footer');

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl_ip.php');
            $this->load->view('post_login/footer');
        }

    }

    public function crnjrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // $frm_date = $this->input->post('from_date');
            // $to_date  = $this->input->post('to_date');

            $frm_date    =   $_POST['from_date'];

            $to_date      =   $_POST['to_date'];
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
             $fin_yr= $this->session->userdata['loggedin']['fin_id'];

           $data['advance']     = $this->Report_Model->f_get_crjnl($frm_date,$to_date,$fin_yr);

            $this->load->view('post_login/finance_main');
            $this->load->view('report/crn_jrnl/crn_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('report/crn_jrnl/crn_jrnl_ip.php');
            $this->load->view('post_login/footer');
        }

    }
    public function salejrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // $frm_date = $this->input->post('from_date');
            // $to_date  = $this->input->post('to_date');
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $frm_date    =   $_POST['from_date'];

            $to_date      =   $_POST['to_date'];

             $fin_yr= $this->session->userdata['loggedin']['fin_id'];

           $data['advance']     = $this->Report_Model->f_get_sljnl($frm_date,$to_date,$fin_yr);

            $this->load->view('post_login/finance_main');
            $this->load->view('report/sale_jrnl/sale_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{

            $this->load->view('post_login/finance_main');
            $this->load->view('report/sale_jrnl/sale_jrnl_ip.php');
            $this->load->view('post_login/footer');
        }
    }
        public function purjrnl(){

            if($_SERVER['REQUEST_METHOD'] == "POST") {
    
                // $frm_date = $this->input->post('from_date');
                // $to_date  = $this->input->post('to_date');
    
                $frm_date    =   $_POST['from_date'];
    
                $to_date      =   $_POST['to_date'];
                $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
                 $fin_yr= $this->session->userdata['loggedin']['fin_id'];
    
               $data['advance']     = $this->Report_Model->f_get_purjnl($frm_date,$to_date,$fin_yr);
    
                $this->load->view('post_login/finance_main');
                $this->load->view('report/pur_jrnl/pur_jrnl.php',$data);
                $this->load->view('post_login/footer');
    
            }else{
    
                $this->load->view('post_login/finance_main');
                $this->load->view('report/pur_jrnl/pur_jrnl_ip.php');
                $this->load->view('post_login/footer');
            }

    }


}
