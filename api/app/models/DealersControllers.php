<?php

class DealersControllers extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $dealer_id;

    /**
     *
     * @var integer
     */
    public $user_id;
    public function initialize()
    {
        $this->belongsTo('dealer_id', 'Dealers', 'id', array('alias' => 'Dealers'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
