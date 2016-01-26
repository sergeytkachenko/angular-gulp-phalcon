<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class DealerController extends Controller {
    public function searchAction() {
        $params = array_merge($_GET, $_POST);
        foreach($params as $key => $v) {
            $params[$key] = preg_replace("/\\//", "", $v);
        }
        $query = Criteria::fromInput($this->di, "Dealers", $params);
        $this->persistent->parameters = $query->getParams();
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

        $data = \Dealers::find($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        if(count($data)==1) {
            echo(json_encode($data[0]));
            exit;
        }
        echo json_encode($data);
    }

    public function indexAction () {
        $data = \Dealers::find(array("order" => 'title'))->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($data);
    }

}
