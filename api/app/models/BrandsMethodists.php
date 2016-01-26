<?php

class BrandsMethodists extends \Phalcon\Mvc\Model
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
    public $user_id;
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
