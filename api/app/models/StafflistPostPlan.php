<?php

class StafflistPostPlan extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $stafflist;

    /**
     *
     * @var integer
     */
    public $dealer;

    /**
     *
     * @var integer
     */
    public $activity;

    /**
     *
     * @var integer
     */
    public $brand;

    /**
     *
     * @var integer
     */
    public $post_plan_count;

    /**
     *
     * @var integer
     */
    public $post_plan_total_count;
    public function initialize()
    {
        $this->belongsTo('activity', 'Activities', 'id', array('alias' => 'Activities'));
        $this->belongsTo('brand', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('dealer', 'Dealers', 'id', array('alias' => 'Dealers'));
        $this->belongsTo('stafflist', 'Stafflist', 'id', array('alias' => 'Stafflist'));
    }

}
