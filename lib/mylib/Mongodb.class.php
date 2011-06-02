<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mongo
 *
 * @author erick
 */

class Mongo_db {

    public $connection;
    public $db;
    public $collection;
    
    public function  __construct($db,$host="localhost:27017",$user="",$pass=""){
        
        try{

            $this->connection = new Mongo($host);
            $this->db = $this->connection->{$db};
            $this->db->command(array('fsync'=>1));
            if( $user ){
                $this->db->authenticate($user, $pass);
            }

        }catch( Exception $e ){
            die($e);
        }
            
        
    }

    public function close(){
        $this->connection->close();
    }

    public function getCollection($c) {
        return $this->db->{$c};
    }

    public function setCollection($c){
        $this->collection = $this->db->{$c};
    }

    public function delete($f, $one = FALSE) {
        $c = $this->collection->remove($f, $one);
        return $c;
    }

    public function ensureIndex($args) {
        return $this->collection->ensureIndex($args);
    }

    public function getObjId($id){
        return new MongoID($id);
    }

    public function createCollection($name){
        $this->db->createCollection($name);
    }

}
?>
