<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Report_Model');
		if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('login');

        }
        // $this->load->model('login_model');
        // $this->load->library('session');
        // $this->load->helper('captcha');
        // $this->load->helper('url');
        // $this->load->helper('form');
        // $this->load->library('email');
    }

    // function index()
    // {
    //     $dash_data = array();
    //     // $dash_data["ho_purchase_daysld"]    = get_purchase($_SESSION['sys_date'], $_SESSION['sys_date'], $branch_id, 'Y', 'S');
    //     $this->load->view('post_login/finance_main');
    //     $this->load->view('post_login/home', $dash_data);
    //     $this->load->view('post_login/footer');
    // }
    function index()
{
    $dash_data = array();

    // Branch ID from session
    $branch_id = $this->session->userdata['loggedin']['branch_id'];

    // Today start & end datetime
    $start = date('Y-m-d 00:00:00');
    $end   = date('Y-m-d 23:59:59');

    /* ===============================
       Approved vouchers of the day
       =============================== */
    $this->db->select('voucher_id');
    $this->db->distinct();
    $this->db->where('approval_status', 'A');
    $this->db->where('branch_id', $branch_id);
    $this->db->where('approved_dt >=', $start);
    $this->db->where('approved_dt <=', $end);
    $dash_data['approved_today'] = $this->db->count_all_results('td_vouchers');

    /* ===============================
       Unapproved vouchers of the day
       =============================== */
    $this->db->select('voucher_id');
    $this->db->distinct();
    $this->db->where('approval_status', 'U');
    $this->db->where('branch_id', $branch_id);
    // $this->db->where('created_dt >=', $start); // or voucher_dt
    // $this->db->where('created_dt <=', $end);
    $dash_data['unapproved_today'] = $this->db->count_all_results('td_vouchers');

    /* ===============================
       Vouchers on Hold for the day
       =============================== */
    $this->db->select('voucher_id');
    $this->db->distinct();
    $this->db->where('approval_status', 'H');
    $this->db->where('branch_id', $branch_id);
    // $this->db->where('hold_dt >=', $start); // OR approved_dt / voucher_dt
    // $this->db->where('hold_dt <=', $end);
    $dash_data['hold_today'] = $this->db->count_all_results('td_vouchers');
/* ===============================
           BAR CHART DATA
        =============================== */
        
        if (($branch_id ?? null) == 342) {
            
        $chartData = $this->Report_Model->get_last_3_months_credit_chart($branch_id);

        $months  = [];
        $amounts = [];

        foreach ($chartData as $row) {
            $months[]  = $row->month_name;          // ✔ FIXED
            $amounts[] = (float)$row->total_amount; // ✔ FIXED
        }

        $dash_data['chart_months']  = $months;
        $dash_data['chart_amounts'] = $amounts;
        }
/***** */
/* ===============================
           BAR CHART DATA
        =============================== */
        
        if (($branch_id ?? null) == 342) {
            
            $prev_chartData = $this->Report_Model->get_privyr_credit_chart($branch_id);
    
            $months  = [];
            $amounts = [];
    
            foreach ($prev_chartData as $row) {
                $months[]  = $row->month_name;          // ✔ FIXED
                $amounts[] = (float)$row->total_amount; // ✔ FIXED
            }
    
            $dash_data['prevchart_months']  = $months;
            $dash_data['prevchart_amounts'] = $amounts;
            }
    /******** */
    /* ===============================
   CLOSING BALANCE BAR CHART
================================ */

if (($branch_id ?? null) == 342) {

    $cbData = $this->Report_Model->get_closing_balance_chart($branch_id);

    $cb_labels   = [];
    $cb_balances = [];

    foreach ($cbData as $row) {
        $cb_labels[]   = $row->ac_name;
        $cb_balances[] = (float)$row->closing_balance;
    }

    $dash_data['cb_labels']   = $cb_labels;
    $dash_data['cb_balances'] = $cb_balances;
}

/***** */
    // Load views
    $this->load->view('post_login/finance_main');
    $this->load->view('post_login/home', $dash_data);
    $this->load->view('post_login/footer');
}


}
