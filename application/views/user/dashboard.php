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
<div class="wraper">      
        <div class="row"> 
            <div class="col-lg-9 col-sm-12">
                <h1><strong>User List</strong></h1>
            </div>
        </div>
        <div class="col-lg-12 container contant-wraper">    
            <h3>

                <!-- <small><a href="<?php echo site_url("user_add");?>" class="btn btn-primary" style="width: 100px;">Add</a></small> -->
                <!-- <span class="confirm-div" style="float:right; color:green;"></span> -->

            </h3>

            <table class="table table-bordered table-hover">
                



            <h5>

               
				<center>
                    
				<input type="radio" id="css" name="user_status" checked  value="A"> <label for="html">Active</label>  &nbsp; &nbsp; &nbsp;
                <input type="radio" id="html" name="user_status" value="U"><label for="approve">Pending</label> &nbsp; &nbsp; &nbsp; 
				<input type="radio" id="css" name="user_status" value="D"> <label for="html">Inactive</label> 
            </center>
				
				</small>
				
                <span class="confirm-div" style="float:right; color:green;"></span>

            </h5>




                <thead>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Name</th>
						<th>Employee code</th>
						<th>Mobile NO</th>
                        <th>User Type</th>
                        <!-- <th>User Id</th> -->
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
                                <td><?php echo $u_dtls->user_name; ?></td>
								<td><?php echo $u_dtls->emp_code; ?></td>
								<td><?php echo $u_dtls->phone_no; ?></td>
                                <td><?php if($u_dtls->user_type == 'A'){
                                            echo '<span class="badge badge-success">Admin</span>';
                                          }
                                          elseif ($u_dtls->user_type == 'M') {
                                            echo '<span class="badge badge-warning">Manager</span>';
                                          }elseif ($u_dtls->user_type == 'D') {
                                            echo '<span class="badge badge-warning">Accountant</span>';
                                          }elseif ($u_dtls->user_type == 'U') {
                                            echo '<span class="badge badge-dark">General User</span>';
                                          }elseif ($u_dtls->user_type == 'C') {
                                            echo '<span class="badge badge-light"Accountant</span>';
                                          }
                                            ?>
                                </td>
                                <!-- <td><?php echo $u_dtls->user_id; ?></td> -->
                                
                                <td>
                                
                                    <a href="admins/user_edit?user_id=<?php echo $u_dtls->user_id; ?>" 
                                        data-toggle="tooltip"
                                        data-placement="bottom" 
                                        title="Edit"
                                    >

                                        <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                        
                                    </a>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                 <!--   <button 
                                        type="button"
                                        class="delete"
                                        id="<?php //echo $u_dtls->user_id; ?>"
                                        data-toggle="tooltip"
                                        data-placement="bottom" 
                                        title="Delete"
                                        >

                                        <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                    </button> -->
                                    
                                </td>

                            </tr>

                    <?php
                            
                            }

                        }

                        else {

                            echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";

                        }
                    ?>
                
                </tbody>

                <tfoot>

                <tr>
                    
                    <th>Sl. No.</th>
                    <th>Name</th>
                    <th>Employee code</th>
                    <th>Mobile NO</th>
                    <th>User Type</th>
                    <!-- <th>User Id</th> -->
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

    });

    <?php } ?>
</script>



<script>
   
    $(document).ready(function() {

    $('.confirm-div').hide();

    <?php if($this->session->flashdata('msg')){ ?>

    $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();
	
	<?php } ?>

    });
	
	$(document).ready( function (){

        $('input[type=radio][name=user_status]').on('change', function() {
			
			$.ajax({
				type: "GET",
				url: "<?php echo site_url('admins/get_userlist'); ?>",
				data: {
					user_status: $(this).val()
				},
				success: function(result) {
				   
					  var string = '';
					  var sl_no = 1;
					  var  utype = '';
					$.each(JSON.parse(result), function( index, value ) {
						
						if(value.user_type == 'A'){
                          utype = '<span class="badge badge-success">Admin</span>';
					    }else if (value.user_type == 'M') {
                            utype = '<span class="badge badge-warning">Manager</span>';
                        }else if (value.user_type == 'U') {
                             utype = '<span class="badge badge-dark">General User</span>';
                            }

						string += '<tr><td>'+ sl_no++ +'</td><td>' + value.user_name + '</td><td>' + value.emp_code + '</td><td>' + value.phone_no + '</td><td>' + utype + '</td><td><a href="admins/user_edit?user_id=' + value.user_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit fa-2x" style="color: #007bff"></i></a></td></tr>'
                     
					});
					$('#user_list').html();
					$('#user_list').html(string);
					
				}
            });
		  
		});

    });
	

    
</script>


