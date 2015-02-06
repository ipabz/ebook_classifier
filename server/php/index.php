<?php
error_reporting(0);

$GLOBALS['uploadedfile'] = '';

$post_back = array();

$post_back['filename'] = @trim($_FILES['files']['name'][0]);
$post_back['class'] = @$_POST['corpus'];

require('UploadHandler.php');
$upload_handler = new UploadHandler();
$temp = (Object)($GLOBALS['uploadedfile'][0]);
$post_back['uploadedfile_name'] = ($temp->name);

$ch = curl_init();		
curl_setopt($ch, CURLOPT_URL, "http://localhost/ebook_classifier/training/handle_file_training");			
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);			
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_back);
curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com.ph');		
$return = curl_exec($ch);			
curl_close($ch);
