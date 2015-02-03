<?php

require 'vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);
define('PATH', realpath(dirname(__FILE__)));

// To access
$clientId = 'xxxxxxxx.apps.googleusercontent.com';
$serviceAccountName = 'app.email@google.com';
$applicationName = 'App Name';
$keyFile = PATH . DS . 'local' . DS . 'private-key.p12';
$privateKeyPassword = 'notasecret';
$scopes = array('https://www.googleapis.com/auth/admin.directory.user');

// To find and update
$username = 'tunght2@smartosc.com';
$newPassword = 'newpassword';

$key = file_get_contents($keyFile);
$credentials = new Google_Auth_AssertionCredentials(
    $serviceAccountName,
    $scopes,
    $key,
    $privateKeyPassword,
    'http://oauth.net/grant_type/jwt/1.0/bearer',
    'admin@smartosc.com'
);

$client = new Google_Client();
$client->setClientId($clientId);
$client->setApplicationName($applicationName);
$client->setAssertionCredentials($credentials);

$service = new Google_Service_Directory($client);
$user = $service->users->get($username);
$user->password = $newPassword;
$service->users->update($username, $user);
