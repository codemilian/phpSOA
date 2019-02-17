<?php
namespace core;

include("settings.php");
include($applicationFilePath."/logic/users.php");
include($applicationFilePath."/core/entities/user.php");

class serviceManager{
    public $users = null;
}

//service manager that can grow to support a wide range of logical services
$serviceManager =  new serviceManager();
$serviceManager->users =  new logic\users();

