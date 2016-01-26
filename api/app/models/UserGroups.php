<?php

class UserGroups extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $group_id;
    public function initialize()
    {
        $this->belongsTo('group_id', 'Groups', 'id', array('alias' => 'Groups'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
        $this->belongsTo('group_id', 'Groups', 'id', array('alias' => 'Groups'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
