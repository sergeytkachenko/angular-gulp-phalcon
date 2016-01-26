<?php
namespace Multiple\Frontend\Controllers;

use Articles;
use Phalcon\Paginator\Adapter\Model;

class IndexController extends ControllerBase
{
    public function indexAction() {
        $this->view->title="УЦ Автокапитал";
        $this->view->err=$this->request->get("err");
    }

    public function loginAction() {
        /*if ($this->session->has("user")) { //Разлогинить, если залогинен
            $this->session->destroy();
        }*/
        $response=new \Phalcon\Http\Response();
        $login=$this->request->get("login");
        $pass=MD5($this->request->get("pass"));
        $user=\Users::findFirst("login = \"".$login."\" AND password = \"".$pass."\"");
        if ($user) {
            $group=\UserGroups::findFirst("user_id = \"".$user->id."\"");
            if ($group->group_id==4) { //Методист
                $this->session->set('user', $user);
                $response->redirect("/methodist/index");
            } else {
                $this->session->destroy();
                $response->redirect("/index?err=2");
            }
        } else {
            $this->session->destroy();
            $response->redirect("/index?err=1");
        }

        return $response;
    }
}

