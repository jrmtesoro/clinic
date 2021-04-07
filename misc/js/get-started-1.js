$('option').mousedown(function(e) {
    e.preventDefault();
    $(this).prop('selected', !$(this).prop('selected'));
    $("#service-name").html("");
    $("#service-price").html("");
    $("#change").text("0.00");
    $("#pay").val("").removeClass("is-invalid").removeClass("is-valid");
    var total_price = 0;
    $("#services > option").each(function() {
        if($(this).is(":selected")) 
        {
            $("#service-name").append("<p>"+$(this).text()+"</p>");
            $("#service-price").append("<p>"+$(this).data("price")+".00</p>");
            total_price += parseInt($(this).data("price"));
        }
    });

    $("#total").val(total_price+".00");
    if (parseInt($("#total").val()) != 0)
    {
        $("#pay").attr("required", "required");
    }
    else
    {
        $("#total").val('');
        $("#pay").removeAttr("required");
    }
    return false;
});

$("#pay").keyup(function(){
    var money = this.value;
    var total = parseInt($("#total").val());
    if (total != "")
    {
        if (money == "")
        {
            $(this).removeClass("is-valid");
            $(this).removeClass("is-invalid");
            $(this).val("");
        }
        else if (money - total < 0)
        {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
            $("#change").text("0.00");
        }
        else
        {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            $("#change").text(money-total+".00");
        }
    }
});