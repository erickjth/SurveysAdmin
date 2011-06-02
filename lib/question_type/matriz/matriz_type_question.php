<?php

function matriz_build_structure($g,$q,$structure,$result,$required=false){
    if(count($result))$r=true;
    else $r=false;
    include 'template.php';
}

function matriz_get_form_config($structure=null){
    include 'form.php';
}

function matriz_validate_value($value,$struct){
    if( !isset($struct["scale_header"]) ) return false;
    return in_array($value,$struct["scale_header"] );
}

function matriz_process_result($g,$q,$structure,$results){
    $r = array();
    $indice = "g".$g.",q".$q;
    if( isset($structure["scale_header"] ) && isset($structure["scale_text"] )){
        foreach($structure["scale_text"] as $t_k=>$text){
            foreach($results as $r_id=>$result){
                if( isset( $result[$indice.",m".$t_k] ) ){
                    if(in_array($result[$indice.",m".$t_k],$structure["scale_header"] ) ){
                        @$r[$t_k."-".$text][$result[$indice.",m".$t_k]]++;
                    }
                }else{
                    @$r[$t_k."-".$text]["-"]++;
                }
            }
        }
    }
    return $r;
}

function matriz_show_result($survey_name,$structure,$results){
    include 'result_template.php';
}

function matriz_get_structure(){
    return array(
        "scale_header"=>array(),
        "scale_text"=>array()
    );
}

function matriz_get_name(){
    return "Matriz";
}


?>
