<?php
$response = array(
    "success" => 0,
    "error" => 0
);

if (isset($_GET['tag']) && $_GET['tag'] != "")
{
    $tag = $_GET['tag'];
    switch($tag)
    {
        case "print-result-company":
            include_once "services.php";
            include_once "misc.php";
            include_once "patient.php";

            $services = new Services();
            $misc = new Misc();
            $patient = new Patient();
            session_start();
            $company_id = $_POST['company_id'];
            $company_result_id = $_POST['company_result_id'];
            $companyPatients = $patient->getPatientCompanyResult($company_result_id, $company_id);
            foreach ($companyPatients as $patient)
            {
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($patient['lab_code'], 'lab_code');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
                $addLogAction = $logs->addLogsAction($log['id'], "Printed Result");

                $process = $services->getPatientServices($patient['lab_code']);
                $tables = [];
                foreach($process as $service)
                {
                    $tables[] = $service['code'];
                }
                $result_ids = array();
                foreach ($tables as $table)
                {
                    $getTableId = $misc->getTableId($table, $patient['result_id']);
                    $result_ids[$table] = $getTableId['id'];
                }
                include_once "test.php";
                printResult($result_ids, $patient['id'], $patient['result_id']);
            }
            
            break;
        case "print-result":
            
            include_once "services.php";
            include_once "misc.php";
            $misc = new Misc();
            $services = new Services();
            $lab_code = $_POST['lab_code'];
            $patient_id = $_POST['patient_id'];
            $result_id = $_POST['result_id'];
            $process = $services->getPatientServices($lab_code);
            $tables = [];
            foreach($process as $service)
            {
                $tables[] = $service['code'];
            }
            $result_ids = array();
            foreach ($tables as $table)
            {
                $getTableId = $misc->getTableId($table, $result_id);
                $result_ids[$table] = $getTableId['id'];
            }
            session_start();
            include "logs.php";
            $logs = new Logs();
            $addLogs = $logs->addLogs($lab_code, 'lab_code');
            $log = $logs->getLatestLogId();
            $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
            $addLogAction = $logs->addLogsAction($log['id'], "Printed Result");

            include "test.php";
            echo printResult($result_ids, $patient_id, $result_id);
            break;
        case "get-tables":
            include "services.php";
            $services = new Services();

            $lab_code = $_POST['lab_code'];

            $process = $services->getPatientServices($lab_code);

            echo json_encode($process);
            break;
        case "get-result-id":
            include "misc.php";
            include "exam.php";
            $exam = new Exam();
            $misc = new Misc();


            $table = $_POST['table'];
            $result_id = $_POST['result_id'];

            $process = $misc->getTableId($table, $result_id);
    
            if ($table == "xray")
            {
                $proc = $exam->getExam($process['xray_id']);
                $process['examination'] = $proc['exam_id'];
            }
            echo json_encode($process);
            break;

        case "update-result":
            if (isset($_POST['patient_id']) && $_POST['patient_id'] != "")
            {
                include "validation.php";
                $validation = new Validation();
                $response['msg'] = "";
                $response['id'] = [];
                $response['data'] = [];
                if (isset($_POST['urinalysis_id']) && $_POST['urinalysis_id'] != "")
                {
                    $urinalysis = array(
                        "color" => $_POST['color'],
                        "rbc" => $_POST['rbc'],
                        "wbc" => $_POST['wbc'],
                        "transparency" => $_POST['transparency'],
                        "a_u" => $_POST['a_u'],
                        "e_c" => $_POST['e_c'],
                        "ph_reaction" => $_POST['ph_reaction'],
                        "specific_gravity" => $_POST['specific_gravity'],
                        "bacteria" => $_POST['bacteria'],
                        "glucose" => $_POST['glucose'],
                        "mucus_threads" => $_POST['mucus_threads'],
                        "protein" => $_POST['protein'],
                        "others" => $_POST['others']
                    );

                    $invalidInput = $validation->urinalysisValidation(
                        $_POST['color'], $_POST['transparency'], $_POST['ph_reaction'],
                        $_POST['specific_gravity'], $_POST['glucose'],
                        $_POST['protein'], $_POST['rbc'], $_POST['wbc'],
                        $_POST['e_c'], $_POST['a_u'], $_POST['bacteria'],
                        $_POST['mucus_threads']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Urinalysis :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError."</br></br>";
                    }
                    $response['id']['urinalysis'] = $_POST['urinalysis_id'];

                    $response['data']["urinalysis"] = $urinalysis;

                }
                if (isset($_POST['hematology_id']) && $_POST['hematology_id'] != "")
                {
                    $hematology = array(
                        "hemoglobin" => $_POST['hemoglobin'],
                        "hematocrit" => $_POST['hematocrit'],
                        "wbc_count" => $_POST['wbc_count'],
                        "platelet_count" => $_POST['platelet_count'],
                        "neutrophils" => $_POST['neutrophils'],
                        "lymphocytes" => $_POST['lymphocytes'],
                        "monocytes" => $_POST['monocytes'],
                        "eosinophils" => $_POST['eosinophils'],
                        "basophils" => $_POST['basophils'],
                        "stab_cells" => $_POST['stab_cells'],
                        "blood_type" => $_POST['blood_type']
                    );

                    $invalidInput = $validation->hematologyValidation(
                        $_POST['hemoglobin'], $_POST['hematocrit'], $_POST['wbc_count'],
                        $_POST['platelet_count'], $_POST['neutrophils'], $_POST['lymphocytes'],
                        $_POST['monocytes'], $_POST['eosinophils'], $_POST['basophils'],
                        $_POST['stab_cells'], $_POST['blood_type']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Hematology :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError."</br></br>";
                    }

                    $response['id']['hematology'] = $_POST['hematology_id'];

                    $response['data']['hematology'] = $hematology;
                    
                }
                if (isset($_POST['fecalysis_id']) && $_POST['fecalysis_id'] != "")
                {
                    $fecalysis = array(
                        "color" => $_POST['color1'],
                        "consistency" => $_POST['consistency'],
                        "rbc" => $_POST['rbc1'],
                        "pus_cells" => $_POST['pus_cells'],
                        "bacteria" => $_POST['bacteria1'],
                        "fat_globules" => $_POST['fat_globules'],
                        "yeast_cells" => $_POST['yeast_cells'],
                        "parasites" => $_POST['parasites']
                    );

                    $invalidInput = $validation->fecalysisValidation(
                        $_POST['color1'], $_POST['consistency'], $_POST['rbc1'],
                        $_POST['pus_cells'], $_POST['bacteria1'], $_POST['fat_globules'],
                        $_POST['yeast_cells'], $_POST['parasites']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Fecalysis :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError;
                    }

                    $response['id']['fecalysis'] = $_POST['fecalysis_id'];
                    $response['data']['fecalysis'] = $fecalysis;
                }
                if (isset($_POST['xray_id']) && $_POST['xray_id'] != "")
                {
                    $xray = array(
                        "impression" => $_POST['impression'],
                        "observation" => $_POST['observation']
                    );

                    $invalidInput = [];
                    include "exam.php";
                    $exam = new Exam();
                    
                    $exams = $exam->getExams("");
                    $found = false;
                    foreach ($exams as $ex)
                    {
                        if ($ex['id'] == $_POST['examination'])
                        {
                            $found = true;
                        }
                    }
                    if (!$found)
                    {
                        $invalidInput[] = "Examination";
                    }

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On X-Ray :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError;
                    }

                    $response['id']['xray'] = $_POST['xray_id'];
                    $response['data']['xray'] = $xray;
                }
                if ($response['error'] == 0)
                {
                    session_start();
                    include "result.php";
                    include_once "employee.php";
                    $employee = new Employee();
                    $result = new Result();
                    foreach ($response['id'] as $table => $id)
                    {
                        $process = $result->updatePatientResult($response['data'][$table], $table, $id);
                        if ($table == "xray")
                        {
                            $addEmployeeResult = $employee->addEmployeeResult($_POST['radtech'], $_POST['lab_code']);
                            $deleteXrayExam = $exam->deleteXrayExam($id);
                            $addXrayExam = $exam->addXrayExam($id, $_POST['examination']);
                        }
                        else
                        {
                            $addEmployeeResult = $employee->addEmployeeResult($_POST['medtech'], $_POST['lab_code']);
                            $addEmployeeResult1 = $employee->addEmployeeResult($_POST['physician'], $_POST['lab_code']);

                        }
                    }
                    if ($_POST['resultOption'] == "newResult")
                    {
                        include "patient.php";
                        $patient = new Patient();
                        $queue = array(
                            "queue" => "0"
                        );
                        $updateQueue = $patient->updatePatient($queue, $_POST['patient_id']);
                        $inactiveResult = $result->inactiveResult($_POST['lab_code']);
                        $proc = $patient->getPatientCompany($_POST['patient_id']);
                        $companyResult = $result->countActiveCompanyResult1($proc['id']);
                        if ($companyResult['count'] == 0)
                        {
                            include "company.php";

                            $company = new Company();

                            $p = $company->updateCompanyQueue($proc['id'], 0);
                            $comInfo = $result->getCompRes($proc['id']);
                            $c_r_id = $comInfo['c_r'];
                            $p1 = $company->updateCompanyRes($c_r_id, 0);
                        }
                    }

                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($_POST['lab_code'], 'lab_code');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
                    $addLogAction = $logs->addLogsAction($log['id'], "Updated Result");

                    $response['success'] = 1;
                    $_SESSION['msg'] = "Successfully Updated Result!";
                }
                echo json_encode($response);
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a patient!";
                echo json_encode($response);
            }
            break;
        case "request-update":
            if (isset($_POST['patient_id']) && $_POST['patient_id'] != "")
            {
                include "validation.php";
                $validation = new Validation();
                $response['msg'] = "";
                $response['id'] = [];
                $response['data'] = [];
                if (isset($_POST['urinalysis_id']) && $_POST['urinalysis_id'] != "")
                {
                    $urinalysis = array(
                        "color" => $_POST['color'],
                        "rbc" => $_POST['rbc'],
                        "wbc" => $_POST['wbc'],
                        "transparency" => $_POST['transparency'],
                        "a_u" => $_POST['a_u'],
                        "e_c" => $_POST['e_c'],
                        "ph_reaction" => $_POST['ph_reaction'],
                        "specific_gravity" => $_POST['specific_gravity'],
                        "bacteria" => $_POST['bacteria'],
                        "glucose" => $_POST['glucose'],
                        "mucus_threads" => $_POST['mucus_threads'],
                        "protein" => $_POST['protein'],
                        "others" => $_POST['others']
                    );

                    $invalidInput = $validation->urinalysisValidation(
                        $_POST['color'], $_POST['transparency'], $_POST['ph_reaction'],
                        $_POST['specific_gravity'], $_POST['glucose'],
                        $_POST['protein'], $_POST['rbc'], $_POST['wbc'],
                        $_POST['e_c'], $_POST['a_u'], $_POST['bacteria'],
                        $_POST['mucus_threads']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Urinalysis :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError."</br></br>";
                    }
                    $response['id']['urinalysis'] = $_POST['urinalysis_id'];

                    $response['data']["urinalysis"] = $urinalysis;

                }
                if (isset($_POST['hematology_id']) && $_POST['hematology_id'] != "")
                {
                    $hematology = array(
                        "hemoglobin" => $_POST['hemoglobin'],
                        "hematocrit" => $_POST['hematocrit'],
                        "wbc_count" => $_POST['wbc_count'],
                        "platelet_count" => $_POST['platelet_count'],
                        "neutrophils" => $_POST['neutrophils'],
                        "lymphocytes" => $_POST['lymphocytes'],
                        "monocytes" => $_POST['monocytes'],
                        "eosinophils" => $_POST['eosinophils'],
                        "basophils" => $_POST['basophils'],
                        "stab_cells" => $_POST['stab_cells'],
                        "blood_type" => $_POST['blood_type']
                    );

                    $invalidInput = $validation->hematologyValidation(
                        $_POST['hemoglobin'], $_POST['hematocrit'], $_POST['wbc_count'],
                        $_POST['platelet_count'], $_POST['neutrophils'], $_POST['lymphocytes'],
                        $_POST['monocytes'], $_POST['eosinophils'], $_POST['basophils'],
                        $_POST['stab_cells'], $_POST['blood_type']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Hematology :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError."</br></br>";
                    }

                    $response['id']['hematology'] = $_POST['hematology_id'];

                    $response['data']['hematology'] = $hematology;
                    
                }
                if (isset($_POST['fecalysis_id']) && $_POST['fecalysis_id'] != "")
                {
                    $fecalysis = array(
                        "color" => $_POST['color1'],
                        "consistency" => $_POST['consistency'],
                        "rbc" => $_POST['rbc1'],
                        "pus_cells" => $_POST['pus_cells'],
                        "bacteria" => $_POST['bacteria1'],
                        "fat_globules" => $_POST['fat_globules'],
                        "yeast_cells" => $_POST['yeast_cells'],
                        "parasites" => $_POST['parasites']
                    );

                    $invalidInput = $validation->fecalysisValidation(
                        $_POST['color1'], $_POST['consistency'], $_POST['rbc1'],
                        $_POST['pus_cells'], $_POST['bacteria1'], $_POST['fat_globules'],
                        $_POST['yeast_cells'], $_POST['parasites']
                    );

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On Fecalysis :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError;
                    }

                    $response['id']['fecalysis'] = $_POST['fecalysis_id'];
                    $response['data']['fecalysis'] = $fecalysis;
                }
                if (isset($_POST['xray_id']) && $_POST['xray_id'] != "")
                {
                    $xray = array(
                        "impression" => $_POST['impression'],
                        "observation" => $_POST['observation']
                    );

                    $invalidInput = [];
                    include "exam.php";
                    $exam = new Exam();
                    
                    $exams = $exam->getExams("");
                    $found = false;
                    foreach ($exams as $ex)
                    {
                        if ($ex['id'] == $_POST['examination'])
                        {
                            $found = true;
                        }
                    }
                    if (!$found)
                    {
                        $invalidInput[] = "Examination";
                    }

                    if (count($invalidInput) != 0)
                    {
                        $response['error'] = 1;
                        $textError = "Invalid Input On X-Ray :</b>";

                        if (count($invalidInput) != 0)
                        {
                            foreach ($invalidInput as $error)
                            {
                                $temp = "</br>->".$error;
                                $textError .= $temp;
                            }
                        }
                        $response['msg'] .= $textError;
                    }

                    $response['id']['xray'] = $_POST['xray_id'];
                    $response['data']['xray'] = $xray;
                }
                if ($response['error'] == 0)
                {
                    session_start();
                    include "misc.php";
                    include "request.php";
                    $request = new Request();
                    $misc = new Misc();
                    $lab_code = $_POST['lab_code'];
                    $employee_id = $_SESSION['employee_id'];
                    $addRequest = $request->addRequest($_POST['lab_code'], $_POST['reason']);
                    $req = $request->getLatestId();
                    $request_id = $req['id'];
                    $addEmployeeRequest = $request->addEmployeeRequest($employee_id, $request_id);
                    foreach($response['id'] as $table=>$id)
                    {
                        $specificResult = $misc->getSpecificResult($table, $id);
                        foreach($response['data'][$table] as $col=>$value)
                        {
                            if ($value != $specificResult[$col])
                            {
                                $addRequestInput = $request->addRequestInput($request_id, $table, $col, $id, $specificResult[$col], $value);
                            }
                        }
                    }
                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($_POST['lab_code'], 'lab_code');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
                    $addLogAction = $logs->addLogsAction($log['id'], "Request Update");

                    $response['success'] = 1;
                    $_SESSION['msg'] = "Successfully Sent Request!";
                }
                echo json_encode($response);
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a patient!";
                echo json_encode($response);
            }
            break;
        case "get-account":
            include "employee.php";
            include "question.php";
            
            $question = new Question();
            $employee = new Employee();

            $employee_id = $_POST['id'];

            $q = $question->getEmployeeQuestion($employee_id);
            $employeeInfo = $employee->getEmployee($employee_id);

            $accountDetails = array(
                "user" => $employeeInfo['user'],
                "question" => $q['id']  
            );
            echo json_encode($accountDetails);
            break;
        case "get-permission":
            include "permission.php";
            $permission = new Permission();

            $permissionList = $permission->getPermission($_POST['id']);

            echo json_encode($permissionList);
            break;
        case "delete-company":
            include "company.php";
            $company = new Company();

            $process = $company->inactiveCompany($_POST['id']);
            $process = $company->deletePatientCompany($_POST['id']);
            include "logs.php";
            $logs = new Logs();
            $addLogs = $logs->addLogs($_POST['id'], 'company');
            $log = $logs->getLatestLogId();
            $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
            $addLogAction = $logs->addLogsAction($log['id'], "Removed Company");
            if ($process)
            {
                echo "success";
            }
            else
            {
                echo "fail";
            }
            break;
        case "company-patient":
            include "company.php";
            $company = new Company();
            $patients = $company->getCompanyPatients($_GET['id']);
            echo json_encode($patients);
            break;
        case "add-company-patient":
            include "company.php";
            include "patient.php";
            include "validation.php";
            session_start();
            $validation = new Validation();
            $patient = new Patient();
            $company = new Company();

            $insert = array(
                "first" => $_POST['first'],
                "mid" => $_POST['mid'],
                "last" => $_POST['last'],
                "address" => $_POST['address'],
                "gender" => $_POST['gender'],
                "age" => $_POST['age'],
                "contact_number" => $_POST['contact_number'],
                "img_name" => $_FILES["img"]["name"]
            );

            $imgError = [];
            if ($insert["img_name"] != null)
            {
                $target_dir = $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/";
                $target_file = $target_dir . basename($insert["img_name"]);
                $imgError = $validation->imageValidation($insert["img_name"], $_FILES['img']['tmp_name']);
                if (count($imgError) == 0)
                {
                    if (!move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) 
                    {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }

            $invalidInput = $validation->patientInformation($insert['first'], $insert['mid'], $insert['last'], $insert['contact_number'], $insert['age'], $insert['gender']);
            if (count($imgError) == 0 && count($invalidInput) == 0)
            {
                $process = $patient->addPatient($insert);
                if ($process)
                {
                    $patientInfo = $patient->getLatestPatient();
                    $process1 = $company->addPatientCompany($patientInfo['id'], $_GET['company_id']);
                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($patientInfo['id'], 'patient');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    $addLogAction = $logs->addLogsAction($log['id'], "Added Patient to Company ".$_GET['company_id']);
                    echo "success";
                }
                else
                {
                    echo "fail";
                }
            }
            else
            {
                $textError = "Invalid Input on :</b>";

                if (count($invalidInput) != 0)
                {
                    foreach ($invalidInput as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                if (count($imgError) != 0)
                {
                    foreach ($imgError as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                echo $textError;
            }
            break;
        case "get-patients":
            include "patient.php";
            $patient = new Patient();

            $patients = $patient->getPatients("LEFT JOIN patient_company ON patient_company.patient_id = patient.id
            WHERE patient_company.patient_id IS NULL AND patient.queue = 0");

            echo json_encode($patients);
            break;
        case "add-existing-to-company":
            include "company.php";
            $company = new Company();
            session_start();
            $ids = $_POST['id'];
            $company_id = $_POST['company_id'];
            foreach ($ids as $id)
            {
                $addPatient = $company->addPatientCompany($id, $company_id);
                if (!$addPatient)
                {
                    echo "error";
                }
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($id, 'patient');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Added Patient to Company ".$_POST['company_id']);
            }
            echo "success";
            break;
        case "get-latest-company-patient":
            include "patient.php";
            $patient = new Patient();

            $latestPatient = $patient->getLatestPatient();
            $patientInfo = $patient->getPatient($latestPatient['id']);
            
            echo json_encode($patientInfo);
            break;
        case "delete-company-patient":
            include "company.php";
            $company = new Company();
            session_start();
            $process = $company->deleteCompanyPatient1($_POST['id']);
            if ($process)
            {
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($_POST['id'], 'patient');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Removed Patient from Company");
                echo "success";
            }
            else
            {
                echo "failed";
            }
            break;
        case "company-sales":
            include "company.php";
            include "services.php";

            $services = new Services();
            $company = new Company();

            $company_id = $_POST['company_id'];
            $company_result_id = $_POST['company_result_id'];
            $company_result = $company->getCompanyResult($company_result_id);
            $result_id = $company_result[0]['result_id'];
            $patient_services = $services->getPatientServices1($result_id);

            echo json_encode($patient_services);
            break;
        case "company-sales-patient":
            include "patient.php";
            $patient = new Patient();

            $patientList = $patient->getPatientCompanyResult($_GET['company_result_id'], $_GET['company_id']);

            echo json_encode($patientList);
            break;
        case "getLog":
            include "logs.php";
            $logs = new Logs();
            $logInfo = $logs->getLog();

            echo json_encode($logInfo);
            break;
        case "get-employee-name":
            include "employee.php";
            $employee = new Employee();

            $employeeInfo = $employee->getEmployee($_POST['employee_id']);
            $name = $employeeInfo['first']." ".$employeeInfo['last'];

            echo $name;
            break;
        case "get-log-action":
            include "logs.php";
            $logs = new Logs();

            $logInfo = $logs->getLogsAction($_POST['log_id']);
            $temp = "";
            $title = false;
            foreach($logInfo as $info)
            {
                if ($info['action'] == "Updated Personal Information")
                {
                    if (!$title)
                    {
                        $temp .= "<div>".$info['action']."</div>";
                        $title = true;
                    }
                    $temp .= "<div><strong class='font-weight-bold'>".$info['col'].": </strong> from <i>".$info['old']."</i> to <i>".$info['new']."</i></div>";
                }
                else if ($info['action'] == "Updated Profile")
                {
                    if (!$title)
                    {
                        $temp .= "<div>".$info['action']."</div>";
                        $title = true;
                    }
                    $temp .= "<div><strong class='font-weight-bold'>".$info['col'].": </strong> from <i>".$info['old']."</i> to <i>".$info['new']."</i></div>";
                }
                else if ($info['action'] == "Updated company")
                {
                    if (!$title)
                    {
                        $temp .= "<div>".$info['action']."</div>";
                        $title = true;
                    }
                    $temp .= "<div><strong class='font-weight-bold'>".$info['col'].": </strong> from <i>".$info['old']."</i> to <i>".$info['new']."</i></div>";
                }
                else
                {
                    $temp = $info['action'];
                }
            }
            echo $temp;
            break;
        case "get-case":
            include "result.php";
            $result = new Result();

            $resultInfo = $result->getResult($_POST['id']);

            echo $resultInfo['lab_code'];
            break;
        case "get-employee-request":
            include "request.php";
            $request = new Request();

            $employeeInfo = $request->getEmployeeRequest($_POST['request_id']);

            echo $employeeInfo['first']." ".$employeeInfo['last'];
            break;
        case "get-request-input":
            include "request.php";
            include "misc.php";
            $misc = new Misc();
            $request = new Request();

            $requestInfo = $request->getRequestInput($_POST['request_id']);
            $textXray = "";
            $textUri = "";
            $textFec = "";
            $textHem = "";
            foreach ($requestInfo as $req)
            {
                if ($req['old'] == "")
                {
                    $req['old'] = "[none]";
                }
                if ($req['table_name'] == "fecalysis")
                {
                    if ($textFec == "")
                    {
                        $textFec .= "<div><strong>Fecalysis</strong></div>";
                    }
                    $textFec .= "<div><strong>".$req['col'].":</strong> from <u>".$req['old']."</u> to <u>".$req['new']."</u></div>";
                }
                else if ($req['table_name'] == "hematology")
                {
                    if ($textHem == "")
                    {
                        $textHem .= "<div><strong>Hematology</strong></div>";
                    }
                    $textHem .= "<div><strong>".$req['col'].":</strong> from <u>".$req['old']."</u> to <u>".$req['new']."</u></div>";
                }
                else if ($req['table_name'] == "urinalysis")
                {
                    if ($textUri == "")
                    {
                        $textUri .= "<div><strong>Urinalysis</strong></div>";
                    }
                    $textUri .= "<div><strong>".$req['col'].":</strong> from <u>".$req['old']."</u> to <u>".$req['new']."</u></div>";
                }
                else if ($req['table_name'] == "xray")
                {
                    if ($textXray == "")
                    {
                        $textXray .= "<div><strong>Xray</strong></div>";
                    }
                    $textXray .= "<div><strong>".$req['col'].":</strong> from <u>".$req['old']."</u> to <u>".$req['new']."</u></div>";
                }
                
            }
            $text = $textFec.$textHem.$textUri.$textXray;
            echo $text;
            break;
    }
}
else if (isset($_POST['tag']) && $_POST['tag'] != "")
{
    $tag = $_POST['tag'];
    $response['tag'] = $tag;
    switch($tag)
    {
        case "login":
            include "login.php";
            $login = new Login();
            include "logs.php";
            $logs = new Logs();


            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $process = $login->loginUser($user, $pass);

            if ($process)
            {
                include "permission.php";
                $permission = new Permission();

                $perms = $permission->getPermission($process['id']);
                $temp = [];

                foreach ($perms as $perm)
                {
                    $temp[] = $perm['page'];
                }
                $response['success'] = 1;
                $response['msg'] = "Logged In";
                $_SESSION['employee_id'] = $process['id'];
                $_SESSION['permission'] = $temp;

                $addLogs = $logs->addLogs($_SESSION['employee_id'], 'employee');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Logged In");
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Invalid Username/Password!";
                $addLogs = $logs->addLoginLogs();
                $log = $logs->getLatestLogId();
                $addLogAction = $logs->addLogsAction($log['id'], "Login attempt on username '$user' and password '$pass'");
            }
            break;

        case "forgot":
            include "login.php";
            $login = new Login();
            include "logs.php";
            $logs = new Logs();

            $user = $_POST['user'];

            $process = $login->getUserQuestion($user);

            if ($process)
            {
                $response['success'] = 1;
                $response['msg'] = $process['question'];
                $response['id'] = $process['id'];
                $addLogs = $logs->addLoginLogs();
                $log = $logs->getLatestLogId();
                $addLogAction = $logs->addLogsAction($log['id'], "Forgot password attempt on username '$user'");
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Invalid Username";
                $addLogs = $logs->addLoginLogs();
                $log = $logs->getLatestLogId();
                $addLogAction = $logs->addLogsAction($log['id'], "Forgot password attempt on username '$user'");
            }
            break;

        case "secret-answer":
            include "login.php";
            $login = new Login();
            include "logs.php";
            $logs = new Logs();
            $id = $_POST['id'];
            $secret_answer = $_POST['secret_answer'];

            $process = $login->getUserAnswer($id, $secret_answer);

            if ($process)
            {
                $response['success'] = 1;
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Invalid Secret Answer!";
                $addLogs = $logs->addLoginLogs();
                $log = $logs->getLatestLogId();
                $addLogAction = $logs->addLogsAction($log['id'], "Invalid secret answer '$secret_answer'");
            }
            break;

        case "update-password":
            include "validation.php";
            $validation = new Validation();
            include "logs.php";
            $logs = new Logs();

            $id = $_POST['id'];
            $pass = $_POST['pass'];
            $pass1 = $_POST['pass1'];

            $errors = $validation->passwordValidation($pass, $pass1);
            if (count($errors) == 0)
            {
                include "employee.php";
                $employee = new Employee();

                $updates = array (
                    "pass" => $pass
                );

                $process = $employee->updateEmployee($updates, $id);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully Changed Password!";
                    $addLogs = $logs->addLogs($id, 'employee');
                    $log = $logs->getLatestLogId();
                    $addLogAction = $logs->addLogsAction($log['id'], "Updated password via forgot password");
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Update Password Failed";
                }
            }
            else
            {
                $response['error'] = 1;
                $msg = "Invalid Input:";
                foreach ($errors as $error)
                {
                    $msg .= "<br>";
                    $msg .= $error;
                }
                $response['msg'] = $msg;
            }
            break;
        
        case "edit-profile":
            include "validation.php";

            $validation = new Validation();

            $updates = array(
                "first" => $_POST['first'],
                "mid" => $_POST['mid'],
                "last" => $_POST['last'],
                "address" => $_POST['address'],
                "email" => $_POST['email'],
                "contact_number" => $_POST['contact_number'],
                "img_name" => $_FILES["img"]["name"],
                "pass" => $_POST['pass'],
                "secret_answer" => $_POST['secret_answer']
            );
            $imgError = [];

            if ($_FILES['img']['name'] != null)
            {
                $imgError = $validation->imageValidation($_FILES['img']['name'], $_FILES['img']['tmp_name']);
            }

            $passwordErr = $validation->passwordValidation($updates['pass'], $_POST['pass1']);
            $invalidInput = $validation->employeeInformation($updates['first'], $updates['mid'], $updates['last'], $updates['email'], $updates['contact_number'], "");

            if (count($invalidInput) == 0 && count($passwordErr) == 0 && count($imgError) == 0)
            {
                include "employee.php";
                include "question.php";
                $employee = new Employee();
                $question = new Question();

                include "logs.php";
                $logs = new Logs();
                $empInfo = $employee->getEmployee($_SESSION['employee_id']);

                $process = $employee->updateEmployee($updates, $_SESSION['employee_id']);
                $process1 = $question->updateEmployeeQuestion($_SESSION['employee_id'], $_POST['secret_question']);

                if ($_FILES['img']['name'] != null)
                {
                    $target_dir =  $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/employee/";
                    $ext = explode(".", $_FILES['img']['name']);
                    $newFile = $_SESSION['employee_id'].".".end($ext);
                    $target_file = $target_dir.$newFile;
                    move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                    $updatePicture = $employee->updateEmployee(array("img_name" => $newFile), $_SESSION['employee_id']);  
                }
                
                $addLogs = $logs->addLogs($_SESSION['employee_id'], 'employee');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);             

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Profile Updated!";
                    $infoList = ['first', 'mid', 'last', 'address', 'email', 'contact_number', 'img_name', 'secret_answer'];
                    foreach ($infoList as $info)
                    {
                        if ($updates[$info] != "" && $empInfo[$info] != $updates[$info])
                        {
                            $addLogAction = $logs->addLogsAction1($log['id'], "Updated Profile", $info, $empInfo[$info], $updates[$info]);
                        }
                    } 
                    if ($updates['pass'] != "")
                    {
                        $addLogAction = $logs->addLogsAction($log['id'], "Updated password");
                    }
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Profile Update Error!";
                    $addLogAction = $logs->addLogsAction($logs['id'], "Failed to update profile");
                }
            }
            else
            {
                $response['error'] = 1;
                $textError = "Invalid Input on :</b>";
                if (count($passwordErr) != 0)
                {
                    foreach ($passwordErr as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                if (count($invalidInput) != 0)
                {
                    foreach ($invalidInput as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                if (count($imgError) != 0)
                {
                    foreach ($imgError as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                $response['msg'] = $textError;
            }

            break;

        case "get-started":
            $radio = $_POST['patientOption'];
            if ($radio == "newPatient")
            {
                include "validation.php";

                $validation = new Validation();

                $insert = array(
                    "first" => $_POST['first'],
                    "mid" => $_POST['mid'],
                    "last" => $_POST['last'],
                    "address" => $_POST['address'],
                    "gender" => $_POST['gender'],
                    "age" => $_POST['age'],
                    "contact_number" => $_POST['contact_number'],
                    "img_name" => ""
                );

                $imgError = [];
                $test = "";
                if ($_FILES["img"]["name"] != null)
                {
                    $imgError = $validation->imageValidation($_FILES["img"]["name"], $_FILES['img']['tmp_name']);
                }
                $invalidInput = $validation->patientInformation($insert['first'], $insert['mid'], $insert['last'], $insert['contact_number'], $insert['age'], $insert['gender']);
                
                if (count($imgError) == 0 && count($invalidInput) == 0)
                {
                    include "patient.php";
                    $patient = new Patient();

                    $process = $patient->addPatient($insert);

                    if ($process)
                    {
                        $response['success'] = 1;
                        $patientInfo = $patient->getLatestPatient();
                        $target_dir =  $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/patient/";
                        $ext = explode(".", $_FILES['img']['name']);
                        $newFile = $patientInfo['id'].".".end($ext);
                        $target_file = $target_dir.$newFile;
                        move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                        $updatePicture = $patient->updatePatient(array("img_name" => $newFile), $patientInfo['id']);

                        include "logs.php";
                        $logs = new Logs();
                        $addLogs = $logs->addLogs($patientInfo['id'], 'patient');
                        $log = $logs->getLatestLogId();
                        $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
                        $addLogAction = $logs->addLogsAction($log['id'], "Added a new patient");

                        Header("Location: index.php?do=get-started-1&id=".$patientInfo['id']);
                    }
                    else
                    {
                        $response['error'] = 1;
                        $response['msg'] = "Patient Add Error!";
                    }
                }
                else
                {
                    $response['error'] = 1;
                    $textError = "Invalid Input on :</b>";

                    if (count($invalidInput) != 0)
                    {
                        foreach ($invalidInput as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }

                    if (count($imgError) != 0)
                    {
                        foreach ($imgError as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }
                    $response['msg'] = $textError;
                    $response['data'] = $insert;
                }
            }
            else if ($radio == "existingPatient")
            {
                if (isset($_POST['id']) && $_POST['id'] != "")
                {
                    Header("Location: index.php?do=get-started-1&id=".$_POST['id']);
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Please pick a patient!";
                }
            }
            break;
        case "get-started-1":
            $total = $_POST['total'];
            if ($total != "")
            {
                $pay = $_POST['pay'];
                if ($pay - $total >= 0)
                {
                    include "billing.php";
                    include "result.php";
                    include "misc.php";
                    include "services.php";
                    include "patient.php";

                    $patient_id = $_GET['id'];
                    $services = $_POST['services'];

                    $result = new Result();
                    $billing = new Billing();
                    $misc = new Misc();
                    $dbServices = new Services();
                    $patient = new Patient();

                    $update = array(
                        "queue" => "1"
                    );
                    $updatePatient = $patient->updatePatient($update, $patient_id);

                    $addBilling = $billing->addBilling($total);
                    $billingInfo = $billing->getLatestBilling();
                    $addResult = $result->addResult($billingInfo['id']);
                    $resultInfo = $result->getLatestResult(); 
                    $addPatientResult = $result->addPatientResult($patient_id, $resultInfo['id']);

                    $lab_code = date('y')."-";
                    if (strlen($resultInfo['id']) == 2)
                    {
                        $lab_code .= "0".$resultInfo['id'];
                    }
                    else if (strlen($resultInfo['id']) == 1)
                    {
                        $lab_code .= "00".$resultInfo['id'];
                    }
                    else
                    {
                        $lab_code .= $resultInfo['id'];
                    }

                    $updateResult = $result->updateResult($resultInfo['id'], $lab_code);

                    foreach ($services as $service)
                    {
                        $addBillingServices = $billing->addBillingServices($billingInfo['id'], $service);
                        $serviceInfo = $dbServices->getService($service);
                        $insertNull = $misc->insertNull($serviceInfo['code']);
                        $miscInfo = $misc->getLatestId($serviceInfo['code']);
                        $insertConnector = $misc->insertConnector($serviceInfo['code'], $resultInfo['id'], $miscInfo['id']);
                    }

                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($resultInfo['id'], 'result');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);    
                    $addLogAction = $logs->addLogsAction($log['id'], "Transaction completed");

                    $response['success'] = 1;
                    $response['msg'] = "Add Result Successful!";

                    header("Location: index.php?do=result");
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Insufficient Money!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a medical service.";
            }
            break;
        case "edit-patient":
            include "validation.php";

            $validation = new Validation();

            $patient_id = $_POST['id'];
            $updates = array(
                "first" => $_POST['first'],
                "mid" => $_POST['mid'],
                "last" => $_POST['last'],
                "address" => $_POST['address'],
                "age" => $_POST['age'],
                "contact_number" => $_POST['contact_number'],
                "gender" => $_POST['gender']
            );

            $imgError = [];

            if ($_FILES['img']['name'] != null)
            {
                $imgError = $validation->imageValidation($_FILES['img']['name'], $_FILES['img']['tmp_name']);
            }
            
            $invalidInput = $validation->patientInformation($updates['first'], $updates['mid'], $updates['last'], $updates['contact_number'], $updates['age'], $updates['gender']);

            if (count($invalidInput) == 0 && count($imgError) == 0)
            {
                include "patient.php";
                $patient = new Patient();

                include "logs.php";
                $logs = new Logs();
                $pInfo = $patient->getPatient($patient_id);

                $process = $patient->updatePatient($updates, $patient_id);

                $addLogs = $logs->addLogs($patient_id, 'patient');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);      

                if ($process)
                {   
                    $target_dir =  $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/patient/";
                    $cur_img = $target_dir.$pInfo['img_name'];
                    unlink($cur_img);
                    $ext = explode(".", $_FILES['img']['name']);
                    $newFile = $patient_id.".".end($ext);
                    $target_file = $target_dir.$newFile;
                    move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                    $updatePicture = $patient->updatePatient(array("img_name" => $newFile), $patient_id);

                    $infoList = ['first', 'mid', 'last', 'address', 'age', 'contact_number', 'gender'];
                    foreach ($infoList as $info)
                    {
                        if ($updates[$info] != "" && $pInfo[$info] != $updates[$info])
                        {
                            $addLogAction = $logs->addLogsAction1($log['id'], "Updated Personal Information", $info, $pInfo[$info], $updates[$info]);
                        }
                    } 
                    if ($_FILES['img']['name'] != "")
                    {
                        $addLogAction = $logs->addLogsAction($log['id'], "Updated photo");
                    }

                    $response['success'] = 1;
                    $response['msg'] = "Successfully Edited Patient's Information!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Edit Patient Failed";
                }
            }
            else
            {
                $response['error'] = 1;
                $textError = "Invalid Input on :</b>";

                if (count($invalidInput) != 0)
                {
                    foreach ($invalidInput as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }

                if (count($imgError) != 0)
                {
                    foreach ($imgError as $error)
                    {
                        $temp = "</br>".$error;
                        $textError .= $temp;
                    }
                }
                $response['msg'] = $textError;
            }

            break;
        case "employee":
            include "validation.php";
            include "employee.php";
            include "question.php";
            $validation = new Validation();

            $radio = $_POST['employeeOption'];
            $userError = [];
            if ($radio == "existingEmployee" && $_POST['id'] == "")
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick an employee!";
            }
            else
            {
                if ($radio == "newEmployee")
                {
                    $userError = $validation->usernameValidation($_POST['username']);
                }
                $patientInfo = array(
                    "first" => $_POST['first'],
                    "mid" => $_POST['mid'],
                    "last" => $_POST['last'],
                    "address" => $_POST['address'],
                    "email" => $_POST['email'],
                    "contact_number" => $_POST['contact_number'],
                    "img_name" => "",
                    "pass" => $_POST['pass'],
                    "job" => $_POST['job'],
                    "secret_answer" => $_POST['secret_answer'],
                    "license" => $_POST['license']
                );
    
                $imgError = [];
                if ($_FILES['img']['name'] != null)
                {
                    $imgError = $validation->imageValidation($_FILES['img']['name'], $_FILES['img']['tmp_name']);
                }
    
    
                $passwordErr = $validation->passwordValidation($patientInfo['pass'], $_POST['pass1']);
                $invalidInput = $validation->employeeInformation($patientInfo['first'], $patientInfo['mid'], $patientInfo['last'], $patientInfo['email'], $patientInfo['contact_number'], $patientInfo['job']);
                
                if (count($userError) == 0 && count($imgError) == 0 && count($passwordErr) == 0 && count($invalidInput) == 0)
                {   
                    include "permission.php";
    
                    $question = new Question();
                    $employee = new Employee();
                    $permission = new Permission();
                    include "logs.php";
                    $logs = new Logs();
                    if ($radio == "existingEmployee")
                    {
                        $empInfo = $employee->getEmployee($_POST['id']);
    
                        $process = $employee->updateEmployee($patientInfo, $_POST['id']);
                        $process1 = $question->updateEmployeeQuestion($_POST['id'], $_POST['secret_question']);
    
                        $addLogs = $logs->addLogs($_POST['id'], 'employee');
                        $log = $logs->getLatestLogId();
                        $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);  
    
                        $perms = $_POST['permission'];
                        $deletePermission = $permission->deleteEmployeePermission($_POST['id']);
                        foreach ($perms as $p)
                        {
                            $addPerms = $permission->addEmployeePermission($p, $_POST['id']);
                        }

                        if ($_FILES['img']['name'] != null)
                        {
                            $target_dir =  $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/employee/";
                            $cur_img = $target_dir.$empInfo['img_name'];
                            unlink($cur_img);
                            $ext = explode(".", $_FILES['img']['name']);
                            $newFile = $_POST['id'].".".end($ext);
                            $target_file = $target_dir.$newFile;
                            move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                            $updatePicture = $employee->updateEmployee(array("img_name" => $newFile), $_POST['id']);
                        }
    
                        if ($process)
                        {
                            $response['success'] = 1;
                            $response['msg'] = "Successfully Edited Employee!";
                            $infoList = ['first', 'mid', 'last', 'address', 'email', 'contact_number', 'img_name', 'secret_answer', 'job', 'license'];
                            foreach ($infoList as $info)
                            {
                                if ($patientInfo[$info] != "" && $empInfo[$info] != $patientInfo[$info])
                                {
                                    $addLogAction = $logs->addLogsAction1($log['id'], "Updated Profile", $info, $empInfo[$info], $patientInfo[$info]);
                                }
                            } 
                            if ($patientInfo['pass'] != "")
                            {
                                $addLogAction = $logs->addLogsAction($log['id'], "Updated password");
                            }
                        }
                        else
                        {
                            $response['error'] = 1;
                            $response['msg'] = "Edit Employee Failed!";
                            $addLogAction = $logs->addLogsAction($log['id'], "Edit employee failed");
                        }
                    }
                    else
                    {
                        $patientInfo['user'] = $_POST['username'];
                        $process = $employee->addEmployee($patientInfo);
                        $pInfo = $employee->getLatestEmployee();
    
                        $addLogs = $logs->addLogs($pInfo['id'], 'employee');
                        $log = $logs->getLatestLogId();
                        $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);  
    
                        $perms = $_POST['permission'];
                        foreach ($perms as $p)
                        {
                            $addPerms = $permission->addEmployeePermission($p, $pInfo['id']);
                        }
    
                        $target_dir =  $_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/employee/";
                        $ext = explode(".", $_FILES['img']['name']);
                        $newFile = $pInfo['id'].".".end($ext);
                        $target_file = $target_dir.$newFile;
                        move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                        $updatePicture = $employee->updateEmployee(array("img_name" => $newFile), $pInfo['id']);
    
                        if ($process)
                        {
                            $patientInfo = $employee->getLatestEmployee();
                            $process1 = $question->addEmployeeQuestion($pInfo['id'], $_POST['secret_question']);
                            $response['success'] = 1;
                            $response['msg'] = "Successfully Added Employee!";
    
                            $addLogAction = $logs->addLogsAction($log['id'], "Added new employee");
                        }
                        else
                        {
                            $response['error'] = 1;
                            $response['msg'] = "Add Employee Failed!";
    
                            $addLogAction = $logs->addLogsAction($log['id'], "Failed to add new employee");
                        }
                    }
                }
                else
                {
                    $response['error'] = 1;
                    $textError = "Invalid Input on :</b>";
    
                    if (count($userError) != 0)
                    {
                        foreach ($userError as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }
    
                    if (count($passwordErr) != 0)
                    {
                        foreach ($passwordErr as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }
    
                    if (count($invalidInput) != 0)
                    {
                        foreach ($invalidInput as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }
    
                    if (count($imgError) != 0)
                    {
                        foreach ($imgError as $error)
                        {
                            $temp = "</br>".$error;
                            $textError .= $temp;
                        }
                    }
                    $response['msg'] = $textError;
                }
            }
            break;

        case "services":
            if (isset($_POST['service_id']) && $_POST['service_id'] != "")
            {
                $id = $_POST['service_id'];
                $code = $_POST['code'];
                $type = $_POST['type'];
                $price = $_POST['price'];

                if (!preg_match("#(\W|\d)#", $price))
                {
                    $response['error'] = 1;
                    $response['msg'] = "Invalid Price!";
                }
                else
                {
                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($id, 'services');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    $addLogAction = $logs->addLogsAction($log['id'], "Updated Price");
                    include "services.php";
                    $services = new Services();
                    $process = $services->updateService($id);
                    $process1 = $services->addService($type, $price, $code);

                    if ($process1)
                    {
                        $response['success'] = 1;
                        $response['msg'] = "Successfully Updated Service!";
                    }
                    else
                    {
                        $response['error'] = 1;
                        $response['msg'] = "Update Service Failed!";
                    }
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a service.";
            }
            break;
        case "question":
            include "question.php";
            $question = new Question();
            if (isset($_POST['question_id']) && $_POST['question_id'] != "")
            {
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($_POST['question_id'], 'question');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Updated Question");
                
                $process = $question->updateQuestion($_POST['question_id']);
                $process1 = $question->addQuestion($_POST['question']);

                if ($process1)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully Edited Question!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Edit Question Failed!";
                }
            }
            else if ($_POST['question'] != "")
            {
                $process = $question->addQuestion($_POST['question']);
                $quest = $question->getLatestId();
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($quest['id'], 'question');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Added New Question");

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully Added Question!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Add Question Failed!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please select or enter your question";
            }
            break;
        case "exam":
            include "exam.php";
            $exam = new Exam();

            if (isset($_POST['eId']) && $_POST['eId'] != "")
            {
                $name = $_POST['eName'];
                $process = $exam->updateExam($_POST['eId'], $name);
                
                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully edited examination!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to edit examination!";
                }
            }
            else
            {
                $name = $_POST['eName'];
                $process = $exam->addExam($name);
                
                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully added examination!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to add examination!";
                }
            }
            break;
        case "permission":
            if (isset($_POST['pId']) && $_POST['pId'] != "")
            {
                include "permission.php";
                $permission = new Permission();

                $permission_id = $_POST['pId'];
                $description = $_POST['description'];
                
                $process = $permission->updatePermission($permission_id, $description);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully edited permission!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to edit permission!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a permission!";
            }
            break;
        case "delete-question":
            if (isset($_POST['question_id']) && $_POST['question_id'] != "")
            {
                include "question.php";
                $question = new Question();

                $process = $question->updateQuestion($_POST['question_id']);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully deleted secret question!";
                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($_POST['question_id'], 'question');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    $addLogAction = $logs->addLogsAction($log['id'], "Removed Question");
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to delete secret question!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please select a secret question!";
            }
            break;
        
        case "delete-exam":
            if (isset($_POST['eId']) && $_POST['eId'] != "")
            {
                include "exam.php";
                $exam = new Exam();

                $process = $exam->inactiveExam($_POST['eId']);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully deleted xray examination!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to delete xray examination!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please select an xray examination!";
            }
            break;
        case "sales":
            $pay = $_POST['pay'];
            $total = $_POST['total'];
            if ($pay - $total >= 0)
            {  
                include "services.php";
                include "misc.php";
                include "result.php";
                include "billing.php";
                include "patient.php";

                $patient = new Patient();
                $billing = new Billing();
                $result = new Result();
                $dbServices = new Services();
                $misc = new Misc();

                $lab_code = $_POST['lab_code'];
                $patient_id = $_POST['patient_id'];
                $result_id = $_POST['result_id'];
                $new_service = $_POST['services'];

                $innerjoin = "";
                $table = "";
                $i = 0;
                $old_service = $dbServices->getPatientServices($lab_code);
                foreach ($old_service as $service)
                {
                    $temp = "t".$i;
                    $temp1 = "y".$i;
                    $innerjoin .= "INNER JOIN result_".$service['code']." $temp ON $temp.result_id = r.id ";
                    $innerjoin .= "INNER JOIN ".$service['code']." $temp1 ON $temp1.id = $temp.".$service['code']."_id ";
                    $table .= ",$temp,$temp1";
                    $i += 1;
                }

                $process = $billing->deleteBilling1($result_id, $table, $innerjoin);

                $addBilling = $billing->addBilling($total);
                $billingInfo = $billing->getLatestBilling();
                $addBillingResult = $result->updateResult1($result_id, $billingInfo['id']);
                
                foreach ($new_service as $service)
                {
                    $addBillingServices = $billing->addBillingServices($billingInfo['id'], $service);
                    $serviceInfo = $dbServices->getService($service);
                    $insertNull = $misc->insertNull($serviceInfo['code']);
                    $miscInfo = $misc->getLatestId($serviceInfo['code']);
                    $insertConnector = $misc->insertConnector($serviceInfo['code'], $result_id, $miscInfo['id']);
                }

                $update = array(
                    "queue" => "1"
                );
                $updatePatient = $patient->updatePatient($update, $patient_id);
                $inactiveRes = $result->activeResult($lab_code);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully edited the patient's result!";
                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($result_id, 'result');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    $addLogAction = $logs->addLogsAction($log['id'], "Edited services");
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to edit the patient's result!";
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Insufficient Money!";
            }
            break;
        case "delete-sales":
            include "services.php";
            include "misc.php";
            include "result.php";
            include "billing.php";
            include "patient.php";
            $patient = new Patient();
            $billing = new Billing();
            $result = new Result();
            $dbServices = new Services();
            $misc = new Misc();

            $lab_code = $_POST['lab_code'];
            $patient_id = $_POST['patient_id'];
            $result_id = $_POST['result_id'];

            $innerjoin = "";
            $table = "";
            $i = 0;
            $old_service = $dbServices->getPatientServices($lab_code);
            foreach ($old_service as $service)
            {
                $temp = "t".$i;
                $temp1 = "y".$i;
                $innerjoin .= "INNER JOIN result_".$service['code']." $temp ON $temp.result_id = r.id ";
                $innerjoin .= "INNER JOIN ".$service['code']." $temp1 ON $temp1.id = $temp.".$service['code']."_id ";
                $table .= ",$temp,$temp1";
                $i += 1;
            }

            $update = array(
                "queue" => "0"
            );
            $updatePatient = $patient->updatePatient($update, $patient_id);

            $process = $billing->deleteBilling($result_id, $table, $innerjoin);
            if ($process)
            {
                $response['success'] = 1;
                $response['msg'] = "Successfully deleted the patient's result!";
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Failed to delete the patient's result!";
            }
            break;
        case "company":
            include "company.php";
            $company = new Company();
            $id = $_POST['company_id'];
            $name = $_POST['company_name'];
            $address = $_POST['company_address'];
            if ($id == "")
            {
                $process = $company->addCompany($name, $address);
                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully added a company!";

                    include "logs.php";
                    $logs = new Logs();
                    $comp = $company->getLatestCompanyId();
                    $addLogs = $logs->addLogs($comp['id'], 'company');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    $addLogAction = $logs->addLogsAction($log['id'], "Added new company");
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to add a company!";
                }
            }
            else
            {
                $compa = $company->getCompany($id);
                $process = $company->updateCompany($id, $name, $address);
                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully edited company!";

                    include "logs.php";
                    $logs = new Logs();
                    $addLogs = $logs->addLogs($id, 'company');
                    $log = $logs->getLatestLogId();
                    $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                    if ($compa['name'] != $name)
                    {
                        $addLogAction = $logs->addLogsAction1($log['id'], "Updated company", 'name', $compa['name'], $name);
                    }
                    if ($compa['address'] != $address)
                    {
                        $addLogAction = $logs->addLogsAction1($log['id'], "Updated company", 'address', $compa['address'], $address);
                    }
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to edit company!";
                }
            }
            break;
        case "patient-company":
            include "company.php";
            $company = new Company();
            $company_id = $_POST['c_id'];
            $companyInfo = $company->countCompanyPatient($company_id);

            if ($companyInfo['total'] != 0)
            {
                header("Location: index.php?do=patient-company-1&id=".$company_id);
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please add patients to the company!";
            }
            break;
        case "patient-company-1":
            if (count($_POST['services']) != 0 && !isset($services))
            {
                include "company.php";
                include "result.php";
                include "billing.php";
                include "misc.php";
                include "patient.php";
                include "services.php";

                $result = new Result();
                $billing = new Billing();
                $misc = new Misc();
                $dbServices = new Services();
                $patient = new Patient();
                $company = new Company();

                $company_id = $_POST['company_id'];
                $company_patients = $company->getCompanyPatients($company_id);
                $services = $_POST['services'];
                $total = $_POST['total'];
                $addCompanyResult = $company->addCompanyResult($company_id);
                $companyResult = $company->getLatestCompanyResult();
                foreach($company_patients as $c_p)
                {
                    $patient_id = $c_p['id'];

                    $update = array(
                        "queue" => "1"
                    );
                    $updatePatient = $patient->updatePatient($update, $patient_id);
                    $addBilling = $billing->addBilling($total);
                    $billingInfo = $billing->getLatestBilling();
                    $addResult = $result->addResult($billingInfo['id']);
                    $resultInfo = $result->getLatestResult(); 
                    $addPatientResult = $result->addPatientResult($patient_id, $resultInfo['id']);
                    $addCompanyResultConnector = $company->addCompanyResultConnector($companyResult['id'], $resultInfo['id']);

                    $lab_code = date('y')."-";
                    if (strlen($resultInfo['id']) == 2)
                    {
                        $lab_code .= "0".$resultInfo['id'];
                    }
                    else if (strlen($resultInfo['id']) == 1)
                    {
                        $lab_code .= "00".$resultInfo['id'];
                    }
                    else
                    {
                        $lab_code .= $resultInfo['id'];
                    }

                    $updateResult = $result->updateResult($resultInfo['id'], $lab_code);

                    foreach ($services as $service)
                    {
                        $addBillingServices = $billing->addBillingServices($billingInfo['id'], $service);
                        $serviceInfo = $dbServices->getService($service);
                        $insertNull = $misc->insertNull($serviceInfo['code']);
                        $miscInfo = $misc->getLatestId($serviceInfo['code']);
                        $insertConnector = $misc->insertConnector($serviceInfo['code'], $resultInfo['id'], $miscInfo['id']);
                    }
                }
                $process = $company->updateCompanyQueue($company_id, 1);
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($company_id, 'company');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Edited services");
                header("Location: index.php?do=result");
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = "Please pick a medical service!";
            }
            break;
        case "company-sales-edit":
            if (isset($_POST['company_result_id']) && $_POST['company_result_id'] != "")
            {
                include "services.php";
                include "misc.php";
                include "result.php";
                include "billing.php";
                include "company.php";

                $company = new Company();
                $billing = new Billing();
                $result = new Result();
                $dbServices = new Services();
                $misc = new Misc();

                $company_result_id = $_POST['company_result_id'];
                $new_service = $_POST['services'];
                $total = $_POST['ptotal'];

                $companyResult = $company->getCompanyResult($company_result_id);
                $company_id = $companyResult[0]['company_id'];

                $queueUpdate = $company->updateCompanyQueue($company_id, 1);
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($company_result_id, 'company_result');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);

                foreach ($companyResult as $cr)
                {
                    $result_id = $cr['result_id'];
                    $resultInfo = $result->getResult($result_id);
                    $lab_code = $resultInfo['lab_code'];

                    $innerjoin = "";
                    $table = "";
                    $i = 0;
                    $old_service = $dbServices->getPatientServices($lab_code);
                    foreach ($old_service as $service)
                    {
                        $temp = "t".$i;
                        $temp1 = "y".$i;
                        $innerjoin .= "INNER JOIN result_".$service['code']." $temp ON $temp.result_id = r.id ";
                        $innerjoin .= "INNER JOIN ".$service['code']." $temp1 ON $temp1.id = $temp.".$service['code']."_id ";
                        $table .= ",$temp,$temp1";
                        $i += 1;
                    }

                    $activeResult = $result->activeResult($lab_code);
                    
                    $process = $billing->deleteBilling1($result_id, $table, $innerjoin);

                    $addBilling = $billing->addBilling($total);
                    $billingInfo = $billing->getLatestBilling();
                    $addBillingResult = $result->updateResult1($result_id, $billingInfo['id']);
                    
                    foreach ($new_service as $service)
                    {
                        $addBillingServices = $billing->addBillingServices($billingInfo['id'], $service);
                        $serviceInfo = $dbServices->getService($service);
                        $insertNull = $misc->insertNull($serviceInfo['code']);
                        $miscInfo = $misc->getLatestId($serviceInfo['code']);
                        $insertConnector = $misc->insertConnector($serviceInfo['code'], $result_id, $miscInfo['id']);
                    }

                    if ($process)
                    {
                        $response['success'] = 1;
                        $response['msg'] = "Successfully edited the company result!";
                        $addLogAction = $logs->addLogsAction($log['id'], "Updated Company Bills");
                    }
                    else
                    {
                        $response['error'] = 1;
                        $response['msg'] = "Failed to edit the company result!";
                    }
                }
            }
            else
            {
                $response['error'] == 1;
                $response['msg'] = "Please pick a company!";
            }
            break;
        case "company-sales-delete":
            if (isset($_POST['company_result_id']) && $_POST['company_result_id'] != "")
            {
                include "services.php";
                include "misc.php";
                include "result.php";
                include "billing.php";
                include "company.php";

                $company = new Company();
                $billing = new Billing();
                $result = new Result();
                $dbServices = new Services();
                $misc = new Misc();

                $company_result_id = $_POST['company_result_id'];
                $new_service = $_POST['services'];

                
                $companyResult = $company->getCompanyResult($company_result_id);
                $company_id = "";
                foreach ($companyResult as $cr)
                {
                    $company_id = $cr['company_id'];
                    $result_id = $cr['result_id'];
                    $resultInfo = $result->getResult($result_id);
                    $lab_code = $resultInfo['lab_code'];
                    
                    $innerjoin = "";
                    $table = "";
                    $i = 0;
                    $old_service = $dbServices->getPatientServices($lab_code);
                    foreach ($old_service as $service)
                    {
                        $temp = "t".$i;
                        $temp1 = "y".$i;
                        $innerjoin .= "INNER JOIN result_".$service['code']." $temp ON $temp.result_id = r.id ";
                        $innerjoin .= "INNER JOIN ".$service['code']." $temp1 ON $temp1.id = $temp.".$service['code']."_id ";
                        $table .= ",$temp,$temp1";
                        $i += 1;
                    }
                    
                    $proc = $billing->deleteBilling($result_id, $table, $innerjoin);
                }

                $updateQueue = $company->updateCompanyQueue($company_id, 0);

                $process = $company->deleteCompanyPatient($company_result_id);

                if ($process)
                {
                    $response['success'] = 1;
                    $response['msg'] = "Successfully edited the company result!";
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = "Failed to edit the company result!";
                }

            }
            else
            {
                $response['error'] == 1;
                $response['msg'] = "Please pick a company!";
            }
            break;
        case "accept-request":
            if (isset($_POST['request_id']) && $_POST['request_id'] != "")
            {
                include "request.php";
                include "misc.php";
                $misc = new Misc();
                $request = new Request();
                $request_id = $_POST['request_id'];
                $requestInput = $request->getRequestInput($request_id);

                foreach ($requestInput as $req)
                {
                    $updateResult = $misc->updateSpecificResult($req['table_name'], $req['id'], $req['col'], $req['new']);
                }
                $updateRequest = $request->updateRequest(2, $request_id);
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($request_id, 'request');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Request Accepted");
                $response['msg'] = "Successfully updated result!";
                $response['success'] = 1;
            }
            else
            {
                $response['msg'] = "Please pick a request!";
                $response['error'] = 1;
            }
            break;
        case "decline-request":
            if (isset($_POST['request_id']) && $_POST['request_id'] != "")
            {
                include "request.php";
                $request = new Request();

                $updateRequest = $request->updateRequest(0, $_POST['request_id']);
                include "logs.php";
                $logs = new Logs();
                $addLogs = $logs->addLogs($_POST['request_id'], 'request');
                $log = $logs->getLatestLogId();
                $addEmployeeLogs = $logs->addEmployeeLogs($_SESSION['employee_id'], $log['id']);
                $addLogAction = $logs->addLogsAction($log['id'], "Request Declined");
                $response['msg'] = "Successfully decline request!";
                $response['success'] = 1;
            }
            else
            {
                $response['msg'] = "Please pick a request!";
                $response['error'] = 1;
            }
            break;
    }
}

?>