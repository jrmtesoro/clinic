<?php
session_start();
ob_start();
$root = $_SERVER['DOCUMENT_ROOT']."/clinic1/includes/";
include "post.php";
include "alert.php";
?>