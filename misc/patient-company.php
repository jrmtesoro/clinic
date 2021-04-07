<?php
$onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
$onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-5">
        <h1>Patient Batch</h1>
    </div>
    <div class="offset-1 col">
    </div>
    <div class="col my-auto">
        <form method="post" class="d-inline">
        <button type="submit" class="btn btn-primary" name="tag" value="patient-company">Next</button>
        <input type="hidden" name="c_id" value="">
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<div class="alert mt-5 d-none" role="alert" id="alert">
    <button type="button" id="alert-times" class="close float-right">
        <span>&times;</span>
    </button>
    <strong id="alert-content"></strong>
</div>
<form method="post" class="d-inline" enctype="multipart/form-data">
<?php
    if (isset($_POST['tag']) && $_POST['tag'] != "")
    {
        $alert = new Alert();
        if ($response['success'] == 1)
        {
            $alert->displaySuccess($response['msg']);
        }
        else if ($response['error'] == 1)
        {
            $alert->displayError($response['msg']);
        }
    }
?>
<div class="row" style="margin-top: 60px;">
    <div class="col-12" id="table-col">
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Company Table</h4>
                    <table class="table table-sm table-hover" id="patient-company-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company Name</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include_once $root."company.php";
                                $company = new Company();

                                $companyInfo = $company->getCompanies("WHERE queue = 0 AND active = 1");
                                $infoList = ['id', 'name', 'address'];
                                
                                foreach ($companyInfo as $row)
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
            <hr>
            <div class="card d-none" id="compat">
                <div class="card-body">
                    <h4 class="card-title">Company Employees Table</h4>
                    <table class="table table-sm table-hover" id="company-patient-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <hr> 
    </div> 
    <div class="col-5 d-none" id="side-bar">
        <div class="card">
            <div class="card-body">
                <button type="button" class="close float-right" id="close-btn">
                    <span>&times;</span>
                </button>
                <div class="d-none" id="company">
                <form method="post" class="d-inline" enctype="multipart/form-data">
                    <h3 class="text-center">Company Details</h3>
                    <hr>
                    <div class="d-flex flex-column">
                        <div class="form-group d-none" id="company_id">
                            <label>ID</label>
                            <input type="text" class="form-control" name="company_id" value="" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="company_name" tabIndex="1" value="">
                        </div>
                        <div class="form-group existing-hide">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="company_address" style="resize: none;" tabIndex="4"></textarea>
                        </div> 
                        <button type="submit" class="btn btn-primary btn-block" name="tag" value="company">Add</button>
                    </div>
                </form>
                </div>
                <div class="d-none" id="patient">
                    <h3 class="text-center">Patient Details</h3>
                    <hr>
                    <center><img src="/clinic1/img/user.png" id="img" alt="File Not Found.." height=250></center>
                    <div class="d-flex flex-column">
                    <form method="post" class="d-inline" enctype="multipart/form-data" id="patient_form">
                        <input type="file" name="img" class="form-control-file" accept=".jpg,.jpeg,.png" required>
                        <div class="form-group">
                        <label>First Name</label>
                            <input type="text" class="form-control" name="first" <?php echo $onlyAlphabets; ?> tabIndex="1">
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" name="mid" <?php echo $onlyAlphabets; ?> tabIndex="2">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last" <?php echo $onlyAlphabets; ?> tabIndex="3">
                        </div> 
                        <div class="form-group existing-hide">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="address" style="resize: none;" tabIndex="4"></textarea>
                        </div> 
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender" tabIndex="5">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control" <?php echo $onlyDigit; ?> name="age" tabIndex="6">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" <?php echo $onlyDigit; ?> name="contact_number" tabIndex="7">
                        </div> 
                        <button type="submit" class="btn btn-primary btn-block mb-5" name="tag" value="add-company-patient">Add</button>
                    </form>
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="existing-patient-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Existing Patients</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Existing Patient Table</h4>
                        <table class="table table-sm table-hover" id="existing-patient-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" name="add-existing-patient">Add Patient</button>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="misc/js/patient-company.js"></script>