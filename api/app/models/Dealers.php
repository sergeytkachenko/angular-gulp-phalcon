<?php

class Dealers extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    public $city_id;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var integer
     */
    public $stafflist_group_id;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'Dealers', 'parent_id', array('alias' => 'Dealers'));
        $this->hasMany('id', 'DealersActivities', 'dealer_id', array('alias' => 'DealersActivities'));
        $this->hasMany('id', 'DealersBrands', 'dealer_id', array('alias' => 'DealersBrands'));
        $this->hasMany('id', 'DealersControllers', 'dealer_id', array('alias' => 'DealersControllers'));
        $this->hasMany('id', 'StafflistPostPlan', 'dealer', array('alias' => 'StafflistPostPlan'));
        $this->hasMany('id', 'StudentsPosts', 'dealer', array('alias' => 'StudentsPosts'));
        $this->belongsTo('city_id', 'City', 'id', array('alias' => 'City'));
        $this->belongsTo('status', 'DealerStatuses', 'id', array('alias' => 'DealerStatuses'));
        $this->belongsTo('parent_id', 'Dealers', 'id', array('alias' => 'Dealers'));
        $this->belongsTo('stafflist_group_id', 'StafflistGroup', 'id', array('alias' => 'StafflistGroup'));
        $this->belongsTo('city_id', 'City', 'id', array('alias' => 'City'));
    }

}
