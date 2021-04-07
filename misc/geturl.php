<?php
    if (isset($_SESSION['employee_id']) && $_SESSION['employee_id'] != "")
    {
        if (isset($_GET['do']))
        {
            $do = $_GET['do'];
            if (in_array($do, $_SESSION['permission']))
            {
                switch($do)
                {
                    case "dashboard":
                        include "dashboard.php";
                        break;

                    case "get-started":
                        include "get-started.php";
                        break;

                    case "edit-patient":
                        include "edit-patient.php";
                        break;

                    case "result":
                        include "result.php";
                        break;
                      
                    case "reports":
                        include "reports.php";
                        break;    
                    
                    case "sales":
                        include "sales.php";
                        break;
                    
                    case "edit-profile":
                        include "edit-profile.php";                
                        break;
                    
                    case "patient-company":
                        include "patient-company.php";                
                        break;
                }
            } 
            else
            {
                if ($do == "get-started-1" && in_array("get-started", $_SESSION['permission']))
                {
                    include "get-started-1.php";
                }
                else if ($do == "patient-company-1" && in_array("patient-company", $_SESSION['permission']))
                {
                    include "patient-company-1.php"; 
                }
                else
                {
                    Header("Location: index.php?do=".$_SESSION['permission'][0]);
                }
            }       
        }
        else
        {
            Header("Location: index.php?do=".$_SESSION['permission'][0]);
        }
    }
?>