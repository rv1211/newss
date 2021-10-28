<?php
$currentUrl =  $_SERVER['REQUEST_URI'];
$page = basename($currentUrl); ?>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">        
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ShipSecure - User Onboard</title>
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/images/favicon.png">
  <meta name="theme-color" content="#ffffff">
  <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/bootstrap1.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/core1.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/css/components2.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>assets/css/colors1.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>/assets/css/custom-style1.css?v=1.1" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>assets/css/admin_custom_style.css?v=3" rel="stylesheet" type="text/css">
</head>
<body class="navbar-top-md-md  pace-done" id="body_div" cz-shortcut-listen="true"><div class="pace  pace-inactive">
  <div class="se-pre-con" style="display: none;"></div>
  <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
    <div class="pace-progress-inner"></div>
  </div>
  <div class="pace-activity"></div>
</div>
<div class="navbar-fixed-top">
  <div class="navbar navbar-default pt-5 pb-5">
    <div class="navbar-header">
      <a class="navbar-brand no-padding-right no-padding-top no-padding-bottom" href="<?php echo @$currentUrl; ?>" style="font-size:30px">
        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="ShipSecure" style="height: 80%;">
      </a>
      <ul class="nav navbar-nav visible-xs-block">
        <li><a data-toggle="collapse" data-target="#navbar-mobile" class="legitRipple"><i class="icon-menu bermuda-gray"></i></a></li>
      </ul>
    </div>
    <div class="navbar-collapse collapse" id="navbar-mobile">
      <div class="navbar-right">
        <ul class="nav navbar-nav">
          <li>
            <a id="current_wallet_amount_div" style="padding: 10px;margin:10px;text-transform: none;display:none;" class="btn btn-sm btn-primary btn-rounded-circle btn-grad legitRipple"> <i class="icon-wallet"></i> <span id="current_wallet_amount">0.00</span> 
            </a>
          </li>
          <li>
            <a style="padding: 10px;margin:10px;text-transform: none;" href="<?php echo base_url('logout'); ?>" class="btn btn-sm bermuda-gray legitRipple">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="hiddenurl" id="hiddenUrl" value="<?php echo base_url(); ?>">
<div id="result_message" style="display: none;"></div>
<div id="result_error_message" style="display: none;"></div>
<?php if($this->session->flashdata('message')){ ?>
  <div id="result" style="display: none;"></div>
<?php } else if($this->session->flashdata('error')){ ?>
  <div id="result_error" style="display: none;"></div>
<?php } else{} ?>              