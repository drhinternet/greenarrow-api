<?php

define('GAS_BASE_URL', 'http://localhost:3000/api');
define('GAS_API_KEY', '1:c9b20e681af084e1830b09933c6c851295ec0a75');

function greenarrow_studio_create_subscriber($params) {
  // Gather parameters needed to communicate with GA Studio.
  $listID   = $params['mailing_list_id'];
  $url      = GAS_BASE_URL.'/v2/mailing_lists/'.$listID.'/subscribers';
  $ch       = curl_init($url);
  $campaign = array('subscriber' => $params);
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
    $return_value = "Error: unknown response from GAS Station: $response_raw";
  }

  return $return_value;
}

$params = array(
  'mailing_list_id' => 1,
  'email'           => 'subscriber-112@example.com',
  'status'          => 'active',
  'subscribe_time'  => '2013-03-27T10:14:13-05:00',
  'subscribe_ip'    => '10.0.81.8',
  'custom_fields' => array(
    'Name' => 'Bob Example'
  )
);

$result = greenarrow_studio_create_subscriber($params);
echo $result . "\n";
