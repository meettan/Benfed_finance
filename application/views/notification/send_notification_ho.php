<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="" onsubmit="return valid_data()">

            <div class="form-header">
                <h4>Send Notification</h4>
            </div>

            

            <div class="form-group row">
                <label for="cheq_no" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-4">
                    <input type="text" name="title" class="form-control smallinput_text" value="" required="">
                </div>

                <label for="cheq_dt" class="col-sm-2 col-form-label">Date:</label>
                <div class="col-sm-4">
                    <input type="date" name="date" value="2022-11-01" class="form-control" required="">
                </div>

            </div>

            

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Message:</label>

                <div class="col-sm-10">

                    <textarea class="form-control" name="message" required=""></textarea>

                </div>

            </div>



            <div class="form-check form-check-inline">

            <?php foreach ($distdata as $key) { ?>
						<input type="checkbox"  id="peru">
						<label for="peru" class="mb-0 ml-1"><?php echo $key->?></label>
<?php } ?> 
                        <input type="checkbox"  id="peru">
						<label for="peru" class="mb-0 ml-1">dfhvkjdfk</label>
					</div>

                   
            
            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info">

                </div>

            </div>

        </form>

    </div>

</div>