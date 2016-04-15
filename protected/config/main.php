<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Citrum - Gateway API - PDV',
	'sourceLanguage'=>'en',
	'language'=>'pt_br',
	'timeZone'=>'America/Sao_Paulo',

	'theme'=>'retaguarda',

	// preloading 'log' component
	'preload'=>array(
		'log',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
	),

	'aliases'=>array(
		'RestfullYii' =>realpath(__DIR__ . '/../extensions/starship/RestfullYii'),
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array(), // 'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>'=>['<controller>/index', 'verb'=>'GET'],/*lista todos os registros do caminho da rota*/

				'<controller:\w+>/<id:\w*>'=>['<controller>/view', 'verb'=>'GET'],
				'<controller:\w+>/<id:\w*>/<param1:\w*>'=>['<controller>/view', 'verb'=>'GET'],
				'<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>'=>['<controller>/view', 'verb'=>'GET'],

				['<controller>/update', 'pattern'=>'<controller:\w+>/<id:\w*>', 'verb'=>'PUT'],
				['<controller>/update', 'pattern'=>'<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'PUT'],
				['<controller>/update', 'pattern'=>'<controller:\w*>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'PUT'],	

				['<controller>/delete', 'pattern'=>'<controller:\w+>/<id:\w*>', 'verb'=>'DELETE'],
				['<controller>/delete', 'pattern'=>'<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'DELETE'],
				['<controller>/delete', 'pattern'=>'<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'DELETE'],

				['<controller>/create', 'pattern'=>'<controller:\w+>', 'verb'=>'POST'],
				['<controller>/create', 'pattern'=>'<controller:\w+>/<id:\w+>', 'verb'=>'POST'],
				['<controller>/create', 'pattern'=>'<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'POST'],
				['<controller>/create', 'pattern'=>'<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'POST'],

				/*'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
			),
		),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_teste',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'abc',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail' => 'ti@citrum.com.br',
		'RestfullYii' => array(
			'req.auth.user' => function($application_id, $username, $password) {
				if(isset($_SERVER['HTTP_X_'.$application_id.'_USERNAME']) and isset($_SERVER['HTTP_X_'.$application_id.'_PASSWORD'])) {
					$username = trim($_SERVER['HTTP_X_'.$application_id.'_USERNAME']);
					$password = trim($_SERVER['HTTP_X_'.$application_id.'_PASSWORD']);
					$identity = new UserIdentity($username, $password);
					$identity->authenticate();
					if ($identity->errorCode === UserIdentity::ERROR_NONE) {
						Yii::app()->user->login($identity);
						return true;
					}
					else
					{
						return false;
					}
				}
				return false;
			},
		),
	),
);
