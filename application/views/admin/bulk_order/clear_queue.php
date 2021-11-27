<div class="page">
    <div class="page-header">
        <h1 class="page-title">Clear Bulk Queue</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Clear Bulk Queue</li>
        </ol>

    </div>

    <div class="page-content">
        <!-- Panel Form Elements -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <center>
                            <div class="form-group form-material">
                                <label style="font-size: 18px; font-weight:bold; color: #3f51b5;">Start Bulk Queue: <span><?= $total_unused_awb; ?></span></label><br>
                                <a href="<?= base_url('bulk-cleared'); ?>" class="btn btn-primary">Click Me</a>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- Panel end -->
    </div>
</div>