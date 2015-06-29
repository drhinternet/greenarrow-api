<?php

define('GAS_BASE_URL', 'http://localhost:3000/ga/api');
define('GAS_API_KEY', '1:2768cac8a813c4419f167749e58219bfe4bca2d7');

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
  'name'                           => 'test api campaign 2',
  'mailing_list_id'                => 1,
  'email_format'                   => 'html',
  'active_html_editor'             => "ckeditor",
  'segmentation_criteria_id' => null,
  'campaign_contents_attributes'   => array(
    array(
      'name' => 'My A Content',
      'content_attributes' => array (
        'format'  => 'html',
        'subject' => 'my subject',
        'html'    => 'here is my html content',
        'text'    => '',
      ),
    ),
    array(
      'name' => 'My B Content',
      'content_attributes' => array (
        'format'  => 'html',
        'subject' => 'bbb my subject',
        'html'    => 'bbb here is my html content',
        'text'    => '',
      ),
    ),
  ),
);

$result = greenarrow_studio_create_campaign($params);
echo $result . "\n";
