<?php

class myUser extends sfBasicSecurityUser
{
    public function getUserMoodle(){
        if( isset( $_SESSION["USER"] ) ){
            return (int)$_SESSION["USER"]->id;
        }
        //return null;
        return 3;//usuario prueba
    }
    
    public function getStructureQuestion($type,$g,$q,$structure,$result,$required=false){
        $dir_type = sfConfig::get("sf_lib_dir")."/question_type/".$type;
        if(is_dir($dir_type) ){
            $this->getContentHeader($type);
            include_once "{$dir_type}/{$type}_type_question.php";
            if($required){$required="required";}
            call_user_func("{$type}_build_structure",$g,$q ,$structure,$result,$required);
        }else{
            echo "Error al cargar tipo de pregunta. ERROR: No existe plugins";
        }
        //$type_build_structure();
    }
    
    public function getTypeQuestionForm($type, $structure=null) {

        $dir_type = sfConfig::get("sf_lib_dir") . "/question_type/" . $type;
        if (is_dir($dir_type)) {
            include_once "{$dir_type}/{$type}_type_question.php";
            call_user_func("{$type}_get_form_config", $structure);
        } else {
            echo "Error al cargar tipo de pregunta. ERROR: No existe plugins";
        }
    }
    
    public function getTypeQuetions(){
        
    }
    
    public function getContentHeader($type) {
        $dir_type = sfConfig::get("sf_lib_dir")."/question_type/".$type;
        $header = "";
        $js = $css = "";
        if(is_dir($dir_type) ){
            if (is_file($dir_type . "/style.css")){
                $css = file_get_contents($dir_type . "/style.css");
                $header .= "<style>$css</style>\n";
            }
            if (is_file($dir_type . "/script.js")){
                $js = file_get_contents($dir_type . "/script.js");
                $header .= "<script type='text/javascript'>$js</script>";
            }
        }
        echo $header;    
    }

    public function validTypeQuestion($type,$struct,$v){
        $dir_type = sfConfig::get("sf_lib_dir")."/question_type/".$type;
        if(is_dir($dir_type) ){
            include_once "{$dir_type}/{$type}_type_question.php";
            return call_user_func("{$type}_validate_value",$v ,$struct);
        }else{
            echo "Error al cargar tipo de pregunta. ERROR: No existe plugins";
        }
        
        return false;
    }
    
    public function proccessResultQuetions($type,$g,$q,$structure,$result) {
        $dir_type = sfConfig::get("sf_lib_dir") . "/question_type/" . $type;
        if (is_dir($dir_type)) {
            include_once "{$dir_type}/{$type}_type_question.php";
            return call_user_func("{$type}_process_result",$g,$q,$structure,$result);
        } else {
            echo "Error al cargar tipo de pregunta. ERROR: No existe plugins";
        }
    }

    public function showResultQuestion($survey_name,$type,$structure,$result) {
        $dir_type = sfConfig::get("sf_lib_dir") . "/question_type/" . $type;
        if (is_dir($dir_type)) {
            include_once "{$dir_type}/{$type}_type_question.php";
            call_user_func("{$type}_show_result",$survey_name,$structure,$result);
        } else {
            echo "Error al cargar tipo de pregunta. ERROR: No existe plugins";
        }
    }
}

