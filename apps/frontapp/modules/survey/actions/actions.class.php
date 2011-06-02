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
     */
    public function executeIndex(sfWebRequest $request) {
        
        if ($moodle_user_id = $this->getUser()->getUserMoodle()) {
            $courses = Doctrine::getTable("MdlCourse")->getCourseByUser($moodle_user_id, 5);

            if (count($courses)) {
                $assign_total_count = 0;
                $status_count = 0;
                //Instancio conexion a la base de datos en MongoDB
                $ss_instance = MongoManager::getConention();
                //Obtengo una instancia de la coleccion
                $assignments = $ss_instance->getCollection("assignments");
                $surveys = $ss_instance->getCollection("surveys");
                //Almacen de encuestas asignidas
                $survey_assignments = array();
   
                foreach ($courses as $key => $course) {
 
                    //Consultar asignaciones del curso.
                    $course_assignment = $assignments->find(array('course_id' => (int)$course["id"]));
                    
                    if( !$course_assignment->count() )
                        continue;
                    
                    foreach($course_assignment as $_id => $assign){
                        
                        //Obtengo información de la encuesta asignada
                        $survey = $surveys->findOne(
                                array(
                                    "_id"=>new MongoId($assign["survey_id"])
                                ),array("_title")
                        );
                        
                        if(!count($survey))continue;
                         
                        $collection_result_survey = $ss_instance->getCollection("r".$survey["_id"]);
                        $result = $collection_result_survey->findOne(
                                array(
                                    "assign_id"=>(string)$assign["_id"],
                                    "user_id"=>$moodle_user_id,
                                )
                        );
                        $assign_total_count++;
                        $status_count += ( (count($result))?( ($result["state"])?1:0 ):-1  );
                        //Guardo información de la encuesta 
                        $survey_assignments[] = array(
                          "assign_id"=>  $_id,
                          "survey_name"=> $survey["_title"],
                          "state"=>( (count($result))?( ($result["state"])?1:0 ):-1  )
                        );
                        
                    }
                    
                }
                
                //Cierro la conexion de la instancia
                $ss_instance->close(); 
                if($status_count == $assign_total_count){
                    if( $request->isXmlHttpRequest() ){
                        return sfView::NONE;
                    }
                    ////NO TIENE CURSOS
                }else{
                    if( $request->isXmlHttpRequest() ){
                        //$this->target_link = "target='_BLANK'";
                    }
                }
                
                //PARA VISUALIZAR EN LA VISTA
                $this->survey_assignments = $survey_assignments;

            } else {
                //NO TIENE CURSOS
                return sfView::NONE;
            }
            
        }else {
           //NO ESTA LOGEADO
           return sfView::NONE;
        }
    }

    /**
     * Executes ViewSurvey action
     *Visualiza la encuesta para la asignación.
     * @param int $aid a Assignment ID
     * @param sfRequest $request A request object
     */
    public function executeViewSurvey(sfWebRequest $request) {

        if (!$moodle_user_id = $this->getUser()->getUserMoodle()) {
            //NO ESTA LOGEADO
            return sfView::NONE;
        }

        $assig_id = $request->getParameter("aid");

        if (!$assig_id) {
            $this->getUser()->setFlash("error", "No existe referencia para asignación!");
            //NO HAY REFERENCIA DE ENCUESTAS
            $this->redirect("survey/index");
        }

        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collection = $ss_instance->getCollection("assignments");
        $surveys_collection = $ss_instance->getCollection("surveys");
                
        $course_assignment = $assignments_collection->findOne(array('_id' => new MongoID($assig_id)));
        
        if (!count($course_assignment)) {
            //NO EXISTE ASIGNACIÓN REFERENCIADA
            $this->getUser()->setFlash("error", "No existe asignación!");
            $ss_instance->close();
            $this->redirect("survey/index");
        }
        //no es del curso asignado el usuario
        if(! Doctrine::getTable("MdlCourse")->isUserInCourse($course_assignment["course_id"],$moodle_user_id)){
            $this->getUser()->setFlash("error", "Acceso denegado a la encuesta que trata de realizar!");   
            $ss_instance->close();
            $this->redirect("survey/index");
        }
                
        
        
        $survey = $surveys_collection->findOne( array("_id"=>new MongoId($course_assignment["survey_id"]) ) );
        
        if(!count($survey)){
            //NO EXISTE ENCUESTA REFERENCIADA
            $this->getUser()->setFlash("error", "No existe encuesta. Por favor contactar al administrador!"); 
            $ss_instance->close();
            $this->redirect("survey/index");
        }
        
        $result_collection = $ss_instance->getCollection("r".$course_assignment["survey_id"]);
        $result = array();
        
        $result_survey = $result_collection->findOne(array( 
            "user_id"=>$moodle_user_id,
            "assign_id"=>$assig_id
        ));
                      
        if(!count($result_survey)){
            $result_survey = array();
        }
        
        $ss_instance->close();
        $this->result = $result_survey;
        $this->assignment = $course_assignment;
        $this->survey = $survey;
        
    }

    
    public function executeSaveAnswerSurvey(sfWebRequest $request) {
        //if request is ajax
        if (!$request->isXmlHttpRequest() && !$request->isMethod("POST")) {
            return $this->renderText("REQUEST ERROR");
        }
        
        if (!$moodle_user_id = $this->getUser()->getUserMoodle()) {
            //NO ESTA LOGEADO
            return sfView::NONE;
        }
        
        $assig_id = $request->getParameter("aid");
        //group de la pregunta
        $g = $request->getParameter("g");
        //numero de la pregunta
        $q = $request->getParameter("q");
        //subpreguntas
        $k = $request->getParameter("k");
        //valor de la pregunta
        $v = $request->getParameter("v");
        
        
        if (!$assig_id) {
            //NO HAY REFERENCIA DE ENCUESTAS
            echo "Error: Dont exist reference!!"; 
            return sfView::NONE;
        }
        
        if( (!is_numeric($q) && $q >= 0) && (!is_numeric($g) && $g>=0) ){return sfView::NONE;}
        if(!$k == "null" && !is_numeric($k) ){return sfView::NONE;}
        
        
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collection = $ss_instance->getCollection("assignments");
        $surveys_collection = $ss_instance->getCollection("surveys");
        $course_assignment = $assignments_collection->findOne(array('_id' => new MongoID($assig_id)));
        
        if (!count($course_assignment)) {
            //NO EXISTE ASIGNACIÓN REFERENCIADA
            $ss_instance->close();
            echo "Error: Dont exist assignment reference!!"; 
            return sfView::NONE;
        }
        
        $survey = $surveys_collection->findOne( 
                array("_id"=>new MongoId( $course_assignment["survey_id"] ) )
        );
        
        if(!count($survey)){
            $ss_instance->close();
            echo "Error: Dont exist survey reference!!"; 
            return sfView::NONE;
        }
        
        $question = $survey["groups"][$g]["questions"][$q]["type"];
        $required = true;

        if($this->getUser()->validTypeQuestion($question["name"],$question["structure"],$v) || empty($v)  ){
            $collection_name = "r".$survey["_id"];
            
            MongoManager::addRateToMongo(
                    $collection_name, 
                    $moodle_user_id, 
                    $assig_id, 
                    $q, $v, $g, $k
            );
            echo "Saved succesfull!";
        }  else {
            echo "Error!";  
        }
        
        $ss_instance->close();        
        return sfView::NONE;
        
    }
   
    
    public function executeFinishSurvey(sfWebRequest $request){
        
        if (!$request->isMethod("POST")) {
            return $this->renderText("REQUEST ERROR");
        }
        
        if (!$moodle_user_id = $this->getUser()->getUserMoodle()) {
            //NO ESTA LOGEADO
            return sfView::NONE;
        }
        
        $assig_id = $request->getParameter("aid");
        
        if (!$assig_id) {
            //NO HAY REFERENCIA DE ENCUESTAS
            $this->getUser()->setFlash("error", "No existe referencia para asignación!");
            $this->redirect("survey/index");
        }
        
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collection = $ss_instance->getCollection("assignments");
        $surveys_collection = $ss_instance->getCollection("surveys");
        $course_assignment = $assignments_collection->findOne(array('_id' => new MongoID($assig_id)));
        
        if (!count($course_assignment)) {
            //NO EXISTE ASIGNACIÓN REFERENCIADA
            $this->getUser()->setFlash("error", "No existe asignación! ");
            $ss_instance->close();
            $this->redirect("survey/index");
        }
        
        $survey = $surveys_collection->findOne( 
                array("_id"=>new MongoId( $course_assignment["survey_id"] ) )
        );
        
        if(!count($survey)){
            $ss_instance->close();
            //NO EXISTE ENCUESTA REFERENCIADA
            $this->getUser()->setFlash("error", "No existe encuesta. Por favor contactar al administrador!");
            $this->redirect("survey/index");
        }
        $q = $request->getParameter("q");
        $collection_name = "r".$survey["_id"];
        $valid = true;
        foreach( $survey["groups"] as $k_g => $group  ){
            
            foreach($group["questions"] as $k_q => $question ){
                $type = $question["type"];
                if(is_array($q[$k_g][$k_q] )){
                    foreach($q[$k_g][$k_q] as $k_m => $sub ){
                        if($this->getUser()->validTypeQuestion($type["name"],$type["structure"],$sub) || (!$required && empty ($sub) ) ){
                                MongoManager::addRateToMongo(
                                        $collection_name, 
                                        $moodle_user_id, 
                                        $assig_id, 
                                        $k_q, $sub, $k_g, $k_m
                                );
                        }else{
                           $error = $type["name"].",q:".$k_q.",v: ".$v;
                           $valid = false;   
                        }
                    }
                }else{
                    $v= $q[$k_g][$k_q];
                    $required = true;
                    if($this->getUser()->validTypeQuestion($type["name"],$type["structure"],$v ) || (!$required && empty ($v) ) ){
                                MongoManager::addRateToMongo(
                                        $collection_name, 
                                        $moodle_user_id, 
                                        $assig_id, 
                                        $k_q, $v, $k_g, null
                                );
                     }else{
                         $error = $type["name"].",_,q:".$k_q.",v: ".$v;
                         $valid = false;  
                     }
                }            
            }
            
        }
        
        if( $valid ){
            $collection_survey = $ss_instance->getCollection($collection_name);
            $collection_survey->update(
                                        array('assign_id' => $assig_id, 'user_id' => $moodle_user_id),
                                        array('$set' => array("time" => time(), "state" => 1)),
                                        true
            );
            $this->getUser()->setFlash("notice", "Encuesta guardada correctamente. Gracias por participar. ");
        }else{
            $ss_instance->close();
            $this->getUser()->setFlash("error", "Algunos datos no son correctos, o no estan diligenciados. Por favor intente nuevamente!. ERROR: ".$error);
            $this->redirect("survey/viewSurvey?aid=$assig_id");
        }
        
        $ss_instance->close();
        $this->redirect("survey/index");
        return sfView::NONE;
        
        
    }
    
}
