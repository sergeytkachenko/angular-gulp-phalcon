<?php

class Students extends \Phalcon\Mvc\Model
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
    public $user_id;

    /**
     *
     * @var string
     */
    public $ind_code;

    /**
     *
     * @var string
     */
    public $sheet_staff;

    /**
     *
     * @var string
     */
    public $order_accept;

    /**
     *
     * @var string
     */
    public $post_for_display;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'QualificationStudents', 'student_id', array('alias' => 'QualificationStudents'));
        $this->hasMany('id', 'SeminarsMarks', 'student_id', array('alias' => 'SeminarsMarks'));
        $this->hasMany('id', 'SeminarsStudents', 'student_id', array('alias' => 'SeminarsStudents'));
        $this->hasMany('id', 'StudentsCertifications', 'student_id', array('alias' => 'StudentsCertifications'));
        $this->hasMany('id', 'StudentsEducation', 'student_id', array('alias' => 'StudentsEducation'));
        $this->hasMany('id', 'StudentsPosts', 'student', array('alias' => 'StudentsPosts'));
        $this->hasMany('id', 'StudentsStatus', 'student_id', array('alias' => 'StudentsStatus'));
        $this->hasMany('id', 'TestsAttempts', 'student_id', array('alias' => 'TestsAttempts'));
        $this->hasMany('id', 'TestsGradebook', 'student_id', array('alias' => 'TestsGradebook'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
