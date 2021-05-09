/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$('#hospital_id').change(function () {
    window.location = '/admin/update_hospital/' + $(this).val();
});
$(document).ready(function () {
    handleSwitcheryElements();
    let groupId = $("#group_id").val();
    if (typeof groupId != 'undefined' && groupId > 0)
    {
        $("#group_id").trigger('change');
    }
});
$("#group_id").change(function () {
    $('#user_id').find('option').remove();
    let groupId = $("#group_id").val();
//    console.log('groupId => ', groupId);
    var jqxhr = $.ajax("/admin/hospitals/getUsers/" + groupId)
            .done(function (data) {
//            console.log('data => ', data);
                var defaultOption = $('<option />');
                defaultOption.attr('value', 0).text("Select User");
                $('#user_id').append(defaultOption);
                var data = JSON.parse(data);
                $.each(data, function (key, val) {
                    var option = $('<option />');
                    option.attr('value', val.user_id).text(val.user_name);
                    if (val.user_id == $('#user_id').attr('data-value'))
                    {
                        option.attr('selected', true);
                    }
                    $('#user_id').append(option);
                });
//                $(".states").prop("disabled", false);
            })
            .fail(function () {
                alert("error");
            })
})
//function inactivaterow(module, id){
//    console.log($(this).is(":checked"));
//    console.log('Module => ', module);
//    console.log('id => ', id);
//}
$('.inactive_button').change(function (event) {
    event.preventDefault();
});


function initSwitchery2($class, $color, $speed, $size, $secondarycolor, $class2) {
    console.log('wear in initSwitchery2');
    var elems = Array.prototype.slice.call(document.querySelectorAll($class));
    var changeFields = Array.prototype.slice.call(document.querySelectorAll($class2));
    elems.forEach(function (el) {
        if ($(el).data('switchery') != true) {
            new Switchery(el, {color: $color, speed: $speed, size: $size, secondaryColor: $secondarycolor});
        }
    });
    $(elems).on("change", function (event, element) {
        let message = event.target.checked == true ? 'Do u want to activate the record ?' : 'Do u want to in-active the record ?';
        if (confirm(message)) {
            let params = {module: window.location.pathname, id: event.target.defaultValue, status: event.target.checked};
            $.post("/admin/update_status", params)
                    .done(function (data) {
                        if (data) {
                            let response = JSON.parse(data);
                            if (typeof response != 'undefined' && response.status == 1) {
                                location.reload();
                            } else if (typeof response != 'undefined' && response.status == 0) {
                                let responseMessage = typeof response.message != 'undefined' ? response.message : 'Something went wrong';
                                alert(responseMessage);
                            }
                        } else {
                            alert('Something went wrong');
                        }
                    });
//            if(event.target.checked){
//                $('#status_'+event.target.defaultValue).text('Active');
//                $('#edit_anchor_'+event.target.defaultValue).attr('href', 'javascript:void(0);');
//            }else{
//                $('#status_'+event.target.defaultValue).text('In-Active');
//                $('#edit_anchor_'+event.target.defaultValue).attr('href', 'javascript:void(0);');
//            }
        } else {
            console.log('event => ', $(event.target).parent());
            console.log('changeFields => ', changeFields);
            console.log('weare in else');
            event.target.checked = !event.target.checked;
        }
    });
}

handleSwitcheryElements = function () {
    console.log('wear in handleSwitcheryElements');
    initSwitchery2('.activate_button', '#00ACAC', '0.3s', 'small', '#ff5b57', '.switchery');
};

$("#countryId").on("change", function (ev) {
    var countryCode = $('#countryId').val();
    if (countryCode != '') {
        getTimezones(countryCode);
    } else {
        $(".timezones option:gt(0)").remove();
    }
});

function getTimezones(countryCode) {
    $(".timezones").find("option:gt(0)").remove();
    $('.timezones').find("option:eq(0)").html("Please wait..");
    var jqxhr = $.ajax("/getTimezonesbycountry/"+countryCode)
        .done(function (responseData) {
            $('.timezones').find("option:eq(0)").html("Select Timezone");
            console.log('responseData => ', responseData);
            var timezoneData = JSON.parse(responseData);
            console.log('timezoneData => ', timezoneData);
            $.each(timezoneData, function (key, timezones) {
                if(typeof timezones.id != 'undefined'){
                    console.log('timezones => ', timezones);
                    var option = $('<option />');
                    option.attr('value', timezones.id).text(timezones.utc);
                    if (timezones.id == $('#timezones').attr('data-value'))
                    {
                        option.attr('selected', true);
                    }
                    $('.timezones').append(option);
                }
            });
        })
        .fail(function () {
            //  alert( "error" );
        })
        .always(function () {
            //  alert( "complete" );
        });
}