<!-- <div class="wraper">

    <div class="col-md-12 container form-wraper">

        <?php foreach ($notification as $key) { ?>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?= $key->msg_title ?></h4>
                            <!-- <p class="card-description"> Write text in <code>&lt;p&gt;</code> tag </p> 
                            <p> <?= $key->msg_text ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">




                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</div> -->


<!-- ============================================================ -->
<?php foreach ($notification as $key) { ?>

<div class="container">
    <div class="row inbox-wrapper">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-12 email-content">
                            <div class="email-head">

                                <div class="email-head-sender d-flex align-items-center justify-content-between flex-wrap">

                                    <div class="date"><?=date('M-d-Y',strtotime($key->create_at))?></div>
                                </div>
                            </div>
                            <div class="email-body">
                                <p><?= humanize($key->msg_title) ?></p>
                                <br>
                                <p><?= $key->msg_text ?></p>
                                <br>
                                <p><strong>Regards</strong>,<br> <?= humanize($key->send_user) ?></p> 
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary" style="float: right;">Print</button>
</div>
<?php } ?>