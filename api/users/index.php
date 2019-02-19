<?php
ini_set('display_errors', false);
$method = $_SERVER['REQUEST_METHOD'];
$requestUrl = $_SERVER['REQUEST_URI'];
$urlParts = explode("/",$requestUrl);
$id = null;
//Getting restful URL argument(s)
if(sizeof($urlParts)>3)
{
    $id = $urlParts[4];
    if($id=="")
    {
        $id = null;
    }
}
include("../../core/core.php");

global $serviceManager;

if ($method === 'POST') { //Creates a new user
    try {
        $entityBody = file_get_contents('php://input');
        $user = json_decode($entityBody);
        $user = $serviceManager->users->create($user);
        $json = json_encode($user);
        header('HTTP/1.1 201 Created', true, 201);
        header('Content-Type: text/json');
        echo $json;
    } catch (\Throwable $e) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Unable to create user";
    }
}
else if ($method === 'PUT') {//Updates user based on the id of the object
    try {
        $entityBody = file_get_contents('php://input');
        $user = json_decode($entityBody);
        $user->id = $id;
        $user = $serviceManager->users->update($user);
        $json = json_encode($user);
        header('HTTP/1.1 200 OK', true, 200);
        header('Content-Type: text/json');
        echo $json;
    } catch (\Throwable $e) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Unable to update user";
    }
}
else if ($method === 'GET') { //Gets user based on given id
    try {
        $records = $serviceManager->users->get($id);
        $json = json_encode($records);
        header('HTTP/1.1 200 OK', true, 200);
        header('Content-Type: text/json');
        echo $json;
    } catch (\Throwable $e) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Unable to retrieve user(s)";
    }
}
else if ($method === 'DELETE') { //Deletes a user based on given id
    try {
        $records = $serviceManager->users->delete($id);
        $json = json_encode($records);
        header('HTTP/1.1 204 Deleted', true, 204);
        header('Content-Type: text/json');
        echo $json;
    } catch (\Throwable $e) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Unable to delete user";
    }
}