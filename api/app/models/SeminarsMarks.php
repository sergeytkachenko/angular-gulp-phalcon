<?php

class SeminarsMarks extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

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

    /**
     *
     * @var integer
     */
    public $mark;
    public function initialize()
    {
        $this->belongsTo('seminar_id', 'Seminars', 'id', array('alias' => 'Seminars'));
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
    }

}
