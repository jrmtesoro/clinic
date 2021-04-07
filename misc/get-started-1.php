<?php
    $onlyAlphabets = "onkeypress='return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123 || event.charCode == 32)'";
    $onlyDigit = "onkeypress='return !(event.charCode > 31 && event.charCode < 48 || event.charCode > 57)'";

    if (isset($_GET['id']) && $_GET['id'] != "")
    {
        $id = $_GET['id'];
        include_once $root."patient.php";
        $patient = new Patient();

        $patientInfo = $patient->getPatient($id);
        if (!$patientInfo)
        {
            Header("Location: index.php?do=get-started");
        }
    }
    else
    {
        Header("Location: index.php?do=get-started");
    }
?>

<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-3">
        <h1>Get Started</h1>
    </div>
    <div class="offset-1 col">
    </div>
    <div class="col my-auto">
        <a class="btn btn-primary my-auto" href="index.php?do=get-started">Back</a>
        <button class="btn btn-primary my-auto" type="submit" name="tag" value="get-started-1">Next</button>
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
    <div class="offset-1 col-5">
        <h4>Patient ID : <?php echo $_GET['id']; ?></h4>
        <hr> 
        <h4><?php echo $patientInfo['first']." ".$patientInfo['last']; ?></h4>
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
                <p><strong>Total Bill</strong></p>
                <p><strong>Payment</strong></p>
                <p><strong>Change</strong></p>
            </div>
            <div class="col-3 text-right">
                <p><input type="text" class="form-control form-control-sm text-right" id="total" name="total" readonly="readonly"> </p>
                <p><input type="text" class="form-control form-control-sm text-right" id="pay" name="pay" <?php echo $onlyDigit; ?> tabIndex="1"></p>
                <p id="change">0.00</p>
            </div>
        </div>
    </div>
</div>
</form>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="misc/js/get-started-1.js"></script>