<div class="page">
    <div class="page-header">
        <h1 class="page-title">Orders</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </div>
    <div class="page-content ">
        <!-- Panel Basic -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
                <table class="table table-striped table-borderd" id="order_table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="all_manifested_order" id="select_all" name="select_all"
                                    value="1"></th>
                            <th>Order Number</th>
                            <th>Airwaybill Number</th>
                            <th>Customer Details</th>
                            <th>Order Type</th>
                            <th>Logistics</th>
                            <th>Processing date</th>
                            <!-- <th>Payment Status</th> -->
                            <th>Remarks</th>
                            <?php if($this->session->userdata('userType') == '1'){ ?>
                            <th>User</th>
                            <?php }?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- End Panel Basic -->
    </div>
</div>
<!-- End Page -->