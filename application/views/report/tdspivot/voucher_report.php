<div class="content-wrapper">
    <div class="container-fluid">

        <!-- HEADING -->
        <h2 class="text-center">THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
        <h4 class="text-center">HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
        <h4 class="text-center">TDS Report Between: <?php echo $_SESSION['date']; ?></h4>

        <!-- ACTION BUTTONS -->
        <div class="mb-3 text-right">
            <button class="btn btn-primary" onclick="printTable()">Print</button>
            <button class="btn btn-warning" onclick="exportToPDF()">Export to PDF</button>
            <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>

            <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-danger" 
               style="width: 100px; margin-left:10px;">Back</a>
        </div>

        <!-- REPORT CONTENT -->
        <div id="report_area">
            <table class="table table-bordered table-striped" id="tdsTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Date</th>
                        <th>Voucher Id</th>
                        <th>Voucher Type</th>

                        <th>Ledger 1</th>
                        <th>Ledger 2</th>
                        <th>Ledger 3</th>

                        <th>Amount 1</th>
                        <th>Amount 2</th>
                        <th>Amount 3</th>

                        <th>CGST</th>
                        <th>SGST</th>
                        <th>TDS PAYBLE</th>

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
                ?>

                <?php if(!empty($tdspivot)) { 
                    foreach($tdspivot as $r) { ?>

                    <tr>
                        <td><?php echo date('d-m-Y', strtotime($r->voucher_date)); ?></td>
                        <td><?php echo $r->voucher_id; ?></td>

                        <td>
                            <?php
                                if ($r->voucher_mode == 'J') {
                                    echo 'Journal';
                                } elseif ($r->voucher_mode == 'B') {
                                    echo 'Bank';
                                } elseif ($r->voucher_mode == 'C') {
                                    echo 'Cash';
                                } else {
                                    echo $r->voucher_mode;
                                }
                            ?>
                        </td>

                        <td><?php echo $r->ledger_1; ?></td>
                        <td><?php echo $r->ledger_2; ?></td>
                        <td><?php echo $r->ledger_3; ?></td>

                        <td><?php echo $r->amount_1; ?></td>
                        <td><?php echo $r->amount_2; ?></td>
                        <td><?php echo $r->amount_3; ?></td>

                        <td><?php echo $r->CGST; ?></td>
                        <td><?php echo $r->SGST; ?></td>
                        <td><?php echo $r->TDS_PAYBLE; ?></td>

                        <td><?php echo $r->ROUND_OFF; ?></td>
                        <td><?php echo $r->bank; ?></td>
                    </tr>

                    <?php
                        // TOTAL CALCULATIONS
                        $total_amt1 += $r->amount_1;
                        $total_amt2 += $r->amount_2;
                        $total_amt3 += $r->amount_3;

                        $total_cgst += $r->CGST;
                        $total_sgst += $r->SGST;

                        $total_tds  += $r->TDS_PAYBLE;

                        $total_round += $r->ROUND_OFF;
                        $total_bank  += $r->bank;
                    ?>

                <?php }} else { ?>

                    <tr>
                        <td colspan="14" class="text-center text-danger">
                            No Records Found
                        </td>
                    </tr>

                <?php } ?>

                <!-- TOTAL ROW -->
                <?php if(!empty($tdspivot)) { ?>
                <tr class="bg-warning font-weight-bold">
                    <td colspan="6" class="text-right"><b>Total:</b></td>

                    <td><b><?php echo number_format($total_amt1,2); ?></b></td>
                    <td><b><?php echo number_format($total_amt2,2); ?></b></td>
                    <td><b><?php echo number_format($total_amt3,2); ?></b></td>

                    <td><b><?php echo number_format($total_cgst,2); ?></b></td>
                    <td><b><?php echo number_format($total_sgst,2); ?></b></td>
                    <td><b><?php echo number_format($total_tds,2); ?></b></td>

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
