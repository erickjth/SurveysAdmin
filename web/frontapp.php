<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
require_once dirname(__FILE__).'/../../vmoodle/config.php';
$configuration = ProjectConfiguration::getApplicationConfiguration('frontapp', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
