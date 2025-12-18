<style>

/* ---- GLOBAL ---- */
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f0f4fa;
}

/* ---- HEADER ---- */
.billPrintWrapper h2 {
    color: #002b5c;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.billPrintWrapper h4 {
    color: #003f7d;
    font-size: 16px;
    font-weight: 600;
}

/* ---- WRAPPER / CARD ---- */
.contant-wraper {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 20px rgba(0,0,0,0.08);
    margin-top: 20px;
}

/* ---- TOP BOXES ---- */
.printTop023 {
    background: #eaf3ff;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 5px solid #0056b3;
    overflow: auto;
}

.leftNo, .rightDate {
    font-size: 15px;
    font-weight: 600;
    color: #003567;
}

/* ---- DROPDOWN ---- */
.cente select {
    padding: 7px 10px;
    border: 1px solid #bcd3f5;
    border-radius: 6px;
    outline: none;
    font-size: 14px;
    font-weight: bold;
    background: #f4f9ff;
    color: #003e7c;
}
.cente select:hover {
    border-color: #007bff;
}

/* ---- TABLE NEW DESIGN ---- */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

table thead th {
    background: linear-gradient(to right, #1a5fae, #3c7ed6);
    color: white;
    padding: 4px;
    text-align: center;
    border: none;
    font-size: 14px;
}

table tbody tr {
    background: white;
    transition: 0.2s;
}

table tbody tr:hover {
    background: #eaf4ff;
    transform: scale(1.01);
}

table td {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;
    font-size: 14px;
}

/* ---- TOTAL ROW ---- */
.total-error {
    background: #ffd8d8 !important;
}
tfoot tr th {
    background: #003e7c;
    color: white;
    padding: 10px;
}

.form-header {
    background: linear-gradient(to right, #1a5fae, #3c7ed6);
    padding: 12px 18px;
    border-radius: 6px;
    color: #fff;
}
.form-header h4 {
    margin: 0;
    font-weight: 600;
    letter-spacing: 0.5px;
}
/* ---- BUTTONS NEW STYLE ---- */
.btn-primary {
    background: #0056b3 !important;
    border: none;
    padding: 10px 25px;
    border-radius: 35px;
    font-weight: bold;
    box-shadow: 0px 4px 12px rgba(0,86,179,0.3);
    transition: 0.3s;
}

.btn-primary:hover {
    background: #003e7c !important;
    transform: translateY(-2px);
}

.btn-danger {
    background: #e0303b !important;
    border: none;
    padding: 10px 25px;
    border-radius: 35px;
    font-weight: bold;
    box-shadow: 0px 4px 12px rgba(224,48,59,0.3);
}

.btn-danger:hover {
    background: #b51e26 !important;
    transform: translateY(-2px);
}

/* ---- REMARKS ---- */
.remarks {
    font-size: 16px;
    font-weight: bold;
    background: #fff7d1;
    padding: 10px;
    border-left: 4px solid #ffc107;
    margin-top: 20px;
    border-radius: 6px;
}

</style>

<style>
    td,
    th {
        padding: 5px;
    }
</style>
<script>
    function set_gr(id) {
        var pre_val = '';
        var pre_id = id - 1;
        if (id > 1) {
            pre_val = $('#acc_code_' + pre_id).val();
            if (pre_val == $('#acc_code_' + id).val()) {
                alert('A/C Head Can Not Be Same');
                $('#acc_code_' + id).val('');
                $('#gr_id_' + id).val('');
                $('#subgr_id_' + id).val('');
            } else {
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
                    data: {
                        ac_id: $('#acc_code_' + id).val()
                    },
                    dataType: 'html',
                    success: function(result) {
                        var result = $.parseJSON(result);
                        $('#gr_id_' + id).val(result.gr_name);
                        $('#subgr_id_' + id).val(result.subgr_name);
                    }
                });
            }
        } else {
            $.ajax({
                type: "GET",
                url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
                data: {
                    ac_id: $('#acc_code_' + id).val()
                },
                dataType: 'html',
                success: function(result) {
                    var result = $.parseJSON(result);
                    $('#gr_id_' + id).val(result.gr_name);
                    $('#subgr_id_' + id).val(result.subgr_name);
                }
            });
        }
    }
    // var x = 1;
    $(document).ready(function() {
        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;
                $("#add").append('<tr class="mb-2"><td><select id="acc_code_' + x + '" name="acc_code[]" class="form-control acc_code" style="width: 80%;" onchange="set_gr(' + x + ')" required><option value="">Select</option>' +
                     "<?php
                        foreach ($row as $value) {
                            echo "<option value='" . $value->sl_no . "'>" . $value->ac_name . "</option>";
                        }
                        ?>" +
                    '</select></td>' +
                    '<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="transparent_tag" id="subgr_id_' + x + '" name="subgr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" oninput="validate(this)" required ></td>' +
                    '<td><input type = "text" id = "dc_flg" name = "dc_flg[]" class = "transparent_tag" style = "width: 100%; text-align: center;" value = "' + g_flg + '" readonly required ></td>' +
                    '<td><button type = "button" class = "btn btn-danger" id = "removeRow"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {

            $(this).parent().parent().remove();

            $('.amount_cls').change();
        });

        $('#add').on("change", ".amount_cls", function() {

            $("#tot_amt").val('');
            var tot_amt = 0;
            $('.amount_cls').each(function() {
                tot_amt += +$(this).val();
            });
            $("#tot_amt").val(tot_amt.toFixed(2));

        });
    });
</script>

<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/update") ?>" onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Cash Voucher</h4>

            </div>

            <div class="form-group row">

                <label for="voucher_dt" class="col-sm-2 col-form-label">Date:</label>

                <div class="col-sm-7">

                    <input type="date" name="voucher_dt" class="transparent_tag" value="<?= $voucher_detail->voucher_date; ?>" readonly />

                </div>

                <label for="voucher_mode" class="col-sm-1 col-form-label">Mode:</label>

                <div class="col-sm-1">

                    <input type="text" name="voucher_mode" value="CASH" class="transparent_tag" style="width:50px;" readonly />

                </div>

            </div>

            <div class="form-group row">

                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>

                <div class="col-sm-8">

                    <select id="v_type" style="width: 100%;" onchange="set_dr_cr()" class="form-control" disabled>

                        <option value="">Select</option>
                        <option value="R" <?= $voucher_detail->voucher_type == 'R' ? 'selected' : '' ?>>Cash Received</option>
                        <option value="P" <?= $voucher_detail->voucher_type == 'P' ? 'selected' : '' ?>>Cash Payment</option>

                    </select>
                    <input type="hidden" name="voucher_type" value="<?= $voucher_detail->voucher_type; ?>">
                </div>

            </div>

            <div class="form-group row">

                <label for="acc_hd" class="col-sm-2 col-form-label">A/C Head:</label>

                <div class="col-sm-8">

                    <input type="text" name="acc_hd" class="transparent_tag" value="<?= $cash_head ?>" style="width: 200px; display:inline;" readonly />

                    <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="<?= $voucher_detail->dr_cr_flag == 'Dr' ? 'Debit' : 'Credit' ?>" style="display:inline;" readonly />

                </div>

            </div>

            <input type="hidden" name="topacc_cd" value="<?= $cash_code ?>" />

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-8">

                    <textarea class="form-control" name="remarks" required><?= $voucher_detail->remarks; ?></textarea>

                </div>

            </div>

            <hr class="hr">

            <table id="vau_tab">
                <thead>
                    <tr>
                        <th width="25%">A/C Head</th>
                        <th width="18%">Group</th>
                        <th width="18%">Subgroup</th>
                        <th>Amount(₹)</th>
                        <th></th>
                        <th><!--<button class="btn btn-success" type="button" id="newrow">
                                <i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button>  -->
                        </th>
                    </tr>
                </thead>
                <tbody id="add">
                    <?php $i = 1;
					      $tot_amt = 0;
                    foreach ($ac_dtls as $dt) { ?>
                        <tr class="mb-2">
                            <td>
                                <select id="acc_code_<?= $i ?>" class="form-control acc_code" style="width: 80%;" onchange="set_gr(<?= $i ?>)" disabled>
                                    <option value="">Select</option>
                                    <?php
                                    foreach ($row as $value) {
                                        $selected = '';
                                        if ($value->sl_no == $dt->acc_code) {
                                            $selected = 'selected';
                                        }
                                        echo "<option value=" . $value->sl_no . " " . $selected . ">" . $value->ac_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="acc_code[]" value="<?=$dt->acc_code ?>">
                            </td>
                            <td><input type="text" class="transparent_tag" id="gr_id_<?= $i ?>" name="gr_id[]" value="<?=$dt->gr_name ?>" style="width: 100%;" readonly></td>
                            <td><input type="text" class="transparent_tag" id="subgr_id_<?= $i ?>" name="subgr_id[]" value="<?=$dt->subgr_name ?>" style="width: 100%;" readonly></td>

                            <td><input type="text" class="form-control amount_cls" id="amt" name="amount[]" value="<?=$dt->amount; ?>" style="width: 100%; text-align: right;"oninput="validate(this)"  required></td>
                            <td><input type="text" class="transparent_tag" id="dc_flg" name="dc_flg[]" value="<?=$dt->dr_cr_flag == 'Dr' ? 'Debit' : 'Credit' ?>" style="width: 100%; text-align: center;" readonly required></td>
                        </tr>
                    <?php $i++; $tot_amt+=$dt->amount;
                    } ?>
                </tbody>
                <tr>
				    <td colspan="2"></td>
                    <td colspan="3" style="text-align:right;">
                        <strong>Total:</strong>
                        <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" value="<?=$tot_amt;?>" style="text-align:left; color:#c1264d; font-size: 25px;" readonly>
                    </td>
                </tr>

            </table>
            <input type="hidden" name="voucher_id" value="<?= $voucher_detail->voucher_id ?>">
            <input type="hidden" name="sl_no" value="<?= $voucher_detail->sl_no ?>">
            <div class="form-group row">

                <div class="col-sm-10">
                <a href="<?php echo site_url("cashVoucher"); ?>" 
                  class="btnSame btn-danger" 
                  style="width: 100px; margin-left:10px;">⬅ Back
                  </a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="submit" id="submit" value="Update" class="btnSame btn-primary" />
                    
                </div>

            </div>

        </form>

    </div>

</div>

<script>
    $(document).ready(function() {
        set_dr_cr();
    })
    $('#submit').on('click', function(e) {
        $('input[name^=amount]').map(function(idx, elem) {
            if ($(elem).val() > 0) {} else {
                e.preventDefault();
                alert('Amount Can Not Be 0');
                return false;
            }
            // console.log();
        })
    })
</script>
<script>
    var g_flg;

    function set_dr_cr() {
        var flag;

        if (document.getElementById('v_type').value == 'R') {
            flag = 'Debit';
            g_flg = 'Credit';
        } else if (document.getElementById('v_type').value == 'P') {
            flag = 'Credit';
            g_flg = 'Debit';
        } else {
            flag = '';
            g_flg = '';
        }

        document.getElementById('dc').value = flag;
        document.getElementById('dc_flg').value = g_flg;
    }


    function valid_data() {
        var voucher_type = document.getElementById('v_type').value;
        if (voucher_type == '0') {
            alert("Please Supply Voucher Type");
            return false;
        }

        var dc_flag = document.getElementById('dc').value;
        if (dc_flag.trim() == '') {
            alert("Invalid Input");
            return false;
        }

        var dr_cr = document.getelementById('dc_flg').value;
        if (dr_cr.trim() == '') {
            alert("Invalid Input");
            return false;
        }

    }
</script>