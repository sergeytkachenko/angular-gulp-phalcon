<?php

use Phalcon\DI;
use Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT_PATH', __DIR__);
define('PATH_LIBRARY', __DIR__ . '/../app/library/');

set_include_path(
	ROOT_PATH . PATH_SEPARATOR . get_include_path()
);

// требуется для phalcon/incubator
include __DIR__ . "/../../vendor/autoload.php";

// Используем автозагрузчик приложений для автозагрузки классов.
// Автозагрузка зависимостей, найденных в composer.
$loader = new \Phalcon\Loader();

$loader->registerDirs(
	array(
		ROOT_PATH
	)
);

$loader->register();

$di = new FactoryDefault();
DI::reset();

// здесь можно добавить любые необходимые сервисы в контейнер зависимостей

DI::setDefault($di);