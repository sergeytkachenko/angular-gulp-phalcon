<?php

class Region extends \Phalcon\Mvc\Model
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
    public $name;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'City', 'region_id', array('alias' => 'City'));
        $this->hasMany('id', 'City', 'region_id', array('alias' => 'City'));
    }

}
