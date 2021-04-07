$(document).ready(function(){
    var et = $('#employee-table').DataTable({
        select: {
            style: 'single'
        },
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": [9, 10],
                "visible": false,
                "searchable": false
            }]
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('html, body').animate({scrollTop: ($('.employee').offset().top)},500);
      })

    $("#employee-table tbody").on("click", "tr", function() 
    {
        $('html, body').animate({scrollTop: ($('.employee').offset().top)},500);
        var inputList = ['id', 'first', 'mid', 'last', '', 'email', '', 'contact_number', 'date_employed', '', 'license'];
        for (col = 0; col <= 10; col++)
        {
            if (col != 4 && col != 6 && col != 9)
            {
                var temp = et.row(this).data()[col];
                $('input[type=text][name='+inputList[col]+']').val(temp);
            }
        }
        $('select[name="job"]').val(et.row(this).data()[6]);
        var id = et.row(this).data()[0];
        $.ajax({
            url: "/clinic1/includes/post.php?tag=get-account",
            type: "POST",
            dataType: "json",
            data: {'id': id},
            success: function(response) 
            {
                $('input[type=text][name=username]').val(response.user);
                $('select[name="secret_question"]').val(response.question);
            }
        });

        $.ajax({
            url: "/clinic1/includes/post.php?tag=get-permission",
            type: "POST",
            dataType: "json",
            data: {'id': id},
            success: function(response) 
            {
                var description = "";
                var permission_values = [];
                $.each(response, function(i, value) {
                    permission_values.push(response[i].id);
                    description += "<p><strong>"+response[i].name+"</strong> - "+response[i].description+"</p>";
                });
                $("#permission-desc").html(description);
                $("#perm").val(permission_values);
            }
        });
        $('#img').attr('src','/clinic1/uploads/employee/'+et.row(this).data()[9]);
        $('textarea[name=address]').text(et.row(this).data()[4]);
    }); 

    
    $("#pass1").keyup(function(){
        var password = $("#pass").val();
        if (password.length == 0)
        {
            $("#pass1").removeClass("is-invalid");
            $("#pass1").removeClass("is-valid");
        }
        else if (password != this.value)
        {
            $("#pass1").removeClass("is-valid");
            $("#pass1").addClass("is-invalid");
            $("#passError1").text("Password does not match.");
        }
        else
        {
            $("#pass1").removeClass("is-invalid");
            $("#pass1").addClass("is-valid");
            $("#passError1").text("");
        }
    });

    $("#pass").keyup(function(){
        var errorId = [];
        var errorText = 
        {
            "#error1":"Must be more than 8 characters.",
            "#error2":"Must be contain 1 digit.",
            "#error3":"Must contain 1 lower case.",
            "#error4":"Must contain 1 upper case."
        };
        if (this.value != "")
        {
            if(this.value.length < 8)
            {
                errorId[errorId.length] = "#error1";
            }
            if(!/\d/.test(this.value))
            {
                errorId[errorId.length] = "#error2";
            }
            if(!/[a-z]/.test(this.value))
            {
                errorId[errorId.length] = "#error3";
            }
            if(!/[A-Z]/.test(this.value))
            {
                errorId[errorId.length] = "#error4";
            }
            if (errorId.length == 0)
            {
                $("#pass").removeClass("is-invalid");
                $("#pass").addClass("is-valid");

            }
            else
            {
                $("#pass").removeClass("is-valid");
                $("#pass").addClass("is-invalid");
            }
            $("#passError").html("");
            for (i = 0; i < errorId.length; i++)
            {
                $("#passError").append(errorText[errorId[i]]+'<br>');
            }

            if (this.value != $("#pass1").val() && $("#pass1").val() != "")
            {
                $("#pass1").removeClass("is-valid");
                $("#pass1").addClass("is-invalid");
                $("#passError1").text("Password does not match.");
            }
            else if (this.value == $("#pass1").val() && errorId.length == 0)
            {
                $("#pass1").removeClass("is-invalid");
                $("#pass1").addClass("is-valid");
                $("#passError1").text("");
            }
        }
        else
        {
            $("#pass1").removeClass("is-valid");
            $("#pass1").removeClass("is-invalid");
            $("#pass").removeClass("is-valid");
            $("#pass").removeClass("is-invalid");
        }
    });

    $('input[type=radio][name=employeeOption]').change(function() {
        $("#permission-desc").html("");
        $("#perm").val("");
        $(".employee").find('input:text').val('');
        $(".employee").find('input:password').val('');
        $("#pass1").removeClass("is-valid");
        $("#pass1").removeClass("is-invalid");
        $("#pass").removeClass("is-valid");
        $("#pass").removeClass("is-invalid");
        $(".employee").find('select').prop('selectedIndex', 0);
        $('#img').attr('src','/clinic1/img/user.png');
        $("input[type=file][name=img]").val("");
        if (this.value == "newEmployee")
        {
            $(".new-hide").addClass("d-none");
            $("input[type=text][name=username]").removeAttr("readonly");
            $(".new-account").find('input:text').attr("required", "required");
            $(".new-account").find('input:password').attr("required", "required");
            $("input[type=file][name=img]").attr("required", "required");
        }
        else
        {
            $(".new-hide").removeClass("d-none");
            $("input[type=text][name=username]").attr("readonly", "readonly");
            $(".new-account").find('input:text').removeAttr("required");
            $(".new-account").find('input:password').removeAttr("required");
            $("input[type=file][name=img]").removeAttr("required");
        }
    });

    $('option').mousedown(function(e) {
        e.preventDefault();
        $(this).prop('selected', !$(this).prop('selected'));
        $("#permission-desc").html("");
        var description = "";
        $("#perm > option").each(function() {
            if($(this).is(":selected")) 
            {
                description += "<p><strong>"+$(this).text()+"</strong> - "+$(this).data("desc")+"</p>";
            }
        });
        $("#permission-desc").html(description);
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

    $("input[type=text][name=email]").keyup(function() {
        $(this).removeClass("is-invalid");
        $(this).removeClass("is-valid");
        $("#emailError").text("");
        if (this.value != "")
        {
            var email = this.value;
            var suf = email.substr(-10);
            if (suf != "@yahoo.com" && suf != "@gmail.com")
            {
                $(this).addClass("is-invalid");
                $("#emailError").text("Invalid email address");
            }
            else
            {
                $(this).addClass("is-valid");
                $("#emailError").text("");
            }
        }
    });
    
});

