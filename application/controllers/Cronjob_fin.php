<?php
	class Cronjob_fin extends CI_Controller{
		protected $sysdate;
		protected $fin_year;
		public function __construct(){
		parent::__construct();	
		
        $this->load->model('transaction_model');
	
		}

		public function voucher_cron_job(){

		     $data    = array(
				      'approval_status'       => "A"
					       );

	         $where  =   array(
                      
					  'CAST(created_dt AS DATE) <= CURDATE()'  => NULL,
					  'approval_status'   => 'U'
					);
	
            $this->transaction_model->f_edit('td_vouchers', $data, $where);
            //  echo $this->db->last_query();
            //  die();
		}
 


}
?>
