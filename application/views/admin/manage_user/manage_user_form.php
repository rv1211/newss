<div class="page">
    <!-- start header -->
    <div class="page-header">
        <h1 class="page-title">Manage User</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Manage User</li>
            </ol>
            <div class="page-header-actions">
                <a class="btn btn-sm btn-primary btn-round" href="<?= base_url('add-user')?>">
                    <i class=" fas fa-user-plus" aria-hidden="true"></i>
                    <span class="hidden-sm-down">Add User</span>
                </a>
            </div>
    </div> 
    <!-- end header -->
    <!-- start page content -->
    <div class="page-content">
        <!-- <form action="<?= base_url('add-user'); ?>" method="post"> -->
            <div class="panel">
                <!-- start panel body -->
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group form-material">
                                <h4 class="example-">User List</h4>
                                <table class="table table-striped table-borderd user" id="user_table">
                                    <thead>
                                        <tr>
                                            <td><b>#</b></td>
                                            <td><b>Name</b></td>
                                            <td><b>Mobile No</b></td>
                                            <td><b>Email</b></td>
                                            <td><b>Type</b></td>
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
                <!-- end panel body -->
            </div>
        <!-- </form> -->
    </div>
    <!-- end page content -->
</div>
>