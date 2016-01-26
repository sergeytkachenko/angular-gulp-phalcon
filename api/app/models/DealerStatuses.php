<?php

class DealerStatuses extends \Phalcon\Mvc\Model
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
        $this->hasMany('id', 'Dealers', 'status', array('alias' => 'Dealers'));
    }

}
