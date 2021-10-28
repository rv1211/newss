<style type="text/css">.sorting_disabled{width:100px !important;} .input {width: 120px;}</style>
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Price</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Manage Price</li>
        </ol>
    </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Manage Price
                    <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="page-content">
                        <div class="content-wrapper ">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive" style="overflow-x: hidden;">
                                            <form method="post" name="manage_shipping_charge" class="form_order_report" action="<?php echo base_url('manage-price'); ?>" data-parsley-validate>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                    <h4 class="example-">User</h4>
                                                    <select name="user_id" id="user_id" data-placeholder="Select Logistic *" class="select form-control select2" tabindex="-1" aria-hidden="true" >
                                                            <option value="0">select user</option>
                                                            <?php foreach ($users as $user) {
                                                                if (@$user_id == $user->id) {
                                                                    $select = 'selected';
                                                                } else {
                                                                    $select = '';
                                                                }
                                                            ?>
                                                            <option value="<?php echo $user->id; ?>" <?php echo $select; ?>><?php echo $user->email; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4 class="example-">Logistic Name</h4>
                                                        <select name="logistic_id" id="logistic_id" data-placeholder="Select Logistic *" class="select form-control select2" tabindex="-1" aria-hidden="true" required="required">
                                                            <option value="">select logistic</option>
                                                            <?php foreach ($assign_logistic_data as $price) {
                                                                if (@$logistic_id == $price->id) {
                                                                    $select = 'selected';
                                                                } else {
                                                                    $select = '';
                                                                }
                                                            ?>
                                                            <option value="<?php echo $price->id; ?>" <?php echo $select; ?>><?php echo $price->logistic_name; ?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label>&nbsp;&nbsp;</label><br>
                                                        <button class="btn btn-success" type="submit">Get Price Data</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
            <!-- Panel Form Elements -->
            <div class="panel" id="logistic_price_table">
                <div class="panel-body container-fluid">
                    <div class="page-content">
                        <div class="content-wrapper ">
                            <div class="content">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive" style="overflow-x: hidden;">
                                            <h5 class="error">Please Enter data Excluding GST</h5>
                                            <form method="post" name="shipping_charge"  action="<?php echo base_url('Price/update_shipping_price'); ?>" data-parsley-validate>
                                                <?php if (!empty($all_price_data)) { ?>
                                                    <div class="tab-pane"  style="display: block;">
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
                                                                            <th><strong>Within-City</strong></th>
                                                                            <th><strong>Within-State</strong></th>
                                                                            <th><strong>Within-Zone</strong></th>
                                                                            <th><strong>Metro-Metro (National 1)</strong></th>
                                                                            <th><strong>Metro-Metro (National 2)</strong></th>
                                                                            <th><strong>Rest Of India (National 1)</strong></th>
                                                                            <th><strong>Rest Of India (National 2)</strong></th>
                                                                            <th><strong>Special Zone</strong></th>
                                                                            <th><strong>Jammnu And kashmir</strong></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($all_price_data as $single_price_data) { ?>
                                                                        <?php //dd($all_price_data); ?>
                                                                        <tr>
                                                                            <td>
                                                                                    <input type="hidden" name="shipment_type" value="<?= $single_price_data['shipment_type'] ?>">
                                                                                <?php if($single_price_data['shipment_type'] == 0): ?>
                                                                                    <strong>Forward</strong>
                                                                                <?php else :?>
                                                                                    <strong>Reverse</strong>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td><strong><?php echo $single_price_data['name']; ?></strong></td>
                                                                            <td>
                                                                                <input type="hidden" name="id[]" value="<?php echo @$single_price_data['id']; ?>">
                                                                                <input type="hidden" name="rules[]" value="<?= @$single_price_data['rule_name']; ?>">
                                                                                <input type="hidden" name="rule_index[]" value="<?= @$single_price_data['rule_index']; ?>">
                                                                                <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_city[]" value="<?php echo $single_price_data['within_city']; ?>">
                                                                            </td>
                                                                            
                                                                                <td>
                                                                                    <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_state[]" value="<?php echo $single_price_data['within_state']; ?>">
                                                                                </td>
                                                                            
                                                                            <td>
                                                                                <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="within_zone[]" value="<?php echo $single_price_data['within_zone']; ?>">
                                                                            </td>
                                                                            <td>
                                                                                <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="metro[]" value="<?php echo $single_price_data['metro']; ?>">
                                                                            </td>
                                                                          
                                                                                <td>
                                                                                    <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="metro_2[]" value="<?php echo $single_price_data['metro_2']; ?>">
                                                                                </td>
                                                                           
                                                                            <td>
                                                                                <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="rest_of_india[]" value="<?php echo $single_price_data['rest_of_india']; ?>">
                                                                            </td>
                                                                          
                                                                                <td>
                                                                                    <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="rest_of_india_2[]" value="<?php echo $single_price_data['rest_of_india_2']; ?>">
                                                                                </td>
                                                                          
                                                                            <td>
                                                                                <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="special_zone[]" value="<?php echo $single_price_data['special_zone']; ?>">
                                                                            </td>
                                                                            <td>
                                                                            <input class="input" type="text" required onkeypress="return isNumberKey(event)" name="special_zone[]" value="<?php echo $single_price_data['special_zone']; ?>">
                                                                            </td>
                                                                        </tr>
                                                                        <?php }?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <?php if (!empty($all_price_data) && @$logistic_id != "") { ?>
                                                    <div class="row" style="margin-top: 10px">
                                                       
                                                            <div class="col-md-2">
                                                                <label>COD Amount</label>
                                                                <input type="text" required onkeypress="return isNumberKey(event)" name="cod_price" class="form-control" value="<?php echo $all_price_data[0]['cod_price']; ?>">
                                                                <input type="hidden" name="logistic_id" value="<?php echo @$logistic_id; ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>COD Percentage</label>
                                                                <input type="text" required onkeypress="return isNumberKey(event)" name="cod_percentage" class="form-control" value="<?php echo $all_price_data[0]['cod_percentage']; ?>">
                                                            </div>
                                                            <div class="col-md-6"></div>
                                                            <input type="hidden" name="logistic_id" value="<?= $logistic_id?>">
                                                            <input type="hidden" name="user_id" value=<?= $user_id?>>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-primary" type="submit" style="margin-top: 10px">Update Data</button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
        </div>
    </div>
</div>
<!-- </div> -->


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