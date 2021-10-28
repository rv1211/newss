<?php //dd($this->data);
?>
<div class="page">
    <!-- start page header -->
    <div class="page-header">
        <h1 class="page-title">All Booking</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">All Booking</li>
        </ol>
    </div>
    <!-- end page header -->
    <!-- start page content -->
    <div class="page-content">
        <form action=<?php echo base_url('all-booking-report') ?> name="pincode_import_form12" method="POST" id="" autocomplete="off" enctype="multipart/form-data">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        All Booking
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
                                <button type="submit" id="rto_booking_report" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic excel">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel body -->
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