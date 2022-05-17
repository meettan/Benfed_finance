<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Report_Model');
		$this->load->model('master_model');
		$this->db2 = $this->load->database('seconddb', TRUE);
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            redirect('login');
        }
        
    }
 
    public function advjrnl(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$voucher_type =   $_POST['voucher_type'];
			$branch_id    =   $_POST['branch_id'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            $data['voucher']     = $this->Report_Model->f_get_voucher($frm_date,$to_date,$fin_yr,$voucher_type,$branch_id);
            $data['advance']     = $this->Report_Model->f_get_advjnl($frm_date,$to_date,$fin_yr,$voucher_type,$branch_id);
						   
			if($voucher_type == 'PUR'){
			    $data['voucher_type'] = 'Purchase';
			}elseif($voucher_type == 'A'){
				$data['voucher_type'] = 'Advance';
			}elseif($voucher_type == 'CRN'){
				$data['voucher_type'] = 'Credit note';
			}elseif($voucher_type == 'SL'){
				$data['voucher_type'] = 'Sale';
			}elseif($voucher_type == 'P'){
				$data['voucher_type'] = 'Payment';
			}elseif($voucher_type == 'R'){
				$data['voucher_type'] = 'Receive';
			}elseif($voucher_type == 'OTH'){
				$data['voucher_type'] = 'Other';
			}
			$where = array('id' => $branch_id );
			$select = array('branch_name');
            $data['branch'] = $this->master_model->f_select("md_branch", $select, $where, 1);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function trailbal(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            $data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function trailbal_group(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];

            //$data['trail_balnce']     = $this->Report_Model->f_get_trailbal_group($frm_date,$to_date);
			$data['trail_balnceg']     = $this->Report_Model->f_get_group_total($frm_date,$to_date);
			$data['trail_balnce']     = $this->Report_Model->f_get_trailbal($frm_date,$to_date);
			
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_group.php',$data);
            $this->load->view('post_login/footer');

        }else{
			
			$data['branch'] = $this->master_model->f_select("md_branch", NULL, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/trail_bal/trail_bal_ip_group.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function advjrnlv(){

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            // $frm_date = $this->input->post('from_date');
            // $to_date  = $this->input->post('to_date');

            $frm_date    =   $_POST['from_date'];

            $to_date      =   $_POST['to_date'];
            
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
             $fin_yr= $this->session->userdata['loggedin']['fin_id'];
			$data['voucher']     = $this->Report_Model->f_get_voucher($frm_date,$to_date,$fin_yr);
            $data['advance']     = $this->Report_Model->f_get_advjnl($frm_date,$to_date,$fin_yr);

            //$this->load->view('post_login/finance_main');
            $this->load->view('report/adv_jrnl/adv_jrnl_vou',$data);
        
           //$this->load->view('post_login/footer');

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
	
	public function gl(){                           // **** Code for Gl report   20/12/2021

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $frm_date     =   $_POST['from_date'];
            $to_date      =   $_POST['to_date'];
			$acc_head     =   $this->input->post('acc_head');
            $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
            $data['trail_balnce']     = $this->Report_Model->f_get_gl($frm_date,$to_date,$acc_head);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/gl/gl.php',$data);
            $this->load->view('post_login/footer');

        }else{
		
		    $select = array('sl_no','ac_name');
			$data['acc_head'] = $this->master_model->f_select("md_achead", $select, $where = null, 2);
            $this->load->view('post_login/finance_main');
            $this->load->view('report/gl/gl_ip.php',$data);
            $this->load->view('post_login/footer');
        }

    }
	public function ro_detail(){                           // **** Code for Gl report   20/12/2021 
			
			$branch_id  = $this->session->userdata['loggedin']['branch_id'];
		    $ro_no      = base64_decode($this->input->get('ro_no'));
		
			$select = array(
				"a.*","b.*","c.*","d.*"
			);
			$where	=	array(
				"a.comp_id = b.COMP_ID" => Null,
				"a.prod_id = c.PROD_ID" => Null,
				"ro_no" => $ro_no,
				"a.unit = d.id"=>NULL			
			);
		   
			$product['stock'] = $this->Report_Model->f_selects("td_purchase a,mm_company_dtls b,mm_product c,mm_unit d",Null,$where,1);
			$stk_pt = array("soc_id","soc_name");
				
			$where_stk = array(
					"stock_point_flag"	=>'Y',

					"district"   		=> $branch_id
			);

			$product['stockpoint'] = $this->Report_Model->f_selects("mm_ferti_soc",$stk_pt,$where_stk,0);

			$product['company'] = $this->Report_Model->f_selects("mm_company_dtls",NULL,NULL,0);
			$product['product'] = $this->Report_Model->f_selects("mm_product",NULL,NULL,0);	
			$product['unit'] = $this->Report_Model->f_selects("mm_unit",Null,Null,0);
			$select_sale = array(
				"count(sale_ro)as sale_cnt"
			);	
			$where_sale = array(
				"sale_ro"	=> $ro_no,
				"br_cd"   	=> $branch_id
		    );
			$product['sale']= $this->Report_Model->f_selects("td_sale",$select_sale,$where_sale,0);
												
			$this->load->view('post_login/finance_main');
			$this->load->view("stock_entry/edit",$product);
			$this->load->view("post_login/footer");

    }


}
