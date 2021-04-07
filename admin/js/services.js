$(document).ready(function(){
    var st = $('#services-table').DataTable({
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

    $("#services-table tbody").on("click", "tr", function() 
    {
        if (!$(this).hasClass('selected'))
        {
            $('input[type=text][name=type]').val(st.row(this).data()[0]);
            $('input[type=text][name=price]').val(st.row(this).data()[1]);
            $('input[type=hidden][name=id]').val(st.row(this).data()[2]);
            $('input[type=hidden][name=code]').val(st.row(this).data()[3]);
        }
        else
        {
            $('input[type=text][name=type]').val("");
            $('input[type=text][name=price]').val("");
            $('input[type=hidden][name=id]').val("");
            $('input[type=hidden][name=code]').val("");
        }
    });
});