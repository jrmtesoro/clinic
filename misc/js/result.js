$(document).ready(function() {
    var rt = $('#result-table').DataTable({
        select: {
            style: 'single'
        },
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [4, 5],
                "visible": false,
                "searchable": false
            }]
    });
    $("#rt1").removeClass("d-none");
    var rt1 = $('#result-table-1').DataTable({
        select: {
            style: 'single'
        },
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [4, 5],
                "visible": false,
                "searchable": false
            }]
    });
    $("#rt1").addClass("d-none");
    $("#result-table tbody").on("click", "tr", function() {
        clearData();
        $("input[type=hidden][name=lab_code]").val(rt.row(this).data()[0]);
        $("input[type=hidden][name=patient_id]").val(rt.row(this).data()[4]);
        var lab_code = rt.row(this).data()[0];
        var gender = rt.row(this).data()[5];
        $.ajax({
            url: "/clinic1/includes/post.php?tag=get-tables",
            type: "POST",
            dataType: "json",
            data: {'lab_code': lab_code},
            success: function(response) 
            {
                for (i = 0; i < response.length; i++)
                {
                    var table = response[i].code;
                    if (table == "xray")
                    {
                        $("#radtech").removeClass("d-none");
                    }
                    else
                    {
                        $("#medtech").removeClass("d-none");
                        $("#physician").removeClass("d-none");
                    }
                    if (table == "hematology")
                    {
                        $("#"+gender+"Hematocrit").removeAttr("disabled");
                        $("#"+gender+"Hemoglobin").removeAttr("disabled");
                    }
                    if (i == 0)
                    {
                        $("#"+table).addClass("active show");
                        $("."+table).addClass("active");
                    }
                    $("."+table).removeClass("d-none");
                    $("#"+table+"_lab_code").text("Case #"+lab_code);
                }
                $.each(response, function(i, item) {
                    $.ajax({
                        url: "/clinic1/includes/post.php?tag=get-result-id",
                        type: "POST",
                        dataType: "json",
                        data: {'result_id': response[i].id, 'table': response[i].code},
                        success: function(response1) 
                        {
                            $('input[type=hidden][name='+response[i].code+'_id]').val(response1.id);
                        }
                    });
                })
            }
        });
    });

    $("#result-table-1 tbody").on("click", "tr", function() {
        clearData();
        var lab_code = rt1.row(this).data()[0];
        var gender = rt1.row(this).data()[5];
        $("input[type=hidden][name=lab_code]").val(lab_code);
        $("input[type=hidden][name=patient_id]").val(rt1.row(this).data()[4]);
        $.ajax({
            url: "/clinic1/includes/post.php?tag=get-tables",
            type: "POST",
            dataType: "json",
            data: {'lab_code': lab_code},
            success: function(response) 
            {
                for (i = 0; i < response.length; i++)
                {
                    var table = response[i].code;
                    if (table == "hematology")
                    {
                        $("#"+gender+"Hematocrit").removeAttr("disabled");
                        $("#"+gender+"Hemoglobin").removeAttr("disabled");
                    }
                    if (i == 0)
                    {
                        $("#"+table).addClass("active show");
                        $("."+table).addClass("active");
                    }
                    $("."+table).removeClass("d-none");
                    $("#"+table+"_lab_code").text("Case #"+lab_code);
                }
                $.each(response, function(i, item) {
                    $.ajax({
                        url: "/clinic1/includes/post.php?tag=get-result-id",
                        type: "POST",
                        dataType: "json",
                        data: {'result_id': response[i].id, 'table': response[i].code},
                        success: function(resp) 
                        {
                            $('input[type=hidden][name='+response[i].code+'_id]').val(resp.id);
                            if (response[i].code == "hematology")
                            {
                                $("#"+gender+"Hemoglobin").val(resp.hemoglobin);
                                $("#"+gender+"Hematocrit").val(resp.hematocrit);
                                $("input[type=text][name=wbc_count]").val(resp.wbc_count);
                                $("input[type=text][name=platelet_count]").val(resp.platelet_count);
                                $("input[type=text][name=neutrophils]").val(resp.neutrophils);
                                $("input[type=text][name=lymphocytes]").val(resp.lymphocytes);
                                $("input[type=text][name=monocytes]").val(resp.monocytes);
                                $("input[type=text][name=eosinophils]").val(resp.eosinophils);
                                $("input[type=text][name=basophils]").val(resp.basophils);
                                $("input[type=text][name=stab_cells]").val(resp.stab_cells);
                                $("input[type=text][name=blood_type]").val(resp.blood_type);
                            }
                            else if (response[i].code == "urinalysis")
                            {
                                $("input[type=text][name=color]").val(resp.color);
                                $("input[type=text][name=transparency]").val(resp.transparency);
                                $("input[type=text][name=ph_reaction]").val(resp.ph_reaction);
                                $("input[type=text][name=specific_gravity]").val(resp.specific_gravity);
                                $("select[name='glucose']").val(resp.glucose);
                                $("select[name='protein']").val(resp.protein);
                                $("input[type=text][name=rbc]").val(resp.rbc);
                                $("input[type=text][name=wbc]").val(resp.wbc);
                                $("select[name='e_c']").val(resp.e_c);
                                $("select[name='a_u']").val(resp.a_u);
                                $("select[name='bacteria']").val(resp.bacteria);
                                $("select[name='mucus_threads']").val(resp.mucus_threads);
                                $("input[type=text][name=others]").val(resp.others);
                            }
                            else if (response[i].code == "fecalysis")
                            {
                                $("input[type=text][name=color1]").val(resp.color);
                                $("input[type=text][name=consistency]").val(resp.consistency);
                                $("input[type=text][name=rbc1]").val(resp.rbc);
                                $("input[type=text][name=pus_cells]").val(resp.pus_cells);
                                $("select[name='bacteria1']").val(resp.bacteria);
                                $("select[name='fat_globules']").val(resp.fat_globules);
                                $("select[name='yeast_cells']").val(resp.yeast_cells);
                                $("input[type=text][name=parasites]").val(resp.parasites);
                            }
                            else if (response[i].code == "xray")
                            {
                                $("select[name='examination']").val(resp.examination);
                                $("textarea[name=impression]").val(resp.impression);
                                $("textarea[name=observation]").val(resp.observation);
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest['responseText']);
                         }
                    });
                })
            }
        });
    });

    $("#update-result").click(function() {
        var lab_code = $("input[type=hidden][name=lab_code]").val();
        if (lab_code == "")
        {
            $('#alert-body').removeClass('d-none');
            $('#alert-content').html("Please pick a patient!");
        }
        else
        {
            $('#update-modal').modal('show');
        }
    });

    $(function () {
        $("form").on('submit', function (e) {
            e.preventDefault();
            window.scrollTo(0, 0);
            var tag = $('input[type=hidden][name=radio_button_val]').val();
            $.ajax({
                url: "/clinic1/includes/post.php?tag="+tag,
                type: "POST",
                dataType: "json",
                data: $(this).serialize(),
                success: function(response) 
                {
                    if (response['success'] == 1)
                    {
                        location.reload();
                        
                    }
                    else if (response['error'] == 1)
                    {
                        $('#alert-body').removeClass('d-none');
                        $('#alert-content').html(response['msg']);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                 }
            });
            $('#request-modal').modal('hide');
        });
    });


    $('input[type=radio][name=resultOption]').change(function() {
        clearData();
        if (this.value == "newResult")
        {
            $("#rt1").addClass("d-none");
            $("#rt").removeClass("d-none");
            $("#update-result").removeClass('d-none');
            $("#request-btn").addClass('d-none');
            $('input[type=hidden][name=radio_button_val]').val("update-result");
        }
        else if (this.value == "existingResult")
        {
            $("#rt1").removeClass("d-none");
            $("#rt").addClass("d-none");
            $("#request-btn").removeClass('d-none');
            $("#update-result").addClass('d-none');
            $('input[type=hidden][name=radio_button_val]').val("request-update");
        }
    });

    $('.alert#alert-body').on('close.bs.alert', function (e) {
        e.preventDefault();
        $(this).addClass('d-none');
    });

    $('.decimal').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
             val = val.replace(/[^0-9\.]/g,'');
             if(val.split('.').length>2) 
                 val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });
});

function clearData()
{
    $("#radtech").addClass("d-none");
    $("#medtech").addClass("d-none");
    $("#physician").addClass("d-none");
    $("#MaleHemoglobin").attr("disabled", true);
    $("#FemaleHemoglobin").attr("disabled", true);
    $("#MaleHematocrit").attr("disabled", true);
    $("#FemaleHematocrit").attr("disabled", true);
    $(".results").find('input:text').val('');
    $(".results").find('textarea').val('');
    $(".hidden_id").val('');
    $(".results").find('select').prop('selectedIndex', 0);
    var resultList = ['urinalysis', 'hematology', 'fecalysis', 'xray'];
    for (i = 0; i < resultList.length; i++)
    {
        $("#"+resultList[i]).removeClass("active show");
        $("."+resultList[i]).removeClass("active");
        $("."+resultList[i]).addClass("d-none");
    }
}