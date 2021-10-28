<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ShipSecure</title>
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/favicon.png">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/favicon.png">
  <meta name="theme-color" content="#ffffff">
  <link href="<?= base_url(); ?>assets/css/styles.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/bootstrap1.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/core1.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/components2.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/colors1.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/custom-style1.css?v=1.1" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/admin_custom_style.css?v=5" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
</head>

<body class="navbar-top-md-md">
  <div class="se-pre-con" style="display: none;"></div>
  <div class="pre-loader" style="display: none;"></div>
  <div class="navbar-fixed-top">
    <div class="navbar navbar-inverse navbar-component pt-5 pb-5" id="navbar-second" style="position: relative; z-index: 30;">
      <div class="navbar-header" style="min-width: 12% !important;">
        <a class="navbar-brand no-padding" href="<?= base_url('dashboard'); ?>"><img src="<?= base_url(); ?>assets/images/logo.png" alt="" style="height: 80%;"></a>
        <ul class="nav navbar-nav pull-right visible-xs-block">
          <li><a data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-tree5"></i></a></li>
        </ul>
      </div>
      <div class="navbar-collapse collapse" id="navbar-second-toggle">
        <ul class="nav navbar-nav">
          <?php if ($_SESSION['user_type'] == '2') { ?>
            <li><a class="pl-5" href="<?= base_url('monthly-statment'); ?>">Monthly Statment</a></li>
            <li><a href="<?= base_url('manage-shipping-charge'); ?>">Manage Shipping Price</a></li>
          <?php } else { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle pl-5 pr-5" data-toggle="dropdown" data-hover="dropdown">
                Order <span class="caret"></span>
              </a>
              <ul class="dropdown-menu width-200">
                <li><a href="<?= base_url('create-order'); ?>">Create Order</a></li>
                <li><a href="<?= base_url('view-order'); ?>">View Order</a></li>
                <li><a href="<?= base_url('reverse-order'); ?>">Reverse Order</a></li>
                <li><a href="<?= base_url('create-bulk-order'); ?>">Create Bulk Order</a></li>
                <?php if ($_SESSION['user_type'] == '1') { ?>
                  <li><a href="<?= base_url('create-shopify-bulk-order'); ?>">Create Shopify Bulk Order</a></li>
                <?php } ?>
                <!-- <li><a href="<?= base_url('view-order-ndr'); ?>">View NDR Order</a></li> -->
              </ul>
            </li>
            <li><a class="pl-5" href="<?= base_url('order-report'); ?>">Order Report</a></li>
            <li><a class="pl-5" href="<?= base_url('list-pickup-address'); ?>">Manage Pickup Address</a></li>
            <?php if ($_SESSION['user_type'] == '1') { ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle pl-5 pr-5" data-toggle="dropdown" data-hover="dropdown">
                  Customer <span class="caret"></span>
                </a>
                <ul class="dropdown-menu width-200">
                  <li><a href="<?= base_url('approved-customers'); ?>">Approved Customer</a></li>
                  <li><a href="<?= base_url('pending-customers'); ?>">Pending Customer</a></li>
                </ul>
              </li>
              <li><a href="<?= base_url('manage-shipping-charge'); ?>">Shipping Price</a></li>
            <?php } ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle pl-5 pr-5" data-toggle="dropdown" data-hover="dropdown">
                Other <span class="caret"></span>
              </a>
              <ul class="dropdown-menu width-200">
                <li><a href="<?= base_url('cod-remittance'); ?>">Remittance</a></li>
                <li><a href="<?= base_url('user-monthly-report'); ?>">Monthly Order Report</a></li>
                <li><a href="<?= base_url('pending-api-oreder-create'); ?>">Pending Api Order</a></li>
                <li><a href="<?= base_url('new-pending-api-oreder-create'); ?>">Create In Api Order</a></li>
                <?php if ($_SESSION['user_type'] == '1') { ?>
                  <li><a href="<?= base_url('api-setting'); ?>">Api Setting</a></li>
                  <li><a href="<?= base_url('user-wallet-balance'); ?>">User Wallet Update</a></li>
                  <li><a href="<?= base_url('credit-setting'); ?>">Credit Setting</a></li>
                  <li><a href="<?= base_url('customer-used-credit-list'); ?>">Customer Used Credit List</a></li>
                  <li><a href="<?php echo base_url('cod-users-list'); ?>">COD Users List</a></li>
                  <li><a href="<?php echo base_url('daily-user-order-list'); ?>">Daily Users order count List</a></li>
                  <li><a href="<?= base_url('manually-refund-order'); ?>">Manually Refund</a></li>
                  <li><a href="<?= base_url('uddan_awb'); ?>">Uddan Awb</a></li>
                <?php } ?>
              </ul>
            </li><?php if ($_SESSION['user_type'] == '1') { ?>
              <li><a class="pl-5" target="_blank" href="<?php echo base_url('search-statment'); ?>">Search Shipment</a></li>
            <?php } ?>
          <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right no-margin-left" id="navbar-mobile">
          <li class="dropdown">
            <p style="margin-right: 5px;"><img style="height: 35px" src="<?= base_url() ?>assets/images/rupees-briefcase-1441491-1218928.png"> <span style="color: #010101;  vertical-align: text-top;font-weight: bold;font-size: 16px">
                <?php $sql_qry = "SELECT * FROM registration WHERE id='" . @$_SESSION['id'] . "'";
                $query = $this->db->query($sql_qry);
                $row = $query->row();
                echo number_format(@$row->wallet_credit, 2); ?>
              </span></p>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle pl-5 pr-5 no-padding" data-toggle="dropdown" data-hover="dropdown">
              <span class="position-relative">
                <img style="height: 30px" src="<?= base_url() ?>assets/images/default_profile.jpg" class="b-r-13" alt="">
                <span><?php echo $_SESSION['name']; ?> </span>
                <i class="caret"></i>
              </span>
            </a>
            <ul class="dropdown-menu width-100">
              <li><a href="<?= base_url('profile'); ?>">Profile</a></li>
              <li><a href="<?= base_url('my-wallet-balance'); ?>" target="_blank">My Wallet</a></li>
              <li><a href="<?= base_url('logout'); ?>">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <input type="hidden" name="hiddenurl" id="hiddenUrl" value="<?= base_url(); ?>">
  <div id="result_message" style="display: none;"></div>
  <div id="result_error_message" style="display: none;"></div>
  <?php if ($this->session->flashdata('message')) { ?>
    <div id="result" style="display: none;"></div>
  <?php } else if ($this->session->flashdata('error')) { ?>
    <div id="result_error" style="display: none;"></div>
  <?php } else {
  } ?>
  <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>