<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
/* ====== PAGE TRANSITION ====== */
body {
    opacity: 0;
    transition: opacity 0.6s ease-in-out;
    background: #f4f6f9;
    font-family: "Segoe UI", Arial, sans-serif;
}
body.page-loaded {
    opacity: 1;
}
.fade-out {
    opacity: 0;
}
/* ===== Voucher Count Badge ===== */
.voucher-count {
    font-size: 32px;
    font-weight: 700;
    margin-top: 6px;
    display: inline-block;
}

/* Approved */
.count-approved {
    color: #1e7e34; /* dark green */
}

/* Unapproved */
.count-unapproved {
    color: #856404; /* dark yellow */
}

/* On Hold */
.count-hold {
    color: #a71d2a; /* dark pink/red */
}

/* Sub text */
.voucher-sub {
    font-size: 13px;
    color: #666;
    margin-top: 2px;
}

/* ====== LEFT SIDEBAR ====== */
.left_bar {
    background: #ffffff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.07);
}

.left_bar h2 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #003e6f;
    font-weight: 600;
}

.left_bar ul {
    list-style: none;
    padding-left: 0;
}

.left_bar ul li {
    margin-bottom: 10px;
}

.left_bar ul li a {
    text-decoration: none;
    display: block;
    padding: 10px 12px;
    background: #eef4fb;
    border-radius: 8px;
    color: #003e6f;
    font-weight: 500;
    transition: 0.25s;
}

.left_bar ul li a:hover {
    background: #d9e9ff;
    color: #002f5e;
}

/* ====== RIGHT SECTION ====== */
.rightSideSec {
    padding-left: 20px;
}

/* ====== 3 BOX CARDS ====== */
.threeBoxNewSmall {
    display: flex;
    background: #ffffff;
    padding: 18px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.07);
    margin-bottom: 20px;
    align-items: center;
    transition: transform .25s ease;
}
.threeBoxNewSmall:hover {
    transform: translateY(-4px);
}

.threeBoxImg img {
    width: 60px;
    height: 60px;
}

.threeBoxTxt {
    padding-left: 15px;
}

.threeBoxTxt h2 {
    font-size: 18px;
    margin: 0;
    color: #003e6f;
    font-weight: 600;
}

.threeBoxTxt p {
    margin-top: 5px;
    font-size: 16px;
    color: #222;
}
/* Light Pink Icon Background for On Hold */
.threeBoxNewSmall .pinkCol {
    background: #ffd0e0; /* soft light pink */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    transition: background 0.25s ease, transform 0.25s ease;
}

/* Hover Effect */
.threeBoxNewSmall:hover .pinkCol {
    background: #ffccd9; /* slightly darker on hover */
}

/* Light Yellow Icon Background */
.threeBoxNewSmall .yellowCol {
    background: #fff0a8; /* light yellow */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    transition: background 0.25s ease, transform 0.25s ease;
}

/* Hover Effect */
.threeBoxNewSmall:hover .yellowCol {
    background: #fff2a8; /* slightly darker light yellow on hover */
}
.left_bar {
    background: linear-gradient(135deg, #001f4d, #003366); /* navy blue gradient */
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.07);
    color: #ffffff; /* text color white for contrast */
}

/* Update heading color */
.left_bar h2 {
    color: #ffffff;
}

/* Sidebar links */
/* Sidebar links with slightly lighter background */
/* Sidebar links with sky blue background */
.left_bar ul li a {
    background: #1F618D; /* sky blue */
    color: #ffffff;      /* text white for contrast */
    padding: 10px 12px;
    border-radius: 8px;
    display: block;
    text-decoration: none;
    font-weight: 500;
    transition: 0.25s;
}

/* Hover Effect */
.left_bar ul li a:hover {
    background: #1A5276; /* deeper sky blue on hover */
    color: #ffd966;       /* optional highlight color */
}

/* Hover Effect */
.left_bar ul li a:hover {
    background: rgba(255, 255, 255, 0.18); /* slightly stronger overlay */
    color: #ffd966; /* optional highlight */
}

/* Hover Effect */
.left_bar ul li a:hover {
    background: rgba(255, 255, 255, 0.25); /* lighter on hover */
    color: #ffd966; /* optional highlight color */
}

.left_bar ul li a:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffd966; /* optional highlight color on hover */
}

/* Utility */
.float-left { float: left; }
.row::after { content: ""; display: block; clear: both; }

</style>
</head>

<body>

<div class="">
<div class="daseboard_home_newAdmin">
<div class="fullWidthBotomPading">

    <!-- LEFT SIDEBAR -->
    <div class="col-sm-3 float-left">
        <div class="left_bar">
            <h2>Quick Links <i class="fa fa-link"></i></h2>

            <ul>
                <li><a href="<?php echo site_url('cashVoucher'); ?>">Cash Voucher</a></li>
                <li><a href="<?php echo site_url('bankVoucher'); ?>">Bank Voucher</a></li>
                <li><a href="<?php echo site_url('jurnalVoucher'); ?>">Journal Voucher</a></li>
                <li><a href="<?php echo site_url('cheqdtl'); ?>">Cheque Entry</a></li>
                <li><a href="<?php echo site_url('advjrnlr'); ?>">Print Voucher</a></li>

                <?php if($this->session->userdata['loggedin']['user_type']=="A"
                    || $this->session->userdata['loggedin']['user_type']=="M"
                    || $this->session->userdata['loggedin']['user_type']=="D"
                    || $this->session->userdata['loggedin']['user_type']=="S"
                    || $this->session->userdata['loggedin']['user_type']=="C"){ ?>

                <li><a href="<?php echo site_url('mnthend'); ?>">Month End</a></li>
                <li><a href="<?php echo site_url('purchasevu'); ?>">Unapproved Voucher</a></li>

                <?php } ?>

                <li><a href="<?php echo site_url('cashbook'); ?>">Cash Book</a></li>
                <li><a href="<?php echo site_url('bankbook'); ?>">Bank Book</a></li>
                <li><a href="<?php echo site_url('ac_detail'); ?>">Account Detail</a></li>
            </ul>

        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="col-sm-9 float-left rightSideSec">
        <div class="row">
            <div class="threeBoxNewmain">

            <div class="col-sm-4 float-left">
    <div class="threeBoxNewSmall">
        <div class="threeBoxImg darkBlue">
            <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_a.png" alt="">
        </div>
        <div class="threeBoxTxt">
            <h2>Approved Voucher</h2>
            <span class="voucher-count count-approved">
                <?php echo $approved_today ?? 0; ?>
            </span>
            <div class="voucher-sub">Today</div>
        </div>
    </div>
</div>


<div class="col-sm-4 float-left">
    <div class="threeBoxNewSmall">
        <div class="threeBoxImg yellowCol">
            <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_b.png" alt="">
        </div>
        <div class="threeBoxTxt">
            <h2>Unapproved Voucher</h2>
            <span class="voucher-count count-unapproved">
                <?php echo $unapproved_today ?? 0; ?>
            </span>
            <div class="voucher-sub">Today</div>
        </div>
    </div>
</div>

<div class="col-sm-4 float-left">
    <div class="threeBoxNewSmall">
        <div class="threeBoxImg pinkCol">
            <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_c.png" alt="">
        </div>
        <div class="threeBoxTxt">
            <h2>Voucher on Hold</h2>
            <span class="voucher-count count-hold">
                <?php echo $hold_today ?? 0; ?>
            </span>
            <div class="voucher-sub">Till Today</div>
        </div>
    </div>
</div>


            </div>
        </div>
    </div>

</div>
</div>
</div>

<!-- SLIDER SCRIPT (unchanged) -->
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
    if (myIndex > x.length) { myIndex = 1 }
    x[myIndex - 1].style.display = "block";
    setTimeout(carousel, 3000);
}
</script>

<!-- SMOOTH PAGE FADE SCRIPT -->
<script>
window.addEventListener("load", function () {
    document.body.classList.add("page-loaded");
});
</script>

</body>
</html>
