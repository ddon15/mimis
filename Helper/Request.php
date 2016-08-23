<?php

class Request{

	const OT_NEWLY_SENT = 3;
	const OT_DISAPPROVED = 0;
	const OT_APPROVED = 1;

    public $table_names;

    public $startTime;
    public $endTime;

    public function __construct() {
        $this->table_names = array(
                'overtime' => 'overtime',
                'leave' => 'work_leave',
                'leave_type' => 'leave_type',
                'attendance' => 'attendance'
            );

        return $this->table_names;
    }
    public function dateDataTransformer($date){
    		// var_dump($date);exit;
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
}