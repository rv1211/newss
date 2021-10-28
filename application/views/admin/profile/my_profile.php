<div class="page">
    <!-- start page header -->
    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
    <!-- end page header -->
    <!-- start page content -->
    <!-- $this->data['user_data']->id -->
    <div class="page-content">
        <form action="<?= base_url('manage-my-profile'); ?>" class="form" name="profile_form" method="POST"
            autocomplete="off">
            <div class="panel">
                <div style="display: inline-flex;">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Profile Details
                        </h3>
                    </div>
                    <div class="panel-heading" style="top: 20px;left: 350%;">
                        <a href="<?= base_url('dashboard'); ?>"><button type="button"
                                class="btn btn-primary waves-effect waves-classic"><i
                                    class="fas fa-arrow-circle-left"></i> Back</button></a>
                    </div>
                </div>
                <hr>
                <!-- end panel heading -->
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <?php  if($this->session->userdata('userType') != 4){ ?>
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h5 class="example-">User Type</h5>
                                <select class="form-control select2" disabled>
                                    <option value="1" <?php if(@$user_data['user_type'] == '1'){ echo 'selected';} ?>>
                                        Admin</option>
                                    <option value="2" <?php if(@$user_data['user_type'] == '2'){ echo 'selected';} ?>>
                                        Member</option>
                                    <option value="3" <?php if(@$user_data['user_type'] == '3'){ echo 'selected';} ?>>
                                        Accountant</option>
                                </select>
                                <?php if (isset($errors['user_type'])): ?>
                                <label class="text-danger"><?=$errors['user_type']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <input type="hidden" class="form-control" id="user_id" name="id"
                                    value="<?= @$user_data['id'] ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="fullname">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname"
                                    placeholder="Full Name" value="<?= @$user_data['name'];?>" <?php ?> />
                                <?php if(isset($errors['fullname'])): ?>
                                <label class="text-danger"><?=$errors['fullname']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Mobile Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile No"
                                    value="<?= ($this->session->userdata('userType') == 4) ?  @$user_data['mobile_no']: @$user_data['user_mobile_no'];?>"
                                    <?php ?> />
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
                                <input type="email" class="form-control"
                                    value="<?= ($this->session->userdata('userType') == 4) ?  @$user_data['email']: @$user_data['user_email']; ?>"
                                    <?= ($this->session->userdata('userType') == '2' || $this->session->userdata('userType') == '3' || $this->session->userdata('userType') == 4) ?  'readonly': ''; ?> />
                                <?php if(isset($errors['email'])): ?>
                                <label class="text-danger"><?=$errors['email']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($this->session->userdata('userType') == 4){ ?>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Website</label>
                                <input type="text" class="form-control" name="website" id="website"
                                    placeholder="Website" value="<?= @$user_data['website']; ?>" />
                                <?php if(isset($errors['website'])): ?>
                                <label class="text-danger"><?=$errors['website']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label" for="inputEmail">Password</label>
                                <div style="display:flex">
                                    <div style="width: 100%;">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password" value="" autocomplete="off" />
                                        <?php if(isset($errors['password'])): ?>
                                        <label class="text-danger"><?=$errors['password']; ?></label>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-control-feedback1">
                                        <i class="fa fa-eye" id="togglePassword" style="right: 50%;top: 4px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material" data-plugin="formMaterial">
                                <label class="form-control-label"></label>
                                <h5 style="color:red">Note : Keep it blank to retain old password.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <button type="submit" class="btn btn-primary waves-effect waves-classic"
                                    id="profile_btn">Save</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <a href="<?= base_url();?>"><button type="button"
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
    this.classList.toggle('fa-eye-slash');
});
</script>