<div style="clear:both"class="select_type_question">
    <select class="<?php echo $required; ?>" name="q<?php echo "[" . $g . "][" . $q . "" ?>]" style="width:40%;" 
            onchange="save_question(this,<?php echo $g; ?>,<?php echo $q; ?>,null)">
        <option value="">...</option> 
        <?php foreach ($structure["option"] as $k => $option): ?>
            <option value="<?php echo $option; ?>"
            <?php echo ($r && isset($result["g{$g},q{$q}"]) && $result["g{$g},q{$q}"] == $option) ? " selected=true " : ""; ?>
                    ><?php echo $option; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<span class="help-type-question">Seleccione una opción de respuesta</span>
