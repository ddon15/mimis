<?php

class User{
    //user status
    const REGISTERED = 2 ;
    const VERIFIED_ACTIVE = 1 ; 
    const INACTIVE = 0 ;

    //User Type
    const ANONYMOUS_USER = 0 ;
    const ADMIN_USER = 1 ;

    const PHP_TIMEZONE = 'Asia/Manila';

    public $table_name = "user";
    /*
    * Set default date
    */
    public $dateTime;

    public function __construct() {

        date_default_timezone_set(SELF::PHP_TIMEZONE);
        $dateTimeFormat = date('Y-m-d h:i:s', time());

        $this->dateTime = $dateTimeFormat;
    }
 
    public function getStatus($status = 2){
        $changeStatus = '';
        if( $status != SELF::REGISTERED ){
            switch($status){
                case SELF::ACTIVE :
                    $changeStatus = SELF::ACTIVE;
                break;
                case SELF::INACTIVE :
                    $changeStatus = SELF::INACTIVE;
                break;
            }
        }else $changeStatus = $status;

        $this->status = $changeStatus; 

        return $this->status;
    }
    //DATE
    public function setDateTime($dateTime = null) {

        $new_date = (is_null($dateTime)) ? date() : $dateTime ;

        $this->dateTime = $new_date;

        return $this->dateTime;
    }
    public function getDateTime() {

        return $this->dateTime;

    }
}