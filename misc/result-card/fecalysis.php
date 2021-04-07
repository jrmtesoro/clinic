<div class="results" id="fecalysis">
<h2>Fecalysis<span class="float-right" id="fecalysis_lab_code"></span></h2>
<hr>
<div class="row border text-center">
    <div class="col border-right">
        <strong>MACROSCOPIC</strong>
    </div>
    <div class="col border-right">
        <strong>RESULTS</strong>
    </div>
    <div class="col border-right">
        <strong>MICROSCOPIC</strong>
    </div>
    <div class="col border-right">
        <strong>RESULTS</strong>
    </div>
</div>
<div class="row border text-center">
    <div class="col border-right my-auto">
        <strong>Color</strong>
    </div>
    <div class="col border-right">
        <input type="text" name="color1" class="form-control text-center" <?php echo $onlyAlphabets; ?> tabIndex="28" value="">
    </div>
    <div class="col border-right my-auto">
        <strong>RBC</strong>
    </div>
    <div class="col border-right">
        <input type="text" name="rbc1" class="form-control text-center decimal" tabIndex="30" value="">
    </div>
</div>

<div class="row border text-center">
    <div class="col border-right my-auto">
        <strong>Consistency</strong>
    </div>
    <div class="col border-right">
        <input type="text" name="consistency" class="form-control text-center" <?php echo $onlyAlphabets; ?> tabIndex="29" value="">
    </div>
    <div class="col border-right my-auto">
        <strong>PUS CELLS</strong>
    </div>
    <div class="col border-right">
        <input type="text" name="pus_cells" class="form-control text-center decimal" tabIndex="31" value="">
    </div>
</div>

<div class="row border text-center">
    <div class="offset-6 col-3 my-auto border-left">
        <strong>BACTERIA</strong>
    </div>
    <div class="col-3 border-right border-bottom">
        <select class="form-control" name="bacteria1" tabIndex="32">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
</div>

<div class="row border text-center">
    <div class="offset-6 col-3 my-auto border-left">
        <strong>FAT GLOBULES</strong>
    </div>
    <div class="col-3 border-right border-bottom">
        <select class="form-control" name="fat_globules" tabIndex="33">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
</div>

<div class="row border text-center">
    <div class="offset-6 col-3 my-auto border-left">
        <strong>YEAST CELLS</strong>
    </div>
    <div class="col-3 border-right border-bottom">
        <select class="form-control" name="yeast_cells" tabIndex="34">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
</div>

<div class="row border text-center">
    <div class="offset-6 col-3 my-auto border-left">
        <strong>PARASITES</strong>
    </div>
    <div class="col-3 border-right border-bottom">
        <input type="text" name="parasites" class="form-control text-center" tabIndex="35" value="">
    </div>
</div>
</div>
