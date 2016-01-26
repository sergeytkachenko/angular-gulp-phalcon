<?php

class StatCoursesBrands extends \Phalcon\Mvc\Model
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
    public $stat_course_id;
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id', array('alias' => 'Brands'));
        $this->belongsTo('stat_course_id', 'StatCourses', 'id', array('alias' => 'StatCourses'));
    }

}
