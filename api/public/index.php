<?

try {
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define('PUBLIC_PATH', realpath(dirname(__FILE__)));

	/**
	 * Read the configuration
	 */

	$config = include __DIR__ . "/../app/config/config.php";

	/**
	 * Read auto-loader
	 */
	include __DIR__ . "/../app/config/loader.php";
	//include __DIR__ . "/../vendor/autoload.php";

	require_once __DIR__ . "/../app/config/define.php";
	/**
	 * Read services
	 */
	include __DIR__ . "/../app/config/services.php";

	include __DIR__ . "/../app/config/debug.php";

	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

	$application->registerModules(
		array(
			'frontend'  => array(
				'className' => 'Multiple\Frontend\Module',
				'path'      => '../app/frontend/Module.php',
			),
			'methodist' => array(
				'className' => 'Multiple\Methodist\Module',
				'path'      => '../app/methodist/Module.php',
			),
			'student'   => array(
				'className' => 'Multiple\Student\Module',
				'path'      => '../app/student/Module.php',
			),
			'crud'      => array(
				'className' => 'Multiple\Crud\Module',
				'path'      => '../app/crud/Module.php',
			),
			'rest'      => array(
				'className' => 'Multiple\Rest\Module',
				'path'      => '../app/rest/Module.php',
			)
		)
	);

	echo $application->handle()->getContent();

} catch (\Exception $e) {
	echo $e->getMessage();
}
