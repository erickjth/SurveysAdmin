<?php $h=array();$i=0;$count=count($structure["scale_header"]);?>
<table class="matriz" cellspacing="0">
    <thead>
        <tr class="headers">
            <th></th>
            <?php foreach ($structure["scale_header"] as $header_matriz): ?>
                <th class="header-text"><?php echo $header_matriz;$h[]=$header_matriz; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
            <?php foreach ($structure["scale_text"] as $k => $header_text): ?>
            <tr class="items <?php echo ( $i%2==0 )?"odd":"even";$i++ ?>">
                <td class="item-text"><?php echo $header_text ?></td>
                <?php foreach ($h as $value): ?>
                <td style="width: <?php echo (50/$count); ?>%" class="item-option">
                    <input id="<?php echo rand(); ?>" class="<?php echo $required; ?>" <?php echo ($r && isset($result["g{$g},q{$q},m{$k}"]) && $result["g{$g},q{$q},m{$k}"] == $value)?" checked=true ":"";  ?> 
                            onchange="save_question(this,<?php echo $g; ?>,<?php echo $q; ?>,<?php echo $k; ?>)" 
                            type="radio" 
                            name="q<?php echo "[".$g."][" . $q . "][" . $k ?>]" 
                            value="<?php echo $value; ?>"/>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>