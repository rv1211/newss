<div class="page">
    <div class="page-header">
        <h1 class="page-title">Next COD Remmitance</h1>
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
                        <form method="POST" action="<?php echo base_url('delete-cod-remmitance-data'); ?>">
                            <!-- <div class="row"> -->
                            <div class="form-actions right">
                                <button type="submit" class="btn btn-danger" name="delete" value="Submit"
                                    id="delete_cod_remmitance" disabled>Delete</button>
                            </div>
                            <!-- </div> -->
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-material">
                                        <table class="table" id="next_cod_remittance_data_table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox"
                                                            id="select_all_cod_remmitance_cus_delete"></th>
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
                                                    <th><input type="checkbox" name="checkbox_cod_delete[]"
                                                            class="select_single_cod_remmitance_cus_delete"
                                                            data-id="<?= $val['id']; ?>" value="<?= $val['id']; ?>">
                                                    </th>
                                                    <th><?= $val['name']; ?></th>
                                                    <th><?= $val['email']; ?></th>
                                                    <th><?php if(!empty($val['order_count'])){ echo $val['order_count']; }else{ echo '0'; }  ?>
                                                    </th>
                                                    <th><?php if(!empty($val['cod_remittance_amount'])){
                                                        echo number_format($val['cod_remittance_amount'], 2, '.', ',');
                                                    }else{ echo '0.00'; } ?>
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


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>