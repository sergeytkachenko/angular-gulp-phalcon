<?php

class ActivitiesMethodists extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $activity_id;

    /**
     *
     * @var integer
     */
    public $user_id;
    public function initialize()
    {
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
