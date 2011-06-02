<script type="text/javascript" >
    $(document).ready(function(){});
    //$( "#sortable" ).css({'background-color':'#f5f5f5', 'border':'1px solid #dedede','border-top':'1px solid #eee', 'border-left':'1px solid #eee'});
    /* var content=<?php //echo image_tag('move')                                                        ?>;
        var group=$("#adrian");
        group.append(content).show("slow");
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
     *
     * 
     *   */
    
</script>

<script type="text/javascript">
    var sid = '<?php echo $survey["_id"]; ?>';
</script>


<div id="main-content">

    <div class="content-default">
        <div class="title">Editar encuesta</div>
        <!--Contenedor de la informacion de la encuesta-->

        <div class="surveyInformation">

            <div class="editSurveyInformation">
                <a href="<?php echo url_for("survey/addSurvey?sid={$survey['_id']}"); ?>" rel="facebox" title="Editar informacion de encuesta."><?php echo image_tag("edit-infoSurvey") ?></a>
            </div> 

            <?php if (isset($survey)): ?>
                <p><b>Encuesta ID: </b><?php echo $survey['_id'] ?></p>
                <p><b>Encuesta Seleccionada:</b><?php echo $survey['_title'] ?></p>
                <div class="surveyDescription"><b>Descripción: </b><?php echo $survey['_description'] ?></div>
            <?php endif; ?>
        </div>


        <!--Contenedor de todos los grupos-->
        <div id="contenedorGroup">  
            <div class="title">Ediccion de grupos</div>
            <div id="adrian"></div>
            <div id="buildGroupInfo">
                <h3>Opciones Grupo</h3>

                <div id="noGroup" style="padding:10px 10px 10px 0px"></div>
                <div>
                    <a href="<?php echo url_for("survey/listSurvey"); ?>" title="Guardar cambios."><?php echo image_tag("save-group") ?></a>
                    <a rel="facebox" href="<?php echo url_for("survey/addGroup?sid={$survey['_id']}"); ?>" class="buttons" title="Agregar nuevo Grupo."><?php echo image_tag("add-group") ?></a>
                    <a href="javascript:void(0);" onclick="return reorganize();" title="Reorganizar grupos"><?php echo image_tag("reorganize") ?></a>
                    <a href="<?php echo url_for("survey/reorganize?sid={$survey['_id']}"); ?>" onclick="return saveReorganize(this);" title="Guardar reorganizacion"><?php echo image_tag("save_reorganize") ?></a>
                </div>



                <ul id="sortable" <?php if (!count($survey["groups"])): ?>style="display: none;" <?php endif; ?> >


                    <?php
                    $group_print = 0;
                    $size = count($survey["position"]);
                    $size--;
                    ?>
                    <?php while ($group_print != count($survey["position"])): ?>

                        <?php $i = $group_print; ?>
                        <?php foreach ($survey["groups"] as $key => $group): ?>


                            <?php if ($survey["position"][$i] == $key): ?>

                                <div class="group" id="<?php echo $key ?>">
                                    <div class="option-group">
                                        <p> 
                                            <span class="drag"><?php echo image_tag("move-group") ?></span>
                                            <a href="<?php echo url_for("survey/selectGroup?gid={$group["key"]}&sid={$survey['_id']}"); ?>" title="Editar Grupo"><small><?php echo image_tag("edit-group") ?></small></a>                           
                                            <a href="<?php echo url_for("survey/remove?sid={$survey['_id']}&gid={$group["key"]}"); ?>" onclick="return removeGroupSurvey(this,'<?php echo $key; ?>');" title="Eliminar grupo"><small><?php echo image_tag("delete-group") ?></small></a>
                                        </p>      
                                    </div>
                                    <div class="content-group">
                                        <p><span style="color:#4BA80E">Nombre Grupo:</span> <?php echo $group["group_name"]; ?></p>
                                        <p><span>Grupo ID: </span><?php echo $group["key"]; ?></p>
                                        <div><span>Descripcion de Grupo:</span><?php echo $group['group_description']; ?></div>

                                        <?php //recorremos todas las preguntas del grupo si existen?>

                                        <?php if (count($group["questions"])): ?>

                                            <span>Numero de preguntas:</span> <?php echo count($group["questions"]); ?><br/>
                                            <?php foreach ($group["questions"] as $key => $question): ?>
                                                <br/>
                                                <span>Pregunta:</span> <?php echo $question["text"]; ?>
                                                <span>Tipo de Pregunta:</span> <?php echo $question["type"]["name"]; ?>
                                            <?php endforeach; ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php $group_print++; ?>
                                <?php if ($i != $size): ?>
                                    <?php $i++; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endwhile; ?>

                </ul>

            </div>
            <div class="removeGroupInformation">

                <script type="text/javascript">
                    var numeroGrupos=$(".group").length;
                    $('#noGroup').text('No. Grupos: '+ numeroGrupos);
                </script>

            </div>
        </div>
    </div>

</div>



