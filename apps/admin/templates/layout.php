<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="main-wrapper">
            <div id="menuContenido">
                <div class="tituloBloqueMenu">
                    <b>SAVIO</b>Survey<span style="font-size:13px; vertical-align:middle"> (gestor de encuestas:Vista Administrativa)</span>
                </div>
		<?php echo link_to("listado de encuestas", "survey/listSurvey", array("class" => "button")); ?> |
		<?php echo link_to("Agregar encuestas", "survey/addSurvey", array("class" => "button")); ?>|
		<?php echo link_to("Asignaciones de encuestas", "assignment/index", array("class" => "button")); ?>|
		<?php echo link_to("Usuarios", "user/index", array("class" => "button")); ?>|
		<?php echo link_to("Salir", "default/logout", array("class" => "button")); ?>

            </div>
            <div id="main-content">
                <?php echo $sf_content ?>
            </div>
        </div>
        <div id="loading">

        </div>
        <div id="notification-sf">
            <?php if ($sf_user->hasFlash('notice')): ?>
                <div class="notice"><?php echo $sf_user->getFlash('notice') ?></div>
            <?php endif; ?>
            <?php if ($sf_user->hasFlash('error')): ?>
                <div class="error"> <?php echo $sf_user->getFlash('error') ?></div>
            <?php endif; ?>
        </div>
    </body>
</html>
