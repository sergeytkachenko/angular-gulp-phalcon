<?php

class CompanyBrands extends \Phalcon\Mvc\Model
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
    public $brand_id;
    public function initialize()
    {
        $this->belongsTo('company_id', 'Company', 'id', array('alias' => 'Company'));
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
    }

}
