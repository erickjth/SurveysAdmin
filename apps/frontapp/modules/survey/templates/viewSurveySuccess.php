<pre>
<?php //print_r($result); ?>
</pre>

<?php if(isset($result["state"]) && $result["state"] == 1): ?>
    <span style="text-align: center;">La encuesta ya fue finalizada! Gracias</span>
    <?php die(); ?>
<?php endif;?>

<?php use_stylesheet("themes/survey_default.css"); ?>

<script type="text/javascript" >
    var config_assig = ({
        assig_id : '<?php echo $assignment["_id"]; ?>',
        save_ajax_question : "<?php echo url_for("survey/SaveAnswerSurvey");?>"
    });
</script>

<script type="text/javascript" >
    $(document).ready(function(){
        $("body").addClass("survey-view");
        $("#main-content").addClass("survey-view-content");
        //validate Form
        var validator = $("#survey-assig-form").validate({
            errorPlacement: function(error, element) {
                element.parent().parent().addClass("error");
            }
        });
        //Submit form
        $("#survey-assig-form").submit(function(){
            if (validator.valid()) { if( confirm("¿ Esta seguro de enviar la evaluación ?") ){ return true; }else{  return false; }
            }else{$.jGrowl("Existen preguntan sin responder, por favor diligencia todo el formulario. Gracias",{ header: 'Error',theme: "error"});return false;}
            return false;
        });
        /*$("#save_form_survey").click(function(){
            if (validator.valid()) { if( confirm("¿ Esta seguro de enviar la evaluación ?") ){ $("#survey-assig-form").submit(); }else{  return false; }
            }else{$.jGrowl("Existen preguntan sin responder, por favor diligencia todo el formulario. Gracias",{ header: 'Error',theme: "error"});return false;}
        });*/

    });
    function save_question(input,g,q,k){
        if(typeof q === 'number' && isFinite(q) && q >= 0 &&
           typeof g === 'number' && isFinite(g) && g >= 0 ){
            var v = input.value;
            $.post(config_assig.save_ajax_question, { aid:config_assig.assig_id , g:g,q:q,k:k,v:v});
            var parent = $(input).parent().parent();
            if( parent.hasClass("error") ){
                parent.removeClass("error");
            }
        }else{
            $.jGrowl("Error a intentar guardar pregunta.",{ header: 'Error',theme: "error"});
        }

    }
    //function saveAnswer(q,v){$.post(config_assig.save_ajax_question, { acid:config_assig.assig_id , q:q,rate:v } );}
    function cancelForm(){
        window.location = '<?php echo sfConfig::get("app_baseurl"); ?>';
    }
</script>

<div id="wrapper-content-survey">
    <div class="header">
        <div class="logo"><?php echo image_tag("utb_logo");?></div>
        <div class="logo2"><?php echo image_tag("utbv_logo");?></div>
    </div>
    <div class="survey-description">
        <p><span class="subtitle">Encuesta: </span><?php echo $survey["_title"] ?></p>
        <p><span class="subtitle">Fecha: </span><?php echo date("d-m-Y"); ?></p>
        <p><span class="subtitle">Descripción </span><?php echo html_entity_decode($survey["_description"]); ?></p>
    </div>
    <div class="content-body-survey">

        <form id="survey-assig-form" action="<?php echo url_for("survey/FinishSurvey"); ?>" method="POST">
            <input name="aid" value="<?php echo $assignment["_id"]; ?>" type="hidden" />
            <?php foreach($survey["groups"] as $key=>$group): ?>
            <div class="content-group" id="group-<?php echo $group["key"]; ?>" class="group">
                <div class="title"><?php echo $group["group_name"];?></div>
                <table class="content-question">
                    
                <?php foreach($group["questions"] as $key=>$question):?>
                    <?php $h=0; ?>
                    <tr>
                        <td>
                            <div class="question-body">
                                <div class="question_info">
                                    <p class="question_text" >
                                        <span class="index"><?php echo $question["index"]?> - </span>
                                        <?php echo $question["text"]?>
                                    </p>
                                </div>
                                <div class="clear"></div>
                                <div class="question_structure">
                                    <?php $sf_user->getStructureQuestion($question["type"]["name"],$group["key"],$question["key"],$question["type"]["structure"],$result,true);?>
                                </div>
                            </div> 
                        </td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
            <?php endforeach; ?>

            <div class="buttons">
                <input type="button" onclick="cancelForm();" value="Cancelar" id="cancel_form_survey" />
                <input type="submit" value="Guardar" id="save_form_survey"/>
            </div>

        </form>
    </div>

</div>

