<!-- BEGIN CONTENT -->

<div class="page">

    <div class="page-header">

        <h1 class="page-title">Pincode Serviceability</h1>

        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>

            <li class="breadcrumb-item active">Pincode Serviceability</li>

        </ol>

    </div>

    <div class="page-content">

        <!-- Panel Form Elements -->

        <div class="panel">

            <div class="panel-heading">

                <h3 class="panel-title">

                    Check Pincode Serviceability

                    <hr>

                </h3>

            </div>

            <div class="panel-body container-fluid">

                <div class="row">

                    <div class="col-md-12">

                        <div class="portlet-body form">

                            <!-- BEGIN FORM-->

                            <form class="horizontal-form" action="<?= base_url('pincode-serviceability'); ?>" name="pincode_serviceability_form" method="POST" enctype="multipart/form-data">

                                <div class="form-body">

                                    <div class="row">

                                        <div class="col-md-2">

                                            <div class="form-group form-material">

                                                <h4 class="example-title">Pickup Pincode <span style="color:red">*</span>

                                                </h4>

                                                <input type="text" class="form-control parsley-error" id="your_pincode" placeholder="Enter Pincode" name="your_pincode" value="<?= @$your_pincode; ?>" maxlength="6">

                                            </div>

                                        </div>

                                        <div class="col-md-1">

                                            <div class="arrow-icon">

                                                <i class="fas fa-arrow-circle-right"></i>

                                            </div>

                                        </div>

                                        <div class="col-md-2">

                                            <div class="form-group form-material">

                                                <h4 class="example-title">Delhivery Pincode <span style="color:red">*</span>

                                                </h4>

                                                <input type="text" class="form-control parsley-error" id="check_pincode" placeholder="Enter Pincode" name="check_pincode" value="<?= @$check_pincode; ?>" maxlength="6">

                                                <label class="text-danger" id="ordernumber"></label>

                                            </div>

                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-actions pincode-button">

                                                <button type="submit" name="submit" value="Get Pincode" id="pincode_submit" class="btn btn-primary">Submit</button>

                                            </div>

                                        </div>

                                    </div>

                                </div>



                            </form>

                            <!-- END FORM-->

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php if ((!empty($logistic_details)) && (!empty($pincode_details))) : ?>

            <div id="pincode_serv_logistic">

                <div class="panel pincode-service-blue-bar-content">

                    <div class="container">

                        <div class="row">

                            <div class="serviceable-city">

                                <span class="serviceability-key">Serviceable City: </span>

                                <span class="serviceability-value"><?= @$pincode_details['city']; ?></span>

                            </div>

                            <div class="serviceable-state">

                                <span class="serviceability-key">Serviceable State: </span>

                                <span class="serviceability-value"><?= @$pincode_details['state']; ?></span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="pincode-serviceability">

                    <?php

                    if (!empty($logistic_details)) {

                        $counter = 0;

                        foreach ($logistic_details as $logistic) :

                            if ($counter % 4 == 0) {

                                echo '</div><div class="pincode-serviceability">';
                            }

                            if (!empty($logistic['is_prepaid'])) {

                                $is_prepaid = $logistic['is_prepaid'];
                            } else {

                                $is_prepaid = '0';
                            }

                            if (!empty($logistic['is_cod'])) {

                                $is_cod = $logistic['is_cod'];
                            } else {

                                $is_cod = '0';
                            }

                            if (!empty($logistic['is_reverse_pickup'])) {

                                $is_reverse_pickup = $logistic['is_reverse_pickup'];
                            } else {

                                $is_reverse_pickup = '0';
                            }

                            if (!empty($logistic['is_pickup'])) {

                                $is_pickup = $logistic['is_pickup'];
                            } else {

                                $is_pickup = '0';
                            }

                    ?>

                            <div class="panel pincode-panel">

                                <div class="panel-heading pincode-card-content">

                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 left-section head-section-icon fedex-body">

                                            <img src="<?= base_url('assets/custom/img/') . $logistic['api_name'] ?>.jpg" class="delivery-icon">

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 right-section head-section-icon">

                                            <p class="head"> <?= @$logistic['logistic_name']; ?> </p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 left-section">

                                            <p class="p-txt">Pre-paid Delivery</p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 right-section">

                                            <p class="p-txt"> <img src="<?= base_url('assets/custom/img/') . $is_prepaid ?>.svg">

                                            </p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 left-section">

                                            <p class="p-txt">Cash on Delivery</p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 right-section">

                                            <p class="p-txt"> <img src="<?= base_url('assets/custom/img/') . $is_cod ?>.svg">

                                            </p>

                                        </div>
                                        <!-- 
                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 left-section">

                                            <p class="p-txt">Reverse Pickup</p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 right-section">

                                            <p class="p-txt"> <img src="<?php //echo base_url('assets/custom/img/') . $is_reverse_pickup
                                                                        ?>.svg">

                                            </p>

                                        </div> -->

                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-7 left-section">

                                            <p class="p-txt">Pickup</p>

                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-5 col-xs-5 right-section">

                                            <p class="p-txt"> <img src="<?php echo base_url('assets/custom/img/') . $is_pickup
                                                                        ?>.svg">

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                    <?php $counter++;
                        endforeach;
                    } ?>

                </div>

            </div>

        <?php endif; ?>

    </div>

</div>