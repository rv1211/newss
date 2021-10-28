<style type="text/css">.sorting_disabled{width:100px !important;} .input {width: 120px;}</style>
<div class="page-container">
    <div class="page-content">
        <div class="content-wrapper ">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"> Manage Price</h5>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive" style="overflow-x: hidden;">
                                    <div class="tabbable">
                                        <div class="tab-content" style="min-height:400px">
                                            <form method="post" name="manage_shipping_charge" class="form_order_report" action="<?php echo base_url('manage-shipping-charge'); ?>" data-parsley-validate>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Logistic</label>
                                                        <select name="logistic_id" id="logistic_id" data-placeholder="Select Logistic *" class="select form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true" required="required">
                                                            <option value="">select logistic</option>
                                                            <?php foreach ($logistics as $single_logistic) {
	                                                            if (@$logistic_id == $single_logistic->id) {
		                                                                $select = 'selected';
                                                            	} else {
		                                                            $select = '';
	                                                            }?>
                                                                <option value="<?php echo $single_logistic->id; ?>" <?php echo $select; ?>><?php echo $single_logistic->logistic; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div  class="col-md-3">
                                                        <label >User</label>
                                                        <select name="user_id" id="user_id" data-placeholder="Select Logistic *" class="select form-control select2-hidden-accessible" tabindex="-1" aria-hidden="true" required="required">
                                                        <option value="">Select User</option>
                                                        <?php
                                                            
                                                        ?>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>&nbsp;&nbsp;</label><br>
                                                        <button class="btn btn-success" type="submit">Get Price Data</button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </form>

                                            <form method="post" name="shipping_charge"  action="<?php echo base_url('Price/update_shipping_price'); ?>" data-parsley-validate>
                                            <?php if (@$show != "") {
	?>
                                            <div class="tab-pane" style="display: block;">
                                                <div class="table-responsive">
                                                    <div id="all-manifested-order-table_wrapper" class="">
                                                        <div id="all-manifested-order-table_processing" class="dataTables_processing" style="display: none;">
                                                            <i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>
                                                        </div>
                                                            <table class="table table-xs table-bordered" id="order_report_table" style="width:100%">
                                                            <thead role="row">
                                                                <tr>
                                                                    <th><strong>Shipment Type</strong></th>
                                                                    <th><strong>Category</strong></th>
                                                                    <?php if ($logistic_data->logistic == 'Udaan Express') {?>
                                                                        <th><strong>Local</strong></th>
                                                                        <th><strong>Zonal 1</strong></th>
                                                                        <th><strong>Zonal 2</strong></th>
                                                                        <th><strong>National 1</strong></th>
                                                                        <th><strong>National 2</strong></th>
                                                                        <th><strong>National 3</strong></th>
                                                                        <th><strong>Special Zone</strong></th>
                                                                    <?php } else {?>
                                                                        <th><strong>Within-City</strong></th>
                                                                    <?php if ($logistic_data->logistic == 'DTDC') {?>
                                                                        <th><strong>Within-State</strong></th>
                                                                    <?php }?>

                                                                    <th><strong>Within-Zone</strong></th>
                                                                    <?php if ($logistic_data->logistic == 'Delhivery' || $logistic_data->logistic == 'Delhivery Express' || $logistic_data->logistic == 'Udaan Express') {?>
                                                                        <th><strong>Metro-Metro (National 1)</strong></th>
                                                                        <th><strong>Metro-Metro (National 2)</strong></th>
                                                                        <th><strong>Rest Of India (National 1)</strong></th>
                                                                        <th><strong>Rest Of India (National 2)</strong></th>
                                                                    <?php } else {?>
                                                                        <th><strong>Metro</strong></th>
                                                                        <th><strong>Rest Of India</strong></th>
                                                                    <?php }?>
                                                                        <th><strong>Special Zone</strong></th>
                                                                    <?php }?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($all_price_data as $single_price_data) {?>
                                                                    <tr>
                                                                        <td><strong><?php echo $single_price_data->shipment_type; ?></strong></td>
                                                                        <td><strong><?php echo $single_price_data->rule; ?></strong></td>
                                                                        <td>
                                                                            <input type="hidden" name="id[]" value="<?php echo @$single_price_data->id; ?>">
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_city[]" value="<?php echo $single_price_data->within_city; ?>">
                                                                        </td>
                                                                    <?php if ($logistic_data->logistic == 'DTDC') {?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_state[]" value="<?php echo $single_price_data->within_state; ?>">
                                                                        </td>
                                                                    <?php }?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_zone[]" value="<?php echo $single_price_data->within_zone; ?>">
                                                                        </td>
                                                                              <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="metro[]" value="<?php echo $single_price_data->metro; ?>">
                                                                        </td>
                                                                        <?php if ($logistic_data->logistic == 'Delhivery' || $logistic_data->logistic == 'Delhivery Express' || $logistic_data->logistic == 'Udaan Express') {?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="metro_2[]" value="<?php echo $single_price_data->metro_2; ?>">
                                                                        </td>
                                                                        <?php }?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="rest_of_india[]" value="<?php echo $single_price_data->rest_of_india; ?>">
                                                                        </td>
                                                                        <?php if ($logistic_data->logistic == 'Delhivery' || $logistic_data->logistic == 'Delhivery Express' || $logistic_data->logistic == 'Udaan Express') {?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="rest_of_india_2[]" value="<?php echo $single_price_data->rest_of_india_2; ?>">
                                                                        </td>
                                                                        <?php }?>
                                                                        <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="special_zone[]" value="<?php echo $single_price_data->special_zone; ?>">
                                                                        </td>
                                                                    </tr>
                                                                <?php }?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                            <?php if (@$logistic_id != "") {
	?>
                                                <div class="row" style="margin-top: 10px">
                                                    <?php if ($logistic_data->logistic != 'DTDC') {?>
                                                        <div class="col-md-2">
                                                            <label>COD Amount</label>
                                                            <input type="text" required onkeypress="return isNumberKey(event)" name="cod_price" class="form-control" value="<?php echo $logistic_data->cod_price; ?>">
                                                            <input type="hidden" name="logistic_id" value="<?php echo @$logistic_id; ?>">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>COD Percentage</label>
                                                            <input type="text" required onkeypress="return isNumberKey(event)" name="cod_percentage" class="form-control" value="<?php echo $logistic_data->cod_percentage; ?>">
                                                        </div>
                                                    <div class="col-md-6"></div>
                                                    <?php } else {
		echo '<div class="col-md-10"></div>';
	}?>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-primary" type="submit" style="margin-top: 10px">Update Data</button>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    function isNumberKey(evt)
                       {
                          var charCode = (evt.which) ? evt.which : evt.keyCode;
                          if (charCode != 46 && charCode > 31
                            && (charCode < 48 || charCode > 57))
                             return false;

                          return true;
                       }
                </script>