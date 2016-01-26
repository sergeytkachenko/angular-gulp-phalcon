<?php

class StatCourses extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $created;

    /**
     *
     * @var integer
     */
    public $is_active;

    /**
     *
     * @var string
     */
    public $code;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $preview_picture;

    /**
     *
     * @var string
     */
    public $preview_text;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $active_from;

    /**
     *
     * @var string
     */
    public $active_to;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'QualificationCoursesStat', 'stat_course_id', array('alias' => 'QualificationCoursesStat'));
        $this->hasMany('id', 'Seminars', 'stat_course', array('alias' => 'Seminars'));
        $this->hasMany('id', 'StatCoursesActivities', 'stat_course_id', array('alias' => 'StatCoursesActivities'));
        $this->hasMany('id', 'StatCoursesBrands', 'stat_course_id', array('alias' => 'StatCoursesBrands'));
        $this->hasMany('id', 'StatCoursesDirectionStudy', 'stat_course_id', array('alias' => 'StatCoursesDirectionStudy'));
    }

}
