<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Users extends \Phalcon\Mvc\Model
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
    public $login;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $salt;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $second_name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $is_male;

    /**
     *
     * @var string
     */
    public $date_registration;

    /**
     *
     * @var string
     */
    public $birthday;

    /**
     *
     * @var string
     */
    public $phome;

    /**
     *
     * @var string
     */
    public $pmobile;

    /**
     *
     * @var string
     */
    public $address_home;

    /**
     *
     * @var string
     */
    public $photo_src;

    /**
     *
     * @var integer
     */
    public $old_id;

    /**
     *
     * @var integer
     */
    public $is_active;
    public function validation()
    {

        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
    public function initialize()
    {
        $this->hasMany('id', 'ActivitiesMethodists', 'user_id', array('alias' => 'ActivitiesMethodists'));
        $this->hasMany('id', 'BrandsMethodists', 'user_id', array('alias' => 'BrandsMethodists'));
        $this->hasMany('id', 'CompanyMethodists', 'user_id', array('alias' => 'CompanyMethodists'));
        $this->hasMany('id', 'DealersControllers', 'user_id', array('alias' => 'DealersControllers'));
        $this->hasMany('id', 'Students', 'user_id', array('alias' => 'Students'));
        $this->hasMany('id', 'UserAuthorization', 'user_id', array('alias' => 'UserAuthorization'));
        $this->hasMany('id', 'UserGroups', 'user_id', array('alias' => 'UserGroups'));
    }

}
