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
    background: linear-gradient(to right, #1a5fae, #3c7ed6);
    color: white;
    padding: 4px;
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

.form-header {
    background: linear-gradient(to right, #1a5fae, #3c7ed6);
    padding: 12px 18px;
    border-radius: 6px;
    color: #fff;
}
.form-header h4 {
    margin: 0;
    font-weight: 600;
    letter-spacing: 0.5px;
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

<style>
    td,
    th {
        padding: 5px;
    }
</style>
<div class="wraper">
    <div class="col-md-10 container form-wraper">
        <form method="POST" action="<?php echo site_url("transaction/service_charge_invoice");?> " onsubmit="return valid_data()">
            <div class="form-header">
                <h4>Service Invoice</h4>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Invoice Date:</label>
                <div class="col-sm-4">
                    <input type="date" value="<?php echo date('Y-m-d');?>" class="form-control" id="gr_name"
                        name="effectiveDate" readonly required />
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Product: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="product_desc" name="product_desc" required />
                </div>

            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="customer" name="customer" required />
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">Supplier's Ref. :</label>
                <div class="col-sm-4">
                    <input type="text" name="supplier_Ref" id="supplier_Ref" class="form-control">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">GST No: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="gst_no" name="gst_no" required />
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">PAN : <span style="color: red;"> *</span></label>
                <div class="col-sm-4">
                    <input type="text" name="pan" id="pan" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Address: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="cust_addr" name="cust_addr" required />
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">PIN. : <span style="color: red;"> *</span></label>
                <div class="col-sm-4">
                    <input type="text" name="pin" id="pin" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">District Name: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="district" name="district" required />
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">SAC Code. : <span style="color: red;"> *</span></label>
                <div class="col-sm-4">
                    <input type="text" name="sac_code" id="sac_code" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Contact no: <span style="color: red;"> *</span></label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="phone_num" name="phone_num" required />
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">Email. :</label>
                <div class="col-sm-4">
                    <input type="text" name="email" id="email" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Amount: <span style="color: red;"> *</span></label>
                <div class="col-sm-4">
                    <input type="text" name="amount" id="amount" class="form-control">
                </div>
                <label for="trans_dt" class="col-sm-2 col-form-label" >GST Rate:  <span id="cgstp" style="color: red;">  %  </span></label>
                <div class="col-sm-4">
                    <input type="text" name="gst" id="gst" class="form-control" >
                </div>
            </div>
          
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label" >CGST:   </label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" id="cgst" class="form-control cgst" readonly>
                    <!-- <input type="hidden" name="cgst_rt" id="cgst_rt" class="form-control cgst_rt"> -->
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST: </label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" id="sgst" class="form-control sgst" readonly>
                    <!-- <input type="hidden" name="sgst_rt" id="sgst_rt" class="form-control sgst_rt"> -->
                </div>
            </div>
            <div class="form-group row">
            
                <label for="totalAmount" class="col-sm-2 col-form-label">Total Amount:</label>
                <div class="col-sm-4">
                    <input type="decimal" name="totalAmount" id="totalAmount" class="form-control totalAmount" readonly>
                </div>
                </div>
            <div class="form-group row">
                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
                
                <div class="col-sm-10">
                          <textarea id="remarks" name="remarks" class="form-control" maxlength="100" onkeyup="countChar(this)"></textarea>
                       
                        </div>
                        <label for="remarks" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                        <div class="align-right"><span  id="charNum">0</span>/100</div>
                        </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                <a href="<?php echo site_url("service_charge_list"); ?>" 
                  class="btnSame btn-danger" 
                  style="width: 100px; margin-left:10px;">⬅ Back
                  </a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" id="submit" class="btnSame btn-primary" value="Save" />
                    <!-- <a href="<?php echo site_url("dashboard"); ?>" 
                        class="btn btn-danger" 
                        style="width: 100px; margin-left:10px;">Back
                        </a> -->
                </div>
            </div>
        </form>
    </div>
</div>
<?php  //print_r($this->session->userdata); ?>
<script>
    $(document).ready(function() {
        $('#gst').change(function(){
        var taxable = $('#amount').val();
        var gst_rt = $(this).val();
       console.log(taxable,gst_rt);
        var gst=((taxable/100)*gst_rt);
       
        $('#cgst').val((gst/2).toFixed(2));
        $('#sgst').val((gst/2).toFixed(2));
         var totalamt=parseFloat(taxable) + parseFloat(gst);
        $('#totalAmount').val(totalamt.toFixed(2));
    })

    $('#remarks').keypress(function(e) {
    var tval = $(this).val(),
        tlength = tval.length,
        set = 100,
        remain = parseInt(set - tlength);
    $('p').text(remain);
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('textarea').val((tval).substring(0, tlength - 1));
        return false;
    }
})

});

</script>