$(document).ready(function(){
    $("#inputPasswordConfirm").keyup(function(){
        var password = $("#inputPassword").val();
        if (password != this.value)
        {
            $("#inputPasswordConfirm").removeClass("is-valid");
            $("#inputPasswordConfirm").addClass("is-invalid");
            $("#passwordValidation1").text("Password does not match.");
            $("#confirmNewPass").attr('disabled', true);
        }
        else
        {
            $("#inputPasswordConfirm").removeClass("is-invalid");
            $("#inputPasswordConfirm").addClass("is-valid");
            $("#passwordValidation1").text("");
            if ($("#passwordValidation").text() == "")
            {
                $("#confirmNewPass").removeAttr('disabled');
            }
        }
    });
    $("#inputPassword").keyup(function(){
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
                $("#inputPassword").removeClass("is-invalid");
                $("#inputPassword").addClass("is-valid");

            }
            else
            {
                $("#inputPassword").removeClass("is-valid");
                $("#inputPassword").addClass("is-invalid");
            }
            $("#passwordValidation").html("");
            for (i = 0; i < errorId.length; i++)
            {
                $("#passwordValidation").append(errorText[errorId[i]]+'<br>');
            }

            if (this.value != $("#inputPasswordConfirm").val() && $("#inputPasswordConfirm").val() != "")
            {
                $("#inputPasswordConfirm").removeClass("is-valid");
                $("#inputPasswordConfirm").addClass("is-invalid");
                $("#passwordValidation1").text("Password does not match.");
                $("#confirmNewPass").attr('disabled', true);
            }
            else if (this.value == $("#inputPasswordConfirm").val() && errorId.length == 0)
            {
                $("#inputPasswordConfirm").removeClass("is-invalid");
                $("#inputPasswordConfirm").addClass("is-valid");
                $("#passwordValidation1").text("");
                $("#confirmNewPass").removeAttr('disabled');
            }
        }
        else
        {
            $("#inputPassword").removeClass("is-invalid");
            $("#inputPassword").removeClass("is-valid");
            $("#inputPasswordConfirm").removeClass("is-valid");
            $("#inputPasswordConfirm").removeClass("is-invalid");
            $("#confirmNewPass").attr('disabled', true);
        }
    });
  });

