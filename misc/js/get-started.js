$(document).ready(function() {
    $('#new-hide-1').removeClass("d-none");
    var gst = $('#get-started-table').DataTable({
        "order": [[0, "desc"]],
        select: {
            style: 'single'
        },
        "columnDefs": [
            {
                "targets": [5],
                "visible": false,
                "searchable": false
            }]
    });
    $('#new-hide-1').addClass("d-none");

    $('input[type=radio][name=patientOption]').change(function() {
        $("#img").attr("src","/clinic1/img/user.png");
        if (this.value == 'newPatient') 
        {
            var inputList = ['first', 'mid', 'last', 'gender', 'age', 'contact_number'];
            for (i = 0; i < inputList.length; i++)
            {
                $('input[type=text][name='+inputList[i]+']').val("").attr("required", "required").removeAttr("readonly");
            }
            $('input[type=file][name=img]').val("").attr("required", "required");
            $('textarea[name=address]').val("").attr("required", "required").removeAttr("readonly");
            $('input[type=text][name=id]').val("");

            $(".existing-hide").removeClass("d-none");
            $(".new-hide").addClass("d-none");

        }
        else if (this.value == "existingPatient")
        {
            var inputList = ['first', 'mid', 'last', 'gender', 'age', 'contact_number'];
            for (i = 0; i < inputList.length; i++)
            {
                $('input[type=text][name='+inputList[i]+']').val("").removeAttr("required").attr("readonly", "readonly");
            }

            $('input[type=file][name=img]').val("").removeAttr("required");
            $('textarea[name=address]').val("").removeAttr("required").attr("readonly", "readonly");
            $('input[type=text][name=id]').val("");

            $(".existing-hide").addClass("d-none");
            $(".new-hide").removeClass("d-none");
        }
    });

    $("#get-started-table tbody").on("click", "tr", function() 
    {
        var inputList = ['id', 'first', 'mid', 'last', 'date_registered'];
        for (col = 0; col < inputList.length; col++)
        {
            var temp = gst.row(this).data()[col];
            $('input[type=text][name='+inputList[col]+']').val(temp);
        }
        $('#img').attr('src','/clinic1/uploads/patient/'+gst.row(this).data()[5]);
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
                $('#img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else
        {
            $('#img').attr('src', '/img/no_preview.png');
        }
    });

    $("input[type=text][name=contact_number]").keyup(function() {
        $(this).removeClass("is-invalid");
        $(this).removeClass("is-valid");
        $("#num_error").text("");
        if (this.value != "")
        {
            var num = this.value;
            if (num.length != 7 && num.length != 11)
            {
                $(this).addClass("is-invalid");
                $("#num_error").text("Invalid contact number");
            }
            else
            {
                if (num.length == 11 && num.substring(0,2) != "09")
                {
                    $(this).addClass("is-invalid");
                    $("#num_error").text("Invalid contact number");
                }
                else
                {
                    $(this).addClass("is-valid");
                    $("#num_error").text("");
                }
            }
        }
    });

    $("input[type=text][name=age]").keyup(function() {
        $(this).removeClass("is-invalid");
        $(this).removeClass("is-valid");
        $("#age_error").text("")
        if (this.value != "")
        {
            var num = this.value;
            if (num > 130)
            {
                $(this).addClass("is-invalid");
                $("#age_error").text("Invalid age");
            }
            else
            {
                $(this).addClass("is-valid");
                $("#age_error").text("");
            }
        }
    });
});