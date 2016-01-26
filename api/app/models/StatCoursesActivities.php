<?php

class StatCoursesActivities extends \Phalcon\Mvc\Model
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
    public $stat_course_id;
    public function initialize()
    {
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('stat_course_id', 'StatCourses', 'id', array('alias' => 'StatCourses'));
    }

}
