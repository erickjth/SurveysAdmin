<?php
/*Evaluaciones->Encuestas->lista->opcion:Preview*/
    use_stylesheet("themes/survey_default.css");
?>
<link href="<?php echo  sfConfig::get("app_baseurl")?>/css/themes/survey_default_print.css" rel="stylesheet" type="text/css" media="print">

<div id="wrapper-content-survey">
    <div class="header">
        <div class="info">VICERRECTORÍA ACADÉMICA DIRECCIÓN DE DOCENCIA</div>
        <div class="logo"><?php echo image_tag("utb_logo");?></div>
        <div class="info2">
            <span class="survey-name"><?php echo $survey["name"] ?></span>
            <span class="date">Fecha: <?php echo date("d-m-Y"); ?></span>
        </div>
    </div>
    <div class="survey-details-assig">
        <div class="teacher-info">
            <p><span class="t">Nombre del profesor:</span>{NOMBRE}</p>
            <p><span class="t">Código:</span>{CODIGO}</p>
            <p><span class="t">Periodo:</span>{PERIODO ACTIVO}</p>
        </div>
        <div class="course-info">
            <p><span class="t" >Nombre del curso:</span>{NOMBRE CURSO}</p>
            <p><span class="t">Código:</span>{NRC}</p>
            <p><span class="t">Grupo:</span>{GRUPO}</p>
        </div>
    </div>
    <div class="survey-description">
        <?php echo html_entity_decode($survey["description"]); ?>
    </div>
    <div class="content-body-survey">
        
        <form id="survey-<?php echo $survey["id"]?>" >
            
            <?php foreach($survey["EvalGroupQuestion"] as $key=>$group): ?>
            <div class="content-group" id="group-<?php echo $group["id"]; ?>">
                <div class="title"><?php echo $group["group_name"];?></div>
                <table class="content-question">
                <?php foreach($group["EvalQuestion"] as $key=>$question):?>
                    <tr>
                    <?php if($question["type_q"] == 1): ?>
                        <td class="index">
                            <?php echo $question["idx"]?>
                        </td>
                        <td class="text">
                            <?php echo $question["text"]?>
                        </td>
                        <td class="indicator">
                            <select class="q-select" name="q[<?php echo $question["id"];?>]">
                                <option value="">Seleccione...</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="0">N/A</option>
                            </select>
                        </td>
                    <?php elseif($question["type_q"] == 2): ?>
                        <td class="index">
                            <?php echo $question["idx"]?>
                        </td>
                        <td class="text-type-2">
                            <?php echo $question["text"]?>
                        </td>
                        <td class="body-text">
                            <textarea name="q[<?php echo $question["id"];?>]"></textarea>
                        </td>
                    <?php endif; ?>
                    </tr>
                <?php endforeach; ?>   
                </table>
            </div>
            <?php endforeach; ?>
            
        </form>
    </div>

</div>
