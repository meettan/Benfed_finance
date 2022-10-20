<div class="">
<!-- <div class="daseboard_home"> -->
    <div class="col-sm-3 float-left">
        <div class="left_bar">
            <h2>Quick Links <i class="fa fa-link" aria-hidden="true"></i></h2>

           
               <ul>

               <?php  if($this->session->userdata['loggedin']['user_type']=="A"){ ?>
                    <li><a href="<?php echo site_url('cashVoucher'); ?>">Cash Voucher</a></li>
                    <li><a href="<?php echo site_url('bankVoucher'); ?>">Bank Voucher</a></li>
                    <li><a href="<?php echo site_url('jurnalVoucher'); ?>">Journal Voucher </a></li>
                    <li> <a href="<?php echo site_url('cheqdtl'); ?>">Cheque Entry</a></li>
                    <li> <a href="<?php echo site_url('advjrnlr'); ?>">Print Voucher</a></li>


                    <li><a href="<?php echo site_url('cashbook'); ?>">Cash Book</a></li>
                    <li><a href="<?php echo site_url('bankbook'); ?>">Bank Book</a></li>
                    <!-- <li> <a href="<?php echo site_url('bankbook'); ?>">Cheque Entry</a></li> -->

                    <?php }
                    if($this->session->userdata['loggedin']['user_type']=="A"||$this->session->userdata['loggedin']['user_type']=="M"||$this->session->userdata['loggedin']['user_type']=="D"||$this->session->userdata['loggedin']['user_type']=="S"){ ?>
                        <li><a href="<?php echo site_url('mnthend'); ?>">Month End</a></li>
                        <li><a href="<?php echo site_url('purchasevu'); ?>">Unapproved Voucher</a></li>
                        <li><a href="<?php echo site_url('ac_detail'); ?>">Account Detail</a></li>
                        
                    <?php }

                    ?>
                </ul>
            <?php // } else { ?>

               

            <?php // } ?>
        </div>
    </div>

  <!--  <div class="col-sm-9 float-left" style="z-index:-1;">
        <div class="daseboardNav"><a href="#">Dashboard</a> / Overview </div>

        <div class="row daseSmBoxMain">

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon"><img src="<?php echo base_url('assets/images/box_a.png'); ?>"></div>
                        <div class="value"><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                echo '';
                                            } else {
                                                echo '';
                                            }
                                            ?> <strong>Qnt</strong></div>
                    </div>
                    <h3>Total Paddy Procurement</h3>
                </div>
            </div>
            <?php if ($this->session->userdata['loggedin']['fin_id'] == '2') {  ?>
                <div class="col-sm-4">
                    <div class="daseSmBox">
                        <div class="subBox">
                            <div class="icon2"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                            <div class="value"><?php
                                                if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                    echo '';
                                                } else {
                                                    echo '';
                                                }
                                                ?></div>
                        </div>
                        <h3>Total No. of Cheques Issued</h3>
                    </div>
                </div>
            <?php } else {  ?>
                <div class="col-sm-4">
                    <div class="daseSmBox">
                        <div class="subBox">
                            <div class="icon2"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                            <div class="value"><?php

                                                echo '';
                                                ?> <strong>Qnt</strong>
                            </div>
                        </div>
                        <h3>Total Paddy Despatched</h3>
                    </div>
                </div>

            <?php } ?>
            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon3"><img src="<?php echo base_url('assets/images/box_c.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?></div>
                    </div>
                    <h3>Total Procured Amount</h3>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon4"><img src="<?php echo base_url('assets/images/box_d.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?></div>
                    </div>
                    <h3>Total Paid Amount</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon5"><img src="<?php echo base_url('assets/images/box_e.png'); ?>"></div>
                        <div class="value"><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                echo '';
                                            } else {
                                                echo '';
                                            } ?> <strong>Qnt</strong></div>
                    </div>
                    <h3>Total CMR offered</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon2"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                        <div class="value"><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                echo '';
                                            } else {
                                                echo '';
                                            } ?> <strong>Qnt</strong></div>
                    </div>
                    <h3>Total DO issued</h3>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon6"><img src="<?php echo base_url('assets/images/box_f.png'); ?>"></div>
                        <div class="value"><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                echo '';
                                            } else {
                                                echo '';
                                            } ?> <strong>Qnt</strong></div>
                    </div>
                    <h3>Total CMR Delivered</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                        <div class="value"><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                echo '';
                                            } else {
                                                echo '';
                                            }
                                            ?> <strong>Qnt</strong></div>
                    </div>
                    <h3>Total WQSC Uploaded</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon4"><img src="<?php echo base_url('assets/images/box_d.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?></div>
                    </div>
                    <h3>Total Fund Requisition(Gross)</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon2"><img src="<?php echo base_url('assets/images/box_b.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?>
                        </div>
                    </div>
                    <h3>Fund Requisition Sanctioned</h3>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon3"><img src="<?php echo base_url('assets/images/box_c.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?></div>
                    </div>
                    <h3>Total Mill Payment</h3>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="daseSmBox">
                    <div class="subBox">
                        <div class="icon5"><img src="<?php echo base_url('assets/images/box_e.png'); ?>"></div>
                        <div class="value"><strong>&#8377; </strong><?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {
                                                                        echo '';
                                                                    } else {
                                                                        echo '';
                                                                    } ?></div>
                    </div>
                    <h3>Total Society Payment</h3>
                </div>
            </div>


        </div>

    </div> -->

</div>

<script>
    var myIndex = 0;
    carousel();

    function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        myIndex++;
        if (myIndex > x.length) {
            myIndex = 1
        }
        x[myIndex - 1].style.display = "block";
        setTimeout(carousel, 3000); // Change image every 2 seconds
    }
</script>