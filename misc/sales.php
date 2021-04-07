<?php
$onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
$onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>
<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Sales</h1>
    </div>
    <div class="offset-4 col my-auto">
    </div>
    <div class="col my-auto">
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<?php
    if (isset($_POST['tag']) && $_POST['tag'] != "")
    {
        $alert = new Alert();
        if ($response['success'] == 1)
        {
            echo $alert->displaySuccess($response['msg']);
        }
        else if ($response['error'] == 1)
        {
            echo $alert->displayError($response['msg']);
        }
    }
?>
<div class="row" style="margin-top: 60px;">
    <div class="col-8">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#patient" role="tab">Patient</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#company" role="tab">Company</a>
            </li>
        </ul>
        <div class="tab-content" style="margin-top: 30px;">
            <div class="tab-pane fade show active" id="patient" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Patient Result Table</h4>
                        <table class="table table-sm table-hover" id="sales-table">
                            <thead>
                                <tr>
                                    <th>Case #</th>
                                    <th>First</th>
                                    <th>Last</th>
                                    <th>Date Time</th>
                                    <th>Printable</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."patient.php";
                                    $patient = new Patient();
                                    
                                    $patientInfo = $patient->getSalesPatient();
                                    $infoList = ['lab_code', 'first', 'last', 'datetime', 'print', 'id', 'patient_id'];
                                    
                                    foreach ($patientInfo as $row)
                                    {
                                        
                                        echo "<tr>";
                                        foreach($infoList as $info)
                                        {
                                            echo "<td>".$row[$info]."</td>";
                                        }
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="company" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Company Result Table</h4>
                        <table class="table table-sm table-hover" id="company-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Date Time</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."company.php";
                                    $company = new Company();

                                    $companyInfo = $company->getCompanies1();
                                    $infoList = ['company_id', 'name', 'address', 'datetime', 'id', 'prnt'];
                                    foreach ($companyInfo as $row)
                                    {
                                        echo "<tr>";
                                        foreach($infoList as $info)
                                        {
                                            echo "<td>".$row[$info]."</td>";
                                        }
                                        $companyCount = $company->countCompanyPatient1($row['id']);
                                        echo '<td>'.$companyCount['total'].'</td>';
                                        echo "</tr>";
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="card d-none" id="cpt">
                    <div class="card-body">
                        <h4 class="card-title">Company Employees</h4>
                        <table class="table table-sm table-hover" id="company-patient-table">
                            <thead>
                                <tr>
                                    <th>Case #</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date Time</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Billing Summary</h3>
                <hr>
                <div class="form-group d-none medservices">
                    <label>Medical Services</label>
                    <select multiple class="form-control" name="services[]" id="services" disabled>
                        <?php
                            include_once $root."services.php";
                            $service = new Services();
                            $services = $service->getServices("WHERE active = 1");

                            foreach ($services as $row)
                            {
                                echo "<option value=".$row['id']." data-price='".$row['price']."'>".$row['type']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="company_result_id" value="">
                <input type="hidden" name="patient_id" value="">
                <input type="hidden" name="result_id" value="">
                <input type="hidden" name="lab_code" value="">
                <hr class="d-none medservices">
                <h5 id="lab_code"></h5>
                <hr> 
                <div class="row pt-2">
                    <div class="col text-left" id="service-name">
                    </div>
                    <div class="col text-right" id="service-price">
                    </div>
                </div>
                <hr>
                <div class="row pt-2">
                    <div class="col text-left">
                        <p><strong>Total Bill</strong></p>
                        <p><strong class="phide d-none">Total Bill (per patient)</strong></p>
                    </div>
                    <div class="col-3 text-right">
                        <p><input type="text" class="form-control form-control-sm text-right" id="total" name="total" readonly="readonly"> </p>
                        <p><input type="text" class="form-control form-control-sm text-right d-none phide" id="ptotal" name="ptotal" readonly="readonly"> </p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="misc/js/sales.js"></script>