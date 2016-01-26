<?php

class QualificationCoursesStat extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $qualification_id;

    /**
     *
     * @var integer
     */
    public $stat_course_id;
    public function initialize()
    {
        $this->belongsTo('stat_course_id', 'StatCourses', 'id', array('alias' => 'StatCourses'));
        $this->belongsTo('qualification_id', 'Qualification', 'id', array('alias' => 'Qualification'));
    }

}
