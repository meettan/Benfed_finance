<?php 
if (!function_exists('unaproved_voucher')) { 
    function unaproved_voucher($branch_id,$approval_status){
        $ci = &get_instance();
        $ci->load->database();
        $data=$ci->db->query("SELECT count(distinct voucher_id) c FROM td_vouchers where approval_status = '".$approval_status."' and branch_id = ".$branch_id)->result();
        return $data[0]->c;

    }
}
?>