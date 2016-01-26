<?php

class DealersBrands extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $brand_id;

    /**
     *
     * @var integer
     */
    public $dealer_id;
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('dealer_id', 'Dealers', 'id', array('alias' => 'Dealers'));
    }

}
