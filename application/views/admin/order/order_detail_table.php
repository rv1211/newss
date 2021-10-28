<table class="table table-striped table-bordered">
    <tbody>
        <tr>
            <td style="border:0px;width:145px;"><b>Vendor : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['sendername']; ?></td>
            <td style="border:0px;width:140px;"><b>Vendor Mobile : </b></td>
            <td style="border:0px;width:170px;"><?php echo $order_data[0]['sendermobile']; ?></td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Name: </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['name']; ?></td>
            <td style="border:0px;"><b>Mobile</b></td>
            <td style="border:0px;"><?php echo $order_data[0]['mobile_no']; ?></td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Address</b></td>
            <td style="border:0px;" colspan="3"><?php echo $order_data[0]['address_1'] . $order_data[0]['address_2']; ?>
            </td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Order ID : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['order_no']; ?></td>
            <td style="border:0px;"><b>Airwaybill No : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['awb_number']; ?></td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Order Number : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['customer_order_no']; ?></td>
            <td style="border:0px;"><b>Order Type: </b></td>
            <?php if ($order_data[0]['order_type'] == '1') {
                $order_type = "COD";
            } else {
                $order_type = "PREPAID";
            } ?>
            <td style="border:0px;"><?php echo $order_type; ?></td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Quantity : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['product_quantity']; ?></td>
            <td style="border:0px;"><b>COD Amount : </b></td>
            <td style="border:0px;"><?php echo $order_data[0]['total_shipping_amount']; ?></td>
        </tr>
        <tr>
            <td style="border:0px;"><b>Product Details : </b></td>
            <td style="border:0px;" colspan="3"><?php echo $order_data[0]['product_name']; ?></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover table-striped" cellspacing="0" id="tracking_table" style="display:none;">
    <thead>
        <tr>
            <th>Scan Date</th>
            <th>Scan</th>
            <th>Location</th>
            <th>Remark</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <?php
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
        $('#tracking_table').DataTable();

    });
</script>