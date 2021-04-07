<nav class="col-md-2 d-none d-md-block bg-light sidebar border-right">
    <div class="sidebar-sticky">
        <ul class="nav flex-column mt-3">
            <?php
                $permission = $_SESSION['permission'];
                include_once $root."patient.php";

                $patient = new Patient();
                $result = $patient->patientCount("INNER JOIN patient_result ON patient_result.patient_id = patient.id
                INNER JOIN result ON result.id = patient_result.result_id
                WHERE result.active = 1");
                $result_count = $result['count'];

                $badge = "";
                if ($result_count != 0)
                {
                    $badge = '<span class="badge badge-secondary ml-2">'.$result_count.'</span>';
                }
                
                if (isset($_GET['do']))
                {
                    $do = $_GET['do'];
                    $highlight = array(
                        "dashboard" => "",
                        "get-started" => "",
                        "patient-company" => "",
                        "edit-patient" => "",
                        "result" => "",
                        "sales" => "",
                        "edit-profile" => "",
                        "reports" => ""
                    );
                    
                    $highlight[$do] = "text-light font-weight-bold bg-info";
                }

                foreach ($highlight as $key => $value)
                {
                    if (in_array($key, $permission))
                    {
                        switch($key)
                        {
                            case "dashboard":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['dashboard'].'". href="index.php?do=dashboard">
                                    <img src="/clinic1/svg/si-glyph-house.svg" class="mb-2 mr-1" height="20" width="20">
                                    Dashboard
                                </a>
                                </li>';
                                break;

                            case "get-started":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['get-started'].'" href="index.php?do=get-started">
                                    <img src="/clinic1/svg/si-glyph-arrow-thick-right.svg" class="mb-1 mr-1" height="20" width="20">
                                    Get Started
                                </a>
                                </li>
                                ';
                                break;

                            case "patient-company":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['patient-company'].'" href="index.php?do=patient-company">
                                    <img src="/clinic1/svg/si-glyph-arrow-two-way-right.svg" class="mb-1 mr-1" height="20" width="20">
                                    Patient Batch
                                </a>
                                </li>
                                ';
                                break;

                            case "edit-patient":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['edit-patient'].'" href="index.php?do=edit-patient">
                                    <img src="/clinic1/svg/si-glyph-person-2.svg" class="mb-2 mr-1" height="20" width="20">
                                    Patient
                                </a>
                                </li>';
                                break;

                            case "result":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['result'].'" href="index.php?do=result">
                                    <img src="/clinic1/svg/si-glyph-test-tube-empty.svg" class="mb-2 mr-1" height="20" width="20">
                                    Result'.$badge.'
                                </a>
                                </li>';
                                break;   

                            case "sales":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['sales'].'" href="index.php?do=sales">
                                    <img src="/clinic1/svg/si-glyph-money-coin.svg" class="mb-2 mr-1" height="20" width="20">
                                    Sales
                                </a>
                                </li>';
                                break;

                            case "reports":
                                echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['reports'].'" href="index.php?do=reports">
                                    <img src="/clinic1/svg/si-glyph-file-box.svg" class="mb-2 mr-1" height="20" width="20">
                                    Reports
                                </a>
                                </li>';
                                break;
                        }
                    }
                }
            ?>
        </ul>
        <hr>
        <ul class="nav flex-column mt-3">
            <?php
                foreach ($permission as $page)
                {
                    switch($page)
                    {
                        case "edit-profile":
                            echo '<li class="nav-item">
                                <a class="nav-link '.$highlight['edit-profile'].'" href="index.php?do=edit-profile">
                                    <img src="/clinic1/svg/si-glyph-edit.svg" class="mb-2 mr-1" height="20" width="20">
                                    Edit Profile
                                </a>
                            </li>';
                            break;
                    
                        case "admin":
                            echo '<li class="nav-item">
                                <a class="nav-link" href="/clinic1/admin.php?do=employee">
                                    <img src="/clinic1/svg/si-glyph-adjustment-vertical.svg" class="mb-2 mr-1" height="20" width="20">
                                    Admin Tools
                                </a>
                            </li>';
                            break;
                    }
                }
            ?>
        </ul>
    </div>
</nav>