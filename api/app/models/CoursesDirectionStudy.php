<?php

class CoursesDirectionStudy extends \Phalcon\Mvc\Model
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
    public $course_id;
    public function initialize()
    {
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
        $this->belongsTo('direction_study_id', 'DirectionStudy', 'id', array('alias' => 'DirectionStudy'));
    }

}
