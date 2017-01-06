var p_begin;
var p_end;
var m_date;
var d_date;
var DOMAIN = "http://localhost/";

$(document).ready(function () {
    $("#insert-form").submit(function (e) {
        e.preventDefault();
        var url = DOMAIN + "/dashboard/insert";
        $("#insert-binding").empty();
        $.ajax({
            type: "POST",
            url: url,
            data: $("#insert-form").serialize(),
            success: function (data) {
                $("#insert-binding").html(data);
            }
        });
        $("#insert-form")[0].reset();
    });

    $("#period-form").submit(function (e) {
        e.preventDefault();
        p_begin = $('#p_begin').val();
        p_end = $('#p_end').val();
        var url = DOMAIN + "/dashboard/period";
        $("#period-binding").empty();
        $.ajax({
            type: "POST",
            url: url,
            data: $("#period-form").serialize(),
            success: function (data) {
                $("#period-binding").html(data);
            }
        });
    });

    $("#month-form").submit(function (e) {
        e.preventDefault();
        m_date = $('#m_date').val();
        var url = DOMAIN + "/dashboard/month";
        $("#month-binding").empty();
        $.ajax({
            type: "POST",
            url: url,
            data: $("#month-form").serialize(),
            success: function (data) {
                $("#month-binding").html(data);
            }
        });
    });

    $("#day-form").submit(function (e) {
        e.preventDefault();
        d_date = $('#d_date').val();
        var url = DOMAIN + "/dashboard/day";
        $("#day-binding").empty();
        $.ajax({
            type: "POST",
            url: url,
            data: $("#day-form").serialize(),
            success: function (data) {
                $("#day-binding").html(data);
            }
        });
    });

    $(function () {
        $('.monthpicker').datetimepicker({
            format: 'MM/YYYY'
        });
    });

    $(function () {
        $('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
});

function paginatePeriod(id) {
    var url = DOMAIN + "/dashboard/period";
    $("#period-binding").empty();
    $.ajax({
        type: "POST",
        url: url,
        data: "p_begin=" + p_begin + "&p_end=" + p_end + "&offset=" + id,
        success: function (data) {
            $("#period-binding").html(data);
        }
    });
}

function paginateMonth(id) {
    var url = DOMAIN + "/dashboard/month";
    $("#month-binding").empty();
    $.ajax({
        type: "POST",
        url: url,
        data: "m_date=" + m_date + "&offset=" + id,
        success: function (data) {
            $("#month-binding").html(data);
        }
    });
}

function paginateDay(id) {
    var url = DOMAIN + "/dashboard/day";
    $("#day-binding").empty();
    $.ajax({
        type: "POST",
        url: url,
        data: "d_date=" + d_date + "&offset=" + id,
        success: function (data) {
            $("#day-binding").html(data);
        }
    });
}