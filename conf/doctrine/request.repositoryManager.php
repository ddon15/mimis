<?php
include_once '../../Repository/RequestRepository.php';

$requestRepository = new RequestRepository();

//Getting request data
$request = (isset($_GET['requestData']) && !is_null($_GET['requestData'])) ? $_GET['requestData'] : '' ;

$sendOTReq = $requestRepository->sendOvertimeRequest($request);
$sendLeaveReq = $requestRepository->sendLeaveRequest($request);
var_dump($sendOTReq);exit;