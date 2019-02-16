<?php
/*
Roberto Milian 2019
Seed demo of SOA architecture using PHP
This project intends to demonstrate in simple terms how one can achieve the following:
    -Simplicity of code
    -Readability
    -Maintainability
    -Code reuse
    -Separation of concerns
	-logic layer, database layer, database
    -Organization of system
It's been a while since I coded in PHP and most of my experience has been in smaller scale projects. 
The majority of my enterprise level experience designing systems has been using the traditional .NET framework. 
As a coding exercise, I wanted to see what approach I could take in designing a system in PHP for a large scale environment. 
A large enterprise system could be composed of many other components responsible for different roles such as security. 
For purposes of this project, I will keep things simple, but this project should stimulate the mind of where additions can be added as needed.

The following project structure and namespaces exists:
Core: This is to host major components consider core functionality to our project
Core\Entities: This will host all entities that our system uses to communicate. These entities are to be kept simple with limited functionality if any.
Data:  
    This will host all objects responsible for persisting entities to the database. 
    It is important to note that its sole responsibility is performing simple data operations.
    no business logic is desired in this layer.
Logic: This is where all our business logic takes place. 
Database: Our database is simply a storage mechanism, ideally you don't assign any logical responsibilities.
*/
include("core/core.php");

/*
The service manager can be expanded to cover a wide range of logical operations. 
In this demo, we will focus on users, but the idea is that as the system grows other logical services can be added such as orders, friendList, wishList, etc
*/
global $serviceManager;


//create new user 
//with one line of code we create an instance of a new user
$roberto = new core\entities\user();


//defining properties of my new users
$roberto->firstName  = "Roberto";
$roberto->lastName  = "Milian";
$roberto->email  = "codemilian@gmail.com";
$roberto->password  = "password123456789";


//with one line of code we call our users logic layer to persist a new user to the database.
//Notice how we set our new user to the save function, this will come back with the same object but the uniquely assigned id will be populated.
$roberto = $serviceManager->users->save($roberto);

//store the newly created id for later reference
$persitedId = $roberto->id;

//Now we will make a change and update the record
//The save function will know what action to take such as update or create
//That us because the users logic service has the responsibility of deciding what to do with our person object
$roberto->lastName = "Miliano";
$roberto = $serviceManager->users->save($roberto);

//Here wi will hack the id of you updated record above and try to break the app
//Here we will demonstrate how our logic layer is smart enough to determine an issue and return an appropriate error message
//Another example of the different logical responsibilities of the logic layer.
try {
    $roberto->id=99999; //this id does not exists!
    $roberto = $serviceManager->users->save($roberto);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


//finally we will get our person object based on an existing id
$person = $serviceManager->users->get($persitedId);

//Let's get a json representation of the retrieved object
$json = json_encode($person);
//Let's output that to the screen;

print_r("\n".$json);

