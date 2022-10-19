<?php

return [

	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'message_api#index', 'url' => '/api/v1/message/{page}','verb' => 'GET', 'requirements' => array('page' => '\\d+')],
		['name' => 'message_api#get_notification', 'url' => '/api/v1/message/{path}','verb' => 'GET', 'requirements' => array('path' => '(notifications).*')],
		['name' => 'message_api#get_new_received_messages', 'url' => '/api/v1/message/{path}/{page}','verb' => 'GET',
			'requirements' => array(
				'path' => '(new).*',
				'page' => '\\d+'
			)],
		['name' => 'message_api#mark_as_read', 'url' => '/api/v1/message','verb' => 'PUT'],
		['name' => 'message_api#delete', 'url' => '/api/v1/message','verb' => 'DELETE'],
		['name' => 'message_api#create', 'url' => '/api/v1/message','verb' => 'POST'],

		['name' => 'message_api#as4Endpoint', 'url' => '/api/v1/as4','verb' => 'POST'],
		['name' => 'message_api#handleTestbedMessage', 'url' => '/api/v1/testbed','verb' => 'POST'],
		['name' => 'message_api#as4Send', 'url' => '/api/v1/as4send','verb' => 'GET'],

		['name' => 'upload_api#receive_new', 'url' => '/api/v1/upload','verb' => 'POST'],

		['name' => 'contact_api#search', 'url' => '/api/v1/contact', 'verb'=>'GET'],
		['name' => 'contact_api#create', 'url' => '/api/v1/contact', 'verb'=>'POST'],

		['name' => 'setting_api#index', 'url' => '/api/v1/setting', 'verb'=>'GET'],
		['name' => 'setting_api#create', 'url' => '/api/v1/setting', 'verb'=>'POST']

	]
];
