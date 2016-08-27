<?php
include_once '../../Repository/RequestRepository.php';

$requestRepository = new RequestRepository();

//Getting request data
$request = (isset($_GET['requestData']) && !is_null($_GET['requestData'])) ? $_GET['requestData'] : '' ;

$sendOTReq = $requestRepository->sendOvertimeRequest($request);
$returnOTResponse = array('request_ot' => $sendOTReq);

$sendLeaveReq = $requestRepository->sendLeaveRequest($request);
$returnLeaveResponse = array('request_leave' => $sendLeaveReq);

$approvedReq = $requestRepository->approvedRequest($request);
$returnApprovedReq = array('approved_request' => $approvedReq);

echo json_encode(array($returnOTResponse, $returnLeaveResponse, $returnApprovedReq));