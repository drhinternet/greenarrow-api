<?php

define('GAS_BASE_URL', 'http://localhost:3000/ga/api');
define('GAS_API_KEY', '1:c0f1f6bcba3dcde6a82c486e9e026b1638a853df');

function greenarrow_studio_get_object_id($endpoint, $name_field, $name_value) {
  // Gather parameters needed to communicate with GA Studio.
  $url      = GAS_BASE_URL . "/v2/" . $endpoint;
  $ch       = curl_init($url);

  // Set up cURL to communicate this message.
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, GAS_API_KEY);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  // Execute the command, retrieve HTTP errors.
  $response_raw = curl_exec($ch);
  $error_test   = curl_error($ch);
  $err          = curl_errno($ch);

  // Don't leave the connection hanging.
  curl_close($ch);

  // First, check if there was an HTTP error.
  if ($err != 0) {
    throw new Exception("cURL - $err $error_test");
  }

  // Decode Studio's response JSON.
  $result = json_decode($response_raw, true);

  // Return an appropriate response.
  if ($result["success"]) {
    foreach ( $result["data"] as $obj ) {
      if ( $obj[$name_field] == $name_value ) {
        return $obj["id"];
      }
    }
    throw new Exception("Error, cannot find $endpoint $name_field: $name_value");
  } else {
    throw new Exception("Error, returned $endpoint $name_field: " . $result["error_message"]);
  }
}

function greenarrow_studio_create_campaign($params) {
  // Gather parameters needed to communicate with GA Studio.
  $listID   = $params['mailing_list_id'];
  $url      = GAS_BASE_URL.'/v2/mailing_lists/'.$listID.'/campaigns';
  $ch       = curl_init($url);
  $campaign = array('campaign' => $params);
  $json     = json_encode($campaign);

  // Set up cURL to communicate this message.
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($ch, CURLOPT_USERPWD, GAS_API_KEY);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json),
  ));

  // Execute the command, retrieve HTTP errors.
  $response_raw = curl_exec($ch);
  $error_test   = curl_error($ch);
  $err          = curl_errno($ch);

  // Don't leave the connection hanging.
  curl_close($ch);

  // First, check if there was an HTTP error.
  if ($err != 0) {
    $rv = "ERROR: cURL - $err $error_test\n";
    return $rv;
  }

  // Decode Studio's response JSON.
  $result = json_decode($response_raw);

  // Return an appropriate response.
  if (isset($result->success)) {
    if ($result->success == false) {
      $return_value = "Error:";

      if (isset($result->error_message)) {
        $return_value .= " " . $result->error_message;
      }
    } else if ($result->success == true) {
      $return_value = "OK";
    } else {
      $return_value = "Error: unknown status";
    }
  } else {
    $return_value = "Error: unknown response from GAS Station";
  }

  return $return_value;
}

$params = array(
  'name'            => 'test api campaign 1 - remote list - ' . rand(),
  'mailing_list_id' => 3,

  'segmentation_criteria_remote_sql' => "( SELECT 'example-query@example.com' AS email ) UNION ( SELECT 'user-2@example.com' AS email )",
  # Alternate option:
  # 'segmentation_criteria_remote_id' => greenarrow_studio_get_object_id('segmentation_criterias', 'name', 'My Stored Segment'),

  'contents' => array(
    array( "name" => "Content AAA", "format" => "text", "subject" => "Daily Update 111", "text" => "Hello, world!\nYou are %%subscribers_email_address%%.\n" ),
    array( "name" => "Content BBB", "format" => "both", "subject" => "Daily Update 222", "html" => "HELLO WORLD<BR>You are %%subscribers_email_address%%", "text" => "Hello, world!\nYou are %%subscribers_email_address%%.\n" ),
  ),

  'dispatch_attributes' => array(
    'speed' => 0,
    'from_email' => 'user@example.com',
    'from_name' => 'Example Campaign User',
    'bounce_email_id' => greenarrow_studio_get_object_id('bounce_emails', 'email', 'return@example.com'),
    'url_domain_id' => greenarrow_studio_get_object_id('url_domains', 'domain', 'example.com'),
    'virtual_mta_id' => greenarrow_studio_get_object_id('virtual_mtas', 'name', 'System Default Route'),
    'begins_at' => '2015-06-29 3:11PM',
  ),
);

$result = greenarrow_studio_create_campaign($params);
echo $result . "\n";
