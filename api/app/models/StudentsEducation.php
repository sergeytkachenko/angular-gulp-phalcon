<?php

class StudentsEducation extends \Phalcon\Mvc\Model
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
    public $education_id;

    /**
     *
     * @var string
     */
    public $institution;

    /**
     *
     * @var string
     */
    public $diploma_number;

    /**
     *
     * @var string
     */
    public $diploma_date;

    /**
     *
     * @var string
     */
    public $speciality;

    /**
     *
     * @var string
     */
    public $qualify;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->belongsTo('education_id', 'Educations', 'id', array('alias' => 'Educations'));
        $this->belongsTo('student_id', 'Students', 'id', array('alias' => 'Students'));
    }

}
