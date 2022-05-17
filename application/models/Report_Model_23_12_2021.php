<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
       
		$this->db2 = $this->load->database('seconddb', TRUE);
		
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
	
	public function f_selects($table, $select = NULL, $where = NULL, $type)   // For fertilizer Database
    {
         $db2 = $this->load->database('seconddb', TRUE);
        if (isset($select)) {
            $db2->select($select);
        }

        if (isset($where)) {
            $db2->where($where);
        }

        $value =$db2->get($table);
        
        if ($type == 1) {
            return $value->row();
        } else {
            return $value->result();
        }
    }
 
	function f_get_voucher($frm_date,$to_date,$fin_id,$voucher_type,$branch_id){
        $sql ="SELECT voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name FROM td_vouchers
               WHERE voucher_date >= '$frm_date' AND voucher_date <= '$to_date'
               and voucher_type='$voucher_type'
			   and branch_id='$branch_id'
			   GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name
               order by voucher_date " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
	function f_get_advjnl($frm_date,$to_date,$fin_id,$voucher_type,$branch_id){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
				 and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
				 and a.voucher_type='$voucher_type'
				 and a.branch_id='$branch_id'
				 order by a.voucher_date,a.sl_no" ;
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
    function f_get_crjnl($frm_date,$to_date,$fin_yr){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='CRN'
        
          order by a.voucher_date,a.sl_no " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }

    function f_get_sljnl($frm_date,$to_date,$fin_yr){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='SL'
        
          order by a.voucher_id,a.sl_no,a.dr_cr_flag,a.voucher_date " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }

    function f_get_purjnl($frm_date,$to_date,$fin_yr){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
         FROM td_vouchers a,md_achead b
          WHERE a.acc_code=b.sl_no 
          and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
          and a.voucher_type='PUR'
        
          order by a.voucher_id,a.sl_no,a.dr_cr_flag,a.voucher_date " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
	function f_get_trailbal($frm_date,$to_date){
		
		$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no 
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}
	
	function f_get_group_total($frm_date,$to_date){
		
	$sql  ="select name,sum(dr_amt) as dr_amt,sum(cr_amt)as cr_amt,mngr_id from (SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,   		if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag,c.name,b.mngr_id FROM mda_mngroup c,td_vouchers a,md_achead b WHERE 				c.sl_no=b.mngr_id and a.acc_code=b.sl_no and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' group by 				c.name,a.dr_cr_flag,b.mngr_id) tt group by name,mngr_id";
        $query  = $this->db->query($sql);
        return $query->result();		
	}
	
	function f_get_gl($frm_date,$to_date,$acc_head){
		
		$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
			   and   b.sl_no   ='$acc_head'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}
   }
