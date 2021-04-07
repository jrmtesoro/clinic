<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";

    if (isset($_GET['id']) && $_GET['id'] != "")
    {
        $id = $_GET['id'];
        include_once $root."patient.php";
        include_once $root."company.php";
        $company = new Company();
        $companyInfo = $company->countCompanyPatient($id);
        $patient_count = $companyInfo['total'];
        if ($patient_count == 0)
        {
            Header("Location: index.php?do=patient-company");
        }
        
        $companyInfo = $company->getCompany($id);
    }
    else
    {
        Header("Location: index.php?do=patient-company");
    }
?>
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-3">
        <h1>Patient Batch</h1>
    </div>
    <div class="offset-2 col">
    </div>
    <div class="col my-auto">
        <a class="btn btn-primary my-auto" href="index.php?do=patient-company">Back</a>
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="patient-company-1">Next</button>
    </div>
</div>
<?php
    if (isset($_POST['tag']) && $_POST['tag'] != "")
    {
        if ($response['error'] == 1)
        {
            $alert = new Alert();
            $alert->displayError($response['msg']);
        }
    }
?>
<div class="row" style="padding-top: 40px;">
    <div class="offset col-6">
        <div class="d-flex flex-column">
            <h1><?php echo $companyInfo['name']; ?></h1>
            <h5><?php echo $companyInfo['address']; ?></h5>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Company Employees Table</h4>
                    <table class="table table-sm table-hover" id="patient-company-1-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $company_patients = $company->getCompanyPatients($id);
                                $infoList = ['id', 'first', 'last'];
                                foreach ($company_patients as $patient)
                                {
                                    echo "<tr>";
                                    foreach ($infoList as $col)
                                    {
                                        echo "<td>".$patient[$col]."</td>";
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" name="company_id" value="<?php echo $id; ?>">
        <input type="hidden" name="patient_count" value="<?php echo $patient_count; ?>">
        <hr>
        <div class="form-group">
            <label>Pick Medical Service</label>
            <select multiple class="form-control" name="services[]" id="services">
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
    </div>
    <div class="col-5">
        <h3>Billing Summary</h3>
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
                <p><strong>Total Bill (company)</strong></p>
                <p><strong>Total Bill (per patient)</strong></p>
            </div>
            <div class="col-3 text-right">
                <p><input type="text" class="form-control form-control-sm text-right" id="total_company" name="total_company" readonly="readonly"> </p>
                <p><input type="text" class="form-control form-control-sm text-right" id="total" name="total" readonly="readonly"> </p>
            </div>
        </div>
    </div>
</div>
</form>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="misc/js/patient-company-1.js"></script>