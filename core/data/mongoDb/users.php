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

        $db->executeBulkWrite($db->dbName.'.users', $bulk);

        return $user;
    }


    public function update($user)
    {   

        $sql = "
            UPDATE users 
            SET
                firstName = ?,
                lastName = ?,
                email = ?,
                password = ?
            WHERE
                Id = ?
            ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("ssssi"
        ,$user->firstName
        ,$user->lastName
        ,$user->email
        ,$user->password
        ,$user->id);

        $sqlPrepared->execute();

        return $user;
    }

    public function getById($id)
    {       
        $sql = "
            SELECT id,firstname,lastname,email,password FROM users WHERE id = ?
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("i",$id);

        $sqlPrepared->execute();

        $sqlPrepared->bind_result($id,$firstName,$lastName,$email,$password);

        while ($sqlPrepared->fetch()) {
            $foundRecord = new \core\entities\user();
            $foundRecord->id = $id;
            $foundRecord->firstName = $firstName;
            $foundRecord->lastName = $lastName;
            $foundRecord->email = $email;
            $foundRecord->password = $password;
            return $foundRecord;
        }
    }

    public function getAll()
    {      
        $results = [];  
        $sql = "
            SELECT id,firstname,lastname,email,password FROM users
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->execute();

        $sqlPrepared->bind_result($id,$firstName,$lastName,$email,$password);

        while ($sqlPrepared->fetch()) {
            $foundRecord = new \core\entities\user();
            $foundRecord->id = $id;
            $foundRecord->firstName = $firstName;
            $foundRecord->lastName = $lastName;
            $foundRecord->email = $email;
            $foundRecord->password = $password;
            array_push($results,$foundRecord);
        }

        return $results;
    }



    public function existBasedOnId($id)
    {       
        $sql = "
            SELECT 1 FROM users WHERE id = ?
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("s",$id);

        $sqlPrepared->execute();

        $result = $sqlPrepared->get_result();

        if($result->num_rows>0)
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
        
        foreach($records as $document) {
            print_r($document);
        }

        if(!empty($user))
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