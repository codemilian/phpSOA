<?php
namespace core\databaseUtilities;

//common database connection
function getDbConnection()
{
    //store this information out of source code to avoid checking this in to an external storage
    $dbUsername = "root";
    $dbPassword = "";
    $dbServer = "localhost";
    $dbName = "test";
    $dbConnection = new \mysqli($dbServer,$dbUsername,$dbPassword,$dbName);
    return $dbConnection;
}