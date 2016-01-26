<?php

class Brands extends \Phalcon\Mvc\Model
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

    /**
     *
     * @var integer
     */
    public $old_id;
    public function initialize()
    {
        $this->hasMany('id', 'BrandsMethodists', 'brand_id', array('alias' => 'BrandsMethodists'));
        $this->hasMany('id', 'CompanyBrands', 'brand_id', array('alias' => 'CompanyBrands'));
        $this->hasMany('id', 'CoursesBrands', 'brand_id', array('alias' => 'CoursesBrands'));
        $this->hasMany('id', 'DealersBrands', 'brand_id', array('alias' => 'DealersBrands'));
        $this->hasMany('id', 'QualificationBrands', 'brand_id', array('alias' => 'QualificationBrands'));
        $this->hasMany('id', 'StafflistPostPlan', 'brand', array('alias' => 'StafflistPostPlan'));
        $this->hasMany('id', 'StatCoursesBrands', 'brand_id', array('alias' => 'StatCoursesBrands'));
        $this->hasMany('id', 'StudentsPostsBrands', 'brand_id', array('alias' => 'StudentsPostsBrands'));
        $this->hasMany('id', 'StudentsStatus', 'brand_id', array('alias' => 'StudentsStatus'));
    }

}
