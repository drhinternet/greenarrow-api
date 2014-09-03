<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [Bounce Emails](#bounce-emails)
  - [Get a list of bounce emails](#get-a-list-of-bounce-emails)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Bounce Emails


### Get a list of bounce emails

Get a list of the basic details of all bounce emails available to user's organization.

#### URL

    GET /ga/api/v2/bounce_emails

#### Request Parameters

This API method does not require any additional parameters.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key      | Meaning                                  | Example            | Type   | 
| -------- | ---------------------------------------- | ------------------ | ------ |
| id       | The id of the bounce email               | "1@1"              | String | 
| username | The name of the user of the bounce email | "test"             | String | 
| domain   | The domain                               | "example.com"      | String | 
| email    | The email                                | "test@example.com" | String | 

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/bounce_emails HTTP/1.1
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
          "domain" : "test",
          "id" : "1@1",
          "username" : "test",
          "email" : "test@test"
        }
      ],
      "error_code" : null,
      "success" : true
    }
