<?php

class CompanyMethodists extends \Phalcon\Mvc\Model
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
    public $user_id;
    public function initialize()
    {
        $this->belongsTo('company_id', 'Company', 'id', array('alias' => 'Company'));
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
