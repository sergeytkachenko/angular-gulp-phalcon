<?php

namespace Multiple\Methodist;

use Phalcon\DiInterface;
use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface,
    Phalcon\Events\Manager as EventsManager;

;

class Module implements ModuleDefinitionInterface {

    /**
     * Регистрация автозагрузчика, специфичного для текущего модуля
     * @param DiInterface $dependencyInjector
     */
    public function registerAutoloaders(DiInterface $dependencyInjector=NULL) {
        $loader=new Loader();
        $loader->registerNamespaces(
            array(
                'Multiple\Methodist\Controllers'=>'../app/methodist/controllers/',
                'Multiple\Frontend\Controllers' =>'../app/frontend/controllers/'
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
        $di->set('dispatcher', function () use ($di) {
            // Создаем менеджер событий
            $eventsManager=new EventsManager();
            // Прикрепляем слушателя
            $eventsManager->attach("dispatch:afterDispatch", function ($event, $dispatcher) use ($di) {
                $session=$di->get('session');
                if ($session->has("user")) {
                    $user=$session->get('user');
                    $group=\UserGroups::findFirst("user_id = \"".$user->id."\"");
                    if ($group->group_id == "4") { //Т.е. если это методист
                        return true;
                    } else {
                        //throw new \Exception('<B>Restricted access!</B>',100);
                        return false;
                    }


                } else {
                    //throw new \Exception('<B>Not logged in!</B>',100);
                    if ($dispatcher->getActionName()!="page404") {
                        $dispatcher->forward(array(
                                                 'controller'=>'index',
                                                 'action'    =>'page404' //show404
                                             ));
                        return false;
                    } else {
                        return true;
                    }
                }
                //if ($user->)
            });
            /*$eventsManager->attach('dispatch:beforeException', function ($event, $dispatcher, $exception) use (&$di) {
                //debug($dispatcher);
                if ($exception->getCode()==1) {
                    debug($dispatcher->getModuleName ());
                    $dispatcher->forward(array(
                                             'controller'=>'index',
                                             'action'    =>'page404' //show404
                                         ));
                    return false;
                } else {
                    $dispatcher->setModuleName("frontend");
                    //debug($dispatcher->getModuleName());
                    //Handle 404 exceptions
                    $dispatcher->forward(array(
                                             'controller'=>'index',
                                             'action'    =>'page404' //show404
                                         ));

                    return false;
                }
            });*/

            //$security=new Security($di);
            // We listen for events in the dispatcher using the Security plugin
            //$eventsManager->attach('dispatch', $security);

            $dispatcher=new Dispatcher();
            //Прикрепляем менеджер событий к диспетчеру
            $dispatcher->setDefaultNamespace("Multiple\Methodist\Controllers");
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
        $view=$di->get("view");
        $view->setViewsDir(__DIR__."/views/");
    }
}