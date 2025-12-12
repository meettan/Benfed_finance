
<!-- jQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<style>
    body {
        background: linear-gradient(135deg, #cfd8dc, #fce4ec); /* lighter background */
        font-family: "Segoe UI", Tahoma, sans-serif;
    }

    .contant-wraper {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    h1 {
        color: #1565c0; /* dark blue */
        font-weight: 700;
        margin-bottom: 20px;
    }

    table {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    thead {
    /* background: linear-gradient(90deg, #1565c0, #1e88e5, #42a5f5); blue gradient */
    background: linear-gradient(to right, #003e7c, #0056b3);
    color: white;
    font-size: 15px;
}


    tbody tr:hover {
        background: #e3f2fd; /* light hover effect */
        transition: 0.3s;
    }

    /* Rounded Buttons */
    .btnSame {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 25px;
        width: 120px;
        display: inline-block;
        text-align: center;
        font-weight: 600;
        box-shadow: 0px 3px 6px rgba(0,0,0,0.2);
        color: white;
        text-decoration: none;
    }
 
    .btn-primary {
        background-color: #1565c0; /* dark blue */
        border: none;
    }

    .btn-danger {
        background-color: #d32f2f; /* red for back/delete */
        border: none;
    }

    .fa-edit:hover,
    .fa-trash-o:hover {
        transform: scale(1.2);
        transition: 0.2s;
    }

    label {
        font-weight: bold;
        color: #37474f;
    }

    input[type="date"] {
        border-radius: 6px;
        border: 1px solid #1565c0; /* blue border for date */
    }

    /* Add + Back Parallel Row */
    .top-button-row {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }

	.form-header {
    background: linear-gradient(135deg, #004e92, #0a85d9, #4fc3f7);
    padding: 13px 20px;
    border-radius: 0;   /* RECTANGLE SHAPE */
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}


.form-header h2 {
    margin: 0;
    color: #ffffff;
    font-size: 20px;
    font-weight: 500;
	text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

</style>
<style>
    .container-fluid {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    h2 {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .row:first-child {
        margin-top: 0 !important;
    }

    body {
        margin-top: 0 !important;
    }
</style>
<?php
$gr_dtls = json_decode($gr_dtls);
$br_dtls = json_decode($br_dtls);
$subgr_dtls = json_decode($subgr_dtls);
?>
<div class="wraper">

    <div class="col-md-6 container form-wraper">
        <form method="POST" action="<?php echo site_url('master/ac_head_save'); ?>">

            <div class="form-header">
                <h2>Add A/C Head</h2>
            </div>

            <div class="form-group row">

                <label for="gr_id" class="col-sm-2 col-form-label">Group</label>

                <div class="col-sm-10">
                    <select class="form-control select2" id="gr_id" name="gr_id" required>
                        <option value="">Select</option>
                        <?php 
                        foreach ($gr_dtls as $dt) {
                            $select = '';
                            if ($dt->sl_no == $selected['gr_id']) {
                                 $select = 'selected';
                             }
                        ?>
                            <option value='<?=$dt->sl_no ?>' <?=$select ?>><?= strtoupper($dt->name) ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">

                <label for="subgr_id" class="col-sm-2 col-form-label">Sub Group</label>

                <div class="col-sm-10">

                    <select class="form-control" id="subgr_id" name="subgr_id" required>
                        <option value="">Select</option>
                        <?php
                        if ($subgr_dtls) {
                            foreach ($subgr_dtls as $dt) {
                                $select = '';
                                if ($dt->sl_no == $selected['subgr_id']) {
                                    $select = 'selected';
                                }
                        ?>
                                <option value='<?= $dt->sl_no ?>' <?= $select ?>><?= strtoupper($dt->name) ?></option>
                        <?php }
                        } ?>
                    </select>
                </div>

            </div>
            <div class="form-group row">

                <label for="br_id" class="col-sm-2 col-form-label">Branch</label>

                <div class="col-sm-10">
                    <select class="form-control select_2" id="br_id" name="br_id" required>
                        <option value="">Select</option>
                        <?php $select = '';
                        foreach ($br_dtls as $dt) {  
                        ?>
                            <option value='<?= $dt->id ?>' <?php if ($dt->id == $selected['br_id']) { echo 'selected'; } ?>>
                            <?= strtoupper($dt->branch_name) ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <label for="ac_flg" class="col-sm-2 col-form-label">A/C Head</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="achead" name="achead" required="required" value="<?= $selected['achead'] ?>" required/>

                </div>

            </div>
            <div class="form-group row">

                <label for="benfed_ac_code" class="col-sm-2 col-form-label">Benfed Account No</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" id="benfed_ac_code" name="benfed_ac_code" required="required" value="<?= $selected['benfed_ac_code'] ?>" required/>

                </div>

            </div>

            <input type="hidden" name="id" value="<?= $selected['id'] ?>">

            <div class="form-group row">

                <div class="col-sm-10">
                <a href="<?php echo site_url("achead"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
                    <input type="submit" class="btnSame btn-primary" value="Save" />
                    
                </div>

            </div>

        </form>

    </div>

</div>

<script>
   // $(".select_2").select2();
</script>

<script>
    $("#gr_id").on('change', function() {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('master/get_subgr_dtls'); ?>",
            data: {
                gr_id: $(this).val()
            },
            dataType: 'html',
            success: function(result) {
                //    console.log(result);
                var result = $.parseJSON(result);
                if (result.length > 0) {
                    $('#subgr_id').empty();
                    $('#subgr_id').append($('<option>', {
                        value: '',
                        text: 'Select'
                    }));
                    $.each(result, function(i, item) {
                        $('#subgr_id').append($('<option>', {
                            value: item.id,
                            text: item.name
                        }));
                    });
                } else {
                    $('#subgr_id').empty();
                    $('#subgr_id').append($('<option>', {
                        value: '',
                        text: 'Select'
                    }));
                }
            }
        });
    });
</script>