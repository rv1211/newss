    <!-- Page -->
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Preawb Dashboard List</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Customer List</li>
            </ol>
        </div>

        <div class="page-content">
            <!-- Panel Basic -->
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Customer List</h3>
                </header>
                <div class="panel-body">
                    <!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
                    <table class="table table-hover dataTable table-striped" id="pre_awb_list">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Panel Basic -->
        </div>
    </div>
    <!-- End Page -->