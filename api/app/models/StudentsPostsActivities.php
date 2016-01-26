<?php

class StudentsPostsActivities extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $student_post_id;

    /**
     *
     * @var integer
     */
    public $activity_id;
    public function initialize()
    {
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('student_post_id', 'StudentsPosts', 'id', array('alias' => 'StudentsPosts'));
    }

}
