<?php

function freetext_build_structure($g,$q,$structure,$result,$required=false){
    if(count($result))$r=true;
    else $r=false;
    include 'template.php';
}

function freetext_get_form_config($structure=null){
    include 'form.php';
}

function freetext_validate_value($value,$struct){
    return true;
}

function freetext_get_name(){
    return "Texto libre";
}

?>
