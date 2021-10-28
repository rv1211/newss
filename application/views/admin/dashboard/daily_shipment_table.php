<table id="daily_shipment_table" class="pop-of-prod-table no-footer dataTable table table-striped" style="overflow: hidden;" width="96%" role="grid">
	<thead class="pop-of-prod-table-head carrier-thead">
		<tr>
			<th class="text-center">Date</th>
			<th class="text-center">New Order</th>
			<!-- <th class="text-center">Pickup</th> -->
			<th class="text-center">In Transit</th>
			<th class="text-center">OFD</th>
			<th class="text-center">Delivered</th>
			<th class="text-center">Undelivered</th>
			<th class="text-center">RTO</th>
		</tr>
	</thead>
	<tbody id="popular_product_body">
		<?php $new_order = $pickup = $intransit = $ofd = $delivered = $undelivered = $rto = $rto1 = $rto2 = $rto3 = $rto4 = $rto5 = 0;
		if (!empty($orderCountData)) {
			foreach ($orderCountData as $value) { ?>

				<tr class="odd">
					<td class="text-center"><?= $value['date']; ?></td>
					<td class="text-center"><?= $value['1']; ?></td>
					<!-- <td class="text-center"><?php // $value['2']; 
													?></td> -->
					<td class="text-center"><?= $value['3']; ?></td>
					<td class="text-center"><?= $value['5']; ?></td>
					<td class="text-center"><?= $value['6']; ?></td>
					<td class="text-center"><?= $value['18']; ?></td>
					<td class="text-center">
						<?= ($value['9'] + $value['10'] + $value['11'] + $value['12'] + $value['13'] + $value['14']); ?>
					</td>
				</tr>
			<?php $new_order += $value['1'];
				// $pickup+=$value['2'];
				$intransit += $value['3'];
				$ofd += $value['5'];
				$delivered += $value['6'];
				$undelivered += $value['18'];
				$rto += $value['9'];
				$rto1 += $value['10'];
				$rto2 += $value['11'];
				$rto3 += $value['12'];
				$rto4 += $value['13'];
				$rto5 += $value['14'];
			}
			?>
	</tbody>
	<tfoot>
		<tr>
			<th class="text-center">Total</th>
			<th class="text-center"><?= @$new_order ?></th>
			<!-- <th class="text-center"><?= @$pickup ?></th> -->
			<th class="text-center"><?= @$intransit ?></th>
			<th class="text-center"><?= @$ofd ?></th>
			<th class="text-center"><?= @$delivered ?></th>
			<th class="text-center"><?= @$undelivered ?></th>
			<th class="text-center"><?= (@$rto + @$rto1 + @$rto2 + @$rto3 + @$rto4 + @$rto5); ?></th>
		</tr>
	</tfoot>
<?php
		} else { ?>
	<tbody>
		<tr class="odd">
			<td valign="top" colspan="8" class="dataTables_empty">
				<div class="text-center mt-4 mb-4 pt-2 pb-2"><img src="<?= base_url('assets/images/dashboard/search.svg'); ?>" class="no-record-found mb-2 dash-img-not-found">
					<p class="no-margin text-semibold font-16 tbody-nrf"> No Record
						Found</p>
				</div>
			</td>
		</tr>

	<?php } ?>
	</tbody>

</table>
<?php if (!empty($orderCountData)) { ?>
	<script>
		$(function() {

			$('#daily_shipment_table').DataTable({
				"bLengthChange": false,
				"paging": true,
				"searching": false,
				"pageLength": 5,
				"order": [
					[0, "desc"]
				],
			});
		});
	</script>
<?php } ?>
