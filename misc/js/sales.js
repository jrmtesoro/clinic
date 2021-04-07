$(document).ready(function() {
    var st = $('#sales-table').DataTable({
        select: {
            style: 'single'
        },
        responsive: true,
        "autoWidth": false,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [5, 6],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [4],
                "render" : function(data, type, row)
                {
                    return data == 'Yes' ? '<button type="button" class="btn btn-primary btn-sm">Print</button>' : ''
                }
            }
        ]
    });

    var ct = $('#company-table').DataTable({
        select: {
            style: 'single'
        },
        responsive: true,
        "autoWidth": false,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [0, 4, 6],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [5],
                "render" : function(data, type, row)
                {
                    return data == 'Yes' ? '<button type="button" class="btn btn-primary btn-sm">Print</button>' : ''
                }
            }
    ]
    });


    $('#sales-table tbody').on('click', 'button', function (){
        var data = st.row($(this).parents('tr')).data();
        var wdw = window.open('', '_blank');
        $.ajax({
            url: "/clinic1/includes/post.php?tag=print-result",
            type: "POST",
            dataType: "text",
            data: {'lab_code': data[0], 'result_id': data[5], 'patient_id': data[6]},
            success: function(response) 
            {
                wdw.location = response;
            }
            ,
            error: function(XMLHttpRequest, textStatus, errorThrown) 
            {
                console.log(XMLHttpRequest['responseText']);
            }
        });
    });

    $('#company-table tbody').on('click', 'button', function (){
        var data = ct.row($(this).parents('tr')).data();
        $.ajax({
            url: "/clinic1/includes/post.php?tag=print-result-company",
            type: "POST",
            dataType: "text",
            data: {'company_id': data[0], 'company_result_id': data[4]},
            success: function(response) 
            {
                console.log(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) 
            {
                console.log(XMLHttpRequest['responseText']);
            }
        });
    });

    $("#sales-table tbody").on("click", "tr", function() 
    {
        clearDatas();
        $("#services > option").each(function() {
            $(this).removeProp('selected');
        });
        if (!$(this).hasClass('selected'))
        {
            $("button[name=tag]").removeClass('d-none');
            var result_id = st.row(this).data()[4];
            var patient_id = st.row(this).data()[5];
            var lab_code = st.row(this).data()[0];
            $("input[type=hidden][name=patient_id]").val(patient_id);
            $("input[type=hidden][name=result_id]").val(result_id);
            $("input[type=hidden][name=lab_code]").val(lab_code);
            $("#lab_code").text("Case #"+lab_code);
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-tables",
                type: "POST",
                dataType: "json",
                data: {'lab_code': lab_code},
                success: function(response) 
                {
                    var total_price = 0;
                    $.each(response, function(i, value) {
                        $("#services > option").each(function() {
                            if ($(this).text() == response[i].type)
                            {
                                $(this).prop('selected', 'selected');
                            }
                        });
                        total_price += parseInt(response[i].price);
                        $("#service-name").append("<p>"+response[i].type+"</p>");
                        $("#service-price").append("<p>"+response[i].price+".00</p>");
                    });
                    $("#total").val(total_price+".00");
                }
            });
        }
        else
        {
            $("button[name=tag]").addClass('d-none');
            $(".medservices").addClass("d-none");
            $("#pay").removeAttr("required");
        }
    });

    $("#company-table tbody").on("click", "tr", function() 
    {
        clearDatas();
        $("#services > option").each(function() {
            $(this).removeProp('selected');
        });
        $('#company-patient-table').DataTable().clear().destroy();
        if (!$(this).hasClass('selected'))
        {
            $("button[name=tag]").removeClass('d-none');
            var company_id = ct.row(this).data()[0];
            var company_result_id = ct.row(this).data()[4];
            var company_count = ct.row(this).data()[5];
            $("input[type=hidden][name=company_result_id]").val(company_result_id);
            $("#lab_code").text(ct.row(this).data()[1]);
            $.ajax({
                url: "/clinic1/includes/post.php?tag=company-sales",
                type: "POST",
                dataType: "json",
                data: {'company_id' : company_id, 'company_result_id' : company_result_id},
                success: function(response) 
                {
                    var total_price = 0;
                    $.each(response, function(i, value) {
                        $("#services > option").each(function() {
                            if ($(this).text() == response[i].type)
                            {
                                $(this).prop('selected', 'selected');
                            }
                        });
                        total_price += parseInt(response[i].price);
                        $("#service-name").append("<p>"+response[i].type+"</p>");
                        $("#service-price").append("<p>"+response[i].price+".00</p>");
                    });
                    $("#total").val((total_price*company_count)+".00");
                    $("#ptotal").val(total_price+".00");
                }
            });

            $('#cpt').removeClass('d-none');
            $('#company-patient-table').DataTable({
                "ajax" : {
                    "url" : "/clinic1/includes/post.php?tag=company-sales-patient&company_result_id="+company_result_id+"&company_id="+company_id,
                    "dataSrc" : ""
                },
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging":         false,
                "info" : false,
                responsive: true,
                "autoWidth": false,
                "columns" : [
                    { "data" : "lab_code" },
                    { "data" : "first" },
                    { "data" : "last" },
                    { "data" : "datetime" }
                ]
            });
        }
        else
        {
            $('#cpt').addClass('d-none');
            $("button[name=tag]").addClass('d-none');
            $(".medservices").addClass("d-none");
        }
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        clearDatas();
        $("button[name=tag]").addClass('d-none');
        $(".medservices").addClass("d-none");
        $("#pay").removeAttr("required");
        st.rows('.selected').deselect();
        ct.rows('.selected').deselect();
        if ($(this).text() == "Patient")
        {
            $("#tag").val('sales');
            $(".hide").removeClass("d-none");
            $(".phide").addClass("d-none");
            $('#cpt').addClass('d-none');
            $('#company-patient-table').DataTable().clear().destroy();
        }
        else
        {
            $("#tag").val('company-sales-edit');
            $(".hide").addClass("d-none");
            $(".phide").removeClass("d-none");
        }
    })

    function clearDatas()
    {
        $("#pay").removeClass("is-valid");
        $("#pay").removeClass("is-invalid");
        $(".medservices").removeClass("d-none");
        $("#change").text("0.00");
        $("#service-name").html("");
        $("#service-price").html("");
        $("#services").val("");
        $("#total").val("0.00");
        $("#ptotal").val("0.00");
        $("#lab_code").text("");
        $("input[type=hidden][name=company_result_id]").val("");
        $("input[type=hidden][name=patient_id]").val("");
        $("input[type=hidden][name=result_id]").val("");
        $("input[type=hidden][name=lab_code]").val("");
    }
});