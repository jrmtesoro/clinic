<div class="results" id="xray">
<h2>X-Ray<span class="float-right" id="xray_lab_code"></span></h2>
<hr>
<div class="row">
    <div class="col-6">
        <div class="d-flex flex-column">
            <label class="font-weight-bold">Examination</label>
            <select class="form-control" name="examination" tabIndex="36">
                <?php
                    include_once $root."exam.php";
                    $exam = new Exam();

                    $exams = $exam->getExams("WHERE active = 1 ORDER BY name ASC");
                    foreach ($exams as $ex)
                    {
                        echo "<option value='".$ex['id']."'>".$ex['name']."</option>";
                    }
                ?>
            </select>
            <label class="font-weight-bold">Impression</label>
            <textarea class="form-control" rows="3" name="impression" style="resize: none;" tabIndex="37"></textarea>
        </div>
    </div>
    <div class="col-6">
        <div class="d-flex flex-column">
            <label class="font-weight-bold">Observation</label>
            <textarea class="form-control" rows="6" name="observation" style="resize: none;" tabIndex="38"></textarea>
        </div>
    </div>
</div>
</div>

