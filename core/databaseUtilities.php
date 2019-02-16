<?php
namespace core\databaseUtilities;

//common database connection
function getDbConnection()
{
    //store this information out of source code to avoid checking this in to an external storage
    $dbUsername = "roberto";
    $dbPassword = "password";
    $dbServer = "localhost";
    $dbName = "test";
    $dbConnection = new \mysqli($dbServer,$dbUsername,$dbPassword,$dbName);
    return $dbConnection;
}