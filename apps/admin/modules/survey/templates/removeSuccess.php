<b>Info:</b>
<?php if (isset($group)): ?>
    <p>Acabas de eliminar en esta encuesta el grupo: <?php echo @$group['group_name'] ?></p>
    <p>con numero de preguntas: "<?php echo count($group["questions"]) ?>"</p>

<?php else: ?>
    <p>Acabas de eliminar la encuesta : <?php echo @$survey['_title'] ?></p>
    <p>con el id: "<?php echo @$survey['_id'] ?>"</p>
    <p>con numero de grupos: "<?php echo count($survey["groups"]) ?>"</p>
<?php endif; ?>
