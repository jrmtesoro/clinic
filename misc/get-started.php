<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>

<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-3">
        <h1>Get Started</h1>
    </div>
    <div class="offset-1 col my-auto">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="patientOption" value="newPatient" checked="checked">
            <label class="form-check-label">New Patient</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="patientOption" value="existingPatient">
            <label class="form-check-label">Existing Patient</label>
        </div>
    </div>
    <div class="offset-2">
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="get-started">Next</button>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<?php
    if (isset($_POST['tag']) && $_POST['tag'] != "")
    {
        $alert = new Alert();
        $alert->displayError($response['msg']);
    }
?>
<div class="row d-none new-hide" style="padding-top: 40px;" id="new-hide-1">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Existing Patient Table</h4>
                <table class="table table-sm table-hover" id="get-started-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First</th>
                            <th>Middle</th>
                            <th>Last</th>
                            <th>Date Registered</th>
                            <th>img_name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once $root."patient.php";
                            $patient = new Patient();

                            $patientInfo = $patient->getPatients("WHERE queue = 0");
                            $infoList = ['id', 'first', 'mid', 'last', 'date_registered', 'img_name'];
                            
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
</div>
<hr>
<div class="card" style="margin-top: 40px; margin-bottom: 50px;">
    <div class="card-body">
        <h4 class="card-title">Patient Information</h4>
        <div class="row">
            <div class="offset-1 col-3">
                <div class="d-flex flex-column">
                    <input type="file" name="img" class="form-control-file my-auto existing-hide" accept=".jpg,.jpeg,.png" value="<?php echo (isset($response['data'])?$response['data']['img_name']:"") ?>" required> 
                    <img src="/clinic1/img/user.png" id="img" alt="File Not Found.." class="thumbnail img-fluid">
                </div>
            </div>
            <div class="offset-1 col-5">
                <div class="d-flex flex-column">
                    <div class="form-group d-none new-hide">
                        <label>Patient ID</label>
                        <input type="text" class="form-control" name="id" value="" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first" <?php echo $onlyAlphabets; ?> tabIndex="1" value="<?php echo (isset($response['data'])?$response['data']['first']:"") ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="mid" <?php echo $onlyAlphabets; ?> tabIndex="2" value="<?php echo (isset($response['data'])?$response['data']['mid']:"") ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last" <?php echo $onlyAlphabets; ?> tabIndex="3" value="<?php echo (isset($response['data'])?$response['data']['last']:"") ?>" required>
                    </div> 
                    <div class="form-group existing-hide">
                        <label>Address</label>
                        <textarea class="form-control" rows="3" name="address" style="resize: none;" tabIndex="4" required><?php echo (isset($response['data'])?$response['data']['address']:"") ?></textarea>
                    </div> 
                    <div class="form-group d-none" id="new-hide">
                        <label>Date Registered</label>
                        <input type="text" class="form-control" name="date_registered" tabIndex="4" disabled>
                    </div>                
                </div>
            </div>
        </div>
        <div class="row existing-hide">
            <div class="col-5">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Gender</label>
                            <select class="form-control" name="gender" tabIndex="5" required>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div> 
                    </div>
                    <div class="col">
                        <label>Age</label>
                        <input type="text" class="form-control"  maxlength="3" <?php echo $onlyDigit; ?> name="age" tabIndex="6" value="<?php echo (isset($response['data'])?$response['data']['age']:"") ?>" required>
                        <div class="invalid-feedback" id="age_error"></div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" class="form-control" maxlength="11" <?php echo $onlyDigit; ?> name="contact_number" tabIndex="7" value="<?php echo (isset($response['data'])?$response['data']['contact_number']:"") ?>" required>
                    <div class="invalid-feedback" id="num_error"></div>
                </div>  
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
<script type="text/javascript" src="misc/js/get-started.js"></script>