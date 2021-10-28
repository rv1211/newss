<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Logistic Priority</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Add logistic priority</li>
        </ol>

    </div>

    <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Logistic Priority
                        <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-5">
                            <div class="form-group form-material">
                                <?php foreach($logistics as $logistic): ?>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel End -->
            <!-- Panel Form Elements -->
            <!-- Panel End -->
        </form>
    </div>
</div>