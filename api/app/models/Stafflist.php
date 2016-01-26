<?php

class Stafflist extends \Phalcon\Mvc\Model
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
    public $post;

    /**
     *
     * @var integer
     */
    public $direction_study;

    /**
     *
     * @var integer
     */
    public $stafflist_group;

    /**
     *
     * @var string
     */
    public $parent;

    /**
     *
     * @var string
     */
    public $department_title;

    /**
     *
     * @var integer
     */
    public $staff_old_id;

    /**
     *
     * @var integer
     */
    public $parent_old_id;
    public function initialize()
    {
        $this->hasMany('id', 'StafflistPostPlan', 'stafflist', array('alias' => 'StafflistPostPlan'));
        $this->belongsTo('direction_study', 'DirectionStudy', 'id', array('alias' => 'DirectionStudy'));
        $this->belongsTo('post', 'Posts', 'id', array('alias' => 'Posts'));
        $this->belongsTo('stafflist_group', 'StafflistGroup', 'id', array('alias' => 'StafflistGroup'));
    }

}
