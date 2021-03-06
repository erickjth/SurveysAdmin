<?php
// auto-generated by sfViewConfigHandler
// date: 2011/06/02 07:12:41
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'ADMIN - SAVIO-Survey', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addStylesheet('mainSurvey.css', '', array ());
  $response->addStylesheet('jquery_plugins/jquery_ui1812.css', '', array ());
  $response->addStylesheet('jquery_plugins/facebox.css', '', array ());
  $response->addStylesheet('jquery_plugins/jgrow.css', '', array ());
  $response->addJavascript('jquery152min.js', '', array ());
  $response->addJavascript('jquery_ui1812min.js', '', array ());
  $response->addJavascript('jquery_validatemin.js', '', array ());
  $response->addJavascript('jgrow.js', '', array ());
  $response->addJavascript('facebox.js', '', array ());
  $response->addJavascript('main_admin.js', '', array ());


