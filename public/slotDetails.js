//Code added by Naresh 
$(document).ready(function() {
    //--------------------
$('.pageoption input').attr('disabled',true);
    $('.main_filter_date').click(function() {
		//process 1
        runWaterFall();

    });
    $('.main_filter_shift')
    $('.fd_shift_select').on('click change',function() {
		//process 2
        checkChildTime($(this));
    });
	 $('.fd_time_select_main').on('click change', function() { 

		//process 2
        checkIndividualChildTime($(this));
	 
    });
	$('.card input').click(function(){
		startCollection();
	})
	

    //-----------------------
$('.savetype').change(function(){
console.log($(this).val());
 if($(this).val()=='update'){
$('.up_opt').show(); 
$('.up_opt input').attr('disabled',false); 
} else{
$('.up_opt').hide();
$('.up_opt input').attr('disabled',false); 
}
});
});

function runWaterFall() {
	/* This method to check how many items being selected */
    resetMainBlock(); //resetting 
    //console.log('waterfall  process');
	//Finding is it selected only dates or dates and times 
	datestotal =  $('.fd_date_select:checked').length;
	timestotal =  $('.fd_time_select_main:checked').length;
	if(datestotal>0 && timestotal==0){
		SelectOnlyDates();
	}
	if(datestotal>0 && timestotal>0){
		selectBothDatesTimes();
	}
	if(datestotal==0 && timestotal>0){
		SelectOnlyTimes();
	}
	startCollection();
//	console.log(timestotal);
}
function startCollection(){
	var design ='<div class="row">';
	 completearray = [];
		$('[id^=sub_date_]').each(function(){
		 dateid = $(this).attr('id');
		if($('#'+dateid+' input:checked').length>0){
			did = $(this).attr('id');
			onlydatearray = did.split('_');
			 onlydate = onlydatearray[3];
design +='<div class="card hcard">';
design +='<div class="card-header">'+onlydate+'</div><div class="card-body">';
			finaltimes = [];
			$('#'+did+' input:checked').each(function(){
				//finaltimes
				timeclass = $(this).parent().attr('class');
				timeclass = timeclass.replace('sub_filter_time ','');
				timearray = timeclass.split('_');
				onlytime = timearray[3];
					onlytime = onlytime.replace('SPACE',' ');
					onlytime = onlytime.replace('COLON',':');
				onlytime = onlytime.replace('SPACE',' ');
				onlytime = onlytime.replace('SPACEAM',' AM');
				onlytime = onlytime.replace('COLON',':');
				onlytime = onlytime.replace('HYPHEN','-');
				design +='<span class="htime badge">'+onlytime+'</span>';	 
				finaltimes.push(onlytime);
				completearray[onlydate] = finaltimes;
			});
			
	design +='</div></div>';		
		}
		});
	 design +='</div>';
		cs = Object.assign({}, completearray);
		csa = JSON.stringify(cs);
		$('.selectedvalues').val(csa);
		$('#reviewselection').html(design);
		//console.log(cs);
		if($('#reviewselection').html()=='<div class="row"></div>'){
			$('.pageoption input').attr('disabled',true);
		}else{
			$('.pageoption input').attr('disabled',false);
		}

}
function checkIndividualChildTime(Individualshift){
	   // console.log('individual script selected');
	    runWaterFall();
}
function checkChildTime(currentshift) {
    //console.log('finding sub times ');
   currentshiftId = currentshift.attr('id');
	if(currentshift.prop('checked')==true){
		$('[class^=' + currentshiftId + ']').prop("checked", true);
	}else{
		$('[class^=' + currentshiftId + ']').prop("checked", false);
	}
	runWaterFall();
 }

function resetMainBlock() {
    $('.main-block input').attr('checked', false);
}
function selectBothDatesTimes (){
	subtimes = []; 
	 console.log('Need to update date and time selection');
	 
	 $('.main_filter_time input:checked').each(function(){
		 onlyClass = $(this).attr('class').replace(' fd_time_select_main','');
		 resetonlyClass =  onlyClass.split('_');
		 resetonlyClassval =   resetonlyClass[0]+'_'+resetonlyClass[2];
		 //console.log(resetonlyClassval);
		 subtimes.push(resetonlyClassval);
	});
	
	//console.log(subtimes);
	
	 $('.main_filter_date input:checked').each(function(){
		 ccid = $(this).parent().attr('id');
		//	 mainids.push(ccid);
		for (i = 0; i < subtimes.length; i++) {
		//console.log(subtimes[i]);
		finalid = '#sub_date_'+ccid+' .sub_time_'+subtimes[i]+' input';
		//console.log(finalid);
		$(finalid).prop('checked',true);
		} 
	});
}
function SelectOnlyTimes(){
	$('.main_filter_time input:checked').each(function(){
		 onlyClass = $(this).attr('class').replace(' fd_time_select_main','');
		 resetonlyClass =  onlyClass.split('_');
		 resetonlyClassval =   ".sub_time_"+resetonlyClass[0]+'_'+resetonlyClass[2]+' input';
		// console.log(resetonlyClassval);
		$(resetonlyClassval).prop('checked',true);
	});
}
function SelectOnlyDates(){
	$('.main_filter_date input:checked').each(function(){
		ccid = $(this).parent().attr('id');
		selectAllDates(ccid);
	});
}
function selectAllDates(ccid) {
	if(ccid==''){
		 cid = $(this).attr('id');
	}else{
		cid = ccid;
	}
   
    newid = $('#sub_date_' + cid + ' input');
    //$(newid).prop('checked',true);
    //console.log(newid.prop("checked"));
    newid.each(function() {
        if ($(this).prop("checked") == false) {
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
        }
    });
}

function validateForm(){
	if($('.savetype').val()=='update'){
		if($('.typeopt:checked').length==0){
			return false;
			$('.type_msg').html(' Please select Consultation type');
			
		}else{
			return true;
		}
	}else{
		return true;
	}
	
}