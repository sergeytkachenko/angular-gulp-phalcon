<?php

class TestsGradebook extends \Phalcon\Mvc\Model
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
    public $student_id;

    /**
     *
     * @var integer
     */
    public $test_id;

    /**
     *
     * @var integer
     */
    public $result;

    /**
     *
     * @var integer
     */
    public $max_result;

    /**
     *
     * @var integer
     */
    public $attempts_count;

    /**
     *
     * @var integer
     */
    public $is_completed;

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
    public function initialize()
    {
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
        $this->belongsTo('test_id', 'Tests', 'id', array('alias' => 'Tests'));
    }

}
