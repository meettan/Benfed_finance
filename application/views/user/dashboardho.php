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
/* Status Colors */
.status-general {
        background: #ffebee;
        color: #c62828;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: bold;
    }

    .status-manager {
        background: #fff8e1;
        color: #ff8f00;
        padding: 3px 8px;
        border-radius: 8px;
        font-weight: bold;
    }
    .status-admin {
    background: #e6f4e6;  /* light green background */
    color: #2e7d32;       /* strong green text */
    padding: 3px 8px;
    border-radius: 8px;
    font-weight: bold;
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
<div class="wraper">      
        <div class="row"> 
            <div class="col-lg-9 col-sm-12">
                <h2><strong>User List</strong></h2>
            </div>
        </div>
        <div class="col-lg-12 container contant-wraper">    
        <h5 style="text-align:left">

               
<!-- <center> -->
    
<input type="radio" id="status" name="user_status" class="status"  value="A"> <label for="html">Active</label>  &nbsp; &nbsp; &nbsp;
<input type="radio" id="status" name="user_status" class="status" value="U"><label for="approve">Pending</label> &nbsp; &nbsp; &nbsp; 
<input type="radio" id="status" name="user_status" class="status" value="D"> <label for="html">Inactive</label> 
<!-- </center> -->
<div>
<a href="<?php echo site_url("dashboard"); ?>" 
                class="btnSame btn-danger" 
                style="width: 100px; margin-left:10px;">
                ⬅ Back
            </a>
</div>
</small>

<span class="confirm-div" style="float:right; color:green;"></span>

</h5>
<h5 style="text-align:right">
<span>Branch :</span>
<select name="" id="branch">
    <option value="0">ALL</option>
    <?php foreach ($branch as $key) {  ?>
    <option value="<?php echo $key->id ?>"><?php echo $key->branch_name; ?></option>
    <?php } ?>
</select></h5>


<?php //print_r($user_dtls); ?>

            <!-- <table class="table table-bordered table-hover"> -->
            <table class="table table-bordered table-hover" id="example">
                <thead>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Branch Name</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>User Id</th>
                        <th>Option</th>

                    </tr>

                </thead>

                <tbody id='user_list'> 

                    <?php 
                    
                    if($user_dtls) {

                        $i = 0;
                        
                            foreach($user_dtls as $u_dtls) {

                    ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $u_dtls->branch_name; ?></td>
                                <td><?php echo $u_dtls->user_name; ?></td>
								
                                <td><?php if($u_dtls->user_type == 'A'){
                                            echo '<span class="status-admin">Admin</span>';
                                          }elseif ($u_dtls->user_type == 'M') {
                                            echo '<span class="status-manager">Manager</span>';
                                          }elseif ($u_dtls->user_type == 'D') {
                                            echo '<span class="status-general">Accountant</span>';
                                          }elseif ($u_dtls->user_type == 'U') {
                                            echo '<span class="status-general">General User</span>';
                                          }
                                            ?>
                                </td>
                                <td><?php echo $u_dtls->user_id; ?></td>
                                <td>
                                    <a href="admins/user_edit_admin?user_id=<?php echo $u_dtls->user_id; ?>" 
                                        data-toggle="tooltip"
                                        data-placement="bottom" 
                                        title="Edit">
                                        <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                            
                            }

                        }

                        else {

                            echo "<tr><td colspan='6' style='text-align: center;'>No data Found</td></tr>";

                        }
                    ?>
                
                </tbody>

                <tfoot>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Branch Name</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>User Id</th>
                        <th>Option</th>

                    </tr>
                
                </tfoot>

            </table>
            
        </div>

    </div>

<script>

    $(document).ready( function (){

        $('.delete').click(function () {

            var id = $(this).attr('id');

            var result = confirm("Do you really want to delete this record?");

            if(result) {

                window.location = "<?php echo site_url('admin/user/delete?user_id="+id+"');?>";

            }
            
        });

    });

</script>

<script>
   
    $(document).ready(function() {

    $('.confirm-div').hide();

    <?php if($this->session->flashdata('msg')){ ?>

    $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();
	
	<?php } ?>

    });
	
	
    $('.status').click(function(){
        // alert($(this).val());
        getData();
        // if ($(this).is(":checked")) {
        //     alert($(this).val())
        // }

    });
	
$('#branch').change(function(){
  getData();
})

function getData(){


  if ($("input[name='user_status']:checked").val()) {
       var ststus=($("input[name='user_status']:checked").val());
    }

  var branch=$("#branch").val();
//   alert($("#branch").val());
    $.ajax({
				type: "GET",
				url: "<?php echo site_url('admins/get_userlist'); ?>",
				data: { user_status: ststus, branch:branch},
				success: function(result) {
					  var string = '';
					  var sl_no = 1;
					  var  utype = '';
					$.each(JSON.parse(result), function( index, value ) {
						if(value.user_type == 'A'){
                          utype = '<span class="status-admin">Admin</span>';
					    }else if (value.user_type == 'M') {
                            utype = '<span class="status-manager">Manager</span>';
                        }else if (value.user_type == 'U') {
                             utype = '<span class="status-general">General User</span>';
                            }else if(value.user_type == '' || value.user_type == null){
                                var  utype = '';
                            }
						string += '<tr><td>'+ sl_no++ +'</td><td>' + value.branch_name + '</td><td>' + value.user_name + '</td><td>' + utype + '</td><td>' + value.user_id + '</td><td><a href="admins/user_edit_admin?user_id=' + value.user_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit fa-2x" style="color: #007bff"></i></a></td></tr>'
					});
					$('#user_list').html();
					$('#user_list').html(string);
					
				}
            });
}
    
</script>
<!-- DataTables Initialization -->
<script>
$(document).ready(function () {

    // Convert date to proper sorting format (dd-mm-yyyy → yyyy-mm-dd)
    $('#example tbody tr').each(function() {
        let dateText = $(this).find('td:eq(2)').text().trim();
        let parts = dateText.split('/');
        if(parts.length === 3){
            let sortableDate = parts[2] + '-' + parts[1] + '-' + parts[0]; // yyyy-mm-dd
            $(this).find('td:eq(2)').attr('data-order', sortableDate);
        }
    });

    $('#example').DataTable({
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100],
        "ordering": true,
        "searching": true,
        "info": true,
        "paging": true,

        // Default sort by Voucher Date (DESC)
        "order": [[2, "desc"]]
    });
});
</script>
