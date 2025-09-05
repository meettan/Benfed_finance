<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

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
    tr:hover {
        background-color: #f5f5f5;
    }

    /* DataTables sorting icons */
    table.dataTable thead .sorting:after {
        content: "↕";
        color: #888;
        font-size: 16px;
    }
    table.dataTable thead .sorting_asc:after {
        content: "▲";
        color: #4caf50;
        font-weight: bold;
        font-size: 16px;
    }
    table.dataTable thead .sorting_desc:after {
        content: "▼";
        color: #f44336;
        font-weight: bold;
        font-size: 16px;
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

    .tip {
        color: blue;
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

            <p class="tip"><b>Tip:</b> Click column headers to sort rows. Drag to reorder columns.</p>

            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th rowspan='2' style="width:90px !important">Date</th>
                        <th rowspan='2'>Particulars</th>
                        <th rowspan='2'>Voucher Type</th>
                        <th rowspan='2'>Narration</th>
                        <th rowspan='2'>Voucher No</th>
                        <th rowspan='2'>Ref. No.</th>
                        <th rowspan='2'>Invoice No.</th>
                        <th colspan='2'>Transaction</th>
                    </tr>
                    <tr>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if($accdetail){
                    $tot_debit = 0.00;
                    $tot_cre = 0.00;

                    // Opening balance row
                    $dr_amt = ($opebalcal && $opebalcal->trans_flag=='DR') ? abs($ope_bal) : 0;
                    $cr_amt = ($opebalcal && $opebalcal->trans_flag=='CR') ? abs($ope_bal) : 0;
                    echo "<tr>
                        <td></td>
                        <td>Opening Balance</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align='right'>{$dr_amt}</td>
                        <td align='right'>{$cr_amt}</td>
                    </tr>";

                    foreach($trail_balnce as $tb){
                        $dr = number_format($tb->dr_amt, 2, '.', '');
                        $cr = number_format($tb->cr_amt, 2, '.', '');
                        $tot_debit += $tb->dr_amt;
                        $tot_cre += $tb->cr_amt;

                        // Safe invoice lookup
                        $invoice_no = '';
                        foreach($inv_detail as $inv) {
                            if(!empty($tb->trans_no) && $tb->trans_no == $inv->ro_no){ 
                                $invoice_no = $inv->invoice_no; 
                                break;
                            }
                        }

                        echo "<tr class='rep'>
                            <td>".date('d-m-Y',strtotime($tb->voucher_date))."</td>
                            <td>{$tb->ac_name}</td>
                            <td>";
                        if($tb->voucher_mode=='C') echo 'Cash';
                        elseif($tb->voucher_mode=='J') echo 'Journal';
                        elseif($tb->voucher_mode=='B') echo 'Bank';
                        echo "</td>
                            <td style='width:30%;word-wrap: break-word'>{$tb->remarks}</td>
                            <td><a href='javascript:void(0)' onclick=\"voucherdtls('{$tb->voucher_id}')\">{$tb->voucher_id}</a></td>
                            <td>".(!empty($tb->trans_no)?$tb->trans_no:'')."</td>
                            <td>{$invoice_no}</td>
                            <td align='right'>{$dr}</td>
                            <td align='right'>{$cr}</td>
                        </tr>";
                    }

                    // Total row
                    echo "<tr>
                        <th>Total</th>
                        <th colspan='6'></th>
                        <th align='right'>".number_format($tot_debit,2,'.','')."</th>
                        <th align='right'>".number_format($tot_cre,2,'.','')."</th>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-top:15px;">
            <button class="btn btn-primary print-btn" type="button" onclick="printDiv();">Print</button>
            <button class="btn btn-danger pdf-btn" type="button" onclick="savePDF();">Save as PDF</button>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.27/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable({
        destroy: true,
        searching: false,
        ordering: true,
        paging: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Account Details',
                text: 'Export to Excel'
            }
        ]
    });
});

function printDiv() {
    var divToPrint = document.getElementById('divToPrint');
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write('<html><head><title>Print</title>');
    WinPrint.document.write('<style>table {border-collapse: collapse;} table, td, th {border:1px solid #ddd; padding:6px;}</style>');
    WinPrint.document.write('</head><body>');
    WinPrint.document.write(divToPrint.innerHTML);
    WinPrint.document.write('</body></html>');
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
}

function savePDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF('l', 'pt', 'a4');
    doc.setFontSize(10);
    doc.text("THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.", 40, 40);
    doc.text("Ledger Name: <?=$accdetail->ac_name?>", 40, 55);
    doc.autoTable({ html: '#example', startY: 70, theme:'grid', styles:{ fontSize:8, overflow:'linebreak' } });
    doc.save('Account_Details.pdf');
}

function voucherdtls(vid){
    window.open("<?php echo site_url('report/voucher_dtls?voucher_id=');?>"+vid,'_blank');
}
</script>
