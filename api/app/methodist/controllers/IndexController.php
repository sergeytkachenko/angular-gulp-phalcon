<?
namespace Multiple\Methodist\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Di\Service\BrandsService;
use Phalcon\Di\Service\ActivitiesService;
use Phalcon\Text as Utils;

class IndexController extends Controller {
    public function indexAction() {
        /*$res = $this->dispatcher->forward(array(
                                       "controller" => "Student",
                                       "action" => "index"
                                   ));
        */
        $response=new \Phalcon\Http\Response();
        $response->redirect("/methodist/student/index");
        return $response;
    }

    public function page404Action() {
        //$this->response->setStatusCode(404, "Not Found");
        $this->view->title="Не знайдено!";
    }

}
