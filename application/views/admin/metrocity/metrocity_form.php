<style>
    .metrocity_list{
        margin-left: 950px !important;
        top: -28px !important;
    }
</style>
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Metrocity</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Metrocity</li>
        </ol>

    </div>

    <div class="page-content">
        <form action="<?= base_url('manage-metrocity/add-metrocity'); ?>" method="post" name="metrocity_form">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Metrocity
                        <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h4 class="example-">Metrocity Name</h4>
                                <input type="hidden" name="metrocity_id" id="metrocity_id" value="0">
                                <input type="text" name="metrocity_name" value="" id="metrocity_name" class="form-control" placeholder="Enter a Metrocity Name">
                                <?php if(isset($errors['metrocity_name'])): ?>
                                <label class="text-danger"><?=$errors['metrocity_name']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <button type="submit" class="btn btn-primary" id="metrocity_submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        <div class="form-group form-material">
                            <h4 class="example-">Metrocity List</h4>
                            <table class="table table-striped table-borderd" id="metrocity_table">
                                <thead>
                                    <tr>
                                        <td><b>#</b></td>
                                        <td><b>Metrocity Name</b></td>
                                        <td><b>Status</b></td>
                                        <td><b>Action</b></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>