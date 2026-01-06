<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<style>
body { opacity:0; transition:0.6s ease-in-out; background:#f4f6f9; font-family:"Segoe UI", Arial, sans-serif; }
body.page-loaded { opacity:1; }

/* Voucher Count Badge */
.voucher-count { font-size:32px; font-weight:700; margin-top:6px; display:inline-block; }
.count-approved { color:#1e7e34; }
.count-unapproved { color:#856404; }
.count-hold { color:#a71d2a; }
.voucher-sub { font-size:13px; color:#666; margin-top:2px; }

/* Left Sidebar */
.left_bar { background:linear-gradient(135deg,#001f4d,#003366); padding:15px; border-radius:12px; box-shadow:0 4px 14px rgba(0,0,0,0.07); color:#fff; }
.left_bar h2 { color:#fff; font-size:20px; margin-bottom:15px; }
.left_bar ul { list-style:none; padding-left:0; }
.left_bar ul li { margin-bottom:10px; }
.left_bar ul li a { background:#1F618D; color:#fff; padding:10px 12px; border-radius:8px; display:block; text-decoration:none; font-weight:500; transition:0.25s; }
.left_bar ul li a:hover { background:rgba(255,255,255,0.2); color:#ffd966; }

/* Right Section */
.rightSideSec { padding-left:20px; }

/* Voucher Cards */
.threeBoxNewSmall { display:flex; background:#fff; padding:18px; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.07); margin-bottom:20px; align-items:center; transition:transform .25s ease; }
.threeBoxNewSmall:hover { transform:translateY(-4px); }
.threeBoxImg img { width:60px; height:60px; }
.threeBoxTxt { padding-left:15px; }
.threeBoxTxt h2 { font-size:18px; margin:0; color:#003e6f; font-weight:600; }

/* Icon Backgrounds */
.pinkCol { background:#ffd0e0; border-radius:12px; display:flex; align-items:center; justify-content:center; width:100px; height:100px; }
.yellowCol { background:#fff0a8; border-radius:12px; display:flex; align-items:center; justify-content:center; width:100px; height:100px; }

/* Utility */
.float-left { float:left; }
.row::after { content:""; display:block; clear:both; }
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
                <?php if(in_array($this->session->userdata['loggedin']['user_type'],['A','M','D','S','C'])) { ?>
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

        <div class="row threeBoxNewmain">

            <!-- Approved -->
            <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                    <div class="threeBoxImg darkBlue">
                        <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_a.png">
                    </div>
                    <div class="threeBoxTxt">
                        <h2>Approved Voucher</h2>
                        <span class="voucher-count count-approved"><?php echo $approved_today ?? 0; ?></span>
                        <div class="voucher-sub">Today</div>
                    </div>
                </div>
            </div>

            <!-- Unapproved -->
            <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                    <div class="threeBoxImg yellowCol">
                        <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_b.png">
                    </div>
                    <div class="threeBoxTxt">
                        <h2>Unapproved Voucher</h2>
                        <span class="voucher-count count-unapproved"><?= $unapproved_today ?? 0 ?></span>
                        <div class="voucher-sub">Today</div>
                    </div>
                </div>
            </div>

            <!-- On Hold -->
            <div class="col-sm-4 float-left">
                <div class="threeBoxNewSmall">
                    <div class="threeBoxImg pinkCol">
                        <img src="https://benfed.in/benfed_finance/assets/images/boxIcon_c.png">
                    </div>
                    <div class="threeBoxTxt">
                        <h2>Voucher on Hold</h2>
                        <span class="voucher-count count-hold"><?= $hold_today ?? 0 ?></span>
                        <div class="voucher-sub">Till Today</div>
                    </div>
                </div>
            </div>

        </div>

        <?php if (($this->session->userdata('loggedin')['branch_id'] ?? null) == 342) { ?>

        <!-- ===== COMPARATIVE BAR CHART ===== -->
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-12">
                <div style="width:100%; height:380px; background:#fff; padding:10px; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.07);">
                    <h4 style="margin-bottom:10px; color:#003e6f;">
                        Financial Year Comparison - Month Wise Collection
                    </h4>
                    <canvas id="mergedChart"></canvas>
                </div>
            </div>
        </div>
<br><br>
        <!-- ===== CLOSING BALANCE BAR CHART (NEW) ===== -->
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-12">
                <div style="width:100%; height:380px; background:#fff; padding:10px; border-radius:14px; box-shadow:0 4px 14px rgba(0,0,0,0.07);">
                    <h4 style="margin-bottom:10px; color:#003e6f;">
                        Branch Wise Collection(Current Financial Year)
                    </h4>
                    <canvas id="closingBalanceChart"></canvas>
                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>
</div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ===== EXISTING CHART (UNCHANGED) ===== */
const months = <?= json_encode($chart_months ?? []) ?>;
const currentData = <?= json_encode($chart_amounts ?? []) ?>;
const prevData = <?= json_encode($prevchart_amounts ?? []) ?>;

if(months.length){
    new Chart(document.getElementById('mergedChart'), {
        type:'bar',
        data:{
            labels: months,
            datasets:[
                { label:'Current FY', data: currentData, backgroundColor:'#0d6efd', borderRadius:4 },
                { label:'Previous FY', data: prevData, backgroundColor:'#6c757d', borderRadius:4 }
            ]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{ legend:{ display:true, position:'top' } },
            scales:{
                x:{ grid:{ display:false } },
                y:{
                    beginAtZero:true,
                    ticks:{
                        maxTicksLimit:5,
                        callback:value=>{
                            if(value>=10000000) return '₹'+(value/10000000).toFixed(1)+' Cr';
                            return '₹'+(value/100000).toFixed(0)+' L';
                        }
                    }
                }
            }
        }
    });
}

/* ===== NEW CLOSING BALANCE CHART ===== */
const cbLabels   = <?= json_encode($cb_labels ?? []) ?>;
const cbBalances = <?= json_encode($cb_balances ?? []) ?>;

if(cbLabels.length){
    new Chart(document.getElementById('closingBalanceChart'), {
        type:'bar',
        data:{
            labels:cbLabels,
            datasets:[{
                data:cbBalances,
                backgroundColor:cbBalances.map(v=>v>=0?'#198754':'#dc3545'),
                borderRadius:6,
                barThickness:22
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{ legend:{ display:false } },
            scales:{
                x:{ grid:{ display:false }, ticks:{ maxRotation:40,minRotation:25 } },
                y:{
                    beginAtZero:true,
                    ticks:{
                        maxTicksLimit:5,
                        callback:v=>{
                            if(Math.abs(v)>=10000000) return '₹'+(v/10000000).toFixed(2)+' Cr';
                            return '₹'+(v/100000).toFixed(0)+' L';
                        }
                    }
                }
            }
        }
    });
}

/* Fade-in */
window.addEventListener("load",()=>{ document.body.classList.add("page-loaded"); });
</script>

</body>
</html>
