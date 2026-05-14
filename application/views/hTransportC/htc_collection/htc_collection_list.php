<!-- Loader -->
<div id="loader" style="display:none;">
    <div class="spinner"></div>
</div>

<style>
#loader{
    position:fixed;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(255,255,255,0.7);
    z-index:9999;
}

.spinner{
    position:absolute;
    left:50%;
    top:50%;
    width:80px;
    height:80px;
    margin-left:-40px;
    margin-top:-40px;
    border:10px solid #f3f3f3;
    border-top:10px solid #3498db;
    border-radius:50%;
    animation:spin 1s linear infinite;
}

@keyframes spin{
    0%{ transform:rotate(0deg); }
    100%{ transform:rotate(360deg); }
}
</style>
<style>

.top-btn-row{
    display:flex;
    gap:15px;
    align-items:center;
    margin-bottom:25px;
}

.btnCustom{
    padding:10px 24px;
    border-radius:30px;
    font-size:15px;
    font-weight:600;
    text-decoration:none;
    color:#fff !important;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:0.3s ease;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

.btnBack{
    background:linear-gradient(to right,#d32f2f,#f44336);
}

.btnBack:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,0.25);
}

.btnAdd{
    background:linear-gradient(to right,#1565c0,#42a5f5);
}

.btnAdd:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 14px rgba(0,0,0,0.25);
}

</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="wraper">

    <div class="row">
        <div class="col-lg-9 col-sm-12">
            <h2><strong>HTC Invoice</strong></h2>
        </div>
    </div>

    <div class="col-lg-12 container contant-wraper">

        <h3>
        <div class="top-btn-row">
        <a href="<?php echo site_url('dashboard'); ?>"
       class="btnCustom btnBack">

        ⬅ Back

    </a>
    <a href="<?php echo site_url('handling-trandport-charges/htc_raise_invoice'); ?>"
       class="btnCustom btnAdd">

        ➕ Add Invoice

    </a>
</div>
        </h3>

        <table id="cashVoucherTable"
               class="table table-bordered table-hover display">

            <thead>
                <tr>
                    <th>Sl No.</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>IRN</th>
                    <th>ACK No</th>
                    <th>ACK DT</th>
                    <th>DOWNLOAD</th>
                    <th>VIEW</th>
                    <th>B2C PRINT</th>
                </tr>
            </thead>

            <tbody>

            <?php

            if($listData){

                $i = 1;

                foreach($listData as $rent_list){

                    $disable_prnt = $rent_list->irn ? 'hidden' : '';
                    $enable_btn   = $rent_list->irn ? '' : 'hidden';

            ?>

                <tr>

                    <td><?= $i ?></td>

                    <td id="do_dt_<?= $i ?>">
                        <?= date("d/m/Y", strtotime($rent_list->trans_dt)); ?>
                    </td>

                    <td><?= $rent_list->invoice_no ?></td>

                    <td><?= $rent_list->cust_name ?></td>

                    <td><?= $rent_list->total_amt ?></td>

                    <!-- IRN -->

                    <td id="irn_clk_td_<?= $i ?>">

                        <?php if($rent_list->irn){ ?>

                            <i class="fa fa-check fa-2x"
                               style="color:green;"></i>

                        <?php } else { ?>

                            <button type="button"
                                    onclick="irn_clk(<?= $i ?>,'<?= $rent_list->invoice_no ?>')">

                                <i class="fa fa-upload fa-2x"
                                   style="color:blue;"></i>

                            </button>

                        <?php } ?>

                    </td>

                    <!-- ACK NO -->

                    <td id="ack_clk_td_<?= $i ?>">
                        <?= $rent_list->ack_no ?>
                    </td>

                    <!-- ACK DT -->

                    <td id="ack_dt_td_<?= $i ?>">
                        <?= $rent_list->ack_dt ?>
                    </td>

                    <!-- DOWNLOAD -->

                    <td>

                        <a href="<?= site_url('api/print_irn?irn='.$rent_list->irn) ?>"
                           id="down_clk_td_<?= $i ?>"
                           <?= $enable_btn ?>>

                            <i class="fa fa-download fa-2x"
                               style="color:green;"></i>

                        </a>

                    </td>

                    <!-- VIEW -->

                    <td>

                        <a href="<?= site_url('handling-trandport-charges/htc_collection_edit/'.$rent_list->trans_no) ?>">

                            <i class="fa fa-edit fa-2x"
                               style="color:#007bff"></i>

                        </a>

                    </td>

                    <!-- PRINT -->

                    <td>

                        <a href="<?= site_url('handling-trandport-charges/rentb2c_rep?invoice_no='.$rent_list->invoice_no) ?>"
                           <?= $disable_prnt ?>>

                            <i class="fa fa-print fa-2x"
                               style="color:green;"></i>

                        </a>

                    </td>

                </tr>

            <?php

                $i++;

                }

            } else {

                echo "<tr>
                        <td colspan='11' style='text-align:center'>
                            No Data Found
                        </td>
                      </tr>";
            }

            ?>

            </tbody>

        </table>

    </div>

</div>

<script>

$(document).ready(function(){

    $('#cashVoucherTable').DataTable({
        pageLength:10,
        lengthMenu:[5,10,25,50,100],
        ordering:true,
        searching:true,
        paging:true,
        info:true,
        order:[[0,'desc']]
    });

});



function irn_clk(i, trans_do){

    var do_dt = $('#do_dt_' + i).text().trim();

    var curr_dt = new Date();

    var curr =
        ("0" + curr_dt.getDate()).slice(-2)
        + '/'
        + ("0" + (curr_dt.getMonth()+1)).slice(-2)
        + '/'
        + curr_dt.getFullYear();

    console.log(do_dt);
    console.log(curr);

    if(do_dt != curr){

        alert('IRN Generation Not Possible');

        return false;
    }

    $.ajax({

        type:'GET',

        url:"<?php echo site_url('/api/get_api_htc'); ?>",

        data:{
            trans_do:trans_do
        },

        dataType:'json',

        beforeSend:function(){

            $('#loader').show();
            $('.wraper').hide();

        },

        success:function(res){

            console.log(res);

            if(res.Success == 'Y'){

                save_data(
                    trans_do,
                    res.Irn,
                    res.AckNo,
                    res.AckDt,
                    'Y'
                );

                $('#irn_clk_td_' + i).html(
                    '<i class="fa fa-check fa-2x" style="color:green;"></i>'
                );

                $('#ack_clk_td_' + i).text(res.AckNo);

                $('#ack_dt_td_' + i).text(res.AckDt);

                $('#down_clk_td_' + i).attr(
                    'href',
                    '<?= site_url() ?>api/print_irn?irn=' + res.Irn
                );

                $('#down_clk_td_' + i).removeAttr('hidden');

                alert('IRN GENERATED SUCCESSFULLY');

            } else {

                alert('IRN NOT GENERATED');

            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

            alert('Server Error');

        },

        complete:function(){

            $('#loader').hide();
            $('.wraper').show();

        }

    });

}



function save_data(trans_do, irn, ack, ack_dt, trn_type){

    $.ajax({

        type:'GET',

        url:"<?php echo site_url('api/save_htc_irn'); ?>",

        data:{
            trans_do:trans_do,
            irn:irn,
            ack:ack,
            ack_dt:ack_dt,
            trn_type:trn_type
        },

        success:function(result){

            console.log(result);

        },

        error:function(){

            alert('Save Failed');

        }

    });

}

</script>