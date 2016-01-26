<?php

class StudentsPosts extends \Phalcon\Mvc\Model
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
    public $student;

    /**
     *
     * @var string
     */
    public $rate;

    /**
     *
     * @var integer
     */
    public $post;

    /**
     *
     * @var integer
     */
    public $dealer;

    /**
     *
     * @var integer
     */
    public $activity;

    /**
     *
     * @var string
     */
    public $appoint_date;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'StudentsPostsActivities', 'student_post_id', array('alias' => 'StudentsPostsActivities'));
        $this->hasMany('id', 'StudentsPostsBrands', 'student_post_id', array('alias' => 'StudentsPostsBrands'));
        $this->belongsTo('activity', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('dealer', 'Dealers', 'id', array('alias' => 'Dealers'));
        $this->belongsTo('post', 'Posts', 'id', array('alias' => 'Posts'));
        $this->belongsTo('student', 'Students', 'id', array('alias' => 'Students'));
    }

}
