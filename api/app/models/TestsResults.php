<?php

class TestsResults extends \Phalcon\Mvc\Model
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
    public $attempt_id;

    /**
     *
     * @var integer
     */
    public $question_id;

    /**
     *
     * @var integer
     */
    public $answer_id;

    /**
     *
     * @var integer
     */
    public $is_correct;

}
