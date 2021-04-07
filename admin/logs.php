<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Logs</h1>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Log List</h4>
                <table class="table table-sm table-hover" id="logs-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Date Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once $root."logs.php";
                            $logs = new Logs();

                            $logsInfo = $logs->getLogs();
                            $infoList = ['id', 'action', 'datetime', 'identifier', 'identifier_id', 'employee_id'];

                            foreach ($logsInfo as $row)
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
<div class="modal fade" id="log-info-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="row1">
                <div class="row">
                    <div class="col-4 text-right">
                        <strong>Log ID:</strong>
                    </div>
                    <div class="col" id="log_id">
                    </div>
                </div>
                <div class="row" id="row2">
                    <div class="col-4 text-right">
                        <strong>By:</strong>
                    </div>
                    <div class="col" id="log_by">
                    </div>
                </div>
                <div class="row" id="row3">
                    <div class="col-4 text-right">
                        <strong>Type:</strong>
                    </div>
                    <div class="col" id="log_table">
                    </div>
                </div>
                <div class="row" id="row4">
                    <div class="col-4 text-right">
                        <strong id="log_affected_title"></strong>
                    </div>
                    <div class="col" id="log_affected">
                    </div>
                </div>
                <div class="row" id="row5">
                    <div class="col-4 text-right">
                        <strong>Action:</strong>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-column" id="log_action">
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
<script type="text/javascript" src="admin/js/logs.js"></script>