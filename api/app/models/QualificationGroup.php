<?php

class QualificationGroup extends \Phalcon\Mvc\Model
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
    public $parent_id;
    public function initialize()
    {
        $this->hasMany('id', 'Qualification', 'qualification_group_id', array('alias' => 'Qualification'));
        $this->hasMany('id', 'QualificationGroup', 'parent_id', array('alias' => 'QualificationGroup'));
        $this->belongsTo('parent_id', 'QualificationGroup', 'id', array('alias' => 'QualificationGroup'));
    }

}
