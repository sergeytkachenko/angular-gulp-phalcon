<?
namespace Multiple\Rest\Controllers;

use EntityQuery;
use Exception;
use JsonController;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends JsonController
{

	public function findAllAction() {
		$this->setJson();
		$queryParams = $this->request->get('queryParams', null);
		if ($queryParams) {
			$criteriaEntity = EntityQuery::buildCriteria($queryParams);
			$data = $criteriaEntity->execute();
			return array(
				'data'       => $data? $data->toArray() : null,
				'totalCount' => $data? count($data->toArray()) : 0
			);
		}
		$data = call_user_func($this->model . "::find");
		return array(
			'data'       => $data? $data->toArray() : null,
			'totalCount' => $data? count($data->toArray()) : 0
		);
	}

	public function findOneAction() {
		$this->setJson();
		$id = $this->request->get('id');

		if (!$id) {
			throw new Exception('Id or lenguage_id is required');
		}
		$data = call_user_func($this->model . "::findFirst", $id);
		return $data->dump();
	}

	public function removeAction($id = null) {
		$id = $id ? $id : $this->request->get('id');
		if (!isset($id)) {
			throw new Exception('Id is required');
		}
		$data = call_user_func($this->model . "::findFirst", $id);
		return array(
			'success' => $data->delete()
		);
	}

	public function saveAction($id = null) {
		$this->setJson();
		$id = $id ? $id : $this->request->get('id');

		if (!isset($id)) {
			throw new Exception('Id is required');
		}

		$data = $this->request->getPost();
		unset($data['id']);
		if ($id == "new") {
			$item = new $this->model;
			$item->assign($data);
			if (!$item->save()) {
				return array(
					"success" => false,
					"errors"  => $this->jsonRecursiveGetMsg($item->getMessages()),
					"data"    => $data
				);
			}
		} else {
			$item = call_user_func($this->model . "::findFirst", $id);
			$item->save($data);
		}

		return array(
			"success" => true,
			"errors"  => $this->jsonRecursiveGetMsg($item->getMessages()),
			"data"    => $data
		);
	}

	public function afterExecuteRoute(Dispatcher $dispatcher) {
		$this->view->disable();

		$data = $dispatcher->getReturnedValue();
		if (is_array($data)) {
			$data = json_encode($data);
		}

		$this->response->setContentType('application/json', 'UTF-8');
		$this->response->setContent($data);
		$this->response->send();
	}
}
