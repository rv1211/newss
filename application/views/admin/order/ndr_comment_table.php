<style>
	.ndr-export {
		float: right !important;
		top: -52px !important;
	}

	.add-row-btn {
		margin-left: 88px !important;
	}

	.dataTables_filter {
		margin-top: -47px !important;
	}

	.modal-header {
		margin-bottom: 24px;
	}
</style>
<form name="ndr_table" id="ndr_table" method="POST" action="<?php echo base_url('insert-ndr-comments'); ?>">
	<div class="row">
		<div class="col-md-6">
			<div class="mb-15">
				<input type="hidden" name="orderid" value="<?php echo $order_id; ?>">
				<?php if (($this->input->post('other_tabs') == "other_tabs"  && $this->session->userdata('userType') != '4') || $this->input->post('other_tabs') == "ndr_tab") { ?>
					<button id="addToTable" class="btn btn-primary add-row-btn" type="button">
						<i class="icon md-plus" aria-hidden="true"></i> Add row
					</button>
				<?php } ?>
			</div>
		</div>
	</div>
	<table class="table table-bordered table-hover table-striped ndr_table" cellspacing="0" id="exampleAddRow">
		<thead>
			<tr>
				<th>NDR Date</th>
				<th>User</th>
				<th>Provider Comment</th>
				<th>PD Comment</th>
				<th>Client Comment</th>
				<?php if (($this->input->post('other_tabs') == "other_tabs"  && $this->session->userdata('userType') != '4') ||          $this->input->post('other_tabs') == "ndr_tab") { ?>
					<th>Action</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody id="ndr_tbody">
			<?php
			//if(!empty($comment_data)){
			foreach ($comment_data as $comment_data_value) { ?>
				<tr>
					<td><?php echo $comment_data_value['created_date']; ?></td>
					<td><span><?php echo $comment_data_value['sender_name']; ?></span><br>
						<span><?php echo $comment_data_value['user_name']; ?></span>
					</td>

					<?php if ($this->session->userdata('userType') == '1') {
						if ($comment_data_value['provider_comment'] == "") { ?>
							<td><input type='text' id='provider_cmnt' name='p_comment'></td>
						<?php } else { ?>
							<td><?php echo $comment_data_value['provider_comment']; ?></td>
						<?php }
						if ($comment_data_value['admin_comment'] == "") { ?>
							<td><input type='text' id='pd_cmnt' name='pd_comment'></td>
						<?php } else { ?>
							<td><?php echo $comment_data_value['admin_comment']; ?></td>
						<?php } ?>
						<td><?php echo $comment_data_value['client_comment']; ?></td>
						<?php if ($comment_data_value['provider_comment'] != "" && $comment_data_value['admin_comment'] != "") { ?>
							<td></td>
						<?php } else { ?>
							<td><button type='submit' class='btn btn-primary waves-effect waves-classic' name='submit' id='save_ndr_cmnt' value="<?= $comment_data_value['ndr_comment_detail_id']; ?>" s>Save</button></td>
						<?php } ?>

					<?php  } else { ?>
						<td><?php echo $comment_data_value['provider_comment']; ?></td>
						<td><?php echo $comment_data_value['admin_comment']; ?></td>
						<?php if ($comment_data_value['client_comment'] == "" && $this->input->post('other_tabs') != "other_tabs") { ?>
							<td><input type='text' name='client_comment'></td>
						<?php } else { ?>
							<td><?php echo $comment_data_value['client_comment']; ?></td>
						<?php } ?>
						<?php if (($this->input->post('other_tabs') == "other_tabs"  && $this->session->userdata('userType') != '4') || $this->input->post('other_tabs') == "ndr_tab") {
							if ($comment_data_value['client_comment'] != "") { ?>
								<td></td>
							<?php } else { ?>
								<td><button type='submit' class='btn btn-primary waves-effect waves-classic' id='save_ndr_cmnt' name='submit' value="<?= $comment_data_value['ndr_comment_detail_id']; ?>">Save</button></td>
						<?php }
						} ?>
					<?php } ?>
				</tr>
			<?php } //} 
			?>

		</tbody>
	</table>

</form>

<script type="text/javascript">
	$(function() {
		var table = $('#exampleAddRow').DataTable({
			dom: 'Bfrtip',
			buttons: [{
				extend: 'csv',
				filename: 'NDR Report',
				text: 'Export',
				className: 'btn btn-primary ndr-export',
				exportOptions: {
					columns: [0, 1, 2, 3, 4]
				}
			}]
		});

		var counter = 1;

		$('#addToTable').on('click', function() {
			var userType = <?php echo json_encode($this->session->userdata('userType')); ?>;
			var username = <?php echo json_encode($this->session->userdata('userName')); ?>;
			var today = new Date();
			var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var dateTime = date + ' ' + time;
			if (userType == '1') {
				table.row.add([
					"<td><lable>" + dateTime + "</lable></td>",
					"<td><lable>" + username + "</lable></td>",
					"<td><input type='text' id='provider_cmnt' name='p_comment' ><label class='text-danger p_cmnt_error'></label></td>",
					"<td><input type='text'  id='pd_cmnt' name='pd_comment'><label class='text-danger pd_cmnt_error '></label></td>",
					"<td><lable></lable></td>",
					"<td><button type='submit' class='btn btn-primary waves-effect waves-classic' name='submit' id='save_ndr_cmnt'>Save</button><button name='delete' class='btn btn-danger waves-effect waves-classic' id='delete_btn' style='width: 64px;margin-top: 1px;'>Delete</button></td>"
				]).draw(false);
			} else {
				table.row.add([
					"<td><lable>" + dateTime + "</lable></td>",
					"<td><lable>" + username + "</lable></td>",
					"<td><label></label></td>",
					"<td><lable></lable></td>",
					"<td><input type='text' name='client_comment'></td>",
					"<td><button type='submit' class='btn btn-primary waves-effect waves-classic' name='submit' id='save_ndr_cmnt'>Save</button><button name='delete' class='btn btn-danger waves-effect waves-classic' id='delete_btn' style='width: 64px;margin-top: 1px;'>Delete</button></td>"
				]).draw(false);
			}
			counter++;
		});

		$(document).delegate('#delete_btn', 'click', function() {
			table
				.row($(this).closest('tr'))
				.remove()
				.draw();
			counter--;
		});

		$(document).delegate('#save_ndr_cmnt', 'click', function() {
			var userType = <?php echo json_encode($this->session->userdata('userType')); ?>;
			if (userType == '1') {
				var provider_cmnt = $('#provider_cmnt').val();
				var pd_cmnt = $('#pd_cmnt').val();

				if (provider_cmnt == "" || pd_cmnt == "") {
					if (provider_cmnt == "") {
						$('.p_cmnt_error').text('Please Enter Provider comment OR Pd comment');
					} else {
						$('.pd_cmnt_error').text('Please Enter Provider comment OR Pd comment');
					}
				}
			}

		});



	});
</script>
