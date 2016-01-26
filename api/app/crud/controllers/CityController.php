<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class CityController extends Controller {
    public function searchAction() {
        $query = Criteria::fromInput($this->di, "City", array_merge($_GET, $_POST));
        $this->persistent->parameters = $query->getParams();
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

        $data = \City::find($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($data);
    }

    public function indexAction () {
        $data = \City::find()->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($data);
    }

    public function oneAction () {
        $query = Criteria::fromInput($this->di, "City", array_merge($_GET, $_POST));
        $this->persistent->parameters = $query->getParams();
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

        $data = \City::findFirst($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($data);
    }

}
