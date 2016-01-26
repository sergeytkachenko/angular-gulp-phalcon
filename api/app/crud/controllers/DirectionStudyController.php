<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Di\Service\PostsService;

class DirectionstudyController extends Controller
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Додає напрямок навчання
     */

    public function addAction() {
            $result=array();
            $presentDirectionStudy=\DirectionStudy::findFirst("title='".$this->request->get("title")."'");
            if ($presentDirectionStudy!=false) {
                $result['retcode']=1;
                $result['msgs'][]="Напрямок навчання з такою назвою вже існує!";
            } else {
                $nameDirectionStudy=new \DirectionStudy();
                $nameDirectionStudy->title=$this->request->get("title");
                $nameDirectionStudy->direction_study_group_id = 1;
                $nameDirectionStudy->old_position_id = 0;
                if ($nameDirectionStudy->save()==false) {
                    $result['retcode']=2;
                    $result['msgs'][]="Неможливо додати напрямок навчання \n";
                    foreach ($nameDirectionStudy->getMessages() as $message) {
                        $result['msgs'][]=$message + "\n";
                    }
                } else {
                    $result['retcode']=0;
                    $result['id']=$nameDirectionStudy->id;
                    $result['msgs'][]="Новий напрямок навчання збережено";
                }
            }
            $this->view->disable();
            $this->response->setContentType('application/json', 'UTF-8');

            echo json_encode($result);
    }

    public function searchAction() {
        $query = Criteria::fromInput($this->di, "DirectionStudy", array_merge($_GET, $_POST));
        $this->persistent->parameters = $query->getParams();
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

        $DirectionStudies = \DirectionStudy::find($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($DirectionStudies);
    }

    public function getAllForSelectAction($term) {
        $allDirectionStudies = \DirectionStudy::find();
        $DirectionStudies = array();
        foreach($allDirectionStudies as $directionStudy) {
            $DirectionStudies[] = array("id"=>$directionStudy->id, "text"=>$directionStudy->title);
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($DirectionStudies);
    }
}
