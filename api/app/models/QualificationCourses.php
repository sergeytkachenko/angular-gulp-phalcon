<?php

class QualificationCourses extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $course_id;

    /**
     *
     * @var integer
     */
    public $qualification_id;
    public function initialize()
    {
        $this->belongsTo('qualification_id', 'Qualification', 'id', array('alias' => 'Qualification'));
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
