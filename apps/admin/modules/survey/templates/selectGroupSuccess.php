<script type="text/javascript" >

    $(document).ready(function(){
 
        $(".editQuestion").click(function(){
            var ul = $("#list-questions");
        });

    });
</script>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="main-content">
    <div class="content-default">

        <div class="title">Editar grupo</div>
        <form action="<?php echo url_for("survey/selectGroup") ?>" id="add-survey-form" method="POST">
            <div class="surveyInformation">
                <?php if (isset($survey)): ?>
                    <p><b>Encuesta ID:</b> <?php echo $survey['_id'] ?></p>
                    <p><b>Encuesta Seleccionada:</b> <?php echo $survey['_title'] ?></p>
                <?php endif; ?>
            </div>
            <div id="infoGroup">
                <div class="option-group">
                    <p style="float:right; clear:both"><a href="<?php echo url_for("survey/addGroup?gid={$group["key"]}&sid={$survey['_id']}"); ?>" rel="facebox" title="Editar informacion de grupo."><?php echo image_tag("edit-group") ?></a></p>
                </div>
                <p><b>Grupo: </b><?php echo $group["group_name"]; ?></p>
                <p><b>Grupo ID: </b><?php echo $group["key"]; ?></p>
                <div><b>Descripcion de Grupo: </b><?php echo $group['group_description']; ?></div> 
            </div>
            <div id="questionGroup">
                <?php if (count($group["questions"])): ?>
                    <p>PREGUNTAS</p>  
                    <p>Numero de preguntas:<?php echo count($group["questions"]); ?></p> 
                    <p>
                        <a href="<?php echo url_for("survey/listGroup?gid={$group["key"]}&sid={$survey['_id']}"); ?>" title="Guardar Grupo."><?php echo image_tag("save-group") ?></a>
                        <a href="<?php echo url_for("survey/addQuestion?gid={$group["key"]}&sid={$survey['_id']}"); ?>" rel="facebox" title="Añadir pregunta."><?php echo image_tag("add-question") ?></a>
                    </p>

                    <?php foreach ($group["questions"] as $key => $question): ?>
                        <div class="question"id="<?php echo $key ?>">
                            <span>Pregunta <?php echo $question["key"]; ?>:</span> <?php echo $question["text"]; ?>
                            <span>Tipo de Pregunta:</span> <?php echo @$question["type"]["name"]; ?>
                            <span>Obligatoria: </span><?php echo $question['required']; ?>
                            <br/>
                            <p>
                                <a href="<?php echo url_for("survey/addQuestion?sid={$survey['_id']}&gid={$group['key']}&qid={$question['key']}&type={$question['type']["name"]}"); ?>" rel="facebox" class="editQuestion"title="Editar pregunta."><?php echo image_tag("edit-ask") ?></a>  
                                <a href="<?php echo url_for("survey/remove?sid={$survey['_id']}&gid={$group['key']}&qid={$question['key']}"); ?>" onclick="return removeQuestionSurvey(this,'<?php echo $key; ?>');"title="Eliminar pregunta"><?php echo image_tag("remove-ask") ?></a>
                            </p> 
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p><a href="<?php echo url_for("survey/addQuestion?gid={$group["key"]}&sid={$survey['_id']}"); ?>" rel="facebox" title="Añadir pregunta."><?php echo image_tag("add-question") ?></a> No existes preguntas en el grupo.</p>  
                <?php endif; ?>


            </div> 

        </form>


    </div>
</div>



