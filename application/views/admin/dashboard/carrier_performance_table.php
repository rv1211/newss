<?php //dd($this->data);
?>
<div class="tcp-total-case-0">
	<div class="tcp-total-case-1">
		<div class="tcp-no-1 skeleton-off" id="total_count"><?= $total_count; ?></div>
		<div class="Total-Count-Copy">Total Count</div>
	</div>

	<div class="tcp-delivered">
		<div class="circular-chart pick-chart-1 Oval-4 skeleton-off" id="delivered_percent">
			<span class="min-chart easyPieChart tcp-rto-span" id="chart-pick-perf-4" data-percent="71">
				<span class="chart-content">
					<?php if (@$total_count > 0) {
						$delivered = ((@$delivered_count * 100) / @$total_count);
					} else {
						$delivered = 0;
					} ?>
					<span class="percent-1"><?= number_format(@$delivered) . '%'; ?>
					</span>
				</span>
			</span>
		</div>
	</div>
	<div class="tcp-total-case-1">
		<div class="tcp-no-1 skeleton-off" id="total_count"><?= $delivered_count; ?></div>
		<div class="Total-Count-Copy">Delivered</div>
	</div>

	<!-- <div class="tcp-delivered">
		<div class="circular-chart pick-chart-1 Oval-4 skeleton-off" id="delivered_percent">
			<span class="min-chart easyPieChart tcp-rto-span" id="chart-pick-perf-4" data-percent="71">
				<span class="chart-content">
					<?php if (@$total_count > 0) {
						$intransit = (($intransit_count * 100) / $total_count);
					} else {
						$intransit = 0;
					} ?>
					<span class="percent-1"><?= number_format($intransit) . '%'; ?></span>
				</span>
			</span>
		</div>
	</div> -->
	<!-- <div class="tcp-total-case-1">
		<div class="tcp-no-1 skeleton-off" id="total_count"><?= $intransit_count; ?></div>
		<div class="Total-Count-Copy">In Transit</div>
	</div>

	<div class="tcp-delivered">
		<div class="circular-chart pick-chart-1 Oval-4 skeleton-off" id="delivered_percent">
			<span class="min-chart easyPieChart tcp-rto-span" id="chart-pick-perf-4" data-percent="71">
				<span class="chart-content">
					<?php if (@$total_count > 0) {
						$ofd = (($ofd_count * 100) / $total_count);
					} else {
						$ofd = 0;
					} ?>
					<span class="percent-1"><?= number_format($ofd) . '%'; ?></span>
				</span>
			</span>
		</div>
	</div>
	<div class="tcp-total-case-1">
		<div class="tcp-no-1 skeleton-off" id="total_count" style="margin-right: 8px;"><?= $ofd_count; ?></div>
		<div class="Total-Count-Copy">OFD</div>
	</div> -->

	<div class="tcp-delivered">
		<div class="circular-chart pick-chart-1 Oval-4 skeleton-off" id="delivered_percent">
			<span class="min-chart easyPieChart tcp-rto-span" id="chart-pick-perf-4" data-percent="71">
				<span class="chart-content">
					<?php if (@$total_count > 0) {
						$rto = (($rto_count * 100) / $total_count);
					} else {
						$rto = 0;
					} ?>
					<span class="percent-1"><?= number_format($rto) . '%'; ?></span>
				</span>
			</span>
		</div>
	</div>
	<div class="tcp-total-case-1">
		<div class="tcp-no-1 skeleton-off" id="total_count" style="margin-right: 8px;"><?= $rto_count; ?></div>
		<div class="Total-Count-Copy">RTO</div>
	</div>
</div>

<div class="table-responsive">
	<table id="carrier_performance_table" class="pop-of-prod-table no-footer dataTable table table-striped " style="overflow: hidden;" width="96%" role="grid">
		<thead class="pop-of-prod-table-head carrier-thead">
			<tr>
				<th class="text-center">Logistic</th>
				<th class="text-center">Total</th>
				<th class="text-center">Delivered</th>
				<!-- <th class="text-center">In Transit</th> -->
				<!-- <th class="text-center">OFD</th> -->
				<th class="text-center">RTO</th>
			</tr>
		</thead>
		<tbody id="popular_product_body">
			<?php $total = $intransit = $ofd = $delivered =  $rto = $rto1 = $rto2 = $rto3 = $rto4 = $rto5 = 0;
			if (!empty($carrier_performance_data)) {
				foreach ($carrier_performance_data as $value) {
			?>

					<tr class="odd">
						<td class="carrier_performance_td"><?= $value['logistic'] ?></td>
						<td class="carrier_performance_td">
							<?php if ($total_count > 0) {
								$total_pr = (($value['total'] * 100) / $total_count);
							} else {
								$total_pr = 0;
							}
							echo number_format($total_pr, 2) . "% (" . $value['total'] . ")"; ?>
						</td>
						<td class="carrier_performance_td">
							<?php if ($total_count > 0) {
								$delivered_pr = (($value['6'] * 100) / $total_count);
							} else {
								$delivered_pr = 0;
							}
							echo number_format($delivered_pr, 2) . "% (" . $value['6'] . ")"; ?>
						</td>
						<!-- <td class="carrier_performance_td">
							<?php if ($total_count > 0) {
								$intransit_pr = (($value['3'] * 100) / $total_count);
							} else {
								$intransit_pr = 0;
							}
							echo number_format($intransit_pr, 2) . "% (" . $value['3'] . ")"; ?>
						</td>
						<td class="carrier_performance_td">
							<?php if ($total_count > 0) {
								$ofd_pr = (($value['5'] * 100) / $total_count);
							} else {
								$ofd_pr = 0;
							}
							echo number_format($ofd_pr, 2) . "% (" . $value['5'] . ")"; ?>
						</td> -->
						<td class="carrier_performance_td">
							<?php $sum = ($value['9'] + $value['10'] + $value['11'] + $value['12'] + $value['13'] + $value['14']);
							if ($total_count > 0) {
								$rto_pr = (($sum * 100) / $total_count);
							} else {
								$rto_pr = 0;
							}
							echo number_format($rto_pr, 2) . "% (" . $sum . ")";
							?>
						</td>
					</tr>
				<?php
					$total += $value['total'];
					$intransit += $value['3'];
					$ofd += $value['5'];
					$delivered += $value['6'];
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
				<th class="carrier_performance_td">Total</th>
				<th class="carrier_performance_td">
					<?php if ($total_count > 0) {
						$total_pr = (($total * 100) / $total_count);
					} else {
						$total_pr = 0;
					}
					echo number_format($total_pr, 2) . "% (" . $total . ")"; ?>
				</th>
				<th class="carrier_performance_td">
					<?php if ($total_count > 0) {
						$delivered_pr = (($delivered * 100) / $total_count);
					} else {
						$total_count = 0;
					}
					echo number_format($delivered_pr, 2) . "% (" . $delivered . ")"; ?>
				</th>
				<th class="carrier_performance_td">
					<?php if ($total_count > 0) {
						$intransit_pr = (($intransit * 100) / $total_count);
					} else {
						$intransit_pr = 0;
					}
					echo number_format($intransit_pr, 2) . "% (" . $intransit . ")"; ?>
				</th>
			</tr>
		</tfoot>
	<?php } else { ?>
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
</div>
<?php if (!empty($carrier_performance_data)) { ?>
	<script>
		$(function() {

			$('#carrier_performance_table').DataTable({
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
