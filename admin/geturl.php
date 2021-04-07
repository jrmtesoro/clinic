<?php

if (isset($_GET['do']) && $_GET['do'] != "")
{
    $do = $_GET['do'];

    switch($do)
    {
        case "employee":
            include "employee.php";
            break;

        case "misc":
            include "misc.php";
            break;

        case "logs":
            include "logs.php";
            break;

        case "request":
            include "request.php";
            break;    
    }
}
else
{
    Header("Location: admin.php?do=employee");
}

?>