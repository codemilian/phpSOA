<?php
namespace core;
include("logic/users.php");
include("core/entities/user.php");

class serviceManager{
    public $users = null;
}

//service manager that can grow to support a wide range of logical services
$serviceManager =  new serviceManager();
$serviceManager->users =  new logic\users();

