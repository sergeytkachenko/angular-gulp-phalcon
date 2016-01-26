<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);

	return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

	$view = new View();

	//$view->setViewsDir($config->application->viewsDir);

	$view->registerEngines(array(
		'.volt'  => function ($view, $di) use ($config) {

			$volt = new VoltEngine($view, $di);

			$volt->setOptions(array(
				'compiledPath'      => $config->application->cacheDir,
				'compiledSeparator' => '_',
				'stat'              => true,
				'compileAlways'     => true
			));

			$compiler = $volt->getCompiler();

			$compiler->addFunction('trim_to_dot',
				function ($resolvedArgs, $exprArgs) use ($compiler) {
					$string = $compiler->expression($exprArgs[0]['expr']);
					$secondArgument = $compiler->expression($exprArgs[1]['expr']);
					return '\Text::substToDot(' . $string . ',' . $secondArgument . ')';
				});
			$compiler->addFunction('substr',
				function ($resolvedArgs, $exprArgs) use ($compiler) {
					$string = $compiler->expression($exprArgs[0]['expr']);
					$secondArgument = $compiler->expression($exprArgs[1]['expr']);
					return 'substr(' . $string . ', 0, ' . $secondArgument . ')';
				});

			$compiler->addFunction('display_when',
				function ($resolvedArgs, $exprArgs) use ($compiler) {
					$string = $compiler->expression($exprArgs[0]['expr']);
					return '\DateFormat::displayWhen("' . $string . '")';
				});

			$compiler->addFunction(
				'menuLeft',
				function ($resolvedArgs, $exprArgs) {
					return '\MenuHelper::menuLeft(' . $resolvedArgs . ')';
				}
			);
			$compiler->addFunction(
				'menuTop',
				function ($resolvedArgs, $exprArgs) {
					return '\MenuHelper::menuTop(' . $resolvedArgs . ')';
				}
			);
			$compiler->addFunction(
				'noformat',
				function ($resolvedArgs, $exprArgs) {
					return '\Tag::noformat(' . $resolvedArgs . ')';
				}
			);

			$compiler->addFunction(
				'format_sum',
				function ($resolvedArgs, $exprArgs) {
					return 'number_format(' . $resolvedArgs . ', 0, "", " ")';
				}
			);


			$compiler->addFunction(
				'getPageUrl',
				function ($resolvedArgs, $exprArgs) {
					return '\Paginator::getPageUrl(' . $resolvedArgs . ')';
				}
			);

			$volt->getCompiler()->addFunction('JSON_encode', 'json_encode');
			$volt->getCompiler()->addFunction('count', 'count');

			return $volt;
		},
		'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
	));

	return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
	return new DbAdapter(array(
		'host'     => $config->database->mysql->host,
		'username' => $config->database->mysql->username,
		'password' => $config->database->mysql->password,
		'dbname'   => $config->database->mysql->dbname,
		"charset"  => $config->database->mysql->charset
	));
});

$di->set('mongo', function () {
	$mongo = new MongoClient();
	return $mongo->selectDB("ucar");
}, true);

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
	return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () use ($config) {
	$session = new SessionAdapter();
	$session->start();

	return $session;
});

// Специфичные роуты для модуля
$di->set('router', function () {

	$router = new \Phalcon\Mvc\Router();

	$router->setDefaultModule("frontend");

	$router->add("/login", array(
		'module'     => 'frontend',
		'controller' => 'index',
		'action'     => 'login'
	));

	$router->add("/rest/:controller/:action/:params?", array(
		'module'     => 'rest',
		'controller' => 1,
		'action'     => 2,
		'params'     => 3,
	));


	$router->add("/methodist/:controller/?", array(
		'module'     => 'methodist',
		'controller' => 1,
		'action'     => 'index',
	));
	$router->add("/methodist/:controller/:action/?([0-9]+)?", array(
		'module'     => 'methodist',
		'controller' => 1,
		'action'     => 2,
		'id' => 3
	));
	$router->add("/student/:controller/?", array(
		'module'     => 'student',
		'controller' => 1,
		'action'     => 'index',
	));
	$router->add("/student/:controller/:action", array(
		'module'     => 'student',
		'controller' => 1,
		'action'     => 2,
	));
	/*$router->add("/crud/:controller/:action/", array(
		'module'     => 'crud',
		'controller' => 1,
		'action'     => 2
	));*/
	$router->add("/crud/:controller/:action/:params", array(
		'module'     => 'crud',
		'controller' => 1,
		'action'     => 2,
		'params' => 3
	));
	$router->add("/crud/:controller(/)", array(
		'module'     => 'crud',
		'controller' => 1,
		'action'     => "index"
	));
	$router->add("/crud/:controller/:int", array(
		'module'     => 'crud',
		'controller' => 1,
		'action'     => "index",
		'int'        => 2
	));

	return $router;
});

$di->set('mail', function () use ($config) {
	return new Mail($config);
});

/**
 * Shared translate service
 */
$di->setShared('trans', function() use($di) {

	$request = $di->getShared('request');
	$language = $request->getBestLanguage();

	if(file_exists(__DIR__ . "/../languages/".$language.".php")) {
		require __DIR__ . "/../languages/".$language.".php";
	} else if (file_exists(__DIR__ . "/../languages/ru.php")) {
		require __DIR__ . "/../languages/ru.php";
	}

	return new \Phalcon\Translate\Adapter\NativeArray(array(
		"content" => $t
	));
});