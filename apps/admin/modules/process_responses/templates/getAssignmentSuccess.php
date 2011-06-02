<?php 
use_javascript("jquery_gchart.js"); 
?>
<script type="text/javascript">
    $(document).ready(function(){

        $("#form-response-process").submit(function(){
            var form = $(this);
            $.ajax({
               type: "POST",
               url: form.attr("action"),
               data: form.serialize(),
               success: function(data){
                $("#ajax-result-process").html(data);
               }
             });
             return false;
        });
        
    });
    
    function selection(e,g,q,i){
        var ul = $("ul.list");
        if($(i).is(":checked")){
            var input = $(i).clone();
            input.attr("type", "hidden");
            var assigs = $("div.assign-content");
            var d = new Date();
            var ul = $("ul.list");
            var li = ul.children();
            var relations = ul.children("li:last").children("div.r");
            //alert(relations.length +" == "+assigs.length);
            if(li.length == 0 || relations.length == assigs.length ){
               if(relations.length == assigs.length){
                   $(".assign-content input.q:checked.actived").attr("disabled", 'disabled');
               }
               ul.append("<li>\n\
                        <input class='type-q-relations' type='hidden' value='"+input.val()+"'/>\n\
                        <input class='id-relations' type='hidden' value='"+d.getTime()+"'/>\n\
                        <div class='option-relactions'>\n\
                            <a class='remove' href='javascript:void(0);' onclick='remove_relation(this);'>Quitar</a>\n\
                        </div>\n\
                        </li>"); 
            }

            last_li = ul.children("li:last"); 
            type = last_li.children("input.type-q-relations").val();
            
            if(type == input.val()){
                id = last_li.children("input.id-relations").val();
                i_name = input.attr("name");
                input.attr("name","process["+id+"]"+i_name+"");
                $(i).addClass("actived");
                last_li.append("<div class='r'>\n\
                                            ENCUESTA:"+e+", \n\
                                            GRUPO: "+g+", \n\
                                            PREGUNTA: "+q+"</div>").append(input);

                
            }else{

                alert("SELECCIONE PREGUNTA DEL MISMO TIPO");
                $(i).attr("checked", '');
            }
            
        }else{
            
            last = ul.children("li:last");
            clss = $(i).attr("rel");
            last.children("input[rel='"+clss+"']").prev("div.r").remove();
            last.children("input[rel='"+clss+"']").remove();
            if(last.children("div.r").length == 0){
                last.remove();
            }
        }
            
    }
    
    function remove_relation(l){
        var parent = $(l).parent().parent();
        var inputs = parent.children("input.q");
        var rel = "";
        $.each(inputs, function(i,inp){
            rel = $(inp).attr("rel");
            $("input[type='checkbox'][rel='"+rel+"']").attr("checked", '').attr("disabled","").removeClass("actived");
        });
 
        parent.remove();
    }
    
    function show_hide_content(a,id_ele){
        var ele = $("#"+id_ele+"");
        if(ele.length){
            if(ele.is(":visible")){
                $(a).text("Mostrar");
                ele.hide();
            }else{
                $(a).text("Ocultar");
                ele.show();
            }
        }
    }
    
    function select_all(i,class_ch){
        var i = $(i);
        var all = $("."+class_ch+"");
        if( i.is(":checked") ){
            $.each(all,function(j,input){
                input.click();              
            });
            all.attr("checked","checked");
        }else{
            all.attr("checked","");
            all.attr("disabled","");
            $("ul.list").children().remove();
        }
    }
    
</script>
    
<?php $count = (count($selected_assignments) <= 3) ? count($selected_assignments) : 3;$i=0; ?>
    
<div id="content-response-process">
    
    <h1>Procesamiento de resultados</h1>
    <p>Encuestas procesadas: <?php echo count($selected_assignments); ?></p>
    <div class="options-result"><a href="javascript:void(0);" onclick="show_hide_content(this,'survey-content');">Ocultar</a> Encuesta(s)</div>
        <div id="survey-content">
            <!---   ENCUESTAS  -->
            <?php foreach ($selected_assignments as $aid => $assignement): ?>

                <div id="assign-<?php echo $aid ?>" class="assign-content <?php echo "r" . $count ?>" >
                    <div class="info-assign">
                        <p>CURSO: <?php echo $assignement["course_name"] ?></p>
                        <p>ASIGNADO EL: <?php echo date("d-m-Y", $assignement["created_at"]) ?></p>
                    </div>
                    <div class="survey-details">
                        <div class="info">
                            <?php if($count == 1): ?>
                            <div class="select_all">
                                <label>Todas las preguntas</label>
                                <input type="checkbox" class="select_all" name="select_all_checkbox" onclick="select_all(this,'q');" />
                            </div>
                            <?php endif; ?>
                            <p>ENCUESTA: <?php echo $assignement["survey"]["_title"]; ?></p>
                        </div>
                        <div class="groups">
                            <!---   GRUPOS   -->
                            <?php foreach ($assignement["survey"]["groups"] as $g_k => $group): ?>
                                <div class="group">
                                    <div class="group-name"><?php echo $group["group_name"] ?></div>
                                    <table cellspacing="0">
                                        <tr>
                                            <th></th>
                                            <th class="index">Index</th>
                                            <th class="question">Pregunta</th>
                                            <th class="type">Tipo</th>
                                        </tr>
                                        <!---   PREGUNTAS   -->
                                        <?php foreach ($group["questions"] as $q_k => $question): ?>
                                            <tr>
                                                <td><input onclick="selection(<?php echo $aid  ?>,<?php echo $g_k  ?>,<?php echo $q_k  ?>,this)" rel="q<?php echo $i; $i++;?>" class="q" type="checkbox" name="[<?php echo $assignement["_id"]; ?>][<?php echo $assignement["survey"]["_id"]; ?>]<?php echo "[" . $g_k . "][" . $q_k . "" ?>]" value="<?php echo $question["type"]["name"] ?>" /></td>
                                                <td><?php echo $question["index"] ?></td>
                                                <td><?php echo $question["text"] ?></td>
                                                <td><?php echo $question["type"]["name"] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>   
                    </div>
                </div>
            <?php endforeach; ?>
        </div>   
    
    <div class="options-result"><a href="javascript:void(0);" onclick="show_hide_content(this,'relations');">Ocultar</a> Relación(es)</div>
    <form id="form-response-process" action="<?php echo url_for("process_responses/process"); ?>" method="POST">
        <div style="clear: both;"></div>
            
        <div id="relations">
            <h1>RELACIONES DE PREGUNTA</h1>
            <ul class="list">
                
            </ul>
        </div>
            
            
        <div style="clear: both;"></div>
            
        <div class="buttons">
            <input type="submit" class="button" value="Procesar encuestas seleccionadas" />
        </div>
            
            
    </form>
        
        
    <div id="ajax-result-process">
    </div>
        
</div>

