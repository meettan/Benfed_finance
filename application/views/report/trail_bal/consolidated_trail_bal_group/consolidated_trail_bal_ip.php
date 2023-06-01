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

</style>

<style>
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
</style>

    
    <div class="wraper">      

        <div class="col-md-6 container form-wraper">
    
            <form method="POST" id="form" action="<?php echo site_url("consolidated-trailbal-group");?>" >

                <div class="form-header">
                
                    <h4>Input Dates</h4>
                
                </div>

                <div class="form-group row">

                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"
                        />  

                    </div>


                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"
                        />  

                    </div>

                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">Group:</label>

                    <div class="col-sm-6">
						<select class="form-control"  name="group_id" id="group" required>
						   <option value="">Select group</option>
                           <option value="0">All group</option>
						   <?php foreach($group as $gr){?>
						   <option value="<?=$gr->sl_no?>"><?=$gr->name?></option>
						   <?php } ?>
						</select>

                    </div>

                </div> 	
                <input type="hidden" name="subgroupinputvalue" id="subgroupinputvalue" value="">
                
            
                
<!--                 
                <div class="form-check form-check-inline">
  <input class="form-check-input bracnhclass" type="checkbox" id="allbranch">
  <label class="form-check-label" for="allbranch">All</label>
</div><br> -->


				
                <!-- <div class="form-check form-check-inline" style="margin-right: 20px;">
                    <input class="form-check-input bracnhclass2" name="type[]" type="checkbox" id="inlineCheckbox" value="1" >
                    <label class="form-check-label" for="inlineCheckbox">Liabilites</label>
                </div>
                <div class="form-check form-check-inline" style="margin-right: 20px;">
                    <input class="form-check-input bracnhclass2" name="type[]" type="checkbox" id="inlineCheckbox" value="2" >
                    <label class="form-check-label" for="inlineCheckbox">Asset</label>
                </div>
                <div class="form-check form-check-inline" style="margin-right: 20px;">
                    <input class="form-check-input bracnhclass2" name="type[]" type="checkbox" id="inlineCheckbox" value="3" >
                    <label class="form-check-label" for="inlineCheckbox">Expense</label>
                </div>
                <div class="form-check form-check-inline" style="margin-right: 20px;">
                    <input class="form-check-input bracnhclass2" name="type[]" type="checkbox" id="inlineCheckbox" value="4" >
                    <label class="form-check-label" for="inlineCheckbox">Revenue</label>
                </div> -->

                


                <div class="form-group row">

                    <div class="col-sm-10">

                        <input type="submit" class="btn btn-info" value="Submit" />

                    </div>

                </div>

            </form>    

        </div>

    </div>


    <script>
        $('.bracnhclass').each(function () {
       var sThisVal = (this.checked ? $(this).val() : "");
  });




  $(".bracnhclass").click(function(){
    $('.bracnhclass2').not(this).prop('checked', this.checked);
});
    </script>


<script>
   
$('#group').change(function(){
        var group_name=$(this).find("option:selected").text();
        $('#subgroupinputvalue').val(group_name);
    });
</script>