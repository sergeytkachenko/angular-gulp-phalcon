<?
use Phalcon\Mvc\Dispatcher;

class InitController extends JsonController {


    public $br = null;
    public $appEmails = array();

    public function initialize() {

    }

    public function checkUser () {
        if(!$this->session->get("user")) {
            $this->response->redirect('/user/login');
        }
    }

    private function initConfig () {
        $configs = Config::find();
        foreach ($configs as $config) {
            $this->setInView($config->name, $config->value);
        }
        $this->appEmails = explode(",", Config::findFirst('name = "email"')->value);
    }


    private function setMetaDefault () {
        $url = $this->router->getRewriteUri();
        $meta = Meta::findFirst(array(
            'url = :url:',
            'bind' => array(
                "url" => $url
            )
        ));
        $this->view->setVar('meta', $meta);
    }

    protected function setMeta ($title, $description =null, $keywords =null) {
        $this->setInView('title', $title);
        if($description) $this->setInView('description', $description);
        if($keywords) $this->setInView('keywords', $keywords);
    }

    protected function setInView($key, $var) {
        $this->view->setVar($key, $var);
    }

    public function afterExecuteRoute(Dispatcher $dispatcher) {
        parent::afterExecuteRoute($dispatcher);
    }

}