<style>
/* Header Section */
/* .report-header { */
    /* background: linear-gradient(135deg, #0b3c5d, #0d6efd); */
    /* background: linear-gradient(
    135deg,
    #0b3c5d 0%,
    #495057 50%,
    #0d6efd 100%
); */

    /* color: #ffffff;
    padding: 22px 25px;     /* slightly more height */
    /* border-radius: 8px; */
    /* margin: 0 -25px 20px;  🔥 extends header left & right */ */
/* }
 */

.report-header h2 {
    font-weight: 700;
    margin: 0;
    font-size: 22px;
}

.report-header h4 {
    margin: 4px 0;
    font-weight: 500;
    font-size: 14px;
    /* color: #e3e9f0; */
}

.report-title {
    margin-top: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    /* color: #f1f3f5; */
}

/* Code Badge */
.code-badge {
    background: #0b3c5d;
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 18px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 10px;
}

/* Table Header */
table th {
    background: linear-gradient(135deg, #0b3c5d, #495057);
    color: #ffffff;
    font-weight: 600;
    border: 1px solid #dee2e6;
}

/* Table Body */
table td {
    border: 1px solid #dee2e6;
    font-size: 13px;
    color: #212529;
}

/* Row Colors */
table tbody tr:nth-child(even) {
    background: #f8f9fa;
}

table tbody tr:hover {
    background: #e9ecef;
}

/* Print Safe Colors */
@media print {
    .report-header {
        background: #e9ecef !important;
        color: #000 !important;
    }

    table th {
        background: #dee2e6 !important;
        color: #000 !important;
    }
}
</style>



<script>
  function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; font-size: 12px;}' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function () {
            WindowObject.close();
        }, 10);

  }
</script>

        <div class="wraper"> 

            <div class="col-lg-12 container contant-wraper">
                
                <div id="divToPrint">

                <div class="report-header" style="text-align:center;">
    <h2>THE WEST BENGAL STATE CO.OP. MARKETING FEDERATION LTD.</h2>
    <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR</h4>
    <h4>1582 RAJDANGA MAIN ROAD, KOLKATA-700107</h4>
    <div class="report-title">Account Head Details</div>
</div>

<span class="code-badge">Code: BR002</span>

          
                    <br>  

                    <table style="width: 100%;" id="example">

                        <thead>

                            <tr>
                            <!-- a.sl_no,a.benfed_ac_code,b.name as main_gr,c.name as sub_gr,a.ac_name -->
                                <th>Sl No.</th>

                                <th>Type</th>

                                <th>Main-group Name</th>

                                <th>Sub-group Name</th>
                          
                                <th>Ledger/ Account head Code</th>

                                <th>Ledger/ Account head Name</th>

                               </tr>

                        </thead>

                        <tbody>

                            <?php

                                if($ledgcodedtls){ 

                                    $i = 1;

                                    foreach($ledgcodedtls as $ratedtls){

                            ?>

                                <tr>
                                     <td><?php echo $i++; ?></td>
                                     <td>
                                     <?php if($ratedtls->type== '1'){echo 'Liability '; } 
												 elseif($ratedtls->type == '2'){ echo 'Assets'; }
												 elseif($ratedtls->type == '3'){ echo 'Expence'; }
												 elseif($ratedtls->type == '4'){ echo 'Income'; }
												 ?>
                                    </td>
                                     <td><?php echo $ratedtls->main_gr; ?></td>
                                     <td><?php echo $ratedtls->sub_gr; ?></td>
                                     <td><?php echo $ratedtls->benfed_ac_code; ?></td>
                                     <td><?php echo $ratedtls->ac_name; ?></td>
                                </tr>
 
                                <?php    } ?>

 
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
        
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script> -->
<!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> -->

<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script>
   $('#example').dataTable({
    destroy: true,
   searching: false,ordering: false,paging: false,

dom: 'Bfrtip',
buttons: [
   {
extend: 'excelHtml5',
title: 'Account Code Datails',
text: 'Export to excel'
//Columns to export
// exportOptions: {
//    columns: [0, 1, 2, 3]
// }
   }
]
   });
</script>