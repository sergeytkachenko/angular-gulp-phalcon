<?php

class Groups extends \Phalcon\Mvc\Model
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
        $this->hasMany('id', 'UserGroups', 'group_id', array('alias' => 'UserGroups'));
        $this->hasMany('id', 'UserGroups', 'group_id', array('alias' => 'UserGroups'));
    }

}
