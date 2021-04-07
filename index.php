<?php
include 'includes/session.php';
if (!isset($_SESSION['employee_id']) || $_SESSION['employee_id'] == "")
{
    header("Location: login.php");
}
else
{
    include_once $root."permission.php";
    $permi = new Permission();
    $employeePerms = $permi->getPermission($_SESSION['employee_id']);
    $tmp = [];
    foreach ($employeePerms as $per)
    {
        $tmp[] = $per['page'];
    }
    $_SESSION['permission'] = $tmp;
}

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Jaz Family Clinic and Diagnostic Center System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap4.mins.css">
        <link href="css/css.css" rel="stylesheet">
        <link href="css/btn.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0 border-right" href="#">
                <img src="/clinic1/img/nav_brand.png" width="120" height="30" class="d-inline-block align-top ml-5" alt="">
            </a>
            <p class="text-light font-weight-bold text-center my-auto" id ="timedate"></p>
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="/clinic1/includes/sign-out.php">Sign out</a>
                </li>
            </ul>
        </nav>
    </body>
    <div class="container-fluid">
        <?php
        
            include_once "misc/sidebar.php";
        ?>
        <div class="col-md-10 ml-sm-auto mt-3" style="padding-top: 48px;">
        <p class="pb-2"></p>
        <?php
            include_once "misc/geturl.php";
        ?>
        </div>
    </div>
    <script type="text/javascript" src="js/clock.js"></script>
</html>