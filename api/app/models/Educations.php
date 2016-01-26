<?php

class Educations extends \Phalcon\Mvc\Model
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

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'Educations', 'parent_id', array('alias' => 'Educations'));
        $this->hasMany('id', 'StudentsEducation', 'education_id', array('alias' => 'StudentsEducation'));
        $this->belongsTo('parent_id', 'Educations', 'id', array('alias' => 'Educations'));
    }

}
