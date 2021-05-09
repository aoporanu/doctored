$(document).ready(function () {

	//loadHospitalData(); /* Normally this method should call but internally the change method is also working ,so need to trigger by default*/
	$('#inputStatehospital').change(function () {
		$('#hid').val($(this).val());
		
		  loadHospitalData(); 
	});
	$('#inputStateDates').change(function () {
		if(	$('#inputStateDates').val()!=''){
		setCarousel();
		}
		loadTimesByDates();
		
	});
	$('#inputStateAppTime').change(function () {
		
		 if($('#inputStateAppTime').val()!=''){
					loadConsultationType();
				} 
			 
		
	});

});


function loadTimesByDates(){
	seldate = $('#inputStateDates').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

		}
	});
	// $('#send_form').html('Sending..');
	$.ajax({
		url: '/fstbd',
		type: "POST",
		data: {
			sdate:seldate,
			hid: $('#hid').val(),
			docid: $('#docid').val(),
			app_time:$('#app_time').val()
		},

		success: function (response) {
			//console.log(response);
			$('#inputStateAppTime').html(response);
			 	$('#inputStateAppTime').prop('disabled',false);
				if($('#inputStateAppTime').val()!=''){
					loadConsultationType();
				}
			
		}
	});
}


function loadConsultationType(){
	seldate = $('#inputStateDates').val();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

		}
	});
	// $('#send_form').html('Sending..');
	$.ajax({
		url: '/fctype',
		type: "POST",
		data: {
			sdate:seldate,
			hid: $('#hid').val(),
			docid: $('#docid').val(),
			time:$('#inputStateAppTime').val(),
			selectedtype:$('#selectedtype').val()
		},

		success: function (response) {
			
			//var json_str = JSON.stringify(response); 
	
	var returnedData = JSON.parse(response);

	$('#screen_id').val(returnedData.otherdetails.screen_id);
	$('#slotid').val(returnedData.otherdetails.id);

			//return false;
			$('#inputStateCtype').html(returnedData.design);
			 $('#inputStateCtype').prop('disabled',false);
			 if($('#inputStateAppTime').val()==''){
				  $('#inputStateCtype').prop('disabled',true);
				  $('#inputStateCtype').html('<option value="">Choose..</option>');
			 }
		}
	});
}

function setCSSForRight() {
	$('.clicktab').css('border', '1px solid #ccc');
	$('.clicktab').css('background', 'rgb(237, 249, 233)');
	$('.clicktab').click(function () {
		var selected = $(this).attr('id');

		$('.clicktab').each(function () {

			if ($(this).attr('id') != selected) {

				$(this).css('border', '1px solid #ccc');
				$(this).css('background', 'rgb(237, 249, 233)');

			} else {
				$(this).css('border', '1px solid red');
				$(this).css('background', '#ffd100');

			}


		});

	});
}
function setCarousel(){
	seldate = 'selectme_'+btoa($('#inputStateDates').val());
$('.carousel-item').each(function(){
 if($(this).attr('id')==seldate){
    $(this).addClass('active');

    }else{
  $(this).removeClass("active");
    
    }
});
	
}
function setDates() {
	$('#inputStateDates').prop('disabled',true);
	/* Additionally we need to disable consulation types and apponttimes and should removed in once dates selected */
	$('#inputStateCtype').prop('disabled',true);
	$('#inputStateAppTime').prop('disabled',true);
	
	/*As we already received the dates from right grid capturing same from that
	 IF need to load consulation use the same kind of process.*/
	$('#inputStateDates').html('');
	var divdates = '<option value="">Choose..</option>';
	var appdate = $('#app_date').val(); var str='';
	$('.divdates').each(function () {
		//console.log($(this).val());
			if($(this).val()==appdate){
				str = ' selected';
			} else{
				str='';
			}
		divdates += '<option '+str+' value="' + $(this).val() + '">' + $(this).val() + '</option>';
	});
	$('#inputStateDates').append(divdates);
	$('#inputStateDates').prop('disabled',false);
	

}

function loadHospitalData() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

		}
	});
	// $('#send_form').html('Sending..');
	$.ajax({
		url: '/fsdbh',
		type: "POST",
		data: {
			hid: $('#hid').val(),
			docid: $('#docid').val()
		},

		success: function (response) {
			//console.log(response);
			$('#customdategrid').html(response);
			setCSSForRight();
			setDates();
			//need to load if the value is selected 
			if(	$('#inputStateDates').val()!=''){
				setCarousel();loadTimesByDates();	
				}
				
			
		}
	});
}