<?php

class CoursesBrands extends \Phalcon\Mvc\Model
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
    public $course_id;
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('course_id', 'Courses', 'id', array('alias' => 'Courses'));
    }

}
