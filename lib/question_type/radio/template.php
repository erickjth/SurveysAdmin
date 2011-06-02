<div class="radio_type_question">
    <ul style="width:40%;" >
        <?php foreach ($structure["option"] as $k => $option): ?>
            <li>
                <input class="<?php echo $required; ?>" type="radio" onchange="save_question(this,<?php echo $g; ?>,<?php echo $q; ?>,null)" value="<?php echo $option; ?>"
                       name="q<?php echo "[" . $g . "][" . $q . "" ?>]"
                       <?php echo ($r && isset($result["g{$g},q{$q}"]) && $result["g{$g},q{$q}"] == $option) ? " checked=true " : ""; ?>
                       />
                       <?php echo $option; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>