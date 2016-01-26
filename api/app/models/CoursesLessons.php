<?php

class CoursesLessons extends \Phalcon\Mvc\Model
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
    public $course_id;

    /**
     *
     * @var integer
     */
    public $chapter_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $preview;

    /**
     *
     * @var string
     */
    public $detail;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->belongsTo('chapter_id', 'CoursesChapters', 'id', array('alias' => 'CoursesChapters'));
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
