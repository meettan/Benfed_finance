<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{
    public function f_select($table, $select = NULL, $where = NULL, $type)
    {

        if (isset($select)) {
            $this->db->select($select);
        }

        if (isset($where)) {
            $this->db->where($where);
        }

        $value = $this->db->get($table);

        if ($type == 1) {
            return $value->row();
        } else {
            return $value->result();
        }
    }

    public function jurnalVoucher($table, $select,$where, $group ){
        // $this->db->select('voucher_date,voucher_id,voucher_type,voucher_mode, SUM(amount) AS amount');
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->group_by($group);
        $value=$this->db->get();
        return $value->result();

    }



    public function f_insert($table_name, $data_array)
    {
        $this->db->insert($table_name, $data_array);
        return;
    }

    public function f_edit($table_name, $data_array, $where)
    {

        $this->db->where($where);
        $this->db->update($table_name, $data_array);

        return;
    }

    public function f_delete($table_name, $where)
    {
        $this->db->delete($table_name, $where);
        return;
    }
    public function select_purchase_appview($fYear,$br_cd){
        $data=$this->db->query("select voucher_date,
        voucher_id,
        approval_status,
        sum(dr_amount)dr_amt,sum(cr_amount) cr_amount
from(
select voucher_date,
        voucher_id,
    approval_status,
    sum(amount) dr_amount,
    0 cr_amount
    from td_vouchers
    where branch_id = ".$br_cd."
    and  approval_status in ('U','H')
    and  fin_yr = ".$fYear."
    and  dr_cr_flag = 'Dr'
    group by voucher_date,voucher_id,approval_status
UNION
select voucher_date,
        voucher_id,
    approval_status,
    0 dr_amount,
    sum(amount) cr_amount
    from td_vouchers
    where branch_id = ".$br_cd."
    and  approval_status in ('U','H')
    and  fin_yr = ".$fYear."
    and  dr_cr_flag = 'Cr'
    group by voucher_date,voucher_id,approval_status)a
 group by  voucher_date,
        voucher_id,
        approval_status");
        return $data->result();
    }

    function get_gr_dtls($achead_id)
    {
        $this->db->select('b.name as gr_name, c.name as subgr_name,a.benfed_ac_code');
        $this->db->join('mda_mngroup b', 'a.mngr_id=b.sl_no');
        $this->db->join('mda_subgroub c', 'a.subgr_id=c.sl_no');
        $this->db->where(array(
            'a.sl_no' => $achead_id
        ));
        $query = $this->db->get('md_achead a');
        return $query->row();
    }

    public function f_get_voucher_id($fin_yr)
    {
        $this->db->select('IFNULL(MAX(sl_no), 0)+1 as sl_no');
		$this->db->where(array(
                        'fin_yr =' => $fin_yr
                         ));
        $result = $this->db->get('td_vouchers');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return 0;
        }
    }

    public function f_select_fertidb($table, $select = NULL, $where = NULL, $type)
    {
        $db2 = $this->load->database('seconddb', TRUE);
        if (isset($select)) {
            $db2->select($select);
        }

        if (isset($where)) {
            $db2->where($where);
        }

        $value = $db2->get($table);

        if ($type == 1) {
            return $value->row();
        } else {
            return $value->result();
        }
    }

    
}
