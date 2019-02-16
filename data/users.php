<?php
namespace core\data;
include("core/databaseUtilities.php"); //reference to a common database utility

//responsible for converting our custom entity into a record(s) in our relational database
class users
{
    public function create($user)
    {   

        $sql = "
        INSERT INTO users (firstName,lastName,email,password)
        VALUES(?,?,?,?)
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("ssss"
        ,$user->firstName
        ,$user->lastName
        ,$user->email
        ,$user->password);

        $sqlPrepared->execute();
        $user->id= $db ->insert_id;

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
        $sql = "
            SELECT 1 FROM users WHERE email = ?
        ";

        $db = \core\databaseUtilities\getDbConnection();

        $sqlPrepared = $db->prepare($sql);

        $sqlPrepared->bind_param("s",$email);

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

}