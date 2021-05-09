//code added by NARESH 
/**
 * Returns the week number for this date.  dowOffset is the day of week the week
 * "starts" on for your locale - it can be from 0 to 6. If dowOffset is 1 (Monday),
 * the week returned is the ISO 8601 week number.
 * @param int dowOffset
 * @return int
 */
Date.prototype.getWeek = function(dowOffset) {
    /*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

    dowOffset = typeof(dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
    var newYear = new Date(this.getFullYear(), 0, 1);
    var day = newYear.getDay() - dowOffset; //the day of week the year begins on
    day = (day >= 0 ? day : day + 7);
    var daynum = Math.floor((this.getTime() - newYear.getTime() -
        (this.getTimezoneOffset() - newYear.getTimezoneOffset()) * 60000) / 86400000) + 1;
    var weeknum;
    //if the year starts before the middle of a week
    if (day < 4) {
        weeknum = Math.floor((daynum + day - 1) / 7) + 1;
        if (weeknum > 52) {
            nYear = new Date(this.getFullYear() + 1, 0, 1);
            nday = nYear.getDay() - dowOffset;
            nday = nday >= 0 ? nday : nday + 7;
            /*if the next year starts before the middle of
              the week, it is week #1 of that year*/
            weeknum = nday < 4 ? 1 : 53;
        }
    } else {
        weeknum = Math.floor((daynum + day - 1) / 7);
    }
    return weeknum;
};
//********************************************************************************************* */
var startdateBegin = new Date();
var dda = (startdateBegin.getDate() < 10 ? '0' : '') + startdateBegin.getDate();
var mma = ((startdateBegin.getMonth() + 1) < 10 ? '0' : '') + (startdateBegin.getMonth() + 1); // 0 is January, so we must add 1


var yyyya = startdateBegin.getFullYear();
var startdateBeginFomrat = yyyya + '-' + mma + '-' + dda; //this is only to add in text box by default
$('#slot_startdate').val(startdateBeginFomrat);

//---------------------------------------------
var targetDate = new Date();
//---------------------------------------------
targetDate.setDate(targetDate.getDate() + 6); //next 7 days i.e week //used with getDate for week calc
//targetDate.setDate(targetDate.getWeek());

var dd = (targetDate.getDate() < 10 ? '0' : '') + targetDate.getDate();
var mm = ((targetDate.getMonth() + 1) < 10 ? '0' : '') + (targetDate.getMonth() + 1); // 0 is January, so we must add 1


var yyyy = targetDate.getFullYear();
var toweek = yyyy + '-' + mm + '-' + dd;
$('#slot_enddate').val(toweek); //this is only to add in text box

//console.log(toweek);
//---------------------------------------------
var targetMonth = new Date();
targetMonth.setMonth(targetMonth.getMonth() + 1); //next month
var dd = (targetMonth.getDate() < 10 ? '0' : '') + targetMonth.getDate();
var mm = ((targetMonth.getMonth() + 1) < 10 ? '0' : '') + (targetMonth.getMonth() + 1); // 0 is January, so we must add 1


var yyyy = targetMonth.getFullYear();
var tomonth = yyyy + '-' + mm + '-' + dd;
//console.log(tomonth);

jQuery.validator.addMethod("checkval", function(value, element, param) { 
 //console.log(element);
 return this.optional(element) || value !== 'fail';  //working code
 
});
function validateForm(){
	console.log('validateForm');
	$("#slot_management").validate({
		
		       

rules:{
	hospital_name:{required: true},
	'consultaions[]':{required: true},
timeval_status:{checkval:'fail'},
ready_date_values:{required:true}
	
},

messages: {
	hospital_name:{
		
		required:"Please select hospital name"
		},
	'consultaions[]':{
		
		required:"Please Choose consultation type"
		},
 timeval_status:{
		checkval:"Time selection is required or Invalid selection" 
	 },
	 ready_date_values:{
		 required:"Please chek all mandatory fields"
	 }
	
	},

submitHandler: function(form){
 //window.alert('ready to submit ajax');
saveSlotConfiguration(); 
$('#aboutme-tab').click();

}
});
}

//---------------------------------------------
function completeSlotCreationProcess(){
	var screenid = $('#screen_id').val();
	 
   
    $.ajax({
        type:'POST',
        url:'fetchSlotConfiguration',
		//dataType: 'json',
		data: {'screen_id':screenid},
        success:function(data){
           // console.log('success');
            //console.log(data);
			$('#review_content').html(data);
        },
        error:function(){

        }
						 

		});
}
$(document).ready(function() {
	
    $('#slot_enddate').val(toweek);
    setSelectedDates();
    //  $('#slot_startdate').datepicker({ dateFormat: 'MM/DD/YYYY'});
   // $('#cus_slot input').prop("disabled", true);
    $('.slot_days').change(function() {
        // $('#slot_startdate').val(currentdate);

        if ($(this).val() == 'custom') {
            $('#cus_slot input').prop("disabled", false);

        } else {
            $('#cus_slot input').prop("disabled", true);
            if ($(this).val() == 'week') {
                $('#slot_enddate').val(toweek);
            }
            if ($(this).val() == 'month') {
                $('#slot_enddate').val(tomonth);

            }


        }
        setSelectedDates();

    });
    $('#slot_startdate, #slot_enddate').change(function() {
        setSelectedDates();
    });
    $('#exclud_slotdate').change(function() {
        if ($(this).val() == 'customday') {
            $('#custom_extention_date').show();
        } else {
            $('#custom_extention_date').hide();
        }

    });
});



function getDateArray(start, end) {
    //console.log('list of available dates on are selected Start: ' + start + ' EndDate :' + end);
    var arr = new Array();
    var dt = new Date(start);

    end = Date.parse(end);
    while (dt <= end) {
        arr.push(new Date(dt));
        dt.setDate(dt.getDate() + 1);
    }
    // console.log(arr);
    return arr;
}

function setSelectedDates() {
  //  console.log('Dates are selected Start: ' + $('#slot_startdate').val() + ' EndDate :' + $('#slot_enddate').val());
    var dateArr = getDateArray($('#slot_startdate').val(), $('#slot_enddate').val());
    var sel_dates_array = new Array();
    sele_dates_div_val = '';
    for (var i = 0; i < dateArr.length; i++) {
        //Dont be confused by below it was refered by above code please separate with - you will understand
        sele_dates_div_val = ((dateArr[i].getDate() < 10 ? '0' : '') + dateArr[i].getDate()) +
            "-" + (((dateArr[i].getMonth() + 1) < 10 ? '0' : '') + (dateArr[i].getMonth() + 1)) +
            "-" + dateArr[i].getFullYear();
        sel_dates_array.push(sele_dates_div_val);
    }

    var selected_date_values = JSON.stringify(sel_dates_array);
    $('#selected_date_values').val(selected_date_values);
    selected_date_values = cleanDates(selected_date_values);

    $('#selected_dates_list').html(selected_date_values);
    initiateExclude();
    //console.log(JSON.stringify(Object.assign({}, sel_dates_array))); //to make json format
}
$(document).ready(function() {
    $('#exclud_slotdate').change(function() {
        initiateExclude();
    });
});

function cleanDates(selected_date_values) {
    selected_date_values = selected_date_values.replace('[', '');
    selected_date_values = selected_date_values.replace(']', '');
    selected_date_values = selected_date_values.replace(new RegExp('"', 'g'), "");
    selected_date_values = selected_date_values.replace(new RegExp(',', 'g'), " , ");
    return selected_date_values;
}


var weekdays = new Array(7);
weekdays[0] = "Sunday";
weekdays[1] = "Monday";
weekdays[2] = "Tuesday";
weekdays[3] = "Wednesday";
weekdays[4] = "Thursday";
weekdays[5] = "Friday";
weekdays[6] = "Saturday";



function excludeWeekends() {
    var dateArr = getDateArray($('#slot_startdate').val(), $('#slot_enddate').val());
    var sele_dates_div_val = '';
    var final_dates = new Array();
    var final_dates_div_val = '';
    var excluded = new Array();
    for (var i = 0; i < dateArr.length; i++) {
        //  console.log(dateArr[i].getDay());

        if (parseInt(dateArr[i].getDay()) != 0 && parseInt(dateArr[i].getDay()) != 6) {
            final_dates_div_val = ((dateArr[i].getDate() < 10 ? '0' : '') + dateArr[i].getDate()) +
                "-" + (((dateArr[i].getMonth() + 1) < 10 ? '0' : '') + (dateArr[i].getMonth() + 1)) +
                "-" + dateArr[i].getFullYear();
            final_dates.push(final_dates_div_val);
            // console.log(dateArr[i].getDay()); 
            //console.log('add for '+dateArr[i].getDay());
        } else {
            excluded.push(weekdays[dateArr[i].getDay()]);
        }

    }

    final_selected_values = JSON.stringify(final_dates);
	$('#ready_date_values').val(final_selected_values);
    //  $('#selected_date_values').val(selected_date_values);
    final_selected_values = cleanDates(final_selected_values);
    $('#excluded_what').html('Saturday\'s and Sunday\'s ');
    $('.excluded_dates_list').html(final_selected_values);


}

function getKeyByValue(object, value) {
    return Object.keys(object).find(key => object[key] === value);
}

//------------------------------
function excludeday(sday) {
    var dateArr = getDateArray($('#slot_startdate').val(), $('#slot_enddate').val());
    var sele_dates_div_val = '';
    var final_dates = new Array();
    var final_dates_div_val = '';
    var excluded = new Array();
    var sday = sday.split('-');
    sday = sday[1];
    for (var i = 0; i < dateArr.length; i++) {
        //  console.log(dateArr[i].getDay());

        if (parseInt(dateArr[i].getDay()) != getKeyByValue(weekdays, sday)) {
            final_dates_div_val = ((dateArr[i].getDate() < 10 ? '0' : '') + dateArr[i].getDate()) +
                "-" + (((dateArr[i].getMonth() + 1) < 10 ? '0' : '') + (dateArr[i].getMonth() + 1)) +
                "-" + dateArr[i].getFullYear();
            final_dates.push(final_dates_div_val);
            // console.log(dateArr[i].getDay()); 
            //console.log('add for '+dateArr[i].getDay());
        } else {
            excluded.push(weekdays[dateArr[i].getDay()]);
        }

    }

    final_selected_values = JSON.stringify(final_dates);
	$('#ready_date_values').val(final_selected_values);
    //  $('#selected_date_values').val(selected_date_values);
    final_selected_values = cleanDates(final_selected_values);
    $('#excluded_what').html(sday + '\'s');
    $('.excluded_dates_list').html(final_selected_values);


}
//------------------------------
function excludeCustomday() {
    var custom_extention_date = $('#custom_extention_date').val();
    console.log(custom_extention_date);

    var dateArr = getDateArray($('#slot_startdate').val(), $('#slot_enddate').val());

    var sele_dates_div_val = '';
    var final_dates = new Array();
    var final_dates_div_val = '';
    var excluded = new Array();
    for (var i = 0; i < dateArr.length; i++) {
        //  console.log(dateArr[i].getDay());

        //---
        cur_val = dateArr[i].getFullYear() +
            "-" + (((dateArr[i].getMonth() + 1) < 10 ? '0' : '') + (dateArr[i].getMonth() + 1)) +
            "-" + ((dateArr[i].getDate() < 10 ? '0' : '') + dateArr[i].getDate());

        //-- 
        //   console.log('cur_val '+cur_val);
        if (cur_val != custom_extention_date) {
            //---------------------------------------------------------------------------------
            final_dates_div_val = ((dateArr[i].getDate() < 10 ? '0' : '') + dateArr[i].getDate()) +
                "-" + (((dateArr[i].getMonth() + 1) < 10 ? '0' : '') + (dateArr[i].getMonth() + 1)) +
                "-" + dateArr[i].getFullYear();
            final_dates.push(final_dates_div_val);
            // console.log(dateArr[i].getDay()); 
            //console.log('add for '+dateArr[i].getDay());
            //-----------------------------------------------
        } else {
            excluded.push(weekdays[dateArr[i].getDay()]);
        }

    }

    final_selected_values = JSON.stringify(final_dates);
	$('#ready_date_values').val(final_selected_values);
    //  $('#selected_date_values').val(selected_date_values);
    final_selected_values = cleanDates(final_selected_values);
    $('#excluded_what').html(custom_extention_date);
    $('.excluded_dates_list').html(final_selected_values);


}
$(document).ready(function() {
    $('#custom_extention_date').change(function() {
        initiateExclude();
    });

});

function initiateExclude() {
    var excluded_for = $('#exclud_slotdate').val();
    if (excluded_for == '') {
        $('#excluded_what').html('None');
        $('.excluded_dates_list').html($('#selected_dates_list').html());
		$('#ready_date_values').val($('#selected_date_values').val());
    } else if (excluded_for == 'weekends') {
        excludeWeekends();
    } else if (excluded_for == 'customday') {
        excludeCustomday();
    } else {
        excludeday($('#exclud_slotdate').val());
    }

}


$(document).ready(function() {
    $('.slot_hospital').html($('#exampleFormControlSelect1 option').html());
    $('.slot_final_dates').html($('.excluded_dates_list').html());
    $('#exampleFormControlSelect1').change(function() {
        $('.slot_hospital').html($('#exampleFormControlSelect1 option').html());
    });

    $('.excluded_dates_list').change(function() {

        $('.slot_final_dates').html($(this).html());

    });


/************************************CODE FOR TIME SELECTION PROCESS */
 
    $("[id$='_break_start']").prop('disabled', true);
    $("[id$='_break_end']").prop('disabled', true);

    $("[id$='_time_start']").change(function() {
        partid = this.id;
        partname = partid.split('_');
        partname = partname[0];
        enable_disable_break(partname);


    });
    $("[id$='_time_end']").change(function() {
        partid = this.id;
        partname = partid.split('_');
        partname = partname[0];

        enable_disable_break(partname);

    });
    //-------------------------------------
    $("[id$='_break_start']").change(function() {
        partid = this.id;
        partname = partid.split('_');
        partname = partname[0];

        validateBreaks(partname);

    });
    $("[id$='_break_end']").change(function() {
        partid = this.id;
        partname = partid.split('_');
        partname = partname[0];

        validateBreaks(partname);

    });



});

function resetErrorMsgs(partname, msg) {
	
    $("." + partname + "_error_msg").html(msg);
    //var failed = 0;    var passed = 0;
	
var failed = 0;

   $("[class$='_error_msg']").each(function() {
	   if($(this).text()!=''){
       failed++;
	   }
    }); 
	if (failed == 0) {
            $('#timeval_status').val('pass');
			$('#timeval_status-error').html('');
        } else {
            $('#timeval_status').val('fail');
        }
$('#failed').val(failed);

//console.log(failed);

}

function convertSeconds(hms) {
    hms = hms + ':00'; // your input string
    var a = hms.split(':'); // split it at the colons

    // minutes are worth 60 seconds. Hours are worth 60 minutes.
    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    return seconds;
}

function disableBreak(partname) {
    $('#' + partname + "_break_start").prop('disabled', true);
    $('#' + partname + "_break_end").prop('disabled', true);
    $('#' + partname + "_break_start").prop('selectedIndex', 0);
    $('#' + partname + "_break_end").prop('selectedIndex', 0);
    $('#timeval_status').val('fail');
}

function enableBreak(partname) {
    $('#' + partname + "_break_start").prop('disabled', false);
    $('#' + partname + "_break_end").prop('disabled', false);

    $('#' + partname + "_break_start").prop('selectedIndex', 0);
    $('#' + partname + "_break_end").prop('selectedIndex', 0);
    $('#timeval_status').val('pass');
}


function validateBreaks(partname) {
    part_break_start = partname + '_break_start';
    part_break_end = partname + '_break_end';
    if ($('#' + part_break_start).val() != '' && $('#' + part_break_end).val() != '') {
        if (convertSeconds($('#' + part_break_start).val()) > convertSeconds($('#' + part_break_end).val())) {
            resetErrorMsgs(partname, 'Breaks End Time should not be equal or less than ' + partname + ' Break Start Time  ');
        } else {
            //Validating with Main timings 
            if (
                (convertSeconds($('#' + part_break_start).val()) < convertSeconds($('#' + part_time_start).val())) ||
                (convertSeconds($('#' + part_break_end).val()) > convertSeconds($('#' + part_time_end).val()))

            ) {
                resetErrorMsgs(partname, 'Breaks should be between ' + partname + ' Start and End date');
            } else {
                //-----------------------

                if (
                    (convertSeconds($('#' + part_break_start).val()) == convertSeconds($('#' + part_time_start).val())) &&
                    (convertSeconds($('#' + part_break_end).val()) == convertSeconds($('#' + part_time_end).val()))

                ) {
                    resetErrorMsgs(partname, 'Breaks Start and Start time and Breaks End and End time should not be Same');
                } else {
                    resetErrorMsgs(partname, '');
                }

                //-------------------------------------------------------------

                resetErrorMsgs(partname,'');
            }
            //End of validation 

        }
    } else {
        resetErrorMsgs(partname, 'Break  Start and End Time required');

    }

}

function enable_disable_break(partname) {
    resetErrorMsgs(partname, '');
    part_time_start = partname + '_time_start';
    part_time_end = partname + '_time_end';
    if ($('#' + part_time_start).val() != '' && $('#' + part_time_end).val() != '') {
        if (convertSeconds($('#' + part_time_start).val()) >= convertSeconds($('#' + part_time_end).val())) {

            resetErrorMsgs(partname, 'End Time should not be equal or less than ' + partname + '  Start Time  ');
            disableBreak(partname);
        } else {
            enableBreak(partname);
        }



    } else {
        resetErrorMsgs(partname, 'Start and End Time required');
        disableBreak(partname);
    }



}



function saveSlotConfiguration(){
	
	var  pagedata = $('#slot_management').serialize();
   
    $.ajax({
        type:'POST',
        url:'saveSlotConfiguration',
		//dataType: 'json',
		data: pagedata,
        success:function(data){
            console.log('success');
			completeSlotCreationProcess();
           console.log(data);
        },
        error:function(){

        }
						 

		});
}

function generateSlots(){
	confirm("Please verify the configuration \n Before submitting  ");

	var screenid = $('#screen_id').val();
	 
   
    $.ajax({
        type:'POST',
        url:'generateAppointments',
		//dataType: 'json',
		data: {'screen_id':screenid},
        success:function(data){
           // console.log('success');
            //console.log(data);
		  window.location = "manage-slots";

			 
        },
        error:function(){

        }
						 

		});
}
$(document).ready(function(){
	$('#timeval_status').change(function(){
		
	if($('#timeval_status').val()=='pass'){
	$('#timeval_status-error').html('');
}
	});
});
