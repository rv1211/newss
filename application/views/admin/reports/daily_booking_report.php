<?php //dd($this->data);
?>
<div class="page">
    <!-- start page header -->
    <div class="page-header">
        <h1 class="page-title">Daily Booking</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Daily Booking</li>
        </ol>
    </div>
    <!-- end page header -->
    <!-- start page content -->
    <div class="page-content">
        <form action=<?php echo base_url('daily-booking-report') ?> name="pincode_import_form12" method="POST" id="pincode_import_form12" autocomplete="off" enctype="multipart/form-data">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Daily Booking
                        <hr>
                    </h3>
                </div>
                <!-- end panel heading -->
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <div class="example-wrap">
                                <div class="example">
                                    <h5 class="example-">From date</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="icon md-calendar" aria-hidden="true"></i>
                                            </span>
                                            <input type="text" id="from_date" name="from_date" class="form-control" value="<?php echo date("m/d/Y"); ?>" data-plugin="datepicker" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="example-wrap">
                                <div class="example">
                                    <h5 class="example-">To date</h5>
                                    <div class="input-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="icon md-calendar" aria-hidden="true"></i>
                                            </span>
                                            <input type="text" id="to_date" value="<?php echo date("m/d/Y"); ?>" name="to_date" class="form-control" data-plugin="datepicker" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <button type="submit" id="booking_report12" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic excel">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel body -->

            <!-- start table panel-->
            <div class="panel" id="booking_report_panel">
                <div class="panel-body container-fluid">
                    <div class="booking-table">
                        <div class="example-wrap">
                            <div class="example">
                                <table class="table table-hover border booking_table" id="daily_booking_report">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <?php foreach ($logistic_name12 as $key => $value) { ?>
                                                <th><?php echo $value; ?></th>
                                            <?php }  ?>
                                            <th>Total Count</th>
                                        </tr>
                                    </thead>
                                    <tbody id="daily_booking_report">
                                        <?php $count = array();
                                        @$all_total_count = 0;
                                        foreach (@$get_booking_data as $get_booking_data_value) { ?>
                                            <tr>
                                                <td><?= @$get_booking_data_value['sender_name']; ?></td>
                                                <?php @$horizontal_count = 0;
                                                foreach ($logistic_name12 as $value) { ?>
                                                    <td>
                                                        <?php if (in_array($value, $get_booking_data_value['logistic_name'])) { ?>
                                                            <?= @$get_booking_data_value[$value]['count'] ?>
                                                        <?php
                                                            @$horizontal_count += @$get_booking_data_value[$value]['count'];
                                                            @$count[$value] += @$get_booking_data_value[$value]['count'];
                                                        } else {
                                                            echo "0";
                                                        }  ?>
                                                    </td>
                                                <?php  }  ?>
                                                <td><?= $horizontal_count ?><?php $all_total_count += $horizontal_count; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <?php foreach ($logistic_name12 as $key => $value) { ?>
                                                <th><?php echo @$count[$value]; ?></th>
                                            <?php }  ?>
                                            <td><strong><?= @$all_total_count ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end table panel  -->
        </form>
    </div>
    <!-- end page content -->
</div>
<!-- 
<script type="text/javascript">
$(document).delegate( '',function () {
    $('#daily_booking_report').DataTable();
} );
</script> -->