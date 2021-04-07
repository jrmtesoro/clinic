<div class="results" id="urinalysis">
<h2>Urinalysis <span class="float-right" id="urinalysis_lab_code"></span></h2>
<hr>
<div class="row border text-center pt-2 pb-2">
    <div class="col border-right">
        <strong>PARAMETER/TEST</strong>
    </div>
    <div class="col border-right">
        <strong>RESULT</strong>
    </div>
    <div class="col border-right">
        <strong>NORMAL/VALUES*</strong>
    </div>
    <div class="col border-right">
    </div>
    <div class="col border-right">
        <strong>RESULT</strong>
    </div>
    <div class="col">
        <strong>NORMAL/VALUES*</strong>
    </div>
</div>

<div class="row border text-center py-2">
    <div class="col border-right">
        <strong>PHYSICAL EXAMINATION</strong>
    </div>
    <div class="col border-right">
        <strong>MICROSCOPIC EXAMINATION</strong>
    </div>
</div>

<div class="row border text-center">
    <div class="col py-2">
        <strong>Color</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="color" class="form-control text-center" <?php echo $onlyAlphabets; ?> tabIndex="1" value="">
    </div>
    <div class="col border-right my-auto">
        <small>yellow</small>
    </div>
    <div class="col my-auto">
        <strong>RBC</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="rbc" class="form-control text-center"  <?php echo $onlyDecimal; ?> tabIndex="7" value="">
    </div>
    <div class="col my-auto">
        M: 0-2/HPF
        F: 0-5/HPF
    </div>
</div>

<div class="row border text-center">
    <div class="col py-2">
        <strong>Transparency</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="transparency" class="form-control text-center" <?php echo $onlyAlphabets; ?> tabIndex="2" value="">
    </div>
    <div class="col border-right my-auto">
        <small>clear</small>
    </div>
    <div class="col my-auto">
        <strong>WBC</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="wbc" class="form-control text-center"  <?php echo $onlyDecimal; ?> tabIndex="8" value="">
    </div>
    <div class="col my-auto">
        M: 0-2/HPF
        F: 0-5/HPF
    </div>
</div>

<div class="row border text-center">
    <div class="col-6 border-right my-auto">
        <strong>CHEMICAL EXAMINATION</strong>
    </div>
    <div class="col my-auto">
        <strong>Epithelial Cells</strong>
    </div>
    <div class="col border-right border-left">
        <select class="form-control" name="e_c" tabIndex="9">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
    <div class="col">
        
    </div>
</div>

<div class="row border text-center">
    <div class="col py-2">
        <strong>pH(Reaction)</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="ph_reaction" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="3" value="">
    </div>
    <div class="col border-right my-auto">
        <small>4.8 - 7.8</small>
    </div>
    <div class="col my-auto">
        <strong>Amorphous Urates</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <select class="form-control" name="a_u" tabIndex="10">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
    <div class="col my-auto">
    </div>
</div>      

<div class="row border text-center">
    <div class="col py-2">
        <strong>Specific Gravity</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="specific_gravity" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="4" value="">
    </div>
    <div class="col border-right my-auto">
        <small>1.015 - 1.025</small>
    </div>
    <div class="col my-auto">
        <strong>Bacteria</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <select class="form-control" name="bacteria" tabIndex="11">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
    <div class="col my-auto">
    </div>
</div> 

<div class="row border text-center">
    <div class="col py-2">
        <strong>Glucose</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <select class="form-control" name="glucose" tabIndex="5">
            <option>Negative</option>
            <option>Trace</option>
            <option>+</option>
            <option>++</option>
            <option>+++</option>
            <option>++++</option>
        </select>
    </div>
    <div class="col border-right my-auto">
        <small>Negative</small>
    </div>
    <div class="col my-auto">
        <strong>Mucus Threads</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <select class="form-control" name="mucus_threads" tabIndex="12">
            <option>None</option>
            <option>Rare</option>
            <option>Few</option>
            <option>Moderate</option>
            <option>Many</option>
            <option>Abundant</option>
        </select>
    </div>
    <div class="col my-auto">
    </div>
</div>

<div class="row border text-center">
    <div class="col py-2">
        <strong>Protein (Albumin)</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <select class="form-control" name="protein" tabIndex="6">
            <option>Negative</option>
            <option>Trace</option>
            <option>+</option>
            <option>++</option>
            <option>+++</option>
            <option>++++</option>
        </select>
    </div>
    <div class="col border-right my-auto">
        <small>Negative</small>
    </div>
    <div class="col my-auto">
        <strong>Others</strong>
    </div>
    <div class="col-4 border-left border-right my-auto">
        <input type="text" name="others" class="form-control text-center" tabIndex="14" value="">
    </div>
</div>
</div>