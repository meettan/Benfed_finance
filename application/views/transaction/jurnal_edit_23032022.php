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
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('transaction/get_gr_dtls'); ?>",
            data: {
                ac_id: $('#acc_code_' + id).val()
            },
            dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                if (id > 1) {
                    pre_val = $('#acc_code_' + pre_id).val();
                    if (pre_val == $('#acc_code_' + id).val()) {
                        alert('A/C Head Can Not Be Same');
                        $('#acc_code_' + id).val('');
                        $('#gr_id_' + id).val('');
                        $('#subgr_id_' + id).val('');
                    } else {
                        $('#gr_id_' + id).val(result.gr_name);
                        $('#subgr_id_' + id).val(result.subgr_name);
                        // console.log(result.gr_name);
                    }
                } else {
                    $('#gr_id_' + id).val(result.gr_name);
                    $('#subgr_id_' + id).val(result.subgr_name);
                }
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;
                $("#add").append('<tr><td>' +
                    '<select id= "acc_code_' + x + '" class="form-control select_2" name="acc_code[]" class="input_text" style="width: 80%;" onchange="set_gr(' + x + ')" required>' +
                    '<option value="">Select</option>' +
                    " <?php
                        foreach ($row as $value) {
                            echo "<option value=" . $value->sl_no . ">" . $value->ac_name . "</option>";
                        }
                        ?>" +
                    '</select></td>' +
                    '<td><input type="text" class="transparent_tag" id="gr_id_' + x + '" name="gr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="transparent_tag" id="subgr_id_' + x + '" name="subgr_id[]" style="width: 100%;" readonly></td>' +
                    '<td><input type="text" class="form-control amount_cls" style="width: 100%; text-align: right;" id="amt" name="amount[]" required></td>' +
                    '<td><input type="text" id="dc_flg" name="dc_flg[]" class="transparent_tag" style="width: 100%; text-align: center;" value="' + g_flg + '" readonly></td>' +
                    '<td><button type="button" class="btn btn-danger" id="removeRow"><i class="fa fa-undo" aria-hidden="true"></i></button></td></tr>');
                $(".select_2").select2();
                //$('.preferenceSelect').change();
            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
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

        $('#submit').click(function() {
            var date = $('#date').val(),
                sys_date = $('#sys_date').val();
            if (new Date(date) > new Date(sys_date)) {
                alert("Invalid Date");
                return false;
            } else {
                $('#submit').prop('type', 'submit');
                return true;
            }
        });
    });
</script>

<div class="wraper">

    <div class="col-md-9 container form-wraper">

        <form method="POST" action="<?php echo site_url("transaction/jurnal_update") ?>" onsubmit="return valid_data()">

            <div class="form-header">

                <h4>Journal Voucher</h4>

            </div>

            <input type="hidden" id="sys_date" value="<?= date('Y-m-d') ?>">

            <div class="form-group row">

                <label for="trans_dt" class="col-sm-2 col-form-label">Date:</label>

                <div class="col-sm-7">

                    <input type="date" name="voucher_dt" class="form-control smallinput_text" value="<?=$voucher_detail->voucher_date;?>" id="date" style="width: 150px;" required  readonly />

                </div>

                <label for="voucher_mode" class="col-sm-1 col-form-label">Mode:</label>

                <div class="col-sm-1">

                    <input type="text" name="voucher_mode" value="Journal" class="transparent_tag" style="width:50px;" readonly />

                </div>

            </div>

            <div class="form-group row">
                <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="voucher_type" id="v_type" onchange="set_dr_cr()" class="input_text" disabled>
                        <option value="">Select</option>
                        <option value="R" <?= $voucher_detail->voucher_type == 'R' ? 'selected' : '' ?>>Bank Received</option>
                        <option value="P" <?= $voucher_detail->voucher_type == 'P' ? 'selected' : '' ?>>Bank Payment</option>
                    </select>
                    <input type="hidden" name="voucher_type" value="<?=$voucher_detail->voucher_type ?>">
                </div>
            </div>

            <div class="form-group row">

                <label for="acc_cd" class="col-sm-2 col-form-label">A/C Head:</label>

                <div class="col-sm-8">

                    <select class="form-control select2" style="width:282px;display: inline;" disabled>
                        <option value="">Select</option>
                        <?php
                        foreach ($row as $value) {
                            $selected = '';
                            if ($value->sl_no == $topacc_head->acc_code) {
                                $selected = 'selected';
                            }
                            echo "<option value='" . $value->sl_no . "' " . $selected . ">" . $value->ac_name . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="topacc_code" value="<?= $topacc_head->acc_code ?>">

                    <span style="float: right; display: inline;">
                        <input type="text" id="dc" class="transparent_tag" name="dr_cr_flag" value="" readonly>
                    </span>

                </div>

            </div>

            <div class="form-group row">

                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>

                <div class="col-sm-8">

                    <textarea class="form-control" name="remarks" required><?= $voucher_detail->remarks ?></textarea>

                </div>

            </div>

            <hr class="hr_divide">

            <table id="vau_tab">
                <thead>
                    <tr>
                        <th width="25%">A/C Head</th>
                        <th width="18%">Group</th>
                        <th width="18%">Subgroup</th>
                        <th>Amount</th>
                        <th></th>
                       <!-- <th><button class="btn btn-success" type="button" id="newrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button></th> -->
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
                            <td><input type="text" class="transparent_tag" id="subgr_id_<?= $i ?>" name="subgr_id[]" value="<?=$dt->subgr_name?>" style="width: 100%;" readonly></td>

                            <td><input type="text" class="form-control amount_cls" id="amt" name="amount[]" value="<?=$dt->amount?>" style="width: 100%; text-align: right;" required></td>
                            <td><input type="text" class="transparent_tag" id="dc_flg" name="dc_flg[]" value="<?=$dt->dr_cr_flag == 'Dr' ? 'Debit' : 'Credit' ?>" style="width: 100%; text-align: center;" readonly required></td>
                        </tr>
                    <?php $i++; $tot_amt+=$dt->amount;
                    } ?>
                </tbody>
                <tr><td colspan="2"></td>
                    <td colspan="3" style="text-align:right;">
                        <strong>Total:</strong>
                        <input name="tot_amt" type="text" class="transparent_tag" id="tot_amt" value="<?= $tot_amt ?>" style="text-align:left; color:#c1264d; font-size: 25px; " readonly>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="voucher_id" value="<?= $voucher_detail->voucher_id ?>">
            <input type="hidden" name="sl_no" value="<?= $voucher_detail->sl_no ?>">
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(".select_2").select2();
</script>
<script>
    $('#submit').on('click', function(e) {
        $('input[name^=amount]').map(function(idx, elem) {
            if ($(elem).val() > 0) {} else {
                e.preventDefault();
                alert('Amount Can Not Be 0');
                return false;
            }
        })
    });
    $(document).ready(function() {
        set_dr_cr();
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