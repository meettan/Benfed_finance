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
         <!-- <div class="col-md-3 container"></div> -->
        <div class="col-md-6 container form-wraper">

            <form method="POST" id="form" action="<?php echo site_url("master/group_edit");?>" >
                     <input type="hidden" name="sl_no" class="form-control"  
                            value = "<?php echo $schdtls->sl_no; ?>" 
                        />
                <div class="form-header">
                
                    <h2>Edit Group</h2>
                
                </div>

                <div class="form-group row">
                  <label for="ac_type" id="ac_type" class="col-sm-3 col-form-label">Type:</label>

                    <div class="col-sm-9">

                        <select class="form-control required" id="ac_type" name="ac_type" required>

                            <option value="1" <?php echo ($schdtls->type == '1')? 'selected' : '';?>>Liabilities</option>

                            <option value="2" <?php echo ($schdtls->type == '2')? 'selected' : '';?>>Asset</option>

                            <option value="3" <?php echo ($schdtls->type == '3')? 'selected' : '';?>>Revenue</option>
                            <option value="4" <?php echo ($schdtls->type == '4')? 'selected' : '';?>>Expense</option>
                            
                        </select>

                    </div>
                
            </div>

              
            

                <div class="form-group row">

                    <label for="name" class="col-sm-3 col-form-label">Name:</label>

                    <div class="col-sm-9">
                        <!-- <textarea name="cate_desc" class="form-control" required=""><?php echo $schdtls->cate_desc; ?></textarea> -->
                        <input type="text" name="gr_name" class="form-control required"  
                            value = "<?php echo $schdtls->name; ?>" 
                        />
		            </div>

		        </div>
                <div class="form-group row">

                    <label for="benfed_srl" class="col-sm-3 col-form-label">Benfed Serial No.:</label>

                    <div class="col-sm-9">
                        <input type="text" name="benfed_srl" class="form-control required"  
                            value = "<?php echo $schdtls->benfed_srl; ?>" 
                        />
		            </div>

		        </div>


                <div class="form-group row">

                    <div class="col-sm-10">
                    <a href="<?php echo site_url("group"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
                        <input type="submit" class="btnSame btn-primary" value="Save" />
                    
                    </div>

                </div>
 
            </form>

        </div>

    <!-- </div> -->