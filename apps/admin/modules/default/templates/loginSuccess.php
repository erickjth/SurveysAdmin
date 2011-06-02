

<div class="title">Login</div>

<form action="<?php echo url_for('default/login') ?>" method="POST"> 
    <p class="fields">
            <?php if ($sf_user->hasFlash('notice')): ?>
                        <?php echo $sf_user->getFlash('notice') ?>
            <?php endif; ?>
            <?php if ($sf_user->hasFlash('error')): ?>
                <?php echo $sf_user->getFlash('error') ?>
            <?php endif; ?>
    </p>
    <p class="fields">
        <label for="username_admin">Usuario:</label>
        <input class="input" type="text" name="username_admin" id="username_admin">
    </p>
    <p class="fields">
        <label  for="password_admin">Contraseña:</label>
        <input class="input" type="password" name="password_admin" id="password_admin">
    </p>
    <p class="buttons">
        <input id="btn_login" type="submit" value="Login" />
    </p>
</form>
