<?php
include_once '../../Repository/UserRepository.php';

$userRepository = new UserRepository();

//Getting request data
$request = (isset($_GET['userData']) && !is_null($_GET['userData'])) ? $_GET['userData'] : '' ;

$check = $userRepository->authorizedAccountToRegister($request);
$returnCheckAdminPassword = array('user_check_adminPassword' => $check);
 
$auth = $userRepository->authenticationProcess($request);
$returnAuthenticationProcess = array('user_auth_process' => $auth);

$creatingUser = $userRepository->createNewUser($request);
$returnCreatingUser = array('user_creating_new' => $creatingUser);

//Note! Wala pani mabutangi ug logs
$removeUser = $userRepository->removeUserById($request);
$returnRemovingUserById = array('user_removeBy_Id' => $removeUser);

$verifyAccount = $userRepository->verifyUserAccount($request);
$returnVerificationAccount = array('user_verify_account' => $verifyAccount);

$accountSettingEdit = $userRepository->updateAccountInfo($request);
$returnAccountSettingEdit = array('user_accountsetting_update' => $accountSettingEdit);
// //Count Features
echo json_encode(array($returnCheckAdminPassword,$returnAuthenticationProcess,$returnCreatingUser, $returnRemovingUserById, $returnVerificationAccount, $returnAccountSettingEdit));