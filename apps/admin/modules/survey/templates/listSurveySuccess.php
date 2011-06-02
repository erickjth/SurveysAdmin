<?php
/* Evaluacion->Encuesta->opcion:Lista */
//use_stylesheet("extPlugins/GroupSummary.css");
//use_javascript("extPlugins/GroupSummary.js");
?>
<script type="text/javascript" >
    $(document).ready(function(){

    });
</script>

<div id="main-content">

    <div class="content-default">
        <div class="title">Listado de encuestas</div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Creado en</th>
                    <th>Activa</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($surveys as $k => $survey): ?>
                        <tr id="<?php echo $k ?>">
                            <td>
                                <?php echo $survey['_id']; ?>
                            </td>
                            <td>
                                <?php echo $survey['_title']; ?>
                            </td>
                            <td>
                                <?php echo date("d-m-Y", $survey['_created_at']); ?>
                            </td>
                            <td>
                                <?php echo $survey['active']; ?>
                            </td>
                            <td>
                                <p <?php if ($survey['active'] == "no"): ?>class="off" <?php else:?>class="on" <?php endif;?>>
                                    <a href="<?php echo url_for("survey/listGroup"); ?>?sid=<?php echo $survey['_id']; ?>"title="Editar Encuesta"><?php echo image_tag("edit-infoSurvey") ?></a>
                                    <a href="<?php echo url_for("survey/preview"); ?>?sid=<?php echo $survey['_id']; ?>" title="Preview"><?php echo image_tag("preview-survey") ?></a>
                                    <a href="<?php echo url_for("survey/remove?sid={$survey['_id']}"); ?>" onclick="return removeSurvey(this,'<?php echo $k; ?>');" title="Eliminar encuesta."><?php echo image_tag("remove-survey") ?></a>       
                                    <a href="<?php echo url_for("survey/updateActive?sid={$survey['_id']}&active=false"); ?>" onclick="return updateActiveSurvey(this,'<?php echo $k; ?>');" title="Desactivar encuesta."><?php echo image_tag("off-survey") ?></a>
                                </p>
                                
                                <p <?php if ($survey['active'] == "si"): ?>class="off" <?php else:?>class="on" <?php endif;?>>
                                    <a href="<?php echo url_for("survey/updateActive?sid={$survey['_id']}&active=true"); ?>" onclick="return updateActiveSurvey(this,'<?php echo $k; ?>');" title="Activar encuesta"><?php echo image_tag("active-survey") ?></a> 
                                </p>
                            
                            </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="removeSurveyInformation">
            <b>Info:</b> Ninguna.
        </div>

        <div class="buttons">
            <?php echo link_to("Crear Nueva", "survey/addSurvey", array("class" => "button")); ?>
        </div>

    </div>


</div>

