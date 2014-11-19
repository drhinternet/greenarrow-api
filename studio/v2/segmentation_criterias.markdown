<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Segmentation Criterias](#segmentation-criterias)
  - [Get a list of segmentation criterias](#get-a-list-of-segmentation-criterias)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Segmentation Criterias

### Get a list of segmentation criterias

Get a list of the basic details of all segmentation criterias available to user's organization.

#### URL

    GET /ga/api/v2/segmentation_criterias

#### Request Parameters

This API method does not require any additional parameters.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key             | Meaning                                                          | Example           | Type    | 
| --------------- | ---------------------------------------------------------------- | ----------------- | ------- | 
| id              | The id of the Segmentation Criteria                              | 1                 | Integer | 
| name            | The name of the Segmentation Criteria                            | "Criteria #1"     | String  | 
| mailing_list_id | The id of the Mailing List that Segmentation Criteria belongs to | 1                 | Integer | 
| criteria_sql    | The resulting SQL of the Segmentation Criteria                   | "SELECT ..."      | String  | 
| criteria_json   | The set of rules of the Segmentation Criteria encoded as JSON    | `'\{"type"...\}'` | String  | 

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/segmentation_criterias HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    < HTTP/1.1 200 OK
    < Cache-Control: no-cache, no-store, max-age=0, must-revalidate
    < Pragma: no-cache
    < Expires: Fri, 01 Jan 1990 00:00:00 GMT
    < Content-Type: application/json; charset=utf-8
    < X-UA-Compatible: IE=Edge
    < Set-Cookie: _session_id=458055a23f26f844e74f8cd7300f6445; path=/; HttpOnly
    < X-Request-Id: f6e40d578ed1d9c418cca45e1b7fe532
    < X-Runtime: 0.025540
    < Connection: close
    <
    {
      "error_message" : null,
      "data" : [
        {
          "id" : 1,
          "created_at" : "2013-08-24T08:23:44Z",
          "criteria_sql" : "SELECT \"s_subscribers\".* FROM \"s_subscribers\" LEFT OUTER JOIN ( SELECT email FROM s_suppressed_addresses WHERE suppression_list_id IN (SELECT id FROM \"s_suppression_lists\" WHERE \"s_suppression_lists\".\"active\" = 't' AND (mailing_list_id = 1 OR (organization_id = 1 AND mailing_list_id IS NULL) OR global = true)) ) suppress_aa ON ( LOWER(s_subscribers.email) = LOWER(suppress_aa.email) ) LEFT OUTER JOIN ( SELECT email FROM s_suppressed_addresses WHERE suppression_list_id in (SELECT id FROM \"s_suppression_lists\" WHERE \"s_suppression_lists\".\"active\" = 't' AND (mailing_list_id = 1 OR (organization_id = 1 AND mailing_list_id IS NULL) OR global = true)) AND email LIKE '@%' ) suppress_bb ON ( LOWER(SUBSTR(s_subscribers.email, position('@' IN s_subscribers.email))) = LOWER(suppress_bb.email) ) WHERE ((s_subscribers.mailing_list_id = 1) AND ((s_subscribers.status = 'active'))) AND (status = 'active') AND (suppress_aa.email IS NULL AND suppress_bb.email IS NULL)",
          "criteria_json" : "{\"type\":\"all\",\"clauses\":[{\"type\":\"subscriber_status\",\"operator\":\"is\",\"value\":\"active\"}]}",
          "mailing_list_id" : 1,
          "updated_at" : "2013-08-24T08:23:44Z",
          "name" : null
        }
      ],
      "error_code" : null,
      "success" : true
    }
