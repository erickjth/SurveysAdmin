    
<div class="content-default">
    <div class="title">Listado de asignaciones</div>
    <form action="<?php echo url_for("process_responses/getAssignment"); ?>" method="POST">
    <table class="tablelist">
        <thead>
            <tr>
                <th></th>
                <th>Encuesta</th>
                <th>Curso</th>
                <th>Fecha creación</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($assignments as  $assig): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="assignments[]" value="<?php echo $assig['_id']; ?>"/>
                    </td>
                    <td>
                        <?php echo $assig['survey_title']; ?>
                    </td>
                    <td>
                        <?php echo $assig["course_name"]; ?>
                    </td>
                    <td>
                        <?php echo date("d-m-Y",$assig['created_at']); ?>
                    </td>
                    <td>
                        <a href="<?php echo url_for("assignment/addUsers"); ?>?sid=<?php echo  $survey['_id'];?>">Usuarios</a>|
                        <a href="<?php echo url_for("assignment/delete"); ?>?sid=<?php echo  $survey['_id'];?>">Eliminar</a>
                    </td>
                </tr>    
            <?php endforeach; ?>
                
        </tbody>
     </table>
    <div class="page-manage">
        <?php if(isset ($pages)): ?>
        <ul>
            <?php for($i=0;$i<$pages;$i++):?>
            <?php if($i==$current):?>
                <li class="current-page"><?php echo $i+1; ?></li>
            <?php else:?>
                <li><?php echo link_to($i+1,"assignment/index?p=".($i+1).""); ?></li>   
            <?php endif;?>
             
            <?php endfor?>
        </ul>
            
        <?php endif;?>
    </div>

    <div class="buttons">
        <input type="submit" class="button" value="Procesar encuestas seleccionadas" />
        <a rel="faceboxy" href="<?php echo url_for("assignment/addCoursAssignment"); ?>" class="button">Crear asignación</a>
        <a rel="faceboxy" href="<?php echo url_for("assignment/addUserAssignment"); ?>" class="button">Crear asignación a usuario(s).</a>
    </div>
        
    </form>
</div>
