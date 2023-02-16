<div class="wraper">
    <div class="col-md-10 container form-wraper">
        <form method="POST" action="<?php echo site_url("handling-trandport-charges/htc_raise_invoice");?> " onsubmit="return valid_data()">
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
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer:</label>

                <div class="col-sm-4">
                <input type="text" value="" class="form-control" id="customer" name="customer" required />
                
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
                <label for="trans_dt" class="col-sm-2 col-form-label" >GST Rate:  <span id="cgstp"></span> % </label>
                <div class="col-sm-4">
                    <input type="text" name="gst" id="gst" class="form-control" >
                </div>
            </div>
          
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label" >CGST:   </label>
                <div class="col-sm-4">
                    <input type="text" name="cgst" id="cgst" class="form-control cgst" readonly>
                    <input type="hidden" name="cgst_rt" id="cgst_rt" class="form-control cgst_rt">
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">SGST: </label>
                <div class="col-sm-4">
                    <input type="text" name="sgst" id="sgst" class="form-control sgst" readonly>
                    <input type="hidden" name="sgst_rt" id="sgst_rt" class="form-control sgst_rt">
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
                    <input type="submit" id="submit" class="btn btn-info submit" value="Save" />
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