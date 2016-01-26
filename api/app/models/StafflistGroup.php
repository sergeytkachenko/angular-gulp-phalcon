<?php

class StafflistGroup extends \Phalcon\Mvc\Model
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
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'Dealers', 'stafflist_group_id', array('alias' => 'Dealers'));
        $this->hasMany('id', 'Stafflist', 'stafflist_group', array('alias' => 'Stafflist'));
        $this->hasMany('id', 'Stafflist', 'stafflist_group_id', array('alias' => 'Stafflist'));
    }

}
