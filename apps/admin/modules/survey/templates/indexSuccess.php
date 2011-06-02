<?php
/* Evaluacion->Encuesta->opcion:Lista */
//use_stylesheet("extPlugins/GroupSummary.css");
//use_javascript("extPlugins/GroupSummary.js");
?>

<script type="text/javascript" >
    $(document).ready(function(){

    });
</script>
<div id="menuContenido">

    
    <div class="tituloBloqueMenu">
        <b>SAVIO</b>Survey<span style="font-size:13px; vertical-align:middle"> (gestor de encuestas:Vista Administrativa)</span>
    </div>
    
    <div class="contentDefault"> 
        
        <div class="bloqueMenu">
            <p><strong>listado de encuestas</strong></p><br/>
            <div class="buttons">
                <?php echo link_to("Ingresar", "survey/listSurvey",array("class"=>"button"));?>
            </div>
        </div>
        <div class="bloqueMenu">
            <p><strong>Agregar encuestas</strong></p><br/>
            <div class="buttons">
                <?php echo link_to("Ingresar", "survey/addSurvey", array("class" => "button")); ?>
            </div>
        </div>
        <div class="bloqueMenu">
            <p><strong>asignaciones de encuestas</strong></p><br/>
            <div class="buttons">
                <?php echo link_to("Ingresar", "survey/index", array("class" => "button")); ?>
            </div>
        </div> 
        <div class="bloqueMenu">
            <p><strong>Estadística y resultados de las encuestas</strong></p><br/>
            <div class="buttons">
                <?php echo link_to("Ingresar", "survey/index", array("class" => "button")); ?>
            </div>
        </div>  
        
    </div>
     
</div>



