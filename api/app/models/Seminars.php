<?php

class Seminars extends \Phalcon\Mvc\Model
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
    public $stat_course;

    /**
     *
     * @var integer
     */
    public $capacity;

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
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'SeminarsMarks', 'seminar_id', array('alias' => 'SeminarsMarks'));
        $this->hasMany('id', 'SeminarsStudents', 'seminar_id', array('alias' => 'SeminarsStudents'));
        $this->belongsTo('stat_course', 'StatCourses', 'id', array('alias' => 'StatCourses'));
    }

}
