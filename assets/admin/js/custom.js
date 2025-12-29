// JavaScript Document
//var bse_url = "/";

var bse_url = "http://localhost/supported-vehicle";//"/vh-admin";
var adm_bse_url = bse_url+"/";

$().ready(function(){
$("#login_form").validate({
		rules:{
				user_name : {
					required: true,
					email: true
				},
				password :  {
					required: true,
					minlength : 5,
					maxlength : 20
				},
		},
		messages:{
			user_name : "Please enter your email",
			password: {
				required: "Please enter password",
				minlength: "Password must contain at least 5 characters and maximum 20 characters.",
				maxlength: "assword must contain at least 5 characters and maximum 20 characters."
		},
		},submitHandler: function(form) {
		 var response = grecaptcha.getResponse();
		  if (response.length == 0) {
			 $('.captcha_error').removeClass('hide');		
			 setTimeout(function() {
				 $('.captcha_error').addClass('hide');
			 }, 2000);
			return false;
		  }else {
			  form.submit();
		  }			
	  }
	})		
})

$(document).on('click', '.HideAutoProPAD', function(){
	var value = 0;
	if( $(this).is(':checked') ){
		$('.AutoProPAD').addClass('hide');
		value = 1;
	}else{
		$('.AutoProPAD').removeClass('hide')
		value = 0;
	}
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/HideAutoProPAD',
		  type: 'POST',
		  data: {remember: value,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){			  
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('change', '.filterVehicleByMake', function(){
	$('.loading').removeClass('hide');
	  var make = $(this).val();		  
	   var vehicle_models = "";  
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_vehicle_models',
		  type: 'POST',
		  data:{makeId: make,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  var x = $(response).filter('div');
			  vehicle_models = x.filter('#vehicle_models').html();			 
			  var vehicle_data = x.filter('#vehicle_data').html();	
			  $('.getModels').html(vehicle_models);
			  $('.vehiclesData').html(vehicle_data);			  
			  $('.loading').addClass('hide');
			  $(".search_key").val('');
		  }
	})
})
$(document).on('change', '.filterVehicleByModel select', function(){
	$('.loading').removeClass('hide');
	var model = $(this).val();	  
	$.ajax({
		url: adm_bse_url+'vehicles/filter_vehicle_by_model',
		type: 'POST',
		data:{modelId: model,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.chips_data').html(response);
			$('.loading').addClass('hide');
			$('.site-pg').addClass('hide');
		}
  })
})
$(document).on('change', '.select_obp_vehicles2', function(){
	$('.loading').removeClass('hide');
	var make = $(this).attr('data-id');
	var model = $(this).val();	  
	$.ajax({
		url: adm_bse_url+'vehicles/get_obp_vehicles2',
		type: 'POST',
		data:{ModelId: model,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.getVehicles').html(response);
			$('.loading').addClass('hide');
		}
  })
})
$(document).on('click', '.addAnotherCodeSeries', function(){
	$('.loading').removeClass('hide');	  
	$.ajax({
		url: adm_bse_url+'vehicles/get_more_code_series',
		type: 'POST',
		data:{csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.code_series_box').append(response);
			$('.loading').addClass('hide');
		}
    })
})

$(document).on('click', '.remove_series_holder', function(){
	$(this).parent('.series_holder').remove();
})
$(document).on('click', '.edit_vh_inputs', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val')
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/edit_vh_inputs',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.edit_image_inputs', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var img_uuid =  $(this).attr('data-uuid');
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/edit_image_inputs',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val,img_uuid: img_uuid,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.vh_input_update', function(){
	$(this).parents('td').find('.edit_vh_inputs').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'vehicles/vh_input_update',
		type: 'POST',
		data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		success: function( response ){
			$(i).parents('td').find('.td_data').html(response);		
			$(i).parents('.get_column_data').html('') 
			$('.loading').addClass('hide');
		}
	})
})
$(document).on('click', '.vh_input_remove', function(){
	$(this).parents('td').find('.edit_vh_inputs').removeClass('hide');
	$(this).parents('td').find('.get_column_data').html('')
})
$(document).on('click', '.HideMachineInfo', function(){
	var value = 0;
	if( $(this).is(':checked') ){
		$('.machine').addClass('hide');
		value = 1;
	}else{
		$('.machine').removeClass('hide')
		value = 0;
	}
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/HideMachineInfo',
		  type: 'POST',
		  data: {remember: value,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){			  
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.HideDecoders', function(){
	var value = 0;
	if( $(this).is(':checked') ){
		$('.decoder').addClass('hide');
		value = 1;
	}else{
		$('.decoder').removeClass('hide');
		value = 0;
	}
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/HideDecoders',
		  type: 'POST',
		  data: {remember: value,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){			  
			  $('.loading').addClass('hide');
		  }
	  })
})

$("#searchVehicles").validate({
	rules:{
		search_key :{
			required: true
	   },			
	},
	messages:{
		search_key : "",			
	}, submitHandler: function(form){
		
		$('.loading').removeClass('hide');
		$.ajax({
			url: adm_bse_url+'vehicles/search_vehicles',
			type: 'POST',
			data: $('#searchVehicles').serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
			success: function( response ){
				$('.chips_data').html(response);
				$('.loading').addClass('hide');
				$('.site-pg').addClass('hide');
			}
		})
	}
  })
  $(document).on('change','.filterCsBykstyle', function(){
	$('.loading').removeClass('hide');
	var kstyleid = $(this).val();
	$.ajax({
		url: adm_bse_url+'vehicles/filter_cs_by_kstyle',
		type: 'POST',
		data: {keyStyleID: kstyleid,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.code_series_data').html(response);
			$('.loading').addClass('hide');
		}
	})
})	

$("#searchCodeSeries").validate({
  rules:{
	  search_key : "required",			
  },
  messages:{
	  search_key : "",			
  }, submitHandler: function(form){
	  $('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/search_code_series',
		  type: 'POST',
		  data: $('#searchCodeSeries').serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $('.code_series_data').html(response);
			  $('.loading').addClass('hide');
		  }
	  })
  }
})  
$().ready(function(){
$("#code_series").validate({
		rules:{
			code_series_name : "required",
		},
		messages:{
			code_series_name : "Please enter name",
		}
	})		
})
$("#AddVehicleForm").validate({
	rules:{
		Make_UUID: 'required',
		Model_UUID : "required",
		fromYear: "required",	
	},
	messages:{
		Make_UUID: '',
		Model_UUID : "",
		fromYear: "Please enter year"
	}
})
$(document).on('click', '.code_series_sort', function(){
	$('.loading').removeClass('hide');
	var sorts = $(this).attr('data_id');
	var sorting_by = 	$(this).attr('data-by');  
	$.ajax({
		url: adm_bse_url+'vehicles/code_series_sort',
		type: 'POST',
		data:{sorting: sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.code_series_data').html(response);
			$('.loading').addClass('hide');
			$('.site-pg').addClass('hide');
		}
  })
})

$(document).on('click', '.editInputType', function(){
	var i = this;
	$(this).addClass('hide');
	var thisval = $(this).attr('data-val');
	var UUId =  $(this).attr('data-id');
	var column = $(this).attr('data-col');
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_cs_column_data',
		  type: 'POST',
		  data: {value: thisval, dataId: UUId, ColumnName: column,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			 $(i).parents('.column_data').find('.get_column_data').html(response) 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.csinput_update', function(){
	$(this).parents('.column_data').find('.editInputType').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/csinput_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('.column_data').find('.tdvalue').text(response);		
			 $(i).parents('.column_data').find('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.csinput_remove', function(){
	$(this).parents('.column_data').find('.editInputType').removeClass('hide');
	$(this).parents('.column_data').find('.get_column_data').html('')
})




$(document).on('click', '.edit_cs_keys', function(){
	var i = this;
	$(this).addClass('hide');
	var thisval = $(this).attr('data-val');
	var UUId =  $(this).attr('data-id');
	var column = $(this).attr('data-col');
	var key_data1 = $(this).attr('data-key1');
	var key_data2 = $(this).attr('data-key2');
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_cs_keys_data',
		  type: 'POST',
		  data: {value: thisval, dataId: UUId, ColumnName: column, key1: key_data1, key2: key_data2,csrf_test_name: $.cookie('csrf_cookie_name') },
		  success: function( response ){
			  $(i).parents('.decoder').find('.ckKeysDropbox').html(response) 
			  $('.loading').addClass('hide');
		  }
	  })
})


$(document).on('click', '.csKyes_update', function(){
	$(this).parents('.decoder').find('.edit_cs_keys').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/cs_keys_data_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('.decoder').find('.tdvalue').text(response);		
			  $(i).parents('.ckKeysDropbox').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.csKyes_remove', function(){
	$(this).parents('.decoder').find('.editInputType').removeClass('hide');
	$(this).parents('.decoder').find('.ckKeysDropbox').html('')
})

$(document).on('click', '.editMachineData', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('.machine').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');
	var data_key = $(this).attr('data-key');
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_machine_data',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column, key: data_key,csrf_test_name: $.cookie('csrf_cookie_name') },
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})


$(document).on('click', '.machine_data_update', function(){
	$(this).parents('.decoder').find('.editMachineData').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/update_machine_data',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('.machine').find('.tdvalue').text(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.machine_data_remove', function(){
	$(this).parents('.machine').find('.editMachineData').removeClass('hide');
	$(this).parents('.machine').find('.get_column_data').html('')
})

$(document).on('click', '.machine_data_update', function(){
	$(this).parents('.decoder').find('.editMachineData').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/update_machine_data',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('.machine').find('.tdvalue').text(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.edit_cs_key_style', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('.dropbox_data').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');
	var data_key = $(this).attr('data-key');
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_key_style_data',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.keyStyle_data_update', function(){
	$(this).parents('.dropbox_data').find('.edit_cs_key_style').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/update_key_style_data',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('.dropbox_data').find('.tdvalue').text(response);		
			  $(i).parents('.get_column_data').html(response) 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.keyStyle_data_remove', function(){
	$(this).parents('.dropbox_data').find('.edit_cs_key_style').removeClass('hide');
	$(this).parents('.dropbox_data').find('.get_column_data').html('')
})
$(document).on('click','#sortlist', function(){
	$('.loading').removeClass('hide');
	var sorts = $(this).attr('data_id');
	var angle = $(this).attr('data-angle');
	//alert('angle');
	$.ajax({
		url: adm_bse_url+'vehicles/makeSortList',
		type: 'POST',
		data: {sorting: sorts, angle:angle,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.make_users').html(response);
			$('.loading').addClass('hide');
		}
	})
})

$(document).on('change', '.filterByMakes', function(){
	var makes = $(this).val();
	$('.loading').removeClass('hide');	
	$.ajax({
		url: adm_bse_url+'vehicles/filter_by_makes',
		type: 'POST',
		data: {make_uuid: makes,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.table-data').html(response);
			$('.loading').addClass('hide');
		}
	})
})

$(document).on('click', '.searchModels', function(){
	var search_key = $('#search_key').val();	
	
})
$("#searchModels").validate({
		rules:{
			search_key : "required",			
		},
		messages:{
			search_key : "",			
		}, submitHandler: function(form){
			$('.loading').removeClass('hide');
			$.ajax({
				url: adm_bse_url+'vehicles/search_makes',
				type: 'POST',
				data: $('#searchModels').serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
				success: function( response ){
					$('.table-data').html(response);
					$('.loading').addClass('hide');
				}
			})
		}
})	

$(document).on('click','#makesname_sorting', function(){
	$('.loading').removeClass('hide');
	var sorts = $(this).attr('data_id');
	var angle = $(this).attr('data-angle');
	$.ajax({
		url: adm_bse_url+'vehicles/MakeNamesSorting',
		type: 'POST',
		data: {sorting: sorts,angle:angle,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.make_names').html(response);
			$('.loading').addClass('hide');
			
		}
	})
})
$().ready(function(){
$("#model_name").validate({
		rules:{
			model_name : "required",
			make_name :"required"
			
		},
		messages:{
			model_name : "Please enter your model name",
			make_name :"Please select make name"
			
		}
	})		
})

/*************************************************************************************************************************************************************** */




function DeleteFunction(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}

function DeleteFunction2(url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url;
	  }else{
	 }	
}

function DeleteEZPages(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}
$().ready(function(){
$("#makes_name").validate({
		rules:{
			make_name : "required"
			
		},
		messages:{
			make_name : "Please enter your make name"
			
		}
	})		
})
$().ready(function(){
$("#edit_makename").validate({
		rules:{
			make_name : "required"
			
		},
		messages:{
			make_name : "Please change make name"
			
		}
	})		
})

var uservalid	= 1;
	$(document).on('blur', '#make_name', function(){
		var username = $(this).val();
		if( username != ""){
			$.ajax({
				  url:adm_bse_url+'check_makename',
				  type:'POST',	
				  data:'make_name='+make_name,
				  success:function(result){								
					if(result == 0){ 
						uservalid = 0;
						$('.MakenameAvailability').html('')
						$(".availability_makename").html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>');
					}else if(result == 1){  
							$(".availability_makename").html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
							$('.MakenameAvailability').html('<div>E-mail already exists, please try another.</div>')
							uservalid = 1;
					}else if(result == 2){  
						$(".availability_makename").html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
						uservalid = 1;
						$('.MakenameAvailability').html('')
					 }
				 }  			
			  })
		}
	})
function DeleteMakeName(id, url){
	var r = confirm("Are you sure you would like to delete? All model under this Make will also delete. This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}
function DeleteModelFunction(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}

function DeleteCodeFunction(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}

function DeleteKeystyle(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}
function DeleteChipsFunction(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}

function DeleteKeytype(id, url){
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){
		 window.location.href = url+''+id;
	  }else{
	 }
}

$(document).on('change','#result', function(){
		var searchs = $(this).val();	
		//alert(searchs)
		$('.loading').removeClass('hide');
		$.ajax({
			url: adm_bse_url+'pagination',
			type: 'POST',
			data: {searching: searchs,csrf_test_name: $.cookie('csrf_cookie_name')},
			success: function( response ){
				var url = document.URL				
				var x = url.substr(url.lastIndexOf('/') + 1)			
				if($.isNumeric( x )){										
					window.location.replace('http://autoproapp.com/admin/manage_model/');	
				}else{
					location.reload();
				}	
				$('.loading').addClass('hide');
		} 
	})
})



$(document).on('click', '.user_sorting', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id'); 
	  var sortby1 = $(this).attr('data-sort'); 
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'user_sorting',
		  type: 'POST',
		  data:{sorting: sorts, sortby: sortby1,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.usersData').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})

$(document).on('click', '.code_sorting', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');	 
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'vehicles/code_sorting',
		  type: 'POST',
		  data:{sorting: sorts,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.code_series_data').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})





/*=========================== Vehicle Page Editing ==========================================*/

$(document).on('click', '.edit_vh_dropbox', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_key = $(this).attr('data-key');
	var data_type = $(this).attr('data-type')
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/edit_vh_dropbox',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, key: data_key, type: data_type,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.vh_dropbox_update', function(){
	$(this).parents('td').find('.edit_vh_dropbox').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/vh_dropbox_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').html(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.edit_vh_programmers_box', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_key = $(this).attr('data-key');
	var data_type = $(this).attr('data-type')
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/edit_vh_programmers_box',
		  type: 'POST',
		  dataType: "html",
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, key: data_key, type: data_type,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.vh_programmers_dropbox_update', function(){
	$(this).parents('td').find('.edit_vh_programmers_box').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/vh_programmers_dropbox_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').html(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.vh_dropbox_remove', function(){
	$(this).parents('td').find('.edit_vh_dropbox').removeClass('hide');
	$(this).parents('td').find('.edit_vh_programmers_box').removeClass('hide');	
	$(this).parents('td').find('.get_column_data').html('')
})

$(document).on('click', '.edit_vh_multiple_box', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_key = $(this).attr('data-key');
	var data_type = $(this).attr('data-type')
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/edit_vh_multiple_box',
		  type: 'POST',
		  dataType: "html",
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, key: data_key, type: data_type,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.vh_multiple_dropbox_update', function(){
	$(this).parents('td').find('.edit_vh_multiple_box').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'vehicles/vh_multiple_dropbox_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').html(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.vh_multiple_dropbox_remove', function(){
	$(this).parents('td').find('.vh_multiple_dropbox_remove').removeClass('hide');	
	$(this).parents('td').find('.get_column_data').html('')
	$(this).parents('td').find('.edit_vh_multiple_box').removeClass('hide');	
})

/*--------------------------- Code Series Sorting------------------------------------------*/

$(document).on('click', '.code_series_uuid_sort', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');
	  var sorting_by = 	$(this).attr('data-by');  
	  $.ajax({
		  url: adm_bse_url+'vehicles/code_series_uuid_sort',
		  type: 'POST',
		  data:{sorting: sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.code_series_data').html(response);
			  $('.loading').addClass('hide');
			  $('.site-pg').addClass('hide');
		  }
	})
})

$(document).on('click', '.obp_opt_cateogry_sort', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');
	  var sorting_by = 	$(this).attr('data-by');  
	  $.ajax({
		  url: adm_bse_url+'vehicles/obp_opt_cateogry_sort',
		  type: 'POST',
		  data:{sorting: sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
			  $('.site-pg').addClass('hide');
		  }
	})
})


$(document).on('click', '.keys_uuid_sorting', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');
	  var sorting_by = $(this).attr('data-by');	
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'keys_uuid_sorting',
		  type: 'POST',
		  data:{sorting: sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})

/*--------------------------------- key style sorting ------------------------------------*/

$(document).on('click', '.key_style_sorting', function(){
	$('.loading').removeClass('hide');
	var sorts = $(this).attr('data_id');
	var sorting_by = $(this).attr('data-by');
	$.ajax({
		url:adm_bse_url+'home/key_style_sorting',
		type:'POST',
		data:{sorting:sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')}, 
		success: function( response ){
			$('.chips_data').html(response);
			$('.loading').addClass('hide');
		}
		
	})
})

$(document).on('click', '.key_type_sorting', function(){
	$('.loading').removeClass('hide');
	var sorts = $(this).attr('data_id');
	var sorting_by = $(this).attr('data-by');
	$.ajax({
		url:adm_bse_url+'home/key_type_sorting',
		type:'POST',
		data:{sorting:sorts, sorting_by: sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')}, 
		success: function( response ){
			$('.chips_data').html(response);
			$('.loading').addClass('hide');
		}
		
	})
})
$(document).on('click', '.showMissingCodeSeries', function(){
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'vehicles/show_missing_code_series',
		type: 'POST',
		data:{type:'t_Vehicles.Code_Series_UUID',csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  },
		  error: function(xhr, status, error) {
			var err = eval("(" + xhr.responseText + ")");
			alert(err.Message);
		  }
	})
})

$(document).on('click', '.showMissingImages', function(){
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'vehicles/show_missing_images',
		type: 'POST',
		data:{type:'t_Vehicles.Vehicle_Image',csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  },
		  error: function(xhr, status, error) {
			var err = eval("(" + xhr.responseText + ")");
			alert(err.Message);
		  }
	})
})
$(document).on('click', '.ShowAutoProPADOnly', function(){
	$('.AutoProPAD').removeClass('hide');
	$('.Types').addClass('hide');
	$('.HImage').addClass('hide');
	$('.code_keyInfo').addClass('hide');
	$('.AdvDiagn').addClass('hide');
	$('.Hotwire').addClass('hide');
	$('.TKOSDD').addClass('hide');
	$('.Dmax').addClass('hide');
	$('.ProLok').addClass('hide');
	$('.Parts').addClass('hide');
	$('.vehicles_checkbox input[type=checkbox]').prop('checked', true);
	$('.vehicles_checkbox .HideAutoProPAD').prop('checked', false)
})
$(document).on('change', '.show_vehicle_by_type', function(){
	$('.loading').removeClass('hide');
	 var type = $(this).val();		
	 $.ajax({
		 url: adm_bse_url+'vehicles/show_vehicle_by_type',
		 type: 'POST',
		 data:{type: type,csrf_test_name: $.cookie('csrf_cookie_name')},
		 success: function( response ){
			 $('.chips_data').html(response);
			 if(type =='All'){
				 location.reload();
			 }
			 $('.loading').addClass('hide');
			 $(".search_key").val('');	
			 $(".filterVehicleByMake").val('');
			 $(".model").val(''); 
		 },
		 error: function(xhr, status, error) {
		   var err = eval("(" + xhr.responseText + ")");
		   alert(err.Message);
		 }
   })
})
$(document).on('change', '.select_obp_Models', function(){
	$('.loading').removeClass('hide');
	  var make = $(this).val();	  
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_obp_models',
		  type: 'POST',
		  data:{makeId: make,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.getModels').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})

$(document).on('change', '.selectModels', function(){
	$('.loading').removeClass('hide');
	  var make = $(this).val();	  
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_obp_models2',
		  type: 'POST',
		  data:{makeId: make,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.getModels').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})

$(document).on('change', '.select_obp_vehicles', function(){
	$('.loading').removeClass('hide');
	  var make = $(this).attr('data-id');
	  var model = $(this).val();	  
	  $.ajax({
		  url: adm_bse_url+'vehicles/get_obp_vehicles',
		  type: 'POST',
		  data:{ModelId: model,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.getVehicles').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})
$(document).on('click', '.delete_checkbox', function(){	
  if($(this).is(':checked'))  {
	$(this).closest('tr').addClass('removeRow');
  } else {
	$(this).closest('tr').removeClass('removeRow');
  }
 });
$(document).on('click', '#delete_all_model', function(){	
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0){
	   var result = confirm("Are you sure to delete selected models?");
        if(result){
             var checkbox_value = [];
		   $(checkbox).each(function(){
			 checkbox_value.push($(this).val());
		   });
		  $('.loading').removeClass('hide');	
			$.ajax({
				url: adm_bse_url+'vehicles/deleteAllModel',
				type: 'POST',
				data: {checkbox_value:checkbox_value},
				success: function( response ){
					 $('.removeRow').fadeOut(1500);
					 $(".return_msg").html("<div class='btn btn-info'>Data deleted successfully</div>");
					$('.loading').addClass('hide');
				},
				  error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				alert(err.Message);
				$('.loading').addClass('hide');
				}
			})
        }else{
            return false;
        }
	  
  } else  {
    alert('Select atleast one records');
  }
 });
 
 // Delete All Makes
 $(document).on('click', '.delete_checkbox_makes', function(){	
  if($(this).is(':checked'))  {
	 $(this).closest('tr').addClass('removeRow');
  } else {
	$(this).closest('tr').removeClass('removeRow');
  }
 });
 
 
 $(document).on('click', '#delete_all_makes', function(){	
  var checkbox = $('.delete_checkbox_makes:checked');
  if(checkbox.length > 0){
	   var result = confirm("Are you sure you would like to delete? All model under this Make will also delete. This action cannot be undone.?");
        if(result){
             var checkbox_value = [];
		   $(checkbox).each(function(){
			 checkbox_value.push($(this).val());
		   });
		  $('.loading').removeClass('hide');	
			$.ajax({
				url: adm_bse_url+'vehicles/deleteAllMakes',
				type: 'POST',
				data: {checkbox_value:checkbox_value},
				success: function( response ){
					 $('.removeRow').fadeOut(1500);
					 $(".return_msg").html("<div class='btn btn-info'>Data deleted successfully</div>");
					$('.loading').addClass('hide');
				},
				  error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					alert(err.Message);
					$('.loading').addClass('hide');
					}
			})
        }else{
            return false;
        }
	  
  } else  {
    alert('Select atleast one records');
  }
 });
 $("#add_key").validate({
	rules:{
		key_name : "required",
		key_type: "required",		
	},
	messages:{
		key_name : "",
		key_type: "",			
	}
})
$(document).on('change', '.show_keysby_types', function(){
	  $('.loading').removeClass('hide');
	  var type = $(this).val();	  
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'home/show_keysby_types',
		  type: 'POST',
		  data:{typeUuid: type,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			$('.chips_data').html(response);
			if(type =='all'){
				location.reload();
			}
			$('.loading').addClass('hide');
			$(".searchkey").val('');
			$(".show_keysby_lock_types").val('');
		  }
	})
})
$(document).on('change', '.show_keysby_lock_types', function(){
	  $('.loading').removeClass('hide');
	  var type = $(this).val();	 
	  var keybytype = $(".show_keysby_types").val();	  
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'home/show_keysby_lock_types',
		  type: 'POST',
		  data:{typeUuid: type,keybytype:keybytype,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  if(type =='all'){
				location.reload();
			}
			  $('.loading').addClass('hide');
			  $(".searchkey").val('');			   
		  }
	})
})
$("#searchKyes").validate({
  rules:{
	  search_key : "required",			
  },
  messages:{
	  search_key : "",			
  }, submitHandler: function(form){
	  $('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'home/search_kyes',
		  type: 'POST',
		  data: $('#searchKyes').serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
			  $('.show_keysby_lock_types').val('');
			 
		  }
	  })
  }
})
$(document).on('change','#keys_pagination', function(){
		var searchs = $(this).val();	
		//alert(searchs)
		$('.loading').removeClass('hide');
		$.ajax({
			url: adm_bse_url+'home/keys_pagination',
			type: 'POST',
			data: {searching: searchs,csrf_test_name: $.cookie('csrf_cookie_name')},
			success: function( response ){
				var url = document.URL				
				var x = url.substr(url.lastIndexOf('/') + 1)			
				if($.isNumeric( x )){										
					window.location.replace('http://localhost/vh-admin/home/keys');	
				}else{
					location.reload();
				}	
			$('.loading').addClass('hide');
		} 
	})
})
$(document).on('click', '.keys_sorting', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');
	  var sorting_by = $(this).attr('data-by');	
	  var keytype = $(".show_keysby_types").val();
	  var keylocktype = $(".show_keysby_lock_types").val();	
	 var searchkey	 =   $(".searchkey").val();	
	  //alert(sorts)
	  $.ajax({
		  url: adm_bse_url+'home/keys_sorting',
		  type: 'POST',
		  data:{sorting: sorts, sorting_by: sorting_by,keytype:keytype,keylocktype:keylocktype,searchkey:searchkey,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})
$(document).ready(function(){
$("#chips").validate({
		rules:{
			name : "required",			
			cloneable : "required",
			reusable : "required",
			cloning_chip : "required",
		},
		messages:{
			name : "Please enter chip name",			
			cloneable :"Please enter clonable value",
			reusable :"Please enter reusable value",
			cloning_chip :"Plaese enter cloning chip value",
		}
	})	
$("#keyBlade").validate({
		rules:{
			Key_Blade_name : "required",		
			
		},
		messages:{
			Key_Blade_name : "Please enter key blade name",
		}
	})	
})
$(document).on('change','.show_chips_filter', function(){
	$('.loading').removeClass('hide');
	var chip = $(this).val();
	$.ajax({
		url: adm_bse_url+'home/show_chips_filter',
		type: 'POST',
		data: {chip:chip,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$('.chips_data').html(response);
			$('.loading').addClass('hide');
		}
	})
})
$("#globalSearchKyes").validate({
	rules:{
		search_global_key : "required",			
	},
	messages:{
		search_global_key : "",			
	}, submitHandler: function(form){
		$('.loading').removeClass('hide');
		$.ajax({
			url: adm_bse_url+'home/search_global_key',
			type: 'POST',
			data: $('#globalSearchKyes').serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
			success: function( response ){
				$('.table-responsive').html(response);
				$('.loading').addClass('hide');
			}
		})
	}
})
/*=============================== Page Editing Functions ===============================================*/


$(document).on('click', '.edit_chips_inputs', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_table = $(this).attr('data-table');
	var img =  $(this).attr('data-img');
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'home/edit_chips_inputs',
		type: 'POST',
		data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, dataTable: data_table, image:  img,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$(thisval).html(response);
			$('.loading').addClass('hide');
		}
	})	
})

$(document).on('click', '.chips_input_update', function(){
	$(this).parents('td').find('.edit_chips_inputs').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'home/chips_input_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').html(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.chips_input_remove', function(){
	$(this).parents('td').find('.edit_chips_inputs').removeClass('hide');
	$(this).parents('td').find('.get_column_data').html('')
})
$(document).on('click', '.edit_table_dropbox', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_table = $(this).attr('data-table');
	var data_type = $(this).attr('data-type');
	var img =  $(this).attr('data-img');
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'home/edit_table_dropbox',
		type: 'POST',
		data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, dataTable: data_table, image:  img, dataType: data_type,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$(thisval).html(response);
			$('.loading').addClass('hide');
		}
	})	
})
/*=============================== Keys Page Editing =========================================*/

$(document).on('click','.edit_keys_inputs', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val')
	$('.loading').removeClass('hide');
	$.ajax({
		url: adm_bse_url+'home/edit_keys_inputs',
		type: 'POST',
		data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val,csrf_test_name: $.cookie('csrf_cookie_name')},
		success: function( response ){
			$(thisval).html(response);
			$('.loading').addClass('hide');
		}
	})	
})

$(document).on('click', '.keys_input_update', function(){
	$(this).parents('td').find('.edit_keys_inputs').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'home/keys_input_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').html(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})
$(document).on('click', '.keys_input_remove', function(){
	$(this).parents('td').find('.edit_keys_inputs').removeClass('hide');
	$(this).parents('td').find('.get_column_data').html('')
})


$(document).on('click', '.edit_keys_dropbox', function(){
	$(this).addClass('hide');
	var thisval = $(this).parents('td').find('.get_column_data');
	var UUId =  $(this).attr('id');
	var data_id = $(this).attr('data-id');
	var data_column = $(this).attr('data-col');	
	var data_val = $(this).attr('data-val');
	var data_key = $(this).attr('data-key');
	var data_type = $(this).attr('data-type')
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'home/edit_keys_dropbox',
		  type: 'POST',
		  data: {uuId: UUId, dataId: data_id, column: data_column, value: data_val, key: data_key, type: data_type,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $(thisval).html(response);
			  $('.loading').addClass('hide');
		  }
	  })
})

$(document).on('click', '.keys_dropbox_update', function(){
	$(this).parents('td').find('.edit_vh_dropbox').removeClass('hide');
	var formName = $(this).parents('form');	
	var i = this;
	$('.loading').removeClass('hide');
	  $.ajax({
		  url: adm_bse_url+'home/keys_dropbox_update',
		  type: 'POST',
		  data: $(formName).serialize()+ "&csrf_test_name=" + $.cookie('csrf_cookie_name'),
		  success: function( response ){
			  $(i).parents('td').find('.td_data').text(response);		
			  $(i).parents('.get_column_data').html('') 
			  $('.loading').addClass('hide');
		  }
	  })
})


$(document).on('click', '.keys_dropbox_remove', function(){
	$(this).parents('td').find('.edit_keys_dropbox').removeClass('hide');	
	$(this).parents('td').find('.get_column_data').html('')
})
$().ready(function(){
$("#key_type").validate({
		rules:{
			name : "required",
		},
		messages:{
			name : "Please enter key type name",
		}
	})		
})
$().ready(function(){
$("#keyHead").validate({
		rules:{
			key_Head_Name : "required",
		},
		messages:{
			key_Head_Name : "Please enter key type name",
		}
	})		
})
$(document).on('click', '.vehicle_sort_retainer', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');
	  var sorting_by = 	$(this).attr('data-by'); 
	  var makeId = $('.filterVehicleByMake option:selected').val();	 
	  var modelId = $('.filterVehicleByModel select option:selected').val();  
	  $.ajax({
		  url: adm_bse_url+'vehicles/vehicle_common_sorting',//vehicle_sort_retainer',
		  type: 'POST',
		  data:{sorting: sorts, sorting_by: sorting_by,makeId:makeId,modelId:modelId,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})
$(document).on('click', '.chips_sorting', function(){
	  $('.loading').removeClass('hide');
	  var sorts = $(this).attr('data_id');	  
	   var sorting_by = $(this).attr('data-by');	  
	  $.ajax({
		  url: adm_bse_url+'home/chips_sorting',
		  type: 'POST',
		  data:{sorting: sorts,sorting_by:sorting_by,csrf_test_name: $.cookie('csrf_cookie_name')},
		  success: function( response ){
			  $('.chips_data').html(response);
			  $('.loading').addClass('hide');
		  }
	})
})
$(document).on('change', '#product_detail_csv_file', function(){
		var file1 = $("#product_detail_csv_file").val();	
		if(file1 !=""){	
			var extension = file1.replace(/^.*\./, '');	
			if(extension !="csv"){
				$('.proDetailimportmsg').html('Please select only csv file.');
				$("#prod_detail_btn").attr("type","button");			
			}else{			
				$("#prod_detail_btn").attr("type","submit");						
				$('.proDetailimportmsg').html('');
			}
		}
});	
$(document).on('change', '#product_info_csv_file', function(){
		var file1 = $("#product_info_csv_file").val();	
		if(file1 !=""){	
			var extension = file1.replace(/^.*\./, '');	
			if(extension !="csv"){
				$('.prodInfoimportmsg').html('Please select only csv file.');
				$("#prodInfo_btn").attr("type","button");			
			}else{			
				$("#prodInfo_btn").attr("type","submit");						
				$('.prodInfoimportmsg').html('');
			}
		}
});	
$("#product_import_csv").on("submit", function(){	
    $('.hide_loader').css('display','block');
  })
 $("#product_detail_import_csv").on("submit", function(){
    $('.hide_loader').css('display','block');
 })

 $( function() {
    var dateFormat = "yy-mm-dd",
      from = $( ".from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 2
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( ".to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );


  $(document).on('click','.remove_attachments', function(){	
	var r = confirm("Are you sure you would like to delete? This action cannot be undone.");
	if(r==true){	 
		$(this).parents('.attachments_row').find('.keyimage').val('');
		$(this).parents('.attachments_row').find('.img-box').remove();
	}
})