   <div class="page">
       <div class="page-header">
           <h4 class="page-title">Airway Bill</h4>
           <div class="page-content">
               <div class="panel">
                   <header class="panel-heading">
                       <h3 class="panel-title">
                           Import Airway Bill
                       </h3>
                   </header>
                   <div class="panel-body">
                       <p>
                           <!--  -->
                       </p>


                       <form class="form-horizontal fv-form fv-form-bootstrap4"
                           action="<?php echo base_url('insert_airway_bill'); ?>" id="create_bulk_order_form"
                           name="create_bulk_order_form" method="POST" enctype="multipart/form-data" autocomplete="off">
                           <div class="row row-lg">
                               <div class="col-lg-4">
                                   <!-- Logistic  -->
                                   <div class="example-wrap">
                                       <h4 class="example-title"></h4>
                                       <div class="example">
                                           <label class="form-control-label">Logistic</label>
                                           <select class="form-control " name="logistic" id="logistic">
                                               <option value="">Please Select Logistic</option>
                                               <?php foreach ($active_logistic as $is_active_logistic) { ?>
                                               <option
                                                   value="<?php echo strtolower($is_active_logistic['api_name']); ?>">
                                                   <?php echo $is_active_logistic['logistic_name']; ?></option>
                                               <?php } ?>
                                           </select>
                                           <?php if (isset($errors['logistic'])) { ?>
                                           <label class="error"><?=@$errors['logistic']?></label>
                                           <?php } ?>
                                       </div>
                                   </div>
                                   <!-- End Logistics -->
                               </div>

                               <div class="col-lg-4">
                                   <!-- Logistic  -->
                                   <div class="example-wrap">
                                       <h4 class="example-title"></h4>
                                       <div class="example">
                                           <label class="form-control-label">Type</label>
                                           <select class="form-control " name="type" id="type">
                                               <option value="">Select Type</option>
                                               <option value="1">Forward Cod</option>
                                               <option value="2">Forward Prepaid</option>
                                               <option value="3">Reverse</option>
                                           </select>
                                           <?php if (isset($errors['type'])) {?>
                                           <label class="error"><?=@$errors['type']?></label>
                                           <?php }?>
                                       </div>
                                   </div>
                                   <!-- End Logistics -->
                               </div>

                               <div class="col-lg-4">
                                   <!-- Logistic  -->
                                   <div class="example-wrap">
                                       <h4 class="example-title"></h4>
                                       <div class="example">
                                           <label class="form-control-label">For what ?</label>
                                           <select class="form-control " name="for_what" id="for_what">
                                               <option value="">Please select for what ?</option>
                                               <option value="1">Manually</option>
                                               <option value="2">Auto</option>
                                           </select>
                                           <?php if (isset($errors['for_what'])) {?>
                                           <label class="error"><?=@$errors['for_what']?></label>
                                           <?php }?>
                                       </div>
                                   </div>
                                   <!-- End Logistics -->
                               </div>
                           </div>


                           <div class="row justify-content-center">
                               <div class="col-md-6 my-auto">
                                   <div class="form-group">
                                       <h4 class="sample_of_excel">
                                           <a href="<?php echo base_url('/assets/import_airway_bill/sample/import-airway-bill.xlsx'); ?>"
                                               download>
                                               <!-- <img src="" alt="W3Schools" width="104" height="142"> -->
                                               <i class="fa fa-file-excel-o"></i> sample.xlsx
                                           </a>
                                           <small style="color: #f44336">(Note: For import excel format given)</small>
                                       </h4>
                                   </div>
                               </div>
                           </div>
                   </div>


                   <div class="row row-lg justify-content-center p-5">
                       <div class="col-lg-4">
                           <input type="file" name="airway_import_file" id="airway_import_file">
                           <!-- <input type="file" name="import_file" class="dropify-event" id="import_file" data-plugin="dropify" data-default-file=""  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/> -->
                           <!-- <input type="file" name="import_file" id="import_file" class="dropify-event"  data-plugin="dropify" data-default-file=""/> -->
                           <!-- <input type="file" name="airway_import_file"  class="dropify-event" data-plugin="dropify" data-default-file="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" /> -->

                       </div>
                       <div class="col-lg-4 my-auto">
                           <input type="submit" name="airway" id="airway" />
                       </div>
                       <!-- form end-->
                       </form>
                   </div>
               </div>
           </div>
       </div>
   </div>
   </div>