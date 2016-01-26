<?php

class TestsAttempts extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $student_id;

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
    public $is_time_expired;

    /**
     *
     * @var integer
     */
    public $is_completed;

    /**
     *
     * @var integer
     */
    public $questions_count;

    /**
     *
     * @var integer
     */
    public $scope;

    /**
     *
     * @var integer
     */
    public $scope_max;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->belongsTo('test_id', 'Tests', 'id', array('alias' => 'Tests'));
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
    }

}
