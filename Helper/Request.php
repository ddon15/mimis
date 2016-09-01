<?php

class Request{

	const REQUEST_NEWLY_SENT = 3;
	const REQUEST_DISAPPROVED = 0;
	const REQUEST_APPROVED = 1;

    public $table_names;

    public $startTime;
    public $endTime;

    public function __construct() {
        $this->table_names = array(
                'overtime'   => 'overtime',
                'leave'      => 'work_leave',
                'leave_type' => 'leave_type',
                'attendance' => 'attendance'
            );

        return $this->table_names;
    }
    public function dateDataTransformer($date){
    	$explodeData = explode("/",$date);
    	$dateComposer = $explodeData[2]."-".$explodeData[0]."-".$explodeData[1];

    	return $dateComposer;								
    }
    public function timeDataTransformer($time){

    	$explodeData = explode(" ",$time);
    	// var_dump($explodeData);exit;
    	$timeComposer = $explodeData[0].$explodeData[1].$explodeData[2].$explodeData[3].$explodeData[4];

    	return $timeComposer;
    }
    public function setTimeStart($startTime){
    	$this->startTime = $startTime;
    	return $this->startTime;
    }
    public function setTimeEnd($endTime){
    	$this->endTime = $endTime;
    	return $this->endTime;
    }
    public function calculateDifference($estimatedTime){
    	$s = explode(":", $this->startTime);
    	$e = explode(":", $this->endTime);

    	$diff = $this->endTime-$this->startTime;
    	var_dump($diff);
    	echo $estimatedTime;
    }
     public function getDateTime(){
        include_once 'User.php';

               $user = new User();
        return $user->getDateTime();
    }
}