<?php 

    include('action/configuration.php');
    include('google_config.php');

    //Destroy entire session data.
    if(!isset($_SESSION)) {
        session_start();
    }
    
    unset($_SESSION['user_id']);

    session_destroy();

    $authUrl = $google_client->createAuthUrl();
     
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

    <style>

        .container-scroller {
            background-image: url("images/login-bg-5.jpg"); /* The image used */
            background-color: #cccccc; /* Used if the image is unavailable */
            height: auto; /* You must set a specified height */
            /*background-position: center; !* Center the image *!*/
            background-repeat: no-repeat; /* Do not repeat the image */
            background-size: cover; /* Resize the background image to cover the entire container */
        }

    </style>
  
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <h4>Let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form id="login_form" action="#" method="post">  
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <a id="btn_submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" onclick="submitForm();" href="#">SIGN IN <img src="images/loader.gif" id="loader" style="height: 25px; width: 25px;display:none;"></a>
                </div>
                <div class="my-2 d-flex justify-content-center align-items-center">
                  -- OR --
                </div>
                <div class="mb-2">
                  <a class="btn btn-block btn-google btn-lg font-weight-medium auth-form-btn" href="<?php echo $authUrl; ?>"><i class="fab fa-google mr-2"></i>Login with Google</a>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Register Here</a>
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

      function submitForm(){

        var modal = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            cssClass: ['custom-class-1', 'custom-class-2']
        });

        var email = $.trim($("#email").val());
        var password = $.trim($("#password").val());

        $("#email").parent().removeClass('has-danger');
        $("#password").parent().removeClass('has-danger');

        if(email == "") {
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
            url: "action/authenticate.php",
            type: 'POST',
            data: $('#login_form').serialize(),
            success: function(result) {

                $("#loader").hide();
                $("#btn_submit").removeAttr("disabled");

                var data = jQuery.parseJSON(result);

                if(data.isError === "false"){

                    window.open("index.php");

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
