$(function() {
  var hiddenurl = $('#hiddenUrl').val();
  var callUrl = hiddenurl+"home/email"; 
   $("form.signupform").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50
            },
            email: {
                required: true,
                email: true,
                maxlength: 255,
                remote: {
                    url: callUrl,
                    type: "post"
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            retype_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            phone: {
                required: true,
                number: true,
                maxlength: 15
            },
            website: {
                url : true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: {         
            name: {
                required: "Please Enter a Name.",
                maxlength: "You can enter 50 characters"
            },
            email: {
                required: "Please Enter an Email",
                email: "Please Enter valid email",
                maxlength: "You can enter 255 characters",
                remote: "Email Id already exist!"
            },
            password: {
                required: "Please Enter a password",
                minlength: "Your password must be at least 5 characters long"
            },
            retype_password: {
                required: "Please Enter a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password not match"
            },
            phone: {
                required: "Please Enter a Phone No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 15 characters"
            },
            website: {
                url : "Please Enter valid Website URL"
            }
        },
        submitHandler: function(form) {
          form.submit();
        }
    });

   $("form.enquiryform").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50
            },
            email: {
                required: true,
                email: true,
                maxlength: 255
            },
            contact_no: {
                required: true,
                number: true,
                maxlength: 10
            },
            tracking_number: {
                required: true,
                maxlength: 50
            },
            captcha: {
                required: true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: {         
            name: {
                required: "Please Enter a Name.",
                maxlength: "You can enter 50 characters"
            },
            email: {
                required: "Please Enter an Email",
                email: "Please Enter valid email",
                maxlength: "You can enter 255 characters"
            },
            contact_no: {
                required: "Please Enter a Phone No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 10 characters"
            },
            tracking_number: {
                required: "Please Enter an Airwaybill No",
                maxlength: "You can enter only 50 characters"
            },
            captcha: {
                required: "Please Enter a Captcha code"
            }
        },
        submitHandler: function(form) {
          //form.submit();
          $('#button').prop('disabled', true);
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });

   $("form.form_kyc_verification").validate({
        rules: {
            profile_type: {
                required: true
            },
            name: {
                required: true
            },
            pan_no: {
                required: true,
                maxlength:15
            },
            gst_no: {
                required: true,
                maxlength:15
            },
            address_proof_type: {
                required: true
            },
            file_name1: {
                required: true
            },
            id_proof_type: {
                required: true
            },
            file_name2: {
                required: true
            },
            file_name3: {
                required: true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: {         
            profile_type: {
                required: "Please Select Profile Type.",
            },
            name: {
                required: "Please Enter a Name",
            },
            pan_no: {
                required: "Please Enter a Pan no",
                maxlength: "you can only enter 10 characters"
            },
            gst_no: {
                required: "Please Enter a GST no",
                maxlength: "you can only enter 15 characters"
            },
            address_proof_type: {
                required: "Please Select Documet1"
            },
            file_name1: {
                required: "Please upload image for Document1"
            },
            id_proof_type: {
                required: "Please Select Document2"
            },
            file_name2: {
                required: "Please upload image for Document2"
            },
            file_name3: {
                required: "Please upload cancelled chaque"
            }
        },
        submitHandler: function(form) {
          //form.submit();
          //$(".se-pre-con").fadeIn("slow");
          $(".se-pre-con").show();
          $('#add_kyc').prop('disabled', true);
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });


    
    
    var addPickupaddress = hiddenurl+"admin/check_duplicate_name";
   $("form.form_pickup_address").validate({
        rules: {
            warehouse_name: {
                required: true,
                remote:{
                    url: addPickupaddress,
                    type: "post"
                }
            },
            warehouse_contact_person: {
                required: true
            },
            warehouse_contact_no: {
                required: true,
                number: true,
                maxlength: 10
            },
            warehouse_email: {
                required: true,
                email: true
            },
            warehouse_address_1: {
                required: true
            },
            warehouse_pincode: {
                required: true,
                number: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: {         
            warehouse_name: {
                required: "Please Enter a Name.",
                remote: "Warehouse Name Already exists"
            },
            warehouse_contact_person: {
                required: "Please Enter contact person name"
            },
            warehouse_contact_no: {
                required: "Please Enter a contact No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 10 characters"
            },
            warehouse_email: {
                required: "Please Enter an email",
                email: "Enter valid email id"
            },
            warehouse_address_1: {
                required: "Please Enter a address1"
            },
            warehouse_pincode: {
                required: "Please Enter a pincode",
                number: "Please Enter numbers only"
            },
            state: {
                required: "Please Enter a state"
            },
            city: {
                required: "Please Enter a city"
            }
        },
        submitHandler: function(form) {
          //form.submit();
          $('.add_pickup').prop('disabled', true);
          $(".se-pre-con").fadeIn("slow");
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });
   $("form.form_pickup_address_edit").validate({
        rules: {
            warehouse_contact_person: {
                required: true
            },
            warehouse_contact_no: {
                required: true,
                number: true,
                maxlength: 10
            },
            warehouse_email: {
                required: true,
                email: true
            },
            warehouse_address_1: {
                required: true
            },
            warehouse_pincode: {
                required: true,
                number: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: { 
            warehouse_contact_person: {
                required: "Please Enter contact person name"
            },
            warehouse_contact_no: {
                required: "Please Enter a contact No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 10 characters"
            },
            warehouse_email: {
                required: "Please Enter an email",
                email: "Enter valid email id"
            },
            warehouse_address_1: {
                required: "Please Enter a address1"
            },
            warehouse_pincode: {
                required: "Please Enter a pincode",
                number: "Please Enter numbers only"
            },
            state: {
                required: "Please Enter a state"
            },
            city: {
                required: "Please Enter a city"
            }
        },
        submitHandler: function(form) {
          //form.submit();
          $('.add_pickup').prop('disabled', true);
          $(".se-pre-con").fadeIn("slow");
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });

   $("form.form_order_create").validate({
        rules: {
            pincode: {
                required: true,
                maxlength: 6
            },
            state:{
                required: true
            },
            city:{
                required: true
            },
            customer_name:{
                required: true
            },
            customer_email: {
                required: true,
                email: true,
                maxlength: 255
            },
            customer_mobile: {
                required: true,
                number: true,
                maxlength: 10
            },
            /*customer_phone: {
                required: true,
                number: true,
                maxlength: 10
            },*/
            customer_address1: {
                required: true,
                maxlength: 80
            },
            customer_address2: {
                maxlength: 80
            },
            ship_length: {
                required: true
            },
            ship_width: {
                required: true
            },
            ship_height: {
                required: true
            },
            product_mrp: {
                required: true
            },
            phy_weight: {
                required: true
            },
            product_description: {
                required: true
            },
            product_group: {
                required: true
            },
            order_no: {
                required: true
            },
            sub_order_no: {
                required: true
            },
            is_reverse: {
                required: true
            },
            order_type: {
                required: true
            },
            quantity: {
                required: true
            },
            logistics:{
                required: true
            },
            pickup_address:{
                required: true
            }
        },
        errorElement: 'span',
        focusInvalid: false,
        ignore: ".ignore",
        messages: {         
            pincode: {
                required: "Please Enter a Pincode.",
                maxlength: "You can enter 6 characters"
            },
            state:{
                required: "Please Enter a State."
            },
            city:{
                required: "Please Enter a City."
            },
            customer_name:{
                required: "Please Enter a Name."
            },
            customer_email: {
                required: "Please Enter an Email",
                email: "Please Enter valid email",
                maxlength: "You can enter 255 characters"
            },
            customer_mobile: {
                required: "Please Enter a Mobile No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 10 characters"
            },
            /*customer_phone: {
                required: "Please Enter a Mobile No",
                number: "Please Enter Number only",
                maxlength: "You can enter only 10 characters"
            },*/
            customer_address1: {
                required: "Please Enter an Address",
                maxlength: "You can enter less than 80 characters"
            },
            customer_address2: {
                maxlength: "You can enter less than 80 characters"
            },
            ship_length: {
                required: "Please Enter a Length"
            },
            ship_width: {
                required: "Please Enter a Width"
            },
            ship_height: {
                required: "Please Enter a Height"
            },
            product_mrp: {
                required: "Please Enter a value"
            },
            phy_weight: {
                required: "Please Enter a Physical Weight"
            },
            product_description: {
                required: "Please Enter a Description"
            },
            product_group: {
                required: "Please Enter a Product group"
            },
            order_no: {
                required: "Please Enter a Order No"
            },
            sub_order_no: {
                required: "Please Enter a Sub Order No"
            },
            is_reverse: {
                required: "Please Select"
            },
            order_type: {
                required: "Please Select"
            },
            quantity: {
                required: "Please Enter a Quantity"
            },
            logistics:{
                required: "Please Select"
            },
            pickup_address:{
                required: "Please Select Pickup Address"
            }
        },
        submitHandler: function(form) {
          $('#order-submit').prop('disabled', true);
          form.submit();
          /*$(".se-pre-con").fadeIn("slow");
          form[0].submit();*/
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });

    
    var metrocity_id = $('#metrocity_id').val();
    if(metrocity_id != ''){
        var addMetrocity = hiddenurl+"metrocity/check_duplicate/"+metrocity_id;
    } else{
        var addMetrocity = hiddenurl+"metrocity/check_duplicate";
    }
    $("form.form_metrocity").validate({
        rules: {
            metrocity_name: {
                required: true,
                remote: {
                    url: addMetrocity,
                    type: "post"
                }
            }
        },
        messages: {
            metrocity_name: {
                required: "Please Enter a Metrocity Name.",
                remote: "Metrocity Name already exists."
            }
        },
        submitHandler: function(form) {
            //form.submit();
            $(".se-pre-con").fadeIn("slow");
            $('#add_metrocity_button').prop('disabled', true);
            form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });


    var rule_id = $('#rule_id').val();
    if(rule_id != ''){
        var addRule = hiddenurl+"rule/check_duplicate/"+rule_id;
        var addRuleweight = hiddenurl+"rule/check_duplicate_weight/"+rule_id;
    } else{
        var addRule = hiddenurl+"rule/check_duplicate";
        var addRuleweight = hiddenurl+"rule/check_duplicate_weight";
    }
    $("form.form_rule").validate({
        rules: {
            rule_name: {
                required: true,
                remote: {
                    url: addRule,
                    type: "post"
                },
            },
            rule_start_weight:{
                required: true,
            },
            rule_end_weight:{
                required: true,
            },
        },
        messages: {
            rule_name: {
                required: "Please Enter a Rule Name.",
                remote: "Rule Name already exists."
            },
            rule_start_weight:{
                required: "Please Enter a Start Weight.",
            },
            rule_end_weight:{
                required: "Please Enter a End Weight.",
            }
        },
        submitHandler: function(form) {
          $(".se-pre-con").fadeIn("slow");
          form.submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });


    var zone_id = $('#zone_id').val();
    if(zone_id != ''){
        var addZone = hiddenurl+"zone/check_duplicate/"+zone_id;
        var addZoneprice = hiddenurl+"zone/check_duplicate_price/"+zone_id;
    } else{
        var addZone = hiddenurl+"zone/check_duplicate";
        var addZoneprice = hiddenurl+"zone/check_duplicate_price";
    }
    $("form.form_zone").validate({
        rules: {
            zone_name: {
                required: true,
                remote: {
                    url: addZone,
                    type: "post"
                }
            },
            zone_start_distance: {
                required: true,
            },
            zone_end_distance: {
                required: true,
            }
        },
        messages: {
            zone_name: {
                required: "Please Enter a Zone Name.",
                remote: "Zone Name already exists."
            },
            zone_start_distance: {
                required: "Please Enter a Start Distance.",
            },
            zone_end_distance: {
                required: "Please Enter a End Distance.",
            }
        },
        submitHandler: function(form) {
          //form.submit();
          $(".se-pre-con").fadeIn("slow");
          $('#add_zone_button').prop('disabled', true);
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });


    $("#zone_start_distance, #zone_end_distance, #zone_for").on('change',function(){
            $(".se-pre-con").fadeIn("slow");

        var zone_start_distance = $('#zone_start_distance').val();
        var zone_end_distance = $('#zone_end_distance').val();
        var zone_for = $('#zone_for').val();
        $.ajax({
          type    : 'POST',
          url     : addZoneprice,
          data: {"zone_start_distance":zone_start_distance,"zone_end_distance":zone_end_distance,"zone_for":zone_for},
          dataType  : 'HTML',
          success: function(response){
            $(".se-pre-con").fadeOut("slow");
            if(response == 'false'){
                $("#zone_start_distance").addClass('priceerror');
                $("#zone_end_distance").addClass('priceerror');
                $("#zone_for").addClass('priceerror');
            }if(response == 'true'){
                $("#zone_start_distance").removeClass('priceerror');
                $("#zone_end_distance").removeClass('priceerror');
                $("#zone_for").removeClass('priceerror');
            }
          }
        });
    });


    $("#rule_start_weight, #rule_end_weight").on('change',function(){
            $(".se-pre-con").fadeIn("slow");

        var rule_start_weight = $('#rule_start_weight').val();
        var rule_end_weight = $('#rule_end_weight').val();
        $.ajax({
          type    : 'POST',
          url     : addRuleweight,
          data: {"rule_start_weight":rule_start_weight,"rule_end_weight":rule_end_weight},
          dataType  : 'HTML',
          success: function(response){
            $(".se-pre-con").fadeOut("slow");
            //console.log(response);
            if(response == 'false'){
                $("#rule_start_weight").addClass('priceerror');
                $("#rule_end_weight").addClass('priceerror');
            }if(response == 'true'){
                $("#rule_start_weight").removeClass('priceerror');
                $("#rule_end_weight").removeClass('priceerror');
            }
          }
        });
    });



    var manage_shipping_price_id = $('#manage_shipping_price_id').val();
    if(manage_shipping_price_id != ''){
        var addShippingprice = hiddenurl+"manageshippingprice/check_duplicate/"+manage_shipping_price_id;
    } else{
        var addShippingprice = hiddenurl+"manageshippingprice/check_duplicate";
    }
    $("form.form_shippingprice").validate({
        rules: {
            zone_id: {
                required: true,
                remote: {
                    url: addShippingprice,
                    type: "post",
                    data: {'rule_id':function(){return $('#rule_id').val()}},
                    async:false
                }
            },
            rule_id:{
                required: true,
                remote: {
                    url: addShippingprice,
                    type: "post",
                    data: {'zone_id':function(){return $('#zone_id').val()}},
                    async:false
                }
            },
            value:{
                required: true
            }
        },
        messages: {         
            zone_id: {
                required: "Please select Zone.",
                remote: "Already exists."
            },
            rule_id:{
                required: "Please select Rule.",
                remote: "Already exists."
            },
            value:{
                required: "Enter Value for Shipping Price"
            }
        },
        submitHandler: function(form) {
          //form.submit();
          $(".se-pre-con").fadeIn("slow");
          $('#add_shippingprice_button').prop('disabled', true);
          form[0].submit();
        }, invalidHandler: function(form){
            $(".se-pre-con").hide();
        }
    });




}); 