<?php //echo base_url('admin/insert_order'); 
?>
<link href="<?php echo base_url(); ?>assets/front-end/css/styles.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/font-awesome.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/bootstrap1.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/core1.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/components2.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/colors1.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/custom-style1.css?v=1.1" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/front-end/css/admin_custom_style.css?v=3" rel="stylesheet" type="text/css">
<style type="text/css">
	.btn-rounded-circle {
		border-radius: 3.375rem !important;
		padding: .1875rem 1rem !important;
		font-size: .875rem !important;
		text-transform: capitalize;
	}

	.btn-primary {
		background-color: #8B7568 !important;
		border-color: #8B7568 !important;
		color: #fff !important;
		border-radius: 3.375rem !important;
	}

	.fc-bordered {
		padding-top: .9375rem !important;
		background-color: transparent !important;
		border-left-color: #f7f7f7 !important;
		border-bottom-color: #f7f7f7 !important;
		color: #555 !important;
		box-shadow: 0px !important;
		border: 1px solid #ccc !important;
		border-radius: 3.375rem !important;
		height: auto !important;
		padding: .8125rem 1rem !important;
		font-size: .875rem !important;
		line-height: 1.25rem !important;
	}

	.fc-bordered:focus,
	.fc-bordered:hover {
		box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.09) !important;
		border-radius: 3.375rem !important;
		border: 1px solid #0000006e !important;
		background-color: #ffffff !important;
	}

	.site-footer {
		position: relative !important;
		overflow: hidden !important;
		padding: 4.5rem 0 !important;
		color: #272727 !important;
		padding-bottom: 15px !important;
		padding-top: 30px !important
	}
</style>
<div id="page" class="ed-page mobile-h2">
	<div id="page-hero" class="ed-page-hero">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div id="wallet_response"></div>
					<div id="step3_div" style="display:block">
						<div class="row">
							<!-- <div class="form-wizard-title col-md-6">
                        </div> -->
						</div>
						<form id="add_order" method="POST" class="form_order_create" action="">
							<div class="col-md-6 col-sm-12">
								<fieldset class="step" id="ajax-step3">
									<div class="row">
										<div class="box_icon_div">
										</div>
										<h4>
											<img src="<?php echo base_url(); ?>assets/front-end/images/intransit.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support">
											Pickup Address
										</h4>

										<div class="col-md-4">
											<div class="form-group">
												<input maxlength="6" autocomplete="off" type="text" class="form-control inputnumbers" id="pickuppincode" name="pickuppincode" placeholder="Pincode *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" class="form-control inputnumbers" id="pickupstate" name="pickupstate" placeholder="State *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4" id="city_selection_div2">
											<div class="form-group">
												<input type="text" autocomplete="off" class="form-control inputnumbers" id="pickupcity" name="pickupcity" placeholder="City *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" autocomplete="off" name="pickupcustomer_address1" id="pickupcustomer_address1" placeholder="Customer Address1 *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" autocomplete="off" name="pickupcustomer_address2" id="pickupcustomer_address2" placeholder="Customer Address2" class="form-control">
											</div>
										</div>
										<div class="clearfix"></div>
										<h4>
											<img src="<?php echo base_url(); ?>assets/front-end/images/manifested.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support"> What are Shipment Type
										</h4>
										<div class="col-md-4">
											<div class="form-group">
												<select name="is_reverse" id="type_of_shipment" data-placeholder="Shipment Type *" class="select form-control select2-hidden-accessible">
													<option selected="" value="0">Forward</option>
													<option value="1">Reverse</option>
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
										<h4>
											<img src="<?php echo base_url(); ?>assets/front-end/images/intransit.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support">
											Where are you sending to?
										</h4>
										<div class="col-md-4">
											<div class="form-group">
												<input maxlength="6" autocomplete="off" type="text" class="form-control inputnumbers" id="pincode" name="pincode" placeholder="Pincode *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" class="form-control inputnumbers" id="state" name="state" placeholder="State *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4" id="city_selection_div2">
											<div class="form-group">
												<input type="text" autocomplete="off" class="form-control inputnumbers" id="city" name="city" placeholder="City *" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" name="customer_name" id="customer_name" placeholder="Customer Name *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" name="customer_email" id="customer_email" placeholder="Customer Email *" class="form-control">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-6">
											<div class="form-group">
												<input maxlength="12" autocomplete="off" minlength="10" type="text" name="customer_mobile" id="customer_mobile" placeholder="Customer Mobile *" class="form-control inputnumbers" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" autocomplete="off" name="customer_address1" id="customer_address1" placeholder="Customer Address1 *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" autocomplete="off" name="customer_address2" id="customer_address2" placeholder="Customer Address2" class="form-control">
											</div>
										</div>
										<div class="clearfix"></div>
										<h4>
											<img src="<?php echo base_url(); ?>assets/front-end/images/rto-delivered.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support"> What size is your parcel?
										</h4>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" name="ship_length" id="ship_length" placeholder="Length (cms) *" class="form-control inputnumbersdots" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" name="ship_width" id="ship_width" placeholder="Width (cms) *" class="form-control inputnumbersdots" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" name="ship_height" id="ship_height" placeholder="Height (cms) *" class="form-control inputnumbersdots" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" name="vol_weight" placeholder="Volumetric Weight (in kg)" class="form-control inputnumbersdots" id="calculate_vol_weight" disabled="">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" name="phy_weight" id="phy_weight" placeholder="Physical Weight (in kg) *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" id="product_mrp" name="product_mrp" placeholder="Product Value *" class="form-control inputnumbersdots " data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-8">
											<div class="form-group">
												<input type="text" autocomplete="off" name="product_description" id="product_description" placeholder="Product Description *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" autocomplete="off" name="product_group" id="product_group" placeholder="Product Group *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<h4>
											<img src="<?php echo base_url(); ?>assets/front-end/images/manifested.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support"> What are the order details?
										</h4>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" name="order_no" id="order_no" placeholder="Order No *" class="form-control" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" name="sub_order_no" id="sub_order_no" placeholder="Sub Order No *" class="form-control">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-3" id="order_type_div">
											<div class="form-group">
												<select id="order_type" name="order_type" data-placeholder="Order Type *" class="select form-control select2-hidden-accessible">
													<!-- <option selected="" value="">Select Order Type</option>
                                    <option value="cod">COD</option> 
                                    <option value="prepaid">Prepaid</option>  -->
												</select>
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-3" id="cod_amount_div" style="display: none">
											<div class="form-group">
												<input type="text" autocomplete="off" name="cod_amount" id="cod_amount" placeholder="Collectable Amount *" class="form-control inputnumbersdots" value="0">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" autocomplete="off" name="quantity" id="quantity" placeholder="Quantity *" class="form-control inputnumbers" data-parsley-required="true">
												<span class="error"></span>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<input type="text" autocomplete="off" name="package_count" id="package_count" placeholder="Package Count" class="form-control inputnumbers" data-parsley-required="true" value="1">
												<span class="error"></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-3">
											<div class="form-group">
												<button type="button" id="get_price" class="btn btn-success"> Get Price </button>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
							<div class="col-md-6 col-sm-12" id="graph_div" style="border: 1px solid rgb(221, 221, 221); border-radius: 10px; position: fixed; right: 50px; width: 46%; top: 100px;">
								<div id="chartdiv" style="height:200px"></div>
								<div class="clearfix"></div>
								<h4>
									<img src="<?php echo base_url() ?>assets/front-end/images/delivered.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support"> Select logistic partner as per your preference
								</h4>
								<div class="row">
									<table class="table table-xs table-bordered" id="rate_table_div" width="100%">
										<tbody>
											<!-- <tr> <td style="width:10%"> <div class="choice" id="uniform-fedex"> <span class="checked"> <input checked="" type="radio" class="styled" name="logistics" id="fedex" data-parsley-multiple="logistics"> </span> </div> </td> <td style="width:60%"> <img src="//manage.ithinklogistics.com/assets/front-end/images/fedex.jpg" style="width:50px;">  <span id="fedex_image" class="text-danger"></span> </td> <td style="text-align:right;width:30%" id="fedex_rate">Rs. 0.00</td> </tr>
                                <tr> <td> <div class="choice" id="uniform-ecom"> <span> <input type="radio" class="styled" name="logistics" id="ecom" data-parsley-multiple="logistics"> </span> </div> </td> <td> <img src="//manage.ithinklogistics.com/assets/front-end/images/ecom.png" style="width:50px;"> <span id="ecom_image" class="text-danger"></span> </td> <td style="text-align:right" id="ecom_rate">Rs. 0.00</td> </tr>
                                <tr> <td> <div class="choice" id="uniform-ekart"> <span> <input type="radio" class="styled" name="logistics" id="ekart" data-parsley-multiple="logistics"> </span> </div> </td> <td> <img src="//manage.ithinklogistics.com/assets/front-end/images/ekart.jpg" style="width:50px;">  <span id="ekart_image" class="text-danger"></span> </td> <td style="text-align:right" id="ekart_rate"> Rs. 0.00</td> </tr>
                                <tr> <td> <div class="choice" id="uniform-xpressbees"> <span> <input type="radio" class="styled" name="logistics" id="xpressbees" data-parsley-multiple="logistics"> </span> </div> </td> <td> <img src="//manage.ithinklogistics.com/assets/front-end/images/xpressbees.jpg" style="width:50px;"> <span id="xpressbees_image" class="text-danger"></span> </td> <td style="text-align:right" id="xpressbees_rate"> Rs. 0.00</td> </tr> -->
											<tr>
												<td>
													<div id="uniform-delhivery">
														<span>
															<input type="radio" class="styled" value="delhivery" name="logistics" id="delhivery">
															<span class="error"></span>
														</span>
													</div>
												</td>
												<td>
													<img src="<?php echo base_url(); ?>assets/front-end/images/delhivery.png" style="width:50px;">
													<input type="hidden" name="shipping_charge" id="shipping_charge" value="0">
												</td>
												<td style="text-align:right" id="delhivery_rate" class="shipp_rate">Rs. 0.00</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:right">
													<b>GST (18%)</b>
												</td>
												<td style="text-align:right"><b id="total_summary" class="total_gst">Rs. 0</b></td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:right">
													<b>Total Summary (incl. GST)</b>
												</td>
												<td style="text-align:right"><b id="total_summary" class="total_rate">Rs. 0</b></td>
											</tr>
										</tbody>
									</table>
									<div class="col-md-12" style="padding: 10px 10px 0px 10px;">
										<!-- <button id="order-submit" type="submit" class="btn btn-primary pull-right legitRipple" style="margin: 0px 0px 10px 0px;">Create Order</button> -->
										<!-- <button type="button" class="btn btn-primary create_order_button" data-toggle="modal" data-target="#exampleModal">
                                modal
                              </button> -->
										<!-- <a class="btn btn-primary pull-right create_order_button">
                                Create Order 
                              </a> -->
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
  $(function(){
    var hiddenurl = $('#hiddenUrl').val();
    var url = hiddenurl+'admin/insert_order';
    $('.create_order_button').on('click',function(){
      //$(".se-pre-con").fadeIn("slow");
      var form = $('#add_order')[0];
      var pickup_address = $('#pickup_address').val();
      var type_of_shipment = $('#type_of_shipment').val();
      var pincode = $('#pincode').val();
      var state = $('#state').val();
      var city = $('#city').val();
      var customer_name = $('#customer_name').val();
      var customer_email = $('#customer_email').val();
      var customer_mobile = $('#customer_mobile').val();
      var customer_address1 = $('#customer_address1').val();
      var ship_length = $('#ship_length').val();
      var ship_width = $('#ship_width').val();
      var ship_height = $('#ship_height').val();
      var phy_weight = $('#phy_weight').val();
      var product_mrp = $('#product_mrp').val();
      var product_description = $('#product_description').val();
      var product_group = $('#product_group').val();
      var order_no = $('#order_no').val();
      var sub_order_no = $('#sub_order_no').val();
      var order_type = $('#order_type').val();
      var cod_amount = $('#cod_amount').val();
      var quantity = $('#quantity').val();
      var package_count = $('#package_count').val();
      var logistics = $("input[name='logistics']:checked").val();
      if (pickup_address == "") {
          $('#pickup_address').parent().parent().parent().find('span.error').html('');
          $('#pickup_address').parent().find('span.error').html('Please select Pickup address');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (type_of_shipment == "") {
          $('#type_of_shipment').parent().parent().parent().find('span.error').html('');
          $('#type_of_shipment').parent().find('span.error').html('Please select Shipment type');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (pincode == "") {
          $('#pincode').parent().parent().parent().find('span.error').html('');
          $('#pincode').parent().find('span.error').html('Enter Pincode'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (state == "") {
          $('#state').parent().parent().parent().find('span.error').html('');
          $('#state').parent().find('span.error').html('Enter State');
          $(".se-pre-con").fadeOut("slow");            
          return false;
      }
      if (city == "") {
          $('#city').parent().parent().parent().find('span.error').html('');
          $('#city').parent().find('span.error').html('Enter City');
          $(".se-pre-con").fadeOut("slow");            
          return false;
      }
      if (customer_name == "") {
          $('#customer_name').parent().parent().parent().find('span.error').html('');
          $('#customer_name').parent().find('span.error').html('Please Enter Customer Name');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (customer_email == "") {
          $('#customer_email').parent().parent().parent().find('span.error').html('');
          $('#customer_email').parent().find('span.error').html('Please Enter Customer Email');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (customer_mobile == "") {
          $('#customer_mobile').parent().parent().parent().find('span.error').html('');
          $('#customer_mobile').parent().find('span.error').html('Please Enter Customer Mobile No');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (customer_address1 == "") {
          $('#customer_address1').parent().parent().parent().find('span.error').html('');
          $('#customer_address1').parent().find('span.error').html('Enter Address1'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (ship_length == "") {
          $('#ship_length').parent().parent().parent().find('span.error').html('');
          $('#ship_length').parent().find('span.error').html('Enter Ship Length');
          $(".se-pre-con").fadeOut("slow");            
          return false;
      }
      if (ship_width == "") {
          $('#ship_width').parent().parent().parent().find('span.error').html('');
          $('#ship_width').parent().find('span.error').html('Enter Ship Width'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (ship_height == "") {
          $('#ship_height').parent().parent().parent().find('span.error').html('');
          $('#ship_height').parent().find('span.error').html('Enter Ship Height'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (phy_weight == "") {
          $('#phy_weight').parent().parent().parent().find('span.error').html('');
          $('#phy_weight').parent().find('span.error').html('Enter physical Weight'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (product_mrp == "") {
          $('#product_mrp').parent().parent().parent().find('span.error').html('');
          $('#product_mrp').parent().find('span.error').html('Enter Product MRP'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (product_description == "") {
          $('#product_description').parent().parent().parent().find('span.error').html('');
          $('#product_description').parent().find('span.error').html('Enter Product Description');
          $(".se-pre-con").fadeOut("slow");
          return false;
      }
      if (product_group == "") {
          $('#product_group').parent().parent().parent().find('span.error').html('');
          $('#product_group').parent().find('span.error').html('Enter Product Group'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (order_no == "") {
          $('#order_no').parent().parent().parent().find('span.error').html('');
          $('#order_no').parent().find('span.error').html('Enter Order No');
          $(".se-pre-con").fadeOut("slow");            
          return false;
      }
      if (sub_order_no == "") {
          $('#sub_order_no').parent().parent().parent().find('span.error').html('');
          $('#sub_order_no').parent().find('span.error').html('Enter Sub Order No'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (order_type == "") {
          $('#order_type').parent().parent().parent().find('span.error').html('');
          $('#order_type').parent().find('span.error').html('Please select atleast one'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (order_type == "cod") {
        if (cod_amount == "0") {
          $('#cod_amount').parent().parent().parent().find('span.error').html('');
          $('#cod_amount').parent().find('span.error').html('Enter COD Charge');
          $(".se-pre-con").fadeOut("slow");            
          return false;
        }
      }
      if (quantity == "") {
          $('#quantity').parent().parent().parent().find('span.error').html('');
          $('#quantity').parent().find('span.error').html('Enter Quantity'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if (package_count == "") {
          $('#package_count').parent().parent().parent().find('span.error').html('');
          $('#package_count').parent().find('span.error').html('Enter Package count');
          $(".se-pre-con").fadeOut("slow");            
          return false;
      }
      if (logistics != "delhivery") {
          $('#delhivery').parent().parent().parent().find('span.error').html('');
          $('#delhivery').parent().find('span.error').html('Please Select'); 
          $(".se-pre-con").fadeOut("slow");           
          return false;
      }
      if(pickup_address != '' && type_of_shipment != '' && pincode != '' && state != '' && city != '' && customer_name != '' && customer_email != '' && customer_mobile != '' && customer_address1 != '' && ship_length != '' && ship_width != '' && ship_height != '' && phy_weight != '' && product_mrp != '' && product_description != '' && product_group != '' && order_no != '' && sub_order_no != '' && order_type != '' && quantity != '' && package_count != '' && delhivery != ''){

        $(".se-pre-con").fadeIn("slow");
        $.ajax({
          url     : url,
          type: "post",
          data: new FormData(form),
          processData: false,
          contentType: false,
          success: function(response){
            $(".se-pre-con").fadeOut("slow");
            var message = $.parseJSON(response);
            $.each( message, function( index, value ){
              if(index == 'error'){key1= value;}
              else if(index == 'success'){key2 = value;}
              else if(index == 'shipping_charge'){key3 = value;}
              else if(index == 'order_id'){key4 = value;}
            });
            if (key2 != "" && key4 !="") {
              $('#exampleModal').modal('toggle');
              $('.modal-body').html('<div class="modal_buttons"><button type="button" class="btn btn-primary pay_with_wallet" id="pay_with_wallet" value="pay_with_wallet"> Pay with Wallet </button><br><br><button type="button" class="btn btn-success pay_with_razorpay" value="pay_with_razorpay" id="pay_with_razorpay"> Pay with Razorpay </button><input type="hidden" name="order_id" class="modal_order_id" id="modal_order_id" value="'+key4+'"><input type="hidden" name="modal_order_amount" class="modal_order_amount" id="modal_order_amount" value="'+key3+'"></div>');
            }
            else if(key1 != ""){
              $('#exampleModal').modal('hide');
              $("#result_error_message").fadeIn("slow").html(key1);
              setTimeout(function() {
                $("#result_error_message").fadeOut("slow");
                //location.reload();
              }, 5000); 
            }
          }
        });
      }
    });

    var walleturl = hiddenurl+'admin/payment_insert_by_wallet';
    $("#exampleModal").on("click", "#pay_with_wallet", function() {
      $(".se-pre-con").fadeIn("slow");
      var order_id = $('#modal_order_id').val();
      $.ajax({
        url     : walleturl,
        type: "post",
        data: {order_id:order_id},
        success: function(response){
          $(".se-pre-con").fadeOut("slow");
          var message = $.parseJSON(response);
          $.each( message, function( index, value ){
            if(index == 'success'){key1= value;}
            else if(index == 'error'){key2 = value;}
            else if(index == 'status'){key3 = value;}
          });
          if (key1 != '') {
              $('#exampleModal').modal('hide');
            $("#result_message").fadeIn("slow").html(key1);
            setTimeout(function() {
              $("#result_message").fadeOut("slow");
                window.location.href = hiddenurl+'view-order';
            }, 4000);
          }
          else if(key2 != '') {
              $('#exampleModal').modal('hide');
            $("#result_error_message").fadeIn("slow").html(key2);
            setTimeout(function() {
              $("#result_error_message").fadeOut("slow");
              //location.reload();
            }, 4000);
          }
        }
      });
    });

    var razorpayurl = hiddenurl+'admin/payment_insert';
    //$('#pay_with_razorpay').on('click', function(e){
    $("#exampleModal").on("click", "#pay_with_razorpay", function(e) {
      $(".se-pre-con").fadeIn("slow");
      var order_id = $('#modal_order_id').val();
      var totalAmount = $('#modal_order_amount').val();
      var options = {
        "key": "rzp_test_Efkd0I5ZK2BIAe",
        "amount": (totalAmount*100),
        "name": "ShipSecure",
        "description": "Order Payment",
        "image": "https://shipsecurelogistics.com/assets/front-end/images/logo.png",
        "handler": function (response){
          $(".se-pre-con").fadeOut("slow");
          $.ajax({
            url: razorpayurl,
            type: 'post',
            dataType: 'json',
            data: {
              razorpay_payment_id: response.razorpay_payment_id , razorpay_order_id: response.razorpay_order_id , razorpay_signature: response.razorpay_signature , totalAmount : totalAmount , order_id:order_id,
            },
            success: function (data) {
              $(".se-pre-con").fadeOut("slow");
              var message = JSON.parse(JSON.stringify(data));
              $.each( message, function( index, value ){
                if(index == 'success'){key1= value;}
                else if(index == 'error'){key2 = value;}
                else if(index == 'status'){key3 = value;}
              });
              if (key1 != '') {
              $('#exampleModal').modal('hide');
                $("#result_message").fadeIn("slow").html(key1);
                setTimeout(function() {
                  $("#result_message").fadeOut("slow");
                  window.location.href = hiddenurl+'view-order';
                }, 4000);
              }
              else if(key2 != '') {
              $('#exampleModal').modal('hide');
                $("#result_error_message").fadeIn("slow").html(key2);
                setTimeout(function() {
                  $("#result_error_message").fadeOut("slow");
                  //location.reload();
                }, 4000);
              }
            }
          });
        },
        "theme": {
          "color": "#528FF0"
        }
      };
      var rzp1 = new Razorpay(options);
      rzp1.open();
      e.preventDefault();
    });
  });
</script> -->
