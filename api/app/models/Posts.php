<?php

class Posts extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $alias;
    public function initialize()
    {
        $this->hasMany('id', 'Stafflist', 'post', array('alias' => 'Stafflist'));
        $this->hasMany('id', 'StudentsPosts', 'post', array('alias' => 'StudentsPosts'));
    }

}
