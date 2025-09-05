<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, td, th {
        border: 1px solid #dddddd;
        padding: 6px;
        font-size: 14px;
    }
    th {
        text-align: center;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
    /* Hide buttons in print */
    @media print {
        .dt-buttons,
        .print-btn,
        .pdf-btn {
            display: none !important;
            visibility: hidden !important;
        }
    }
</style>

<div class="wraper">
    <div class="col-lg-12 container contant-wraper">
        <div id="divToPrint">
            <div style="text-align:center;">
                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                <h4>Ledger Name: <?=$accdetail->ac_name?></h4>
                <h4>Ledger Code: <?=$accdetail->benfed_ac_code?></h4>
                <h4>Account Detail: <?php echo $_SESSION['date']; ?></h4>
                <h5 style="text-align:left"><label>District: </label>
                    <?php echo $this->session->userdata['loggedin']['branch_name']; ?></h5>
            </div>
            <br>

            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Particulars</th>
                        <th>Voucher Type</th>
                        <th>Narration</th>
                        <th>Voucher No</th>
                        <th>Ref. No.</th>
                        <th>Invoice No.</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($accdetail){
                        $tot_debit = 0; 
                        $tot_cre = 0;

                        if($opebalcal){
                            $opening = ($opebalcal->type == 1) ? $opebalcal->cr_amt - $opebalcal->dr_amt : $opebalcal->dr_amt - $opebalcal->cr_amt;
                        } else {
                            $opening = 0;
                        }
                    ?>
                    <tr>
                        <td></td>
                        <td>Opening Balance</td>
                        <td></td><td></td><td></td><td></td><td></td>
                        <td align="right"><?php if($opebalcal && $opebalcal->trans_flag=='DR'){ echo abs($opening); $tot_debit += abs($opening); }?></td>
                        <td align="right"><?php if($opebalcal && $opebalcal->trans_flag=='CR'){ echo abs($opening); $tot_cre += abs($opening); }?></td>
                    </tr>

                    <?php foreach($trail_balnce as $tb){ ?>
                    <tr>
                        <td><?php echo date('d-m-Y',strtotime($tb->voucher_date)); ?></td>
                        <td><?php echo $tb->ac_name; ?></td>
                        <td><?php echo ($tb->voucher_mode=='C')?'Cash':($tb->voucher_mode=='J'?'Journal':'Bank'); ?></td>
                        <td style="word-wrap: break-word"><?php echo $tb->remarks; ?></td>
                        <td><a href="javascript:void(0)" onclick="voucherdtls('<?php echo $tb->voucher_id; ?>')"><?php echo $tb->voucher_id; ?></a></td>
                        <td><?php echo $tb->trans_no ?? ''; ?></td>
                        <td>
                            <?php foreach($inv_detail as $inv){
                                if(!empty($tb->trans_no) && $tb->trans_no == $inv->ro_no) echo $inv->invoice_no;
                            } ?>
                        </td>
                        <td align="right"><?php echo number_format($tb->dr_amt,2,'.',''); $tot_debit += $tb->dr_amt;?></td>
                        <td align="right"><?php echo number_format($tb->cr_amt,2,'.',''); $tot_cre += $tb->cr_amt;?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th>Total</th>
                        <th colspan="6"></th>
                        <th align="right"><?=$tot_debit?></th>
                        <th align="right"><?=$tot_cre?></th>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-top:15px;">
            <button class="btn btn-primary print-btn" onclick="printDiv()">Print</button>
            <button class="btn btn-success excel-btn">Export to Excel</button>
            <button class="btn btn-danger pdf-btn" onclick="savePDF()">Save as PDF</button>
        </div>
    </div>
</div>

<!-- jQuery + DataTables + Buttons -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- jsPDF + AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable({
        dom: 'Bfrtip',
        paging: false,
        searching: false,
        ordering: false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Account Details',
                text: 'Export to Excel'
            }
        ]
    });

    // Trigger Excel button on custom button click
    $('.excel-btn').on('click', function() {
        table.button('.buttons-excel').trigger();
    });
});

// Print
function printDiv() {
    var divToPrint = document.getElementById('divToPrint');
    var win = window.open('', '', 'height=600,width=800');
    win.document.write('<html><head><title>Account Details</title>');
    win.document.write('<style>table {border-collapse: collapse;} table, td, th {border:1px solid #ddd;padding:6px;font-size:14px;} th{text-align:center;} </style>');
    win.document.write('</head><body>');
    win.document.write(divToPrint.innerHTML);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}

// PDF
function savePDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('l','pt','a4');
    doc.setFontSize(10);

    doc.text("THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.", 40, 40);
    doc.text("HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.", 40, 55);
    doc.text("Ledger Name: <?=$accdetail->ac_name?>", 40, 70);
    doc.text("Ledger Code: <?=$accdetail->benfed_ac_code?>", 40, 85);
    doc.text("Account Detail: <?php echo $_SESSION['date']; ?>", 40, 100);
    doc.text("District: <?php echo $this->session->userdata['loggedin']['branch_name']; ?>", 40, 115);

    doc.autoTable({
        html: '#example',
        startY: 130,
        theme: 'grid',
        styles: { fontSize: 8, overflow: 'linebreak' },
        headStyles: { fillColor: [52,73,94], textColor: 255 },
        footStyles: { fillColor: [52,73,94], textColor: 255 },
        margin: { left: 20, right: 20 },
        columnStyles: {
            0: { cellWidth: 60 },
            1: { cellWidth: 120 },
            2: { cellWidth: 60 },
            3: { cellWidth: 180 },
            4: { cellWidth: 60 },
            5: { cellWidth: 60 },
            6: { cellWidth: 60 },
            7: { cellWidth: 'auto', halign: 'right', fontSize: 7 },
            8: { cellWidth: 'auto', halign: 'right', fontSize: 7 }
        },
        didDrawPage: function(data) {
            var pageCount = doc.getNumberOfPages();
            doc.setFontSize(8);
            doc.text('Page ' + pageCount, data.settings.margin.left, doc.internal.pageSize.height - 10);
        }
    });

    doc.save('Account_Details.pdf');
}

// Voucher details popup
function voucherdtls(vid){
    window.open("<?php echo site_url('report/voucher_dtls?voucher_id=');?>"+vid,'_blank');
}
</script>
