<?php

class StatCoursesDirectionStudy extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $direction_study_id;

    /**
     *
     * @var integer
     */
    public $stat_course_id;
    public function initialize()
    {
        $this->belongsTo('direction_study_id', 'DirectionStudy', 'id', array('alias' => 'DirectionStudy'));
        $this->belongsTo('stat_course_id', 'StatCourses', 'id', array('alias' => 'StatCourses'));
    }

}
