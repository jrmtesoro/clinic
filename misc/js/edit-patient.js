$(document).ready(function() {
    var ept = $('#edit-patient-table').DataTable({
        select: {
            style: 'single'
        },
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        lengthChange: false,
        buttons: ['colvis'],
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [9],
                "visible": false,
                "searchable": false
            }]
    });
    
    ept.buttons().container().appendTo( '#edit-patient-table_wrapper .col-md-6:eq(0)' );

    $("#edit-patient-table tbody").on("click", "tr", function() 
    {
        var inputList = ['id', 'first', 'mid', 'last', 'age', '', '', 'contact_number','date_registered'];
        for (col = 0; col <= 9; col++)
        {
            if (col != 9 && col != 6 && col != 5)
            {
                var temp = ept.row(this).data()[col];
                $('input[type=text][name='+inputList[col]+']').val(temp);
            }
        }
        $('#img_name').attr('src','/clinic1/uploads/patient/'+ept.row(this).data()[9]);
        $('textarea[name=address]').text(ept.row(this).data()[6]);
        $('select[name=gender]').val(ept.row(this).data()[5]);
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    }); 

    $('input[type=file][name=img]').change(function(){
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "png" || ext == "jpeg" || ext == "jpg")) 
            {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_name').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#img_name').attr('src', '/img/no_preview.png');
        }
    });
});