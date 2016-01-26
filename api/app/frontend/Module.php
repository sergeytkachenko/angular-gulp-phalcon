<?php

namespace Multiple\Frontend;

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
                'Multiple\Frontend\Controllers' => '../app/frontend/controllers/',
                'Lib' => '../app/lib/',
                'Lib\Import' => '../app/lib/import',
                'Lib\Import\Column' => '../app/lib/import/column',
                'Lib\Import\Iterator' => '../app/lib/import/iterator',
                'Lib\Import\Parser' => '../app/lib/import/parser',
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
            $dispatcher->setDefaultNamespace("Multiple\Frontend\Controllers");
            return $dispatcher;
        });

        // Регистрация компонента представлений
        $view = $di->get("view");
        $view->setViewsDir('../app/frontend/views/');
        $di->set('view', $view);
    }

}