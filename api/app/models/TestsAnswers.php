<?php

class TestsAnswers extends \Phalcon\Mvc\Model
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
    public $title;

    /**
     *
     * @var integer
     */
    public $is_correct;

    /**
     *
     * @var integer
     */
    public $question_id;

    /**
     *
     * @var integer
     */
    public $sort;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->belongsTo('question_id', 'TestsQuestions', 'id', array('alias' => 'TestsQuestions'));
    }

}
