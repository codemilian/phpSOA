<?php
ini_set('display_errors', false);
$method = $_SERVER['REQUEST_METHOD'];
$requestUrl = $_SERVER['REQUEST_URI'];
$urlParts = explode("/",$requestUrl);
$id = null;
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

if ($method === 'POST') {
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
else if ($method === 'PUT') {
    try {
        $entityBody = file_get_contents('php://input');
        $user = json_decode($entityBody);
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
else if ($method === 'GET') {
    try {
        $records = $serviceManager->users->get($id);
        $json = json_encode($records);
        header('HTTP/1.1 200 OK', true, 200);
        header('Content-Type: text/json');
        echo $json;
    } catch (\Throwable $e) {
        header('HTTP/1.1 400 Bad Request', true, 400);
        echo "Unable to update user";
    }
}
