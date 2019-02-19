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

        $db = \core\databaseUtilities\getDbConnection();

        $bulk = new \MongoDB\Driver\BulkWrite;

        $bulk->update([ '_id' => new  \MongoDB\BSON\ObjectID($id)] ,$user);


        $db->executeBulkWrite($db->dbName.'.users', $bulk);
        
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
        $sql = "
            DELETE FROM users WHERE id = ?
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("s",$id);

        $sqlPrepared->execute();

    }

}