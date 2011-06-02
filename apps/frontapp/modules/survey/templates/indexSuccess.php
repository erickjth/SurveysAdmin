<?php if (!count($survey_assignments)): ?>
    <?php die(); ?>
<?php endif; ?>

<a href="<?php echo sfConfig::get("app_URLMoodle"); ?>">
    Volver a mis cursos.
</a>
<div id ="content-list-survey">
    <div class="header-title">
        ENCUESTAS DISPONIBLES
    </div>
    <?php foreach ($survey_assignments as $key => $assign): ?>
        <div class="list-survey">
              <p><span class="sub">NOMBRE DE ENCUESTA:</span> <br /><?php echo $assign["survey_name"]?></p>
              <?php if($assign["state"] == -1): ?>
                    <a <?php echo @$target_link ; ?> href="<?php echo url_for("survey/viewSurvey");?>?aid=<?php echo $assign["assign_id"]; ?>" >Realizar encuesta</a>
              <?php elseif($assign["state"] ==  1 ):?>
                    <span class="finish" >Encuesta finalizada</span>
              <?php else: ?>
                    <a <?php echo @$target_link ; ?> href="<?php echo url_for("survey/viewSurvey");?>?aid=<?php echo $assign["assign_id"]; ?>" >Continuar con la encuesta</a>
              <?php endif;?>
        </div>
    <?php endforeach; ?>

</div>