<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MongoManager
 *
 * @author erick
 */
class MongoManager {
    
    private static $mongoconection;
    
    static function getConention(){
        
        if (  !self::$mongoconection instanceof Mongo_db) 
        {  
            $db_name = sfConfig::get("app_mongodb_name");
	    $db_host = sfConfig::get("app_mongodb_host");
	    $db_user = sfConfig::get("app_mongodb_user");
	    $db_pass = sfConfig::get("app_mongodb_pass");
            self::$mongoconection = new Mongo_db($db_name,$db_host,$db_user,$db_pass); 
        } 
          return self::$mongoconection; 
    }
    
    static public function addRateToMongo($collection,$uid,$aid,$q,$v,$g,$m,$finish = false){
        
        $mongo = MongoManager::getConention();
        
        $collection_result_survey = $mongo->getCollection($collection);

        $result = $collection_result_survey->findOne(
                array(
                    'assign_id'=> $aid,
                    'user_id'=>$uid
                )
        );

        $q_struct;
        if (isset($m) && is_numeric($m)) {
            $m = ",m{$m}";
        } else {
            $m = "";
        }
            
        //exist a row for assignment
        if( count($result) ){

            $collection_result_survey->update(
                    array( 'assign_id' => $aid,'user_id'=>$uid ),
                    array('$set' => array(
                            "g{$g},q{$q}{$m}"=>$v
                        )
                    ),
                    true
            );


        }//dont exist row, create
        else{
                       
            $new_result = array(
                "state"=>0,
                "assign_id"=>$aid,
                "user_id"=>$uid,
                "g{$g},q{$q}{$m}"=>$v
            );

            $collection_result_survey->insert( $new_result );
        }

        $mongo->close();

    }
    

}

?>
