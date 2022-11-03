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

    <div class="col-md-9 container form-wraper">
    <?php foreach($notification as $keyy) { ?>

        <form method="POST" action="<?= site_url('notification/edit/').$keyy->sl_no ?>">
       

            <div class="form-header">
                <h4>Send Notification</h4>
            </div>

            

            <div class="form-group row">
                <label for="cheq_no" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" name="title" class="form-control smallinput_text"  required="" value="<?=$keyy->msg_title?>" >
                </div>

                <label for="cheq_dt" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="date" value="<?php echo date("Y-m-d",strtotime($keyy->send_dt)); ?>" class="form-control" required="">
                </div>

            </div>

            

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Message:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="message" required="" rows="6"><?=$keyy->msg_text?></textarea>

                </div>

            </div>
            <?php $expdata=explode(',',$keyy->receive_branch);
             ?>
            <div class="form-check form-check-inline">
  <input class="form-check-input bracnhclass" type="checkbox" id="allbranch">
  <label class="form-check-label" for="allbranch">All Branch</label>
</div><br>
            <?php foreach ($distdata as $key) { if('342'!=$key->id){?>


                <div class="form-check form-check-inline" style="margin-right: 20px;">
  <input class="form-check-input bracnhclass2" name="branch_id[]" type="checkbox" id="inlineCheckbox<?php echo $key->id;?>" value="<?php echo $key->id;?>" <?php 
  foreach ( $expdata as $keyy => $value) { if($value==$key->id){echo "checked";} } ?> >
  <label class="form-check-label" for="inlineCheckbox<?php echo $key->id;?>"><?php echo $key->branch_name;?></label>
</div>



						
<?php }} ?> 
                       
				

                   
            
            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info">

                </div>

            </div>

           

        </form>
        <?php } ?>
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