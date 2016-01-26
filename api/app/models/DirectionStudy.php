<?php

class DirectionStudy extends \Phalcon\Mvc\Model
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
    public $direction_study_group_id;

    /**
     *
     * @var integer
     */
    public $is_managerial_position;

    /**
     *
     * @var integer
     */
    public $old_position_id;
    public function initialize()
    {
        $this->hasMany('id', 'CoursesDirectionStudy', 'direction_study_id', array('alias' => 'CoursesDirectionStudy'));
        $this->hasMany('id', 'Qualification', 'direction_study_id', array('alias' => 'Qualification'));
        $this->hasMany('id', 'Stafflist', 'direction_study', array('alias' => 'Stafflist'));
        $this->hasMany('id', 'Stafflist', 'direction_study_id', array('alias' => 'Stafflist'));
        $this->hasMany('id', 'StatCoursesDirectionStudy', 'direction_study_id', array('alias' => 'StatCoursesDirectionStudy'));
        $this->belongsTo('direction_study_group_id', 'DirectionStudyGroups', 'id', array('alias' => 'DirectionStudyGroups'));
    }

}
