<?php

class SeminarsStudents extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $seminar_id;

    /**
     *
     * @var integer
     */
    public $student_id;
    public function initialize()
    {
        $this->belongsTo('seminar_id', 'Seminars', 'id', array('alias' => 'Seminars'));
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
    }

}
