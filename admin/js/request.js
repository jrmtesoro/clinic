$(document).ready(function(){
    var rt = $('#request-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "desc"]]
    });

    var rt1 = $('#request-table1').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "desc"]]
    });

    var rt2 = $('#request-table2').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "desc"]]
    });

    $("#request-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('#request-info-modal').modal('show');
            var request_id = rt.row(this).data()[0];
            var request_case = rt.row(this).data()[1];
            var request_reason = rt.row(this).data()[2];
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-request-input",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_changes').html(response);
                }
            });
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-employee-request",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_by').text(response);
                }
            });
            $('#request_id').text(request_id);
            $('#request_case').text(request_case);
            $('#request_reason').text(request_reason);
            $("input[type=hidden][name=request_id]").val(request_id);
        }
        else
        {
            $("input[type=hidden][name=request_id]").val("");
        }
    });

    $("#request-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('#request-info-modal').modal('show');
            var request_id = rt.row(this).data()[0];
            var request_case = rt.row(this).data()[1];
            var request_reason = rt.row(this).data()[2];
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-request-input",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_changes').html(response);
                }
            });
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-employee-request",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_by').text(response);
                }
            });
            $('#request_id').text(request_id);
            $('#request_case').text(request_case);
            $('#request_reason').text(request_reason);
            $("input[type=hidden][name=request_id]").val(request_id);
        }
        else
        {
            $("input[type=hidden][name=request_id]").val("");
        }
    });

    $("#request-table1 tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('#request-info-modal1').modal('show');
            var request_id = rt1.row(this).data()[0];
            var request_case = rt1.row(this).data()[1];
            var request_reason = rt1.row(this).data()[2];
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-request-input",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_changes1').html(response);
                }
            });
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-employee-request",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_by1').text(response);
                }
            });
            $('#request_id1').text(request_id);
            $('#request_case1').text(request_case);
            $('#request_reason1').text(request_reason);
        }
    });

    $("#request-table2 tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('#request-info-modal1').modal('show');
            var request_id = rt2.row(this).data()[0];
            var request_case = rt2.row(this).data()[1];
            var request_reason = rt2.row(this).data()[2];
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-request-input",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_changes1').html(response);
                }
            });
            $.ajax({
                url: "/clinic1/includes/post.php?tag=get-employee-request",
                type: "POST",
                dataType: "text",
                data: {'request_id' : request_id},
                success: function(response) 
                {
                    $('#request_by1').text(response);
                }
            });
            $('#request_id1').text(request_id);
            $('#request_case1').text(request_case);
            $('#request_reason1').text(request_reason);
        }
    });

    $('#request-info-modal').on('hide.bs.modal', function (e) {
        rt.rows({selected: true}).deselect();
    })

    $('#request-info-modal1').on('hide.bs.modal', function (e) {
        rt1.rows({selected: true}).deselect();
        rt2.rows({selected: true}).deselect();
    })
});