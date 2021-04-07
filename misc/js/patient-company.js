$(document).ready(function() {
    var pct = $('#patient-company-table').DataTable({
        select: {
            style: 'single'
        },
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        buttons : [{
            text: 'Add',
            action: function ( e, dt, node, config ) {
                if (dt.row( { selected: true } ).data())
                {
                    $("#company").find('input:text').val('');
                    $("#company").find('textarea').val('');
                    $('#company_id').addClass("d-none");
                }
                $('#patient').addClass("d-none");
                $("#patient").find('input:text').val('').removeAttr('required');
                $("#patient").find('textarea').val('').removeAttr('required');
                $("#patient").find('input:file').val('').removeAttr('required');

                $('#table-col').removeClass('col-12').addClass('col-7');
                $('#side-bar').removeClass('d-none');
                $('#company').removeClass("d-none");
                $('input[type=text][name=company_name]').attr('required', 'required');
                $('input[type=text][name=company_address]').attr('required', 'required');
                $('button[name=tag][value=company]').removeClass("d-none").text("Add");
            },
            className : "btn btn-info"
        },
        {
            text: 'Edit',
            action: function ( e, dt, node, config ) {
                if (dt.row( { selected: true } ).data())
                {
                    $('#patient').addClass("d-none");
                    $("#patient").find('input:text').val('').removeAttr('required');
                    $("#patient").find('textarea').val('').removeAttr('required');
                    $("#patient").find('input:file').val('').removeAttr('required');

                    var companyInfo = pct.row( { selected: true } ).data();
                    $('#table-col').removeClass('col-12').addClass('col-7');
                    $('#side-bar').removeClass('d-none');
                    $('#company').removeClass("d-none");
                    $('button[name=tag][value=company]').removeClass("d-none").text("Edit");
                    $('#company_id').removeClass("d-none");
                    $('input[type=text][name=company_name]').removeAttr('required');
                    $('input[type=text][name=company_address]').removeAttr('required');

                    var inputList = ['id', 'name'];
                    for (i = 0; i < 2; i++)
                    {
                        $('input[type=text][name=company_'+inputList[i]+']').val(companyInfo[i]);
                    }
                    $('textarea[name=company_address]').val(companyInfo[2]);
                }
                else
                {

                }
            },
            className : "btn btn-warning"
        }
        ],
        "order": [[0, "desc"]]
    });
    pct.buttons().container().appendTo( '#patient-company-table_wrapper .col-md-6:eq(0)' );

    $("#patient-company-table tbody").on("click", "tr", function() 
    {
        var table = $('#company-patient-table').DataTable();
        table.clear().destroy();
        if ($(this).hasClass('selected'))
        {
            $('input[type=hidden][name=c_id]').val('');
            $('#table-col').removeClass('col-7').addClass('col-12');
            $('#compat').addClass('d-none');
            $('#side-bar').addClass('d-none');
            $('#company').addClass("d-none");
            $('button[name=tag][value=company]').addClass("d-none").text("");
            $('#company_id').addClass("d-none");
            $('input[type=text][name=company_id]').val('');
            $('input[type=text][name=company_name]').removeAttr('required').val('');
            $('input[type=text][name=company_address]').removeAttr('required').val('');
        }
        else
        {
            var id = pct.row(this).data()[0];
            $('input[type=hidden][name=c_id]').val(id);
            $('#compat').removeClass('d-none');
            $('#company-patient-table').DataTable({
                "ajax" : {
                    "url" : "/clinic1/includes/post.php?tag=company-patient&id="+id,
                    "dataSrc" : ""
                },
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging":         false,
                responsive: true,
                "autoWidth": false,
                select: {
                    style: 'single'
                },
                "columns" : [
                    { "data" : "id" },
                    { "data" : "first" },
                    { "data" : "last" },
                ],
                dom : 'fBrtip',
                buttons : [{
                    text: 'Add New Patient',
                    action: function ( e, dt, node, config ) {
                        $('#patient').addClass("d-none");
                        $("#patient").find('input:text').val('').attr('required', 'required');
                        $("#patient").find('textarea').val('').attr('required', 'required');
                        $("#patient").find('input:file').val('').attr('required', 'required');

                        $('#table-col').removeClass('col-12').addClass('col-7');
                        $('#side-bar').removeClass('d-none');
                        $('#company').addClass("d-none");
                        $('button[name=tag][value=company]').addClass("d-none").text("");
                        $('#company_id').addClass("d-none");
                        $('input[type=text][name=company_id]').val('');
                        $('input[type=text][name=company_name]').removeAttr('required').val('');
                        $('input[type=text][name=company_address]').removeAttr('required').val('');
                        $('#patient').removeClass("d-none");


                    },
                    className : "btn btn-info"
                },
                {
                    text: 'Add Existing Patient',
                    action: function ( e, dt, node, config ) {
                        var existing_patient_table = $('#existing-patient-table').DataTable();
                        existing_patient_table.clear().destroy();
                        $('#existing-patient-table').DataTable({
                            "ajax" : {
                                "url" : "/clinic1/includes/post.php?tag=get-patients",
                                "dataSrc" : ""
                            },
                            dom : "ftrip",
                            responsive: true,
                            "autoWidth": false,
                            select: {
                                style: 'true'
                            },
                            "columns" : [
                                { "data" : "id" },
                                { "data" : "first" },
                                { "data" : "last" },
                            ]
                        });
                        $('#existing-patient-modal').modal('show')
                    },
                    className : "btn btn-secondary"
                },
                {
                    text: 'Remove Patient',
                    action: function ( e, dt, node, config ) {
                        var table_values = dt.row({selected: true}).data();
                        var id = table_values['id'];
                        $.ajax({
                            url: "/clinic1/includes/post.php?tag=delete-company-patient",
                            type: "POST",
                            dataType: "text",
                            data: {'id' : id},
                            success: function(response) 
                            {
                                var text_response = "";
                                if (response == "success")
                                {
                                    text_response = "Successfully deleted company patient!";
                                    $("#alert").addClass("alert-success");
                                }
                                else if (response == "error")
                                {
                                    text_response = "Failed to delete company patient!";
                                    $("#alert").addClass("alert-danger");
                                }
                                $("#alert").removeClass("d-none");
                                $("#alert-content").text(text_response);
                                dt.row({selected: true}).remove().draw(false);
                            }
                        });
                    },
                    className : "btn btn-danger"
                }]
            });
        }
    }); 

    $('button[name=add-existing-patient]').click(function(){
        var ept_values = $('#existing-patient-table').DataTable().rows({selected: true}).data();
        $('#existing-patient-table').DataTable().rows({selected: true}).remove().draw(false);
        var id = [];
        var company_id = pct.row({selected: true}).data()[0];
        for (col = 0; col < ept_values.length; col++)
        {
            id[col] = ept_values[col]['id'];
        }
        
        $.ajax({
            url: "/clinic1/includes/post.php?tag=add-existing-to-company",
            type: "POST",
            dataType: "text",
            data: {'id' : id, 'company_id' : company_id},
            success: function(response) 
            {
                var text_response = "";
                if (response == "success")
                {
                    text_response = "Successfully added company patient!";
                    $("#alert").addClass("alert-success");
                }
                else if (response == "error")
                {
                    text_response = "Failed to add company patient!";
                    $("#alert").addClass("alert-danger");
                }
                $("#alert").removeClass("d-none");
                $("#alert-content").text(text_response);
                $('#company-patient-table').DataTable().rows.add(ept_values).draw();
                $('#existing-patient-modal').modal('hide');
            }
        });
    });

    $('#alert-times').click(function(){
        $('#alert').addClass("d-none");
    });

    $('#close-btn').click(function(){
        $('#table-col').removeClass('col-7').addClass('col-12');
        $('#side-bar').addClass('d-none');
        $('#company').addClass("d-none");
        $('button[name=tag][value=company]').addClass("d-none").text("");
        $('#company_id').addClass("d-none");
        $('input[type=text][name=company_id]').val('');
        $('input[type=text][name=company_name]').removeAttr('required').val('');
        $('input[type=text][name=company_address]').removeAttr('required').val('');
        $('#patient').addClass("d-none");
        $("#patient").find('input:text').val('').removeAttr('required');
        $("#patient").find('textarea').val('').removeAttr('required');
        $("#patient").find('input:file').val('').removeAttr('required');
    });

    $("#patient_form").submit(function(e){
        e.preventDefault();
        var company_id = pct.row({selected: true}).data()[0];
        $.ajax({
            url: "/clinic1/includes/post.php?tag=add-company-patient&company_id="+company_id,
            type: "POST",
            dataType: "text",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) 
            {
                var text_response = "";
                if (response == "success")
                {
                    text_response = "Successfully added company patient!";
                    $("#alert").addClass("alert-success");
                }
                else if (response == "error")
                {
                    text_response = "Failed to add company patient!";
                    $("#alert").addClass("alert-danger");
                }
                else
                {
                    text_response = response;
                    $("#alert").addClass("alert-danger");
                }
                $("#patient").find('input:text').val('').attr('required', 'required');
                $("#patient").find('textarea').val('').attr('required', 'required');
                $("#patient").find('input:file').val('').attr('required', 'required');

                $("#alert").removeClass("d-none");
                $("#alert-content").text(text_response);

                $.ajax({
                    url: "/clinic1/includes/post.php?tag=get-latest-company-patient",
                    type: "POST",
                    dataType: "json",
                    data: {'company_id' : company_id},
                    success: function(response) 
                    {
                        $('#company-patient-table').DataTable().row.add(response).draw();
                    }
                });
            }
        });
    });

    $('input[type=file][name=img]').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#img').attr('src', '/img/no_preview.png');
        }
    });
});
