<?php

/**
 * user actions.
 *
 * @package    sf_sandbox
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //Instancio conexion a la base de datos en MongoDB
        $ss_instance = MongoManager::getConention();
        //Obtengo una instancia de la coleccion
        $users_collections = $ss_instance->getCollection("users");
        $users = $users_collections->find()->sort(array("_id" => -1));
        $ss_instance->close();
        $this->users = $users;
    }

    public function executeAdd(sfWebRequest $request) {
        
        $ss_instance = MongoManager::getConention();
        ////Obtengo una instancia de la coleccion
        $user_collections = $ss_instance->getCollection("users");

        if ($request->isMethod("POST")) {
            
            $user = $request->getParameter("user");
            if( isset( $user["id"] ) ){
               $user_save = $user_collections->findOne(array("_id"=>new MongoId($user["id"])));
            }else{
               $user_save = array(); 
               
            }
            
            $user_save["username"] =  $user["username"];
            $user_save["fullname"] =  $user["fullname"];
            $user_save["email"] =  $user["email"];
            $user_save["role"] = $user["role"];
            if( !empty ($user["password"]) ){
                $user_save["password"] =  md5($user["password"]);
            }
            $user_collections->save($user_save);
            
            $ss_instance->close();
            $this->redirect("user/index");
        }

        $user_id = $request->getParameter("uid");
        if( isset ($user_id) && $user_id ){
            $user =  $user_collections->findOne(array("_id"=>new MongoId($user_id)));
            $ss_instance->close();
            if(count($user)){
                $this->user = $user;
            }else{
                 $this->getUser()->setFlash("error", "No existe usuario que intenta editar");
                 $this->redirect("user/index");
            }
        }

        $ss_instance->close();
    }

    public function executeDelete(sfWebRequest $request) {
        
        $ss_instance = MongoManager::getConention();
        ////Obtengo una instancia de la coleccion
        $user_collections = $ss_instance->getCollection("users");

        $user_id = $request->getParameter("uid");
        
        if( isset ($user_id) && $user_id ){
            $user =  $user_collections->findOne(array("_id"=>new MongoId($user_id)));
            if(count($user)){
                $user_collections->remove($user);
                $this->getUser()->setFlash("error", "Usuario borrado correctamente");
            }else{
                 $this->getUser()->setFlash("error", "No existe usuario que intent borrar");
                 
            }
        }
        $ss_instance->close();
        $this->redirect("user/index");
    }
    
}
