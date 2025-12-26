

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

<div class="content-wrapper">
    <div class="container-fluid">

        <!-- HEADING -->
        <h2 class="text-center">THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
        <h4 class="text-center">HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
        <h4 class="text-center">TDS Report Between: <?php echo $_SESSION['date']; ?></h4>
        <div class="mb-3 d-flex justify-content-between align-items-center">

<!-- LEFT SIDE TEXT -->
<span style="float:left; font-weight:bold; font-size:16px;">
    Code: BR007
</span>
        <!-- ACTION BUTTONS -->
        <div class="mb-3 text-right">
        <a href="<?php echo site_url('dashboard'); ?>" class="btnSame btn-danger" 
               style="width: 100px; margin-left:10px;">⬅Back</a>
            <button class="btnSame btn-primary" onclick="printTable()">Print</button>
            <button class="btnSame btn-warning" onclick="exportToPDF()">PDF</button>
            <button class="btnSame btn-success" onclick="exportToExcel()">Excel</button>

            <!-- <a href="<?php echo site_url('dashboard'); ?>" class="btnSame btn-danger" 
               style="width: 100px; margin-left:10px;">⬅Back</a> -->
        </div>

        <!-- ROUND HALF UP FUNCTION -->
        <?php 
        function round_half_up($number, $precision = 2) {
            $factor = pow(10, $precision);
            return abs(ceil($number * $factor - 0.0000001) / $factor);
        }
        ?>

        <!-- REPORT CONTENT -->
        <div id="report_area">
            <table class="table table-bordered table-striped" id="tdsTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Voucher Id</th>
                        <th>Voucher Type</th>
                        <th>Narration</th> <!-- NEW COLUMN -->

                        <th>Ledger 1</th>
                        <th>Ledger 2</th>
                        <th>Ledger 3</th>

                        <th>Amount 1</th>
                        <th>Amount 2</th>
                        <th>Amount 3</th>

                        <th>Total Amount</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>TDS PAYBLE</th>
                        <th>TDS %</th>

                        <th>Round Off</th>
                        <th>Bank</th>
                    </tr>
                </thead>

                <tbody>

                <?php 
                // TOTAL VARIABLES
                $total_amt1 = $total_amt2 = $total_amt3 = 0;
                $total_cgst = $total_sgst = 0;
                $total_tds  = 0;
                $total_round = 0;
                $total_bank = 0;
                $total_sum   = 0;
                ?>

                <?php if(!empty($tdspivot)) { 
                    foreach($tdspivot as $r) {

                        $sum_amt = $r->amount_1 + $r->amount_2 + $r->amount_3;

                        // Correct TDS percentage rounding
                        $raw_percent = ($sum_amt > 0) ? (($r->TDS_PAYBLE / $sum_amt) * 100) : 0;
                        $tds_percent = round_half_up($raw_percent, 2);
                ?>

                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($r->voucher_date)); ?></td>
                        <td><?php echo $r->voucher_id; ?></td>

                        <td>
                            <?php
                                if ($r->voucher_mode == 'J') echo 'Journal';
                                elseif ($r->voucher_mode == 'B') echo 'Bank';
                                elseif ($r->voucher_mode == 'C') echo 'Cash';
                                else echo $r->voucher_mode;
                            ?>
                        </td>

                        <td><?php echo $r->remarks; ?></td> <!-- NEW COLUMN -->

                        <td><?php echo $r->ledger_1; ?></td>
                        <td><?php echo $r->ledger_2; ?></td>
                        <td><?php echo $r->ledger_3; ?></td>

                        <td><?php echo $r->amount_1; ?></td>
                        <td><?php echo $r->amount_2; ?></td>
                        <td><?php echo $r->amount_3; ?></td>

                        <td><?php echo number_format($sum_amt,2); ?></td>

                        <td><?php echo $r->CGST; ?></td>
                        <td><?php echo $r->SGST; ?></td>
                        <td><?php echo $r->TDS_PAYBLE; ?></td>

                        <td><?php echo $tds_percent; ?></td>

                        <td><?php echo $r->ROUND_OFF; ?></td>
                        <td><?php echo $r->bank; ?></td>
                    </tr>

                    <?php
                        // TOTAL CALCULATIONS
                        $total_amt1 += $r->amount_1;
                        $total_amt2 += $r->amount_2;
                        $total_amt3 += $r->amount_3;
                        $total_sum  += $sum_amt;

                        $total_cgst += $r->CGST;
                        $total_sgst += $r->SGST;
                        $total_tds  += $r->TDS_PAYBLE;

                        $total_round += $r->ROUND_OFF;
                        $total_bank  += $r->bank;
                    ?>

                <?php }} else { ?>

                    <tr>
                        <td colspan="17" class="text-center text-danger">
                            No Records Found
                        </td>
                    </tr>

                <?php } ?>

                <!-- TOTAL ROW -->
                <?php if(!empty($tdspivot)) { ?>
                <tr class="bg-warning font-weight-bold">
                    <td colspan="7" class="text-right"><b>Total:</b></td>

                    <td><b><?php echo number_format($total_amt1,2); ?></b></td>
                    <td><b><?php echo number_format($total_amt2,2); ?></b></td>
                    <td><b><?php echo number_format($total_amt3,2); ?></b></td>

                    <td><b><?php echo number_format($total_sum,2); ?></b></td>

                    <td><b><?php echo number_format($total_cgst,2); ?></b></td>
                    <td><b><?php echo number_format($total_sgst,2); ?></b></td>
                    <td><b><?php echo number_format($total_tds,2); ?></b></td>

                    <td><b>—</b></td>

                    <td><b><?php echo number_format($total_round,2); ?></b></td>
                    <td><b><?php echo number_format($total_bank,2); ?></b></td>
                </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- JS LIBRARIES -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

<script>

// PRINT
function printTable() {
    var content = document.getElementById("report_area").innerHTML;
    var newWin = window.open("");
    newWin.document.write("<html><head><title>Print</title>");
    newWin.document.write("<style>table,th,td{border:1px solid #000;border-collapse:collapse;padding:6px;font-size:12px;}</style>");
    newWin.document.write("</head><body>");

    newWin.document.write("<h2 style='text-align:center;'>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>");
    newWin.document.write("<h4 style='text-align:center;'>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>");
    newWin.document.write("<h4 style='text-align:center;'>TDS Report Between: <?php echo $_SESSION['date']; ?></h4><br>");

    newWin.document.write(content);
    newWin.document.write("</body></html>");
    newWin.document.close();
    newWin.print();
}

// EXCEL EXPORT
function exportToExcel() {
    let table = document.getElementById("tdsTable");
    let wb = XLSX.utils.table_to_book(table, {sheet: "Report"});
    XLSX.writeFile(wb, "TDS_Pivot_Report.xlsx");
}

// PDF EXPORT
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF("l", "pt", "a4");

    doc.setFontSize(14);
    doc.text("THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.", 40, 30);
    doc.setFontSize(11);
    doc.text("HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.", 40, 50);
    doc.text("TDS Report Between: <?php echo $_SESSION['date']; ?>", 40, 70);

    doc.autoTable({
        html: "#tdsTable",
        startY: 90,
        theme: "grid",
        styles: { fontSize: 7 }
    });

    doc.save("TDS_Pivot_Report.pdf");
}

</script>
