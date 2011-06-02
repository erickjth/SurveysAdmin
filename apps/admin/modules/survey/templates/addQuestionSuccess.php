<script type="text/javascript" >

    $(document).ready(function(){
        $("#add-question-survey-form").validate({
            errorLabelContainer: $("#error")
        });
    });
   
</script>

<div class="content-default content-facebox">
    <?php if (!isset($tipeQuestion)): ?>
        <div class="title">Formulario añadir pregunta.</div>
    <?php else: ?>
        <div class="title">Formulario editar pregunta.</div>
    <?php endif; ?>

    <div id="box-info-survey-create">
        <div id="create-question-survey" class="content-build-survey">
            <form action="<?php echo url_for("survey/addQuestion") ?>" id="add-question-survey-form" method="POST">

                <input type="hidden" name="survey" value="<?php echo @$survey['_id'] ?>">
                <input type="hidden" name="group" value="<?php echo @$group['key'] ?>">
                <input type="hidden" name="typeQuestion" value="<?php echo @$question["type"]["name"] ?>">
                <input type="hidden" name="question[key]" value="<?php echo @$question['key'] ?>">

                <div class="list">
                    <div> 
                        <div style="display:block; background:#F6F6F6; border:1px solid #CCC; padding: 10px 0px 10px 10px; margin:10px 0px 10px 10px;width: 97%;">
                            <p>
                                <b>Indice:</b>
                                <input style="height: 24px; width: 83px;  margin:5px 0px 0px 0px; " value="<?php echo @$question['index']; ?>"  name='question[index]' type='text'/>
                            </p>
                            <p style="margin:5px 0px 0px 0px;">
                                <b>Obligatoria:</b>
                                <select name="required[type]">
                                    <?php if (isset($required)): ?>   
                                        <?php if ($required == "si"): ?> 
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        <?php else: ?>
                                            <option value="no">No</option>
                                            <option value="si" >Si</option>
                                        <?php endif; ?>
                                    <?php else: ?>  
                                        <option value="si">Si</option>
                                        <option value="no">No</option> 
                                    <?php endif; ?>
                                </select>
                            </p>
                            <p>
                                <b>Texto de la Pregunta:</b>
                                <input class='required big' value="<?php echo @$question['text']; ?>"  name='question[text]' type='text'/>
                            </p>
                            <p>
                                <b>Ayuda:</b>
                                <input style="height: 24px; width: 628px;  margin:5px 0px 0px 0px;" value="<?php echo @$question['help']; ?>"  name='question[help]' type='text'/>
                            </p>



                        </div>
                        <?php if (isset($question["type"]["name"])): ?>     
                            <?php $sf_user->getTypeQuestionForm($question["type"]["name"], $question["type"]["structure"]); ?>
                        <?php else: ?>
                            <b style="margin:0px 0px 0px 10px"> Tipo pregunta:</b>
                            <select rel="<?php echo url_for("survey/typeQuestion"); ?>" name="question[type]" onchange="loadType(this);">
                                <option value="">...</option>
                                <option value="matriz" >Escala (1 - 5)</option>
                                <option value="text">Texto</option>
                                <option value="freetext">Free Texto</option>
                            </select>
                        <?php endif; ?>
                        </p>

                    </div>

                    <div style="" class="loadTypeQestion">

                    </div>


                </div>

                <div class="buttons">
                    <input type="button" value="Cancelar" />
                    <input id="create-question" type="submit" value="Guardar pregunta" />
                </div>
            </form>
        </div>
    </div>


</div>