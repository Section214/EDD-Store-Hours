/*global jQuery, document*/
jQuery(document).ready(function ($) {
    "use strict";

    if ($(".edd-store-hours").length) {
        $(".edd-store-hours").datetimepicker({
            timeOnly: true,
            showTime: false,
            timeFormat: "h:mm tt"
        });
    }
    $(".edd-store-hours").clearable();

    $("select.edd_store_hours_status").change(function () {
        var selectedItem = $(this).val();

        if (selectedItem === "false") {
            $(this).closest("p").next().css("display", "none");
            $(this).closest("p").next().next().css("display", "none");
        } else {
            $(this).closest("p").next().css("display", "block");
            $(this).closest("p").next().next().css("display", "block");
        }
    }).change();

    $("select.edd_store_hours_time_format").change(function () {
        var selectedItem = $(this).val();

        if (selectedItem === "custom") {
            $(this).closest("p").next().css("display", "block");
        } else {
            $(this).closest("p").next().css("display", "none");
        }
    }).change();

    $("select.edd_store_hours_day_status").change(function () {
        var selectedItem = $(this).val();

        if (selectedItem === "open") {
            $(this).closest("td").find("span.edd-store-hours-input").css("display", "inline-block");
            $(this).closest("td").find("span.edd-help-tip").css("display", "none");
        } else {
            $(this).closest("td").find("span.edd-store-hours-input").css("display", "none");
            $(this).closest("td").find("span.edd-help-tip").css("display", "inline-block");
        }
    }).change();

    $("input[name='edd_settings[edd_store_hours_hide_buttons]']").change(function () {
        var checked = $(this).is(":checked");

        if (checked === true) {
            $("input[name='edd_settings[edd_store_hours_closed_label]']").closest("tr").css("display", "none");
        } else {
            $("input[name='edd_settings[edd_store_hours_closed_label]']").closest("tr").css("display", "table-row");
        }
    }).change();
});