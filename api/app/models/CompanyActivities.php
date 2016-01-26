<?php

class CompanyActivities extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $company_id;

    /**
     *
     * @var integer
     */
    public $activity_id;
    public function initialize()
    {
        $this->belongsTo('company_id', 'Company', 'id', array('alias' => 'Company'));
        $this->belongsTo('activity_id', 'Activities', 'id', array('alias' => 'Activities'));
    }

}
