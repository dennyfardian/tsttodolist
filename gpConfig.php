<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '56455975422-2rdcns58d0r426pu795mo1na2j70nl0t.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'hjW609H-VytrN_3PcPM40MOp'; //Google client secret
$redirectURL = 'https://tsttodolist.azurewebsites.net/myapp/tst/index.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to To Do List Web Service');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>