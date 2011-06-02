<div class="content-default">
    <div class="title">Listado de usuarios</div>
    <table class="tablelist">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nombres</th>
                <th>E-mail</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($users as  $user): ?>
                <tr>
                    <td>
                        <?php echo $user['username']; ?>
                    </td>
                    <td>
                        <?php echo $user['fullname']; ?>
                    </td>
                    <td>
                        <?php echo $user["email"]; ?>
                    </td>
                    <td>
                        <a rel="faceboxy" href="<?php echo url_for("user/add"); ?>?uid=<?php echo $user['_id'];?>">Editar</a>|
                        <a href="<?php echo url_for("user/delete"); ?>?uid=<?php echo $user['_id'];?>">Eliminar</a>
                    </td>
                </tr>    
            <?php endforeach; ?>
                
        </tbody>
     </table>

    <div class="buttons">
        <a rel="faceboxy" href="<?php echo url_for("user/add"); ?>" class="button">Crear usuario</a>
    </div>
        
    </form>
</div>
