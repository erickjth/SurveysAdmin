<script type="text/javascript" >
    $(document).ready(function(){
        $("#add-user-form").validate();
    });
</script>

    <div class="content-default">
    
        <?php if (!isset($user)): ?>
            <div class="title">Crear usuario</div>
        <?php else: ?>
            <div class="title">Editar usuario</div>
        <?php endif; ?>
        
        <div  class="form-content-fix">
            <form id="add-user-form" action="<?php echo url_for("user/add") ?>" method="POST">
            
                <?php if (isset($user)): ?>
                    <input type="hidden" name="user[id]" value="<?php echo @$user['_id'] ?>" />
                <?php endif; ?>
                
                <p>
                    <label for="username">Nombre de usuario</label>
                    <input class="required big" name="user[username]" type="text" value="<?php echo @$user['username']; ?>"/>
                </p>
                <p>
                    <label for="username">Nombre completo</label>
                    <input class="required big" name="user[fullname]" type="text" value="<?php echo @$user['fullname']; ?>"/>
                </p>
                <p>
                    <label for="username">E-mail</label>
                    <input class="required email big" name="user[email]" type="text" value="<?php echo @$user['email']; ?>"/>
                </p>
                <p>
                    <label for="username">Contraseña</label>
                    <input class="<?php echo (!isset($user))?"required":"" ?> big" name="user[password]" type="password" value=""/>
                </p>
                <p>
                    <label for="username">Repita Contraseña</label>
                    <input class="<?php echo (!isset($user))?"required":"" ?> big" name="user[re-password]" type="password" value=""/>
                </p>
                <p>
                    <label for="username">Administrador</label>
                    <input type="checkbox" checked="<?php (isset($user['role']) && $user['role']=="superadmin")?"checked":"" ?>" name="user[role]" value="superadmin" />
                </p>
                
                
                <p class="buttons">
                    <input type="submit" id="create-user" value="Guardar"/>
                </p>
            </form>
        </div>
    </div>

