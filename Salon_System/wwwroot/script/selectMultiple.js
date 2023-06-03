$(document).ready(function () {
    $('.selectMultiple').select2({
        closeOnSelect: false,
        placeholder: "Click to select",
        allowHtml: true,
        allowClear: true,
        tags: true
    });
});