<?php
/* Evalucion->Encuestas->opcion:Agregar *//* Evalucion->Encuestas->Lista->boton:Crear Nueva */
use_stylesheet("jquery_plugins/jquery-cleditor.css");
use_javascript("jquery_plugins/jquery-cleditor.js");
?>
<script type="text/javascript" >

    $(document).ready(function(){
        $("#add-survey-form").validate();
        $("#group-description").cleditor({
            width:  595,
            height: 250
        });
    });
 
</script>

<div id="main-content">

    <div class="content-default">
        <?php if (!isset($group['key'])): ?>
            <div class="title">Formulario crear Grupo</div>
        <?php else: ?>
            <div class="title">Formulario editar Grupo</div>
        <?php endif; ?>
        <div class="form-content-fix">

            <form action="<?php echo url_for("survey/addGroup") ?>" id="add-survey-form" method="POST">

                <input type="hidden" name="survey[id]" value="<?php echo @$survey['_id'] ?>">
                <input type="hidden" name="group[key]" value="<?php echo @$group['key'] ?>">
            
                    <p><label for="survey-name"><b>Encuesta ID:</b> <?php echo @$survey['_id'] ?></label></p>
                    <p><label><b>Titulo de la encuesta:</b> <?php echo @$survey['_title'] ?></label></p>
                    <p><label for="survey-name"><b>Grupo ID: </b><?php echo @$group['key'] ?></label></p>
                
                <p>
                    <label for="survey-name">Nombre del grupo:</label>
                    <input class="required big" id="survey-name" name="group[name]" type="text" value="<?php echo @$group['group_name']; ?>"/>
                </p>

                <p>
                    <label for="group-description">Descripción del grupo</label>
                    <textarea class="required fix" id="group-description" name="group[description]">
                        <?php echo @$group['group_description']; ?> 
                    </textarea>
                </p>

                <p class="buttons">
                    <input type="submit" id="create-survey" value="Guardar"/>
                </p>
            </form>


        </div>
    </div>
</div>

