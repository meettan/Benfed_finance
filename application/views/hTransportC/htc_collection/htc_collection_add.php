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
        <form method="POST" action="<?php echo site_url("handling-trandport-charges/htc_raise_invoice");?> " onsubmit="return valid_data()">
            <div class="form-header">
                <h4>Raise Invoice</h4>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Invoice Date:</label>
                <div class="col-sm-4">
                    <input type="date" value="<?php echo date('Y-m-d');?>" class="form-control" id="gr_name"
                        name="effectiveDate" readonly required />
                </div>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Product:</label>
                <div class="col-sm-4">
                <?php //print_r($rent_product); ?>
                        <select class="form-control" id="product" name="product" required>
                        <option value=''>Select</option>
                        <?php foreach ($rent_product as $rp) { ?>
                        <option value="<?php echo $rp->sl_no; ?>"><?php echo $rp->product_desc; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer:</label>

                <div class="col-sm-4">
                    <select class="form-control" id="ac_type" name="customer" required>
                        <option value=''>Select</option>
                        <?php foreach ($customer as $cm) { ?>
                        <option value="<?php echo $cm->id; ?>"><?php echo $cm->cust_name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <label for="supplier_Ref" class="col-sm-2 col-form-label">Supplier's Ref. :</label>
                <div class="col-sm-4">
                    <input type="text" name="supplier_Ref" id="supplier_Ref" class="form-control">
                </div>

                
            </div>


            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="amount" id="amount" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label" >CGST:  <span id="cgstp"></span> % </label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" id="cgst" class="form-control cgst" readonly>
                    <input type="hidden" name="cgst_rt" id="cgst_rt" class="form-control cgst_rt">
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST: <span id="sgstp"></span> %</label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" id="sgst" class="form-control sgst" readonly>
                    <input type="hidden" name="sgst_rt" id="sgst_rt" class="form-control sgst_rt">
                </div>
            </div>
            <div class="form-group row">
                <label for="totalAmount" class="col-sm-2 col-form-label">Total Amount:</label>
                <div class="col-sm-4">
                    <input type="text" name="totalAmount" id="totalAmount" class="form-control totalAmount" readonly>
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
                <a href="<?php echo site_url("htc_raise_invoice_list"); ?>" 
                  class="btnSame btn-danger" 
                  style="width: 100px; margin-left:10px;">⬅ Back
                  </a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" id="submit" class="btnSame btn-primary" value="Save" />
                </div>
            </div>
        </form>
    </div>
</div>
<?php  //print_r($this->session->userdata); ?>
<script>
    $(document).ready(function() {
    $('#bank_section').hide();
    $('#rf').hide();
    $('#mode').change(function(){
        let mode=$(this).val();
        if(mode=='B'){
        $('#bank_section').show();
        $('#rf').show();
        }else{
            $('#bank_section').hide(); 
            $('#rf').hide();
        }
    });


    function totalvalue(){
        var customer=$('#ac_type').val();

        var cgst_rt=$('#cgst_rt').val();
        var sgst_rt =$('#sgst_rt').val();
       
        $.ajax({
            url: "<?php echo site_url().'/HTransportC/fetchhtc'; ?>",
            type: 'POST',
            data: {customer:customer},
            dataType: "json",
            success: function(data) {
                $('#amount').val(data.htc_amt);

                var amount=data.htc_amt;
                var cgst=((amount/100)*cgst_rt);
                var sgst=((amount/100)*sgst_rt);
                $('#cgst').val(cgst);
                $('#sgst').val(sgst);
                var totalamt=(parseFloat(cgst) + parseFloat(sgst) + parseFloat(amount));
                
                // $('#totalAmount').val(totalamt);
            }
        });
    }

    $('#product').change(function(){

        var product_id=$(this).val();
        $.ajax({
            url: "<?php echo site_url().'/HTransportC/productData'; ?>",
            type: 'POST',
            data: {product_id:product_id},
            dataType: "json",
            success: function(data) {
                $('#cgstp').html(data.cgst_rt);
                $('#sgstp').html(data.sgst_rt);
                $('#cgst_rt').val(data.htm_cgst_rt);
                $('#sgst_rt').val(data.htm_sgst_rt);

                 // var cgst_rt=$('#cgst_rt').val();
                // var sgst_rt =$('#sgst_rt').val();
                var amount=$("#amount").val();
                var cgst=((amount/100)*data.htm_cgst_rt);
                var sgst=((amount/100)*data.htm_sgst_rt);
                $('#cgst').val(cgst.toFixed(2));
                $('#sgst').val(sgst.toFixed(2));
                var totalamt=(parseFloat(cgst) + parseFloat(cgst) + parseFloat(amount));
                $('#totalAmount').val(totalamt.toFixed(2));
               
            }
        });
        totalvalue();

    });
    $('#product').change(function(){
        $('#godown').removeAttr('disabled');
        var product_id=$(this).val();
        $.ajax({
            url: "<?php echo site_url().'/rent_collection/fetch_product'; ?>",
            type: 'POST',
            data: {product_id:product_id},
            dataType: "json",
            success: function(data) {
                $('#cgstp').html(data.cgst_rt);
                $('#sgstp').html(data.sgst_rt);
                $('#cgst_rt').val(data.htm_cgst_rt);
                $('#sgst_rt').val(data.htm_sgst_rt);
                var amount=$("#amount").val();
                var cgst=((amount/100)*data.htm_cgst_rt);
                var sgst=((amount/100)*data.htm_sgst_rt);
                $('#cgst').val(cgst.toFixed(2));
                $('#sgst').val(sgst.toFixed(2));
                var totalamt=(parseFloat(data.htm_cgst_rt) + parseFloat(data.htm_cgst_rt) + parseFloat(amount));
                $('#totalAmount').val(totalamt.toFixed(2));

            }
        });

    });

        $('#ac_type').change(function(){
        var customer=$(this).val();
        var product=$('#product').val();

        var cgst_rt=$('#cgst_rt').val();
        var sgst_rt =$('#sgst_rt').val();
       
        $.ajax({
            url: "<?php echo site_url().'/HTransportC/fetchhtc'; ?>",
            type: 'POST',
            data: {customer:customer},
            dataType: "json",
            success: function(data) {
                // $('#amount').val(data.htc_amt);
                var amount=data.htc_amt;
                var cgst=((amount/100)*cgst_rt);
                var sgst=((amount/100)*sgst_rt);
                // $('#cgst').val(cgst);
                // $('#sgst').val(sgst);
                var totalamt=(parseFloat(cgst) + parseFloat(sgst) + parseFloat(amount));
                
                // $('#totalAmount').val(totalamt);
            }
        });
    });

    $('#amount').keyup(function(){
        var cgst_rt=$('#cgst_rt').val();
        var sgst_rt =$('#sgst_rt').val();
        var amount=$(this).val();
        //alert(amount);
        var cgst=((amount/100)*cgst_rt);
        var sgst=((amount/100)*sgst_rt);
        cgst=cgst.toFixed(2);
        sgst =sgst.toFixed(2);

        $('#cgst').val(cgst);
        $('#sgst').val(sgst);
        //alert(cgst);
        var totalamt=parseFloat(cgst) + parseFloat(sgst) + parseFloat(amount);
        //totalamt=totalamt + amount;
        
     var totalamt= parseFloat(totalamt);
      //alert(totalamt);
       // $('#totalAmount').val(totalamt);
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


function countChar(val) {
  var len = val.value.length;
  if (len >= 100) {
    val.value = val.value.substring(0, 100);
  } else {
    $('#charNum').text(0 + len);
  }
}


</script>