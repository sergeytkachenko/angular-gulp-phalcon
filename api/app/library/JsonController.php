<?
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class JsonController extends \Phalcon\Mvc\Controller {

    protected $_isJsonResponse = false;

    // Call this func to set json response enabled
    public function setJson() {
        $this->view->disable();

        $this->_isJsonResponse = true;
        $this->response->setContentType('application/json', 'UTF-8');
    }

    // After route executed event
    public function afterExecuteRoute(Dispatcher $dispatcher) {
        if ($this->_isJsonResponse) {
            $data = $dispatcher->getReturnedValue();
            if (is_array($data)) {
                $data = json_encode($data);
            }
            $this->response->setContent($data);
            $this->response->send();
        }
    }

    public function jsonRecursiveGetMsg ($dataList) {
        $messages = array();
        foreach($dataList as $data) {
            $messages[] = $data->getMessage();
        }
        return $messages;
    }

}