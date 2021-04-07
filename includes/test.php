<?php
require ('fpdf/fpdf.php');
function printResult($result_ids, $patient_id, $result_id)
{
//max width = 189mm
$pdf = new FPDF('P', 'mm', 'A4');

$keys = [];
$values = [];

foreach ($result_ids as $key=>$val)
{
    $keys[] = $key;
    $values[] = $val;
}

include_once "employee.php";
include_once "result.php";
$result = new Result();
$employee = new Employee();

$resultInfo1 = $result->getResult($result_id);

$footer = array(
    "radtech" => "",
    "medtech" => "",
    "physician" => ""
);

$emp1 = $employee->getEmployeeResult($resultInfo1['lab_code']);
foreach ($emp1 as $emp2)
{
    if ($emp2['result_lab_code'] == $resultInfo1['lab_code'])
    {
        $employeeInfo = $employee->getEmployee($emp2['employee_id']);
        $job = $employeeInfo['job'];
        if ($job == "Radiologist")
        {
            $footer["radtech"] = $employeeInfo;
        }
        else if ($job == "Medical Technologist")
        {
            $footer["medtech"] = $employeeInfo;
        }
        else if ($job == "Physician")
        {
            $footer["physician"] = $employeeInfo;
        }
    }
}

//cell (width, height, text, border, endline, [align])

/////////////////////////////////////////////////////////////////
/////////////////////////PATIENT INFO///////////////////////////
///////////////////////////////////////////////////////////////
include_once "patient.php";
$patient = new Patient();
$patientInfo = $patient->getPatient($patient_id);
$name = $patientInfo['first']." ".$patientInfo['mid']." ".$patientInfo['last'];
$age = $patientInfo['age'];
$gender = $patientInfo['gender'];

$company = "None";
$patientCompany = $patient->getPatientCompany($patient_id);
if ($patientCompany['count'] != 0)
{
    $company = $patientCompany['name'];
}

include_once "result.php";
$result = new Result();
$resultInfo = $result->getResult($result_id);
$result_lab_code = $resultInfo['lab_code'];
$result_datetime = $resultInfo['datetime'];
$datetime = new DateTime($result_datetime);
$date = $datetime->format("F d, Y");

/////////////////////////////////////////////////////////////////
///////////////////////////xray///////////////////////////////./
///////////////////////////////////////////////////////////////
if (in_array("xray", $keys) && $result_ids['xray'] != "")
{
    $pdf->AddPage();

    $xray_id = $result_ids['xray'];
    include_once "misc.php";
    include_once "exam.php";
    $exam = new Exam();
    $misc = new Misc();
    
    $info = $misc->getSpecificResult("xray", $xray_id);
    $exam = $exam->getExam($xray_id);
    $examInfo = $misc->getSpecificResult("exam", $exam['exam_id']);
    $examination = $examInfo['name'];

    $pdf->SetFont('Arial', '', 10);
    $pdf->Image($_SERVER['DOCUMENT_ROOT']."/clinic1/img/jaz_logo.png", 8, 10, 195, 15);//logo
    $pdf->Cell(189, 30, '',0, 1);
    $pdf->Cell(135, 0, '',0, 0);
    $pdf->cell(35, 35, $pdf->Image($_SERVER['DOCUMENT_ROOT']."/clinic1/uploads/patient/".$patientInfo['img_name'], $pdf->GetX(), $pdf->GetY(), 35, 35), 1, 0, 'C');
    $pdf->Cell(0, 0, '',0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'NAME', 0, 0);
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 7, $name, 0, 1);//NAME

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'EXAMINATION', 0, 0);
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 7, $examination, 0, 1);//EXAMINATION

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'AGE/SEX', 0, 0);
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 7, $age." / ".$gender, 0, 1);//AGE / GENDER

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'DATE', 0, 0);
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 7, $date, 0, 1);//datetime

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 7, '', 0, 0);
    $pdf->Cell(30, 7, 'CASE #', 0, 0);
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 7, $result_lab_code, 0, 1);//lab_code

    $pdf->Cell(189, 20, '', 0, 1);

    $pdf->Cell(63, 5, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(63, 5, 'X-RAY RESULT', 0, 0, 'C');
    $pdf->Cell(63, 5, '', 0, 0);

    $pdf->Cell(189, 20, '', 0, 1);//blank space
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(20, 20, '', 0, 0);
    $pdf->Multicell(150, 7, $info['observation'], 0, 'L');//observation

    $pdf->Cell(20, 20, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(20, 20, '', 0, 0);
    $pdf->Cell(35, 20, 'IMPRESSION:', 0, 0);
    $pdf->Cell(5, 20, '', 0, 0);
    $pdf->SetFont('Arial', '', 13);
    $pdf->Cell(110, 20, $info['impression'], 0, 0); //impression

    $radtech = $footer['radtech'];
    $name = $radtech['first']." ".substr(ucfirst($radtech['mid']),0,1).". ".$radtech['last'];

    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(189, 60, '', 0, 1);//blank space
    $pdf->Cell(119, 7, '', 0, 0);
    $pdf->Cell(60, 7, $name, 'B', 1, 'C');//radiologist name
    $pdf->Cell(119, 7, '', 0, 0);
    $pdf->Cell(60, 7, 'Radiologist', 0, 1, 'C');
    $pdf->Cell(119, 7, '', 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(60, 5, 'Lic.No.:'.$radtech['license'], 0, 1, 'C');//license number
}

if (in_array("hematology", $keys) || in_array("urinalysis", $keys) || in_array("fecalysis", $keys))
{
    $pdf->AddPage();
    $pdf->Image($_SERVER['DOCUMENT_ROOT']."/clinic1/img/jaz_logo.png", 8, 10, 195, 15);//logo
    $pdf->Cell(189, 20, '',0, 1);//blank space

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(23, 5, 'Name:', 1, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(60, 5, $name, 1, 0, 'C');//name
    $pdf->Cell(23, 5, 'Age:', 1, 0, 'C');
    $pdf->Cell(20, 5, $age, 1, 0, 'C');//age
    $pdf->Cell(23, 5, 'Date:', 1, 0);
    $pdf->Cell(40, 5, $date, 1, 1, 'C');//end line //date of transaction

    $pdf->Cell(23, 5, 'Company:', 1, 0);
    $pdf->Cell(60, 5, $company, 1, 0, 'C'); //company
    $pdf->Cell(23, 5, 'Sex:', 1, 0, 'C');
    $pdf->Cell(20, 5, $gender, 1, 0, 'C'); //gender
    $pdf->Cell(23, 5, 'Case #:', 1, 0);
    $pdf->Cell(40, 5, $result_lab_code, 1, 1, 'C');//endline // lab_code

    $pdf->Cell(189, 10, '', 0, 1);//space
}

/////////////////////////////////////////////////////////////////
///////////////////////////URINALYSIS///////////////////////////
///////////////////////////////////////////////////////////////

if (in_array("urinalysis", $keys) && $result_ids['urinalysis'] != "")
{
    $urinalysis_id = $result_ids['urinalysis'];
    include_once "misc.php";
    $misc = new Misc();
    
    $info = $misc->getSpecificResult("urinalysis", $urinalysis_id);

    $pdf->SetFont('Arial', 'B', 22);
    $pdf->Cell(189, 10, 'URINALYSIS', 0, 1);//title
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(41, 5, 'PARAMETER/TEST', 1, 0, 'C');
    $pdf->Cell(25, 5, 'RESULT', 1, 0, 'C');
    $pdf->Cell(33, 5, 'NORMAL VALUES*', 1, 0, 'C');
    $pdf->Cell(28, 5, '', 1, 0);
    $pdf->Cell(27, 5, 'RESULT', 1, 0, 'C');
    $pdf->Cell(35, 5, 'NORMAL VALUES*', 1, 1, 'C');//endline

    $pdf->Cell(99, 5, 'PHYSICAL EXAMINATION', 1, 0, 'C');
    $pdf->Cell(90, 5, 'MICROSCOPIC EXAMINATION', 1, 1, 'C');//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 8, 'Color', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 8, $info['color'], 1, 0, 'C');//color
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 8, 'yellow', 1, 0, 'C');


    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 8, 'RBC', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 8, ($info['rbc'] != ""?$info['rbc']."/HPF":""), 1, 0, 'C');//RBC
    $pdf->SetFont('Arial', '', 8);
    $pdf->Multicell(35,4,"M: 0-2/HPF\nF: 0-5/HPF", 1, 'C');
    $pdf->Cell(0, 0, "", 0, 1);//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 8, 'Transparency', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 8, $info['transparency'], 1, 0, 'C');//transparency
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 8, 'Clear', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 8, 'WBC', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 8,($info['wbc'] != ""?$info['wbc']."/HPF":""), 1, 0, 'C');//WBC
    $pdf->SetFont('Arial', '', 8);
    $pdf->Multicell(35,4,"M: 0-2/HPF\nF: 0-5/HPF", 1, 'C');
    $pdf->Cell(0, 0, "", 0, 1);//endline

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(99, 6, 'CHEMICAL EXAMINATION', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 6, 'Ephithelial Cells', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 6, $info['e_c'], 1, 0, 'C');//e_c
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(35, 6, "", 1, 1);//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 6, 'pH(Reaction)', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, $info['ph_reaction'], 1, 0, 'C');//ph_reaction
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 6, '4.8 - 7.8', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 6, 'Amorphous Urates', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 6, $info['a_u'], 1, 0, 'C');//a_u
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(35, 6, "", 1, 1);//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 6, 'Specific Gravity', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, $info['specific_gravity'], 1, 0, 'C');//specific_gravity
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 6, '1.015 - 1.025', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 6, 'Bacteria', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 6, $info['bacteria'], 1, 0, 'C');//bacteria
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(35, 6, "", 1, 1);//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 6, 'Glucose', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, $info['glucose'], 1, 0, 'C');//glucose
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 6, 'Negative', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 6, 'Mucus Threads', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(27, 6, $info['mucus_threads'], 1, 0, 'C');//mucus_threads
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(35, 6, "", 1, 1);//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(41, 6, 'Protein (Albumin)', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, $info['protein'], 1, 0, 'C');//protein
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(33, 6, 'Negative', 1, 0, 'C');

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(28, 12, 'Others', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(62, 12, $info['others'], 1, 1);//others
}

/////////////////////////////////////////////////////////////////
///////////////////////////hematology///////////////////////////
///////////////////////////////////////////////////////////////

if (in_array("hematology", $keys) && $result_ids['hematology'] != "")
{
    $hematology_id = $result_ids['hematology'];
    include_once "misc.php";
    $misc = new Misc();
    
    $info = $misc->getSpecificResult("hematology", $hematology_id);
    $resultTemp = array(
        "hemoglobinM" => "-",
        "hemoglobinF" => "-",
        "hematocritM" => "-",
        "hematocritF" => "-"
    );
    if ($gender == "Male")
    {
        $resultTemp["hemoglobinM"] = $info['hemoglobin']."g/L";
        $resultTemp["hematocritM"] = $info['hematocrit'];
    }
    else
    {
        $resultTemp["hemoglobinF"] = $info['hemoglobin']."g/L";
        $resultTemp["hematocritF"] = $info['hematocrit'];
    }

    $pdf->SetFont('Arial', 'B', 22);
    $pdf->Cell(189, 10, 'HEMATOLOGY', 0, 1);//title
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 5, 'TEST', 1, 0, 'C');
    $pdf->Cell(38, 5, 'REFERENCE (SI UNIT)', 1, 0, 'C');
    $pdf->Cell(31.5, 5, 'RESULT', 1, 0, 'C');
    $pdf->Cell(25, 5, 'TEST', 1, 0, 'C');
    $pdf->Cell(38, 5, 'REFERENCE (SI UNIT)', 1, 0, 'C');
    $pdf->Cell(31.5, 5, 'RESULT', 1, 1, 'C');//endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 10, 'Hemoglobin', 1, 0, 'C');
    $pdf->Cell(38, 5, 'M 140 - 180', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 5, $resultTemp["hemoglobinM"], 1, 0, 'C');//hemoglobin male //endline

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(94.5, 5, 'Differential Count', 1, 1, 'C');//end line

    $pdf->Cell(25, 5, '', 0, 0);//blank line
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(38, 5, 'F 120 - 160', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 5, $resultTemp["hemoglobinF"], 1, 0, 'C');//hemoglobin female //endline


    $pdf->Cell(25, 5, 'Neutrophils', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.40 - 0.75', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['neutrophils'], 1, 1, 'C');//neutrophils

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 10, 'Hematocrit', 1, 0, 'C');
    $pdf->Cell(38, 5, 'M 0.40 - 0.54', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 5, $resultTemp["hematocritM"], 1, 0, 'C');//hematocrit male

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 5, 'Lymphocytes', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.20 - 0.45', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['lymphocytes'], 1, 1, 'C');//lymphocytes

    $pdf->Cell(25, 5, '', 0, 0);//blank line
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(38, 5, 'F 0.27 - 0.47', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 5, $resultTemp["hematocritF"], 1, 0, 'C');//hematocrit female

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 5, 'Monocytes', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.02 - 0.06', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['monocytes'], 1, 1, 'C');//monocytes


    $pdf->Cell(25, 10, 'WBC Count', 1, 0, 'C');
    $pdf->Cell(38, 10, '5.0 - 10.0 x10^9 L', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 10, ($info['wbc_count'] != ""?$info['wbc_count']."x10^9 L":""), 1, 0, 'C');//wbc count

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 5, 'Eosinophils', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.01 - 0.04', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['eosinophils'], 1, 1, 'C');//eosinophils

    $pdf->Cell(94.5, 5, '', 0, 0);//blank cell

    $pdf->Cell(25, 5, 'Basophils', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.0 - 0.01', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['basophils'], 1, 1, 'C');//basophils

    $pdf->Cell(25, 10, 'Platelet Count', 1, 0, 'C');
    $pdf->Cell(38, 10, '5.0 - 10.0 x10^9 L', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(31.5, 10, ($info['platelet_count'] != ""?$info['platelet_count']."x10^9 L":""), 1, 0, 'C');//platelet count

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 5, 'Stab Cells', 1, 0, 'C');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(38, 5, '0.03 - 0.05', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(31.5, 5, $info['stab_cells'], 1, 1, 'C');//stab_cells

    $pdf->Cell(189, 5, '', 0, 1);//blank cell
}

/////////////////////////////////////////////////////////////////
///////////////////////////FECALYSIS////////////////////////////
///////////////////////////////////////////////////////////////
if (in_array("fecalysis", $keys) && $result_ids['fecalysis'] != "")
{
    $fecalysis_id = $result_ids['fecalysis'];
    include_once "misc.php";
    $misc = new Misc();
    
    $info = $misc->getSpecificResult("fecalysis", $fecalysis_id);
    
    $pdf->SetFont('Arial', 'B', 22);
    $pdf->Cell(189, 10, 'FECALYSIS', 0, 1);//title
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 5, 'MACROSCOPIC', 1, 0, 'C');
    $pdf->Cell(47.25, 5, 'RESULT', 1, 0, 'C');
    $pdf->Cell(47.25, 5, 'MICROSCOPIC', 1, 0, 'C');
    $pdf->Cell(47.25, 5, 'RESULT', 1, 1, 'C');//end line

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 10, 'Color', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 10, $info['color'], 1, 0, 'C');//color

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 5, 'RBC', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 5, $info['rbc'], 1, 1, 'C');//rbc //endline

    $pdf->Cell(94.5, 5, '', 0, 0);//blank line
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 5, 'PUS CELLS', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 5, $info['pus_cells'], 1, 1, 'C');//pus_cells //endline

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 10, 'Consistency', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 10, $info['consistency'], 1, 0, 'C');//consistency

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 5, 'BACTERIA', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 5, $info['bacteria'], 1, 1, 'C');//bacteria //endline


    $pdf->Cell(94.5, 5, '', 0, 0);//blank line
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 5, 'FAT GLOBULES', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 5, $info['fat_globules'], 1, 1, 'C');//fat_globules //endline

    $pdf->Cell(94.5, 10, '', 0, 0);//blank line
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(47.25, 10, 'PARASITES', 1, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47.25, 10, $info['parasites'], 1, 1, 'C');//parasites //endline
}

/////////////////////////////////////////////////////////////////
///////////////////////////FOOTER////////////////////////////
///////////////////////////////////////////////////////////////

if (in_array("hematology", $keys) || in_array("urinalysis", $keys) || in_array("fecalysis", $keys))
{
    $medtech = $footer['medtech'];
    $physician = $footer['physician'];

    $medtech_name = $name = $medtech['first']." ".substr(ucfirst($medtech['mid']),0,1).". ".$medtech['last'];
    $physician_name = $name = $physician['first']." ".substr(ucfirst($physician['mid']),0,1).". ".$physician['last'];

    $pdf->Cell(189, 15, '', 0, 1);//blank line

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(57.25, 5, $medtech_name.", RMT", "B", 0, 'C');
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->Cell(57.25, 5, $physician_name.", MD", "B", 1, 'C');//endline
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(57.25, 5, 'Medical Technologist', 0, 0, 'C');
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->Cell(57.25, 5, 'Clinical Pathologist', 0, 1, 'C');//endline
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(57.25, 5, 'Lic.No.:'.$medtech['license'], 0, 0, 'C');//license number
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->Cell(37.25, 5, '', 0, 0);//blank space
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(57.25, 5, 'Lic.No.:'.$physician['license'], 0, 1, 'C');//license number
}
$fle = $_SERVER['DOCUMENT_ROOT']."/clinic1/results/".$result_lab_code." ".$patientInfo['last'].", ".$patientInfo['first'].".pdf";
if (file_exists($fle)) {
    $handle = fopen($fle, 'r');
    fclose($handle);
    unlink($fle);
}
$pdf->Output('F', $fle);
return "results/".$result_lab_code." ".$patientInfo['last'].", ".$patientInfo['first'].".pdf";
}
?>