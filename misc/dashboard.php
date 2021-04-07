<?php
    include $_SERVER['DOCUMENT_ROOT']."/clinic/includes/chart.php";
    $chart = new Chart();

    $totalResults = $chart->totalResults("0");
    $totalSales = $chart->totalSales();
    $total = 0;
    if ($totalSales['total_sales'] != null)
    {
        $total = $totalSales['total_sales'];
    }
?>

<div class="row w-100 border-bottom" style="margin-left: -25px; margin-top: -50px; background-color: white; position: fixed; z-index: 1010;">
    <div class="col-2">
        <h1>Dashboard</h1>
    </div>
    <div class="offset-6 col-3 my-auto">
        <div class="form-group row my-auto">
            <img src="/clinic/svg/si-glyph-chart-column.svg" class="my-auto" height="20" width="20">
            <strong class="col-sm-2 col-form-label">Sort</strong>
            <div class="col-sm-5">
                <select class="form-control" id="sort">
                    <option value="month">By Month</option>
                    <option value="week">Last 7 days</option>
                </select>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/clinic/js/Chart.js"></script>
<div class="row" style="margin-top: 30px;">
    <div class="col">
        <div class="card">
            <div class="card-header text-center">Statistics Today</div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col text-center">
                        <div class="d-flex flex-column">
                            <small>Total Results Produced</small>
                            <p class="font-weight-bold"><?php echo $totalResults['total_result'] ?></p>
                        </div>
                    </div>
                    <div class="col">
                    <div class="col text-center">
                        <div class="d-flex flex-column">
                            <small>Pending Results</small>
                            <a class="font-weight-bold" href="index.php?do=result"><?php echo $result_count['pending'] ?></a>
                        </div>
                    </div>
                    </div>
                    <div class="col">
                        <div class="col text-center">
                            <div class="d-flex flex-column">
                                <small>Total Sales</small>
                                <p class="font-weight-bold"><?php echo $total ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pt-2">
    <div class="col-6">
        <div class="card">
            <div class="card-body" id="clickme" data-toggle="popover" title="Clickable!" data-content="Click the bars to see the patient list!">
                <canvas id="chartjs" class="chartjs">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <canvas id="chartjs1" class="chartjs">
            </div>
        </div>
    </div>
</div>
<hr>
<div class="card d-none" id="table">
    <div class="card-header">
        <h5 class="mb-0 text-center">
            <button class="btn btn-link" type="button" id="btnTable" data-toggle="collapse" data-target="#table3">
                
            </button>
        </h5>
    </div>
    <div id="table3" class="collapse">
        <div class="card-body">
            <div class="row">
                <div class="col-7">
                    <table class="table table-sm table-hover border text-center" id="table1">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                            </tr>
                        </thead>
                        <tbody id="table2">
                        </tbody>
                    </table>
                    <hr> 
                </div> 
                <div class="col-5"> 
                    <canvas id="chartjs2" class="chartjs">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/clinic/js/jquery.min.js"></script>
<script type="text/javascript" src="/clinic1/js/popper.js"></script>
<script src="/clinic/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/clinic1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/clinic1/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="/clinic1/js/moment.js"></script>
<script type="text/javascript" src="js/chart.js"></script>