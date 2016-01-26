<?php

class CoursesActivities extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $activity_id;

    /**
     *
     * @var integer
     */
    public $course_id;
    public function initialize()
    {
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
