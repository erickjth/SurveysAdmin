$(document).ready(function(){
    activeFaceBox();
    $(".but").button();
});

function activeEditor(e){
    $(e).cleditor({
        width:  595,
        height: 250
    });
}

function activeFaceBox(){
    $('a[rel*=facebox]').facebox();
}

function showMessage(message,header,theme){

    if(theme = "")
        theme =  "info-notification";
    
    $.jGrowl(message,
    {
        header: header,
        theme: theme
    }
    );
}

function toDate(value){

    var mEpoch = parseInt(value);
    if(mEpoch<10000000000){
        mEpoch *= 1000;
    }
    var myDate = new Date(mEpoch);

    return myDate.format("Y-m-d");

}

function selecGroup(a){
    var href = $(a).attr("href");
    $.ajax({
        type: "POST",
        url: href,
        data: {
            sid:sid
        },
        success: function(data){
            $("#infoGroup").html(data);
        }
    });
    return false; 
}

function loadType(a){
    
    var value = $(a).val();
         
    if(value != ""){
        $.ajax({
            type: "POST",
            url: $(a).attr("rel"),
            data: {
                qtype:value
            },
            success: function(data){
                $(".loadTypeQestion").html(data);
            }
        });
    } 
        
}
 
function editloadType(a){
    var href = $(a).attr("href");
    $.ajax({
        type: "POST",
        url: href,
        data: {
            qtype:sid,
            edit:edit
        },
        success: function(data){
            $(".loadTypeQestion").html(data);
        }
    });
    return false;  
}
 
//*******Eliminar un encuesta*************//
function removeSurvey(info,k){  
    
    if( confirm("¿Esta seguro de querer eliminar toda la encuesta?") ){            
        var href = $(info).attr("href");
        $.ajax({
            type: "POST",
            url: href,
            success: function(data){
                $(".removeSurveyInformation").html(data);
                $("#"+k+"").remove();
            }
        });   
    }
    
    return false;
  
}

function  removeGroupSurvey(info,key){  
   
    if( confirm("¿Esta seguro de querer eliminar el grupo de esta la encuesta?") ){            
        var href = $(info).attr("href");
        $.ajax({
            type: "POST",
            url: href,
            success: function(data){
                $(".removeGroupInformation").html(data);
                $("#"+key+"").remove();
                updateNoGroup();
            }
        });   
    }
    
    return false; 
}

function removeQuestionSurvey(info,key){  
    
    if( confirm("¿Esta seguro de querer eliminar esta pregunta?") ){            
        var href = $(info).attr("href");
        $.ajax({
            type: "POST",
            url: href,
            success: function(data){
                $(".removeQuestionInformation").html(data);
                $("#"+key+"").remove();
            }
        });   
    }
    
    return false; 
}



function reorganize(){        
    $("#sortable" ).sortable({
        cursor: 'crosshair'
    });
    $(".group").addClass("group-active"); 
    return false;
}
  
  
  
function saveReorganize(info){ 
    /******comentarios
    // $("#sortable" ).disableSelection();
    // alert(newPosition+sid);
    //$( "#sortable" ).bind();
     *******/
   
    var newPosition=$('#sortable').sortable('toArray');
    $( "#sortable" ).sortable( "option", "disabled", true );
    $(".group").removeClass("group-active"); 
    var href = $(info).attr("href");
    $.ajax({
        type: "POST",
        url: href,
        data: {
            position:newPosition  
        },
        success: function(data){
            showMessage("tu nueva organizacion fue guardada","Guardar organizacion","");
            $(".removeGroupInformation").html(data);
        }
    });  
    return false; 
    
}


function updateNoGroup(){
    var numeroGrupos=$(".group").length;
    $('#noGroup').text('No. Grupos: '+ numeroGrupos);
    return false;
}


function updateActiveSurvey(info,key){
    var href = $(info).attr("href");
    $.ajax({
        type: "POST",
        url: href,
        success: function(data){
            //alert(data);
          if(data==0){
              $("#"+key+" td:eq(4) p:eq(0)" ).removeClass("on");
              $("#"+key+" td:eq(4) p:eq(0)" ).addClass("off");
              $("#"+key+" td:eq(4) p:eq(1)" ).removeClass("off");
              $("#"+key+" td:eq(4) p:eq(1)" ).addClass("on");
              $("#"+key+" td:eq(3)").text('no');
           }else{
              $("#"+key+" td:eq(4) p:eq(0)" ).removeClass("off");
              $("#"+key+" td:eq(4) p:eq(0)" ).addClass("on");
              $("#"+key+" td:eq(4) p:eq(1)" ).removeClass("on");
              $("#"+key+" td:eq(4) p:eq(1)" ).addClass("off");
              $("#"+key+" td:eq(3)").text('si');
           }
            //$(".removeQuestionInformation").html(data);
            //$("#"+key+"").remove();
        }
    });  
    return false; 
}

