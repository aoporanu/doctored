$("#appointmentDate").change(function () {
    $('#appointmentTime').find('option').remove();
    let appointmentDate = $("#appointmentDate").val();
    let doctor_id = $("#doctor_id").val();
    let hospital_id = $("#hospital_id").val();
//    console.log('groupId => ', groupId);
    var jqxhr = $.ajax({type: "POST", url: "/getappointmenttimes", data: {appointmentDate, doctor_id, hospital_id}})
            .done(function (data) {
                console.log('data => ', data);
                var defaultOption = $('<option />');
                defaultOption.attr('value', 0).text("Select Time").attr('selected', 1);
                $('#appointmentTime').append(defaultOption);
                var data = JSON.parse(data);
                $.each(data, function (key, val) {
                    var option = $('<option />');
                    option.attr('value', val.id).text(val.booking_start_time);
                    if (val.id == $('#appointmentTime').attr('data-value'))
                    {
                        option.attr('selected', true);
                    }
                    $('#appointmentTime').append(option);
                });
            })
            .fail(function () {
                alert("error");
            })
})
