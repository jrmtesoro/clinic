<?php
$onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
$onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>
<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Patient</h1>
    </div>
    <div class="offset-4 col">
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="edit-patient">Update</button>
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
            $alert->displaySuccess($response['msg']);
        }
        else if ($response['error'] == 1)
        {
            $alert->displayError($response['msg']);
        }
    }

?>
<div class="row" style="margin-top: 60px;">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Patient List</h4>
                <table class="table table-sm table-hover" id="edit-patient-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First</th>
                            <th>Middle</th>
                            <th>Last</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Date Registered</th>
                            <th>Image Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once $root."patient.php";
                            $patient = new Patient();

                            $patientInfo = $patient->getPatients("");
                            $infoList = ['id', 'first', 'mid', 'last', 'age', 'gender', 'address', 'contact_number', 'date_registered', 'img_name'];
                            
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
        <hr>
    </div>   
</div>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Patient Information</h4>
        <div class="row">
            <div class="offset-1 col-5">
                <div class="d-flex flex-column">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Patient ID</label>
                            <input type="text" class="form-control" name="id" readonly="readonly">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Date Registered</label>
                            <input type="text" class="form-control" name="date_registered" tabIndex="4" disabled>
                        </div> 
                    </div>
                </div> 
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="first" <?php echo $onlyAlphabets; ?> tabIndex="1" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="mid" <?php echo $onlyAlphabets; ?> tabIndex="2" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="last" <?php echo $onlyAlphabets; ?> tabIndex="3" required>
                    </div>               
                </div>
            </div>
            <div class="offset-1 col-3">
                <div class="d-flex flex-column">
                    <img src="/clinic1/img/user.png" id="img_name" alt="File Not Found.." class="thumbnail img-fluid">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-5">
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="3" name="address" style="resize: none;" tabIndex="4" required></textarea>
                </div> 
            </div>
            <div class="offset-1 col-5">
                <strong>Select Patient Image</strong>
                <input type="file" name="img" class="form-control-file my-auto" accept=".jpg,.jpeg"> 
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-5">
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
                        <input type="text" class="form-control" <?php echo $onlyDigit; ?> name="age" tabIndex="6" value="">
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" class="form-control" <?php echo $onlyDigit; ?> name="contact_number" tabIndex="7" value="" required>
                </div>  
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
<script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="misc/js/edit-patient.js"></script>