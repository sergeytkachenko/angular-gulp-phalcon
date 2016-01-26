<?php

class City extends \Phalcon\Mvc\Model
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
    public $region_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $phone_code;
    public function initialize()
    {
        $this->hasMany('id', 'Dealers', 'city_id', array('alias' => 'Dealers'));
        $this->hasMany('id', 'Dealers', 'city_id', array('alias' => 'Dealers'));
        $this->belongsTo('region_id', 'Region', 'id', array('alias' => 'Region'));
        $this->belongsTo('region_id', 'Region', 'id', array('alias' => 'Region'));
    }

}
