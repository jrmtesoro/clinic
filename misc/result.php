<?php
$onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
$onlyDecimal = "onkeypress='return (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46 || event.charCode == 32 || event.charCode == 45)'";
?>

<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Result</h1>
    </div>
    <div class="offset-2 col my-auto">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="resultOption" value="newResult" checked="checked">
            <label class="form-check-label">Pending Result</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="resultOption" value="existingResult">
            <label class="form-check-label">Existing Result</label>
        </div>
    </div>
    <div class="offset-1">
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto"type="button" id="update-result">Update</button>
        <button class="btn btn-primary my-auto d-none" type="button" id ="request-btn" data-toggle="modal" data-target="#request-modal">Request Update</button>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<div class="alert alert-danger alert-dismissible fade show mt-5 d-none" id='alert-body' role="alert">
    <p class="font-weight-bold my-auto" id="alert-content"></p>
    <button type="button" class="close my-auto" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php  
    if (isset($_SESSION['msg']))
    {
        $alert = new Alert();
        $alert->displaySuccess($_SESSION['msg']);
        $_SESSION['msg'] = null;
    }
?>
<div class="row" style="margin-top: 60px;" id="rt">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pending Results</h4>
                <table class="table table-sm table-hover" id="result-table">
                    <thead>
                        <tr>
                            <th>Case #</th>
                            <th>First</th>
                            <th>Last</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once $root."patient.php";
                            $patient = new Patient();
                            $where = "INNER JOIN patient_result ON patient_result.patient_id = patient.id INNER JOIN result ON result.id = patient_result.result_id WHERE result.active = 1";
                            $patientInfo = $patient->getPatients($where);
                            $infoList = ['lab_code', 'first', 'last', 'datetime', 'patient_id', 'gender'];
                            
                            foreach ($patientInfo as $row)
                            {
                                
                                echo "<tr>";
                                foreach($infoList as $info)
                                {
                                    echo "<td>".$row[$info]."</td>";
                                }
                                echo "</tr>";
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
<?php
?>
<div class="row d-none" style="margin-top: 60px;" id="rt1">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Existing Results</h4>
                <table class="table table-sm table-hover" id="result-table-1">
                    <thead>
                        <tr>
                            <th>Case #</th>
                            <th>First</th>
                            <th>Last</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $where = "INNER JOIN patient_result ON patient_result.patient_id = patient.id INNER JOIN result ON result.id = patient_result.result_id WHERE result.active = 0";
                            $patientInfo = $patient->getPatients($where);
                            $infoList = ['lab_code', 'first', 'last', 'datetime', 'patient_id', 'gender'];
                            
                            foreach ($patientInfo as $row)
                            {
                                echo "<tr>";
                                foreach($infoList as $info)
                                {
                                    echo "<td>".$row[$info]."</td>";
                                }
                                echo "</tr>";
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
<div class="row" id="result-nav" style="margin-top: 20px;">
    <div class="col">
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link active urinalysis d-none" data-toggle="tab" href="#urinalysis" role="tab">Urinalysis</a>
                <a class="nav-item nav-link hematology d-none" data-toggle="tab" href="#hematology" role="tab">Hematology</a>
                <a class="nav-item nav-link fecalysis d-none" data-toggle="tab" href="#fecalysis" role="tab">Fecalysis</a>
                <a class="nav-item nav-link xray d-none" data-toggle="tab" href="#xray" role="tab">Xray</a>
            </div>
        </nav>
        <div class="tab-content mb-5 pb-5">
            <div class="tab-pane fade" id="urinalysis" role="tabpanel">
                <?php include "result-card/urinalysis.php"; ?>
            </div>
            <div class="tab-pane fade" id="hematology" role="tabpanel">
                <?php include "result-card/hematology.php"; ?>
            </div>
            <div class="tab-pane fade" id="fecalysis" role="tabpanel">
                <?php include "result-card/fecalysis.php"; ?>
            </div>
            <div class="tab-pane fade" id="xray" role="tabpanel">
                <?php include "result-card/xray.php"; ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="hidden_id" name="lab_code" value="">
<input type="hidden" class="hidden_id" name="patient_id" value="">
<input type="hidden" class="hidden_id" name="urinalysis_id" value="">
<input type="hidden" class="hidden_id" name="fecalysis_id" value="">
<input type="hidden" class="hidden_id" name="hematology_id" value="">
<input type="hidden" class="hidden_id" name="xray_id" value="">
<input type="hidden" name="radio_button_val" value="update-result">

<div class="modal fade" id="request-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Reason</label>
                    <textarea class="form-control" rows="3" name="reason" style="resize: none;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="tag" value="update-request">Request</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="update-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Examined By</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group d-none" id="medtech">
                    <label>Medical Technologist</label>
                    <select class="form-control" name="medtech" tabIndex="1">
                        <?php
                            include_once $root."employee.php";
                            $employee = new Employee();
                            $employeeList = $employee->getEmployees("");
                            foreach ($employeeList as $employee)
                            {
                                if ($employee['job'] == "Medical Technologist")
                                {
                                    echo "<option value='".$employee['id']."'>".$employee['first']." ".$employee['last']."</option>";   
                                }
                            }
                        ?>
                    </select>
                </div> 
                <div class="form-group d-none" id="radtech">
                    <label>Radiologist</label>
                    <select class="form-control" name="radtech" tabIndex="1">
                        <?php
                            include_once $root."employee.php";
                            $employee = new Employee();
                            $employeeList = $employee->getEmployees("");
                            foreach ($employeeList as $employee)
                            {
                                if ($employee['job'] == "Radiologist")
                                {
                                    echo "<option value='".$employee['id']."'>".$employee['first']." ".$employee['last']."</option>";   
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group d-none" id="physician">
                    <label>Physician</label>
                    <select class="form-control" name="physician" tabIndex="1">
                        <?php
                            include_once $root."employee.php";
                            $employee = new Employee();
                            $employeeList = $employee->getEmployees("");
                            foreach ($employeeList as $employee)
                            {
                                if ($employee['job'] == "Physician")
                                {
                                    echo "<option value='".$employee['id']."'>".$employee['first']." ".$employee['last']."</option>";   
                                }
                            }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="tag" value="update-result">Submit</button>
            </div>
        </div>
    </div>
</div>
</form>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="misc/js/result.js"></script>