<style type="text/css">
@media (min-width: 769px) {
    .modal-dialog {
        width: 850px !important;
        margin: 30px auto;
    }
}

.modal-header {
    padding: 10px !important;
}

.modal-tab-link {
    font-size: 10px !important;
}

.modal-order-title {
    font-weight: normal !important;
    font-size: 16px !important;
    margin-left: 10px;
    margin-top: 10px
}

.display-block {
    display: block !important
}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">
        COD Remittance Detail
    </h4>
</div>
<div class="portlet light bordered">
    <div class="portlet-body">
        <div class="">
            <div class="form-group">
                <div>
                    <table class="table table-striped table-bordered cod-export" id="cod_remittance_order_detail_table"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Airwaybill Number</th>
                                <th>COD Amount</th>
                                <th>Delivery Date</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cod_order_list as $cod_single_order) {?>
                            <tr>
                                <td><?php echo $cod_single_order['awb_number']; ?></td>
                                <td><?php echo $cod_single_order['cod_amount']; ?></td>
                                <td><?php echo date("d-m-Y", strtotime($cod_single_order['delivery_date'])); ?></td>
                                <td><?php echo date("d-m-Y", strtotime($cod_single_order['is_cod_remittance_close_datetime'])); ?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
    $('.cod-export').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'csv',
            filename: 'cod-remittance-order',
            text: 'Export',
            className: 'btn btn-sm btn-primary'

        }]

    });
});
</script>