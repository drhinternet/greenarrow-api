<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Introduction](#introduction)
- [ Formatting](#formatting)
  - [ JSON Formatting](#json-formatting)
  - [Return Values](#return-values)
  - [Error Response](#error-response)
  - [Dates and Times](#dates-and-times)
- [ Authentication](#authentication)
  - [ Organization ID](#organization-id)
  - [API Keys](#api-keys)
  - [Authorization Header](#authorization-header)
- [Subscribers](#subscribers)
  - [Get subscriber details](#get-subscriber-details)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)
  - [Create a new subscriber](#create-a-new-subscriber)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters-1)
    - [Request Payload](#request-payload)
    - [Example](#example)
  - [Update an existing subscriber](#update-an-existing-subscriber)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-2)
    - [Request Payload](#request-payload-1)
    - [Response](#response-1)
    - [Example](#example-1)
- [Mailing Lists](#mailing-lists)
  - [Get list of mailing lists](#get-list-of-mailing-lists)
    - [URL](#url-3)
    - [Request Parameters](#request-parameters-3)
    - [Response](#response-2)
    - [Example Request](#example-request-1)
  - [Create a new mailing list](#create-a-new-mailing-list)
    - [URL](#url-4)
    - [Request Parameters](#request-parameters-4)
    - [Request Payload](#request-payload-2)
    - [Response](#response-3)
    - [Example](#example-2)
  - [Update an existing mailing list](#update-an-existing-mailing-list)
    - [URL](#url-5)
    - [Request Parameters](#request-parameters-5)
    - [Request Payload](#request-payload-3)
    - [Response](#response-4)
    - [Example](#example-3)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Introduction

This is the documentation for the GreenArrow Studio 4 API. If you have additional questions about the API, or feel that you've encountered a bug, please don't hesitate to contact us at [our support address](https://drhinternet.zendesk.com/anonymous_requests/new).

Interactions with this API are accomplished over HTTP. On POST and PUT requests, JSON is expected as the body of the request. All API calls reply with JSON.

## Formatting

### JSON Formatting

The JSON included as examples in this document has been nicely formatted for viewing. Neither the JSON expected as input into the API nor the JSON returned by it will be formatted this way.

### Return Values

All API requests will return a JSON hash with the following keys:

Key | Meaning | Example | Type
----|---------|---------|-----
success | The API call was successful or not. | true or false | Boolean
data | The object returned by the particular API call, as defined in each section of this document. This will be null if the call failed. | ... | Array or Hash
error\_code | A simple error code to identify what went wrong. This will be null if the call was successful. | "not\_authorized" | String
error\_message | A more descriptive message of what went wrong. This will be null if the call was successful. | please specify a valid auth\_id or auth\_key | String

### Error Response

Here's an example of an error message returned by this API.

```json
{
    "data": null, 
    "error_code": "validation_failed", 
    "error_message": "name cannot be blank", 
    "success": false
}
```

### Dates and Times

* Times are passed to the API in ISO 8601 date/time format:
```
YYYY-MM-DDThh:mm:ss-ZZ:ZZ
2013-03-27T10:41:15-05:00
```

* A date (with no time) can be passed to the API, and is returned, in the following format:
```
YYYY-MM-DD
2010-03-30
```

* Times are returned by the API as both an integer number of seconds since the UNIX epoch, and in [ISO 8601 date/time format](http://www.w3.org/TR/NOTE-datetime).
* All fields that are interpreted as a time also have a corresponding \_epoch field with the integer number of seconds since the UNIX epoch. For example, on a subscriber the "created\_at" field might have the value **"2013-03-27T10:41:15-05:00"**, there will also be a field "created\_at\_epoch" which contains the integer value **1364398875**.
* The timezone of all times is the organization timezone.


## Authentication

Every request to the GreenArrow Studio 4 API must be authenticated. This is done via the "Authorzation" HTTP header in the request. For this, you need your "Organization ID" and "API Key", as detailed below. See the "Authorization Header" section below for details on building the header.


### Organization ID

You will need your organization's ID to authenticate with the GreenArrow Studio 4 API. This ID can be found on the organization page in the "Organization Details" section. To load that page for your organization, hover over "Admin" in the top navigation menu, then select "My Organization":

[***Convert to image***](https://wiki.drh.net/confluence/download/attachments/5244403/Screen+Shot+2013-03-27+at+9.30.58+AM.jpg?version=1&modificationDate=1384788190000)

### API Keys

Organization administrators may create API keys from their organization's page. To find that page, hover over "Admin" in the top navigation menu, then select "My Organization". See the "API Keys" section on that screen. The "Key" column contains the value needed for authentication.

[***Convert to image***](https://wiki.drh.net/confluence/download/attachments/5244403/Screen+Shot+2013-03-27+at+9.26.49+AM.jpg?version=1&modificationDate=1384788190000)

### Authorization Header

The **Authorization** header must be included in every call to the GreenArrow Studio 4 API.

```
Authorization: Basic <Data>
```
The **\<Data\>** portion of this header should be a Base64 encoded string containing your organization ID, followed by a colon, followed by your API key. From the example screenshots above, using the API key for "Bob's Script", you would Base64 encode the string "1:5e96465c883f3309f0105a2e1076632b687e61d2". This results in the string "MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy". Thus, for that example, our header would be the following.

```
Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
```

## Subscribers
### Get subscriber details

Get the details for up to 100 subscribers at a time.

#### URL
```
GET /ga/api/mailing_lists/:mailing_list_id/subscribers/:subscriber_ids
```
#### Request Parameters
Key|Meaning|Example
---|-------|-------
mailing\_list\_id|The id of the mailing list the subscribers are on. This can be found on the mailing list's page under the "Admin" section|456
subscriber\_ids|A comma-separated list of up to 100 subscriber ids|1,9182,9981

#### Response
The response will be a JSON array where each element contains the following keys.

Key|Meaning|Example|Type
---|-------|-------|----
id|The id of the subscriber|123|Integer
mailing\_list_id|The id of the mailing list|456|Integer
email|The subscriber's email address|bob@example.com|String
created\_at|The date the subscriber record was added to GreenArrow Studio 4.|"2013-03-27T10:14:13-05:00"|String
confirmed|The subscriber's confirmed status. This column is only presented for mailing lists which use the Confirmed field.|true or false|Boolean
email\_format|The subscriber's email format. This column is only presented for mailing lists which use the Format field.|"plaintext" or "html"|String
status|The status of the subscriber.|"active", "bounced", "unsubscribed", "scomp" or "deactivated"|String
subscribe\_time|The time the subscriber subscribed.|"2013-03-27T10:14:13-05:00"|String
subscribe_ip|The ip the subscriber subscribed from. This can be null if it is unknown.|"192.168.0.123"|String
custom\_fields|An array of entries matching the definition found below.|...|Hash

Each entry in the custom\_fields hash are keyed for the name of the custom field, and the value being a hash containing the following keys.

 Key | Meaning | Example | Type | Present for Custom Field Types 
 ----|---------|---------|------|-------------------------------
 name | The name of the custom field which this entry represents. | "First Name" | String | All 
 type | The type of the custom field. | "text", "text\_multiline", "number", "date", "select\_single\_dropdown", "select\_single\_radio", "select\_multiple\_checkboxes", "boolean" | String | All 
 value | The string value of the custom field. | "James McGuy" | String | text, text\_multiline, select\_single\_dropdown, select\_single\_radio 
 value | The integer value of the custom field. | 9182 | Integer | number 
 value | The boolean value of the custom field. | true or false | Boolean | boolean 
 value | The date value of the custom field. | "2000-02-17" | String | date 
 value | The list of values selected for the custom field. | ... | Array of strings | select\_multiple\_checkboxes 

#### Example Request
```json
> GET /ga/api/mailing_lists/1/subscribers/1,2 HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
> 
< HTTP/1.1 200 OK
< Content-Type: text/html
< X-UA-Compatible: IE=Edge
< ETag: "68a7c81054bbf60f3b6ee5c481e5245b"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=ef4d24b30d8700118859eb7a8d0d291c; path=/; HttpOnly
< X-Request-Id: 3a5478ebf7c8d5bc047c8d989403c863
< X-Runtime: 0.028557
< Connection: close
< 
{
    "data": [
        {
            "created_at": "2013-01-31T14:25:48-06:00", 
            "custom_fields": {
                "First Name": {
                    "name": "First Name", 
                    "type": "text", 
                    "value": "Bob"
                }, 
                "boolean test": {
                    "name": "boolean test", 
                    "type": "boolean", 
                    "value": false
                }, 
                "boolean test yes by default": {
                    "name": "boolean test yes by default", 
                    "type": "boolean", 
                    "value": true
                }, 
                "radio test": {
                    "name": "radio test", 
                    "type": "select_single_radio", 
                    "value": "bar"
                }
            }, 
            "email": "bob@example.com", 
            "id": 1, 
            "mailing_list_id": 1, 
            "status": "active", 
            "subscribe_ip": null, 
            "subscribe_time": "2013-01-31T14:25:48-06:00"
        }, 
        {
            "created_at": "2013-01-31T14:25:48-06:00", 
            "custom_fields": {}, 
            "email": "joe@example.net", 
            "id": 2, 
            "mailing_list_id": 1, 
            "status": "active", 
            "subscribe_ip": null, 
            "subscribe_time": "2013-01-31T14:25:48-06:00"
        }
    ], 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```


### Create a new subscriber

#### URL
```
POST /ga/api/mailing_lists/:mailing_list_id/subscribers
```
#### Request Parameters
Key | Meaning | Example 
----|---------|----------
mailing\_list\_id | The mailing list to onto which to add the subscriber | 99182 


#### Request Payload
The POST request should have a JSON document in its payload with all of the following keys.

Key | Meaning | Example | Type 
----|---------|---------|------
email | The subscriber's email address | bob@example.com | String 
confirmed | The subscriber's confirmed status. This column is only needed for mailing lists which use the Confirmed field. | true or false | Boolean 
email\_format | The subscriber's email format. This column is only needed for mailing lists which use the Format field. | "plaintext" or "html" | String 
status | The status of the subscriber. | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String 
subscribe\_time | The time the subscriber subscribed. | "2013-03-27T10:14:13-05:00" | String 
subscribe\_ip | The ip the subscriber subscribed from. This can be null if it is unknown. | "192.168.0.123" | String 
custom\_fields | An array of entries matching the definition found below. | ... | Hash 


Each entry in the specified **custom\_fields** hash must have the following keys. The keys for the hash is the name of the custom field.

Key | Meaning | Example | Type | Present for Custom Field Types 
----|---------|---------|------|--------------------------------
name | The name of the custom field which this entry represents. | "First Name" | String | All 
value | The string value of the custom field. | "James McGuy" | String | text, text\_multiline, select\_single\_dropdown, select\_single\_radio 
value | The integer value of the custom field. | 9182 | Integer | number 
value | The boolean value of the custom field. | true or false | Boolean | boolean 
value | The date value of the custom field. | "2000-02-17" | String | date 
value | The list of values selected for the custom field. | ... | Array of strings | select\_multiple\_checkboxes 

Response
A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example
```json
> POST /ga/api/mailing_lists/4/subscribers HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
> Content-Length: 430
> Content-Type: application/json
> 
{
    "custom_fields": {
        "First Name": "Ted",
        "boolean test": false,
        "boolean test yes by default": true,
        "radio test": "bar"
    },
    "email": "ted@example.com",
    "mailing_list_id": 4,
    "status": "active",
    "subscribe_ip": null,
    "subscribe_time": "2013-02-01T08:22:42-06:00"
}
< HTTP/1.1 200 OK
< Content-Type: text/html
< X-UA-Compatible: IE=Edge
< ETag: "e5794f737673a63d76a5741a66332d22"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=d27440cb5fba4c7a579920acd8986636; path=/; HttpOnly
< X-Request-Id: 293ca6db3ed520f5be284686cfc7b7ed
< X-Runtime: 0.046717
< Connection: close
< 
{
    "data": {
        "created_at": "2013-03-29T13:27:50-05:00", 
        "custom_fields": {
            "First Name": {
                "name": "First Name", 
                "type": "text", 
                "value": "Ted"
            }, 
            "boolean test": {
                "name": "boolean test", 
                "type": "boolean", 
                "value": false
            }, 
            "boolean test yes by default": {
                "name": "boolean test yes by default", 
                "type": "boolean", 
                "value": true
            }, 
            "radio test": {
                "name": "radio test", 
                "type": "select_single_radio", 
                "value": "bar"
            }
        }, 
        "email": "ted@example.com", 
        "id": 3386566, 
        "mailing_list_id": 4, 
        "status": "active", 
        "subscribe_ip": null, 
        "subscribe_time": "2013-02-01T08:22:42-06:00"
    }, 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```

### Update an existing subscriber

#### URL
```
PUT /ga/api/mailing_lists/:mailing_list_id/subscribers/:subscriber_id
```

#### Request Parameters
Key | Meaning | Example
----|---------|---------
mailing\_list\_id | The mailing list to onto which to add the subscriber | 99182
subscriber\_id | The id of the subscriber to update | 17293 or bob@example.com

#### Request Payload
The PUT request should have a JSON document in its payload with all of the following keys.

Key | Meaning | Example | Type 
----|---------|---------|------
email | The subscriber's email address | bob@example.com | String 
confirmed | The subscriber's confirmed status. This column is only needed for mailing lists which use the Confirmed field. | true or false | Boolean 
email\_format | The subscriber's email format. This column is only needed for mailing lists which use the Format field. | "plaintext" or "html" | String 
status | The status of the subscriber. | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String 
subscribe\_time | The time the subscriber subscribed. | "2013-03-27T10:14:13-05:00" | String 
subscribe\_ip | The ip the subscriber subscribed from. This can be null if it is unknown. | "192.168.0.123" | String 
custom\_fields | An array of entries matching the definition found below. | ... | Hash 

Each entry in the specified **custom\_fields** hash must have the following keys. The keys for the hash is the name of the custom field.

Key | Meaning | Example | Type | Present for Custom Field Types 
----|---------|---------|------|------
name | The name of the custom field which this entry represents. | "First Name" | String | All 
value | The string value of the custom field. | "James McGuy" | String | text, text\_multiline, select\_single\_dropdown, select\_single\_radio 
value | The integer value of the custom field. | 9182 | Integer | number 
value | The boolean value of the custom field. | true or false | Boolean | boolean 
value | The date value of the custom field. | "2000-02-17" | String | date 
value | The list of values selected for the custom field. | ... | Array of strings | select\_multiple\_checkboxes 


#### Response
A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example
```json
> PUT /ga/api/mailing_lists/4/subscribers/10012 HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
> content-type: application/json
> Content-Length: 343
> 
{
    "custom_fields": {
        "First Name": "bobbie",
        "boolean test": false,
        "boolean test yes by default": true,
        "radio test": "bar"
    },
    "email": "renamed@example.com",
    "status": "active",
    "subscribe_ip": null,
    "subscribe_time": "2013-02-01T08:22:42-06:00"
}
< HTTP/1.1 200 OK
< Content-Type: text/html
< X-UA-Compatible: IE=Edge
< ETag: "2b2badce6c43e80e30a9d85aea2c9dff"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=68685553f5c70ce29e9b03929e5201b0; path=/; HttpOnly
< X-Request-Id: bdce4f074d21a3a3c8ccfca067852cdd
< X-Runtime: 0.024645
< Connection: close
< 
* Closing connection #0
{
    "data": {
        "created_at": "2013-02-01T08:22:42-06:00", 
        "custom_fields": {
            "First Name": {
                "name": "First Name", 
                "type": "text", 
                "value": "bobbie"
            }, 
            "boolean test": {
                "name": "boolean test", 
                "type": "boolean", 
                "value": false
            }, 
            "boolean test yes by default": {
                "name": "boolean test yes by default", 
                "type": "boolean", 
                "value": true
            }, 
            "radio test": {
                "name": "radio test", 
                "type": "select_single_radio", 
                "value": "bar"
            }
        }, 
        "email": "renamed@example.com", 
        "id": 10012, 
        "mailing_list_id": 4, 
        "status": "active", 
        "subscribe_ip": null, 
        "subscribe_time": "2013-02-01T08:22:42-06:00"
    }, 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```

## Mailing Lists
### Get list of mailing lists

Get a list of the basic details of all mailing lists in GreenArrow Studio 4.

#### URL
```
GET /ga/api/mailing_lists
```
#### Request Parameters
This API method does not require any additional parameters.

#### Response
The response will be a JSON array where each element contains the following keys.

Key | Meaning | Example | Type 
----|---------|---------|-------
id | The id of the mailing list | 123 | Integer 
name | The name of the mailing list | "My Mailing List" | String 
d\_from\_email | The default from email for campaigns from this mailing list | "bob@example.com" | String 
d\_from\_name | The default from name for campaigns from this mailing list | "Bob Example" | String 
d\_reply\_to | The default reply-to email address for campaigns from this mailing list | "replies@example.com" | String 
d\_virtual\_mta | The name of the default virtual mta for campaigns from this mailing list | "smtp1-1" | String 
d\_url\_domain | The default url domain for campaigns from this mailing list | "www.urldomain.com" | String 
d\_speed | The default speed for campaigns from this mailing list | 75 | Integer 
d\_sender\_email | The default sender email address for campaigns from this mailing list | "sender@example.com" | String 
d\_bounce\_email | The default bounce email address for campaigns from this mailing list. | "bounce@example.com" | String 
has\_format | True if this mailing list uses the email\_format field. | true or false | Boolean 
has\_confirmed | True if this mailing list uses the confirmed field. | true or false | Boolean 

#### Example Request
Note that the JSON response will not be "pretty formatted" as it is below.

```json
> GET /ga/api/mailing_lists HTTP/1.1
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
    "data": [
        {
            "d_bounce_email": null, 
            "d_bounce_email_id": "", 
            "d_from_email": "joe@example.com", 
            "d_from_name": "Joe Example", 
            "d_reply_to": "", 
            "d_sender_email": "", 
            "d_speed": 0, 
            "d_url_domain": "staging.example.com", 
            "d_url_domain_id": 1, 
            "d_virtual_mta": "System Default Route", 
            "d_virtual_mta_id": 0, 
            "has_confirmed": false, 
            "has_format": false, 
            "id": 2, 
            "name": "Daily News Letter"
        }, 
        {
            "d_bounce_email": "return@staging.example.com", 
            "d_bounce_email_id": "4@1", 
            "d_from_email": "bob@staging.example.com", 
            "d_from_name": "Bob Staging", 
            "d_reply_to": "", 
            "d_sender_email": "", 
            "d_speed": 0, 
            "d_url_domain": "staging.example.com", 
            "d_url_domain_id": 1, 
            "d_virtual_mta": "System Default Route", 
            "d_virtual_mta_id": 0, 
            "has_confirmed": false, 
            "has_format": false, 
            "id": 12, 
            "name": "Weather Forecasts"
        }
    ], 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```

### Create a new mailing list

#### URL
```
POST /ga/api/mailing_lists
```
#### Request Parameters
This API method does not require any additional parameters.

#### Request Payload
The POST request should have a JSON document in its payload with all of the following keys.

Key | Meaning | Example | Type 
----|---------|---------|-------
name | The name of the mailing list | "My Mailing List" | String 
d\_from\_email | The default from email for campaigns from this mailing list | "bob@example.com" | String 
d\_from\_name | The default from name for campaigns from this mailing list | "Bob Example" | String 
d\_reply\_to | The default reply-to email address for campaigns from this mailing list | "replies@example.com" | String 
d\_virtual\_mta | The name of the default virtual mta for campaigns from this mailing list | "smtp1-1" | String 
d\_url\_domain | The default url domain for campaigns from this mailing list | "www.urldomain.com" | String 
d\_speed | The default speed for campaigns from this mailing list | 75 | Integer 
d\_sender\_email | The default sender email address for campaigns from this mailing list | "sender@example.com" | String 
d\_bounce\_email | The default bounce email address for campaigns from this mailing list. | "bounce@example.com" | String 
has\_format | True if this mailing list uses the email\_format field. | true or false | Boolean 
has\_confirmed | True if this mailing list uses the confirmed field. | true or false | Boolean 

#### Response
A successful response will return the mailing list record using the format described in the "Get list of mailing lists" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example
```json
> POST /ga/api/mailing_lists HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
> content-type: application/json
> Content-Length: 309
> 
{
  "d_bounce_email": null,
  "d_from_email": "joe@example.com",
  "d_from_name": "Joe Example",
  "d_reply_to": "",
  "d_sender_email": "",
  "d_speed": 0,
  "d_url_domain": "staging.example.com",
  "d_virtual_mta": "System Default Route",
  "has_confirmed": false,
  "has_format": false,
  "name": "Daily News Letter"
}
< HTTP/1.1 200 OK
< Cache-Control: no-cache, no-store, max-age=0, must-revalidate
< Pragma: no-cache
< Expires: Fri, 01 Jan 1990 00:00:00 GMT
< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< Set-Cookie: _session_id=397c15499b2ee6e225accb1f75745129; path=/; HttpOnly
< X-Request-Id: 6944382a9a981c44a26f5aa6b318efb8
< X-Runtime: 0.027678
< Connection: close
< 
{
    "data": {
        "d_bounce_email": null, 
        "d_bounce_email_id": null, 
        "d_from_email": "joe@example.com", 
        "d_from_name": "Joe Example", 
        "d_reply_to": "", 
        "d_sender_email": "", 
        "d_speed": 0, 
        "d_url_domain": "staging.example.com", 
        "d_url_domain_id": 2, 
        "d_virtual_mta": "System Default Route", 
        "d_virtual_mta_id": 0, 
        "has_confirmed": false, 
        "has_format": false, 
        "id": 22, 
        "name": "Daily News Letter"
    }, 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```

### Update an existing mailing list

#### URL
```
PUT /ga/api/mailing_lists/:mailing_list_id
```

#### Request Parameters
Key | Meaning | Example 
----|---------|--------
mailing\_list\_id | The id of the mailing list to update | 17293 or bob@example.com 

#### Request Payload

The POST request should have a JSON document in its payload with all of the following keys.

Key | Meaning | Example | Type 
----|---------|---------|------
name | The name of the mailing list | "My Mailing List" | String 
d\_from\_email | The default from email for campaigns from this mailing list | "bob@example.com" | String 
d\_from\_name | The default from name for campaigns from this mailing list | "Bob Example" | String 
d\_reply\_to | The default reply-to email address for campaigns from this mailing list | "replies@example.com" | String 
d\_virtual\_mta | The name of the default virtual mta for campaigns from this mailing list | "smtp1-1" | String 
d\_url\_domain | The default url domain for campaigns from this mailing list | "www.urldomain.com" | String 
d\_speed | The default speed for campaigns from this mailing list | 75 | Integer 
d\_sender\_email | The default sender email address for campaigns from this mailing list | "sender@example.com" | String 
d\_bounce\_email | The default bounce email address for campaigns from this mailing list. | "bounce@example.com" | String 
has\_format | True if this mailing list uses the email\_format field. | true or false | Boolean 
has\_confirmed | True if this mailing list uses the confirmed field. | true or false | Boolean 


#### Response

A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

```json
> PUT /ga/api/mailing_lists/22 HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
> content-type: application/json
> Content-Length: 309
> 
{
  "d_bounce_email": null,
  "d_from_email": "joe@example.com",
  "d_from_name": "Joe Example",
  "d_reply_to": "",
  "d_sender_email": "",
  "d_speed": 0,
  "d_url_domain": "staging.example.com",
  "d_virtual_mta": "System Default Route",
  "has_confirmed": false,
  "has_format": false,
  "name": "Renamed Daily News Letter"
}
< HTTP/1.1 200 OK
< Cache-Control: no-cache, no-store, max-age=0, must-revalidate
< Pragma: no-cache
< Expires: Fri, 01 Jan 1990 00:00:00 GMT
< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< Set-Cookie: _session_id=397c15499b2ee6e225accb1f75745129; path=/; HttpOnly
< X-Request-Id: 6944382a9a981c44a26f5aa6b318efb8
< X-Runtime: 0.027678
< Connection: close
< 
{
    "data": {
        "d_bounce_email": null, 
        "d_bounce_email_id": null, 
        "d_from_email": "joe@example.com", 
        "d_from_name": "Joe Example", 
        "d_reply_to": "", 
        "d_sender_email": "", 
        "d_speed": 0, 
        "d_url_domain": "staging.example.com", 
        "d_url_domain_id": 2, 
        "d_virtual_mta": "System Default Route", 
        "d_virtual_mta_id": 0, 
        "has_confirmed": false, 
        "has_format": false, 
        "id": 22, 
        "name": "Renamed Daily News Letter"
    }, 
    "error_code": null, 
    "error_message": null, 
    "success": true
}
```
