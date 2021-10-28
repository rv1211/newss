var file_name;
	$(function ()
	{
		var btnUpload = $('#upload1');
		var status = $('#status1');
		var type = '1';
		new AjaxUpload(btnUpload, {
			action: '//manage.ithinklogistics.com/onboard-upload-documents.php',
			name: 'uploadfile',
			onSubmit: function (file, ext)
			{
				if (!(ext && /^(jpg|png|jpeg|pdf)$/.test(ext)))
				{
					$('#status1').html('<p style="color:#d05165;margin-left:10px">Only JPG, JPEG, PNG or PDF files are allowed.</p>');
					$('#files1').html('<center><i class="icon  icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
					return false;
				}
				document.getElementById('files1').innerHTML = '<center><img src="//manage.ithinklogistics.com/assets/images/loading.gif" style="width:30px;margin-top:35px"></center>';
			},
			onComplete: function (file, response)
			{
				var file_name_split = response.split("$$");
				file = file_name_split[1];
				file1 = file_name_split[0];
				if (file1 === "success")
				{
					document.getElementById('file_name1').value = file;
					$('<li></li>').add('#files1').html('<img src="//manage.ithinklogistics.com/assets/images/upload_icon.svg" style="margin-bottom:30px;width:70px;height: 70px;"  alt="" /><div style="clear:both"></div><center><a class="" style="cursor:pointor" onclick="delete_upload(1)"><i style="font-size: 12px;" class="icon icon-trash text-danger"></i><div style="clear:both"></div> </a></center>').addClass('success');
					$('input').attr('title', ' ');
				}
				else if (response == 'size_error')
				{
					$('#status1').html('<p style="color:#d05165;margin-left:10px">Please upload image with max size 5MB.</p>');
					$('#files1').html('<center><i class="icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
					return false;
				}
				else
				{
					$('<li></li>').add('#files1').text(file).addClass('error');
				}
			}
		});
	});
	var file_name;
	$(function ()
	{
		var btnUpload = $('#upload2');
		var status = $('#status2');
		var type = '2';
		new AjaxUpload(btnUpload, {
			action: '//manage.ithinklogistics.com/onboard-upload-documents.php',
			name: 'uploadfile',
			onSubmit: function (file, ext)
			{
				if (!(ext && /^(jpg|png|jpeg|pdf)$/.test(ext)))
				{
					$('#status2').html('<p style="color:#d05165;margin-left:10px">Only JPG, JPEG, PNG or PDF files are allowed.</p>');
					$('#files2').html('<center><i class="icon  icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
					return false;
				}
				document.getElementById('files2').innerHTML = '<center><img src="//manage.ithinklogistics.com/assets/images/loading.gif" style="width:30px;margin-top:35px"></center>';
			},
			onComplete: function (file, response)
			{
				var file_name_split = response.split("$$");
                file = file_name_split[1];
                file1 = file_name_split[0];

                if (file1 === "success")
                {
                    document.getElementById('file_name2').value = file;
                    /*	                            $('<li></li>').add('#files2').html('<img src="//manage.ithinklogistics.com/uploads/customer/documents/size_450/' + file + '" style="margin-bottom:10px;width:150px;height:150px;"  alt="" /><div style="clear:both"></div><center><a class="" style="cursor:pointor" onclick="delete_upload(2)"><i class="icon icon-subtract"></i><div style="clear:both"></div>DELETE </a></center>').addClass('success');
                    	                        $('input').attr('title', ' ');*/

                    	                            $('<li></li>').add('#files2').html('<img src="//manage.ithinklogistics.com/assets/images/upload_icon.svg" style="margin-bottom:30px;width:70px;height: 70px;"  alt="" /><div style="clear:both"></div><center><a class="" style="cursor:pointor" onclick="delete_upload(2)"><i style="font-size: 12px;" class="icon icon-trash text-danger"></i><div style="clear:both"></div> </a></center>').addClass('success');
                    	                        $('input').attr('title', ' ');
                }
                else if (response == 'size_error')
                {
                    $('#status2').html('<p style="color:#d05165;margin-left:10px">Please upload image with max size 5MB.</p>');
                    $('#files2').html('<center><i class="icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
                    return false;
                }
                else
                {
                    $('<li></li>').add('#files2').text(file).addClass('error');
                }
            }
        });
    });
	var file_name;
    $(function ()
    {
        var btnUpload = $('#upload3');
        var status = $('#status3');
        var type = '3';
        new AjaxUpload(btnUpload, {
            action: '//manage.ithinklogistics.com/onboard-upload-documents.php',
            name: 'uploadfile',
            onSubmit: function (file, ext)
            {
                if (!(ext && /^(jpg|png|jpeg|pdf)$/.test(ext)))
                {

                    $('#status3').html('<p style="color:#d05165;margin-left:10px">Only JPG, JPEG, PNG or PDF files are allowed.</p>');
                    $('#files3').html('<center><i class="icon  icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
                    return false;
                }
                document.getElementById('files3').innerHTML = '<center><img src="//manage.ithinklogistics.com/assets/images/loading.gif" style="width:30px;margin-top:35px"></center>';
            },
            onComplete: function (file, response)
            {
                var file_name_split = response.split("$$");
                file = file_name_split[1];
                file1 = file_name_split[0];

                if (file1 === "success")
                {
                    document.getElementById('file_name3').value = file;
                    /*	                            $('<li></li>').add('#files3').html('<img src="//manage.ithinklogistics.com/uploads/customer/documents/size_450/' + file + '" style="margin-bottom:10px;width:150px;height:150px;"  alt="" /><div style="clear:both"></div><center><a class="" style="cursor:pointor" onclick="delete_upload(3)"><i class="icon icon-subtract"></i><div style="clear:both"></div>DELETE </a></center>').addClass('success');
                    	                        $('input').attr('title', ' ');*/

                    	                            $('<li></li>').add('#files3').html('<img src="//manage.ithinklogistics.com/assets/images/upload_icon.svg" style="margin-bottom:30px;width:70px;height: 70px;"  alt="" /><div style="clear:both"></div><center><a class="" style="cursor:pointor" onclick="delete_upload(3)"><i style="font-size: 12px;" class="icon icon-trash text-danger"></i><div style="clear:both"></div> </a></center>').addClass('success');
                    	                        $('input').attr('title', ' ');
                }
                else if (response == 'size_error')
                {
                    $('#status3').html('<p style="color:#d05165;margin-left:10px">Please upload image with max size 5MB.</p>');
                    $('#files3').html('<center><i class="icon-add" style="color:#3333FF;font-size: 20px;margin-top: 20px;"></i><div style="clear:both"></div></center>');
                    return false;
                }
                else
                {
                    $('<li></li>').add('#files3').text(file).addClass('error');
                }
            }
        });
    });
    function select_profile_type(selected)
    {
    	if(selected == 'company')
    	{
    		$('#company_type_div').css('display','block');
    		$('#company_name_div').css('display','block');
    		$('#company_type').attr('data-parsley-required', 'true');
    		$('input[name=company_name]').attr('data-parsley-required', 'true');
    	
    		
    		$('select[name=address_proof_type] option[value="aadhar card"]').remove();
    		$('select[name=address_proof_type] option[value="driving license"]').remove();
    		$('select[name=address_proof_type] option[value="valid passport"]').remove();
    		$('select[name=address_proof_type] option[value="voter id card"]').remove();
    	
    	
    		$("select[name=address_proof_type]").append('<option value="company incorporation document">Company Incorporation Document</option>');
    	
    	    
    	}
    	else
    	{
    		$('#company_type_div').css('display','none');
    		$('#company_name_div').css('display','none');
    		$('#company_type').attr('data-parsley-required', 'false');
    		$('input[name=company_name]').attr('data-parsley-required', 'false');
    	    
    	    $('select[name=address_proof_type] option[value="aadhar card"]').remove();
    		$('select[name=address_proof_type] option[value="driving license"]').remove();
    		$('select[name=address_proof_type] option[value="valid passport"]').remove();
    		$('select[name=address_proof_type] option[value="voter id card"]').remove();
    	
    		$("select[name=address_proof_type]").append('<option value="aadhar card">Aadhar Card</option>');
    		$("select[name=address_proof_type]").append('<option value="driving license">Driving License</option>');
    		$("select[name=address_proof_type]").append('<option value="valid passport">Valid Passport</option>');
    		$("select[name=address_proof_type]").append('<option value="voter id card">Voter id card</option>');
    	    $('select[name=address_proof_type] option[value="company incorporation document"]').remove();
    	    $('select[name=address_proof_type] option[value="gst certificate"]').remove();
    	
    		
    	}
    }
    function delete_upload(delete_file_id)
    {
        $('#files' + delete_file_id).html('<center style="margin-top: 20px;"><i class="icon icon-add"></i><div style="clear:both"></div></center>');
        $('#file_name' + delete_file_id).val("");
    }
			//file upload end
    $('#order_type,#is_reverse').on('change', function (e)
    {
        calculate_rate();
    });
    
	$('#ship_height,#ship_length,#ship_width,#phy_weight,#product_mrp,#cod_amount').on('keyup', function (e)
    {
        calculate_rate();
    });	
    var currentRequest = null;
	function calculate_rate()
    {

        
        var order_type  = $('#order_type').val();
        var pincode     = $('#pincode').val();
        var src_pincode     = $('#warehouse_pincode').val();
        var ship_height = $('#ship_height').val();
        var ship_length = $('#ship_length').val();
        var ship_width 	= $('#ship_width').val();
        var phy_weight  = $('#phy_weight').val();
        var product_mrp = $('#product_mrp').val();
        if(order_type != '' && pincode != '' && src_pincode != '' && ship_height != '' && ship_length != '' && ship_width != '' && phy_weight != '' && product_mrp != '')
        {
            
        
            if(order_type == 'cod')
			{
			    var product_mrp = $('#cod_amount').val();
			}
             var pst_data = {}
			pst_data["order_type"] = $("#order_type").val();
			pst_data["pincode"] = $("#pincode").val();
			pst_data["src_pincode"] = $("#warehouse_pincode").val();
			pst_data["ship_height"] = $("#ship_height").val();
			pst_data["ship_length"] = $("#ship_length").val();
			pst_data["ship_width"] = $("#ship_width").val();
			pst_data["phy_weight"] = $("#phy_weight").val();
			pst_data["product_mrp"] = product_mrp;
			
			pst_data["page_type"] = 'onboard_order';
            //$('#rate_table_div').css('displa');
            currentRequest = $.ajax(
            {
                url         : "//manage.ithinklogistics.com/calculate_rate_chart.php",
                type        : "POST",
                data        : pst_data,
                dataType    : 'json',
                encode      : true,
                async       : true,
                beforeSend  : function ()
                {
                    if(currentRequest != null) {
                        currentRequest.abort();
                    }
                	//$('#rate_table_div').css('display','none');
                	//$('#rate_chart_loading').css('display','block');
                    //$.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                },
                success     : function (data)
                {
                
                    $.unblockUI();
                    if (data.status === 'success')
                    {
                    	$('#rate_table_div').css('display','block');
                    	//$('#rate_chart_loading').css('display','none');
                        	
                      //  $('#calculate_rate_chart_form').trigger("reset");
                      //  $('#calculate_rate_chart_form').parsley().destroy();
                      	$('#delhivery_rate').html('Rs. '+data.billing.delhivery.itl_bill_with_gst);
                      	$('#fedex_rate').html('Rs. '+data.billing.fedex.itl_bill_with_gst);
                      	$('#xpressbees_rate').html('Rs. '+data.billing.xpressbees.itl_bill_with_gst);
                      	$('#ecom_rate').html('Rs. '+data.billing.ecom.itl_bill_with_gst);
                      	$('#ekart_rate').html('Rs. '+data.billing.ekart.itl_bill_with_gst);
                        
                        $("#delhivery").val(data.billing.delhivery.itl_bill_with_gst);
                        $("#fedex").val(data.billing.fedex.itl_bill_with_gst);
                        $("#xpressbees").val(data.billing.xpressbees.itl_bill_with_gst);
                        $("#ecom").val(data.billing.ecom.itl_bill_with_gst);
                        $("#ekart").val(data.billing.ekart.itl_bill_with_gst);
                        if(data.pincode_service_response_data !='')
                        {
                            $.each(data.pincode_service_response_data, function(key, value) 
                      		{
                      		    $("#"+key).attr('disabled', false);
                      			$("#"+key+"_image").html(''); 
                      		    var log_name = key;
                      		    var service_cod = value.cod;
                      			if(service_cod == 'N')
                      			{
                      			    $("#"+key).attr('disabled', true);
                      			    $("#"+key+"_image").html('Not serviceable');
                      			}
                      			
                      			
                      			
                      		});
                        }
                        var selected_logistics = $('input[type=radio][name=logistics]:checked').attr('id');
                        if(selected_logistics != '' && typeof selected_logistics != 'undefined')
                        {
                        	$('#total_summary').html('Rs. '+$("#"+selected_logistics).val());
                        }
                        
                        
                      //  $.notifyBar({cssClass: "success", html: data.html_message});

                      //  $('#client_id').select2('val', '-');
                      //  $('#customer_address_id').select2('val', '-');
                      //  $('#logistics_id').select2('val', '-');
                      //  $('#pickup_hour').select2('val', ' ');
                      //  $('#pickup_minute').select2('val', ' ');

                    }
                    else
                    {
                        $.notifyBar({cssClass: "error", html: data.html_message});
                    }
                },
                error       : function (data, errorThrown)
                {
                    $.unblockUI();
                    //$.notifyBar({cssClass: "error", html: "Error occured!"});
                }
            });
        }
    }
 	function select_order_type(order_type)
    {
        var order_type = order_type;
        if(order_type == 'cod')
        {
            $('#cod_amount').attr('data-parsley-required', 'true');
            $('#cod_amount_div').css("display","block");
        }
        else if(order_type == 'prepaid')
        {
            $('#cod_amount').attr('data-parsley-required', 'false');
             $('#cod_amount_div').css("display","none");
        }
    }

    function hideerror(value)
    {
    	console.log(value);
        if(value == '')
        {
            $('#error_div').css('display', 'block');
        }
        else
        {
            $('#error_div').css('display', 'none');
        }
    }
    $('#ship_length,#ship_width,#ship_height').on('keyup', function (e)
    {
        calculate_vol_weight();
    });
    function calculate_vol_weight()
    {
       	var length = $('#ship_length').val();
       	var width = $('#ship_width').val();
       	var height = $('#ship_height').val();
       	if(length != '' && width != '' && height != '' )
       	{
       		var vol_weight = (length * width * height)/5000;
       		var vol_weight = vol_weight.toFixed(3);
       		$('#calculate_vol_weight').val(vol_weight);
        }
       	else
       	{	
       		$('#calculate_vol_weight').val('');
       	}
    }
	$(document).ready(function ()
    {
    	$('#step'+1+'_div').css('display','block');
		$('#kyc_details_form').parsley();
		$('#kyc_details_form').on('submit', function (e)
        {
        	var document1 = $('select[name=address_proof_type]').val();
        	var document2 = $('select[name=id_proof_type]').val();
        	
        	$('#file1_error').html('');
        	$('#file2_error').html('');
        	$('#file3_error').html('');
        	
        	var file_name1 = $('#file_name1').val();
        	if(file_name1 == '')
        	{
        	    $('#file1_error').html('Document 1 not uploaded');
        	    	return false;
        	    //alert('FileName 1 not Update');
        	}
        	var file_name2 = $('#file_name2').val();
        	if(file_name2 == '')
        	{
        	    $('#file2_error').html('Document 2 not uploaded');
        	    	return false;
        	    //alert('FileName 2 not Update');
        	}
        	var file_name3 = $('#file_name3').val();
        	if(file_name3 == '')
        	{
        	    $('#file3_error').html('Cancelled Cheque not uploaded');
        	    	return false;
        	    //alert('FileName 3 not Update');
        	}
        	
        	 $('.document_error').html('');
        	if(document1 == document2)
        	{
        		 $('.document_error').html("Both Documents cannot be same");
        		return false;
        	}
        	if(!fnValidatePAN())
        	{
        		return false;
        	}
        	var gst_no = $('#gst_no').val();
        	if(!checksum(gst_no))
        	{
        		 $('.gst_error').html("Invaild GST No.");
        		 return false;
        	}
        	else
        	{
        		 $('.gst_error').html("");
        	}
        	e.preventDefault();
            var f = $(this);
            f.parsley().validate();
            if (f.parsley().isValid())

              var addKycform = hiddenUrl + 'admin/insert_kyc_form';
            {
				$.ajax(
                {
                    url             : addKycform,
                    type            : "POST",
                    data            : $('#kyc_details_form').serialize()+"&step_type=1",
                    dataType        : 'json',
                    encode          : true,
                    beforeSend      : function ()
                    {
                        $.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                    },
                    success         : function (data)
                    {
                        $.unblockUI();
                        
                        if (data.status == 'success')
                        {
                        	if(data.kyc_approval_message != '')	
                        	{
                        		$('.kyc_message').removeClass('text-danger').addClass('text-success').html('Your KYC will get verified shortly.');
                        	}
                        	else
                        	{
                        		step1_submit(1);
                        	}
                        }
                        else
                        {
                            $.notifyBar({cssClass: "error", html: data.html_message});
                        }
                    },
                    error           : function (data, errorThrown)
                    {
                        $.unblockUI();
                        $.notifyBar({cssClass: "error", html: "Error occured!"});
                    }

                });
            }
            else
            {
                e.preventDefault();
            }
        });
		$('#pickup_address_form').parsley();
		$('#pickup_address_form').on('submit', function (e)
        {
        	e.preventDefault();
            var f = $(this);
            f.parsley().validate();
            if (f.parsley().isValid())
            {
				$.ajax(
                {
                    url             : "//manage.ithinklogistics.com/onboard_wizard_submit.php",
                    type            : "POST",
                    data            : $('#pickup_address_form').serialize()+"&step_type=2",
                    dataType        : 'json',
                    encode          : true,
                    beforeSend      : function ()
                    {
                        $.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                    },
                    success         : function (data)
                    {
                        $.unblockUI();
                        
                        if (data.status == 'success')
                        {
                             step1_submit(2);
                        }
                        else
                        {
                            $.notifyBar({cssClass: "error", html: data.html_message});
                        }
                    },
                    error           : function (data, errorThrown)
                    {
                        $.unblockUI();
                        $.notifyBar({cssClass: "error", html: "Error occured!"});
                    }

                });
            }
            else
            {
                e.preventDefault();
            }
        });
		$('#add_order').parsley();
		$('#add_order').on('submit', function (e)
        {
            
            
        	e.preventDefault();
            var f = $(this);
            f.parsley().validate();
            if (f.parsley().isValid())
            {
            	
            		var logistics_id = $('input[type=radio][name=logistics]:checked').attr('id');
					$.ajax(
                    {
                        url             : "//manage.ithinklogistics.com/onboard_wizard_submit.php",
                        type            : "POST",
                        data            : $('#add_order').serialize()+"&step_type=3&logistics_id="+logistics_id,
                        dataType        : 'json',
                        encode          : true,
                        beforeSend      : function ()
                        {
                            $.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                        },
                        success         : function (data)
                        {
                            $.unblockUI();
                            
                            if (data.status == 'success')
                            {
                            	console.log(data);
                            	window.location.href = '//manage.ithinklogistics.com/'+data.filename;
                            	$.notifyBar({cssClass: "success", html: data.html_message});
                                 
                            }else if (data.status == 'error')
                            {
                                if(data.enable_wallet_modal == 1)
                                {
									open_wallet_modal();
                                }
                                $.notifyBar({cssClass: "error", html: data.html_message});
	                            
                            }
                            else
                            {
                                $.notifyBar({cssClass: "error", html: data.html_message});
                            }
                        },
                        error           : function (data, errorThrown)
                        {
                            $.unblockUI();
                            $.notifyBar({cssClass: "error", html: "Error occured!"});
                        }

                    });
            		
            	
            }
            else
            {
                e.preventDefault();
            }
        });

		

	});
	function checksum(g){

	    let regTest = /\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/.test(g)
	     if(regTest){
	        let a=65,b=55,c=36;
	        return Array['from'](g).reduce((i,j,k,g)=>{ 
	           p=(p=(j.charCodeAt(0)<a?parseInt(j):j.charCodeAt(0)-b)*(k%2+1))>c?1+(p-c):p;
	           return k<14?i+p:j==((c=(c-(i%c)))<10?c:String.fromCharCode(c+b));
	        },0); 
	    }
	    return regTest
	}
	function fnValidatePAN() {
	  var Obj = document.getElementById("textPanNo");
	  if (Obj == null) Obj = window.event.srcElement;
	  if (Obj.value != "") {
	    ObjVal = Obj.value;
	    var panPat = /^([a-zA-Z]{5})(\d{4})([a-zA-Z]{1})$/;
	    var code = /([C,P,H,F,A,T,B,L,J,G,c,p,h,f,a,t,b,l,j,g])/;
	    var code_chk = ObjVal.substring(3,4);
	    // if pan pattern not matched
	    if (ObjVal.search(panPat) == -1) {
	     $('.pan_error').html("Invaild PAN Card No.");
	      Obj.focus();
	      return false;
	    }
	    // if code pattern not matched
	    if (code.test(code_chk) == false) {
	      $('.pan_error').html("Invaild PAN Card No.");
	      return false;
	    }
	    if(ObjVal.search(panPat) != -1 && code.test(code_chk) != false)     {
	      //alert("Vaild PAN Card");
	      $('.pan_error').html('');
	      return true;
	    }
	  }
	}
	$('input[type=radio][name=logistics]').change(function() {
		
		$('#total_summary').html('Rs. '+this.value)
	});
    function create_order()
	{
		$('#wallet_modal').modal({
			   // backdrop: 'static',
			   // keyboard: false,
			   show: true
		});
		//$(".content").addClass("blur_bg");
		
	}

    function step1_submit(current_step)
    {
    	//var current_step = $(dis).data('step');
    	var current_step = current_step;
    	var next_step = current_step+1;
    	$('#step'+current_step+'_div').hide();
    	$('#step'+next_step+'_div').show();
    	if(next_step == 2)
    	{
    		$('#progress').css('width','30%');
    		$('.one').removeClass('no-color');
    		$('.one').addClass('primary-color');
    	}
    	if(next_step == 3)
    	{
    		$('#progress').css('width','60%');
    		$('.two').removeClass('no-color');
    		$('.two').addClass('primary-color');
    	}
    	
    	
	}
	function get_city_state(dis,ids)
	{	
		var pat1	= /^[0-9]{1,6}$/;
		var pincode =  dis.value;
		if(pat1.test(dis.value))
		{
		   
		    
			$.ajax(
            {
                url             : "//manage.ithinklogistics.com/get_state_city_selection.php",
                type            : "POST",
                data            : "pincode="+pincode,
                async           : true,
                dataType        : 'json',
                encode          : true,
                beforeSend      : function ()
                {
                    $.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                },
                success         : function (data)
                {
                    
                    $.unblockUI();
                    if (data.status == 'success')
                    {
                        var state_id = data.state_id;
                        var city_id = data.city_id;
                        var longitude = data.longitude;
                        var latitude = data.latitude;
						$('#warehouse_state'+ids).val(state_id).trigger('change');
						$('#warehouse_state_input_'+ids).val(state_id);
						get_city_selection(city_id,state_id,ids);
						if(ids == 1)//warehouse data
						{
						    $('#src_lat_input').val(latitude);
						    $('#src_lon_input').val(longitude);
						}
						if(ids == 2)
		                {
		                    var src_longitude = $('#src_lon_input').val();
		                    var src_latitude = $('#src_lat_input').val();
		                    calculate_rate();
		                	show_graph(src_latitude,src_longitude,latitude,longitude);
		                	
		                }
                    }
                    else
                    {
                        $.notifyBar({cssClass: "error", html: data.html_message});
                        $('#warehouse_state'+ids).select2("val", " ");
                        $('#customer_city_'+ids).select2("val", " ");
                        if(ids == 2)
                        {
                            $('#chartdiv').html('');
                            chart.clear();
                           
                        }
                       
                    }
                    
                },
                error           : function (data, errorThrown)
                {
                    $.unblockUI();
                    $.notifyBar({cssClass: "error", html: "Error occured!"});
                }

            });

		}
		else
		{
			$('#pincode').focus();
			return false;
		}

	}
	function step1_back(step)
	{
		var current_step = step+1;

		$('#step1_div').hide(1000);
		$('#step2_div').hide(1000);
		$('#step3_div').hide(1000);
		
    	$('#step'+step+'_div').show(200);
    		
    	if(step == 1)
    	{
    		$('#progress').css('width','10%');
    		
    		$('.one,.two,.three').removeClass('primary-color');
    		$('.one,.two,.three').addClass('no-color');
    	}
    	if(step == 2)
    	{
    		$('#progress').css('width','30%');
    		$('.one').removeClass('no-color');
    		$('.one').addClass('primary-color');
    		$('.two,.three').removeClass('primary-color');
    		$('.two,.three').addClass('no-color');
    	}
    	if(step == 3)
    	{
    		$('#progress').css('width','60%');
    		$('.two').removeClass('no-color');
    		$('.two').addClass('primary-color');
    		$('.one,.three').removeClass('primary-color');
    		$('.one,.three').addClass('no-color');
    	}
    	
	}
	function get_city_selection(city_id,state_id,form_id)
    {
       
        if (state_id > 0)
        {
            $.ajax(
            {
                url             : "//manage.ithinklogistics.com/get-onboard-city-selection-div.php",
                type            : "POST",
                data            : 
                {
                    "state_id"  : state_id,
                    "form_id"   : form_id
                },
                dataType        : 'json',
                encode          : true,
                async           : true,
                beforeSend      : function ()
                {
                    $.blockUI({message: '<img id="loading-image" src="//manage.ithinklogistics.com/assets/images/loading.gif" />'});
                },
                success         : function (data)
                {
                    $.unblockUI();

                    if (data.status == 'success')
                    {
                    	
                        $('#customer_city_'+form_id).empty();
                        var newOption = new Option('Select',' ');
                        $('#customer_city_'+form_id).append(newOption);
                        $.each(data.city_id_state_option, function(key, value) 
                  		{
                  			var newOption  = new Option(value,key);
                  			$('#customer_city_'+form_id).append(newOption);
                  			
                  		});
                  		$('#customer_city_'+form_id).val(city_id).trigger('change');
                    }
                    else
                    {
                        $('#city_selection_div').html("");
                    }
                },
                error           : function (data, errorThrown)
                {
                    $.unblockUI();
                    $.notifyBar({cssClass: "error", html: "Error occured!"});
                }
            });
        }
        else
        {
            $('#city_selection_div').html("");
            $('#' + form_id + '_city_id').attr('data-parsley-required', 'false');
            $('#customer_city').attr('data-parsley-required', 'false');
        }
    }
	function open_wallet_modal()
	{
		$('#wallet_modal').modal('show'); 
	}

    $('.select_amount').click(function(){
            $('.select_amount').css("background-color", "#F7F7FC")
            var data = $(this).attr('amount');
            $('#input_amount').val(data);
            
            $(this).css("background-color", "rgba(255, 205, 144, 0.52)")
        });
    $(window).scroll(function() {
        var browser_width = $(window).width();
        if(browser_width > 1024) {
            //alert('here');top: 58px;
	    	var wy = window.scrollY;
	    	//console.log(window.scrollY);
	    	$( "#graph_div" ).css('position','fixed');
    		$( "#graph_div" ).css('right','50px');
    		$( "#graph_div" ).css('width','46%');
	 
			if(wy <= 160)
	    	{
	    		var new1 = parseInt(140- wy);
	    		$( "#graph_div" ).css('top',new1+'px');
	    		
	    	}
        }
	});
		
	function show_razorpay()
	{
		
		
  		var rzp_amount = 0 + parseInt($('#input_amount').val())+'00';
        var amount = 0 + parseInt($('#input_amount').val());
        
        if(amount > 100 && amount <= 2500)
        {
            var options = {
                
                "key": "rzp_live_B3V9j1omCnhSCu", // Enter the Key ID generated from the Dashboard
                "amount": rzp_amount, // Amount is in currency subunits. Default currency is INR. Hence, 29935 refers to 29935 paise or INR 299.35.
                "currency": "INR",
                "name": "Ithink Logistics",
                "description": "Add Wallet Amount",
                "image": "assets/images/iTL_E5.jpg",
                "handler": function (response){
                	var res_id = response.razorpay_payment_id;
                
                	if(res_id != '' && typeof res_id != 'undefined')
                	{

                		$.ajax(
                        {
                            url         : "//manage.ithinklogistics.com/add-onboard-wallet-amount-submit.php",
                            type        : "POST",
                            data        : {"remarks":'Payment Made from RZP '+res_id+'',"amount":amount},
                            dataType    : 'json',
                            encode      : true,
                            beforeSend  : function ()
                            {
                                $.blockUI({message: '<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>'});
                            },
                            success     : function (data)
                            {
                                $.unblockUI();
                                if (data.status === 'success')
                                {
                                	var wallet_amount = data.wallet_amount;
                                	var logistics_id = $('input[type=radio][name=logistics]:checked').attr('id');
                                	 //var response = '<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered"><span class="text-semibold">Well done!</span> You successfully reacharged your wallet with Rs.'+amount+' .</div>';
                					$('#wallet_modal').modal('hide'); 	
                					 //$('#wallet_response1').css('display','block');
                					$('#current_wallet_amount_div').css('display','inline-block');
                					$('#current_wallet_amount').html('Rs. '+wallet_amount);
                					//document.getElementById('add_order').submit();
                					var btnSubmitTags = $('#order-submit');
                					btnSubmitTags.click();
                				}
                                else
                                {
                                    $.notifyBar({cssClass: "error", html: data.html_message});
                                }
                            },
                            error       : function (data, errorThrown)
                            {
                                $.unblockUI();
                                $.notifyBar({cssClass: "error", html: "Error occured!"});
                            }
                        });

                		// $('#wallet_modal').modal('hide'); 

                		// $(".content").removeClass("blur_bg");
                		
                		
                	}
                	else
                	{
            			var response = '<div class="alert alert-danger alert-styled-left alert-bordered"><span class="text-semibold">Oh snap!</span> Wallet Recharge transaction failed.</div>';
            			$('#wallet_modal_response').html(response);	
            			
            			show_razorpay();
            			
                	}
                    
                },
                "prefill": {
                    "name": "Dhruv Patel ",
                    "email": "Sagupatel777@gmail.com"
                },
                "notes": {
                    "address": "note value"
                },
                "theme": {
                    "color": "#F37254"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            //e.preventDefault();      
        }
        else
        {
        	$.notifyBar({cssClass: "error", html: "Wallet Amount min 100 and max limit 2500 Rs."});
        }
         
    }



 	$(".form-ajax").on("step_shown", function(event, data){
        //console.log(event);
        console.log(data.currentStep);
        if(data.currentStep == 'ajax-step3')
        {

        }
    });
    $("input[class*='inputnumbers']").keydown(input_numbers);
    $("input[class*='inputnumbersdots']").keydown(inputnumbersdots);
    function input_numbers (event) {


        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 110) {

        } else {
            event.preventDefault();
        }
    }
       function inputnumbersdots (event) {


       if (event.shiftKey == true) {
                    event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

        } else {
            event.preventDefault();
        }
        
        if($(this).val().indexOf('.') !== -1 && $(this).val().charAt(0) == '.' && (event.keyCode == 190 || event.keyCode == 110 ))
            event.preventDefault();

    }	
   
		function show_graph(src_lat,src_lon,des_lat,des_lon)
		{
		   if(src_lat != '' || src_lon != '' || des_lat != '' || des_lon != '')
           {
            /**
             * ---------------------------------------
             * This demo was created using amCharts 4.
             * 
             * For more information visit:
             * https://www.amcharts.com/
             * 
             * Documentation is available at:
             * https://www.amcharts.com/docs/v4/
             * ---------------------------------------
             */
            
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end
            
            // Create map instance
            var chart = am4core.create("chartdiv", am4maps.MapChart);
            chart.geodata = am4geodata_india2019High;
            // chart.projection = new am4maps.projections.Miller();
            chart.projection = new am4maps.projections.Miller();
            chart.homeZoomLevel = 3;
            chart.homeGeoPoint = {
                latitude:  parseFloat(des_lat),
                longitude: parseFloat(des_lon)
            };
            
            // Create map polygon series
            var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.useGeodata = true;
            polygonSeries.mapPolygons.template.fill = chart.colors.getIndex(0).lighten(0.5);
            polygonSeries.mapPolygons.template.nonScalingStroke = true;
            polygonSeries.exclude = ["AQ"];
            
            // Add line bullets
            var cities = chart.series.push(new am4maps.MapImageSeries());
            cities.mapImages.template.nonScaling = true;
            
            var city = cities.mapImages.template.createChild(am4core.Circle);
            city.radius = 6;
            city.fill = chart.colors.getIndex(0).brighten(-0.2);
            city.strokeWidth = 2;
            city.stroke = am4core.color("#fff");
            
            function addCity(coords, title) {
                var city = cities.mapImages.create();
                city.latitude = coords.latitude;
                city.longitude = coords.longitude;
                city.tooltipText = title;
                return city;
            }
            
            var pickup = addCity({ "latitude": parseFloat(src_lat), "longitude": parseFloat(src_lon)}, "pickup");
            var delivery = addCity({ "latitude": parseFloat(des_lat), "longitude": parseFloat(des_lon) }, "delivery");
            
            // Add lines
            var lineSeries = chart.series.push(new am4maps.MapArcSeries());
            lineSeries.mapLines.template.line.strokeWidth = 2;
            lineSeries.mapLines.template.line.strokeOpacity = 0.5;
            lineSeries.mapLines.template.line.stroke = city.fill;
            lineSeries.mapLines.template.line.nonScalingStroke = true;
            lineSeries.mapLines.template.line.strokeDasharray = "1,1";
            lineSeries.zIndex = 10;
            
            var shadowLineSeries = chart.series.push(new am4maps.MapLineSeries());
            shadowLineSeries.mapLines.template.line.strokeOpacity = 0;
            shadowLineSeries.mapLines.template.line.nonScalingStroke = true;
            shadowLineSeries.mapLines.template.shortestDistance = false;
            shadowLineSeries.zIndex = 5;
            
            function addLine(from, to) {
                var line = lineSeries.mapLines.create();
                line.imagesToConnect = [from, to];
                line.line.controlPointDistance = -0.3;
            
                var shadowLine = shadowLineSeries.mapLines.create();
                shadowLine.imagesToConnect = [from, to];
            
                return line;
            }
            
            addLine(pickup, delivery);
            
            // Add plane
            var plane = lineSeries.mapLines.getIndex(0).lineObjects.create();
            plane.position = 0;
            plane.width = 48;
            plane.height = 48;
            
            plane.adapter.add("scale", function(scale, target) {
                return 0.5 * (1 - (Math.abs(0.5 - target.position)));
            })
            
            var planeImage = plane.createChild(am4core.Sprite);
            planeImage.scale = 0.08;
            planeImage.horizontalCenter = "middle";
            planeImage.verticalCenter = "middle";
            planeImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
            planeImage.fill = chart.colors.getIndex(2).brighten(-0.2);
            planeImage.strokeOpacity = 0;
            
            var shadowPlane = shadowLineSeries.mapLines.getIndex(0).lineObjects.create();
            shadowPlane.position = 0;
            shadowPlane.width = 48;
            shadowPlane.height = 48;
            
            var shadowPlaneImage = shadowPlane.createChild(am4core.Sprite);
            shadowPlaneImage.scale = 0.05;
            shadowPlaneImage.horizontalCenter = "middle";
            shadowPlaneImage.verticalCenter = "middle";
            shadowPlaneImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
            shadowPlaneImage.fill = am4core.color("#000");
            shadowPlaneImage.strokeOpacity = 0;
            
            shadowPlane.adapter.add("scale", function(scale, target) {
                target.opacity = (0.6 - (Math.abs(0.5 - target.position)));
                return 0.5 - 0.3 * (1 - (Math.abs(0.5 - target.position)));
            })
            
            // Plane animation
            var currentLine = 0;
            var direction = 1;
            function flyPlane() {
            
                // Get current line to attach plane to
                plane.mapLine = lineSeries.mapLines.getIndex(currentLine);
                plane.parent = lineSeries;
                shadowPlane.mapLine = shadowLineSeries.mapLines.getIndex(currentLine);
                shadowPlane.parent = shadowLineSeries;
                shadowPlaneImage.rotation = planeImage.rotation;
            
                // Set up animation
                var from, to;
                var numLines = lineSeries.mapLines.length;
                if (direction == 1) {
                    from = 0
                    to = 1;
                    if (planeImage.rotation != 0) {
                        planeImage.animate({ to: 0, property: "rotation" }, 1000).events.on("animationended", flyPlane);
                        return;
                    }
                }
                else {
                    from = 1;
                    to = 0;
                    if (planeImage.rotation != 180) {
                        planeImage.animate({ to: 180, property: "rotation" }, 1000).events.on("animationended", flyPlane);
                        return;
                    }
                }
            
                // Start the animation
                var animation = plane.animate({
                    from: from,
                    to: to,
                    property: "position"
                }, 5000, am4core.ease.sinInOut);
                animation.events.on("animationended", flyPlane)
                /*animation.events.on("animationprogress", function(ev) {
                  var progress = Math.abs(ev.progress - 0.5);
                  //console.log(progress);
                  //planeImage.scale += 0.2;
                });*/
            
                shadowPlane.animate({
                    from: from,
                    to: to,
                    property: "position"
                }, 5000, am4core.ease.sinInOut);
            
                // Increment line, or reverse the direction
                currentLine += direction;
                if (currentLine < 0) {
                    currentLine = 0;
                    direction = 1;
                }
                else if ((currentLine + 1) > numLines) {
                    currentLine = numLines - 1;
                    direction = -1;
                }
            
            }
            
            // Go!
flyPlane();
           }   
           else
           {
              $('#chartdiv').html('');
               chart.clear();
               $('#graph_div').css('display','none');
           }
		}