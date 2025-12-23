<style>
body {
    background: linear-gradient(135deg, #cfd8dc, #fce4ec);
    font-family: "Segoe UI", Tahoma, sans-serif;
}

.contant-wraper,
.form-wraper {
    background: #ffffff;
    padding: 0px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-top: 0px;
}

/* ===== BLUE GRADIENT FORM HEADER ===== */
.form-header {
    background: linear-gradient(to right, #003e7c, #0056b3, #1e88e5);
    padding: 5px 10px; /* compact */
    border-radius: 0px;
    margin-bottom: 20px;
    margin:-10px -5px 20px -5px;
}

/* REMOVE ALL SPACE FROM H2 */
.form-header h2 {
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.2;
    color: #fff;
    font-weight: 500;
    font-size: 26px;
}
/* Slight right shift for form labels only */
.form-wraper label.col-form-label {
    padding-right: 10px;   /* adjust: 5–10px as needed */
}


/* Labels & Inputs */
label {
    font-weight: bold;
    color: #37474f;
}

input[type="date"],
select {
    border-radius: 6px;
    border: 1px solid #1565c0;
}

/* Buttons */
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

/* Layout fixes */
.container-fluid {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

/* .row:first-child {
    margin-top: 0 !important;
} */
/* DO NOT TOUCH BOOTSTRAP ROW */
.row {
    margin-left: -15px;
    margin-right: -15px;
}

/* Form-only alignment */
.form-wraper {
    padding:5px;
}

@media (min-width: 992px) {
    .form-wraper.col-md-6 {
        flex: 0 0 42% !important;
        max-width: 42% !important;
    }
}

/* } */


body {
    margin-top: 0 !important;
}
</style>

<div class="wraper">
    <div class="col-md-6 container form-wraper">

        <form method="POST" id="form" action="<?php echo site_url("report/ac_detail"); ?>">
            <div class="form-header">
                <h4>Account detail Inputs</h4>
            </div>

            <!-- <div class="form-group row">

                <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>
                <div class="col-sm-6">
                    <input type="date" name="from_date" id="from_date" class="form-control required" value="<?php echo date('Y-m-d'); ?>" min='<?php echo explode('-',$this->session->userdata('loggedin')['fin_yr'])[0] ?>-04-01' max='<?php echo (explode('-',$this->session->userdata('loggedin')['fin_yr'])[0])+1 ?>-03-31'/>
                </div>
            </div>

            <div class="form-group row">

                <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                <div class="col-sm-6">
                    <input type="date" name="to_date" class="form-control required" value="<?php echo date('Y-m-d'); ?>" min='<?php echo explode('-',$this->session->userdata('loggedin')['fin_yr'])[0] ?>-04-01' max='<?php echo (explode('-',$this->session->userdata('loggedin')['fin_yr'])[0])+1 ?>-03-31'/>
                </div>
            </div> -->
            <div class="form-group row">
                <?php $fyear=$this->session->userdata['loggedin']['fin_yr']; $year=explode('-',$fyear) ?>
                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"
                               value="<?=$year[0]?>-04-01" />

                    </div>


                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?=$year[0]+1?>-03-31" min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"
                        />  

                    </div>

                </div>

            <div class="form-group row">
                <label for="to_date" class="col-sm-2 col-form-label">Acount Head:</label>
                <div class="col-sm-6">
                    <select class="form-control sch_cd select2" name="acc_head" required>
                        <option value="">Select</option>
                        <?php foreach ($acc_head as $key) { ?>
                            <option value="<?php if (isset($key->sl_no)) {
                                                echo $key->sl_no;
                                            } ?>"><?php if (isset($key->ac_name)) {
                                                                                                    echo $key->ac_name . ' ' . $key->benfed_ac_code;
                                                                                                } ?></option>
                        <?php } ?>
                    </select>
                </div>
                
            </div>

            <div class="form-group row">
            <?php if($this->session->userdata('loggedin')['branch_id']==342){ ?>
                <!-- <label for="allaccounthead" class="col-sm-2 col-form-label">All Branches:</label>
                <div class="col-sm-2">

                    <input type="checkbox" name="allaccounthead" class="" value="false" id="allaccounthead" />

                </div> -->
                <label for="" class="col-sm-2 col-form-label"> Branches:</label>
                <div class="col-sm-6">
                       <select class="form-control" name="branch_id" reqired>
                       <option value="">Select Branch</option>
                        <option value="0">All Branch</option>
                        <?php foreach($branch as $br) { ?>
                            <option value="<?=$br->id?>"><?=$br->branch_name?></option>
                            <?php } ?>

                       </select>
                </div>       
                <?php } ?>
            </div>



            <div class="form-group row">
                <div class="col-sm-10">
                <a href="<?php echo site_url("dashboard"); ?>"
                       class="btnSame btn-danger"
                       style="width:100px;">⬅ Back</a>
                    <input type="submit" class="btnSame btn-primary" value="Submit" onclick="" />
                    
                </div>

            </div>

        </form>


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
        searching: false,
        ordering: false,
        paging: false,

        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            title: 'Account details report',
            text: 'Export to excel'
            //Columns to export
            // exportOptions: {
            //    columns: [0, 1, 2, 3]
            // }
        }]
    });
</script>

<!-- <script>
    $("#allaccounthead").on('change', function() {
        if ($(this).is(':checked')) {
            $(this).attr('value', 'true');
        } else {
            $(this).attr('value', 'false');
        }
        //alert($(this).val());
    });
</script> -->

<script>
    // function myFunction() {
    //     var frmdt = $('#from_date').val();
    //     frmdt = frmdt.substring(0, 4);
    //     // alert(frmdt);
    //     var fin_year_sort_code = <?php //echo substr($this->session->userdata['loggedin']['fin_yr'], 0, 4) ?>;

    //     if (frmdt != fin_year_sort_code) {
    //         alert('Financial Year Not Matched');
    //         $('#submit').attr('type', 'buttom');
    //         event.preventDefault();
    //     } else {
    //         $('#submit').attr('type', 'submit');
    //     }
    // }
</script>