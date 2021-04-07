<div class="results" id="hematology">
<h2>Hematology<span class="float-right" id="hematology_lab_code"></span></h2>
<hr>
<div class="row border text-center">
    <div class="col border-right my-auto">
        <strong>TEST</strong>
    </div>
    <div class="col border-right my-auto">
        <strong>REFERENCE (SI UNIT)</strong>
    </div>
    <div class="col border-right my-auto">
        <strong>RESULT</strong>
    </div>
    <div class="col border-right my-auto">
        <strong>TEST</strong>
    </div>
    <div class="col border-right my-auto">
        <strong>REFERENCE (SI UNIT)</strong>
    </div>
    <div class="col my-auto">
        <strong>RESULT</strong>
    </div>
</div>

<div class="row border border-top-0">
    <div class="col-2 my-auto text-center">
        <strong>Hemoglobin</strong>
    </div>
    <div class="col-2">
        <div class="d-flex flex-column text-center">
            <small class="py-2">M 140 - 180</small>
            <small class="py-2">F 140 - 180</small>
        </div>
    </div>
    <div class="col-2 border-right">
        <div class="d-flex flex-column">
            <input type="text" id="MaleHemoglobin" name="hemoglobin" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="15" value="" disabled>
            <input type="text" id="FemaleHemoglobin" name="hemoglobin" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="16" value="" disabled>
        </div>
    </div>
    <div class="col-6 text-center">
        <div class="d-flex flex-column">
            <strong class="pt-3 my-auto">Differential Count</strong>
            <div class="row border-top">
                <div class="col my-auto border-right">
                    <strong>Neutrophils</strong>
                </div>
                <div class="col my-auto border-right">
                    <small>0.40 - 0.75</small>
                </div>
                <div class="col my-auto">
                    <input type="text" name="neutrophils" class="form-control text-center decimal" tabIndex="21" value="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row border border-top-0">
    <div class="col-2 my-auto text-center">
        <strong>Hematocrit</strong>
    </div>
    <div class="col-2">
        <div class="d-flex flex-column text-center">
            <small class="py-2">M 0.40 - 0.54</small>
            <small class="py-2">F 0.37 - 0.47</small>
        </div>
    </div>
    <div class="col-2 border-right">
        <div class="d-flex flex-column">
            <input type="text" id="MaleHematocrit" name="hematocrit" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="17" value="" disabled>
            <input type="text" id="FemaleHematocrit" name="hematocrit" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="18" value="" disabled>
        </div>
    </div>
    <div class="col-6 text-center">
        <div class="d-flex flex-column">
            <div class="row border-top">
                <div class="col my-auto border-right">
                    <strong>Lymphocytes</strong>
                </div>
                <div class="col my-auto border-right">
                    <small>0.20 - 0.45</small>
                </div>
                <div class="col my-auto">
                    <input type="text" name="lymphocytes" class="form-control text-center decimal" tabIndex="22" value="">
                </div>
            </div>
            <div class="row border-top">
                <div class="col my-auto border-right">
                    <strong>Monocytes</strong>
                </div>
                <div class="col my-auto border-right">
                    <small>0.02 - 0.06</small>
                </div>
                <div class="col my-auto">
                    <input type="text" name="monocytes" class="form-control text-center decimal" tabIndex="23" value="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row border border-top-0 text-center">
    <div class="col py-2">
        <strong>WBC Count</strong>
    </div>
    <div class="col border-left my-auto">
        <small>5.0-10.0 X 10<sup>9</sup> / L</small>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="wbc_count" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="19" value="">
    </div>
    <div class="col my-auto">
        <strong>Eosinophils</strong>
    </div>
    <div class="col border-left my-auto">
        <small>0.01 - 0.04</small>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="eosinophils" class="form-control text-center decimal" tabIndex="24" value="">
    </div>
</div>

<div class="row border border-top-0 text-center">
    <div class="col py-2">
        <strong>Platelet Count</strong>
    </div>
    <div class="col border-left my-auto">
        <small>150 - 450 X 10<sup>9</sup> / L</small>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="platelet_count" class="form-control text-center" <?php echo $onlyDecimal; ?> tabIndex="20" value="">
    </div>
    <div class="col my-auto">
        <strong>Basophils</strong>
    </div>
    <div class="col border-left my-auto">
        <small>0.00 - 0.01</small>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="basophils" class="form-control text-center decimal" tabIndex="25" value="">
    </div>
</div>

<div class="row border border-top-0 text-center">
    <div class="border-left offset-6 col my-auto">
        <strong>Stab Cells</strong>
    </div>
    <div class="col border-left my-auto">
        <small>0.03 - 0.05</small>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="stab_cells" class="form-control text-center decimal" tabIndex="26" value="">
    </div>
</div>

<div class="row border text-center">
    <div class="border-left offset-6 col-2 my-auto">
        <strong>Blood Type</strong>
    </div>
    <div class="col border-left border-right my-auto">
        <input type="text" name="blood_type" class="form-control text-center" tabIndex="27" value="">
    </div>
</div>
</div>
