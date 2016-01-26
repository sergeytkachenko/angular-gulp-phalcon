<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Di\Service\ArraysService;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Di\Service\PostsService;

class StafflistController extends Controller {

    public function getPostsByDealerAction() {
        $query=Criteria::fromInput($this->di, "Dealers", array_merge($_GET, $_POST));
        $this->persistent->parameters=$query->getParams();
        $parameters=$this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters=array();
        }

        $posts=PostsService::getPostsByDealer($parameters);

        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($posts);
    }

    public function saveAction() {
        $res=array();
        $stafflist = new \Stafflist();
        $stafflist->post = $this->request->get("post");
        $stafflist->direction_study = $this->request->get("directionStudy");
        $stafflist->stafflist_group = $this->request->get("stafflistGroup");
        $stafflist->staff_old_id = 0;
        if ($stafflist->save()==false) {
            $res["retcode"] = 1;
            $res['msgs'][]="Неможливо додати посаду \n";
            foreach ($stafflist->getMessages() as $message) {
                $res['msgs'][]=$message + "\n";
            }
        } else {
            $res["retcode"] = 0;
            $res["msgs"] = "Запис доданий успішно.";
            $res["stafflist"] = $stafflist;
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($res);
    }

    private function checkPostInStaff($post, $stafflists) {
        foreach($stafflists as $staff){
            if ($staff->Posts == $post) {
                return true;
            }
        }
        return false;
    }

    public function getPostsAction($gid=NULL){
        if ($gid==NULL) {
            if ($this->request->get("stafflistGroup")) {$gid=$this->request->get("stafflistGroup");
            } else {$result=NULL;}
        } else {
            $posts = \Posts::find();
            $stafflists = \Stafflist::find("stafflist_group=".$gid);
            $result=array();
            foreach($posts as $post){
                if (!$this->checkPostInStaff($post, $stafflists)) {
                    $result[]=$post->toArray(true);
                }
            }
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($result);
    }


}
