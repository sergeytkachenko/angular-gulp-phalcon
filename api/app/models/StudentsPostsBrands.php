<?php

class StudentsPostsBrands extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $student_post_id;

    /**
     *
     * @var integer
     */
    public $brand_id;
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('student_post_id', 'StudentsPosts', 'id', array('alias' => 'StudentsPosts'));
    }

}
