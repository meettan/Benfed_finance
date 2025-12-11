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
<style>
    .container-fluid {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    h2 {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .row:first-child {
        margin-top: 0 !important;
    }

    body {
        margin-top: 0 !important;
    }
</style>
<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h2><strong>Handling & transport charges</strong></h2>

        </div>

    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
        <a href="<?php echo site_url("dashboard"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
            <a href="<?php echo site_url("handling-trandport-charges/customar_htc_entry"); ?>" class="btnSame btn-primary" style="width: 100px;">Add</a>
            <span class="confirm-div" style="float:right; color:green;"></span>
        </h3>

        <!-- <table class="table table-bordered table-hover" id="example"> -->
        <table id="cashVoucherTable" class="table table-bordered table-hover display">
            <thead>

                <tr>
                    <th>Sl No.</th>
                    <th>Effective Date</th>
                    <!-- <th>Godown</th> -->
                    <th>Customer</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Amount</th>
                    <th></th>
                </tr>

            </thead>

            <tbody>

                <?php
    // print_r($listData);
                if ($listData) {
                    $i = 1;
                    foreach ($listData as $rent_list) {
                        
                ?>

                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $rent_list->effective_date; ?></td>
                    <!-- <td><?php //echo $rent_list->gdn_name; ?></td> -->
                    <td><?php echo $rent_list->cust_name; ?></td>
                    <td><?php echo $rent_list->htc_start_date	; ?></td>
                    <td><?php echo $rent_list->htc_end_date	; ?></td>
                    <td><?php echo $rent_list->htc_amt	; ?></td>
                    <td><a href="<?php echo site_url() ?>/handling-trandport-charges/htc_edit/<?php echo $rent_list->sl_no ; ?>" data-toggle="tooltip"
                            data-placement="bottom" title="Edit">

                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                        </a>
                    </td>
                </tr>

                <?php
                     $i++;  
                    }
                } else {

                    echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
                }
                ?>

            </tbody>

            <tfoot>

            <th>Sl No.</th>
                    <th>Effective Date</th>
                    <!-- <th>Godown</th> -->
                    <th>Customer</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Amount</th>
                    <th></th>

            </tfoot>

        </table>

    </div>

</div>
<!-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "pagingType": "full_numbers",
            // "scrollY": 250,
            // "scrollX": true
        });
    });
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
    // $('.delete').click(function() {
    //     var id = $(this).attr('id');
    //     if(confirm("Do you really want to delete this record?")){
    //         window.location = "<?= site_url('transaction/delete?id='); ?>" + id;
    //     }
    // });

    // FLASH MESSAGE
    <?php if ($this->session->flashdata('msg')): ?>
        alert("<?= $this->session->flashdata('msg'); ?>");
    <?php endif; ?>
});
</script>
