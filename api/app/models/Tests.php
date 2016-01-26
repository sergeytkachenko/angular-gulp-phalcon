<?php

class Tests extends \Phalcon\Mvc\Model
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
    public $date_created;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $course;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $attempt_limit;

    /**
     *
     * @var integer
     */
    public $time_limit;

    /**
     *
     * @var integer
     */
    public $completed_score;

    /**
     *
     * @var string
     */
    public $question_from;

    /**
     *
     * @var integer
     */
    public $question_amount;

    /**
     *
     * @var integer
     */
    public $passage_type;

    /**
     *
     * @var integer
     */
    public $is_random_questions;

    /**
     *
     * @var integer
     */
    public $is_random_answers;

    /**
     *
     * @var integer
     */
    public $is_approved;

    /**
     *
     * @var integer
     */
    public $is_include_self_test;

    /**
     *
     * @var integer
     */
    public $is_active;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'TestsAttempts', 'test_id', array('alias' => 'TestsAttempts'));
        $this->hasMany('id', 'TestsGradebook', 'test_id', array('alias' => 'TestsGradebook'));
        $this->hasMany('id', 'TestsQuestions', 'test_id', array('alias' => 'TestsQuestions'));
        $this->belongsTo('course', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
