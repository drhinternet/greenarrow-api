<?php

// API Configuration
$api_key = 'API_KEY_HERE_FROM_WEB_UI';
$api_url = 'http://example.com/ga/api';
 
// Subscriber data
$listID = 5;
$email = 'customer1@example.com';

 
// subscriberAdd.php - Example usage of the GreenArrow Studio
// API's subscriberAdd method.
 
// API request.
$request = array(
    'email'  => $email,
    'confirmed' => true,
    'email_format' => 'html',
    'status' => 'active',
    'subscribe_time' => date('c'),
    'subscribe_ip' => null,
);
 
$request_url = "$api_url/mailing_lists/$listID/subscribers";
 
print "\nRequesting\n$request_url\n";
 
$request_handle = curl_init($request_url);
curl_setopt($request_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($request_handle, CURLOPT_USERPWD, "1:$api_key");
curl_setopt($request_handle, CURLOPT_POST, true);
curl_setopt($request_handle, CURLOPT_POSTFIELDS, json_encode($request));
curl_setopt($request_handle, CURLOPT_RETURNTRANSFER, true);
$request_result = curl_exec($request_handle);
 
print "\nThe results are:\n";
print_r(json_decode($request_result));