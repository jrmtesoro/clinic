<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";

    include_once $root."/question.php";
    include_once $root."/employee.php";

    $employee_id = $_SESSION['employee_id'];

    $question = new Question();
    $employee = new Employee();

    $questionList = $question->getQuestions("WHERE active = 1");
    $employeeQuestion = $question->getEmployeeQuestion($employee_id);
    $employeeInfo = $employee->getEmployee($employee_id);
?>

<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col">
        <h1>Edit Profile</h1>
    </div>
    <div class="offset-3 col">
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="edit-profile">Update</button>
    </div>
</div>
<div class="row" style="padding-top: 50px;">
    <div class="col">
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#userInformation">
                        User Information
                    </button>
                </h5>
            </div>
            <div id="userInformation" class="collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="offset-1 col-5">
                            <div class="d-flex flex-column">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" tabIndex="7" value="<?php echo $employeeInfo['user']; ?>" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="pass" name="pass" class="form-control" tabIndex="8" value="">
                                    <div class="invalid-feedback" id="passError"></div>
                                </div>
                                <div class="form-group">
                                    <label>Re-type password</label>
                                    <input type="password" id="pass1" name="pass1" class="form-control" tabIndex="9" value="">
                                    <div class="invalid-feedback" id="passError1"></div>
                                </div>             
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex flex-column"> 
                                <div class="form-group">
                                    <label>Secret Question</label>
                                    <select class="form-control" name="secret_question">
                                        <option value="<?php echo $employeeQuestion['id']; ?>"><?php echo $employeeQuestion['question']; ?></option>
                                        <?php
                                            foreach ($questionList as $q)
                                            {
                                                if ($q['question'] != $employeeQuestion['question'])
                                                {
                                                    echo "<option value=".$q['id'].">".$q['question']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Secret Answer</label>
                                    <input type="text" class="form-control" name="secret_answer" tabIndex="10" value="">
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#personalInformation">
                        Personal Information
                    </button>
                </h5>
            </div>
            <div id="personalInformation" class="collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="offset-1 col-3">
                            <div class="d-flex flex-column">
                                <strong class="mt-1">Change Profile Picture</strong>   
                                <input type="file" name="img" class="form-control-file mt-2 mb-2" accept=".jpg,.jpeg,.png"> 
                                <img id="img" src="/clinic1/uploads/employee/<?php echo $employeeInfo['img_name']; ?>" alt="File Not Found.." class="thumbnail img-fluid">
                            </div>
                        </div>
                        <div class="offset-1 col-5">
                            <div class="d-flex flex-column">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" <?php echo $onlyAlphabets; ?> name="first" tabIndex="1" value="<?php echo $employeeInfo['first']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" class="form-control" <?php echo $onlyAlphabets; ?> name="mid" tabIndex="2" value="<?php echo $employeeInfo['mid']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" <?php echo $onlyAlphabets; ?> name="last" tabIndex="3" value="<?php echo $employeeInfo['last']; ?>">
                                </div>  
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" rows="3" name="address" style="resize: none;" tabIndex="4"><?php echo $employeeInfo['address']; ?></textarea>
                                </div> 
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" id="email" placeholder="email@gmail.com" name="email" tabIndex="5" value="<?php echo $employeeInfo['email']; ?>">
                                            <div class="invalid-feedback" id="emailError"></div>
                                        </div>  
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Contact Number</label>
                                            <input type="text" class="form-control" maxlength="11" <?php echo $onlyDigit; ?> name="contact_number" tabIndex="6" value="<?php echo $employeeInfo['contact_number']; ?>">
                                            <div class="invalid-feedback" id="num_error"></div>
                                        </div>  
                                    </div>
                                </div>                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="misc/js/edit-profile.js"></script>