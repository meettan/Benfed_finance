<div class="wraper">

    <div class="col-md-6 container form-wraper">

        <form method="POST" id="product" action="<?php echo site_url("transaction/month_end") ?>">

            <div class="form-header">

                <h4>Month End Operation</h4>

            </div>


            <div class="form-group row">
                <label for="dist" class="col-sm-2 col-form-label">District:</label>
                <div class="col-sm-4">

                    <select name="dist" class="form-control required" id="dist" style="width: 500px;" required>

                        <option value="">Select District</option>

                        <?php

                            foreach($distDtls as $dist){

                        ?>

                        <option value="<?php echo $dist->district_code;?>"><?php echo $dist->district_name;?></option>

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

                            foreach($monthdtls as $mnth){

                        ?>

                        <option value="<?php echo $mnth->id;?>"><?php echo $mnth->month_name;?></option>

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

                <input type="submit" id="submit" class="btn btn-info" value="Save" />

            </div>

    </div>

    </form>

</div>

</div>

<!-- <script>

$(document).ready(function(){

	var i = 2;

	$('#dist').change(function(){

		$.get( 

			'<?php echo site_url("transaction/f_get_onholdv");?>',
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
    $(document).ready(function () {

        var i = 2;

        $('#dist').change(function () {

            $.get(

                    '<?php echo site_url("transaction/f_get_lstmnth");?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function (data) {
                    var parseData = JSON.parse(data);
                    var mnth = parseData.end_mnth;
                    var yr = parseData.end_yr;
                    var mnth_nm = '';

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
        $('#dist').change(function () {

            $.get(

                    '<?php echo site_url("transaction/f_get_onholdv");?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function (data) {


                    $('#onholdv').val(data);

                    if (data > 0) {
                        alert("Some vouchers are on hold.Please contact branch!");
                        $('#submit').attr('type', 'buttom');
                        return false;
                    } else {
                        $('#submit').attr('type', 'submit');
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
                '<?php echo site_url("transaction/checked_MonthEnd");?>', {
                    year: year
                }
            )
            .done(function (data) {
                alert(data);
                if (data==1) {
                    $('#submit').attr('type', 'submit');
                } else {
                    $('#submit').attr('type', 'buttom');
                        return false;
                }
            });

    }
</script>