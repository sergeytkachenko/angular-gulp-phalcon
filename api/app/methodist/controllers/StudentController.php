<?
namespace Multiple\Methodist\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Di\Service\BrandsService;
use Phalcon\Di\Service\ActivitiesService;
use Phalcon\Text as Utils;
use Phalcon\Logger\Adapter\File as FileAdapter;

class StudentController extends Controller {

    private $logFileName="../app/logs/StudentController.log";

    public function indexAction() {

        $this->view->title= $this->trans->_("students");
        $request=new Request();
        $students=\Students::find();
        $search=trim($request->get("search"));
        $pageCount=$request->get("page-count") ? $request->get("page-count") : $this->session->get("page-count");

        if ($pageCount) {
            $this->session->set("page-count", $pageCount);
        }
        $orderColumn=trim($request->get("order-column"))." ".trim($request->get("order-type"));
        $paginator=new \Phalcon\Paginator\Adapter\Model(
            array(
                "data" =>\Students::find(
                        array(
                            "order"     =>trim($orderColumn) ? $orderColumn : "id ASC",
                            "conditions"=>"id LIKE ?1 ",
                            "bind"      =>array(1=>"%".$search."%")
                        )),
                "limit"=>$pageCount ? $pageCount : 30,
                "page" =>$request->get("page")
            )
        );

        $page=$paginator->getPaginate();
        $this->view->page=$page;

        //$this->view->users=$students->;
        $this->view->countItems=count($page->items);
        $this->view->search=$search;
        $this->view->orderColumn=$request->get("order-column");
        $this->view->orderType=$request->get("order-type");
        $this->view->pageCount=$pageCount;
    }

    private function checkINN($INN) {
        //Далее следует алгоритм проверки корректности ИНН по данным Википедии
        if (strlen($INN) < 10) {
            return false;
        }
        $x=($INN[0]) * (-1) + ($INN[1]) * (5) +
            ($INN[2]) * (7) + ($INN[3]) * (9) +
            ($INN[4]) * (4) + ($INN[5]) * (6) +
            ($INN[6]) * (10) + ($INN[7]) * (5) +
            ($INN[8]) * (7);
        $x=($x % 11) % 10;

        //if ($x != ($INN[9])) {console.log("The last INN number must to be "+x);}
        return ($x==($INN[9]));
    }

    public function addAction() {
        $this->editAction();
        $this->view->title="Додати студента";
    }

    public function editAction($id=NULL) {
        $this->view->title="Редагувати студента";
        $this->view->nothing=true;
        $this->view->ind_code=$this->request->get("ind_code");
        if (((!is_null($this->view->ind_code)) && ($this->checkINN($this->view->ind_code))) || (!is_null($id))) {
            $this->view->nothing=false;
            $this->view->student=is_null($id) ? \Students::findFirst("ind_code = ".$this->view->ind_code) : \Students::findFirst($id);
            $this->view->user=$this->session->get("user");
            $methodistBrands=\BrandsMethodists::find("user_id=".$this->view->user->id)->toArray();
            $methodistActivities=\ActivitiesMethodists::find("user_id=".$this->view->user->id)->toArray();
            if ($this->view->student!=NULL) {
                $this->view->ind_code=$this->view->student->ind_code;
                $this->view->user=\Users::findFirst($this->view->student->user_id);
                $studentBrands=BrandsService::getStudentBrands($this->view->student);
                $studentActivities=ActivitiesService::getStudentActivities($this->view->student);
                $studentPostsJSON=array();
                if ($this->view->student->StudentsPosts!=NULL) {
                    foreach ($this->view->student->StudentsPosts as $sp) {

                        //{"dealer":"1","post":"2","brands":["2", "5"],"activities":["1"],"rate":"1.0","appoint_date":"2015-04-01"}
                        $studentPostsJSON[$sp->id]=array();
                        $studentPostsJSON[$sp->id]["dealer"]=$sp->dealer;
                        $studentPostsJSON[$sp->id]["post"]=$sp->post;
                        $array=array();
                        foreach ($sp->StudentsPostsBrands as $spb) {
                            $array[]=$spb->Brands->id;
                        }
                        $studentPostsJSON[$sp->id]["brands"]=$array;
                        $array=array();
                        foreach ($sp->StudentsPostsActivities as $spa) {
                            $array[]=$spa->Activities->id;
                        }
                        $studentPostsJSON[$sp->id]["activities"]=$array;
                        $studentPostsJSON[$sp->id]["rate"]=$sp->rate;
                        $studentPostsJSON[$sp->id]["appoint_date"]=$sp->appoint_date;

                    }

                }
                //$this->view->student->StudentsEducation;
            } else {
                $this->view->student=new \Students();
                $this->view->user=new \Users();
                $studentPostsJSON=array();
                $studentBrands=array();
                $studentActivities=array();
            }
            $this->view->brands=BrandsService::getForChosenEntity(\Brands::find()->toArray(), $methodistBrands, $studentBrands);
            $this->view->activities=ActivitiesService::getForChosenEntity(\Activities::find()->toArray(), $methodistActivities, $studentActivities);
            $this->view->allEducations=\Educations::find("parent_id is NULL");
            $this->view->allDealers=\Dealers::find();
            $this->view->studentPostsJSON=$studentPostsJSON;
        }
    }

    public function saveAction() {
        $this->view->title="Збереження студента";
        $errors=array();

        (!file_exists($this->logFileName)) ? $attr=array('mode'=>'w') : $attr=array();

        $logger=new FileAdapter($this->logFileName, $attr);
        $manager=new \Phalcon\Mvc\Model\Transaction\Manager();
        $transaction=$manager->get();
        $indCode=$this->request->get("ind_code");
        if ($indCode!=NULL) {
            $logger->log("indCode not NULL");
            if ($this->request->isPost()) {
                $logger->log("POST request finded");
                //debug($this->request->get());
                if ($this->request->get("uid")==NULL) {
                    $user=new \Users();
                    $logger->log("new User created");
                } else {
                    $user=\Users::findFirst($this->request->get("uid"));
                    if (!$user) {
                        $logger->warning("this User is not finded!");
                        $user=new \Users();
                        $logger->log("new User created");
                    } else {
                        $logger->log("User id is ".$user->id);
                    }
                }
                $user->setTransaction($transaction);
                $logger->log("Transaction started");
                $user->name=$this->request->get("name");
                $user->last_name=$this->request->get("last_name");
                $user->second_name=$this->request->get("second_name");
                $user->login=$this->request->get("login");
                $user->password=MD5($this->request->get("password"));
                $user->is_male=$this->request->get("is_male");
                $user->is_active=1;
                $user->email=$this->request->get("email");
                $user->date_registration=date('Y-m-d H:i:s');
                $user->birthday=$this->request->get("birthday");
                $user->address_home=$this->request->get("address_home");
                $user->phome=$this->request->get("phome");
                $user->pmobile=$this->request->get("pmobile");

                if ($this->request->get("id")==NULL) {
                    $student=new \Students();
                    $logger->log("new Student created");
                } else {
                    $student=\Students::findFirst($this->request->get("id"));
                    if (!$student) {
                        $logger->warning("this Student is not finded!");
                        $student=new \Students();
                        $logger->log("new Student created");
                    } else {
                        $logger->log("Student id is ".$user->id);
                    }
                }
                { //добавление студента
                    $student->ind_code=$indCode;

                    if (count($this->request->get("student_education")) > 0) {
                        $logger->log("student educations from request count>0, so start to add its");
                        $studentEducations=array();
                        { //добавление образований
                            $c=0;
                            foreach ($this->request->get("student_education") as $educ) {
                                $logger->log("Educ cycle #".$c++);
                                $educJSON=json_decode($educ, true);
                                $se=new \StudentsEducation();
                                if (!array_key_exists("education_child_id", $educJSON)) {
                                    $se->education_id=$educJSON["education_id"];
                                } else {
                                    $se->education_id=$educJSON["education_child_id"];
                                }
                                $se->institution=$educJSON["institution"];
                                $se->speciality=$educJSON["speciality"];
                                $se->qualify=$educJSON["qualify"];
                                $se->diploma_number=$educJSON["diploma_number"];
                                $se->diploma_date=$educJSON["diploma_date"];
                                $logger->log("Educ id = ".$educJSON["education_id"]);
                                $studentEducations[]=$se;
                            }
                        }
                    } else {
                        $logger->warning("No educations in request!");
                        $studentEducations=NULL;
                    }
                    if ($student->StudentsEducation->count() > 0) {
                        $logger->warning("Finded old education(s) (".$student->StudentsEducation->count().") in this Student. Trying to delete all its");
                        $c=0;
                        foreach ($student->StudentsEducation as $se) {
                            $logger->log("Educ delation cycle #".$c++);
                            $se->delete();
                        }
                    } else {
                        $logger->warning("no old educations finded!");
                    }
                    $student->StudentsEducation=$studentEducations;
                    //debug($student->StudentsEducation);

                    if (count($this->request->get("student_post")) > 0) {
                        $logger->log("There is Posts in request");
                        $studentPosts=array();
                        { //добавление должностей
                            $logger->log("new Posts addition");
                            $c=0;
                            foreach ($this->request->get("student_post") as $spost) {
                                $logger->log("Posts cycle #".$c++);
                                $spostJSON=json_decode($spost, true);
                                if (!array_key_exists("brands", $spostJSON)) {
                                    $spostJSON=array_values($spostJSON)[0];
                                }
                                $sp=new \StudentsPosts();
                                if (array_key_exists("dealer", $spostJSON)) $sp->dealer=$spostJSON["dealer"];
                                if (array_key_exists("post", $spostJSON)) $sp->post=$spostJSON["post"];
                                if (array_key_exists("rate", $spostJSON)) $sp->rate=$spostJSON["rate"];
                                if (array_key_exists("appoint_date", $spostJSON)) $sp->appoint_date=strtotime($spostJSON["appoint_date"]);

                                if (array_key_exists("brands", $spostJSON) && count($spostJSON["brands"]) > 0) { // Добавление брендов
                                    $logger->log("Brands finded. Triying to add all of ".(count($spostJSON["brands"]))." brands");
                                    $studentsPostsBrands=array();
                                    foreach ($spostJSON["brands"] as $brand) {
                                        $spb=new \StudentsPostsBrands();
                                        $spb->brand_id=$brand;
                                        $studentsPostsBrands[]=$spb;
                                    }
                                    $sp->StudentsPostsBrands=$studentsPostsBrands;
                                } else {
                                    $logger->warning("no Brands in this Post finded!");
                                }

                                if (array_key_exists("activities", $spostJSON) && count($spostJSON["activities"]) > 0) { // Добавление напр. деятельности
                                    $logger->log("Activities finded. Triying to add all of ".(count($spostJSON["activities"]))." activities");
                                    $studentPostsActivities=array();
                                    foreach ($spostJSON["activities"] as $activity) {
                                        $spa=new \StudentsPostsActivities();
                                        $spa->activity_id=$activity;
                                        $studentPostsActivities[]=$spa;
                                    }
                                    $sp->StudentsPostsActivities=$studentPostsActivities;
                                } else {
                                    $logger->warning("no Activities in this Post finded!");
                                }
                                $studentPosts[]=$sp;
                            }
                        }
                    } else {
                        $logger->warning("no Posts finded in request!");
                        $studentPosts=NULL;
                    }
                    if ($student->StudentsPosts->count() > 0) {
                        $logger->log("There is old Posts");
                        $c=0;
                        foreach ($student->StudentsPosts as $sp) {
                            $logger->log("old Posts deletion cycle #".$c++);
                            if ($sp->StudentsPostsActivities->count() > 0) {
                                $logger->log("there is some (".$sp->StudentsPostsActivities->count().") Activities in old Post. Deletion all of it.");
                                foreach ($sp->StudentsPostsActivities as $spa) {
                                    if ($spa->delete()) {
                                        $logger->log("StudentsPostsActivities id = ".$spa->activity_id." deleted");
                                    } else {
                                        $logger->warning("StudentsPostsActivities id = ".$spa->activity_id." deletion error!");
                                    }
                                }
                            } else {
                                $logger->warning("No one Activities in old Posts");
                            }
                            if ($sp->StudentsPostsBrands->count() > 0) {
                                $logger->log("there is some (".$sp->StudentsPostsBrands->count().") Brands in old Post. Deletion all of it.");
                                foreach ($sp->StudentsPostsBrands as $spb) {
                                    if ($spb->delete()) {
                                        $logger->log("StudentsPostsBrand id = ".$spb->brand_id." deleted");
                                    } else {
                                        $logger->warning("StudentsPostsBrand id = ".$spb->brand_id." deletion error!");
                                    }
                                }
                            } else {
                                $logger->warning("No one Brands in old Posts");
                            }
                            $logger->log("Posts id ".$sp->id." deletion");
                            if ($sp->delete()) {
                                $logger->log("StudentsPosts id = ".$sp->id." deleted");
                            } else {
                                $logger->warning("StudentsPosts id = ".$sp->id." deletion error!");
                            }
                        }
                    } else {
                        $logger->warning("no old Posts finded!");
                    }

                    $logger->log("Add all new Posts to Student");
                    $student->StudentsPosts=$studentPosts;
                    $logger->log("Add all new Students to User");
                    $user->Students=array($student);

                    if ($user->save()===false) {
                        $logger->log("User not saved!");
                        echo('<div class="alert alert-warning" role="alert">Під час збереження студента виникли наступні помилки: <br><ul>');
                        foreach ($user->getMessages() as $msg) {
                            echo("<li>".$msg."</li>");
                        }
                        echo("</ul></div>");
                        $transaction->rollback("Під час збереження студента виникли помилки");
                    } else {
                        if ($transaction->commit()) {
                            if ($this->request->get("id")==NULL) {
                                echo('<div class="alert alert-success" role="alert">Студент доданий успішно!</div>');
                            } else {
                                echo('<div class="alert alert-success" role="alert">Студент збережений успішно!</div>');
                            }
                            $logger->log("User saved!");
                        } else {
                            echo('<div class="alert alert-warning" role="alert">Під час збереження студента виникла помилка транзакції <br><ul>');
                            $logger->warning("Transaction save errors:");
                            foreach ($transaction->getMessages() as $msg) {
                                $logger->warning("--- ".$msg);
                            }
                        }
                    }
                }
                //$user->Students = array();
            }
        } else {
            echo('<div class="alert alert-warning" role="alert">Під час збереження студента виникла помилка. Вiдсутній ІНН!</div>');
            $transaction->rollback("Вiдсутній ІНН!");
            $logger->error("No INN!");
        }
    }

    //это спец-функция, чтобы отпарсить города в БД
    public function parseCitiesAction() {
        $csv=array();
        $lines=file('https://raw.githubusercontent.com/attichka/code_examples/master/phone_codes_parser/ukraine_phone_codes.csv', FILE_IGNORE_NEW_LINES);
        foreach ($lines as $key=>$value) {
            $csv[$key]=str_getcsv($value);
        }

        foreach ($csv as $data) {
            $city=new \City();
            $city->name=$data[0];
            if ($data[1]=="Київ") {
                $region=new \Region();
                $region->id=9;
            } elseif ($data[1]=="Севастополь") {
                $region=new \Region();
                $region->id=11;
            } else {
                $region=\Region::findFirst("name = '".$data[1]."'");
            }
            if ($region!=NULL) {
                $city->region_id=$region->id;
                $city->phone_code=$data[2];
                if ($city->save()) {
                    echo("FINE!");
                } else {
                    echo("<pre>");
                    foreach ($city->getMessages() as $message) {
                        echo "Message: ", $message->getMessage();
                        echo "Field: ", $message->getField();
                        echo "Type: ", $message->getType();
                    }
                    echo("</pre>");
                }
            } else {
                debug("Error parse region on: ", $city);
            }
        }
    }

}

