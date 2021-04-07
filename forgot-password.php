<?php
include 'includes/session.php';
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
                            <center class="text-light login-style-font"><h3>Forgot Password</h3></center>
                        </div>
                        <form method="post">
                        <?php           
                            $forgot = '<div class="input-group">
                            <input type="text" class="form-control" name="user" placeholder="Username" tabindex="1">
                            </div>
                            <p></p>
                            <button class="btn btn-block btn-primary" type="submit" name="tag" value="forgot" tabindex="2">
                                <strong>Confirm</strong>
                            </button>';                 
                            if (isset($response['tag']))
                            {
                                $alert = new Alert();
                                $tag = $response['tag'];

                                if ($tag == "forgot")
                                {
                                    if ($response['success'] == 1)
                                    {
                                        echo '<p><strong><center class="text-light">'.$response['msg'].'</center></strong></p>';
                                        echo 
                                        '<div class="input-group">
                                            <input name="question" value="'.$response['msg'].'" type="hidden">
                                            <input name="id" value="'.$response['id'].'" type="hidden">
                                            <input id="secret-answer" type="text" class="form-control" name="secret_answer" placeholder="Secret Answer" tabindex="1">
                                        </div>
                                        <p></p>
                                        <button class="btn btn-block btn-primary" type="submit" name="tag" value="secret-answer" tabindex="2">
                                            <strong>Confirm</strong>
                                        </button>';
                                    }
                                    else
                                    {
                                        echo $alert->displayError($response['msg']);
                                        echo $forgot;
                                    }
                                }
                                else if ($tag == "secret-answer")
                                {   
                                    if ($response['success'] == 1)
                                    {
                                        echo '<p><strong><center class="text-light">New Password</center></strong></p>
                                        <input name="id" value="'.$_POST['id'].'" type="hidden">
                                        <div class="form-group" id="newPass">
                                            <input type="password" class="form-control" id="inputPassword" name="pass" placeholder="Password" tabindex="1" required>
                                            <div class="invalid-feedback" id="passwordValidation"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="inputPasswordConfirm" name="pass1" placeholder="Re-type password"tabindex="2"  required>
                                            <div class="invalid-feedback" id="passwordValidation1"></div>
                                        </div>
                                        <p></p>
                                        <button class="btn btn-block btn-primary" id="confirmNewPass" type="submit" name="tag" value="update-password" tabindex="3" disabled>
                                            <strong>Confirm</strong>
                                        </button>';
                                    }
                                    else if ($response['error'] == 1)
                                    {
                                        echo $alert->displayError($response['msg']);
                                        echo '<p><strong><center class="text-light">'.$_POST['question'].'</center></strong></p>';
                                        echo 
                                        '<div class="input-group">
                                            <input name="question" value="'.$_POST['question'].'" type="hidden">
                                            <input name="id" value="'.$_POST['id'].'" type="hidden">
                                            <input id="secret-answer" type="password" class="form-control" name="secret_answer" placeholder="Secret Answer" tabindex="1">
                                        </div>
                                        <p></p>
                                        <button class="btn btn-block btn-primary" type="submit" name="tag" value="secret-answer" tabindex="2">
                                            <strong>Confirm</strong>
                                        </button>';
                                    }
                                }
                                else if ($tag == "update-password")
                                {
                                    if ($response['success'] == 0)
                                    {
                                        echo $alert->displayError($response['msg']);
                                        echo '<p><strong><center class="text-light">New Password</center></strong></p>
                                        <input name="id" value="'.$_POST['id'].'" type="hidden">
                                        <div class="form-group" id="newPass">
                                            <input type="password" class="form-control" id="inputPassword" name="pass" placeholder="Password" tabindex="1" required>
                                            <div class="invalid-feedback" id="passwordValidation"></div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="inputPasswordConfirm" name="pass1" placeholder="Re-type password" tabindex="2"  required>
                                            <div class="invalid-feedback" id="passwordValidation1"></div>
                                        </div>
                                        <p></p>
                                        <button class="btn btn-block btn-primary" id="confirmNewPass" type="submit" name="tag" value="update-password" tabindex="3" disabled>
                                            <strong>Confirm</strong>
                                        </button>';
                                    }
                                    else
                                    {
                                        echo '<div class="alert alert-success text-center" role="alert">'.$response['msg'].'<p>Redirecting to <a href="login.php" class="alert-link">login</a>...</p></div>';
                                        Header("refresh:3;url=login.php");
                                    }
                                }
                            }
                            else
                            {
                                echo $forgot;
                            }
                        ?>     
                        <hr class="hr-style">           
                            <center>
                                <small>
                                    <a href="login.php" class="text-light">Sign In</a>
                                </small>
                            </center> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/validation/forgot.js"></script>
</html>
