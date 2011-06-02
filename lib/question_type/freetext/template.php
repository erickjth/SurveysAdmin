
<textarea class="<?php echo $required; ?>" onblur="save_question(this,<?php echo $g; ?>,<?php echo $q; ?>,null);" style="width: 80%;" rows="10" name="q<?php echo "[".$g."][".$q?>]" >
<?php echo ($r && isset($result["g{$g},q{$q}"]) )?$result["g{$g},q{$q}"]:""; ?>
</textarea>
