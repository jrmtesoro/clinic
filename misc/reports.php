<form method="post" class="d-inline" enctype="multipart/form-data">
<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Reports</h1>
    </div>
    <div class="offset-4 col">
    </div>
    <div class="col my-auto">
    </div>
</div>
<link rel="stylesheet" type="text/css" href="css/buttons.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/daterangepicker.css">
<div class="row" style="margin-top: 60px;">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter</h5>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label>Table</label>
                            <select class="form-control" id="reports_selector">
                                <option value="b">Billing</option>
                                <option value="p">Patient</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Option</label>
                            <select class="form-control" id="reports_option">
                                <option value="sd">Specific Date</option>
                                <option value="m">Month</option>
                                <option value="y">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Do</label>
                            <select class="form-control" id="reports_option1">
                                <option value="info">Information</option>
                                <option value="total">Total</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Date</label>
                            <input class="form-control dates" id="bsd">
                            <input class="form-control d-none dates" id="bm">
                            <input class="form-control d-none dates" id="by">
                            <input class="form-control d-none dates" id="psd">
                            <input class="form-control d-none dates" id="pm">
                            <input class="form-control d-none dates" id="py">
                            <input class="form-control d-none dates" id="rsd">
                            <input class="form-control d-none dates" id="rm">
                            <input class="form-control d-none dates" id="ry">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="card-title"></h4>
                <table class="table table-sm table-hover" id="report-table">
                    <thead>
                        <tr id="columns">
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="ft">
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.select.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="js/jszip.min.js"></script>
<script type="text/javascript" src="js/pdfmake.min.js"></script>
<script type="text/javascript" src="js/vfs_fonts.js"></script>
<script type="text/javascript" src="js/buttons.html5.min.js"></script>
<script type="text/javascript" src="js/buttons.print.min.js"></script>
<script type="text/javascript" src="js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="js/knockout.js"></script>
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>
<script type="text/javascript" src="misc/js/reports.js"></script>