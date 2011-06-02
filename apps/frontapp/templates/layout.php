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
          <div id="main-content">
              <?php echo $sf_content ?>
          </div>
      </div>
      <div id="loading">

      </div>
      <div id="notification-sf">
            <?php if ($sf_user->hasFlash('notice')): ?>
                <script>showMessage("<?php echo $sf_user->getFlash('notice') ?>","Notificación")</script>
            <?php endif; ?>
            <?php if ($sf_user->hasFlash('error')): ?>
                <script>showMessage("<?php echo $sf_user->getFlash('error') ?>","Notificación")</script>
            <?php endif; ?>
      </div>
  </body>
</html>
