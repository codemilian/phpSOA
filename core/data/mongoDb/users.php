<?php
namespace core\data;
include($applicationFilePath."/core/databaseUtilities.php"); //reference to a common database utility

//responsible for converting our custom entity into a record(s) in our relational database
class users
{
    public function create($user)
    {   
        $db = \core\databaseUtilities\getDbConnection();

        $bulk = new \MongoDB\Driver\BulkWrite;

        $bulk->insert($user);

        $user->_id= new \MongoDB\BSON\ObjectID();
        $db->executeBulkWrite($db->dbName.'.users', $bulk);
        
        return $user;
    }


    public function update($user)
    {   
        $id = $user->id;
        $db = \core\databaseUtilities\getDbConnection();

        $filter = [ '_id' => new  \MongoDB\BSON\ObjectID($user->id)];

        unset($user->_id);
        unset($user->id);

        $bulk = new \MongoDB\Driver\BulkWrite;

        $options=array('multi' => false, 'upsert' => false);

        $bulk->update($filter,$user,$options);

        $db->executeBulkWrite($db->dbName.'.users', $bulk);

        $user->_id =new  \MongoDB\BSON\ObjectID($id);
        
        return $user;
    }
    

    public function getById($id)
    {       
        $db = \core\databaseUtilities\getDbConnection();

        $filter = [ '_id' => new  \MongoDB\BSON\ObjectID($id) ]; 
        $query = new \MongoDB\Driver\Query($filter);
        
        $res = $db->executeQuery($db->dbName.".users", $query);
        $records = $res->toArray();
        return $records[0];
    }

    public function getAll()
    {      
        $db = \core\databaseUtilities\getDbConnection();

        $filter = []; 
        $query = new \MongoDB\Driver\Query($filter);
        
        $res = $db->executeQuery($db->dbName.".users", $query);
        $records = $res->toArray();
        
        return $records;
    }



    public function existBasedOnId($id)
    {       
        $db = \core\databaseUtilities\getDbConnection();

        $filter = [ '_id' =>  new \MongoDB\BSON\ObjectID($id) ]; 
        $query = new \MongoDB\Driver\Query($filter);
        
        $res = $db->executeQuery($db->dbName.".users", $query);
        $records = $res->toArray();
        
        if(sizeof($records)>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function existBasedOnEmail($email)
    {       
        $db = \core\databaseUtilities\getDbConnection();

        $filter = [ 'email' => $email ]; 
        $query = new \MongoDB\Driver\Query($filter);
        
        $res = $db->executeQuery($db->dbName.".users", $query);
        $records = $res->toArray();
        
        if(sizeof($records)>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function delete($id)
    {       
        $db = \core\databaseUtilities\getDbConnection();

        $filter = [ '_id' => new  \MongoDB\BSON\ObjectID($id)];



        $bulk = new \MongoDB\Driver\BulkWrite;

        $options=array('limit' => 1);

        $bulk->delete($filter,$options);

        $db->executeBulkWrite($db->dbName.'.users', $bulk);


    }

}