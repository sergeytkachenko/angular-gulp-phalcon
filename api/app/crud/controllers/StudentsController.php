<?php
namespace Multiple\Crud\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class StudentsController extends Controller
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for students
     */
    public function searchAction() {
        $query = Criteria::fromInput($this->di, "Students", array_merge($_GET, $_POST));
        $this->persistent->parameters = $query->getParams();
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }

        $students = \Students::find($parameters)->toArray(true);
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo json_encode(array("student" => $students));
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a student
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $student = \Students::findFirstByid($id);
            if (!$student) {
                $this->flash->error("student was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "students",
                    "action" => "index"
                ));
            }

            $this->view->id = $student->getId();

            $this->tag->setDefault("id", $student->getId());
            $this->tag->setDefault("user_id", $student->getUserId());
            $this->tag->setDefault("ind_code", $student->getIndCode());
            $this->tag->setDefault("sheet_staff", $student->getSheetStaff());
            $this->tag->setDefault("order_accept", $student->getOrderAccept());
            $this->tag->setDefault("post_for_display", $student->getPostForDisplay());
            $this->tag->setDefault("old_id", $student->getOldId());
            
        }
    }

    /**
     * Creates a new student
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "index"
            ));
        }

        $student = new Students();

        $student->setUserId($this->request->getPost("user_id"));
        $student->setIndCode($this->request->getPost("ind_code"));
        $student->setSheetStaff($this->request->getPost("sheet_staff"));
        $student->setOrderAccept($this->request->getPost("order_accept"));
        $student->setPostForDisplay($this->request->getPost("post_for_display"));
        $student->setOldId($this->request->getPost("old_id"));
        

        if (!$student->save()) {
            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "new"
            ));
        }

        $this->flash->success("student was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "students",
            "action" => "index"
        ));

    }

    /**
     * Saves a student edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $student = Students::findFirstByid($id);
        if (!$student) {
            $this->flash->error("student does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "index"
            ));
        }

        $student->setUserId($this->request->getPost("user_id"));
        $student->setIndCode($this->request->getPost("ind_code"));
        $student->setSheetStaff($this->request->getPost("sheet_staff"));
        $student->setOrderAccept($this->request->getPost("order_accept"));
        $student->setPostForDisplay($this->request->getPost("post_for_display"));
        $student->setOldId($this->request->getPost("old_id"));
        

        if (!$student->save()) {

            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "edit",
                "params" => array($student->id)
            ));
        }

        $this->flash->success("student was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "students",
            "action" => "index"
        ));

    }

    /**
     * Deletes a student
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $student = Students::findFirstByid($id);
        if (!$student) {
            $this->flash->error("student was not found");

            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "index"
            ));
        }

        if (!$student->delete()) {

            foreach ($student->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "students",
                "action" => "search"
            ));
        }

        $this->flash->success("student was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "students",
            "action" => "index"
        ));
    }

    /**
     *
     */
    public function checkIPNAction($ind_code=NULL) {
        if ($ind_code==NULL) {
            if ($this->request->get("ind_code")!=NULL) {
                $ind_code=$this->request->get("ind_code");
            } else {
                return false;
            }
        }
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $res = \Students::findFirst("ind_code='".$ind_code."'");
        //if ($res) {$res=$res->toArray(true);}
        echo json_encode($res ? $res->toArray(true) : false);
    }
}
