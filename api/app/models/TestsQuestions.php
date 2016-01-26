<?php

class TestsQuestions extends \Phalcon\Mvc\Model
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
    public $test_id;

    /**
     *
     * @var string
     */
    public $date_created;

    /**
     *
     * @var integer
     */
    public $is_multiple;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $sort;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $point;

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
        $this->hasMany('id', 'TestsAnswers', 'question_id', array('alias' => 'TestsAnswers'));
        $this->belongsTo('test_id', 'Tests', 'id', array('alias' => 'Tests'));
    }

}
