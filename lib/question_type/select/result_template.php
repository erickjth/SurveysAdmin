<?php $h=array();$texts=array(); $i =0; $k=1 ;$count = 0;?>
<script type="text/javascript">
    function select_load_frecuence(i){
        input = $(i);
        var column_class = input.val();
        td_list = $("td."+column_class+"");
        $.each(td_list, function(idx,t){
            td = $(t);
            td_result = td.nextAll(".total-column-select:eq(0)");
            result = 0;
            
            value_td = getNumber(td.text());
            value_td_result = getNumber(td_result.children("span").text());
            value_total = getNumber(td_result.children("input").val());
            
            if( input.is(":checked") ){
                result = value_td_result + value_td;
            }else{
                result = value_td_result - value_td;
            }
            td_result.children("span").text(result);                        
        })
        
    }
    function getNumber(num) {
        num = num.toString().replace(/\$|\,/g,'');

        if(isNaN(num))
            num = "0";

        return (parseFloat(num));
    }
</script>
<table class="select" cellspacing="0">
    <thead>
        <tr class="headers">
            <?php foreach ($structure as $s_index=>$header_matriz): ?>
            <?php $structure[$s_index]["option"][]="-"; ?>
            <th colspan="<?php echo count($header_matriz["option"])+2; ?>">
            <span class="text-question">[<?php echo $results[$s_index]["q_index"].". ".$results[$s_index]["q_text"] ?>]</span>
            </th>
            <?php endforeach; ?>
        </tr>
        <tr class="headers">
        <?php foreach ($structure as $s_index=>$header_matriz): ?>
            <?php foreach ($header_matriz["option"] as $h_index=>$v_h): ?>
            <th class="header-text">
                <?php echo $v_h;$h[$s_index][$h_index] = $v_h; ?>
                <input onclick="select_load_frecuence(this);" type="checkbox" checked="checked" class="" name="" value="select<?php echo $s_index."_".$h_index;?>" />
            </th>
            <?php endforeach; ?>
            <th class="header-text">f(x)</th>
            <?php foreach ($header_matriz["scale_text"] as $t_index=>$v_t): ?>
            <?php @$texts[$t_index."-".$v_t]=$v_t; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>    
        </tr>
    </thead>
    <tbody>
        <tr class="items odd">
            <?php foreach ($h as $s_h_index=>$header_values): ?>
                <?php $k=0;?>
                <?php foreach($header_values as $k_header_text=>$value): ?>
            
                <td class="item-option select<?php echo $s_h_index."_".$k_header_text ?> ">
                    <?php if (isset($results[$s_h_index][$value])): ?>
                    <?php 
                        echo number_format(($results[$s_h_index][$value] * 100)/$results[$s_h_index]["total"],2);
                        $k+=($results[$s_h_index][$value]* 100)/$results[$s_h_index]["total"]; 
                    ?>
                    <?php else: ?>0 
                    <?php endif;?>
                </td>
                
                <?php endforeach; ?>
                <td class="item-option last_group total-column-select result-<?php echo $s_h_index;?>">
                <span><?php echo number_format($k,2);?></span>
                <input type="hidden" value="<?php echo $k;?>"/>
                </td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>

<?php 
echo "<pre>";
//print_r($h);
//print_r($texts);
//print_r($structure);
//print_r($results);
echo "</pre>";
?>