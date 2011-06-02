<?php

/**
 * assignment actions.
 *
 * @package    sf_sandbox
 * @subpackage assignment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class assignmentActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $assignments_collections = $ss_instance->getCollection("assignments");
        $assignments = $assignments_collections->find()->sort(array("_id" => -1)); 
        $ss_instance->close();
        $this->assignments =$assignments;
        $this->pages = $n_page;
        $this->current = $current;
    }
    
    public function executeAdd(sfWebRequest $request){
        $ss_instance = MongoManager::getConention();
        
        if($request->isMethod("POST")){
            $course_id = $request->getParameter("course_id");
            $survey_id = $request->getParameter("survey_id");
            
            $survey = $ss_instance->getCollection("surveys")->findOne(array( "_id"=>new MongoId($survey_id) ),array("_id","_title"));
            $course = Doctrine::getTable("MdlCourse")->find($course_id);
            if( count($survey) && $course instanceof MdlCourse){
                
                $assign_collections = $ss_instance->getCollection("assignments");
                
                $assing  = $assign_collections->findOne( array( 
                    "survey_id"=>(string)$survey_id ,
                    "course_id"=>(int)$course_id )
                );
                
                if(count($assing)){
                    $this->getUser()->setFlash("error", "Ya existe esta asignación. Intente nuevamente");
                }  else {
                    $assign_collections->insert( array( "survey_id"=> $survey_id,"survey_title"=>$survey["_title"],"course_id"=>(int)$course_id,"course_name"=>$course["fullname"],"created_at"=>time()) );
                }
                
            }else{
                $this->getUser()->setFlash("error", "No existe curso o encuesta!");
            }

            $this->redirect("assignment/index");
        }

        //Obtengo una instancia de la coleccion
        $survey_collections = $ss_instance->getCollection("surveys");
        $surveys = $survey_collections->find(array(),array("_id","_title"));
        $ss_instance->close();
        $this->surveys = $surveys;
    }
    
    public function executeGetCourses(sfWebRequest $request){
        $term = $request->getParameter("term");
        
        $return = array();
        if( isset ($term) && $term){
            $return = Doctrine::getTable("MdlCourse")->createQuery()
                    ->select("id,fullname,idnumber")
                    ->where("fullname LIKE ?","%".$term."%")->fetchArray();
        }
        
        return $this->renderText( json_encode($return) );        
        
    }
    
    public function executeGetUsers(sfWebRequest $request){
        $term = $request->getParameter("term");
        
        $return = array();
        if( isset ($term) && $term){
            $return = Doctrine::getTable("MdlUser")->createQuery()
                    ->select("id,username,firtsname,lastname")
                    ->where("username LIKE ?","%".$term."%")->fetchArray();
        }
        
        return $this->renderText( json_encode($return) );        
        
    }

    public function executeAddUsers(sfWebRequest $request){
        $assign_id = $request->getParameter("aid");
        if( !$assign_id ){
            $this->getUser()->setFlash("error", "Bad Reference");
            $this->redirect("assignment/index");
        }
        
        
    }
}
