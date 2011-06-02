<script type="text/javascript" >

    $(document).ready(function(){
        $( "#accordion" ).accordion();
       
   
        $("#addscaleHeader").click(function(){
            var t = new Date();
            t = t.getTime();
            var content="<div id='"+t+"'><input class='input' type='text' name='form_type_question[scale_header][]' /><a class='delete' href='javascript:void(0);' onclick='remove_field("+t+")' title='Eliminar'></a></div>" ;         
            var contenedor=$("#loadScaleHeader");
            contenedor.append(content).show();
        });
        
        $("#addscaleText").click(function(){
            var t = new Date();
            t = t.getTime();
            var content="<div id='"+t+"'><input class='input' type='text' name='form_type_question[scale_text][]' /><a class='delete' href='javascript:void(0);' onclick='remove_field("+t+")' title='Eliminar'></a></div>" ;
            var contenedor=$("#loadScaleText");
            contenedor.append(content).show();
        });
        
        
    });
    
    function remove_field(id){
        $("#"+id+"").remove();
    }
    
    function addDescription(){
        $("#selecPaste").addClass("auxOff");
        $("#addDescription").addClass("auxOff");
        var content="<div id='descrip'>Añada una descripcion para ser referenciada: <input id='inputDescription' class='input' type='text' name='form_type_question[scale_text][]' /><a class='savePattern' href='<?php echo url_for('survey/processQuestion?type=matriz'); ?>' onclick='return savePattern(this)' title='Guardar patron'></a><a class='delete' href='javascript:void(0);' onclick='cancelCopy()' title='Cancelar'></a></div>" ;
        var contenedor= $("#description");
        contenedor.append(content).show();
    }
    
    
    function savePattern(a){
        var href = $(a).attr("href");
        var value= $("#inputDescription ").val();
       
        if(value == ""){
            alert("coloque una descripción");
        }else{
           
            /*******************dejamos todo como estaba antes******************/
            var content="<div id='addDescription'><a class='savePattern' href='javascript:void(0);' onclick='addDescription()' title='Guardar patron'></a></div>";
            var contenedor= $("#add");
            contenedor.prepend(content).show(); 
            
            var headers_inputs = $("#headers input.input").clone();
            $("#form").append("<form action='<?php echo url_for('survey/ProcessQuestion'); ?>' id='form-save-pattern' method='POST' ></form>")
            headers_inputs.css("display","none");
            $("#form-save-pattern").append(headers_inputs);
            var form=$("#form-save-pattern").serialize();
            $.ajax({
                type: "POST",
                url: href,
                data:form+"&description="+value ,
                success: function(data){
                    remove_field("descrip");
                }
            });
                
        }
        return false;
    }
    
 
 
    function pastePattern(a){
        var href = $(a).attr("href");
        $.ajax({
            type: "POST",
            url: href,
            dataType: 'json',
            success: function(data){
                
                var son=$("#pattern").children().length;
                if(son){
                    $("#pattern").addClass("auxOff");
                }
                $("#selecPaste").addClass("auxOff");
                $("#addDescription").addClass("auxOff");
                
                var empty=$("#first").val();
                if(empty==""){
                    $("#first").addClass("auxOff");     
                }
                var content="<div id='pastePattern'>Seleccione la descripción a pegar: <select  rel='"+a+"' name='header[type]' onchange='loadPaste(this);'><option value=''>...</option>";             
                $.each(data, function(i,v){
                    content += "<option value='"+i+"'>"+v.description+"</option>";
                });
                content += "</select><a class='delete' href='javascript:void(0);' onclick='cancelPaste()' title='Cancelar'></a></div>";
                $("#description").append(content).show();
                
            }
        });
        return false;
    }
    
   
    function loadPaste(ID){
        
        var son=$("#pattern").children().length;
        if(son>0){
            remove_field("pattern");
        }
        var href= $(ID).attr("rel");
        var value = $(ID).val();
        if(value != ""){
            $.ajax({
                type: "POST",
                url:href,
                dataType: 'json',
                data: {
                    id:value
                },
                success: function(data){
                    //alert(data);
                    var t = 0;
                    var structure="<div id='pattern'>";
                    $.each(data, function(k,r){
                        $.each(r.structure.scale_header, function(s,m){
                            t ++;
                            structure+="<div id='"+t+"'><input class='input' type='text' name='form_type_question[scale_header][]' value='"+m+"'/><a href='javascript:void(0);' onclick='remove_field("+t+")' title='Eliminar' class='clear'></a></div>";                                                 
                        });
                    });
                    structure+="</div>";
                    $("#headers").prepend(structure).show();
                    $("#selecPaste").removeClass("auxOff");
                    $("#addDescription").removeClass("auxOff");
                    var empty=$("#first").val();
                    if(empty==""){
                        remove_field("initial");
                    }else{
                    $("#initial a").removeClass("auxOff");
                    }                    
                    remove_field("pastePattern");
                }
            });   
        }   
    } 
    
    
    function viewCopy(a){
        var value = $(a).val();
        if(value==""){
            return false;
        }else{
            $("#addDescription").removeClass("auxOff");
            // $("#addDescription").addClass("auxOn");
            return true;         
        }       
    }
    
    
    function cancelPaste(){
        var son=$("#pattern").children().length;
        if(son){
            $("#pattern").removeClass("auxOff");
        }
        $("#selecPaste").removeClass("auxOff");
        $("#addDescription").removeClass("auxOff");
        remove_field("pastePattern");
        $("#first").removeClass("auxOff");
        return false;   
    }
    
    function cancelCopy(){
        $("#selecPaste").removeClass("auxOff");
        $("#addDescription").removeClass("auxOff");
        remove_field("descrip");
    }
    
</script>

<style> 
    .add, .remove{
        margin: 0px 10px 10px 0px;
    }
    .add img{
        width:22px;
        height: 22px;
    }
    .remove img{
        width:16px;
        height: 16px;
    }
    .input{
        width:96%; 
        height: 20px; 
        margin: 3px 0px 3px 0px;
    }
    #descrip, #pastePattern{
        display:block;
        background:#F1F5FF;
        border:1px solid #CCC;
        color:#4A3C31;
        margin:8px 0px 8px 0px;
        padding:5px 5px 10px 10px;
    }
    #descrip input{
        width:56%;
    }
    #descrip a.savePattern{
        float: right;
    }
    .auxOff{
        display: none;
    }
    .auxOn{
        display: inline;  
    }
    a.delete{
        width:16px;
        height: 16px;
    }

</style>




<div style="border: 1px solid #1C94C4; background-color: #F1F5FF; padding: 0px 0px 10px 0px; margin:10px 0px 10px 10px; float: left; width: 98%;">
    <div style="color:#2E6E9E; height: 10px; font-weight: bold; font-size: 14px; background-color:#DFEFFC; padding: 10px 0px 15px 10px;">
        Pregunta tipo matriz

    </div>
    <div style="border:1px solid #CCC; margin: 10px 10px 10px 12px; width:95%; padding:10px 10px 10px 10px; display:inline-block; background:#F6F6F6; float: left;">
        <div id="add" style="color:#194294; height: 10px; font-size: 14px; background-color:#DFEFFC; text-align: center; padding: 10px 0px 25px 0px; margin-bottom: 10px;">

            <div id="addDescription" class="auxOff"><a class="savePattern" href="javascript:void(0);" onclick='addDescription()' title='Guardar patron'></a></div>
            <?php if (count($structure) == 0): ?> 
                <div id="selecPaste"><a class="pastePattern" href="<?php echo url_for('survey/processQuestion?type=matriz&paste=true'); ?>" onclick="return pastePattern(this);" title='Pegar patron'></a></div>
            <?php endif; ?>
            Agregar cabeceras de la matriz
            <a class="add" style="float:right;" href="javascript:void(0);" id="addscaleHeader" title="añadir cabecera"><?php echo image_tag("add") ?></a>
        </div>

        <div id="description"></div>
        <div id="form"></div>

        <div id="headers">
            <?php if (count($structure)): ?>
                <?php foreach ($structure["scale_header"] as $k => $header_matriz): ?>
                    <div id= <?php echo $k ?>>
                        <input class="input" type="text" name="form_type_question[scale_header][]" value="<?php echo $header_matriz; ?>"/>
                        <a class="remove" href="javascript:void(0);" onclick='remove_field("<?php echo $k ?>")' title="Eliminar" class="remove"><?php echo image_tag("remove") ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div id="initial">
                    <input id="first"class="input" onBlur="viewCopy(this)" type="text" name="form_type_question[scale_header][]"/>
                    <a href="javascript:void(0);" onclick='remove_field("initial")' title="Eliminar" class="remove auxOff"><?php echo image_tag("remove") ?></a>
                </div>
            <?php endif; ?>
            <div id="loadScaleHeader"></div>
        </div>

    </div>

    <div style="border:1px solid #CCC; background:#F6F6F6; margin: 10px 10px 10px 10px; width:95%; padding:10px 10px 10px 12px; float: left;">

        <div style="color:#194294; height: 10px; font-size: 14px; background-color:#DFEFFC; text-align: center; padding: 10px 0px 15px 0px; margin-bottom: 10px;">
            Agregar textos de la matriz
            <a class="add" style="float:right;" href="javascript:void(0);" id="addscaleText"title="añadir texto"><?php echo image_tag("add") ?></a>
        </div>

        <?php if (count($structure)): ?>
            <?php foreach ($structure["scale_text"] as $k => $header_matriz): ?>
                <div id= <?php echo $k ?>>        
                    <input class="input" type="text" name="form_type_question[scale_text][]" value="<?php echo $header_matriz; ?>"/>
                    <a class="remove" href="javascript:void(0);" onclick='remove_field("<?php echo $k ?>")' title="Eliminar"><?php echo image_tag("remove") ?></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <br/>
            <input class="input" type="text" name="form_type_question[scale_text][]"/>   
        <?php endif; ?>
        <div id="loadScaleText"></div>  
    </div>

</div>




