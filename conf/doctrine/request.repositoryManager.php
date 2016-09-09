<?php
include_once '../../Repository/RequestRepository.php';

$requestRepository = new RequestRepository();

//Getting request data
$request = (isset($_GET['requestData']) && !is_null($_GET['requestData'])) ? $_GET['requestData'] : '' ;

$sendOTReqAdmin = $requestRepository->sendOvertimeRequestAdmin($request);
$returnOTAdminResponse = array('request_ot_admin' => $sendOTReqAdmin);

$sendOTReq = $requestRepository->sendOvertimeRequest($request);
$returnOTResponse = array('request_ot' => $sendOTReq);

$sendLeaveReq = $requestRepository->sendLeaveRequest($request);
$returnLeaveResponse = array('request_leave' => $sendLeaveReq);

$approvedReq = $requestRepository->approvedRequest($request);
$returnApprovedReq = array('approved_request' => $approvedReq);

$disapprovedReq = $requestRepository->disapprovedRequest($request);
$returnDisapprovedReq = array('disapproved_request' => $disapprovedReq);

$removeNotificationFromList = $requestRepository->removeNotificationFromList($request);
$returnRemoveNotificationFromList = array('remove_from_list' => $removeNotificationFromList);

echo json_encode(array($returnOTResponse, $returnLeaveResponse, $returnApprovedReq, $returnDisapprovedReq, $returnOTAdminResponse, $returnRemoveNotificationFromList));