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
	
	public function js_get_sale_rate($br_cd,$comp_id,$ro_dt,$prod_id)
	{
		$db2 = $this->load->database('seconddb', TRUE);
		$sql = $db2->query("SELECT a.catg_id,b.cate_desc
									from  mm_sale_rate a,
	   					                  mm_category b    							   							
					                     where  a.catg_id = b.sl_no
					                     and a.district='$br_cd'
			                             and a.comp_id='$comp_id'
			                             and a.prod_id ='$prod_id'
			                             and a.frm_dt =(select  max(frm_dt) from mm_sale_rate where frm_dt<='$ro_dt' 
													and district='$br_cd'
													and comp_id='$comp_id'
													and prod_id ='$prod_id')");

			return $sql->result();
	}
	public function js_get_stock_qty($ro)
	{
		$db2 = $this->load->database('seconddb', TRUE);
		$sql = $db2->query("SELECT a.stock_qty -  (select  ifnull(sum(qty) ,0) from td_sale where sale_ro ='$ro') stkqty,a.prod_id ,b.gst_rt ,b.prod_id,b.prod_desc,a.unit,c.unit_name FROM td_purchase a ,mm_product b ,mm_unit c WHERE a.prod_id=b.prod_id and a.unit=c.id and  a.ro_no = '$ro'");
			return $sql->row();
	}
	
	public function js_get_stock_point($ro_no){
        $db2 = $this->load->database('seconddb', TRUE);
			$query = $db2->query("select a.soc_id,a.soc_name
									from  mm_ferti_soc a,td_purchase b    							   							
									where  a.soc_id = b.stock_point
									and    a.stock_point_flag = 'Y'
									and    b.ro_no            = '$ro_no' ");
		return $query->row();
	}
	
	public function f_get_adv_dtls($recv_no){
		   $db2 = $this->load->database('seconddb', TRUE);
			$data   =   $db2->query("select  a.trans_dt ,a.sl_no,a.fin_yr,a.branch_id,a.soc_id,a.receipt_no,
			a.trans_type,a.adv_amt,a.bank,a.remarks,a.inv_no,a.ro_no,a.created_by,a.created_dt,b.bank_name,b.ac_no,
			a.cshbnk_flag
			from   tdf_advance a,mm_feri_bank b
			where  a.bank=b.sl_no
			and receipt_no = '$recv_no'");
			$result = $data->row();  
			return $result;
	}
 /******************************* */
	function f_get_purappvoucher($vid){
        $sql ="SELECT voucher_id,voucher_date,trans_dt,trans_no,transfer_type,ins_no,ins_dt,bank_name ,approval_status ,created_dt,created_by,
		       voucher_type
               FROM td_vouchers
               WHERE  voucher_id='$vid'
			    and approval_status IN('U','H')
			    GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name,approval_status
               order by voucher_date " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
	function f_get_purappjnl($vid){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
				and  voucher_id='$vid'
				 order by a.voucher_date,a.sl_no" ;
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
    /******************************* */
	function f_get_voucher($frm_date,$to_date,$fin_id,$branch_id){
        $sql ="SELECT voucher_id,voucher_date,trans_dt,trans_no,transfer_type,ins_no,ins_dt,bank_name FROM td_vouchers
               WHERE voucher_date >= '$frm_date' AND voucher_date <= '$to_date'
               
			   and branch_id='$branch_id'
               and approval_status!='H'
			   GROUP BY voucher_id,voucher_date,trans_no,transfer_type,ins_no,ins_dt,bank_name
               order by voucher_date " ;
            
        $query  = $this->db->query($sql);

        return $query->result();
    }
	
	function f_get_advjnl($frm_date,$to_date,$fin_id,$branch_id){
        $sql ="SELECT a.voucher_id, a.voucher_date,a.sl_no,a.remarks,a.amount,b.ac_name,a.dr_cr_flag,
                 a.voucher_type
				 FROM td_vouchers a,md_achead b
				 WHERE a.acc_code=b.sl_no 
				 and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
				 and a.approval_status!='H'
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
	
	
	public function f_get_cashjrnl_prt($receipt_no)
{

  $sql = $this->db->query(" select  a.voucher_date,a.voucher_id,a.voucher_type,a.amount,a.transfer_type,
                           a.trans_no,a.trans_dt, a.ins_no,a.ins_dt,a.dr_cr_flag,a.acc_code,c.ac_name,
                           c.benfed_ac_code,
                           a.bank_name,a.remarks,b.district_name as branch_name
                             from td_vouchers a,md_district b,md_achead c
                             where a.voucher_id='$receipt_no'
                             and a.acc_code=c.sl_no
                             and a.branch_id=b.district_code
                             ORDER BY a.dr_cr_flag ASC");			
  return $sql->result();

}

	public function f_get_acccodedtls(){

    $sql = $this->db->query("Select  a.sl_no,a.benfed_ac_code,b.name as main_gr,c.name as sub_gr,a.ac_name,b.type 
                            from md_achead a,  mda_mngroup b,mda_subgroub c
                            where a.mngr_id=b.sl_no
                            and a.subgr_id=c.sl_no
                            and c.mngr_id=b.sl_no
                            order by b.type,b.sl_no,c.sl_no,a.benfed_ac_code");            

    return $sql->result();

}
	
  function f_get_acheaddeatil(){
  $this->db->select("sl_no,ac_name,benfed_ac_code");
  $this->db->from("md_achead");
  $br_id=$this->session->userdata('loggedin')['branch_id'];
  $this->db->where_in('br_id', array($br_id,0));
  $this->db->order_by('ac_name'); 
 return $this->db->get()->result();
} 
	function f_get_trailbal($frm_date,$to_date,$op_dt){
		

		
		/* $sql ="select sum(op_dr)op_dr, sum(op_cr)op_cr, sum(dr_amt)dr_amt,
		      sum(cr_amt)cr_amt,ac_name,type,dr_cr_flag,benfed_ac_code,mngr_id
           
              from (
SELECT 0 op_dr,0 op_cr,if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id ,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,c.type,a.dr_cr_flag,b.benfed_ac_code
               FROM td_vouchers a,md_achead b,mda_mngroup c,td_opening d
               WHERE a.acc_code=b.sl_no
               and b.sl_no=d.acc_code
               and   b.mngr_id = c.sl_no and
			   a.voucher_date >=  '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id


 union 
              select if(trans_flag='DR',amount,0),if(trans_flag='CR',amount,0),0,b.mngr_id,0 ,b.ac_name,c.type,a.trans_flag,b.benfed_ac_code
               from  td_opening a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
              
               and   b.mngr_id = c.sl_no 
               and  balance_dt='$op_dt'
group by b.mngr_id,b.ac_name,c.type,a.trans_flag,b.benfed_ac_code)a
                  group by ac_name,type,benfed_ac_code,mngr_id" ;*/
		  $sql =" select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from(
SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from( 
        select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code 
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,    
          b.ac_name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
          FROM td_vouchers a ,md_achead b,mda_mngroup c
          WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date' 
          and a.approval_status!='H'
          group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id 
          union 
          SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
          from md_achead b,mda_mngroup c,td_opening d 
          where d.balance_dt=(select max(balance_dt) from td_opening 
                           where balance_dt<='$frm_date') 
          and b.mngr_id = c.sl_no and b.sl_no=d.acc_code group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id)b group by mngr_id, ac_name,type,benfed_ac_code )a
          group by benfed_ac_code 
union 
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
b.ac_name,a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c 
WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date'
and a.approval_status!='H'
AND a.voucher_date <= '$to_date' group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id)C
group by mngr_id, ac_name,type,benfed_ac_code
order by ac_name";
        $query  = $this->db->query($sql);
        return $query->result();
	}

    function f_get_trailbal_br($frm_date,$to_date,$op_dt,$brid){

		  $sql =" select sum(op_dr)op_dr,sum(op_cr)op_cr,sum(dr_amt)dr_amt,sum(cr_amt)cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from(
SELECT if(type=2,sum(op_dr)-sum(op_cr)+trans_dr-trans_cr,0) op_dr,if(type=1,sum(op_cr)-sum(op_dr)+trans_cr-trans_dr,0)op_cr ,0 dr_amt,0 cr_amt,mngr_id, ac_name,dr_cr_flag,type,benfed_ac_code 
from( 
        select sum(op_dr)op_dr, sum(op_cr)op_cr,sum(trans_dr)trans_dr , sum(trans_cr)trans_cr,mngr_id, ac_name,type,dr_cr_flag,benfed_ac_code 
        from(SELECT 0 op_dr,0 op_cr,sum(if(a.dr_cr_flag='DR',a.amount,0 ))trans_dr , sum(if(a.dr_cr_flag='CR',a.amount,0 ))trans_cr,b.mngr_id,    
          b.ac_name,c.type,UPPER(a.dr_cr_flag)dr_cr_flag,b.benfed_ac_code 
          FROM td_vouchers a ,md_achead b,mda_mngroup c
          WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.trans_dt>='$op_dt' AND a.trans_dt<='$frm_date'
          and a.approval_status!='H' 
          and b.br_id=$brid
          group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id 
          union 
          SELECT if(d.trans_flag='DR',d.amount,0),if(d.trans_flag='CR',d.amount,0),0 ,0 ,b.mngr_id, b.ac_name,c.type,UPPER(d.trans_flag),b.benfed_ac_code 
          from md_achead b,mda_mngroup c,td_opening d 
          where d.balance_dt=(select max(balance_dt) from td_opening 
                           where balance_dt<='$frm_date') 
          and b.mngr_id = c.sl_no and b.sl_no=d.acc_code and  b.br_id=$brid
           group by b.ac_name,c.type,b.benfed_ac_code,b.mngr_id )b 
          group by mngr_id, ac_name,type,benfed_ac_code )a
          group by benfed_ac_code 
union 
SELECT 0 op_dr,0 op_cr,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt, sum(if(dr_cr_flag='Cr',a.amount,0))as cr_amt,b.mngr_id ,
b.ac_name,a.dr_cr_flag,c.type,b.benfed_ac_code
FROM td_vouchers a,md_achead b,mda_mngroup c 
WHERE a.acc_code=b.sl_no and b.mngr_id = c.sl_no and a.voucher_date >= '$frm_date'
AND a.voucher_date <= '$to_date'  and b.br_id=$brid
and a.approval_status!='H'
 group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id )C
group by mngr_id, ac_name,type,benfed_ac_code
order by ac_name";
        $query  = $this->db->query($sql);
        return $query->result();
	}


	function f_get_trailbalsubgroup($frm_date,$to_date){
		
		$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.subgr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,c.type,a.dr_cr_flag
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
               and a.approval_status!='H'
               and   b.mngr_id = c.sl_no and
			   a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.subgr_id" ;
        $query  = $this->db->query($sql);
        return $query->result();
	}
	
	function f_get_group_total($frm_date,$to_date){
		
		$sql  ="select name,sum(dr_amt) as dr_amt,sum(cr_amt)as cr_amt,mngr_id from (SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt, if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag,c.name,b.mngr_id FROM mda_mngroup c,td_vouchers a,md_achead b WHERE c.sl_no=b.mngr_id 
        and a.acc_code=b.sl_no and a.voucher_date >= '$frm_date'
         AND a.voucher_date <= '$to_date' 
         and a.approval_status!='H'
         group by c.name,a.dr_cr_flag,b.mngr_id) tt group by name,mngr_id";
        $query  = $this->db->query($sql);
        return $query->result();		
	}

    function f_get_gl($frm_date,$to_date,$acc_head){
		
		$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,a.voucher_date,c.type,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
               and a.approval_status!='H'
			   and   b.sl_no   ='$acc_head'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
               group by b.ac_name,a.dr_cr_flag,b.ac_name,b.mngr_id,a.voucher_date" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}

    function f_get_acdeatil($frm_date,$to_date,$acc_head){
		
		/*$sql ="select a.acc_code,if(dr_cr_flag='Dr',a.amount,0)as dr_amt,a.voucher_date,a.remarks, if(dr_cr_flag='Cr',a.amount,0)as cr_amt,
        a.voucher_id,a.voucher_type,a.dr_cr_flag,b.ac_name,c.type from td_vouchers a,md_achead b,mda_mngroup c 
        where voucher_id in(SELECT a.voucher_id FROM td_vouchers a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no 
        and b.mngr_id =c.sl_no and b.sl_no ='$acc_head' and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date') 
        and a.acc_code !='$acc_head' and a.acc_code = b.sl_no and b.mngr_id = c.sl_no ORDER BY a.voucher_date ASC" ;*/
	$sql="select d.ac_name,sum(if(dr_cr_flag='Dr',a.amount,0))as dr_amt,a.voucher_date,a.remarks, sum(if(dr_cr_flag='Cr',a.amount,0))as       
	       cr_amt, a.voucher_id,a.voucher_type,a.dr_cr_flag,c.type
        from td_vouchers a,md_achead b,mda_mngroup c,(SELECT max(acc_code)acc_cd,voucher_id,b.ac_name
                                                      from td_vouchers a,md_achead b
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code !='$acc_head' 
                                                      and a.approval_status!='H'
                                                      and voucher_id in(select a.voucher_id
                                                      from td_vouchers a
                                                      where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head' )
                                                      and acc_code=b.sl_no   
                                                      group by voucher_id)d
         where a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date' and a.acc_code ='$acc_head'
        and a.acc_code = b.sl_no and b.mngr_id = c.sl_no 
        and a.voucher_id=d.voucher_id
        and a.approval_status!='H'
        group by d.acc_cd,a.voucher_date,a.remarks, a.voucher_id,a.voucher_type,a.dr_cr_flag,b.ac_name,c.type  ORDER BY a.voucher_date ASC";
        $query  = $this->db->query($sql);
        
        return $query->result();
	}
	function get_ope_gl($op_dt,$ope_date,$acc_head){
		
		/*$sql ="SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag as trans_flag,c.type,c.name
               FROM td_vouchers a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
			   and   b.sl_no   ='$acc_head'
               and a.voucher_date >='$op_dt' and a.voucher_date <= '$ope_date'
               group by a.dr_cr_flag,b.mngr_id,c.type,c.name" ;  */
               $sql="select sum(amt)dr_amt,0 cr_amt,type,mngr_id,acc_name, Case WHEN (type=2 or type=3)&& sum(amt) >0 THEN 'DR'
               WHEN (type=2 or type=3)&& sum(amt) <0 THEN 'CR'
                WHEN (type=1 or type=4)&& sum(amt) >0 THEN 'CR'
                WHEN (type=1 or type=4)&& sum(amt) <0 THEN 'DR'
                  ELSE ''
              END as trans_flag
               from(
               select if(((c.type=2 or c.type=3) && trans_flag='DR') or ((c.type=1 or c.type=4) && trans_flag='CR'),a.amount,-1*a.amount)amt,
               c.type,b.mngr_id,a.acc_name from td_opening a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no and b.mngr_id =c.sl_no
               and  acc_code='$acc_head'
               union
               select if( type =2 or type= 3,sum(dr_amt)-sum(cr_amt),if(type =1 or type= 4,sum(cr_amt)-sum(dr_amt),0)),
               type,mngr_id,ac_name
               from(
               SELECT if(dr_cr_flag='Dr',sum(a.amount),0)as dr_amt,b.mngr_id, if(dr_cr_flag='Cr',sum(a.amount),0)as cr_amt,a.dr_cr_flag as trans_flag,c.type,b.ac_name
                FROM td_vouchers a,md_achead b,mda_mngroup c WHERE a.acc_code=b.sl_no and b.mngr_id =c.sl_no and b.sl_no ='$acc_head'
               and a.voucher_date >='$op_dt' and a.voucher_date <= '$ope_date'
               group by a.dr_cr_flag,b.mngr_id,c.type,b.ac_name)a)b";
        $query  = $this->db->query($sql);
        return $query->row();
	}
    function get_ope_gl_re($ope_date,$acc_head){
		
		$sql ="SELECT if(trans_flag='DR',sum(a.amount),0)as dr_amt,b.mngr_id,
		       if(trans_flag='CR',sum(a.amount),0)as cr_amt,a.trans_flag,c.type,c.name
               FROM td_opening a,md_achead b,mda_mngroup c
               WHERE a.acc_code=b.sl_no
			   and   b.mngr_id   =c.sl_no
			   and   b.sl_no   ='$acc_head'
               AND a.balance_dt = '$ope_date'
               AND c.type in(1,2)
               group by a.trans_flag,b.mngr_id,c.type,c.name" ;  
        $query  = $this->db->query($sql);
        return $query->row();
	}
	function f_get_daybook($frm_date,$to_date){
		$branch_id = $this->session->userdata['loggedin']['branch_id'];
		$sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
		       if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag 
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
			   and a.branch_id = '$branch_id'
               and a.approval_status!='H'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
			   order by a.voucher_date,a.voucher_type" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}
    function f_get_cashbook($frm_date,$to_date){
		$branch_id = $this->session->userdata['loggedin']['branch_id'];
		$sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
		       if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag,b.benfed_ac_code
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
               and a.approval_status!='H'
			   and a.branch_id = '$branch_id'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
			   order by a.voucher_date,a.voucher_type" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}
    function f_get_bankbook($frm_date,$to_date){
		$branch_id = $this->session->userdata['loggedin']['branch_id'];
		$sql ="SELECT if(dr_cr_flag='Dr',a.amount,0)as dr_amt,b.mngr_id,a.voucher_id,a.voucher_date,a.voucher_type,
		       if(dr_cr_flag='Cr',a.amount,0)as cr_amt,b.ac_name,a.dr_cr_flag
               FROM td_vouchers a,md_achead b
               WHERE a.acc_code=b.sl_no
			   and a.branch_id = '$branch_id'
               and b.BNK_flag  = 'B'
               and a.approval_status!='H'
               and a.voucher_date >= '$frm_date' AND a.voucher_date <= '$to_date'
			   order by a.voucher_date,a.voucher_type" ;  
        $query  = $this->db->query($sql);
        return $query->result();
	}


}
