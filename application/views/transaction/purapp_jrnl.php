<style>

/* ---- GLOBAL ---- */
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f0f4fa;
}

/* ---- HEADER ---- */
.billPrintWrapper h2 {
    color: #002b5c;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.billPrintWrapper h4 {
    color: #003f7d;
    font-size: 16px;
    font-weight: 600;
}

/* ---- WRAPPER / CARD ---- */
.contant-wraper {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0,0,0,0.08);
    margin-top: 20px;
}

/* ---- TOP BOXES ---- */
.printTop023 {
    background: #eaf3ff;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 5px solid #0056b3;
    overflow: auto;
}

.leftNo, .rightDate {
    font-size: 15px;
    font-weight: 600;
    color: #003567;
}

/* ---- DROPDOWN ---- */
.cente select {
    padding: 7px 10px;
    border: 1px solid #bcd3f5;
    border-radius: 6px;
    outline: none;
    font-size: 14px;
    font-weight: bold;
    background: #f4f9ff;
    color: #003e7c;
}
.cente select:hover {
    border-color: #007bff;
}

/* ---- TABLE NEW DESIGN ---- */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

table thead th {
    background: linear-gradient(to right, #003e7c, #0056b3);
    color: white;
    padding: 12px;
    text-align: center;
    border: none;
    font-size: 14px;
}

table tbody tr {
    background: white;
    transition: 0.2s;
}

table tbody tr:hover {
    background: #eaf4ff;
    transform: scale(1.01);
}

table td {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;
    font-size: 14px;
}

/* ---- TOTAL ROW ---- */
.total-error {
    background: #ffd8d8 !important;
}
tfoot tr th {
    background: #003e7c;
    color: white;
    padding: 10px;
}

/* ---- BUTTONS NEW STYLE ---- */
.btn-primary {
    background: #0056b3 !important;
    border: none;
    padding: 10px 25px;
    border-radius: 35px;
    font-weight: bold;
    box-shadow: 0px 4px 12px rgba(0,86,179,0.3);
    transition: 0.3s;
}

.btn-primary:hover {
    background: #003e7c !important;
    transform: translateY(-2px);
}

.btn-danger {
    background: #e0303b !important;
    border: none;
    padding: 10px 25px;
    border-radius: 35px;
    font-weight: bold;
    box-shadow: 0px 4px 12px rgba(224,48,59,0.3);
}

.btn-danger:hover {
    background: #b51e26 !important;
    transform: translateY(-2px);
}

/* ---- REMARKS ---- */
.remarks {
    font-size: 16px;
    font-weight: bold;
    background: #fff7d1;
    padding: 10px;
    border-left: 4px solid #ffc107;
    margin-top: 20px;
    border-radius: 6px;
}

</style>



<script>
function printDiv() {

    var divToPrint = document.getElementById('divToPrint');

    var WindowObject = window.open('', 'Print-Window');
    WindowObject.document.open();
    WindowObject.document.writeln('<!DOCTYPE html>');
    WindowObject.document.writeln('<html><head><title>Print</title>');
    WindowObject.document.writeln('<style>');
    WindowObject.document.writeln('@media print { table{width:100%; border-collapse:collapse;} th{background:#007bff;color:#fff;padding:6px;} td{padding:6px;} }');
    WindowObject.document.writeln('</style></head><body onload="window.print()">');
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
        <form method="POST" id="form" action="<?php echo site_url("transaction/f_upd_app");?>">
        <div id="divToPrint">
            <div class="billPrintWrapper">

                <div style="text-align:center;">
                    <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                    <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                </div>

                <br>

                <?php foreach($voucher as $vou); ?>

                <div class="printTop023">
                    <div class="leftNo">Voucher ID: <?=$vou->voucher_id?></div><br>

                    <div class="leftNo">Dated: <?php echo date("d/m/Y",strtotime($vou->voucher_date)); ?></div>

                    <center>
                        <span class="cente">
                            Approval Status:
                            <select id="appstatus" name="appstatus">
                                <option value="">Select Product Type</option>
                                <option value="U" <?php echo ($vou->approval_status == 'U')? 'selected' : '';?>>Unapproved</option>
                                <option value="A" <?php echo ($vou->approval_status == 'A')? 'selected' : '';?>>Approved</option>
                                <option value="H" <?php echo ($vou->approval_status == 'H')? 'selected' : '';?>>On Hold</option>
                            </select>
                        </span>
                    </center>

                    <div class="rightDate" style="margin-top:-49px;">Created By: <?=$vou->created_by?></div>
                    <div class="rightDate" style="margin-top:-27px;">Created Date: <?php echo date("d/m/Y H:i:s",strtotime($vou->created_dt));?></div>
                </div>

                <div class="printTop023">
                    <div class="leftNo">Transaction No: <?=$vou->trans_no?></div>
                    <input type="hidden" name="trans_no" value="<?=$vou->trans_no?>">
                    <input type="hidden" name="voucher_date" value="<?=$vou->voucher_date?>">
                    <input type="hidden" name="voucher_id" value="<?=$vou->voucher_id?>">
                </div>

                <br>

                <div class="tableArea">
                <table>
                    <thead>
                        <tr>
                            <th>A/C Head</th>
                            <th>Trans Type</th>
                            <th>Dr Amount(₹)</th>
                            <th>Cr Amount(₹)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php  
                        $dr_tot  = 0.00;
                        $cr_tot  = 0.00;
                        $remarks = '';

                        if($advance){
                            foreach($advance as $adv){
                                if($adv->amount > 0){
                                    if($adv->voucher_id == $vou->voucher_id){
                                        $remarks = $adv->remarks;
                        ?>
                        <tr>
                            <td><?=$adv->ac_name?></td>
                            <td><?=$adv->dr_cr_flag?></td>
                            <td><?php 
                                if($adv->dr_cr_flag=='Dr'){
                                    echo $adv->amount;
                                    $dr_tot += $adv->amount;
                                } else { echo '0.00'; }
                            ?></td>

                            <td><?php 
                                if($adv->dr_cr_flag=='Cr'){
                                    echo $adv->amount;
                                    $cr_tot += $adv->amount;
                                } else { echo '0.00'; }
                            ?></td>
                        </tr>

                        <?php }}}} ?>
                    </tbody>

                    <?php 
                        $dr_tot = number_format((float)$dr_tot, 2, '.', '');
                        $cr_tot = number_format((float)$cr_tot, 2, '.', '');

                        $errorColor = ($dr_tot != $cr_tot) ? "total-error" : "";
                    ?>

                    <tfoot>
                        <tr class="<?=$errorColor?>">
                            <th>Total:</th>
                            <th></th>
                            <th><?=$dr_tot?></th>
                            <th><?=$cr_tot?></th>
                        </tr>
                    </tfoot>
                </table>
                </div>

                <div class="remarks"><b>Remarks: <?=$remarks?></b></div>

                <br>
                <hr style="border-top: 4px dashed #bbb">

            </div>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <button class="btn btn-primary" type="submit" id="submit">Save</button>

            <a href="<?php echo site_url("purchasevu"); ?>" 
                class="btn btn-danger" 
                style="margin-left:10px;">
                Back
            </a>
        </div>

        </form>
    </div>

</div>
