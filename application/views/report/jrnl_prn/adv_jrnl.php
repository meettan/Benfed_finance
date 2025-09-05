<style>
	table {
		border-collapse: collapse;
	}

	table,
	td,
	th {
		border: 1px solid #dddddd;
		padding: 6px;
		font-size: 14px;
	}

	th {
		text-align: center;
	}

	tr:hover {
		background-color: #f5f5f5;
	}

	/* Always hide DataTables buttons (Excel, PDF, etc.) */
	.dt-buttons {
		display: none !important;
	}

	@media print {
		/* Hide buttons during print */
		.dt-buttons,
		.print-btn,
		.pdf-btn {
			display: none !important;
			visibility: hidden !important;
		}
	}
</style>

<script>
	function printDiv() {
		var divToPrint = document.getElementById('divToPrint');
		var WindowObject = window.open('', 'Print-Window');
		WindowObject.document.open();
		WindowObject.document.writeln('<!DOCTYPE html>');
		WindowObject.document.writeln('<html><head><title>Cash Voucher</title><style type="text/css">');

		// Inject CSS into popup
		WindowObject.document.writeln(
			'table { border-collapse: collapse; }' +
			'table, td, th { border: 1px solid #dddddd; padding: 6px; font-size: 14px; }' +
			'th { text-align: center; }' +
			'tr:hover { background-color: #f5f5f5; }' +
			'.dt-buttons, .print-btn, .pdf-btn { display: none !important; visibility: hidden !important; }' +
			'.center { text-align: center; }' +
			'body { padding: 0; margin:0; }' +
			'.billPrintWrapper { padding: 15px; color: #333; }'
		);

		WindowObject.document.writeln('</style></head><body onload="window.print()">');
		WindowObject.document.writeln(divToPrint.innerHTML);
		WindowObject.document.writeln('</body></html>');
		WindowObject.document.close();

		setTimeout(function () {
			WindowObject.close();
		}, 10);
	}

	// Save as PDF (html2pdf.js)
	function savePDF() {
		var element = document.getElementById('divToPrint');
		var opt = {
			margin: 0.5,
			filename: 'Cash_Voucher.pdf',
			image: { type: 'jpeg', quality: 0.98 },
			html2canvas: { scale: 2 },
			jsPDF: { unit: 'in', format: 'A4', orientation: 'portrait' }
		};
		html2pdf().set(opt).from(element).save();
	}
</script>

<div class="wraper">
	<div class="col-lg-12 container contant-wraper">

		<div id="divToPrint">
			<div class="billPrintWrapper">
				<div style="text-align:center;">
					<h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
					<h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
				</div>
				<br>

				<?php foreach ($voucher as $vou); { ?>
					<div class="printTop023">
						<div class="leftNo"><b>Voucher ID: </b> <?= $vou->voucher_id ?></div>
						<div class="rightDate"><b>Dated:</b> <?php echo date("d/m/Y", strtotime($vou->voucher_date)); ?></div><br>
						<?php if ($vou->transfer_type != 'T') { ?>
							<div class="leftNo"><b>Branch: </b><?= $vou->branch_name ?></div>
						<?php } ?>
						<div class="rightDate"><b>Status:</b>
							<?php if ($vou->approval_status == 'A') { echo 'Approved'; } elseif ($vou->approval_status == 'U') { echo 'Unpproved'; } ?>
						</div>
					</div>

					<div class="tableArea">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" id="example">
							<thead>
								<tr>
									<th>A/C Head</th>
									<th>A/C Code</th>
									<th>Trans Type</th>
									<th>Dr Amount</th>
									<th>Cr Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$dr_tot  = 0.00;
								$cr_tot  = 0.00;
								$remarks = '';
								if ($voucher) {
									foreach ($voucher as $adv) {
										if ($adv->voucher_id == $vou->voucher_id) {
											$remarks = $adv->remarks;
								?>
											<tr>
												<td><?= $adv->ac_name; ?></td>
												<td><?= $adv->benfed_ac_code; ?></td>
												<td><?= $adv->dr_cr_flag; ?></td>
												<td>
													<?php if ($adv->dr_cr_flag == 'Dr') {
														echo $adv->amount;
														$dr_tot += $adv->amount;
													} else {
														echo '0.00';
													} ?>
												</td>
												<td>
													<?php if ($adv->dr_cr_flag == 'Cr') {
														echo $adv->amount;
														$cr_tot += $adv->amount;
													} else {
														echo '0.00';
													} ?>
												</td>
											</tr>
								<?php } } } ?>
							</tbody>
							<?php
							$dr_tot = number_format((float)$dr_tot, 2, '.', '');
							$cr_tot = number_format((float)$cr_tot, 2, '.', '');
							$style_c = ($dr_tot != $cr_tot) ? '#FF0000' : '';
							?>
							<tfoot>
								<tr>
									<th style="background-color:<?= $style_c ?>">Total:</th>
									<th style="background-color:<?= $style_c ?>"></th>
									<th style="background-color:<?= $style_c ?>"></th>
									<th style="background-color:<?= $style_c ?>"><?= $dr_tot ?></th>
									<th style="background-color:<?= $style_c ?>"><?= $cr_tot ?></th>
								</tr>
							</tfoot>
						</table>
					</div>

					<br>
					<div class="remarks"><b>Remarks: </b> <?= $remarks ?></div>
					<br>

					<div class="printTop023">
						<div class="leftNo"><b>Created By</b>: <?= $vou->created_by; ?></div>
						<div class="rightDate"><b>Approved By</b>: <?= $vou->approved_by; ?></div> <br>
						<div class="leftNo"><b>Created Date</b>: <?= date("d/m/Y H:i:s", strtotime($vou->created_dt)); ?></div>
						<div class="rightDate"><b>Approved Date</b>:
							<?php if (!empty($vou->approved_dt) && $vou->approved_dt != '0000-00-00 00:00:00') { echo date("d/m/Y H:i:s", strtotime($vou->approved_dt)); } ?>
						</div>
					</div>
					<hr style="border-top: 4px dashed #bbb">
				<?php } ?>
			</div>
		</div>

		<div style="text-align: center; margin-top:10px;">
			<button class="btn btn-primary print-btn" type="button" onclick="printDiv();">Print</button>
			<button class="btn btn-danger pdf-btn" type="button" onclick="savePDF();">Save as PDF</button>
		</div>
	</div>
</div>

<!-- DataTables & Buttons -->
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<!-- html2pdf.js for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
	$('#example').dataTable({
		destroy: true,
		searching: false,
		ordering: false,
		paging: false,
		scrollX: false,
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				title: 'Cash Voucher',
				text: 'Export to Excel'
			}
		]
	});
</script>
