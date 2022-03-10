<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\CoolApi\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [

    /*'resources' => [
        'contact_api' => ['url' => '/api/v1/contact' ]
    ],*/
    'routes' => [
	   	['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
	   	['name' => 'page#create', 'url' => '/', 'verb' => 'POST'],
       	['name' => 'contact_api#preflighted_cors', 'url'=> '/api/v1/{path}}', 'verb' => 'OPTIONS',
       	'requirements' => ['path' => '.+']],
		['name' => 'contact_api#index', 'url' => '/api/v1/contact/{name}', 'verb' => 'GET'],
		['name' => 'invoice#index', 'url' => '/invoice', 'verb' => 'GET']

    ]
];
