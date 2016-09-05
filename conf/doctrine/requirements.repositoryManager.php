<?php
include_once '../../Repository/RequirementsRepository.php';

$repository = new RequirementsRepository();

//Getting request data
$request = (isset($_GET['requirementsData']) && !is_null($_GET['requirementsData'])) ? $_GET['requirementsData'] : '' ;

$update = $repository->updateRequirements($request);
$returnUpdateResponse = array('update' => $update);

echo json_encode(array($returnUpdateResponse));