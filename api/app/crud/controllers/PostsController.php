<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Di\Service\PostsService;

class PostsController extends Controller {
    /**
     * Index action
     */
    public function indexAction() {
        $this->persistent->parameters=NULL;
    }

    /**
     * Добавляет новую должность
     */
    public function addAction() {
        $result=array();
        $presentPost=\Posts::findFirst("title='".$this->request->get("title")."'");
        if ($presentPost!=false) {
            $result['retcode']=1;
            $result['msgs'][]="Посада із такою назвою вже існує!";
        } else {
            $namePost=new \Posts();
            $namePost->title=$this->request->get("title");
            if ($namePost->save()==false) {
                $result['retcode']=2;
                $result['msgs'][]="Неможливо додати посаду \n";
                foreach ($namePost->getMessages() as $message) {
                    $result['msgs'][]=$message + "\n";
                }
            } else {
                $result['retcode']=0;
                $result['id']=$namePost->id;
                $result['msgs'][]="Нову посаду збережено";
            }
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');

        echo json_encode($result);
    }

    /**
     * Поиск должностей по параметрам
     */
    public function searchAction() {
        $query=Criteria::fromInput($this->di, "Posts", array_merge($_GET, $_POST));
        $this->persistent->parameters=$query->getParams();
        $parameters=$this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters=array();
        }

        $posts=\Posts::find($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($posts);
    }
}
