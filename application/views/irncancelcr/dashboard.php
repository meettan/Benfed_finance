<div class="wraper">      
        
        <div class="row">
            
            <div class="col-lg-9 col-sm-12">

                <h1><strong>IRN Cancel After 24 Hours</strong></h1>

            </div>

        </div>

        <div class="col-lg-12 container contant-wraper">    

            <h3>
		       <!-- <small><a href="<?php echo site_url("irncncl/advAdd");?>" class="btn btn-primary" style="width: 100px;">Add</a></small>
                    <span class="confirm-div" style="float:right; color:green;"></span> -->
                <!-- <div class="input-group" style="margin-left:75%;">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search..." id="search" style="z-index: 0;">
                </div> -->
            </h3> 

            <!-- <table class="table table-bordered table-hover" id="example"> -->
                <table class="mb-5 table">
                    <tbody>
                        <tr>
                            <td>
                            <div class="form-group">
                                <label for="serch">Search</label>
                                <input type="serch" class="form-control serch" id="serch" placeholder="Serch................">
                            </div>
                               
                            </td>
                            <td>
                            <div class="form-group">
                                <label for="fdate">From Date</label>
                                <input type="date" class="form-control" id="fdate">
                            </div>
                            </td>
                            <td>
                            <div class="form-group">
                                <label for="tdate">To Date</label>
                                <input type="date" class="form-control tdate" id="tdate">
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                        <th>Sl.No.</th>
                        <th>Acknowledgement No</th>
            			<th>Acknowledgement Date.</th>
                        <th>IRN.</th>
                        <th>View</th>
                        <!-- <th>Download</th> -->
                       
                    </tr>

                </thead>

                <tbody id="tableData"> 

                    
                    
                
                </tbody>

                <tfoot>
                    <tr>
                        <th>Sl.No.</th>
                        <th>Acknowledgement No</th>
            			<th>Acknowledgement Date.</th>
                        <th>IRN.</th>
                        <th>View</th>
                        <!-- <th>Download</th> -->
                    </tr>
                </tfoot>
            </table>
            <div class="pagination_link"></div>
        </div>
    </div>

<!-- <script>

    $(document).ready( function (){

        $('.delete').click(function () {
            
            var id = $(this).attr('id');
            
            var result = confirm("Do you really want to delete this record?");
        
            if(result) {

                window.location = "<?php echo site_url('adv/advDel?receipt_no="+id+"');?>";

            }
            
        });

    });
</script> -->

<script>

    $(document).ready(function() {

    <?php if($this->session->flashdata('msg')){ ?>
	window.alert("<?php echo $this->session->flashdata('msg'); ?>");
    <?php } ?>
    <?php if($this->session->flashdata('error')){ ?>
	window.alert("<?php echo $this->session->flashdata('error'); ?>");
    <?php } ?>
    });

    
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "pagingType": "full_numbers"
    } );
} );
</script>


<script>

// $( "#fdate" ).datepicker({
//     minDate: -3,
//     maxDate: 3
// });



//     $('#tdate').change(function(){
// //         var d = new Date($(this).val());
// //         // d.setDate($(this).val() - 5)
// //         d.setDate(d.getDate() - 3);
// //         $('#fdate').val(d.toLocaleString())

// // console.log(d.toLocaleString());





// var from = $("#fdate").val();
// var to = $("#tdate").val();



// const toDate = ((Date.parse(to)-3)) => {
//   const [day, month, year] = dateStr.split("-")
//   return new Date(year, month - 1, day)
// }

// var from = ().split("-")
// var f = new Date(from[2], from[1] - 1, from[0])

// console.log();

// if(Date.parse(to) ){
//    alert("Invalid Date Range");
// }
// else{
//    alert("Valid date Range");
// }
 //   });
</script>




<script>
	$(document).ready(function () {
				filter_test_data(1);

				function filter_test_data(page) {
					
					var action = 'fetch_data';
					let ftate = $('#fdate').val();
					let tdate = $('#tdate').val();
					let serch = $('#serch').val();
					

					$.ajax({
					//	url: "<?php echo site_url(); ?>/irncancr/" + page,
                        url: "<?php echo site_url(); ?>/Irncancel/irncanlcrs/"+ page,
						method: "get",
						dataType: "json",
						data: {
							action: action,
							serch: serch,
							formdate:ftate,
							todate:tdate
							
						},
						success: function (data) {
							$('#tableData').html(data.product_list);
							$('.pagination_link').html(data.pagination_link);
						}
					})
				}





        $(document).on('click', '.pagination_link li a', function(event){
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_test_data(page);
    	});

    // $('.common_selector').click(function(){
    //     filter_test_data(1);
    // });

	// $('.testSerch').click(function(){
    //     filter_test_data(1);
    // });
	$('.tdate').change(function(){
        filter_test_data(1);
    });

	$('.serch').keyup(function(){
        filter_test_data(1);
    });

});

</script>