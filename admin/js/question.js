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

    $("#question-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=id]').val(qt.row(this).data()[1]);
            $('input[type=text][name=question]').val(qt.row(this).data()[0]);
        }
        else
        {
            $('input[type=text][name=id]').val("");
            $('input[type=text][name=question]').val("");
        }
    });
});