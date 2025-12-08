<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<style>
    body {
        background: linear-gradient(135deg, #cfd8dc, #fce4ec); /* lighter background */
        font-family: "Segoe UI", Tahoma, sans-serif;
    }

    .contant-wraper {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    h1 {
        color: #1565c0; /* dark blue */
        font-weight: 700;
        margin-bottom: 20px;
    }

    table {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    thead {
    /* background: linear-gradient(90deg, #1565c0, #1e88e5, #42a5f5); blue gradient */
    background: linear-gradient(to right, #003e7c, #0056b3);
    color: white;
    font-size: 15px;
}


    tbody tr:hover {
        background: #e3f2fd; /* light hover effect */
        transition: 0.3s;
    }

    /* Rounded Buttons */
    .btnSame {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 25px;
        width: 120px;
        display: inline-block;
        text-align: center;
        font-weight: 600;
        box-shadow: 0px 3px 6px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }
 /* Status Colors */
 .status-unapproved {
        background: #ffebee;
        color: #c62828;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: bold;
    }

    .status-hold {
        background: #fff8e1;
        color: #ff8f00;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #1565c0; /* dark blue */
        border: none;
    }

    .btn-danger {
        background-color: #d32f2f; /* red for back/delete */
        border: none;
    }

    .fa-edit:hover,
    .fa-trash-o:hover {
        transform: scale(1.2);
        transition: 0.2s;
    }

    label {
        font-weight: bold;
        color: #37474f;
    }

    input[type="date"] {
        border-radius: 6px;
        border: 1px solid #1565c0; /* blue border for date */
    }

    /* Add + Back Parallel Row */
    .top-button-row {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-row {
        padding: 15px;
        background: #e3f2fd; /* light blue background */
        border-radius: 10px;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
</style>

    <div class="wraper">

        <div class="row">

            <div class="col-lg-9 col-sm-12">

                <h1><strong>Unapproved Bank Vouchers</strong></h1>

            </div>

        </div>

        <!-- <div class="col-lg-12 container contant-wraper">
			<div class="col-sm-2">

            <?php if($count_data <= 0){ ?>
            <h3>
                <a href="<?php echo site_url("bankVoucher/entry"); ?>" class="btn btn-primary" style="width: 100px;">Add</a>
                <span class="confirm-div" style="float:right; color:green;"></span>
            </h3>

            <?php }else{
            ?>
             <a class="btn btn-primary" style="width: 100px;" onclick="alert('Some vouchers are pending for approval')">Add</a>
             <?php } ?>
			</div> -->
            <div class="col-lg-12 container contant-wraper">
            <!-- ADD + BACK BUTTON -->
        <div class="top-button-row">
            <?php if($count_data <= 0): ?>
                <a href="<?= site_url("bankVoucher/entry"); ?>" class="btnSame btn-primary">Add</a>
            <?php else: ?>
                <a class="btnSame btn-primary" onclick="alert('Some vouchers are pending for approval')">Add</a>
            <?php endif; ?>
            <a href="<?= site_url('dashboard'); ?>" class="btnSame btn-danger">Back</a>
        </div>
		    <!-- SEARCH ROW -->
            <div class="search-row row">
            <form method="POST" action="<?= site_url("transaction") ?>" class="row">
                <label class="col-sm-2 col-form-label">From Date:</label>
                <div class="col-sm-2">
                    <input type="date" name="fr_dt" class="form-control" required />
                </div>
                <label class="col-sm-2 col-form-label">To Date:</label>
                <div class="col-sm-2">
                    <input type="date" name="to_dt" class="form-control" required />
                </div>
                <div class="col-sm-2">
                    <input type="submit" value="Search" class="btnSame btn-primary">
                </div>
            </form>
        </div>

<!-- <a href="<?php echo site_url('dashboard'); ?>" 
   class="btnSame" 
   style="background-color: #dc3545; color: white; text-decoration:none;">
   Back
</a>
			</form> -->
		<!-- </div>	 -->

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Voucher No.</th>
                        <!-- <th>Type</th> -->
                        <th>Mode</th>
                        <th>Amount(₹)</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($row) {
                        foreach ($row as $value) {
                           // $drcr_flag = $value->voucher_type == 'R' ? 'Dr' : 'Cr';
                           // if ($value->dr_cr_flag == $drcr_flag) {
                    ?>

                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($value->voucher_date)); ?></td>
                                    <td><?php echo $value->voucher_id; ?></td>
                                    <!-- <td><?php $type = $value->voucher_type;
                                        if ($type == "P") {
                                            $type = "Payment";
                                        } else {
                                            $type = "Receipt";
                                        }
                                        echo $type;
                                        ?></td> -->
                                    <td><?php $mode = $value->voucher_mode;
                                        if ($mode == "C") {
                                            $val = "Cash";
                                        } elseif ($mode == "B") {
                                            $val = "Bank";
                                        } else {
                                            $val = "Transfer";
                                        }
                                        echo $val;
                                        ?></td>
                                        
                                    <td><?php echo $value->amount; ?></td>
                                    <td><?php if($value->approval_status=='U'){ ?>
                                <span class="status-unapproved">Unapproved</span>
                            <?php } else if($value->approval_status=='H') { ?>
                                <span class="status-hold">On Hold</span>
                            <?php } ?></td>
                                    <td><a href="<?= site_url() ?>/transaction/bank_edit?id=<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">

                                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                        </a>
                                    </td>
                                <!--    <td><a href="<?= site_url() ?>/transaction/bank_forward?id=<?php //echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Forward">
                                            <i class="fa fa-forward fa-2x" style="color: #007bff"></i>
                                        </a>
                                    </td>  -->
								<?php if($value->voucher_mode != 'A'){ ?>	
                                    <td>
                                        <button type="button" class="delete" date="<?php echo $value->voucher_date; ?>" id="<?php echo $value->voucher_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                        </button>
                                    </td>
								 <?php }?>	
                                </tr>

                    <?php
                          //  }
                        }
                    } else {

                        echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                    }
                    ?>

                </tbody>

                <tfoot>

                    <tr>

                        <th>Date</th>
                        <th>Voucher No.</th>
                        <!-- <th>Type</th> -->
                        <th>Mode</th>
                        <th>Amount(₹)</th>
                        <th>Status</th>
                        <th>Edit</th>
                       
                        <th>Delete</th>
                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

    <!-- <script>
        $(document).ready(function() {

            $('.delete').click(function() {

                var id = $(this).attr('id'),
                    date = $(this).attr('date');

                var result = confirm("Do you really want to delete this record?");

                if (result) {

                    window.location = "<?php echo site_url('transaction/bank_delete?id="+id+"'); ?>";

                }

            });

        });
    </script> -->

    <!-- <script>
        $(document).ready(function() {

            <?php if ($this->session->flashdata('msg')) { ?>
                window.alert("<?php echo $this->session->flashdata('msg'); ?>");
        });

        <?php } ?>
    </script> -->

    
<script>
$(document).ready(function() {

    // Initialize DataTables with empty table handling
    $('#cashVoucherTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100],
        "ordering": true,
        "searching": true,
        "info": true,
        "paging": true,
        "order": [[0, "desc"]],
        "language": {
            "emptyTable": "No data Found"
        }
    });

    // DELETE CONFIRM
    $('.delete').click(function() {
        var id = $(this).attr('id');
        if(confirm("Do you really want to delete this record?")){
            window.location = "<?= site_url('transaction/bank_delete?id='); ?>" + id;
        }
    });

    // FLASH MESSAGE
    <?php if ($this->session->flashdata('msg')): ?>
        alert("<?= $this->session->flashdata('msg'); ?>");
    <?php endif; ?>
});
</script>
