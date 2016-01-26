<?php

class QualificationStudents extends \Phalcon\Mvc\Model
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
    public $date;

    /**
     *
     * @var integer
     */
    public $student_id;

    /**
     *
     * @var integer
     */
    public $qualification_id;
    public function initialize()
    {
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
        $this->belongsTo('qualification_id', 'Qualification', 'id', array('alias' => 'Qualification'));
    }

}
