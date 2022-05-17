<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
		$this->load->model('Report_Model');
        $this->load->model('master_model');
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('login');

        }
    }

    function index()
    {
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
       
        $cashcd = $cashcd->sl_no;
        $select = array(
            "voucher_date",
            "voucher_id",
            "voucher_type",
            "voucher_mode",
            "amount"
        );
        $where = array(
            //"acc_code"       => $cashcd,
			"voucher_mode"    => 'C',
            "approval_status" => 'U',
			"1 group by voucher_id " => NULL
        );
        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/view", $voucher);
        $this->load->view('post_login/footer');
    }

 public function f_get_onholdv(){

        $select          = array("count(*) as cnt_v");
        
       $where=array(
           "branch_id" =>$this->input->get("dist_cd"),
           "approval_status"=>'H'
           ) ;
    
           
        $cnt_v    = $this->Report_Model->f_select(' td_vouchers',$select,$where,1);
        echo $cnt_v->cnt_v;
          
    }	


    public function f_get_lstmnth(){

        //$fin_id              = $this->session->userdata['loggedin']['fin_id'];
        $select_lastend      = array("(end_mnth) as end_mnth","end_yr");
        $where_lastend       = array("branch_id" =>$this->input->get("dist_cd"));
        $data    = $this->Report_Model->f_select('td_month_end',$select_lastend,$where_lastend,1);
        
        echo json_encode($data);
        // echo $lstmnth->end_mnth;

          
    }	



    function month_end()
    {
      
        $fin_id              = $this->session->userdata['loggedin']['fin_id'];

        $where               = array("sl_no"=>$fin_id);
        $data['finyrdtls']   = $this->transaction_model->f_select('md_fin_year',NULL,$where,1);
       
        $select              = array("district_code","district_name");
        $data['distDtls']    = $this->transaction_model->f_select('md_district',$select,NULL,0);
        
        $select_lastend      = array("ifnull(max(end_mnth),0)+1 as mnth");
        $where_lastend       = array("end_yr"=>$fin_id);
        $data['lastend']     = $this->transaction_model->f_select('td_month_end',$select_lastend,$where_lastend,0);
          
        $where_mn            = array('id'=>$data['lastend'][0] ->mnth);
        $data['monthdtls']   = $this->transaction_model->f_select('md_month',NULL,$where_mn,1);
        // echo $this->db->last_query();
        // die();

        $data['row']         = $this->transaction_model->f_select("td_month_end", NULL, NULL, 0);
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $data_array = array(
                "branch_id"         =>  $this->input->post('dist'),
                "end_yr"            =>  $this->input->post('yr_sl'),
                "end_mnth"          =>  $this->input->post('mnth_id'),
                "remarks"           =>  $this->input->post('remarks'),
                "closed_by"         =>  $this->session->userdata('loggedin')['user_id'],
                "closed_dt"         =>  date('Y-m-d h:i:s')
            );
    
            $this->transaction_model->f_insert('td_month_end', $data_array);
    
        }
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/month_end", $data);
        $this->load->view('post_login/footer');
    
    }

    public function f_acc_code(){
		 
        $select	=	array("a.*");
        $data    = $this->transaction_model->f_select("md_achead a",$select,NULL,0);
        // $curl = curl_init();
        echo json_encode($data);
    }

    function entry()
    {
        $where = array(
            'mngr_id !=' => 6,
			'subgr_id !=' => 56
            //'br_id =' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
        $data['cash_head'] = $cashcd->ac_name;
        $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/entry", $data);
        $this->load->view('post_login/footer');
    }

    function save()
    {
        $data = $this->input->post();
        $where  = array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id = $this->session->userdata['loggedin']['fin_id'];
		$fin_yr = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis = $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id    = $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id    = $v_id->sl_no;
        $voucher_id = $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;
        $v_code  = $data['acc_code'];
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];

        for ($i = 0; $i < count($v_code); $i++) {
            if ($v_code[$i] != '' || $v_code[$i] > 0) {
                $data_array = array(
                    "voucher_date"      =>  $data['voucher_dt'],
                    "sl_no"             =>  $v_id,
                    "voucher_id"        =>  $voucher_id,
					"fin_yr"            =>  $fin_id,
                    "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                    "trans_no"          =>  0,
                    "voucher_type"      =>  $data['voucher_type'],
                    "voucher_mode"      =>  'C',
                    "voucher_through"   =>  'M',
                    "acc_code"          =>  $v_code[$i],
                    "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                    "remarks"           =>  $data['remarks'],
                    "amount"            =>  $v_amt[$i],
                    "approval_status"   =>  'U',
                    "user_flag"         =>  'S',
                    "ins_no"            =>  NULL,
                    "ins_dt"            =>  NULL,
                    "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                    "created_dt"        =>  date('Y-m-d h:i:s')
                );

                $this->transaction_model->f_insert('td_vouchers', $data_array);
            }
        }

        $row_array = array(
            "voucher_date"          =>  $data['voucher_dt'],
            "sl_no"                 =>  $v_id,
            "voucher_id"            =>  $voucher_id,
			"fin_yr"                =>  $fin_id,
            "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
            "trans_no"              =>  0,
            "voucher_type"          =>  $data['voucher_type'],
            "voucher_mode"          =>  'C',
            "voucher_through"       =>  'M',
            "acc_code"              =>  $data['topacc_cd'],
            "dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "approval_status"       =>  'U',
            "user_flag"             =>  'M',
            "ins_no"                =>  NULL,
            "ins_dt"                =>  NULL,
            "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
            "created_dt"            =>  date('Y-m-d h:i:s')
        );

        $this->transaction_model->f_insert('td_vouchers', $row_array);


        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('cashVoucher');
    }

    function edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
		$voucher_type            = $data['voucher_detail']->voucher_type;
        $where = array(
            //'mngr_id !=' => 6,
            //'br_id =' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
		$vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>$voucher_type == 'P' ? 'Dr' : 'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null );
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);
        $data['cash_head'] = $cashcd->ac_name;
        $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, NULL, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/edit", $data);
        $this->load->view('post_login/footer');
    }

    function update()
    {
        // echo '<pre>';
        $data = $this->input->post();
        $v_code  = $data['acc_code'];
		
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
           // if ($v_code[$i] != '' || $v_code[$i] > 0) {
                //$select = array('COUNT(*) row');
                $where = array(
                    'voucher_id'   => $data['voucher_id'],
					'voucher_date' => $data['voucher_dt'],
					'acc_code'     => $v_code[$i]
                );
                    $data_array = array(
                        //"acc_code"          =>  $v_code[$i],
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d h:i:s')
                    );
					
                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);

           // }
        }
		        $where = array(
                    'voucher_id'   => $data['voucher_id'],
					'voucher_date' => $data['voucher_dt'],
					'acc_code'     => $data['topacc_cd']
                );
                $data_array = array(
                      
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $data['tot_amt'],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d h:i:s')
                );
					
                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
	
		
        $this->session->set_flashdata('msg', 'Successfully Updated');
        redirect('cashVoucher');
    }

    function delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("cashVoucher");
    }

    function forward()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d h:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('cashVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        // var_dump($tnx_dtls);
        // exit;
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk)
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $where = array(
            'mngr_id !=' => 6,
            'br_id =' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'br_id' => $this->session->userdata['loggedin']['branch_id'],
            'mngr_id' => 6,
            'subgr_id' => 56
        );
        $cashcd = $this->transaction_model->f_select("md_achead", $select = null, $achead_where, 1);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $data['cash_head'] = $cashcd->ac_name;
        $data['cash_code'] = $cashcd->sl_no;
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/approve", $data);
        $this->load->view('post_login/footer');
    }

    function bank_view()
    {
        $select = array(
            "voucher_date",
            "voucher_id",
            "voucher_type",
            "voucher_mode",
            "dr_cr_flag",
            "amount"
        );

        $where  = array(
            //"user_flag"       => 'M',
            "voucher_mode"    => 'B',
            "approval_status" => 'U',
			"1 group by voucher_id" => NULL
        );
        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('transaction/bank_view', $voucher);
        $this->load->view('post_login/footer');
    }
/************************Advance from Society Voucher Vu************************** */
function adv_appview()
{
    $select = array(
        "voucher_date",
        "voucher_id",
        "trans_no",
        "amount",
        "approval_status"
    );

    $where  = array(
        //"user_flag"       => 'M',
        "voucher_type"    => 'A',
        "approval_status" => 'U',
        "1 group by voucher_id" => NULL
    );
    $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
    $this->load->view('post_login/finance_main');
    $this->load->view('transaction/adv_appview', $voucher);
    $this->load->view('post_login/footer');
}
/***************************************** */

    /************************Cr note to Society Voucher Vu************************** */
function crn_appview()
{
    $select = array(
        "voucher_date",
        "voucher_id",
        "trans_no",
        "amount",
        "approval_status"
    );

    $where  = array(
        //"user_flag"       => 'M',
        "voucher_type"    => 'CRN',
        "approval_status" => 'U',
        "1 group by voucher_id" => NULL
    );
    $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
    $this->load->view('post_login/finance_main');
    $this->load->view('transaction/crn_appview', $voucher);
    $this->load->view('post_login/footer');
}
/***************************************** */
	/************************************************** */
function purchase_appview()
    {
	$br_cd =$this->session->userdata['loggedin']['branch_id'];
        $select = array(
            "voucher_date",
            "voucher_id",
            "trans_no",
            "amount",
            "approval_status"
        );

        if ($br_cd==342){
            $where  = array(
                //"user_flag"       => 'M',
                // "voucher_type"    => 'PUR',
                "approval_status" => 'U',
                "1 group by voucher_id" => NULL
            );

        }else{
            $where  = array(
                //"user_flag"       => 'M',
                // "voucher_type"    => 'PUR',
                "branch_id"=>$br_cd,
                "approval_status" => 'U',
                "1 group by voucher_id" => NULL
            );
        }
        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view('transaction/purchase_appview', $voucher);
        $this->load->view('post_login/footer');
    }
    /***************************************** */
    public function f_upd_app(){
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $data_array = array(

				"approval_status"     => $this->input->post('appstatus'));
                $where = array(
                    "trans_no" => $this->input->post('trans_no')
            );
            $this->Report_Model->f_edit('td_vouchers', $data_array, $where);
            // echo $this->db->last_query();
            // die();
            $this->session->set_flashdata('msg', 'Successfully Updated');
            $this->load->view('post_login/finance_main');
            $this->load->view('post_login/footer');
            redirect('purchasevu');
        }
    }
    public function purchaseappv(){
        
            $id = $this->input->get('id');
            // $_SESSION["date"]= date('d-m-Y',strtotime($frm_date)).' - '. date('d-m-Y',strtotime($to_date));
            $fin_yr= $this->session->userdata['loggedin']['fin_id'];
           
            $data['voucher']     = $this->Report_Model->f_get_purappvoucher($id);
            
            $data['advance']     = $this->Report_Model->f_get_purappjnl($id);
            
            $this->load->view('post_login/finance_main');
            // $this->load->view('report/adv_jrnl/adv_jrnl.php',$data);
            $this->load->view('transaction/purapp_jrnl.php',$data);
            $this->load->view('post_login/footer');
    }


	/*******************************************/
    function bank_add()
    {
        $bnk_head_where = array(
            'mngr_id' => 6,
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            //'subgr_id !=' => 56,
            //'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, NULL, 0);
        $data['bank']  =   $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_entry", $data);
        $this->load->view('post_login/footer');
    }

    function bank_save()
    {
		
        $data = $this->input->post();
        $where          = array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id         = $this->session->userdata['loggedin']['fin_id'];
		$fin_yr         = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis            = $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id           =   $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id           =   $v_id->sl_no;
		$voucher_id     = $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;
        $v_code         =   $data['acc_code'];
        $v_dc           =   $data['dc_flg'];
        $v_amt          =   $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"fin_yr"            =>  $fin_id,
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  $data['inst_num'],
                "trans_dt"          =>  $data['inst_dt'],
                "voucher_type"      =>  $data['voucher_type'],
                "transfer_type"     =>  $data['transfer_type'],
                "voucher_mode"      =>  'B',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code[$i],
                "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d h:i:s')
            );
            $this->transaction_model->f_insert('td_vouchers', $data_array);
        }
		//  Code start for Bank Entry As Debit  
        $row_array = array(
            "voucher_date"          =>  $data['voucher_dt'],
            "sl_no"                 =>  $v_id,
            "voucher_id"            =>  $voucher_id,
			"fin_yr"                =>  $fin_id,
            "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
            "trans_no"              =>  $data['inst_num'],
            "trans_dt"              =>  $data['inst_dt'],
            "voucher_type"          =>  $data['voucher_type'],
            "transfer_type"         =>  $data['transfer_type'],
            "voucher_mode"          =>  'B',
            "voucher_through"       =>  'M',
            "acc_code"              =>  $data['bank_cd'],
            "dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "approval_status"       =>  'U',
            "user_flag"             =>  'M',
            "ins_no"                =>  NULL,
            "ins_dt"                =>  NULL,
            "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
            "created_dt"            =>  date('Y-m-d h:i:s')
        );
        $this->transaction_model->f_insert('td_vouchers', $row_array);
        //  Code start for Bank Entry As Debit 

        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('bankVoucher');
    }

    function bank_edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
        $voucher_type            = $data['voucher_detail']->voucher_type;
		$data['bank_detail']     = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id,'dr_cr_flag' =>$voucher_type == 'R' ? 'Dr' : 'Cr'), 1);
        
        $bnk_head_where = array(
            'mngr_id' => 6,
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
           // 'subgr_id !=' => 56,
           // 'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']      =  $this->transaction_model->f_select("md_achead", NULL, NULL, 0);
        $data['bank']     =  $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
		$vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>$voucher_type == 'P' ? 'Dr' : 'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null );
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);
        $data['head_tag'] =  $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_edit", $data);
        $this->load->view('post_login/footer');
    }

    function bank_update()
    {
        $data = $this->input->post();
        // echo '<pre>';
        // var_dump($data);
        // exit;
        $data = $this->input->post();
		$fin_yr         = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $v_code  = $data['acc_code'];
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
            if ($v_code[$i] != '' || $v_code[$i] > 0) {
                $select = array('COUNT(*) row');
                $where = array(
                    'voucher_id' => $data['voucher_id'],
                    'acc_code' => $v_code[$i]
                );
                $dt = $this->transaction_model->f_select("td_vouchers", $select, $where, 1);
                if ($dt->row > 0) {
                    $data_array = array(
					    "trans_no"          =>  $data['inst_num'],
                        "trans_dt"          =>  $data['inst_dt'],
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d h:i:s')
                    );

                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
                } else {
                    $data_array = array(
                        "voucher_date"          =>  $data['voucher_dt'],
                        "sl_no"                 =>  $data['sl_no'],
                        "voucher_id"            =>  $data['voucher_id'],
						"fin_yr"                =>  $fin_yr,
                        "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
                        "trans_no"              =>  $data['inst_num'],
                        "trans_dt"              =>  $data['inst_dt'],
                        "voucher_type"          =>  $data['voucher_type'],
                        "transfer_type"         =>  $data['transfer_type'],
                        "voucher_mode"          =>  'B',
                        "voucher_through"       =>  'M',
                        "acc_code"              =>  $v_code[$i],
                        "dr_cr_flag"            =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                        "remarks"               =>  $data['remarks'],
                        "amount"                =>  $v_amt[$i],
                        "approval_status"       =>  'U',
                        "user_flag"             =>  'M',
                        "ins_no"                =>  NULL,
                        "ins_dt"                =>  NULL,
                        "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"            =>  date('Y-m-d h:i:s'),
                        "modified_by"           =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"           =>  date('Y-m-d h:i:s')
                    );
                    $this->transaction_model->f_insert('td_vouchers', $data_array);
                }
            }
        }
        $where = array(
            'voucher_id' => $data['voucher_id'],
            'acc_code' => $data['bank_code']
        );
        $row_array = array(
            "trans_no"              =>  $data['inst_num'],
            "trans_dt"              =>  $data['inst_dt'],
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "modified_by"           =>  $this->session->userdata('loggedin')['user_id'],
            "modified_dt"           =>  date('Y-m-d h:i:s')
        );

        $this->transaction_model->f_edit('td_vouchers', $row_array, $where);
        $this->session->set_flashdata('msg', 'Successfully Updated');
        redirect('bankVoucher');
    }

    function bank_delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("bankVoucher");
    }

    function bank_forward()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d h:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('bankVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk) {
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            } else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'transfer_type' => $dt->transfer_type,
                    'trans_no' => $dt->trans_no,
                    'trans_dt' => $dt->trans_dt,
                    'acc_code' => $dt->acc_code,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $bnk_head_where = array(
            'mngr_id' => 6,
            'subgr_id' => 57,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $achead_where = array(
            'subgr_id !=' => 56,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['bank']  =   $this->transaction_model->f_select("md_achead", NULL, $bnk_head_where, 0);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/bank_approve", $data);
        $this->load->view('post_login/footer');
    }

    function jurnal_view()
    {
        $select = array(
            "voucher_date",
            "voucher_id",
            "voucher_type",
            "voucher_mode",
            "amount"
        );

        $where  = array(
           // "user_flag"         => 'M',
            "voucher_mode"      => 'J',
            "approval_status"   => 'U',
			"1 group by voucher_id" => NULL
        );

        $voucher['row']    = $this->transaction_model->f_select("td_vouchers", $select, $where, 0);
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_view", $voucher);
        $this->load->view('post_login/footer');
    }

    function jurnal_entry()
    {
        $achead_where = array(
            //'mngr_id !=' => 6,
            //'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, NULL, 0);

        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_entry", $data);
        $this->load->view('post_login/footer');
    }

    function jurnal_save()
    {
        $data = $this->input->post();
        $where          = array('id' => $this->session->userdata['loggedin']['branch_id']);
		$fin_id         = $this->session->userdata['loggedin']['fin_id'];
		$fin_yr         = str_replace("-","",$this->session->userdata['loggedin']['fin_yr']);
        $dis            = $this->transaction_model->f_select("md_branch", $select = null, $where, 1);
        $v_id           =   $this->transaction_model->f_get_voucher_id($fin_id);  // Incremented Sl No
        $v_id           =   $v_id->sl_no;
        $voucher_id     =   $dis->dist_sort_code .'-'. $fin_yr .'/'. $v_id;
        $v_code         =   $data['acc_code'];
        $v_dc           =   $data['dc_flg'];
        $v_amt          =   $data['amount'];

        for ($i = 0; $i < count($v_code); $i++) {
            $data_array = array(
                "voucher_date"      =>  $data['voucher_dt'],
                "sl_no"             =>  $v_id,
                "voucher_id"        =>  $voucher_id,
				"fin_yr"            =>  $fin_id,
                "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                "trans_no"          =>  0,
                "voucher_type"      =>  $data['voucher_type'],
                "voucher_mode"      =>  'J',
                "voucher_through"   =>  'M',
                "acc_code"          =>  $v_code[$i],
                "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                "remarks"           =>  $data['remarks'],
                "amount"            =>  $v_amt[$i],
                "approval_status"   =>  'U',
                "user_flag"         =>  'S',
                "ins_no"            =>  NULL,
                "ins_dt"            =>  NULL,
                "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "created_dt"        =>  date('Y-m-d h:i:s')
            );

            $this->transaction_model->f_insert('td_vouchers', $data_array);
        }

        $row_array = array(
            "voucher_date"          =>  $data['voucher_dt'],
            "sl_no"                 =>  $v_id,
            "voucher_id"            =>  $voucher_id,
			"fin_yr"                =>  $fin_id,
            "branch_id"             =>  $this->session->userdata['loggedin']['branch_id'],
            "trans_no"              =>  0,
            "voucher_type"          =>  $data['voucher_type'],
            "voucher_mode"          =>  'J',
            "voucher_through"       =>  'M',
            "acc_code"              =>  $data['acc_cd'],
            "dr_cr_flag"            =>  $data['dr_cr_flag'] == 'Debit' ? 'Dr' : 'Cr',
            "remarks"               =>  $data['remarks'],
            "amount"                =>  $data['tot_amt'],
            "approval_status"       =>  'U',
            "user_flag"             =>  'M',
            "ins_no"                =>  NULL,
            "ins_dt"                =>  NULL,
            "created_by"            =>  $this->session->userdata('loggedin')['user_id'],
            "created_dt"            =>  date('Y-m-d h:i:s')
        );

        $this->transaction_model->f_insert('td_vouchers', $row_array);


        $this->session->set_flashdata('msg', 'Successfully Added');

        redirect('jurnalVoucher');
    }

    function jurnal_edit()
    {
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();
		$data['voucher_detail']  = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id), 1);
        $voucher_type            = $data['voucher_detail']->voucher_type;
		$data['topacc_head']     = $this->transaction_model->f_select("td_vouchers", NULL,array('voucher_id' => $id,'dr_cr_flag' =>$voucher_type == 'R' ? 'Dr' : 'Cr'), 1);
        
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, NULL, 0);
		$select = array(
            'a.*','g.name gr_name','s.name subgr_name'
        );
        $vou_where = array('a.voucher_id' => $id,
		                   'a.dr_cr_flag' =>$voucher_type == 'P' ? 'Dr' : 'Cr',
						   'a.acc_code=b.sl_no' => null,
                           'b.mngr_id = g.sl_no' => null,
                           'b.subgr_id = s.sl_no' => null );
        $data['ac_dtls'] = $this->transaction_model->f_select("td_vouchers a,md_achead b,mda_mngroup g,mda_subgroub s", $select,$vou_where, 0);
        $data['head_tag'] = $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_edit", $data);
        $this->load->view('post_login/footer');
    }

    function jurnal_update()
    {
        $data = $this->input->post();
		$fin_id         = $this->session->userdata['loggedin']['fin_id'];
        $v_code  = $data['acc_code'];
        $v_dc    =  $data['dc_flg'];
        $v_amt   =  $data['amount'];
        for ($i = 0; $i < count($v_code); $i++) {
            if ($v_code[$i] != '' || $v_code[$i] > 0) {
                $select = array('COUNT(*) row');
                $where = array(
                    'voucher_id' => $data['voucher_id'],
                    'acc_code' => $v_code[$i]
                );
                $dt = $this->transaction_model->f_select("td_vouchers", $select, $where, 1);
                if ($dt->row > 0) {
                    $data_array = array(
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d h:i:s')
                    );

                    $this->transaction_model->f_edit('td_vouchers', $data_array, $where);
                } else {
                    $data_array = array(
                        "voucher_date"      =>  $data['voucher_dt'],
                        "sl_no"             =>  $data['sl_no'],
                        "voucher_id"        =>  $data['voucher_id'],
						"fin_yr"            =>  $fin_id,
                        "branch_id"         =>  $this->session->userdata['loggedin']['branch_id'],
                        "trans_no"          =>  0,
                        "voucher_type"      =>  $data['voucher_type'],
                        "voucher_mode"      =>  'J',
                        "voucher_through"   =>  'M',
                        "acc_code"          =>  $v_code[$i],
                        "dr_cr_flag"        =>  $v_dc[$i] == 'Debit' ? 'Dr' : 'Cr',
                        "remarks"           =>  $data['remarks'],
                        "amount"            =>  $v_amt[$i],
                        "approval_status"   =>  'U',
                        "user_flag"         =>  'S',
                        "ins_no"            =>  NULL,
                        "ins_dt"            =>  NULL,
                        "created_by"        =>  $this->session->userdata('loggedin')['user_id'],
                        "created_dt"        =>  date('Y-m-d h:i:s'),
                        "modified_by"       =>  $this->session->userdata('loggedin')['user_id'],
                        "modified_dt"       =>  date('Y-m-d h:i:s')
                    );
                    $this->transaction_model->f_insert('td_vouchers', $data_array);
                }
            }
        }
        $where = array(
            'voucher_id' => $data['voucher_id'],
            'acc_code' => $data['topacc_code']
        );
        $row_array = array(
            
            "remarks"             =>  $data['remarks'],
            "amount"              =>  $data['tot_amt'],
            "modified_by"         =>  $this->session->userdata('loggedin')['user_id'],
            "modified_dt"         =>  date('Y-m-d h:i:s')
        );

        $this->transaction_model->f_edit('td_vouchers', $row_array, $where);
        $this->session->set_flashdata('msg', 'Successfully Updated');
        redirect('jurnalVoucher');
    }

    function jurnal_delete()
    {
        $where = array(
            "voucher_id"  =>  $this->input->get('id')
        );
        $this->session->set_flashdata('msg', 'Successfully Deleted!');
        $this->transaction_model->f_delete('td_vouchers', $where);
        redirect("jurnalVoucher");
    }

    function jurnal_approve()
    {
        if (isset($_REQUEST['submit'])) {
            $input = array(
                'approval_status' => 'A',
                "approved_by"        =>  $this->session->userdata('loggedin')['user_id'],
                "approved_dt"        =>  date('Y-m-d h:i:s')
            );
            $ap_where = array(
                'voucher_id' => $this->input->post('voucher_id'),
            );
            $this->transaction_model->f_edit('td_vouchers', $input, $ap_where);
            $this->session->set_flashdata('msg', 'Successfully Approved');
            redirect('jurnalVoucher');
        }
        $id = $this->input->get('id');
        $ac_dtls = array();
        $head_tag = array();

        $select = array(
            'a.*', 'b.ac_name', 'c.name subgr_name', 'd.name gr_name'
        );
        $tnx_where = array(
            'a.voucher_id' => $id,
            'a.acc_code=b.sl_no' => null,
            'b.mngr_id = d.sl_no' => null,
            'b.subgr_id = c.sl_no' => null
        );
        $tnx_dtls = $this->transaction_model->f_select("td_vouchers a, md_achead b, mda_subgroub c, mda_mngroup d", $select, $tnx_where, 2);
        foreach ($tnx_dtls as $k => $dt) {
            $chk = $dt->voucher_type == 'R' ? 'Dr' : 'Cr';
            if ($dt->dr_cr_flag != $chk) {
                foreach ($dt as $key => $val) {
                    $ac_dtls[$k][$key] = $val;
                }
            } else {
                $head_tag = array(
                    'sl_no' => $dt->sl_no,
                    'voucher_id' => $dt->voucher_id,
                    'voucher_date' => $dt->voucher_date,
                    'voucher_type' => $dt->voucher_type,
                    'transfer_type' => $dt->transfer_type,
                    'trans_no' => $dt->trans_no,
                    'trans_dt' => $dt->trans_dt,
                    'acc_code' => $dt->acc_code,
                    'dr_cr_flag' => $dt->dr_cr_flag,
                    'ac_name' => $dt->ac_name,
                    'remarks' => $dt->remarks,
                    'tot_amt' => $dt->amount
                );
            }
        }
        $achead_where = array(
            'mngr_id !=' => 6,
            'br_id' => $this->session->userdata['loggedin']['branch_id']
        );
        $data['row']   =   $this->transaction_model->f_select("md_achead", NULL, $achead_where, 0);
        $data['ac_dtls'] = $ac_dtls;
        $data['head_tag'] = $head_tag;
        $this->load->view('post_login/finance_main');
        $this->load->view("transaction/jurnal_approve", $data);
        $this->load->view('post_login/footer');
    }

    function get_gr_dtls()
    {
        $achead_id = $this->input->get('ac_id');
        $data = $this->transaction_model->get_gr_dtls($achead_id);
        echo json_encode($data);
    }
}
