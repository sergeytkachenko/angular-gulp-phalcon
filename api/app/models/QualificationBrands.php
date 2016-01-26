<?php

class QualificationBrands extends \Phalcon\Mvc\Model
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
    public $brand_id;
    public function initialize()
    {
        $this->belongsTo('qualification_id', 'Qualification', 'id', array('alias' => 'Qualification'));
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
    }

}
