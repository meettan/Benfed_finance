<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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

	.form-header {
    background: linear-gradient(135deg, #004e92, #0a85d9, #4fc3f7);
    padding: 13px 20px;
    border-radius: 0;   /* RECTANGLE SHAPE */
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}


.form-header h2 {
    margin: 0;
    color: #ffffff;
    font-size: 20px;
    font-weight: 500;
	text-shadow: 0 1px 3px rgba(0,0,0,0.3);
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
<div class="wraper">

    <div class="col-md-6 container form-wraper">

        <form method="POST" id="product" action="<?php echo site_url("transaction/month_end") ?>">

            <div class="form-header">

                <h2>Month End Operation</h2>

            </div>


            <div class="form-group row">
                <label for="dist" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">

                    <select name="dist" class="form-control required" id="dist" style="width: 500px;" required>

                        <option value="">Select District</option>

                        <?php

                        foreach ($distDtls as $dist) {

                        ?>

                            <option value="<?php echo $dist->district_code; ?>"><?php echo $dist->district_name; ?></option>

                        <?php

                        }

                        ?>

                    </select>

                </div>

            </div>

            <div class="form-group row">
                <div></div>
            </div>

            <div class="form-group row">

                <label for="yr" class="col-sm-2 col-form-label">Year:</label>
                <div class="col-sm-4">


                    <input type="hidden" id=yr_sl name="yr_sl" class="form-control required" readonly />

                    <input type="text" id=yr_nm name="yr_nm" class="form-control required" readonly />

                </div>
                <label for="mnth" class="col-sm-2 col-form-label">Month:</label>
                <div class="col-sm-4">
                    <input type="hidden" id=mnth_id name="mnth_id" class="form-control required" readonly />
                    <input type="text" id=mnth_nm name="mnth_nm" class="form-control required" readonly />
                    <!-- <select name="mnth" class="form-control required" id="bank" required>

						<option value="">Select Month</option>

                        <?php

                        foreach ($monthdtls as $mnth) {

                        ?>

                        <option value="<?php echo $mnth->id; ?>"><?php echo $mnth->month_name; ?></option>

                        <?php

                        }

                        ?>     

                    </select> -->

                </div>

            </div>

            <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">No Of Onhold Voucher:</label>
                <div class="col-sm-10">
                    <input type="text" id=onholdv name="onholdv" class="form-control required" readonly />

                </div>
            </div>

            <div class="form-group row">
                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
                <div class="col-sm-10">

                    <textarea id=remarks name="remarks" class="form-control"></textarea>
                </div>
            </div>

            <div class="col-sm-10">
            <a href="<?php echo site_url("dashboard"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
                <input type="submit" id="submit" class="btnSame btn-primary" value="Save" disabled=""/>
                
            </div>
            </form>

    </div>

    


    <!-- ==================================================== -->

    <div class="col-md-5 container form-wraper" style="margin-left: 10px;">

        <form method="POST" id="product" action="<?php echo site_url("transaction/month_end") ?>">

            <div class="form-header">

                <h2> Month Ended Upto :</h2>

            </div>


            <div class="form-group row">
                <div></div>
            </div>

            <div class="form-group row">

                <label for="yr" class="col-sm-2 col-form-label">Year:</label>
                <div class="col-sm-4">

                    <input type="text" id="current_yr_nm" name="current_yr_nm" class="form-control required" readonly />

                </div>
                <label for="mnth" class="col-sm-2 col-form-label">Month:</label>
                <div class="col-sm-4">
                    <input type="text" id="current_mnth_nm" name="current_mnth_nm" class="form-control required" readonly />
                </div>

            </div>

            <!-- <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">No Of Onhold Voucher:</label>
                <div class="col-sm-10">
                    <input type="text" id="current_onholdv" name="current_onholdv" class="form-control required" readonly />

                </div>
            </div> -->

            <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">Closed By:</label>
                <div class="col-sm-10">
                    <input type="text" id="closedBy" name="closedBy" class="form-control required" readonly />

                </div>
            </div>

            <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">Closed Date:</label>
                <div class="col-sm-10">
                    <input type="text" id="closeddate" name="closeddate" class="form-control required" readonly />

                </div>
            </div>

    </div>

</div>

<!-- <script>

$(document).ready(function(){

	var i = 2;

	$('#dist').change(function(){

		$.get( 

			'<?php echo site_url("transaction/f_get_onholdv"); ?>',
			{ 

				
				dist_cd: $(this).val()
				
				
			}

		)
		.done(function(data){
				

			$('#onholdv').val(data);
            
            if(data>0)
            {
            alert("Ther are Onhold data! Kindly ask to Branch");
            $('#submit').attr('type', 'buttom');
            return false;
            }else{
               $('#submit').attr('type', 'submit');
            }
		});
        

	});

});
</script> -->


<script>
    $(document).ready(function() {

        var i = 2;

        $('#dist').change(function() {

            $.get(

                    '<?php echo site_url("transaction/f_get_lstmnth"); ?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function(data) {
                    var parseData = JSON.parse(data);
                    var mnth = parseData.end_mnth;
                    var yr = parseData.end_yr;
                    var mnth_nm = '';


                    var date_month= parseData.end_mnth;
                    var date_month_nm="";


                    if (parseFloat(date_month) == 1) {
                        date_month_nm = 'JAN';
                    } else if (parseFloat(date_month) == 2) {
                        date_month_nm = 'FEB';
                    } else if (parseFloat(date_month) == 3) {
                        date_month_nm = 'MAR';
                    } else if (parseFloat(date_month) == 4) {
                        date_month_nm = 'APR';
                    } else if (parseFloat(date_month) == 5) {
                        date_month_nm = 'MAY';
                    } else if (parseFloat(date_month) == 6) {
                        date_month_nm = 'JUN';
                    } else if (parseFloat(date_month) == 7) {
                        date_month_nm = 'JUL';
                    } else if (parseFloat(date_month) == 8) {
                        date_month_nm = 'AUG';
                    } else if (parseFloat(date_month) == 9) {
                        date_month_nm = 'SEP';
                    } else if (parseFloat(date_month) == 10) {
                        date_month_nm = 'OCT';
                    } else if (parseFloat(date_month) == 11) {
                        date_month_nm = 'NOV';
                    } else if (parseFloat(date_month) == 12) {
                        date_month_nm = 'DEC';
                    }



                    $('#current_mnth_nm').val(date_month_nm);
                    $('#current_yr_nm').val(parseData.end_yr);
                    $('#closedBy').val(parseData.closed_by);
                    $('#closeddate').val(parseData.closed_dt);

                    // alert(mnth);
                    if (parseFloat(mnth) == 12) {
                        // alert(yr);
                        mnth = 1;
                        yr = parseFloat(yr) + 1;
                    } else {
                        mnth = parseFloat(mnth) + 1;
                    }

                    if (parseFloat(mnth) == 1) {
                        mnth_nm = 'JAN';
                    } else if (parseFloat(mnth) == 2) {
                        mnth_nm = 'FEB';
                    } else if (parseFloat(mnth) == 3) {
                        mnth_nm = 'MAR';
                    } else if (parseFloat(mnth) == 4) {
                        mnth_nm = 'APR';
                    } else if (parseFloat(mnth) == 5) {
                        mnth_nm = 'MAY';
                    } else if (parseFloat(mnth) == 6) {
                        mnth_nm = 'JUN';
                    } else if (parseFloat(mnth) == 7) {
                        mnth_nm = 'JUL';
                    } else if (parseFloat(mnth) == 8) {
                        mnth_nm = 'AUG';
                    } else if (parseFloat(mnth) == 9) {
                        mnth_nm = 'SEP';
                    } else if (parseFloat(mnth) == 10) {
                        mnth_nm = 'OCT';
                    } else if (parseFloat(mnth) == 11) {
                        mnth_nm = 'NOV';
                    } else if (parseFloat(mnth) == 12) {
                        mnth_nm = 'DEC';
                    }

                    $('#yr_nm').val(yr);
                    $('#yr_sl').val(yr);
                    $('#mnth_nm').val(mnth_nm);
                    $('#mnth_id').val(mnth);
                    mtVal();


                });


        });
        $('#dist').change(function() {

            $.get(

                    '<?php echo site_url("transaction/f_get_onholdv"); ?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function(data) {


                    $('#onholdv').val(data);

                    if (data > 0) {
                        alert("Some vouchers are on hold.Please contact branch!");
                        // $('#submit').attr('type', 'buttom');

                        $("#submit").attr("disabled", true);
                        return false;
                    } else {
                        // $('#submit').attr('type', 'submit');
                        $("#submit").attr("disabled", false);
                    }
                });


        });


    });




    // $("#mnth_id").change(function(){
    //     alert($(this).val());
    // });
    function mtVal() {
        var year = $("#mnth_id").val();

        $.get(
                '<?php echo site_url("transaction/checked_MonthEnd"); ?>', {
                    year: year
                }
            )
            .done(function(data) {
               //  alert(data);
                if (data == 1) {
                    $('#submit').attr('type', 'submit');
                } else {
                    $('#submit').attr('type', 'buttom');
                    return false;
                }
            });

    }
</script>