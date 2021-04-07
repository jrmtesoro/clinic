$(document).ready(function(){
    var qt = $('#question-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[1, "desc"]],
        "columnDefs": [
            {
                "targets": [1],
                "visible": false,
                "searchable": false
            }]
    });

    var et = $('#exam-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "asc"]]
    });

    var pt = $('#permission-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "asc"]]
    });

    var st;

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = e.target.hash;
        if (target == "#service")
        {
            $('button[id=tag]').val("services");
            $('button[id=tag1]').addClass("d-none").val("");
            $('input[type=text][name=question]').val("").removeAttr("required");
            $('input[type=text][name=price]').val("").attr("required", "required");
            $('input[type=text][name=eName]').val("").removeAttr("required");
            $('textarea[name=description]').text("").removeAttr("required");
            if (!$.fn.DataTable.isDataTable('#services-table')) 
            {
                st = $('#services-table').DataTable({
                    select: {
                        style: 'single'
                    },
                    "order": [[0, "desc"]],
                    "columnDefs": [
                        {
                            "targets": [2,3],
                            "visible": false,
                            "searchable": false
                        }]
                });
            }
        }
        else if (target == "#secret_question")
        {
            $('button[id=tag]').val("question");
            $('button[id=tag1]').removeClass("d-none").val("delete-question");
            $('input[type=text][name=question]').val("").attr("required", "required");
            $('input[type=text][name=price]').val("").removeAttr("required");
            $('input[type=text][name=eName]').val("").removeAttr("required");
            $('textarea[name=description]').text("").removeAttr("required");
        }
        else if (target == "#xray")
        {
            $('button[id=tag]').val("exam");
            $('button[id=tag1]').removeClass("d-none").val("delete-exam");
            $('input[type=text][name=question]').val("").removeAttr("required");
            $('input[type=text][name=price]').val("").removeAttr("required");
            $('input[type=text][name=eName]').val("").attr("required", "required");
            $('textarea[name=description]').text("").removeAttr("required");
        }
        else if (target == "#permission")
        {
            $('button[id=tag]').val("permission");
            $('button[id=tag1]').addClass("d-none").val("");
            $('input[type=text][name=question]').val("").removeAttr("required");
            $('input[type=text][name=price]').val("").removeAttr("required");
            $('input[type=text][name=eName]').val("").removeAttr("required");
            $('textarea[name=description]').text("").attr("required", "required");
        }
    });

    $("#services-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=type]').val(st.row(this).data()[0]);
            $('input[type=text][name=price]').val(st.row(this).data()[1]);
            $('input[type=hidden][name=service_id]').val(st.row(this).data()[2]);
            $('input[type=hidden][name=code]').val(st.row(this).data()[3]);
        }
        else
        {
            $('input[type=text][name=type]').val("");
            $('input[type=text][name=price]').val("");
            $('input[type=hidden][name=service_id]').val("");
            $('input[type=hidden][name=code]').val("");
        }
    });

    $("#question-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=question_id]').val(qt.row(this).data()[1]);
            $('input[type=text][name=question]').val(qt.row(this).data()[0]);
        }
        else
        {
            $('input[type=text][name=question_id]').val("");
            $('input[type=text][name=question]').val("");
        }
    });

    $("#exam-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=eId]').val(et.row(this).data()[0]);
            $('input[type=text][name=eName]').val(et.row(this).data()[1]);
        }
        else
        {
            $('input[type=text][name=eId]').val("");
            $('input[type=text][name=eName]').val("");
        }
    });

    $("#permission-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=pId]').val(pt.row(this).data()[0]);
            $('input[type=text][name=pName]').val(pt.row(this).data()[1]);
            $('textarea[name=description]').text(pt.row(this).data()[2]);
        }
        else
        {
            $('input[type=text][name=pId]').val("");
            $('input[type=text][name=pName]').val("");
            $('textarea[name=description]').text("");
        }
    });
});