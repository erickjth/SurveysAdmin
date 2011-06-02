<?php
use_stylesheet("jquery_plugins/jquery-cleditor.css");
use_javascript("jquery-cleditor.js");
?>
<script type="text/javascript" >
    $(document).ready(function(){
        $("#add-survey-form").validate();
    });
</script>

<div id="main-content">
    <div class="content-default">

        <?php if (!isset($survey)): ?>
            <div class="title">Formulario crear encuesta</div>
        <?php else: ?>
            <div class="title">Formulario editar encuesta</div>
        <?php endif; ?>



        <div class="form-content-fix">
            <form action="<?php echo url_for("survey/addSurvey") ?>" id="add-survey-form" method="POST">

                <?php if (isset($survey)): ?>
                    <input type="hidden" name="survey[id]" value="<?php echo @$survey['_id'] ?>">
                    <p><label for="survey-name">Id de la encuesta: <?php echo @$survey['_id'] ?></label></p>
                <?php endif; ?>

                <p>
                    <label for="survey-name">Nombre</label>
                    <input class="required big" id="survey-name" name="survey[name]" type="text" value="<?php echo @$survey['_title']; ?>"/>
                </p>
                <p>
                    <b>Activar encuesta:</b>
                    <select name="active[type]">
                        <?php if (isset($active)): ?>   
                            <?php if ($active == "si"): ?> 
                                <option value="si">Activa</option>
                                <option value="no">Desactiva</option>
                            <?php else: ?>
                                <option value="no">Desactiva</option>
                                <option value="si" >Activa</option>
                            <?php endif; ?>
                        <?php else: ?>  
                            <option value="si">Activa</option>
                            <option value="no">Desactiva</option> 
                        <?php endif; ?>
                    </select>
                </p>
                <p>
                    <label for="survey-description">Descripción</label>
                    <textarea class="required fix" id="survey-description" name="survey[description]">
                        <?php echo @$survey['_description']; ?> 
                    </textarea>
                    <script>activeEditor("#survey-description");</script>
                </p>

                <p class="buttons">
                    <input type="submit" id="create-survey" value="Guardar"/>
                </p>
            </form>
        </div>
    </div>

</div>