$(document).ready(function () {


    $('.panel-heading').on('click', function () {
        $(this).next('.panel-wrapper').slideToggle('slow');
    });

    $('#search_btn').on('click', function () {
       $('#result_div').show('slow')
    });

});