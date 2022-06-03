<style>
table {
    border-collapse: collapse;
}
table, td, th {
    border: 1px solid #dddddd;
    padding: 6px;
    font-size: 14px;
}

th {
    text-align: center;
}

tr:hover {background-color: #f5f5f5;}
</style>
 <?php   if($_SERVER['REQUEST_METHOD'] == "GET") {  ?>
    <div class="wraper">      
        <div class="col-md-6 container form-wraper">
            <form method="POST" id="form" action="<?php echo site_url("trailbalsubgroup");?>" >
                <div class="form-header">
                    <h4>Input Dates</h4>
                </div>
                <div class="form-group row">
                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>
                    <div class="col-sm-6">
                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"/>  
                    </div>
                </div>

                <div class="form-group row">
                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                    <div class="col-sm-6">
                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"/>  
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-info" value="Submit" />
                    </div>
                </div>
            </form>    
        </div>
    </div>	
<?php }elseif($_SERVER['REQUEST_METHOD'] == "POST") { ?>

  <div class="wraper"> 

            <div class="col-lg-12 container contant-wraper">
                
                <div id="divToPrint">

                    <div style="text-align:center;">

                        <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                        <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                        <h4>Trial Balance Subgroup Between: <?php echo $_SESSION['date']; ?></h4>
                        <!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->district_name; ?></h5> -->

                    </div>
                    <br>  

                    <table style="width: 100%;" id="example">

                        <thead>
                            <tr>
                                <th rowspan='2'>Sl</th>
                                <th rowspan='2' style="width:40%">Ledger a/c Heads</th>
								<th colspan='2'>Opening</th>
                                <th colspan='2'>Transaction</th>
								<th colspan='2'>Closing</th>
                            </tr>
							<tr>
                                <th>Dr.</th>
                                <th>Cr.</th>
								<th>Dr.</th>
                                <th>Cr.</th>
								<th>Dr.</th>
                                <th>Cr.</th>
                            </tr>
                        </thead>

                        <tbody>
                                
                            <?php

                                if($trail_balnce){

                                    $i = 1;$otot_dr =0.00;$otot_cr =0.00;
                                    $total = 0.00;$tot_dr =0.00; $tot_cr =0.00;
                                    $val =0; $ope_bal = 0.00;$cls_bal = 0.00;$type='';
									$ctot_dr =0.00;$ctot_cr =0.00;
                                ?>
                                <?php   foreach($trail_balnce as $tb){ $type = $tb->type;  ?>
                                     
                                <tr class="rep">
                                     <td class="report"><?php echo $i++; ?></td>
                                     <!-- <tr v-for="(cover,index) in  packetDocument" i=index> -->
									 <td ><?php echo $tb->ac_name; ?></td>
									<td><?php if($type == 2 || $type == 4){ ?>
										  <?php echo abs($ope_bal); $otot_dr +=$ope_bal; ?>
										 <?php } ?>
									 </td>
                                     <td><?php if($type == 1 || $type == 3){ ?>
									       <?php echo abs($ope_bal); $otot_cr +=$ope_bal; ?>
								         <?php }  ?>
									 </td>
                                     <td ><?php echo $tb->dr_amt; $tot_dr +=$tb->dr_amt; ?></td>
                                     <td ><?php echo $tb->cr_amt; $tot_cr +=$tb->cr_amt; ?></td>
									 <td><?php if($type == 2 || $type == 4){ ?>
										  <?php echo abs($ope_bal+($tb->dr_amt)-($tb->cr_amt));
													$ctot_dr +=abs($ope_bal+($tb->dr_amt)-($tb->cr_amt));
										  ?>
										 <?php } ?>
									 </td>
                                     <td><?php if($type == 1 || $type == 3){ ?>
									       <?php echo abs($ope_bal+($tb->cr_amt)-($tb->dr_amt));
													$ctot_cr +=abs($ope_bal+($tb->cr_amt)-($tb->dr_amt));
										   ?>
								         <?php }  ?>
									 </td>
									
                                </tr>
 
                                <?php  
                                                        
                                    }
                                ?>
                                <tr style="font-weight: bold;">
								    <td colspan='2'>Total</td>
									<td><?=$otot_dr?></td>
									<td><?=$otot_cr?></td>
									<td><?=$tot_dr?></td>
									<td><?=$tot_cr?></td>
									<td><?=$ctot_dr?></td>
									<td><?=$ctot_cr?></td>
								</tr>
                                <?php 
                                       }
                                else{

                                    echo "<tr><td colspan='14' style='text-align:center;'>No Data Found</td></tr>";

                                }   

                            ?>

                        </tbody>

                    </table>

                </div>   
                
                <div style="text-align: center;">

                    <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
                   <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->

                </div>

            </div>
            
        </div> 
 
 <?php } ?>