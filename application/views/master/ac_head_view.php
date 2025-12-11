<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
    body {
        background: linear-gradient(135deg, #cfd8dc, #fce4ec);
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
        color: #1565c0;
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
        background: linear-gradient(to right, #003e7c, #0056b3);
        color: white;
        font-size: 15px;
    }

    tbody tr:hover {
        background: #e3f2fd;
        transition: 0.3s;
    }

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

    .btn-primary {
        background-color: #1565c0;
        border: none;
    }

    .btn-danger {
        background-color: #d32f2f;
        border: none;
    }

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

    .search-row {
        padding: 15px;
        background: #e3f2fd;
        border-radius: 10px;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .container-fluid, h2, .row:first-child, body {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
</style>

<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">
            <h2><strong>A/C Head Master</strong></h2>
        </div>

        <div class="col-lg-12 container contant-wraper">

            <h3>
                <a href="<?php echo site_url("dashboard"); ?>" 
                    class="btnSame btn-danger" 
                    style="width: 100px; margin-left:10px;">
                    ⬅ Back
                </a>

                <a href="<?php echo site_url("achead/entry"); ?>?id=" 
                   class="btnSame btn-primary" 
                   style="width: 100px;">
                   Add
                </a>

                <span class="confirm-div" style="float:right; color:green;"></span>
            </h3>

            <table class="table table-bordered table-hover" id="cashVoucherTable"> 
                <thead>
                    <tr>
                        <th>Sl No.</th>
                        <th>A/C Code</th>
                        <th>Branch</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>A/C Head</th>
                        <th>Option</th>
                    </tr>
                </thead>

                <tbody id="stordata"></tbody>

                <tfoot>
                    <tr>
                        <th>Sl No.</th>
                        <th>A/C Code</th>
                        <th>Branch</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>A/C Head</th>
                        <th>Option</th>
                    </tr>
                </tfoot>
            </table>

            <nav aria-label="..." class="pagination_link"></nav>

        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    load_data(1);

    function load_data(page) {

        $.ajax({
            url: "<?= site_url('Master/fetch_my_achead/') ?>" + page,
            type: "POST",
            dataType: "JSON",
            data: {
                action: "fetch_data",
                serch: $("#serch").val()
            },
            success: function (data) {

                $("#stordata").html(data.product_list);
                $(".pagination_link").html(data.pagination_link);

                // Reinitialize DataTable safely
                $('#cashVoucherTable').DataTable({
                    "destroy": true,
                    "pageLength": 10,
                    "lengthMenu": [5,10,25,50,100],
                    "ordering": true,
                    "searching": true,
                    "info": true,
                    "paging": true,
                    "order": [[0,"desc"]],
                    "language": { "emptyTable": "No data Found" }
                });
            }
        });
    }

    // Pagination click
    $(document).on("click", ".pagination_link li a", function (e) {
        e.preventDefault();
        var page = $(this).data("ci-pagination-page");
        load_data(page);
    });

    // Search (if field exists)
    $(".serch").keyup(function () {
        load_data(1);
    });

    // Flash message
    <?php if ($this->session->flashdata('msg')): ?>
        alert("<?= $this->session->flashdata('msg'); ?>");
    <?php endif; ?>

});
</script>
