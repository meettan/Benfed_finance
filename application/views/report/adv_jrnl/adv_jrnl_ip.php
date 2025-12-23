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

<div class="container-fluid mt-3">

    <div class="col-md-6 container form-wraper">

        <form method="POST" id="form" action="<?php echo site_url("advjrnlr");?>">

            <!-- FORM HEADER -->
            <div class="form-header">
                <h2>Input Parameters</h2>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">From Date:</label>
                <div class="col-sm-6">
                    <input type="date"
                           name="from_date"
                           class="form-control required"
                           value="<?php echo date('Y-m-d');?>"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">To Date:</label>
                <div class="col-sm-6">
                    <input type="date"
                           name="to_date"
                           class="form-control required"
                           value="<?php echo date('Y-m-d');?>"/>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">District:</label>
                <div class="col-sm-6">
                    <select class="form-control"
                            name="branch_id"
                            required
                            <?php if($this->session->userdata['loggedin']['branch_id']!=342){echo 'disabled';}?>>
                        <option value="">Select</option>
                        <?php foreach($branch as $br){ ?>
                            <option value="<?=$br->id?>"
                                <?php if($this->session->userdata['loggedin']['branch_id']==$br->id){echo 'selected';}?>>
                                <?=$br->branch_name?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <a href="<?php echo site_url("dashboard"); ?>"
                       class="btnSame btn-danger"
                       style="width:100px;">⬅ Back</a>

                    <input type="submit"
                           class="btnSame btn-primary"
                           value="Submit"/>
                </div>
            </div>

        </form>

    </div>

</div>
