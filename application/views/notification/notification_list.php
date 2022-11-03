<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>All Notification</strong></h1>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">
        <div class="col-sm-2">
       
		</div>
		<div class="col-sm-8" style="margin-top:20px">
			<form method="POST" action="<?php echo site_url("notification") ?>" >
            <label for="voucher_dt" class="col-sm-2 col-form-label">From Date:</label>
            <div class="col-sm-3">
              <input type="date" name="fr_dt" class="form-control" value="" required />
            </div>
            <label for="voucher_mode" class="col-sm-2 col-form-label">To Date:</label>
            <div class="col-sm-3">
                    <input type="date" name="to_dt" class="form-control" value="" required />
            </div>
			<div class="col-sm-2"><input type="submit" value="submit"></div>
			</form>
		</div>		

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Send By</th>
                    <th>Title</th>
                    <!-- <th>Branch</th> -->
                    <th>action</th>
                    
                </tr>

            </thead>

            <tbody>
                <?php
                if ($notification) {
                    $i=0;
                    foreach ($notification as $value) { $i++;
                ?>
                        <tr>
                            <td><?= $i?></td>
                            <td><?php echo date('d/m/Y', strtotime($value->send_dt)); ?></td>
                            <td><?php echo $value->send_user; ?></td>
                            <td><?php echo $value->msg_title; ?></td>
                            <!-- <td><?php echo $value->msg_text; ?></td> -->
                            <!-- <td><?php echo $value->receive_branch; ?></td> -->
                            
                            <td>
                              <a  title="Print" class="deletebtn" onclick="deletefunction(<?= $value->sl_no ?>)">

                            
                              <i class="fa fa-trash fa-2x" style="color:red;"></i>  
                              <!-- <span class="mdi mdi-printer"></span> -->
                              </a>

                              <a title="Print" onclick="editefunction(<?= $value->sl_no ?>)">

                            
                              <i class="fa fa-pencil fa-2x" style="color:green;"></i>  
                              <!-- <span class="mdi mdi-printer"></span> -->
                              </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                }
                ?>

            </tbody>

            <tfoot>

                <tr>

                <th>SL</th>
                    <th>Date</th>
                    <th>Send By</th>
                    <th>Title</th>
                    <!-- <th>Branch</th> -->
                    <th>action</th>
                </tr>

            </tfoot>

        </table>

    </div>

</div>

<script>
    // $(document).ready(function() {

    //     $('.delete').click(function() {

    //         var id = $(this).attr('id'),
    //             date = $(this).attr('date');

    //         var result = confirm("Do you really want to delete this record?");

    //         if (result) {

    //             window.location = "<?php echo site_url('transaction/delete?id="+id+"'); ?>";

    //         }

    //     });

    // });
</script>

<script>
   function deletefunction(id){

    r = confirm('are you sure you want to Delete?');
        if (r == true) {
            window.location.href='<?= site_url('notification/delete') ?>/'+id;
        } else {
        //
        }
   }


   function editefunction(id){
    window.location.href='<?= site_url('notification/edit') ?>/'+id;
   }



    
</script>