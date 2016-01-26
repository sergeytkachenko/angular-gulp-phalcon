<?php

class Courses extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $section;

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
        $this->hasMany('id', 'CoursesActivities', 'course_id', array('alias' => 'CoursesActivities'));
        $this->hasMany('id', 'CoursesBrands', 'course_id', array('alias' => 'CoursesBrands'));
        $this->hasMany('id', 'CoursesChapters', 'course_id', array('alias' => 'CoursesChapters'));
        $this->hasMany('id', 'CoursesDirectionStudy', 'course_id', array('alias' => 'CoursesDirectionStudy'));
        $this->hasMany('id', 'CoursesLessons', 'course_id', array('alias' => 'CoursesLessons'));
        $this->hasMany('id', 'QualificationCourses', 'course_id', array('alias' => 'QualificationCourses'));
        $this->hasMany('id', 'StudentsCertifications', 'course_id', array('alias' => 'StudentsCertifications'));
        $this->hasMany('id', 'Tests', 'course', array('alias' => 'Tests'));
        $this->belongsTo('section', 'CoursesSections', 'id', array('alias' => 'CoursesSections'));
    }

}
