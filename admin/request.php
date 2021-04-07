<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Request</h1>
    </div>
    <div class="offset-4 col">
    </div>
    <div class="col my-auto">
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<div class="row" style="margin-top: 60px;">
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
        <nav>
            <div class="nav nav-tabs" role="tablist">
                <a class="nav-item nav-link active" data-toggle="tab" href="#request_pending" role="tab">Pending</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#request_accepted" role="tab">Accepted</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#request_declined" role="tab">Declined</a>
            </div>
        </nav>
        <div class="tab-content" style="padding-top: 20px;">
            <div class="tab-pane fade show active" id="request_pending" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Request List</h4>
                                <table class="table table-sm table-hover" id="request-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Case #</th>
                                            <th>Reason</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once $root."request.php";
                                            $request = new Request();

                                            $requestInfo = $request->getRequests("1");
                                            $infoList = ['id', 'result_lab_code', 'reason', 'datetime'];

                                            foreach ($requestInfo as $row)
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
            </div>
            <div class="tab-pane fade" id="request_accepted" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Request List</h4>
                                <table class="table table-sm table-hover" id="request-table1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Case #</th>
                                            <th>Reason</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once $root."request.php";
                                            $request = new Request();

                                            $requestInfo = $request->getRequests("2");
                                            $infoList = ['id', 'result_lab_code', 'reason', 'datetime'];

                                            foreach ($requestInfo as $row)
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
            </div>
            <div class="tab-pane fade" id="request_declined" role="tabpanel">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Request List</h4>
                                <table class="table table-sm table-hover" id="request-table2">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Case #</th>
                                            <th>Reason</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once $root."request.php";
                                            $request = new Request();

                                            $requestInfo = $request->getRequests("0");
                                            $infoList = ['id', 'result_lab_code', 'reason', 'datetime'];

                                            foreach ($requestInfo as $row)
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
            </div>
        </div>
    </div>   
</div>
<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="modal fade" id="request-info-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Request ID:</strong>
                    </div>
                    <div class="col" id="request_id">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>By:</strong>
                    </div>
                    <div class="col" id="request_by">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Case #:</strong>
                    </div>
                    <div class="col" id="request_case">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Reason:</strong>
                    </div>
                    <div class="col" id="request_reason">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Changes:</strong>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column" id="request_changes">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" name="tag" value="decline-request">Decline</button>
                <button type="submit" class="btn btn-primary" name="tag" value="accept-request">Accept</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="request_id" value="">
</form>

<div class="modal fade" id="request-info-modal1" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Request ID:</strong>
                    </div>
                    <div class="col" id="request_id1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>By:</strong>
                    </div>
                    <div class="col" id="request_by1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Case #:</strong>
                    </div>
                    <div class="col" id="request_case1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Reason:</strong>
                    </div>
                    <div class="col" id="request_reason1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Changes:</strong>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column" id="request_changes1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="admin/js/request.js"></script>
