$(document).ready(function() {
    slickInit();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        $(".slider").slick("unslick");
        slickInit();
    });
});

function slickInit() {
    $('.slider').slick({
        draggable: false,
        infinite: false,
        slidesPerRow: 3,
        slidesToShow: 3
    });

}

$(function(){
    $('#user_report_dateFrom').daterangepicker({
        singleDatePicker: true,
    });
});
$(function(){
    $('#user_report_dateTo').daterangepicker({
        singleDatePicker: true,
    });
});
function getUsersForSelect() {
    let selectList = $('#user_report_user');
    document.getElementById('nav-report-tab').removeAttribute('onclick');
    $.ajax({
        url: routeGetUsers,
        method: 'GET',
        success: function (data) {
            $.each(data, function (key, value) {
                selectList.append('<option value="' + key + '">' + value + '</option>');
            });
        }
    })
}

function displayReport() {
    let data = $('#user_report_form').serializeArray();

    $.ajax({
        url: routeGetReport,
        method: 'POST',
        data: data,
        success: function (res) {
           console.log(res)
        }
    })
}
