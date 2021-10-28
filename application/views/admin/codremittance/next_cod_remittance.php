<div class="page">
    <div class="page-header">
        <h1 class="page-title">COD Remittance</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">COD Remittance</a></li>
            <!-- <li class="breadcrumb-item active">COD Remittance</li> -->
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="portlet-body form">
                    <div class="form-body">
                        <form class="horizontal-form" id="next_cod_remittance_form" method="POST"
                            enctype="multipart/form-data" action="<?php echo base_url('next-cod-remittance-list'); ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-material">
                                        <label class="form-control-label">From Date</label>
                                        <input type="date" name="from_date" id="cod_remittance_from_date"
                                            class="form-control" required="required" value="<?php echo @$from_date; ?>"
                                            placeholder="Select From Date..">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-material">
                                        <label class="form-control-label">To Date</label>
                                        <input type="date" name="to_date" id="cod_remittance_to_date"
                                            class="form-control " required="required" value="<?php echo @$to_date; ?>"
                                            placeholder="Select To Date..">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group form-material">
                                        <button type="submit" name="submit" value="Get List" class="btn btn-primary"
                                            id="get_next_cod_remittance_list" style="margin-top: 22px">Get List</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php if (@$from_date != "" && @$to_date != "") { ?>
                        <hr>
                        <form method="POST" action="<?php echo base_url('insert-cod-remmitance-data'); ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-material">
                                        <table class="table" id="next_cod_remittance_list_table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="select_all_cod_remmitance_cus"></th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Email</th>
                                                    <th>Order Count</th>
                                                    <th>COD Remmitance Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($customer_list)){
                                            foreach($customer_list as $val){
                                                ?>
                                                <tr>
                                                    <th><input type="checkbox" name="checkbox_cod_remmitance[]"
                                                            class="select_single_cod_remmitance_cus"
                                                            data-id="<?= $val['id']; ?>" value="<?= $val['id']; ?>">
                                                    </th>
                                                    <th><?= $val['name']; ?></th>
                                                    <th><?= $val['email']; ?></th>
                                                    <th><?php if(!empty($val['order_count'])){ echo $val['order_count']; }else{ echo '0'; }  ?><input
                                                            type="hidden"
                                                            name="checkbox_cod_remmitance_order_count[<?= $val['id']; ?>]"
                                                            value="<?php if(!empty($val['order_count'])){ echo $val['order_count']; }else{ echo '0';} ?>">
                                                    </th>
                                                    <th><?php if(!empty($val['cod_amount'])){
                                                        echo number_format($val['cod_amount'], 2, '.', ',');
                                                    }else{ echo '0.00'; } ?><input type="hidden"
                                                            name="checkbox_cod_remmitance_cod_amount[<?= $val['id']; ?>]"
                                                            value="<?php if(!empty($val['cod_amount'])){ echo $val['cod_amount']; }else{ echo '0.00'; } ?>">
                                                    </th>
                                                </tr>
                                                <?php
                                            }
                                        } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="form-actions right">
                        <button type="submit" class="btn btn-primary" name="submit" value="Submit"
                            id="submit_cod_remmitance" disabled>Submit</button>
                    </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>