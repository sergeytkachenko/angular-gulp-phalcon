<?php

namespace Multiple\Rest;

use Phalcon\DiInterface;
use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface {

    /**
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {

        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Multiple\Rest\Controllers' => '../app/rest/controllers/',
            )
        );

        $loader->register();
    }

    /**
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        // Регистрация диспетчера
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Rest\Controllers");
            return $dispatcher;
        });

        // Регистрация компонента представлений
        $view = $di->get("view");
        $view->setViewsDir('../app/rest/views/');
        $di->set('view', $view);
    }

}