<?php     
    $detailstyle=$detailliclass=$trackingstyle=$trackingclass=$ndrstyle=$detailstyle=$ndrclass='style="display:none"';
    $button_type = $this->input->post('button_type');
    if ($button_type === 'order_detail') {$detailstyle = 'style="display:block;"'; $detailliclass = 'active';}
    elseif ($button_type === 'order_tracking') {$trackingstyle = 'style="display:block;"'; $trackingclass = 'active';}
?>
<!-- Modal -->
<style type="text/css">
.order_details {
    margin-right: 241px;
    margin-left: 147px;
}
</style>
<?php //dd($order_data);?>
<div class="modal-dialog modal-simple modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Order Details</h4>
        </div>
        <div class="modal-body">
            <!-- Example Tabs -->
            <div class="example-wrap ">
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                        <li class="nav-item details" role="presentation">
                            <a class="nav-link order_details order_nav modal_order_detail_tab <?php echo ($this->input->post('ord_type') == "detail")?'active':'' ?>"
                                data-target="#orderdetail_tab" data-toggle="tab" role="tab">Order Details</a>
                        </li>
                        <li class="nav-item tracking" role="presentation">
                            <a class="nav-link order_tracking order_nav modal_order_detail_tab <?php echo ($this->input->post('ord_type') == "track")?'active':'' ?>"
                                data-target="#ordertracking_tab" data-toggle="tab" role="tab">Order Tracking</a>
                        </li>
                    </ul>

                    <div class="tab-content pt-20">
                        <div style="display: <?php echo ($this->input->post('ord_type') == "track")?'none':'block' ?>"
                            id="orderdetail_tab" class="tab-pane_detail " <?php echo $detailstyle;?>>
                            <div class="tab-pane <?php echo $detailliclass; ?>" role="tabpanel">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="border:0px;width:145px;"><b>Vendor : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['sendername'];?></td>
                                            <td style="border:0px;width:140px;"><b>Vendor Mobile : </b></td>
                                            <td style="border:0px;width:170px;">
                                                <?php echo $order_data[0]['sendermobile'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Name: </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['name'];?></td>
                                            <td style="border:0px;"><b>Mobile</b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['mobile_no'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Address</b></td>
                                            <td style="border:0px;">
                                                <?php echo $order_data[0]['address_1'].$order_data[0]['address_2'];?>
                                            </td>
                                            <td style="border:0px;"><b>Pincode : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['pincode'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>City : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['city'];?></td>
                                            <td style="border:0px;"><b>State : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['state'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Order ID : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['order_no'];?></td>
                                            <td style="border:0px;"><b>Airwaybill No : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['awb_number'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Order Number : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['customer_order_no'];?>
                                            </td>
                                            <td style="border:0px;"><b>Order Type: </b></td>
                                            <?php if($order_data[0]['order_type'] == '1'){$order_type = "COD";}else{$order_type = "PREPAID";}?>
                                            <td style="border:0px;"><?php echo $order_type;?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Quantity : </b></td>
                                            <td style="border:0px;"><?php echo $order_data[0]['product_quantity'];?>
                                            </td>
                                            <td style="border:0px;"><b>COD Amount : </b></td>
                                            <td style="border:0px;">
                                                <?php echo $order_data[0]['cod_amount'];?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px;"><b>Product Details : </b></td>
                                            <td style="border:0px;" colspan="3">
                                                <?php echo $order_data[0]['product_name'];?></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="display: <?php echo ($this->input->post('ord_type') == "detail")?'none':'block' ?>"
                            id="ordertracking_tab" class="tab-pane_track " <?php echo $trackingstyle;?>>
                            <div class="tab-pane <?php echo $trackingclass; ?>" role="tabpanel">
                                <table class="table table-bordered table-hover table-striped" cellspacing="0"
                                    id="tracking_table">
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
                                                if(!empty($tracking_data)){
                                                    foreach ($tracking_data as $tracking_data_value) { ?>
                                        <tr>
                                            <td><?php echo $tracking_data_value['scan_date_time'];?></td>
                                            <td><?php echo $tracking_data_value['scan'];?></td>
                                            <td><?php echo $tracking_data_value['location'];?></td>
                                            <td><?php echo $tracking_data_value['remark'];?></td>

                                        </tr>
                                        <?php } } ?>

                                    </tbody>
                                </table>
                                <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#tracking_table').DataTable();

                                });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script type="text/javascript">
$(function() {
    $('.modal_order_detail_tab').click(function() {
        var orderdatatarget = $(this).data('target');
        if (orderdatatarget === '#orderdetail_tab') {
            $('#orderdetail_tab').show();
            $('#ordertracking_tab').hide();
        }
        if (orderdatatarget === '#ordertracking_tab') {
            $('#orderdetail_tab').hide();
            $('#ordertracking_tab').show();
            $('#ordertracking_tab').css('display', 'block');
            $('.order_tracking ').addClass('active');
            $('.order_details ').removeClass('active');
        }
    });
});
</script>