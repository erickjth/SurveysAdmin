<?php

/**
 * default actions.
 *
 * @package    sf_sandbox
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

  }

  public function executeLogin(sfWebRequest $request){

    $this->setLayout("login");
    if(!$this->getUser()->isAuthenticated()){

      if ($request->isMethod('post')) {

          $username = $request->getParameter("username_admin");
          $pass     = md5($request->getParameter("password_admin"));
          
          /*if ($current_user = Doctrine::getTable("Teacher")->getTeacherByCode($username)) {

          }else{
              $this->getUser()->setFlash('error', "El usuario no existe en el sistema.");
          }
 
          $check = Doctrine::getTable("RolesAssignment")->createQuery("ra")
                      ->where("ra.user_id = ?",$current_user->id)
                      ->andWhere("ra.roles_id = 1")
                      ->fetchOne();

              if( $check instanceof RolesAssignment ){
                  $this->getUser()->setAuthenticated(true);
              }else{

              }*/
          
          if( $username == 'admin' && $pass == md5("admin@savio") ) {

              $this->getUser()->setAuthenticated(true);
              $this->getUser()->addCredential("admin");
              $this->redirect("default/index");

          }elseif( $username == 'consultas' && $pass == md5("consultas@evaluaciones2010") ){

              $this->getUser()->setAuthenticated(true);
              $this->getUser()->addCredential("consulting");
              $this->redirect("results/index");

          }else {
              $this->getUser()->setFlash('error', "Usuario o Contraseña Erroneos");
              $this->redirect("default/login");
          }
      }

    }else{
        $this->redirect("default/index");
    }
  }
  public function executeLogout(){
      $this->getUser()->clearCredentials();
      $this->getUser()->setAuthenticated(false);
      $this->redirect('default/login');
      return sfView::NONE;
  }

  public function executeSecure(){
      
  }
}
