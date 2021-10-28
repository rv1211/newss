<div class="page">
    <div class="page-header">
        <h1 class="page-title">Pickup Address</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Pickup Address</li>
        </ol>


        <div class="page-header-actions">
            <a class="btn btn-sm btn-primary btn-round" href="<?= base_url('create-pickup-address')?>">
                <i class="icon md-link" aria-hidden="true"></i>
                <span class="hidden-sm-down">Add Pickup Address</span>
            </a>
        </div>
    </div>
    <div class="page-content ">

        <!-- Panel Basic -->
        <div class="panel">
            <!-- <header class="panel-heading">
            <div class="panel-actions"></div>
         </header> -->
            <div class="panel-body container-fluid">
                <button type="button" style="margin-left: 70%; top: 33px;" id="export_pickup"
                    class="btn btn-primary waves-effect waves-classic">Export</button>
                <!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
                <table class="table table-hover dataTable table-striped table-pickup" id="pickup_add_table">
                    <thead>
                        <tr>
                            <th>
                                <input class="selectable-all-pickup getChecked_pickup" type="checkbox">
                            </th>
                            <th>Warehouse Name</th>
                            <th>Contact Person Name</th>
                            <th>Contact no</th>
                            <th>Contact Email</th>
                            <th>Website</th>
                            <th>Address Line 1</th>
                            <th>Address Line 2</th>
                            <th>Pincode</th>
                            <th>State</th>
                            <th>City</th>
                            <?php if ($this->session->userdata('userType') == '1') { ?>
                            <th>Action</th>
                            <?php }?>
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