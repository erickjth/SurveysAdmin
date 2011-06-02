<script>
    $(document).ready(function(){
        $( "#course" ).autocomplete({
            minLength: 3,
            source: "<?php echo url_for("assignment/getCourses"); ?>",
            focus: function( event, ui ) {
                $( "#course" ).val( ui.item.fullname );
                return false;
            },
            select: function( event, ui ) {
                $( "#course" ).val( ui.item.fullname );
                $( "#course_id" ).val( ui.item.id );                
                return false;
            }
        })
        .data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>" + item.fullname + "</a>" )
            .appendTo( ul );
        };
    });
</script>
<form action="<?php echo url_for("assignment/add");?>" method="POST">
    <input id="course" name="course"/><input type="hidden" name="course_id" id="course_id"/>
    <select name="survey_id" style="width:50%;">
        <option value="">...</option>
        <?php foreach($surveys as $k=>$survey):?>
        <option value="<?php echo $survey["_id"]?>"><?php echo $survey["_title"] ?></option>
        <?php endforeach;?>
    </select>
    <input type="submit" value="Crear" class="button" />
</form>
