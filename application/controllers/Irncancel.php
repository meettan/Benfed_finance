<?php
	class Irncancel extends CI_Controller{

		protected $sysdate;

		protected $fin_year;

		public function __construct(){

			parent::__construct();	

			$this->load->model('IrncancelModel');
			$this->load->model('Transaction_model');
			
			$this->session->userdata('fin_yr');

			if(!isset($this->session->userdata['loggedin']['user_id'])){
            
            redirect('User_Login/login');

            }
		}
		
		/****************************************** */		/****************************************** */
		public function irncanlcrs(){
			//echo $this->db->last_query();die();

			$serch=$this->input->get('serch');
			$formdate=$this->input->get('formdate');
			$todate=$this->input->get('todate');

			$this->load->library("pagination");
			$config = array();
			$config["base_url"] = site_url()."/Irncancel/irncancr/";
			$config["total_rows"] = $this->IrncancelModel->count_all_Data($serch,$formdate,$todate);
			$config["per_page"] = 20;
			$config["uri_segment"] = 2;
			$config["use_page_numbers"] = TRUE;
	
			$config['full_tag_open']     = '<div class="pagging text-right"><nav><ul class="pagination">';
			 $config['full_tag_close']   = '</ul></nav></div>';
			 $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
			 $config['num_tag_close']    = '</span></li>';
			 $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
			 $config['cur_tag_close']    = '<span class="sr-only"></span></span></li>';
			 $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
			 $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
			 $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
			 $config['prev_tag_close']   = '</span></li>';
			 $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
			 $config['first_tag_close' ] = '</span></li>';
			 $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
			 $config['last_tag_close']   = '</span></li>';
	
	
	
			$config["num_links"] = 2;
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['first_url'] = site_url()."/irncancr/";
			$this->pagination->initialize($config);
			// $page = $this->uri->segment('2');
			//$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	
			//$start = ($page - 1) * $config["per_page"];
			// $irn["links"] = $this->pagination->create_links();
			// $irn['data'] = $this->IrncancelModel->get_Data($config["per_page"],$page);


			$output = array(
				'pagination_link'		=>	$this->pagination->create_links(),
				'product_list'			=>	$this->IrncancelModel->get_Data($config["per_page"], $page,$serch,$formdate,$todate)
			);
			echo json_encode($output);

            // $select	=	array("a.ack" ,"a.ack_dt","a.irn","c.district_name");
            // $irn['data']    = $this->IrncancelModel->f_select("td_sale a,mm_ferti_soc b,md_district c",$select,$where,0);
            // $this->load->view("post_login/fertilizer_main");
            // $this->load->view("irncancelcr/dashboard_table",$irn);
            // $this->load->view('search/search');
        
            // $this->load->view('post_login/footer');

        }
		public function irnAft24(){
			$this->load->view("post_login/finance_main");
        
            $this->load->view("irncancelcr/dashboard");
        
            // $this->load->view('search/search');
        
            $this->load->view('post_login/footer');
		}

		public function irncancelcrv(){

			$br_id             = $this->session->userdata['loggedin']['branch_id'];
			$br_cd             = $this->session->userdata['loggedin']['branch_id'];
			//$dist_sort_code    = $this->session->userdata['loggedin']['dist_sort_code'];
			$fin_year_sort_code= substr($this->session->userdata['loggedin']['fin_yr'],2);
			$finYr            = $this->session->userdata['loggedin']['fin_id'];
			$branch         = $this->session->userdata['loggedin']['branch_id'];
			if($_SERVER['REQUEST_METHOD'] == "POST") {
							
					  $data     = array(
										   'trans_type'   => $this->input->post('trans_type'),
		
										   'sale_due_dt'  => $this->input->post('sale_due_dt'), 
		
										   'qty'          => $_POST['qty'],
		
										   'taxable_amt'  => $_POST['taxable_amt'],
											
										   'cgst'         => $_POST['cgst'],
		
										   'sgst'         => $_POST['sgst'],
		
										   'tot_amt'      => $_POST['tot_amt'],
										   
										   'round_tot_amt' => $_POST['round_tot_amt'],
										   
										   "modified_by"  =>  $this->session->userdata['loggedin']['user_name'],
		
										   "modified_dt"  =>  date('Y-m-d h:i:s'),
		
										);
		
				   $where  =   array(
		
						 'trans_do'     => $this->input->post('trans_do'),
		
						 'sale_ro'      => $this->input->post('ro')
		
					);
		
					$this->Transaction_model->f_edit('td_sale', $data, $where);
					//}
					$select_sale    = array("a.*","b.*");
					$where_ack     = array("ack"=> $this->input->post('ack'),"a.cust_id=b.id"=>NULL);
					// $sale=$this->Transaction_model->f_select('td_rent_collection a,md_rent_customer b',$select_sale,$where_ack,1);
					$sale=$this->Transaction_model->f_select('td_rent_collection a',$select_sale,$where_ack,1);

					$data_array_fin=$data;
					// $select_br    = array("dist_sort_code");
					// $where_br     = array("district_code"=> $br_id );
					// $br_nm=$this->Transaction_model->f_select('md_district',$select_br,$where_br,1);
							
							$data_array_fin['fin_fulyr']=$fin_year_sort_code;
							$data_array_fin['fin_yr']=$finYr;
							$data_array_fin['br_nm']= $br_nm->dist_sort_code;
							$data_array_fin['do_dt']= $sale->do_dt;
							$data_array_fin['trans_do']= $sale->trans_do;
							$data_array_fin['taxable_amt']= $sale->taxable_amt;
							$data_array_fin['tot_amt']= $sale->taxable_amt  + $sale->cgst + $sale->sgst;
							$data_array_fin['created_dt']= $sale->created_dt;
							$data_array_fin['created_by']= $sale->created_by;
							$data_array_fin['acc_cd']= $sale->acc_cd;
							$data_array_fin['cgst']= $sale->cgst;
							$data_array_fin['sgst']= $sale->sgst;
							$data_array_fin['br_cd']=$br_cd;
	
					// $data_array_fin['rem'] = $prod_name->prod_desc." Sale Return vide Ro No ".$rono;
					$data_array_fin['rem'] = $this->input->post('prod_desc')." Sale Return vide Ro No ";
				//$this->SaleModel->f_salejnl_crn($data_array_fin);
				//$this->IrncancelModel->f_cancelsalejnl($data_array_fin);
				
				$this->session->set_flashdata('msg', 'Successfully Updated');
		
				redirect('irncancr');
								
					}else {
		
					// $select5                = array("sl_no","cate_desc");
					
					// $where5                 =  array('district'     => $this->session->userdata['loggedin']['branch_id']);
					// $product['catg']        = $this->SaleModel->f_select('mm_category',$select5,NULL,0);
						
					$select4                = array("id","unit_name");
					// $product['unit']        = $this->SaleModel->f_select('mm_unit',$select4,NULL,0);
		
					 $select3               = array("comp_id","comp_name");
					 $product['compdtls']   = $this->Transaction_model->f_select('mm_company_dtls',$select3,NULL,0);
		
					$data['godown']     = $this->Transaction_model->f_select('md_godown',NULL,NULL,0);
					$data['rent_product']  = $this->Transaction_model->f_select('md_rent_product',NULL,NULL,0);	
					$data['customer']  = $this->Transaction_model->f_select('md_rent_customer',NULL,NULL,0);	
					$data['rntcledite']    = $this->Transaction_model->f_select("td_rent_collection", NULL, array("irn" => $this->input->get('irn')),1);
					
					$this->load->view('post_login/finance_main');
					$this->load->view("irncancelcr/edit",$data);
					$this->load->view('post_login/footer');
			}
		
		}
		
/*********************************IRN CANCEL DASHBOARD Within 24 Hours******************** */

        public function irncanl(){

            $select	=	array("a.ack" ,"a.ack_dt","a.irn","c.district_name");
        
            $where  =	array(
                "a.soc_id=b.soc_id"   => NULL,
                "a.br_cd=c.district_code" => NULL,
                 "HOUR(TIMEDIFF(now(),a.ack_dt))<=24"=>NULL,
                "a.ack>0"=>NULL,
                "fin_yr  =	'".$this->session->userdata['loggedin']['fin_id']."' ORDER BY a.ack_dt  desc,c.district_name"  => NULL
			
            );
        
            $irn['data']    = $this->IrncancelModel->f_select("td_sale a,mm_ferti_soc b,md_district c",$select,$where,0);
 			 // echo $this->db->last_query();
			// die();
            $this->load->view("post_login/fertilizer_main");
        
            $this->load->view("irncancel/dashboard",$irn);
        
            $this->load->view('search/search');
        
            $this->load->view('post_login/footer');
        }

        public function viewirn(){


			$br_id             = $this->session->userdata['loggedin']['branch_id'];
			$br_cd             = $this->session->userdata['loggedin']['branch_id'];
			$dist_sort_code    = $this->session->userdata['loggedin']['dist_sort_code'];
			$fin_year_sort_code= substr($this->session->userdata['loggedin']['fin_yr'],2);
			$finYr            = $this->session->userdata['loggedin']['fin_id'];
			$branch         = $this->session->userdata['loggedin']['branch_id'];

			$fin_year       = $this->session->userdata['loggedin']['fin_yr'];
            if($_SERVER['REQUEST_METHOD'] == "POST") {
        
                $data_array = array(
        
                        "ack"              => $this->input->post('ack'),
        
                        "ack_dt"   		   => $this->input->post('ack_dt'),
        
                        "irn"				=> $this->input->post('irn')
                    );
        
                $where = array(
                    "irn"     		    =>  $this->input->post('irn')
                );
				$select_sale    = array("a.*","b.*");
				$where_ack     = array("ack"=> $this->input->post('ack'),"a.soc_id=b.soc_id"=>NULL);
				$sale=$this->SaleModel->f_select('td_sale a,mm_ferti_soc b',$select_sale,$where_ack,1);
                
				$data_array_fin=$data_array;
				$select_br    = array("dist_sort_code");
				$where_br     = array("district_code"=> $br_id );
				$br_nm=$this->SaleModel->f_select('md_district',$select_br,$where_br,1);
						
						$data_array_fin['fin_fulyr']=$fin_year_sort_code;
						$data_array_fin['fin_yr']=$finYr;
						$data_array_fin['br_nm']= $br_nm->dist_sort_code;
						$data_array_fin['do_dt']= $sale->do_dt;
						$data_array_fin['trans_do']= $sale->trans_do;
						$data_array_fin['taxable_amt']= $sale->taxable_amt;
						$data_array_fin['tot_amt']= $sale->taxable_amt  + $sale->cgst + $sale->sgst;
						$data_array_fin['created_dt']= $sale->created_dt;
						$data_array_fin['created_by']= $sale->created_by;
						$data_array_fin['acc_cd']= $sale->acc_cd;
						$data_array_fin['cgst']= $sale->cgst;
						$data_array_fin['sgst']= $sale->sgst;
						$data_array_fin['br_cd']=$br_cd;

				// $data_array_fin['rem'] = $prod_name->prod_desc." Sale Return vide Ro No ".$rono;
				$data_array_fin['rem'] = $this->input->post('prod_desc')." Sale Return vide Ro No ";
				$this->IrncancelModel->f_cancelsalejnl($data_array_fin);
                // $this->SaleModel->f_edit('td_sale', $data_array, $where);
                $this->session->set_flashdata('msg', 'Successfully Updated');
        
                 redirect('irncan');
        
            }else{
                    $select = array(
                                "ack",
        
                                "ack_dt",
        
                                "irn"                       
                        );
        
                    $where = array(
        
                        "irn" => $this->input->get('irn')
                        
                        );
                    
                    $data['irnDtls']        = $this->IrncancelModel->f_get_adv_dtls($this->input->get('irn'));
					$sdata  = $this->SaleModel->f_get_particulars("td_sale", NULL, array("irn" => $this->input->get('irn')),1);
					$paid_id               = $this->IrncancelModel->f_get_paidid($sdata->trans_do);
					if($paid_id){
						$data['payment_fwd_cnt'] = $this->IrncancelModel->check_payment_forward($paid_id);
					}else{
						$data['payment_fwd_cnt'] = 0 ;
					}
					
        
                    $this->load->view('post_login/fertilizer_main');
        
                    $this->load->view("irncancel/edit",$data);
        
                    $this->load->view("post_login/footer");
            }
        }
        
        
/****************************************************Advance Dashboard************************************ */
//Company Advance dashoard
public function company_advance(){

    $select	=	array("a.trans_dt","a.receipt_no","a.comp_id","a.trans_type","b.comp_name");

	$where  =	array(
        "a.comp_id=b.comp_id"   => NULL,

       

        "fin_yr"              => $this->session->userdata['loggedin']['fin_id'],
    
    );

	$adv['data']    = $this->AdvanceModel->f_select("tdf_company_advance  a,mm_company_dtls b",$select,$where,0);

	$this->load->view("post_login/fertilizer_main");

	$this->load->view("company_advance/dashboard",$adv);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

//Company Advance add
public function company_advAdd(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

            $branch         = $this->session->userdata['loggedin']['branch_id'];

            $finYr          = $this->session->userdata['loggedin']['fin_id'];

            $fin_year       = $this->session->userdata['loggedin']['fin_yr'];

            $select         = array(
                "dist_sort_code"
            );

            $where          = array(
                "district_code"     =>  $branch
            );

            $brn            = $this->AdvanceModel->f_select("md_district",$select,$where,1);  

            $transCd 	    = $this->AdvanceModel->f_get_comp_advance_code($branch,$finYr);

            $receipt        = 'CompAdv/'.$brn->dist_sort_code.'/'.$fin_year.'/'.$transCd->sl_no;

		//  echo ($receipt);
		//  die();
			$data_array = array (

                    "trans_dt" 			=> $this->input->post('trans_dt'),

                    "sl_no" 			=> $transCd->sl_no,
                    
                    "receipt_no"        => $receipt,

                    "fin_yr"            => $finYr,

                    "branch_id"  		=> $branch,

                    "comp_id"            => $this->input->post('company'),

					"trans_type"   		=> $this->input->post('trans_type'),

					"adv_amt"			=> $this->input->post('adv_amt'),

					"remarks" 			=> $this->input->post('remarks'),

					"created_by"    	=> $this->session->userdata['loggedin']['user_name'],    

					"created_dt"    	=>  date('Y-m-d h:i:s')
				);

				// $this->AdvanceModel->f_insert('tdf_company_advance', $data_array);
				//  echo $this->db->last_query();
				//  die();
				$this->session->set_flashdata('msg', 'Successfully Added');

				redirect('adv/company_advance');

			}else {

                $select          		= array("comp_id","comp_name");
                
                // $where                  = array(
                //     "district"  =>  $this->session->userdata['loggedin']['branch_id']
                // );

				// $society['societyDtls']   = $this->AdvanceModel->f_select('mm_ferti_soc',$select,$where,0);
				$society['compDtls']   = $this->AdvanceModel->f_select('mm_company_dtls',$select,NULL,0);	
				$this->load->view('post_login/fertilizer_main');

				$this->load->view("company_advance/add",$society);

				$this->load->view('post_login/footer');
			}
}
//Company Advance Edit
public function company_editadv(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"trans_dt"              => $this->input->post('trans_dt'),

				"comp_id"   			    => $this->input->post('company'),

				"trans_type"    		=>  $this->input->post('trans_type'),

				"adv_amt"				=> $this->input->post('adv_amt'),

				"remarks" 				=> $this->input->post('remarks'),
				
				"modified_by"  			=>  $this->session->userdata['loggedin']['user_name'],
               
				"modified_dt"  			=>  date('Y-m-d h:i:s')	
			);

		$where = array(
            "receipt_no"     		    =>  $this->input->post('receipt_no')
		);
		 

		$this->AdvanceModel->f_edit('tdf_company_advance', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('adv/company_advance');

	}else{
			$select = array(
						"trans_dt",

						"receipt_no",

						"comp_id",
					
						"trans_type",
					
						"adv_amt",
					
						"remarks"                          
				);

			$where = array(

				"receipt_no" => $this->input->get('rcpt')
				
                );
                
            $select1          		= array("comp_id","comp_name");
            
            // $where1                 = array(
            //     "district"  =>  $this->session->userdata['loggedin']['branch_id']
            // );       

            $data['advDtls']        = $this->AdvanceModel->f_select("tdf_company_advance",$select,$where,1);

            $data['societyDtls']    = $this->AdvanceModel->f_select("mm_company_dtls",$select1,NULL,0);
                                                                         
            $this->load->view('post_login/fertilizer_main');

            $this->load->view("company_advance/edit",$data);

            $this->load->view("post_login/footer");
	}
}
//Company Advance Delete
public function company_advDel(){
			
    $where = array(
        
        "receipt_no"    =>  $this->input->get('receipt_no')
    );

    $this->session->set_flashdata('msg', 'Successfully Deleted!');

    $this->AdvanceModel->f_delete('tdf_company_advance', $where);

    redirect("adv/company_advance");
}	


//Socity Advace Dashboard
public function advance(){

    $select	=	array("a.trans_dt","a.receipt_no","a.soc_id","a.trans_type","b.soc_name","a.adv_amt");

	$where  =	array(
        "a.soc_id=b.soc_id"   => NULL,

        "district"            => $this->session->userdata['loggedin']['branch_id'],

        "fin_yr"              => $this->session->userdata['loggedin']['fin_id'],
    
    );

	$adv['data']    = $this->AdvanceModel->f_select("tdf_advance a,mm_ferti_soc b",$select,$where,0);
// echo $this->db->last_query();
// die();
	$this->load->view("post_login/fertilizer_main");

	$this->load->view("advance/dashboard",$adv);

	$this->load->view('search/search');

	$this->load->view('post_login/footer');
}

public function socadvReport()
{
	$receipt_no = $this->input->get('receipt_no');
	$adv['data']    = $this->AdvanceModel->f_get_receiptReport_dtls($receipt_no);
	
	$adv['receipt_no'] = $receipt_no;
	
	$this->load->view("post_login/fertilizer_main");

	$this->load->view('report/adv_receipt', $adv);

	$this->load->view('post_login/footer');
	
}
// Add Advance
public function advAdd(){
	$branch         = $this->session->userdata['loggedin']['branch_id'];
	
	$finYr          = $this->session->userdata['loggedin']['fin_id'];

	$fin_year       = $this->session->userdata['loggedin']['fin_yr'];

	if($_SERVER['REQUEST_METHOD'] == "POST") {

	

            $select         = array(
                "dist_sort_code"
            );

            $where          = array(
                "district_code"     =>  $branch
            );

            $brn            = $this->AdvanceModel->f_select("md_district",$select,$where,1);  

            $transCd 	    = $this->AdvanceModel->get_advance_code($branch,$finYr);

            $receipt        = 'Adv/'.$brn->dist_sort_code.'/'.$fin_year.'/'.$transCd->sl_no;

		
	
			$data_array = array (

                    "trans_dt" 			=> $this->input->post('trans_dt'),

                    "sl_no" 			=> $transCd->sl_no,
                    
                    "receipt_no"        => $receipt,

                    "fin_yr"            => $finYr,

                    "branch_id"  		=> $branch,

                    "soc_id"            => $this->input->post('society'),

				
					"trans_type"   		=> $this->input->post('trans_type'),

					"adv_amt"			=> $this->input->post('adv_amt'),

					"bank"            => $this->input->post('bank_id'),

					"remarks" 			=> $this->input->post('remarks'),

					

					"created_by"    	=> $this->session->userdata['loggedin']['user_name'],    

					"created_dt"    	=>  date('Y-m-d h:i:s')
				);
				// echo '<pre>';
				// print_r($data_array) ;
				// die();
				// foreach($data_array as $k => $v){
				// 	$key[]= $k;
				// 	$val[] = '"' . $v . '"'; 
				// }
				// $fields = implode(",", $key);
				// $values = implode(",", $val);
				// $sql = 'SELECT * FROM tdf_advance';
				// $query = $this->db->query($sql);
				// var_dump($query->result());
				// echo $this->db->last_query();
				// die();
				$this->AdvanceModel->f_insert('tdf_advance', $data_array);
				// echo $this->db->last_query();
				// die();
				$this->session->set_flashdata('msg', 'Successfully Added');

				redirect('adv/advance');

			}else {

                $select          		= array("soc_id","soc_name");
                
                $where                  = array(
                    "district"  =>  $this->session->userdata['loggedin']['branch_id']
                );

				$society['societyDtls'] = $this->AdvanceModel->f_select('mm_ferti_soc',$select,$where,0);

				$society['bnk_dtls']    = $this->AdvanceModel->f_getbnk_dtl($branch);	

				$this->load->view('post_login/fertilizer_main');

				$this->load->view("advance/add",$society);

				$this->load->view('post_login/footer');
			}
}

//Edit Soceity
public function editadv(){

	if($_SERVER['REQUEST_METHOD'] == "POST") {

		$data_array = array(

				"trans_dt"              => $this->input->post('trans_dt'),

				"soc_id"   			    => $this->input->post('society'),

				"trans_type"    		=>  $this->input->post('trans_type'),

				"adv_amt"				=> $this->input->post('adv_amt'),

				"bank"                  => $this->input->post('bank'),

				"remarks" 				=> $this->input->post('remarks'),
				
				"modifed_by"  			=>  $this->session->userdata['loggedin']['user_name'],
               
				"modifed_dt"  			=>  date('Y-m-d h:i:s')	
			);

		$where = array(
            "receipt_no"     		    =>  $this->input->post('receipt_no')
		);
		 

		$this->AdvanceModel->f_edit('tdf_advance', $data_array, $where);

		$this->session->set_flashdata('msg', 'Successfully Updated');

		redirect('adv/advance');

	}else{
			$select = array(
						"trans_dt",

						"receipt_no",

						"soc_id",
					
						"trans_type",
					
						"adv_amt",

						"bank",
						
						"remarks"                          
				);

			$where = array(

				"receipt_no" => $this->input->get('rcpt')
				
                );
			$select2          		= array("sl_no","bank_name");
			$where2                 = array(
                "dist_cd"  =>  $this->session->userdata['loggedin']['branch_id']
            );    
            $select1          		= array("soc_id","soc_name");
            
            $where1                 = array(
                "district"  =>  $this->session->userdata['loggedin']['branch_id']
            );       

			// $data['advDtls']        = $this->AdvanceModel->f_select("tdf_advance",$select,$where,1);
			$data['advDtls']        = $this->AdvanceModel->f_get_adv_dtls($this->input->get('rcpt'));

			$data['societyDtls']    = $this->AdvanceModel->f_select("mm_ferti_soc",$select1,$where1,0);
			
			$data['bnk_dtls']    = $this->AdvanceModel->f_select("mm_feri_bank",$select2,$where2,0);  
				//   echo $this->db->last_query();
				  
				//   die();
            $this->load->view('post_login/fertilizer_main');

            $this->load->view("advance/edit",$data);

            $this->load->view("post_login/footer");
	}
}
public function f_get_dist_bnk_dtls(){
			
	$select          = array("ifsc","ac_no");
	$where=array(
		"sl_no" =>$this->input->get("bnk_id")) ;
		
	//  $comp    = $this->Society_paymentModel->f_select('mm_dist_bank',$select,$where,0);
	$bnk    = $this->AdvanceModel->f_select('mm_feri_bank',$select,$where,0);
//  echo $this->db->last_query();
// 			die();
	 echo json_encode($bnk);
 
 }
//Delete
public function advDel(){
			
    $where = array(
        
        "receipt_no"    =>  $this->input->get('receipt_no')
    );

    $this->session->set_flashdata('msg', 'Successfully Deleted!');

    $this->AdvanceModel->f_delete('tdf_advance', $where);

    redirect("adv/advance");
}	

}
?>