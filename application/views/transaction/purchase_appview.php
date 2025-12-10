<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    /* Page Background */
    body {
        background: linear-gradient(135deg, #e3f2fd, #fce4ec);
    }

    /* Card Wrapper */
    .card-custom {
        background: #ffffff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        margin-bottom: 20px;
    }

    /* Table Style */
    table thead {
        background: linear-gradient(90deg, #3949ab, #5c6bc0);
        color: #fff;
    }

    table tbody tr:hover {
        background-color: #e8eaf6;
        cursor: pointer;
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

    /* Back Button */
    .btn-back {
        background: #007bff;
        border-radius: 30px;
        font-weight: bold;
        padding: 8px 20px;
        transition: 0.3s;
        color: #ffffff !important;
    }
    .btn-back:hover {
        background: #0056b3;
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

<div class="container-fluid mt-3">

    <div class="row">
        <div class="col-lg-9 col-sm-12">
            <h2 class="text-primary"><strong>Unapproved & Hold Vouchers</strong></h2>
        </div>
    </div>

    <div class="card-custom">

        <a href="<?php echo site_url("dashboard"); ?>" class="btn btn-back mb-3">⬅ Back</a>

        <div id="v_list">

            <table class="table table-bordered table-hover" id="example">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Voucher No.</th>
                        <th>Voucher Date</th>
                        <th>Status</th>
                        <th>Amount (₹)</th>
                        <th>Edit</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($row) {
                        $i = 1;
                        foreach ($row as $value) {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $value->voucher_id; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($value->voucher_date)); ?></td>

                        <td>
                            <?php if($value->approval_status=='U'){ ?>
                                <span class="status-unapproved">Unapproved</span>
                            <?php } else if($value->approval_status=='H') { ?>
                                <span class="status-hold">On Hold</span>
                            <?php } ?>
                        </td>

                        <td><strong style="color:#2e7d32;"><?php echo $value->dr_amt; ?></strong></td>

                        <td>
                            <a href="<?= site_url() ?>/Transaction/purchaseappv?id=<?php echo $value->voucher_id; ?>"
                               data-toggle="tooltip" title="Edit">
                                <i class="fa fa-edit fa-2x" style="color:#3949ab;"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center text-danger'><strong>No Data Found</strong></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <center>
            <img src="<?=base_url()?>assets/images/loader.gif" height="120px" id="image"
                style="margin-top:20px; display:none;">
        </center>

        <div id="v_lists"></div>

    </div>
</div>


<!-- DataTables Initialization -->
<script>
$(document).ready(function () {

    // Convert date to proper sorting format (dd-mm-yyyy → yyyy-mm-dd)
    $('#example tbody tr').each(function() {
        let dateText = $(this).find('td:eq(2)').text().trim();
        let parts = dateText.split('/');
        if(parts.length === 3){
            let sortableDate = parts[2] + '-' + parts[1] + '-' + parts[0]; // yyyy-mm-dd
            $(this).find('td:eq(2)').attr('data-order', sortableDate);
        }
    });

    $('#example').DataTable({
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100],
        "ordering": true,
        "searching": true,
        "info": true,
        "paging": true,

        // Default sort by Voucher Date (DESC)
        "order": [[2, "desc"]]
    });
});
</script>
