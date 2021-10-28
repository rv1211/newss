<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Cod Remittance List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Cod Remittance</a></li>
            <li class="breadcrumb-item active">All Remittance List</li>
        </ol>
    </div>

    <div class="page-content">
        <!-- Panel Basic -->
        <div class="panel">
            <header class="panel-heading">
                <div class="panel-actions"></div>
                <h3 class="panel-title">Basic</h3>
            </header>
            <div class="panel-body">
                <!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
                <table class="table table-hover dataTable table-striped" id="all_cod_remittance_list_table" width="100%">
                    <thead>
                        <tr>
                            <!-- <th><input type="checkbox" id="check_all_cod_remittance_order"></th> -->
                            <th>Remitted Date</th>
                            <th>Remitted Amount</th>
                            <th>Note</th>
                            <th>Action</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Remitted Date</th>
                            <th>Remitted Amount</th>
                            <th>Note</th>
                            <th>Action</th>
                            <th>Customer</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- End Panel Basic -->

    </div>
</div>
<!-- End Page -->

<!-- Modal -->
<div class="modal fade modal-fade-in-scale-up" id="myModal" role="dialog">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-body cod-modal-body">
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->