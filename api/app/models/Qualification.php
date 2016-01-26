<?php

class Qualification extends \Phalcon\Mvc\Model
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
    public $qualification_group_id;

    /**
     *
     * @var integer
     */
    public $direction_study_id;

    /**
     *
     * @var string
     */
    public $date_start;

    /**
     *
     * @var string
     */
    public $date_end;

    /**
     *
     * @var integer
     */
    public $test_id;

    /**
     *
     * @var integer
     */
    public $seminar_id;
    public function initialize()
    {
        $this->hasMany('id', 'QualificationActivities', 'qualification_id', array('alias' => 'QualificationActivities'));
        $this->hasMany('id', 'QualificationBrands', 'qualification_id', array('alias' => 'QualificationBrands'));
        $this->hasMany('id', 'QualificationCourses', 'qualification_id', array('alias' => 'QualificationCourses'));
        $this->hasMany('id', 'QualificationCoursesStat', 'qualification_id', array('alias' => 'QualificationCoursesStat'));
        $this->hasMany('id', 'QualificationStudents', 'qualification_id', array('alias' => 'QualificationStudents'));
        $this->belongsTo('direction_study_id', 'DirectionStudy', 'id', array('alias' => 'DirectionStudy'));
        $this->belongsTo('qualification_group_id', 'QualificationGroup', 'id', array('alias' => 'QualificationGroup'));
    }

}
