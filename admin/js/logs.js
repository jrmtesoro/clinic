$(document).ready(function(){
    var lt = $('#logs-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [3,4,5],
                "visible": false,
                "searchable": false
            }]
    });

    $("#logs-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('#log-info-modal').modal('show');
            var log_id = lt.row(this).data()[0];
            var table = lt.row(this).data()[3];
            var affected_id = lt.row(this).data()[4];
            var employee_id = lt.row(this).data()[5];
            $('#row2').removeClass('d-none');
            $('#row3').removeClass('d-none');
            $('#row4').removeClass('d-none');

            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-employee-name",
                type: "POST",
                dataType: "text",
                data: {'employee_id' : employee_id},
                success: function(response) 
                {
                    $('#log_by').text(response);
                }
            });

            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-log-action",
                type: "POST",
                dataType: "text",
                data: {'log_id' : log_id},
                success: function(response) 
                {
                    $('#log_action').html(response);
                }
            });

            if (table == "")
            {
                $('#row3').addClass('d-none');
            }
            if (employee_id == "")
            {
                $('#row2').addClass('d-none');
            }
            if (affected_id == "")
            {
                $('#row4').addClass('d-none');
            }

            if (table == "patient")
            {
                $('#log_affected_title').text("Patient ID: ")
            }
            else if (table == "company")
            {
                $('#log_affected_title').text("Company ID: ")
            }
            else if (table == "result")
            {
                $('#log_affected_title').text("Case #: ")
            }
            else if (table == "employee")
            {
                $('#log_affected_title').text("Employee ID: ")
            }
            else if (table == "question")
            {
                $('#log_affected_title').text("Question ID: ")
            }
            else if (table == "services")
            {
                $('#log_affected_title').text("Service ID: ")
            }
            else if (table == "lab_code")
            {
                $('#log_affected_title').text("Case #: ")
                table = "result ";
            }
            else if (table == "company_result")
            {
                $('#log_affected_title').text("Company ID: ")
                table = "company";
            }
            else if (table == "request")
            {
                $('#log_affected_title').text("Request ID: ")
            }
            $('#log_id').text(lt.row(this).data()[0]);
            $('#log_table').text(table);
            if (table == "result")
            {
                $.ajax({
                    url: "/clinic1/includes/post.php?tag=get-case",
                    type: "POST",
                    dataType: "text",
                    data: {'id' : affected_id},
                    success: function(response) 
                    {
                        $('#log_affected').text(response);
                    }
                });
            }
            else
            {
                $('#log_affected').text(affected_id);
            }
        }
        else
        {

        }
    });

    $('#log-info-modal').on('hide.bs.modal', function (e) {
        lt.rows({selected: true}).deselect();
    })
});