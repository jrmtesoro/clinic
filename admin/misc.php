<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";
?>

<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-3">
        <h1>Miscellaneous</h1>
    </div>
    <div class="offset-2 col my-auto">
    </div>
    <div class="col my-auto">
        <button class="btn btn-primary my-auto" type="submit" id="tag" name="tag" value="question">Update</button>
        <button class="btn btn-danger my-auto" type="submit" id="tag1" name="tag" value="">Remove</button>
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
<div class="row" style="padding-top: 40px;">
    <div class="col">
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link active" data-toggle="tab" href="#secret_question" role="tab">Secret Question</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#service" role="tab">Services</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#xray" role="tab">X-Ray</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#permission" role="tab">Permission</a>
            </div>
        </nav>
        <div class="tab-content" style="padding-top: 20px;">
            <div class="tab-pane fade show active" id="secret_question" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-hover" id="question-table">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."question.php";
                                    $services = new Question();

                                    $serviceList = $services->getQuestions("WHERE active = 1");
                                    $infoList = ['question', 'id'];

                                    foreach ($serviceList as $row)
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
                        <hr> 
                    </div>   
                </div>
                <div class="row">
                    <div class="offset-2 col-2">
                        <div class="form-group">
                            <label>Question ID</label>
                            <input type="text" class="form-control" name="question_id" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question" tabIndex="1" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="service" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-hover" id="services-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."services.php";
                                    $services = new Services();

                                    $serviceList = $services->getServices("WHERE active = 1");
                                    $infoList = ['type', 'price', 'id', 'code'];

                                    foreach ($serviceList as $row)
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
                        <hr> 
                    </div>   
                </div>
                <div class="row">
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="code" value="">
                    <div class="offset-2 col-4">
                        <div class="form-group">
                            <label>Service Type</label>
                            <input type="text" class="form-control" name="type" tabIndex="1" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Service Price</label>
                            <input type="text" class="form-control" name="price" <?php echo $onlyDigit; ?> tabIndex="2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="xray" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-hover" id="exam-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."exam.php";
                                    $exam = new Exam();

                                    $examList = $exam->getExams("WHERE active = 1");
                                    $infoList = ['id', 'name'];

                                    foreach ($examList as $row)
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
                        <hr> 
                    </div>   
                </div>
                <div class="row">
                    <div class="offset-3 col-2">
                        <div class="form-group">
                            <label>Exam ID</label>
                            <input type="text" class="form-control" name="eId" tabIndex="1" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Exam Name</label>
                            <input type="text" class="form-control" name="eName" <?php echo $onlyAlphabets; ?> tabIndex="2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="permission" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-hover" id="permission-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include_once $root."permission.php";
                                    $permission = new Permission();

                                    $permissionList = $permission->getPermissions("");
                                    $infoList = ['id', 'name', 'description'];

                                    foreach ($permissionList as $row)
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
                        <hr> 
                    </div>   
                </div>
                <div class="row">
                    <div class="offset-3 col-2">
                        <div class="form-group">
                            <label>Permission ID</label>
                            <input type="text" class="form-control" name="pId" tabIndex="1" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Permission Name</label>
                            <input type="text" class="form-control" name="pName" <?php echo $onlyAlphabets; ?> tabIndex="2">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-3 col-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="3" name="description" style="resize: none;" tabIndex="4"></textarea>
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
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="admin/js/misc.js"></script>