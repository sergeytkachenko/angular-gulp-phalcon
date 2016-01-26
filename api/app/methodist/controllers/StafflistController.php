<?
namespace Multiple\Methodist\Controllers;

use Phalcon\Di\Service\Activities;
use Phalcon\Di\Service\Brands;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Criteria;

class StafflistController extends Controller {

    public function indexAction() {
        $this->view->title="Штатний розклад";
        $this->view->stafflistGroup=\StafflistGroup::find();
    }

    public function directionStudyAction() {
        $request=new Request();
        $this->view->setVar("title", "Напрямки навчання");

        $search=trim($request->get("search"));
        $pageCount=$request->get("page-count") ? $request->get("page-count") : $this->session->get("page-count");

        if ($pageCount) {
            $this->session->set("page-count", $pageCount);
        }
        $orderColumn=trim($request->get("order-column"))." ".trim($request->get("order-type"));
        $paginator=new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" =>\DirectionStudy::find(
                        array(
                            "order"     =>trim($orderColumn) ? $orderColumn : "title ASC",
                            "conditions"=>"title LIKE ?1",
                            "bind"      =>array(1=>"%".$search."%")
                        )),
                "limit"=>$pageCount ? $pageCount : 30,
                "page" =>$request->get("page")
            )
        );

        $page=$paginator->getPaginate();
        $this->view->page=$page;
        $this->view->countItems=count($page->items);
        $this->view->search=$search;
        $this->view->orderColumn=$request->get("order-column");
        $this->view->orderType=$request->get("order-type");
        $this->view->pageCount=$pageCount;
    }


    public function saveDirectionStudyAction() {
        $this->view->title="Збереження";
        $errors=array();

        if ($this->request->isPost()) {
            $dirStudy=new \DirectionStudy();
            $dirStudy->title=$this->request->get("title");
            $dirStudy->direction_study_group_id=$this->request->get("direction_study_group_id");
            $dirStudy->old_position_id=0;
            $dirStudy->direction_study_group_id=1;
            if ($dirStudy->save()==false) {
                echo "Неможливо додати напрямок навчання \n";
                foreach ($dirStudy->getMessages() as $message) {
                    echo $message, "\n";
                }
            } else {
                $response = new \Phalcon\Http\Response();
                $response->redirect("/methodist/stafflist/directionStudy");
                return $response;
            }
        }
    }

    public function postsAction() {
        $request=new Request();
        $this->view->setVar("title", "Посади");

        $search=trim($request->get("search"));
        $pageCount=$request->get("page-count") ? $request->get("page-count") : $this->session->get("page-count");

        if ($pageCount) {
            $this->session->set("page-count", $pageCount);
        }
        $orderColumn=trim($request->get("order-column"))." ".trim($request->get("order-type"));
        $paginator=new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" =>\Posts::find(
                        array(
                            "order"     =>trim($orderColumn) ? $orderColumn : "title ASC",
                            "conditions"=>"title LIKE ?1",
                            "bind"      =>array(1=>"%".$search."%")
                        )),
                "limit"=>$pageCount ? $pageCount : 30,
                "page" =>$request->get("page")
            )
        );

        $page=$paginator->getPaginate();
        $this->view->page=$page;
        $this->view->countItems=count($page->items);
        $this->view->search=$search;
        $this->view->orderColumn=$request->get("order-column");
        $this->view->orderType=$request->get("order-type");
        $this->view->pageCount=$pageCount;
    }

    public function savePostAction() {
        $this->view->title="Збереження посади";
        $errors=array();

        if ($this->request->isPost()) {
            $namePost=new \Posts();
            $namePost->title=$this->request->get("title");
            if ($namePost->save()==false) {
                echo "Неможливо додати посаду \n";
                foreach ($namePost->getMessages() as $message) {
                    echo $message, "\n";
                }
            } else {
                $response = new \Phalcon\Http\Response();
                $response->redirect("/methodist/stafflist/posts");
                return $response;
            }
        }
    }

    public function addAction() {

        if (strlen($this->request->get("title")) > 0) {
            $group=new \StafflistGroup();
            $group->title=$this->request->get("title");
            $group->old_id=0;
            if ($group->save()==false) {
                echo("Помилка при додаванні ШР.");
            } else {
                $response = new \Phalcon\Http\Response();
                $response->redirect("/methodist/stafflist/edit/".$group->id);
                return $response;
            }
        } else {
            echo("Помилка в запиті. Необхадно вказати назву.");
        }

        $this->view->title="Додати штатний розклад \"".$this->request->get("title")."\"";
    }

    public function editAction($gid) {
        $this->view->stafflist=(is_null($gid)) ? new \Stafflist() : \Stafflist::find("stafflist_group='".$gid."'");
        $this->view->gid=$gid;
        $this->view->title="Редагувати штатний розклад \"".\StafflistGroup::findFirst($gid)->title."\"";
    }


    public function postPlanAction() {
        $this->view->title="Кадровий план";
        $this->view->stafflistPostPlan=\StafflistPostPlan::find();
    }

    public function addDirectionStudyAction() {
        $this->view->directionStudyGroups=\DirectionStudyGroups::find();
    }


}