$(document).ready(function () {

console.log('Script started');
    $('.panel-heading').on('click', function () {
        $(this).next('.panel-wrapper').slideToggle('slow');
    });

    $('#search_btn').on('click', function () {
       $('#result_div').show('slow');
    });

    $('#search_btn_table').on('click', function () {
        $('#table_results_div').show('fast');
    });
});