<?php

namespace Multiple\Crud;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{

    /**
     * Регистрация автозагрузчика, специфичного для текущего модуля
     */
    public function registerAutoloaders($dependencyInjector=null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'Multiple\Crud\Controllers' => '../app/crud/controllers/'
            )
        );

        $loader->register();
    }

    /**
     * Регистрация специфичных сервисов для модуля
     */
    public function registerServices($di) {
        // Регистрация диспетчера
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Crud\Controllers");
            return $dispatcher;
        });
        $view = $di->get("view");
        $view->setViewsDir(__DIR__."/views/");
    }
}