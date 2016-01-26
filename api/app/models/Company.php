<?php

class Company extends \Phalcon\Mvc\Model
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
    public function initialize()
    {
        $this->hasMany('id', 'CompanyActivities', 'company_id', array('alias' => 'CompanyActivities'));
        $this->hasMany('id', 'CompanyBrands', 'company_id', array('alias' => 'CompanyBrands'));
        $this->hasMany('id', 'CompanyMethodists', 'company_id', array('alias' => 'CompanyMethodists'));
    }

}
