<?php

namespace Multiple\Inspector;

use Phalcon\DiInterface;
use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{

    /**
     * Регистрация автозагрузчика, специфичного для текущего модуля
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di=null)
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'Multiple\Inspector\Controllers' => '../app/inspector/controllers/',
            )
        );

        $loader->register();
    }

    /**
     * Регистрация специфичных сервисов для модуля
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di) {
        // Регистрация диспетчера
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Multiple\Inspector\Controllers");
            return $dispatcher;
        });
        $view = $di->get("view");
        $view->setViewsDir(__DIR__."/views/");
    }

}