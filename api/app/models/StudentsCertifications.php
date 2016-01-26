<?php

class StudentsCertifications extends \Phalcon\Mvc\Model
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
    public $student_id;

    /**
     *
     * @var integer
     */
    public $course_id;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var integer
     */
    public $mark;

    /**
     *
     * @var integer
     */
    public $mark_max;

    /**
     *
     * @var string
     */
    public $mark_percent;
    public function initialize()
    {
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
