<?php

class QualificationActivities extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $qualification_id;

    /**
     *
     * @var integer
     */
    public $activity_id;
    public function initialize()
    {
        $this->belongsTo('qualification_id', 'Qualification', 'id', array('alias' => 'Qualification'));
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
    }

}
