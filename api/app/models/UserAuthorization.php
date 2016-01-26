<?php

class UserAuthorization extends \Phalcon\Mvc\Model
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
    public $user_id;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var string
     */
    public $last_time;

    /**
     *
     * @var string
     */
    public $expired_time;

    /**
     *
     * @var string
     */
    public $user_agent;

    /**
     *
     * @var string
     */
    public $user_ip;

    /**
     *
     * @var string
     */
    public $user_os;

    /**
     *
     * @var string
     */
    public $session_id;
    public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id', array('alias' => 'Users'));
    }

}
