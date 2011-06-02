<?php $h=array();$texts=array();$data_graph = array(); $i =0; $k=1 ;$count = 0;?>
<script type="text/javascript">
    function matriz_load_frecuence(i){
        input = $(i);
        var column_class = input.val();
        td_list = $("td."+column_class+"");
        $.each(td_list, function(idx,t){
            td = $(t);
            per_number_span = td.children("span.per_number");
            td_result = td.nextAll(".total-column-matriz:eq(0)");
            result = 0;
            
            value_td = getNumber(per_number_span.text());
            value_td_result = getNumber(td_result.children("span.per_number").text());
   
            if( input.is(":checked") ){
                result = value_td_result + value_td;
            }else{
                result = value_td_result - value_td;
            }
            if( result <= 0){
               result = 0;
            }else if(result > 100){
               result = 100;
            }
            result = number_format(result,1,".");
            td_result.children("span.per_number").text(result);  
                                   
        })
        
    }
    function getNumber(num) {
        num = num.toString().replace(/\$|\,/g,'');

        if(isNaN(num))
            num = "0";

        return (parseFloat(num));
    }
    
    function number_format( number, decimals, dec_point, thousands_sep ) {
        
        var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
        var d = dec_point == undefined ? "," : dec_point;
        var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
        var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
</script>
<div class="survey-question-ref">

</div>
<table class="matriz" cellspacing="0">
    <thead>
        <tr class="headers">
            <th></th>
            <?php foreach ($structure as $s_index=>$header_matriz): ?>
            <?php $structure[$s_index]["scale_header"][]="-"; ?>
            <th colspan="<?php echo count($header_matriz["scale_header"])+3; ?>">
            <span class="text-question">[<?php echo $results[$s_index]["q_index"].". ".$results[$s_index]["q_text"] ?>]</span>
            </th>
            <?php endforeach; ?>
        </tr>
        <tr class="headers">
        <th>Sub-Pregunta</th>
        <?php foreach ($structure as $s_index=>$header_matriz): ?>
            <?php foreach ($header_matriz["scale_header"] as $h_index=>$v_h): ?>
            <th class="header-text">
                <?php echo $v_h;$h[$s_index][$h_index] = $v_h; ?>
                <input onclick="matriz_load_frecuence(this);" type="checkbox" checked="checked" class="" name="" value="matriz<?php echo $s_index."_".$h_index."_".$results[$s_index]["result_code"];?>" />
            </th>
            <?php endforeach; ?>
            <th class="header-text">f(x)(%)</th>
            <th class="header-text">Total</th>
            <?php foreach ($header_matriz["scale_text"] as $t_index=>$v_t): ?>
            <?php @$texts[$t_index."-".$v_t]=$v_t; ?>
            <?php @$data_graph[$s_index]["h"][] = substr($v_t, 0, 10); ?>
            <?php endforeach; ?>
        <?php endforeach; ?>    
        </tr>
    </thead>
    <tbody>
        <?php foreach ($texts as $t_index=>$q_text): ?>
        <tr class="items <?php echo ( $i % 2 == 0 ) ? "odd" : "even";$i++ ?>">
            <td class="item-text"><?php echo $q_text ?></td>
            <?php foreach ($h as $s_h_index=>$header_values): ?>
                <?php $k=0;$t=0;?>
                <?php foreach($header_values as $k_header_text=>$value): ?>
                <td class="item-option matriz<?php echo $s_h_index."_".$k_header_text."_". $results[$s_h_index]["result_code"] ?> ">
                    <?php if (isset($results[$s_h_index][$t_index][$value])): ?>
                    <span class="per_number">
                        <?php echo number_format(($results[$s_h_index][$t_index][$value] * 100)/$results[$s_h_index]["total"],1); ?>
                    </span>%
                    (<span class="n_number"><?php echo $results[$s_h_index][$t_index][$value]; ?></span>)
                    <?php 
                        $k+=($results[$s_h_index][$t_index][$value]* 100)/$results[$s_h_index]["total"]; 
                        $t+=$results[$s_h_index][$t_index][$value];
                        @$data_graph[$s_h_index]["q"][$value][$t_index]++;
                    ?>
                    <?php else: ?>
                    <span class="per_number">0</span>%
                    (<span class="n_number">0</span>)
                    <?php @$data_graph[$s_h_index]["q"][$value][$t_index] = 0 ?>
                    <?php endif;?>
                    
                </td>
                <?php endforeach; ?>
                <td class="item-option last_group total-column-matriz result-<?php echo $s_h_index;?>">
                <span class="per_number"><?php echo number_format($k,1);?></span>%
                </td>
                <td class="item-option last_group total-column-matriz">
                <span><?php echo $t;?></span>
                </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td><span style="margin-top: 10px;">( - ) : Sin respuesta</span></td>
        </tr>
    </tfoot>
</table>

<?php 
echo "<pre>";
//print_r($h);
//print_r($texts);
//print_r($structure);
//print_r($results);
//print_r($data_graph);
echo "</pre>";
?>