<div class="row">
    <div class="col-md-6">
        <div class="mb-15">

        </div>
    </div>
</div>
<table class="table table-bordered table-hover table-striped" cellspacing="0" id="tracking_table">
    <thead>
        <tr>
            <th>Scan Date</th>
            <th>Scan</th>
            <th>Location</th>
            <th>Remark</th>

        </tr>
    </thead>
    <tbody id="tbody">
        <?php //dd($tracking_data);
        if (!empty($tracking_data)) {
            foreach ($tracking_data as $tracking_data_value) { ?>
        <tr>
            <td><?php echo $tracking_data_value['scan_date_time']; ?></td>
            <td><?php echo $tracking_data_value['scan']; ?></td>
            <td><?php echo $tracking_data_value['location']; ?></td>
            <td><?php echo $tracking_data_value['remark']; ?></td>

        </tr>
        <?php }
        } ?>

    </tbody>
</table>

</form>

<script type="text/javascript">
$(document).ready(function() {
    $('#tracking_table').DataTable({
        "order": [
            [1, "desc"]
        ]
    });
});
</script>