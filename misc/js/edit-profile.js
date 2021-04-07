$(document).ready(function(){
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

    $("#email").keyup(function(){
        var email = this.value;
        if (email != "")
        {
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            {
                $("#emailError").text("You must enter a valid email address.");
                $("#email").addClass("is-invalid");
            }
            else
            {
                $("#email").removeClass("is-invalid");
                $("#emailError").text("");
            }
        }
        else
        {
            $("#email").removeClass("is-invalid");
        }
    })

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

