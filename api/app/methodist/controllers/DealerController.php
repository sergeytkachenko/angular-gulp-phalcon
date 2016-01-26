<?
namespace Multiple\Methodist\Controllers;
use Phalcon\Di\Service\ActivitiesService;
use Phalcon\Di\Service\BrandsService;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Criteria;

class DealerController extends Controller {
    public function indexAction() {

        $request = new Request();
        $this->view->setVar("title", "Дилери");

        $search = trim($request->get("search"));
        $pageCount = $request->get("page-count") ? $request->get("page-count") : $this->session->get("page-count");

        if($pageCount) {
            $this->session->set("page-count", $pageCount);
        }
        $orderColumn = trim($request->get("order-column"))." ".trim($request->get("order-type"));
        $paginator = new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" => \Dealers::find(
                    array(
                        "order" => trim($orderColumn)? $orderColumn : "title ASC",
                        "conditions" => "title LIKE ?1 OR address LIKE ?1 ",
                        "bind" => array (1 => "%".$search."%")
                    )),
                "limit"=> $pageCount? $pageCount : 30,
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
        $this->view->setVar("title", "Додати дилера");
    }

    public function editAction($dealerId=NULL) {
        $this->view->setVar("title", "Редагування дилера");

        $user = $this->session->get("user");
        $methodistBrands = \BrandsMethodists::find("user_id=".$user->id)->toArray();
        $methodistActivities = \ActivitiesMethodists::find("user_id=".$user->id)->toArray();

        $dealer = $dealerId ? \Dealers::findFirst($dealerId): new \Dealers();

        if($dealerId and !$dealer->id) { // не найден такой диллер
            $this->view->pick("dealer/not-found");
            return;
        }

        $city = $dealer->City;
        $this->view->regionId = $city ? $city->Region->id : NULL;
        $dealerBrands = $dealer->id? $dealer->DealersBrands->toArray() : array();
        $dealerActivities = $dealer->id ? \DealersActivities::find("dealer_id=".$dealer->id)->toArray() : array();

        $this->view->dealers = \Dealers::find(array('order'=> 'title'));
        $this->view->regions = \Region::find();
        $this->view->regionFirst = $this->view->regions[0];
        $this->view->cities = \City::find();
        $this->view->staffListGroup = \StafflistGroup::find();

        $this->view->brands = BrandsService::getForChosenEntity(\Brands::find()->toArray(), $methodistBrands, $dealerBrands);
        $this->view->activities = ActivitiesService::getForChosenEntity(\Activities::find()->toArray(), $methodistActivities, $dealerActivities);

        $this->view->dealerStatuses = \DealerStatuses::find();

        $controllers = \Users::query()
            ->rightJoin("UserGroups")
            ->where("UserGroups.group_id = 3")
            ->execute();
        $this->view->controllers = $controllers;

        $this->view->dealerControllers = $dealer->DealersControllers;

        $this->view->dealer = $dealer;
        $this->view->saved = $this->request->get("saved");
    }

    public function saveAction() {
        $errors = array();
        $id = $this->request->get("id");

        if($this->request->isPost()) {
            $title = $this->request->get("title");
            $address = $this->request->get("address");
            $parent_id = $this->request->get("parent_id");
            $parent_id = $parent_id ? $parent_id : NULL;
            $status = $this->request->get("status");
            $city_id = $this->request->get("city_id");
            $stafflist_group_id = $this->request->get("stafflist_group_id");
            $inspectors = $this->request->get("inspectors");

            $user = $this->session->get('user');

            $brandsForm = $this->request->get("brands");
            $activities = $this->request->get("activities");
            $brandsForm = is_array($brandsForm)? $brandsForm : array();
            $activitiesForm = is_array($activities)? $activities : array();

            $dealer = $id ? \Dealers::findFirst($id) : new \Dealers();

            $calculationBrands = BrandsService::getCalculationResult($user->BrandsMethodists, $dealer->DealersBrands, $brandsForm);
            $calculationActivities = ActivitiesService::getCalculationResult($user->ActivitiesMethodists, $dealer->DealersActivities, $activitiesForm);

            $dealer->DealersBrands->delete(); // delete all brands from dealer
            $dealer->DealersActivities->delete(); // delete all activities from dealer
            $dealer->DealersControllers->delete(); // delete all inspectors from dealer

            $dealer->title = $title;
            $dealer->address = $address;
            $dealer->parent_id = $parent_id;
            $dealer->status = $status;
            $dealer->city_id = $city_id;
            $dealer->stafflist_group_id = $stafflist_group_id;

            if($id = !$dealer->save()) {
                foreach($dealer->getMessages() as $msg) {
                    $errors[] = $msg->getMessage();
                }
            } else {
                $dealerBrands = array();
                $dealerActivities = array();
                $dealersControllers = array();

                foreach($calculationBrands as $brand) {
                    $dealerBrand = new \DealersBrands();
                    $dealerBrand->brand_id = $brand->id;
                    $dealerBrand->dealer_id = $id;

                    $dealerBrands[] = $dealerBrand;
                }
                $dealer->DealersBrands = $dealerBrands;

                foreach($calculationActivities as $activity) {
                    $dealerActivity = new \DealersActivities();
                    $dealerActivity->activity_id = $activity->id;
                    $dealerActivity->dealer_id = $id;

                    $dealerActivities[] = $dealerActivity;
                }
                $dealer->DealersActivities = $dealerActivities;

                foreach($inspectors as $userId) {
                    $dealerInspector = new \DealersControllers();
                    $dealerInspector->dealer_id = $dealer->id;
                    $dealerInspector->user_id = $userId;

                    $dealersControllers [] = $dealerInspector;
                }
                $dealer->DealersControllers = $dealersControllers;

                if(!$dealer->save()) {

                }
            }
            if($errors===array()) {
                // redirect to dealer edit
                $this->response->redirect('/methodist/dealer/edit/'.$dealer->id."?saved=true");
            }
        } else {
            $errors[] = "Немає данних для збереження";
        }

        $this->view->errors = $errors;
        $this->view->back = $id? '/methodist/dealer/edit/'.$id : '/methodist/dealer/add';
    }


}
