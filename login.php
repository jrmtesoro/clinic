<?php
include 'includes/session.php';

if (isset($_SESSION['employee_id']))
{
    Header("Location: index.php?do=".$_SESSION['permission']);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/clinic1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/clinic1/css/css.css" rel="stylesheet">
  </head>
  <body class="clinic-bg-img">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-10 col-centered">
                <div class="card login-style">
                    <div class="card-body">
                        <div class="card-title">
                            <center class="text-light login-style-font"><h3>Login</h3></center>
                        </div>
                        <form method="post">
                            <?php
                                if (isset($_POST['tag']) && $_POST['tag'] != "")
                                {
                                    $alert = new Alert();
                                    echo $alert->displayError($response['msg']);
                                }
                            ?>
                            <div class="input-group">
                                <input id="user" type="text" class="form-control" name="user" placeholder="Username" tabindex="1">
                            </div>
                            <p></p>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control" name="pass" placeholder="Password" tabindex="2">
                            </div>
                            <p></p>
                            <button class="btn btn-block btn-primary" type="submit" name="tag" value="login" tabindex="3">
                                <strong>Sign In</strong>
                            </button>
                            <hr class="hr-style">           
                            <center>
                                <small>
                                    <a href="forgot-password.php" class="text-light">Forgot Password?</a>
                                </small>
                            </center>               
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
  <script src="/clinic1/js/jquery.min.js"></script>
  <script src="/clinic1/js/bootstrap.min.js"></script>
</html>
