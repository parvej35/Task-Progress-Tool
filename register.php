<?php

    if(!isset($_SESSION)) {
        session_start();
    }
    unset($_SESSION['user_id']);
    session_destroy();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Task Progress Tool</title>

  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/tingle.css">

  <link rel="shortcut icon" href="images/favicon.png" />

</head>

<body>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps.</h6>
              <form id="signup_form" action="#" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="First name" required="true">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Last name" required="true">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required="true">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required="true">
                </div>
                <div class="mt-3">
                  <a id="btn_submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" onclick="submitSignupForm();" href="#">SIGN UP <img src="images/loader.gif" id="loader" style="height: 25px; width: 25px;display:none;"></a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jQuery.3.2.1.js"></script>
  <script src="js/tingle.js"></script>

  <script type="text/javascript">

      function submitSignupForm(){

        var modal = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ['custom-class-1', 'custom-class-2']
        });

        var first_name = $.trim($("#first_name").val());
        var last_name = $.trim($("#last_name").val());
        var email = $.trim($("#email").val());
        var password = $.trim($("#password").val());

        $("#first_name").parent().removeClass('has-danger');
        $("#last_name").parent().removeClass('has-danger');
        $("#email").parent().removeClass('has-danger');
        $("#password").parent().removeClass('has-danger');

        if(first_name == "") {
            $("#first_name").parent().addClass('has-danger');
            return false;
        } else if(last_name == "") {
            $("#last_name").parent().addClass('has-danger');
            return false;
        } else if(email == "") {
            $("#email").parent().addClass('has-danger');
            return false;
        } else if(!validateEmail(email)) {
            $("#email").parent().addClass('has-danger');
            return false;
        } else if(password == "") {
            $("#password").parent().addClass('has-danger');
            return false;
        }

        $("#loader").show();
        $("#btn_submit").attr("disabled", true);

        $.ajax({
            url: "action/registration.php",
            type: 'POST',
            data: $('#signup_form').serialize(),
            success: function(result) {

                $("#loader").hide();
                $("#btn_submit").removeAttr("disabled");

                var data = jQuery.parseJSON(result);

                if(data.isError === "false"){

                    $("#first_name").val('');
                    $("#last_name").val('');
                    $("#email").val('');
                    $("#password").val('');

                    modal.setContent("<div style='text-align:center;'><h3 style='color:green;'>"+data.message+"</h3><h4>Check your registered email for verification.</h4></div>");
                    modal.addFooterBtn('Close', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
                        modal.close();
                    });

                    modal.open();

                } else if(data.isError === "true"){

                    modal.setContent("<h4 style='color:red;'>"+data.message+"</h4>");
                    modal.addFooterBtn('Close', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
                        modal.close();
                    });

                    modal.open();

                }
            },
            error: function (request, status, error) {
                $("#loader").hide();
                $("#btn_submit").removeAttr("disabled");

                modal.setContent("<h4 style='color:red;'>"+request.responseText+"</h4>");
                modal.addFooterBtn('Close', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
                    modal.close();
                });

                modal.open();
            }
        });
    }

    function validateEmail(email){
        var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(email);
    }

  </script>


</body>


</html>
