
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
    <div class="col-md-8 container-fluid form-wraper">
        <?php //print_r($godownrentData); ?>
        <form method="POST" action="<?php echo site_url("handling-trandport-charges/htc_edit/".$godownrentData->sl_no);?> " onsubmit="return valid_data()">
            <div class="form-header">
                <h2>Godown Rent Handling & transport charges </h2>
            </div>
            <div class="form-group row">
                <label for="ac_type" class="col-sm-2 col-form-label">Effective Date:</label>
                <div class="col-sm-4">
                    <input type="date" value="<?php echo $godownrentData->effective_date;?>" class="form-control" id="gr_name" name="effectiveDate" readonly required />
                </div>
            </div>
            <div class="form-group row">
                
                <label for="voucher_mode" class="col-sm-2 col-form-label">Customer:</label>
                <div class="col-sm-4">
                <select class="form-control" id="ac_type" name="customer" required>
                        <option value=''>Select</option>
                        <?php foreach ($customer as $cm) { ?>
                        <option value="<?php echo $cm->id; ?>" <?php if($godownrentData->customer_id == $cm->id){echo "selected";}?>><?php echo $cm->cust_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">From  Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="startDate" value="<?php echo $godownrentData->htc_start_date; ?>" id="startDate" class="form-control startDate" required>
                </div>
                <label for="voucher_mode" class="col-sm-2 col-form-label">To Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="endDate" id="endDate" value="<?php echo $godownrentData->htc_end_date; ?>" class="form-control endDate" required>
                </div>
            </div>
            

            <div class="form-group row">
                <label for="trans_dt" class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-4">
                    <input type="text" name="amount" id="amount" value="<?php echo $godownrentData->htc_amt; ?>" class="form-control smallinput_text amount">
                </div>
            </div>
            
            <div class="form-group row">
            <!-- <div> -->
            <div class="col-sm-10">
                <a href="<?php echo site_url("htc_list"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
             <!-- </div> -->
               
                    <input type="submit" id="submit" class="btnSame btn-primary submit" value="Save" />
                </div>
               
            </div>
        </form>
    </div>
</div>

<script>
    $('form').on('#submit', function() {
        
        var amount=$('#amount').val();
     if(amount>0){
        return true;
     }else{
        return false;
     }
});



$('#submit').click(function() {
    var am = $('#amount').val();
        
          if(am > 0){ 
            return true;
          }else{
            alert('invalid amount'); 
            return false;
          } 
            
});

$('#submit').click(function() {
    var sd = $('#startDate').val();
    var ed = $('#endDate').val();
        
          if(sd < ed){
            return true;
          }else{
            alert('end date should be greater than start date'); 
            return false;
          } 
            
});
</script>