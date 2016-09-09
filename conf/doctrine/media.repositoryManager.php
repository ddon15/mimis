<?php
include_once '../../Repository/MediaRepository.php';

$repository = new MediaRepository();
//Getting request data
$request = (isset($_GET['mediaData']) && !is_null($_GET['mediaData'])) ? $_GET['mediaData'] : '' ;

$repository->setName($request['name']);
$repository->setSize($request['size']);
$repository->setType($request['type']);
$repository->setId($request['user_id']);
$repository->setLastModifiedToken($request['lastModifiedToken']);

$upload = $repository->upload();

$returnUploadResponse = array('media_upload' => $upload);

echo json_encode(array($returnUploadResponse));