<?php

/**
 * survey actions.
 *
 * @package    sf_sandbox
 * @subpackage survey
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class surveyActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     *
     */
    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeAddSurvey(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        if ($request->isMethod("POST")) {

            $survey = $request->getParameter('survey');
            $active = $request->getParameter('active');


            if (!(isset($survey["id"]))) {
                $row = array(
                    '_created_at' => time(),
                    '_title' => $survey["name"],
                    'active' => $active["type"],
                    '_description' => $survey["description"],
                    'position' => array(),
                    'groups' => array()
                );
                $collection_survey->save($row);
                $survey["id"] = $row["_id"];

                $mongo->close();
                $this->redirect("survey/addGroup?sid=" . $survey["id"]);
            } else {

                $newdata = array('$set' => array('_update_at ' => time(), '_title' => $survey["name"], '_description' => $survey["description"], 'active' => $active["type"]));
                $collection_survey->update(array('_id' => new MongoId($survey["id"])), $newdata);

                $mongo->close();
                $this->redirect("survey/listGroup?sid=" . $survey["id"]);
            }
        }



        $survey_id = $request->getParameter("sid");

        if ($survey_id) {
            $survey_edit = $collection_survey->findOne(
                            array("_id" => new MongoId($survey_id))
            );
            $this->survey = $survey_edit;
            $this->active = $survey_edit["active"];
            $mongo->close();
        }
    }

    public function executeListSurvey(sfWebRequest $request) {
        $mongo = MongoManager::getConention();
        $this->surveys = $mongo->getCollection("surveys")->find();
        $mongo->close();
    }

    public function executeAddGroup(sfWebRequest $request) {
        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");
        if ($request->isMethod("POST")) {

            $survey = $request->getParameter('survey');
            $group = $request->getParameter('group');

            if (!trim($group["key"])) {

                $survey_to_update = $collection_survey->findOne(
                                array(
                                    "_id" => new MongoId($survey["id"])
                                )
                );

                $id_group = $this->returnID($survey["id"]);


                $addPosition = count($survey_to_update["position"]);

                if ($addPosition == 0) {
                    $survey_to_update["position"][0] = $id_group;
                } else {
                    $survey_to_update["position"][$addPosition] = $id_group;
                }

                $survey_to_update["groups"][$id_group] = array(
                    "key" => $id_group,
                    "group_name" => $group["name"],
                    "group_description" => $group["description"],
                    "questions" => array()
                );

                $collection_survey->save($survey_to_update);

                $mongo->close();
                $this->redirect("survey/listGroup?sid=" . $survey["id"] . "&gid=" . $group["key"]);
            } else {

                $survey_to_update = $collection_survey->findOne(
                                array(
                                    "_id" => new MongoId($survey["id"])
                                )
                );

                $survey_to_update["groups"][$group["key"]]["group_name"] = $group["name"];
                $survey_to_update["groups"][$group["key"]]["group_description"] = $group["description"];

                $collection_survey->save($survey_to_update);

                $mongo->close();

                $this->redirect("survey/selectGroup?sid=" . $survey["id"] . "&gid=" . $group["key"]);
            }
        }


        $survey_id = $request->getParameter("sid");
        $group_id = $request->getParameter("gid");

        if ($survey_id) {

            $survey_edit = $collection_survey->findOne(
                            array("_id" => new MongoId($survey_id))
            );
            if ($survey_edit) {
                $this->survey = $survey_edit;
                if ($group_id) {
                    $this->group = $survey_edit["groups"][$group_id];
                }
                $mongo->close();
            } else {
                die("No existe el id del la encuesta");
            }
        } else {
            $survey_id = $request->getParameter("survey");
            $survey_edit = $collection_survey->findOne(
                            array("_id" => new MongoId($survey["_id"]))
            );

            if (count($survey_edit) > 1) {
                $this->survey = $survey_edit;
                $this->group = $survey["groups"][$group_id];
                $mongo->close();
            }
        }
    }

    public function executeListGroup(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");


        if ($request->isMethod("POST")) {
            echo"entro_dos";
        }


        /* Le mandamos la el id de la encuesta */
        $survey_id = $request->getParameter("sid");
        $group_id = $request->getParameter("gid");

        if ($survey_id) {

            $survey_edit = $collection_survey->findOne(
                            array(
                                "_id" => new MongoId($survey_id),
                            )
            );

            if ($survey_edit) {
                $this->survey = $survey_edit;
                //$this->group= $survey_edit["groups"][];
                $mongo->close();
            } else {

                die("No existe el id del la encuesta" . $survey_id);
            }
        } else {
            $survey_id = $request->getParameter("survey");
            $survey_edit = $collection_survey->findOne(
                            array("_id" => new MongoId($survey["_id"]))
            );

            if (count($survey_edit) > 1) {
                $this->survey = $survey_edit;
                $mongo->close();
            }
        }
    }

    public function executeSelectGroup(sfWebRequest $request) {
        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        if ($request->isMethod("POST")) {
            
        }

        $survey_id = $request->getParameter("sid");
        $group_id = $request->getParameter("gid");
        $tipeQuestion = $request->getParameter("tiq");
        $required = $request->getParameter("req");

        $survey = $collection_survey->findOne(
                        array(
                            "_id" => new MongoId($survey_id),
                        )
        );
        if (!isset($survey["_id"])) {
            die("No existe encuesta que trata de editar");
        }
        $this->survey = $survey;
        $this->group = $survey["groups"][$group_id];
        if ($tipeQuestion) {
            $this->tipeQuestion = $tipeQuestion;
        }
        if ($required) {
            $this->required = $required;
        }
    }

    public function executeAddQuestion(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");


        if ($request->isMethod("POST")) {

            //si vamos a crearla
            $survey = $request->getParameter('survey');
            $group_key = $request->getParameter('group');
            $question = $request->getParameter('question');
            $required = $request->getParameter('required');
            //required[type]
            $contentQuestion = $request->getParameter('form_type_question');

            if (!trim($question['key'])) {

                $survey_to_update = $collection_survey->findOne(
                                array(
                                    "_id" => new MongoId($survey)
                                )
                );
                $id_question = $this->returnID($survey_to_update["_id"], $group_key);
                //  $id_question = count($survey_to_update["groups"][$group_key]["questions"]);
                // $id_question++;
                //contador de preguntas(las cuento y las incremento)
                $survey_to_update["groups"][$group_key]["questions"][$id_question] = array(
                    "required" => $required["type"],
                    "key" => $id_question,
                    "index" => $question["index"],
                    "text" => $question["text"],
                    "help" => $question["help"],
                    "type" => array(
                        "name" => $question["type"],
                        "structure" => $contentQuestion
                    )
                );
                $collection_survey->save($survey_to_update);
            } else {

                //Vamos a atualizarlo
                $survey_to_update = $collection_survey->findOne(
                                array(
                                    "_id" => new MongoId($survey)
                                )
                );

                $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["required"] = $required["type"];
                $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["type"]["structure"] = $contentQuestion;
                $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["text"] = $question["text"];
                $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["help"] = $question["help"];
                $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["index"] = $question["index"];
                //print_r( $survey_to_update["groups"][$group_key]["questions"][$question["key"]]["type"]["structure"]);
                $collection_survey->save($survey_to_update);
            }

            $mongo->close();
            $this->survey = $survey_to_update;
            $this->redirect("survey/selectGroup?sid=" . $survey . "&gid=" . $group_key . "&tiq=" . $question["type"]);
        }

        $survey_id = $request->getParameter("sid");
        $group_id = $request->getParameter("gid");
        $question_id = $request->getParameter("qid");
        $question = $request->getParameter("question");
        $tipeQuestion = $request->getParameter("type");

        $survey = $collection_survey->findOne(
                        array(
                            "_id" => new MongoId($survey_id),
                        )
        );

        if (!isset($survey["_id"])) {
            die("No existe encuesta que trata de editar");
        }

        $this->survey = $survey;

        if (!isset($group_id)) {
            die("No se tiene el id del grupo a editar");
        }
        $this->group = $survey["groups"][$group_id];
        if ($tipeQuestion) {
            $this->tipeQuestion = $tipeQuestion;
        }
        if ($question_id) {
            $this->question = $survey["groups"][$group_id]["questions"][$question_id];
            $this->required = $survey["groups"][$group_id]["questions"][$question_id]["required"];
        }
        $mongo->close();
    }

    public function executeTypeQuestion(sfWebRequest $request) {

        if ($request->isMethod("POST")) {

            $tipeQuestion = $request->getParameter("qtype");
            $this->tipeQuestion = $tipeQuestion;
        }
    }

    public function executeRemove(sfWebRequest $request) {
        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        $survey_id = $request->getParameter("sid");
        $group = $request->getParameter("gid");
        $question = $request->getParameter("qid");

        $survey = $collection_survey->findOne(
                        array(
                            "_id" => new MongoId($survey_id),
                        )
        );

        if (isset($survey["_id"])) {
            if ($question) {
                //******guardo la pregunta antes de eliminarla para utilizarla en mi info******//        
                $this->question = $survey["groups"][$group]["questions"][$question];
                //******despues que la salvo la elimino*******//
                unset($survey["groups"][$group]["questions"][$question]);
                $collection_survey->save($survey);
                $this->survey = $survey;
                $mongo->close();
            } else if ($group) {
                //****guardo el grupo antes de eliminarlo para utilizarlo en mi info******//
                $this->group = $survey["groups"][$group];
                //***************despues lo elimino*************//
                unset($survey["groups"][$group]);


                //************Manipulamos el arrray de posiciones************************//
                $sizePosition = count($survey["position"]);
                $inc;
                foreach ($survey["position"] as $key => $position) {
                    //*******recorro todas las posiciones hasta encontrar la que se quiere eliminar*******//
                    if ($position == $group) {
                        $sizePosition--;

                        if ($key == $sizePosition) {
                            unset($survey["position"][$sizePosition]);
                        } else {

                            for ($i = $key; $i < $sizePosition; $i++) {
                                $inc = $i;
                                $inc++;
                                $survey["position"][$i] = $survey["position"][$inc];
                            }
                            unset($survey["position"][$sizePosition]);
                        }
                    }
                }

                //************guardamos los cambios**********************************//
                $collection_survey->save($survey);
                $this->survey = $survey;
                $mongo->close();
            } else {
                //**************si solo me mandan el id de la encuesta la elimino***********//
                $collection_survey->remove($survey);
                $this->survey = $survey;
                $mongo->close();
            }
        } else {
            die("No existe la encuesta que trata de manipular");
        }
        //   return sfView::NONE;
    }

    public function executeReorganize(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        //Guardamos la reorganizacion
        $survey = $request->getParameter('sid');
        $newPosition = $request->getParameter('position');

        $survey_to_update = $collection_survey->findOne(
                        array(
                            "_id" => new MongoId($survey)
                        )
        );

        if (isset($survey_to_update["_id"])) {
            $size = count($survey_to_update["position"]);
            for ($i = 0; $i < $size; $i++) {
                $survey_to_update["position"][$i] = (int) $newPosition[$i];
            }

            $collection_survey->save($survey_to_update);
            $mongo->close();
        } else {
            $mongo->close();
            die("No existe encuesta que trata de editar");
        }
    }

    public function executeUpdateActive(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        //Guardamos la reorganizacion
        $survey = $request->getParameter('sid');
        $active = $request->getParameter('active');

        $survey_to_update = $collection_survey->findOne(
                        array(
                            "_id" => new MongoId($survey)
                        )
        );

        if ($active != null) {
            //$this->redirect("survey/selectGroup");
            //die("Active es igual a" . (string) $active);
            if ($active == "true") {
                $survey_to_update["active"] = "si";
                $active = 1;
            } else {
                $active = 0;
                $survey_to_update["active"] = "no";
            }
            $collection_survey->save($survey_to_update);
            $mongo->close();
        } else {
            $active = -1;
            die("error de activacion");
        }
        return $this->renderText($active);
    }

    public function executeProcessQuestion(sfWebRequest $request) {

        $mongo = MongoManager::getConention();
        $collection_templates = $mongo->getCollection("templates");

        $form = $request->getParameter('form_type_question');
        $type = $request->getParameter('type');
        $description = $request->getParameter('description');
        $paste = $request->getParameter('paste');
        $id = $request->getParameter('id');

        if ((string) $paste == "true") {

            if ($id) {
                $headers = $collection_templates->find(
                                array(
                                    "_id" => new MongoId($id)
                                )
                );
                $mongo->close();
                return $this->renderText(json_encode(iterator_to_array($headers)));
            } else {
                $headers = $collection_templates->find(
                                array(
                                    "type" => $type
                                )
                );
                $mongo->close();
                return $this->renderText(json_encode(iterator_to_array($headers)));
            }
        } else {
            if ($form) {
                $info = array(
                    "type" => $type,
                    "description" => $description,
                    "structure" => $form
                );
                $collection_templates->save($info);
                $mongo->close();
            }
        }


        return sfView::NONE;
    }

    function returnID($survey_id, $group_id=NULL) {

        $mongo = MongoManager::getConention();
        $collection_survey = $mongo->getCollection("surveys");

        $survey = $collection_survey->findOne(
                        array("_id" => new MongoId($survey_id))
        );

        if ($group_id != NULL) {
            $group = $survey["groups"][$group_id];
            $id_question = count($group["questions"]);
            foreach ($group["questions"] as $key => $question) {
                if ($question["key"] > $id_question) {
                    $id_question = $question["key"];
                }
            }
            $mongo->close();
            $id_question++;
            echo $id_question;
            return $id_question;
        } else {
            $id_group = count($survey["groups"]);
            foreach ($survey["groups"] as $key => $group) {
                if ($group["key"] > $id_group) {
                    $id_group = $group["key"];
                }
            }
            $id_group++;
            $mongo->close();
            return $id_group;
        }
    }

}

