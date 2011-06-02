<?php

/**
 * process_responses actions.
 *
 * @package    sf_sandbox
 * @subpackage process_responses
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class process_responsesActions extends sfActions
 {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

    }
    
    public function executeGetAssignment(sfWebRequest $request){
        $this->setLayout("result_layout");
        
        $assignments = $request->getParameter("assignments");
        
        if(!isset ($assignments) && !count($assignments)){
            $this->getUser()->setFlash("error", "Seleccione encuestas!");
            $this->redirect("assignment/index");
        }
        
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collections = $ss_instance->getCollection("assignments");
        $survey_collections = $ss_instance->getCollection("surveys");
        
        $selected_assigment = array();
        
        foreach($assignments as $aid){
            $a = array();
            $assignment = $assignments_collections->findOne(
                    array("_id"=>new MongoId($aid))
            );
            
            if(count($assignment) && $assignment){
                $survey = $survey_collections->findOne( array("_id" => new MongoId($assignment["survey_id"])) );
                $assignment["survey"]=$survey;
            }
            
            $selected_assigment[] = $assignment;
        }
        $ss_instance->close();
        $this->selected_assignments = $selected_assigment; 
    }

    public function executeProcess(sfWebRequest $request){
        $process = $request->getParameter("process");
                
        if(!isset ($process) && !count($process)){
            return $this->renderText("<h2 style='text-align:center;'>SELECCIONE POR LO MENOS UNA PREGUNTA!</h2>");
        }
        $empty = false;
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collections = $ss_instance->getCollection("assignments");
        $survey_collections = $ss_instance->getCollection("surveys");
        $result_code = 0;
        //SOLO HACE UN SOLO RECORRIDO EN TODOS MENOS EN LOS RESULTADOS
        foreach($process as $i=>$assig){
            $q_r = array();
            $q_e = array();
            $type_name = "";
            $question_text = "";
            $survey_name = array();
            foreach($assig as $assig_id=>$survey ){
                foreach($survey as $survey_id=>$group){
                    
                    $survey_structure = $survey_collections->findOne(array("_id"=>new MongoId($survey_id)));
                    $result_collection = $ss_instance->getCollection("r".$survey_id);
    
                    $results =  $result_collection->find(array("assign_id"=>$assig_id));
                    $results = iterator_to_array($results);
                    
                    if($survey_structure && count($results)){
                        $survey_name[]=$survey_structure["_title"];
                        foreach($group as $g_k=>$question){
                            foreach($question as $q_k=>$type){
                                
                                    $type_name = $type;
                                    $q_r[$assig_id] = $this->getUser()->proccessResultQuetions(
                                                            $survey_structure["groups"][$g_k]["questions"][$q_k]["type"]["name"],
                                                            $g_k,
                                                            $q_k,
                                                            $survey_structure["groups"][$g_k]["questions"][$q_k]["type"]["structure"],
                                                            $results
                                    );
                                    $q_r[$assig_id]["result_code"] = $result_code;
                                    $q_r[$assig_id]["q_index"] = $survey_structure["groups"][$g_k]["questions"][$q_k]["index"];
                                    $q_r[$assig_id]["q_key"] = $survey_structure["groups"][$g_k]["questions"][$q_k]["key"];
                                    $q_r[$assig_id]["q_text"] = $survey_structure["groups"][$g_k]["questions"][$q_k]["text"];
                                    $q_r[$assig_id]["total"]=count($results);
                                    $q_e[$assig_id] = $survey_structure["groups"][$g_k]["questions"][$q_k]["type"]["structure"];
                                    
            
                            } 
                        }
                    }
                        
                }
                
            }
            if( count($q_e) && count( $q_r) ){
                $this->getUser()->showResultQuestion( $survey_name,$type_name, $q_e, $q_r);
            }else{
               $empty = true;
            }
            $result_code++;
        }
        
        if($empty){
            echo "NO HAY RESULTADOS AUN!";
        }
        
        $ss_instance->close();
        return sfView::NONE;
    }
}
