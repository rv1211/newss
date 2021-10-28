<div class="page">
    <!-- start page header -->
    <div class="page-header">
        <h1 class="page-title">Manage Users</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </div>
    <!-- end page header -->
    <!-- start page content -->
    <!-- $this->data['user_data']->id -->
    <div class="page-content">
        <form action="<?= base_url('manage-user/edit/'.$this->uri->segment(3)); ?>" class="user-edit-form"
            id="user-edit-form" method="POST" autocomplete="off">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add User
                        <hr>
                    </h3>
                </div>
                <!-- end panel heading -->
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h5 class="example-">User Type</h5>
                                <select name="user_type" class="form-control select2"
                                    value="<?= @$user_data->user_type;?>">
                                    <option value="">Select user type</option>
                                    <option value="1"
                                        <?php echo set_select('user_type','1',(@$user_data->user_type == "1")?TRUE:''); ?>>
                                        Admin</option>
                                    <option value="2"
                                        <?php echo set_select('user_type','2',(@$user_data->user_type == "2")?TRUE:''); ?>>
                                        Member</option>
                                    <option value="3"
                                        <?php echo set_select('user_type','3',(@$user_data->user_type == "3")?TRUE:''); ?>>
                                        Accountant</option>
                                </select>
                                <?php if(isset($errors['user_type'])): ?>
                                <label class="text-danger"><?=$errors['user_type']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <input type="hidden" class="form-control" id="user_id" name="id"
                                    value="<?= @$user_data->id;?>" />

                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="fullname">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" name="inputEmail"
                                    placeholder="Full Name" value="<?= @$user_data->name;?>" />
                                <?php if(isset($errors['fullname'])): ?>
                                <label class="text-danger"><?=$errors['fullname']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Mobile Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile No"
                                    value="<?= @$user_data->user_mobile_no;?>" />
                                <?php if(isset($errors['phone'])): ?>
                                <label class="text-danger"><?=$errors['phone']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="fullname">Email</label>
                                <input type="email" class="form-control" name="email" id="email" name="inputEmail"
                                    placeholder="Email" value="<?= @$user_data->user_email; ?>" />
                                <?php if(isset($errors['email'])): ?>
                                <label class="text-danger"><?=$errors['email']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    name="password" placeholder="Password" value="" />
                                <div class="form-control-feedback1">
                                    <i class="fa fa-eye" id="togglePassword"></i>
                                </div>
                                <h5>Note : Keep it blank to retain old password.</h5>
                                <?php if(isset($errors['password'])): ?>
                                <label class="text-danger"><?=$errors['password']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-check form-group form-material">
                                <input type="checkbox" class="form-check-input" name="is_active"
                                    <?= @$user_data->is_active == ' 1'?"checked":''; ?>
                                    value="<?php echo set_checkbox('is_active', 1); ?>">
                                <label class="form-check-label" for="exampleCheck1" name="active"
                                    style="margin-left: -18px;">Active</label>

                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <button type="submit" id="user-update-btn"
                                    class="btn btn-primary waves-effect waves-classic update">Update</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <a href="<?= base_url('manage-user');?>"><button type="button"
                                        class="btn btn-primary waves-effect waves-classic">cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end panel body -->
        </form>
    </div>
    <!-- end page content -->
</div>
<script type="text/javascript">
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', function(e) {
    // toggle the type attribute

    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye');
});
</script>