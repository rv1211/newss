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
    <div class="page-content">
        <form action="<?= base_url('add-user'); ?>" method="POST" autocomplete="off" id="user-add-form">
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
                                <select name="user_type" class="form-control select2">
                                    <option value="">Select user type</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Member</option>
                                    <option value="3">Accountant</option>
                                </select>
                                <?php if(isset($errors['user_type'])): ?>
                                <label class="text-danger"><?=$errors['user_type']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="fullname">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" name="inputEmail"
                                    placeholder="Full Name"
                                    value="<?= isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>" />
                                <?php if(isset($errors['fullname'])): ?>
                                <label class="text-danger"><?=$errors['fullname']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Mobile Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile No"
                                    value="<?= isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" />
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
                                    placeholder="Email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
                                <?php if(isset($errors['email'])): ?>
                                <label class="text-danger"><?=$errors['email']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    name="password" placeholder="Password"
                                    value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" />
                                <div class="form-control-feedback1">
                                    <i class="fa fa-eye" id="togglePassword"></i>
                                </div>
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
                                    value="<?= isset($_POST['is_active']) ? $_POST['is_active'] : ''; ?>">
                                <label class="form-check-label" for="exampleCheck1" name="active"
                                    style="margin-left: -18px;">Active</label>

                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <button type="submit" id="user-add-form"
                                    class="btn btn-primary waves-effect waves-classic">Submit</button>
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