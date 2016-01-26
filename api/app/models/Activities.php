<?php

class Activities extends \Phalcon\Mvc\Model
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
    public $parent;
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getParent()
    {
        return $this->parent;
    }
    public function initialize()
    {
        $this->hasMany('id', 'Activities', 'parent', array('alias' => 'Activities'));
        $this->hasMany('id', 'ActivitiesMethodists', 'activity_id', array('alias' => 'ActivitiesMethodists'));
        $this->hasMany('id', 'CompanyActivities', 'activity_id', array('alias' => 'CompanyActivities'));
        $this->hasMany('id', 'CoursesActivities', 'activity_id', array('alias' => 'CoursesActivities'));
        $this->hasMany('id', 'DealersActivities', 'activity_id', array('alias' => 'DealersActivities'));
        $this->hasMany('id', 'QualificationActivities', 'activity_id', array('alias' => 'QualificationActivities'));
        $this->hasMany('id', 'Stafflist', 'activity', array('alias' => 'Stafflist'));
        $this->hasMany('id', 'StafflistPostPlan', 'activity', array('alias' => 'StafflistPostPlan'));
        $this->hasMany('id', 'StatCoursesActivities', 'activity_id', array('alias' => 'StatCoursesActivities'));
        $this->hasMany('id', 'StudentsAbilities', 'activity', array('alias' => 'StudentsAbilities'));
        $this->belongsTo('parent', 'Activities', 'id', array('alias' => 'Activities'));
    }

}
