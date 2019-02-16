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
    
It's been a while since I coded in PHP and most of my PHP experience has been in smaller scale projects. 
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


**To get right to it and see how the implementation of such system looks like browse to index.php
