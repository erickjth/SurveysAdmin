<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <!--[if lt IE 7]>
        <script type="text/javascript" src="/workplansavio/js/jqueryPlugins/jquery.dropdown.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="result-content-wrapper">
        <?php echo link_to("Volver", "assignment/index", array("class" => "button")); ?>
            <div id="main-content">
                <?php echo $sf_content ?>
            </div>
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