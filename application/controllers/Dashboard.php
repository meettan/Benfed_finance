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

    // Load views
    $this->load->view('post_login/finance_main');
    $this->load->view('post_login/home', $dash_data);
    $this->load->view('post_login/footer');
}

}
