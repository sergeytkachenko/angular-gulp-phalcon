<?
namespace Multiple\Methodist\Controllers;
use Phalcon\Di\Service\ActivitiesService;
use Phalcon\Di\Service\BrandsService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Criteria;

class InspectorController extends Controller {
    public static $ITEMS_ON_PAGE = 30;
    public function indexAction() {

        $request = new Request();
        $this->view->setVar("title", "Інспектори");

        $search = trim($request->get("search"));
        $pageCount = $request->get("page-count") ? $request->get("page-count") : $this->session->get("page-count");

        if($pageCount) {
            $this->session->set("page-count", $pageCount);
        }
        $orderColumn = trim($request->get("order-column"))." ".trim($request->get("order-type"));
        $offset = $request->get("page") * $pageCount - $pageCount;

        $inspectorsQuery = \Users::query()
            ->rightJoin("UserGroups")
            ->where("UserGroups.group_id = 3");
        $pageCount = $pageCount?$pageCount : self::$ITEMS_ON_PAGE;

        $inspectorsQuery->limit($pageCount, $offset >= 0 ?$offset : null);

        if($orderColumn and !empty($orderColumn)) {
            $inspectorsQuery->orderBy(trim($orderColumn)? $orderColumn : "last_name ASC");
        }
        if($search and !empty($search)) {
            $searchBind = "'%".$search."%'";
            $inspectorsQuery->andWhere(
                "name LIKE $searchBind OR last_name LIKE $searchBind OR second_name LIKE $searchBind OR email LIKE $searchBind OR pmobile LIKE $searchBind"
            );
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => $inspectorsQuery->execute(),
                "limit"=> $pageCount? $pageCount : self::$ITEMS_ON_PAGE,
                "page" =>  $request->get("page")
            )
        );

        $page = $paginator->getPaginate();
        $this->view->page = $page;
        $this->view->countItems = count($page->items);
        $this->view->search = $search;
        $this->view->orderColumn = $request->get("order-column");
        $this->view->orderType = $request->get("order-type");
        $this->view->pageCount = $pageCount;

    }

    public function addAction() {
        $this->editAction();
        $this->view->setVar("title", "Додати інспектора");
    }

    public function editAction($userId=NULL) {
        $this->view->setVar("title", "Редагування інспектора");

        $inspector = $userId ? \Users::findFirst($userId): new \Users();
        $isInspector = false;
        foreach($inspector->UserGroups as $userGroup) {
            if($userGroup->group_id == 3) $isInspector = true;
        }
        if($userId and (!$inspector->id or !$isInspector) ) { // не найден такой inspector
            $this->view->pick("inspector/not-found");
            return;
        }

        $this->view->inspector = $inspector;
        $this->view->saved = $this->request->get("saved");
        $this->view->passwordDisabled = $userId? "disabled" : "";
    }

    public function saveAction() {
        $errors = array();
        $id = $this->request->get("id");

        if($this->request->isPost()) {
            $email = $this->request->get("email");
            $password = $this->request->get("password");
            $name = $this->request->get("name");
            $last_name = $this->request->get("last_name");
            $second_name = $this->request->get("second_name");
            $pMobile = $this->request->get("pmobile");

            $inspector = $id ? \Users::findFirst($id) : new \Users();

            if($password and !empty($password)) {
                $inspector->password = md5($password);
            }

            // проверить существует ли такой email в БД
            $users = \Users::find(array(
                "conditions" => "email = ?1",
                "bind"       => array(1 => $email)
            ));
            if ($users->getFirst()) {
                $errors[] = "Такий email вже існує в системі";
            } else {
                $inspector->email = $email;
                $inspector->name = $name;
                $inspector->last_name = $last_name;
                $inspector->second_name = $second_name;
                $inspector->pmobile = $pMobile;
                $inspector->is_active = true;

                if(!$id) $inspector->date_registration = date("Y-m-d H:i:s");

                if($id = !$inspector->save()) {
                    foreach($inspector->getMessages() as $msg) {
                        $errors[] = $msg->getMessage();
                    }
                } else { // saved is true
                    foreach($inspector->UserGroups as $userGroups) {
                        if($userGroups->group_id == 3) { // удаляем его пренадлежность к контролеру
                            if($userGroups->delete()) {
                                foreach($userGroups->getMessages() as $msg) {
                                    $errors[] = $msg->getMessage();
                                }
                            };
                        }
                    }
                    $userGroups = new \UserGroups();
                    $userGroups->user_id = $inspector->id;
                    $userGroups->group_id = 3; // group by inspector
                    if(!$userGroups->save()) { // добавялем принадлежность к контролеру
                        foreach($userGroups->getMessages() as $msg) {
                            $errors[] = $msg->getMessage();
                        }
                    }
                }
            }

            if($errors===array()) {
                // redirect to dealer edit
                $this->response->redirect('/methodist/inspector/edit/'.$inspector->id."?saved=true");
            }
        } else {
            $errors[] = "Немає данних для збереження";
        }

        $this->view->errors = $errors;
        $this->view->back = $id? '/methodist/inspector/edit/'.$id : '/methodist/inspector/add';

    }

    public function getAllAction () {
        $data = \Users::query()
            ->rightJoin("UserGroups")
            ->where("UserGroups.group_id = 3")
            ->execute()->toArray();
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode($data);
    }
}
