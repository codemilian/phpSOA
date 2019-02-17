<?php
namespace core\logic; 
include($applicationFilePath."/core/data/users.php"); 

//responsible for all logical operations for the user entity.
class users {
     //This is our reference to the object responsible for persistent users to the database
    private $usersDbStororage;
    function __construct() {
        $this->usersDbStororage = new \core\data\users(); 
    }


    //Gets a user object based on the given id
    public function get($id)
    {
        if($id==null)
        {
            return $this->usersDbStororage->getAll();
        }
        else{
            $user =  $this->usersDbStororage->getById($id);
            if($user==null)
            {
                throw new \Exception("Unable to retrieve user record, a record with id ".$id." does not exists"); 
            }
            else{
                return $user;
            }
        }
    }

    //Delete a record based on Id
    public function delete($id)
    {
        if (!$this->usersDbStororage->existBasedOnId($id)) {
            throw new \Exception("Unable to delete user record, a record with id ".$id." does not exists"); 
        }
        else {
            return $this->usersDbStororage->delete($id); 
        } 

    }
    
    //Save the given user object
    //Notice how this function is responsible for determining what action to perform such as create or update
    //It also validates what it's given for potential errors and to maintain data integrity
    public function save($user) {
        if (!property_exists($user, 'id') || $user->id == null) 
        {
            if ($this->usersDbStororage->existBasedOnEmail($user->email)) {
                throw new \Exception("A user with this email already exists"); 
            }
            else {
                return $this->usersDbStororage->create($user); 
            }
        }
        else{
            if (!$this->usersDbStororage->existBasedOnId($user->id)) {
                throw new \Exception("Unable to update user record, a record with id ".$user->id." does not exists"); 
            }
            else {
                return $this->usersDbStororage->update($user); 
            } 
        }
    }

    public function update($user) {
        if (!$this->usersDbStororage->existBasedOnId($user->id)) {
            throw new \Exception("Unable to update user record, a record with id ".$user->id." does not exists"); 
        }
        else {
            return $this->usersDbStororage->update($user); 
        } 
    }

    public function create($user) {
        if ($this->usersDbStororage->existBasedOnEmail($user->email)) {
            throw new \Exception("A user with this email already exists"); 
        }
        else {
            return $this->usersDbStororage->create($user); 
        }
    }
}