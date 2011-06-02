<script type="text/javascript" >

    $(document).ready(function(){
        
        $("#add_select_option").click(function(){
            var t = new Date();
            t = t.getTime();
            var content="<div id='"+t+"'><input type='text' name='form_type_question[option][]' /><a href='#' onclick='remove_field("+t+")'><small>Eliminar</small></a></div>" ;
            var contenedor=$("#load_select");
            contenedor.append(content).show();
        });
       
    });
    
    function remove_field(id){
        $("#"+id+"").remove();
    }

</script>
<div>
    <div>
        <p>Agregar opción a la seleccion</p>
            
        <a href="#" id="add_select_option"><small>añadir opción</small></a>
        <div id="load_select">
            <?php if (count($structure)): ?>
                <?php foreach ($structure["option"] as $k => $option): ?>
                    <input type="text" name="form_type_question[option][]" value="<?php echo $option; ?>"/>       
                <?php endforeach; ?>
            <?php else: ?>
                <input type="text" name="form_type_question[option][]"/>   
            <?php endif; ?>
        </div>
    </div>
</div>