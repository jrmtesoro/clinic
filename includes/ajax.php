<?php
include "reports.php";
$report = new Reports();
if (isset($_GET['tag']) && $_GET['tag'] != "")
{
    $tag = $_GET['tag'];
    switch ($tag)
    {
        case "getDate":
            $getdate = $report->getDate($_GET['table']);
            echo json_encode($getdate);
            break;

        case "get-table":
            $start = $_GET['start'];
            $end = $_GET['end'];
            $option = $_GET['option'];
            $option1 = $_GET['option1'];
            if ($option1 == "info")
            {
                $tableInfo = $report->getTableInfo($_GET['table'], $start, $end, $option);
                echo json_encode($tableInfo);
            }
            else if ($option1 == "total")
            {
                $tableInfo = $report->getTableInfo1($_GET['table'], $start, $end, $option);
                echo json_encode($tableInfo);
            }
            break;
    }
}

?>