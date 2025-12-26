<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;

    padding: 6px;

    font-size: 14px;
}

th {

    text-align: center;

}

tr:hover {background-color: #f5f5f5;}
    .form-check {
  display: inline-block;
}

.panel-heading a:after {
    font-family: 'Glyphicons Halflings';
    content: "\e114";    
    float: right; 
    color: grey; 
}
.panel-heading a.collapsed:after {
    content: "\e080";
}
/* ===== BLUE GRADIENT FORM HEADER ===== */
.form-header {
    background: linear-gradient(to right, #003e7c, #0056b3, #1e88e5);
    padding: 5px 10px; /* compact */

    /* Control margins */
    margin-top: -10px;
    margin-bottom: 20px;
    margin-left: -15px;
    margin-right: -15px;

    border-radius: 0px;
}

h2 {
        color: #1565c0; /* dark blue */
        font-weight: 700;
        margin-bottom: 20px;
        
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
</style>
<div class="wraper">      

        <div class="col-md-6 container form-wraper">
    
            <form method="POST" id="form" action="<?php echo site_url("balsh");?>" >

                <div class="form-header">
                    <h4>Input Dates</h4>
                
                </div>

                <div class="form-group row">
                <?php $fyear=$this->session->userdata['loggedin']['fin_yr']; $year=explode('-',$fyear) ?>
                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">
                        <input type="date"
                               name="from_date"
                               class="form-control required" min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"
                               value="<?=$year[0]?>-04-01"/>  
                    </div>
                </div>

                <div class="form-group row">
                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>
                    <div class="col-sm-6">
                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?=$year[0]+1?>-03-31" min='<?=$year[0]?>-04-01' max="<?= $year[0]+1?>-03-31"/>  
                    </div>
                </div>
               
                <div class="form-group row">
                    <div class="col-sm-10">
                    <a href="<?php echo site_url("dashboard"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
                        <input type="submit" class="btnSame btn-primary" value="Submit" />

                    </div>
                </div>
            </form>    
        </div>
    </div>