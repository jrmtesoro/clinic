$(document).ready(function() {
    var gst = $('#patient-company-1-table').DataTable({
        "order": [[0, "desc"]],
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "filter" : false,
        "info" : false
    });

    $('option').mousedown(function(e) {
        e.preventDefault();
        $(this).prop('selected', !$(this).prop('selected'));
        $("#service-name").html("");
        $("#service-price").html("");
        var patient_count = $('input[type=hidden][name=patient_count]').val();
        var total_company = 0;
        var total_price = 0;
        $("#services > option").each(function() {
            if($(this).is(":selected")) 
            {
                $("#service-name").append("<p>"+$(this).text()+"</p>");
                $("#service-price").append("<p>"+$(this).data("price")+".00</p>");
                total_price += parseInt($(this).data("price"));
                total_company += parseInt($(this).data("price"))*patient_count;
            }
        });
        $("#total_company").val(total_company+".00");
        $("#total").val(total_price+".00");
        return false;
    });
});