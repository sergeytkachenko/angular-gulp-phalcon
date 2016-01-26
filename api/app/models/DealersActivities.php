<?php

class DealersActivities extends \Phalcon\Mvc\Model
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
    public $dealer_id;
    public function initialize()
    {
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('dealer_id', 'Dealers', 'id', array('alias' => 'Dealers'));
    }

}
