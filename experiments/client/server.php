<?php

require __DIR__ . '/vendor/autoload.php';

use PonderSource\Peppol\PeppolServer;

$server = new PeppolServer();
if($_SERVER['REQUEST_URI'] === "/initialSetup"){
    $success = false;
    if(isset($_FILES['key'])){
        $key = file_get_contents($_FILES['key']['tmp_name']);
        $key = openssl_pkey_get_private($key);
        $success = $server->initialSetup($key);
    } else {
        $success = $server->initialSetup();
    }
    if($success){
        print 'OK';
    } else {
        print 'SOMETHING WENT WRONG';
    }
} else if ($_SERVER['REQUEST_URI'] === '/as4') {
    $server->parseIncomingMessage();
} else if ($_SERVER['REQUEST_URI'] === '/key') {
    if(file_exists('keys/public.pem')){
        print(file_get_contents('keys/public.pem'));
    } else {
        print 'NO KEY';
    }
}

