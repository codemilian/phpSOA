<?php
namespace core\databaseUtilities;
include($applicationFilePath."/core/settings.php");

//common database connection
function getDbConnection()
{
    global $storageMode;
    if($storageMode=="mySQL")
    {
        //store this information out of source code to avoid checking this in to an external storage
        $dbUsername = "root";
        $dbPassword = "";
        $dbServer = "localhost";
        $dbName = "test";
        $dbConnection = new \mysqli($dbServer,$dbUsername,$dbPassword,$dbName);
        return $dbConnection;
    }
    else if($storageMode=="mongoDb")
    {
        $dbConnection = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        $dbConnection->dbName = "test";

        return $dbConnection;
    }
}
