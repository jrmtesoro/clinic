<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>
<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-3">
        <h1>Employee</h1>
    </div>
    <div class="offset-1 col my-auto">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="employeeOption" value="newEmployee">
            <label class="form-check-label">New Employee</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="employeeOption" value="existingEmployee" checked="checked">
            <label class="form-check-label">Existing Employee</label>
        </div>
    </div>
    <div class="offset-2">
        
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="employee">Update</button>
    </div>
</div>
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
<div class="row new-hide" style="padding-top: 40px;">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Employee Table</h4>
                <table class="table table-sm table-hover" id="employee-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First</th>
                            <th>Middle</th>
                            <th>Last</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Job</th>
                            <th>Contact Number</th>
                            <th>Date Employed</th>
                            <th>Image</th>
                            <th>License</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once $root."employee.php";
                            $employee = new Employee();

                            $employeeInfo = $employee->getEmployees("");
                            $infoList = ['id', 'first', 'mid', 'last', 'address', 'email', 'job', 'contact_number', 'date_employed', 'img_name', 'license'];

                            foreach ($employeeInfo as $row)
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
<hr>
<div class="employee">
<div class="row">
    <div class="col">
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link active" data-toggle="tab" href="#pInfo" role="tab">Personal Information</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#aInfo" role="tab">Account Information</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#permission" role="tab">Permissions</a>
            </div>
        </nav>
        <div class="tab-content" style="padding-top: 50px;">
            <div class="tab-pane fade show active" id="pInfo" role="tabpanel">
                <div class="row">
                    <div class="offset-1 col-3">
                        <div class="d-flex flex-column"> 
                            <img src="/clinic1/img/user.png" id="img" alt="File Not Found.." class="thumbnail img-fluid">
                        </div>
                    </div>
                    <div class="offset-1 col-6">
                        <div class="d-flex flex-column">
                            <div class="row new-hide">
                                <div class="col">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control" name="id" readonly="readonly">
                                </div>
                                <div class="col">
                                    <label>Date Employed</label>
                                    <input type="text" class="form-control" name="date_employed" disabled>
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
                </div>
                <div class="row">
                    <div class="offset-1 col-4">
                        <div class="form-group">
                            <label>Employee Picture</label>
                            <input type="file" name="img" class="form-control-file my-auto" accept=".jpg,.jpeg,.png">
                        </div>  
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" rows="3" name="address" style="resize: none;" tabIndex="4" required></textarea>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="offset-1 col-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="example@gmail.com" tabIndex="5" value="" required>
                            <div class="invalid-feedback" id="emailError"></div>
                        </div>  
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control" maxlength="11" <?php echo $onlyDigit; ?> name="contact_number" tabIndex="6" value="" required>
                            <div class="invalid-feedback" id="num_error"></div>
                        </div>  
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Job</label>
                            <select class="form-control" name="job" tabIndex="7">
                                <option>Medical Technologist</option>
                                <option>Radiologist</option>
                                <option>Physician</option>
                                <option>Receptionist</option>
                            </select>
                        </div>  
                    </div>
                </div>
                <div class="row mb-4 pb-4">
                    <div class="offset-1 col-3">
                        <div class="form-group">
                            <label>License Number</label>
                            <input type="text" class="form-control" <?php echo $onlyDigit; ?> name="license" tabIndex="7" value=""> 
                        </div>  
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="aInfo" role="tabpanel">
                <div class="row new-account">
                    <div class="offset-1 col-5">
                        <div class="d-flex flex-column">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" tabIndex="8" value="" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="pass" name="pass" class="form-control" tabIndex="9" value="">
                                <div class="invalid-feedback" id="passError"></div>
                            </div>
                            <div class="form-group">
                                <label>Re-type password</label>
                                <input type="password" id="pass1" name="pass1" class="form-control" tabIndex="10" value="">
                                <div class="invalid-feedback" id="passError1"></div>
                            </div>             
                        </div>
                    </div>
                    <?php
                        include_once $root."question.php";
                        $question = new Question();
                        $questionList = $question->getQuestions("WHERE active = 1");
                    ?>
                    <div class="col-5">
                        <div class="d-flex flex-column"> 
                            <div class="form-group">
                                <label>Secret Question</label>
                                <select class="form-control" name="secret_question" tabIndex="11">
                                    <?php
                                        foreach ($questionList as $q)
                                        {
                                            echo "<option value='".$q['id']."'>".$q['question']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Secret Answer</label>
                                <input type="text" class="form-control" name="secret_answer" tabIndex="12" value="">
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="permission" role="tabpanel">
                <div class="row">
                    <div class="offset-1 col-5">
                        <div class="form-group">
                            <label>Permission List</label>
                            <select multiple class="form-control" size="10" name="permission[]" id="perm" required>
                                <?php
                                    include_once $root."permission.php";
                                    $permission = new Permission();

                                    $permissionList = $permission->getPermissions("");

                                    foreach ($permissionList as $perm)
                                    {
                                        echo "<option data-desc='".$perm['description']."' value=".$perm['id'].">".$perm['name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col" id="permission-desc">
                    </div>
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
<script type="text/javascript" src="admin/js/employee.js"></script>