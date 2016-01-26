<?php

class DirectionStudyGroups extends \Phalcon\Mvc\Model
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
    public function initialize()
    {
        $this->hasMany('id', 'DirectionStudy', 'direction_study_group_id', array('alias' => 'DirectionStudy'));
    }

}
