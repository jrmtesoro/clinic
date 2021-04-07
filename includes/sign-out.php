<?php
    session_start();
    include "logs.php";
    $logs = new Logs();

    $addLogs = $logs->addLogs($_SESSION['employee_id'], 'employee');
    $log = $logs->getLatestLogId();
    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
    $addLogAction = $logs->addLogsAction($log['id'], "Signed Out");

    $_SESSION['employee_id'] = null;
    $_SESSION['permission'] = null;
    session_destroy();

    Header("Location: /clinic1/login.php");
?>