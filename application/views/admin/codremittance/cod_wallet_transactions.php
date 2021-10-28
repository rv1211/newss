<div class="page">
    <div class="page-header">
        <h1 class="page-title">Cod Remittance</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">home</a></li>
            <li class="breadcrumb-item active">Cod Remittance</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <?php require APPPATH.'views/admin/codremittance/cod_card.php';?>
        </div>
        <!-- Panel Basic -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg" style="margin-top: 40px;">
                    <div class="form-group form-material">
                    </div>
                    <div class="col-xl-12">

                        <!-- Example Tabs -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php require APPPATH.'views/admin/codremittance/cod_tab_list.php';?>
                                </ul>
                                <div class="tab-content pt-20">
                                    <div class="tab-pane active" id="all_tab" role="tabpanel">
                                        <table class="table table-striped table-borderd" id="cod_wallet_transactions"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="12%">Date & Time </th>
                                                    <th width="10%">Transaction ID </th>
                                                    <th width="10%">Debit </th>
                                                    <th width="10%">Credit </th>
                                                    <th width="10%">Balance </th>
                                                    <th width="10%">Remarks </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End Page -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>