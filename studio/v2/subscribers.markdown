<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Subscribers](#subscribers)
  - [Get subscriber details](#get-subscriber-details)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Notes](#notes)
    - [Response](#response)
    - [Example Request](#example-request)
  - [Create a new subscriber](#create-a-new-subscriber)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters-1)
    - [Request Payload](#request-payload)
    - [Response](#response-1)
    - [Example](#example)
  - [Update an existing subscriber](#update-an-existing-subscriber)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-2)
    - [Request Payload](#request-payload-1)
    - [Response](#response-2)
    - [Example](#example-1)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Subscribers

### Get subscriber details

Get the details for up to 100 subscribers at a time.

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/subscribers/:subscriber_ids_or_emails

#### Request Parameters

| Key                      | Meaning                                                                                                                   | Example                       |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------- | ----------------------------- |
| mailing_list_id          | The id of the mailing list the subscribers are on. This can be found on the mailing list's page under the "Admin" section | 456                           |
| subscriber_ids_or_emails | A comma-separated list of up to 100 subscriber ids or URI encoded email addresses                                         | 1,9182,bob%40example.com,9981 |

#### Notes

* The email addresses in the request should be URI encoded.

* If the request includes an email address used by multiple subscribers on the
  mailing list (as might be the case if the mailing list uses an alternate
  primary key), the API will return all subscribers with that email address.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key             | Meaning                                                                                                           | Example                                                       | Type    |
| --------------- | ----------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ------- |
| id              | The id of the subscriber                                                                                          | 123                                                           | Integer |
| mailing_list_id | The id of the mailing list                                                                                        | 456                                                           | Integer |
| email           | The subscriber's email address                                                                                    | bob@example.com                                               | String  |
| created_at      | The date the subscriber record was added to GreenArrow Studio 4.                                                  | "2013-03-27T10:14:13-05:00"                                   | String  |
| confirmed       | The subscriber's confirmed status. This column is only presented for mailing lists which use the Confirmed field. | true or false                                                 | Boolean |
| email_format    | The subscriber's email format. This column is only presented for mailing lists which use the Format field.        | "plaintext" or "html"                                         | String  |
| status          | The status of the subscriber.                                                                                     | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String  |
| subscribe_time  | The time the subscriber subscribed.                                                                               | "2013-03-27T10:14:13-05:00"                                   | String  |
| subscribe_ip    | The ip the subscriber subscribed from. This can be null if it is unknown.                                         | "192.168.0.123"                                               | String  |
| custom_fields   | An array of entries matching the definition found below.                                                          | ...                                                           | Hash    |

Each entry in the custom_fields hash are keyed for the name of the custom field, and the value being a hash containing the following keys.

| Key   | Meaning                                                   | Example                                                                                                                              | Type             | Present for Custom Field Types                                    |
| ----- | --------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------ | ---------------- | ----------------------------------------------------------------- |
| name  | The name of the custom field which this entry represents. | "First Name"                                                                                                                         | String           | All                                                               |
| type  | The type of the custom field.                             | "text", "text_multiline", "number", "date", "select_single_dropdown", "select_single_radio", "select_multiple_checkboxes", "boolean" | String           | All                                                               |
| value | The string value of the custom field.                     | "James McGuy"                                                                                                                        | String           | text, text_multiline, select_single_dropdown, select_single_radio |
| value | The integer value of the custom field.                    | 9182                                                                                                                                 | Integer          | number                                                            |
| value | The boolean value of the custom field.                    | true or false                                                                                                                        | Boolean          | boolean                                                           |
| value | The date value of the custom field.                       | "2000-02-17"                                                                                                                         | String           | date                                                              |
| value | The list of values selected for the custom field.         | ...                                                                                                                                  | Array of strings | select_multiple_checkboxes                                        |

#### Example Request

    > GET /ga/api/v2/mailing_lists/1/subscribers/1,2 HTTP/1.1
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


### Create a new subscriber

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/subscribers

#### Request Parameters

| Key             | Meaning                                              | Example |
| --------------- | ---------------------------------------------------- | ------- |
| mailing_list_id | The mailing list to onto which to add the subscriber | 99182   |

#### Request Payload

The POST request should have a JSON document in its payload with all of the following keys.

| Key                            | Meaning                                                                                                        | Example                                                       | Type    |
| ------------------------------ | -------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ------- |
| subscriber.email               | The subscriber's email address                                                                                 | bob@example.com                                               | String  |
| subscriber.confirmed           | The subscriber's confirmed status. This column is only needed for mailing lists which use the Confirmed field. | true or false                                                 | Boolean |
| subscriber.email_format        | The subscriber's email format. This column is only needed for mailing lists which use the Format field.        | "plaintext" or "html"                                         | String  |
| subscriber.status              | The status of the subscriber.                                                                                  | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String  |
| subscriber.subscribe_time      | The time the subscriber subscribed.                                                                            | "2013-03-27T10:14:13-05:00"                                   | String  |
| subscriber.subscribe_ip        | The ip the subscriber subscribed from. This can be null if it is unknown.                                      | "192.168.0.123"                                               | String  |
| subscriber.custom_fields       | An array of entries matching the definition found below.                                                       | ...                                                           | Hash    |
| subscriber.skip_autoresponders | Do not run autoresponders for this new subscriber                                                              | false                                                         | Boolean |

Each entry in the specified *custom_fields* hash must have the following keys. The keys for the hash is the name of the custom field.

| Key | Meaning | Example | Type | Present for Custom Field Types |
| --- | ------- | ------- | ---- | ------------------------------ |
| name | The name of the custom field which this entry represents. | "First Name" | String | All |
| value | The string value of the custom field. | "James McGuy" | String | text, text_multiline, select_single_dropdown, select_single_radio |
| value | The integer value of the custom field. | 9182 | Integer | number |
| value | The boolean value of the custom field. | true or false | Boolean | boolean |
| value | The date value of the custom field. | "2000-02-17" | String | date |
| value | The list of values selected for the custom field. | ... | Array of strings | select_multiple_checkboxes |

#### Response

A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

    > POST /ga/api/v2/mailing_lists/4/subscribers HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    > Content-Length: 430
    > Content-Type: application/json
    >
    {
        "subscriber": {
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


### Update an existing subscriber

#### URL

    PUT /ga/api/v2/mailing_lists/:mailing_list_id/subscribers/:subscriber_id

#### Request Parameters

| Key             | Meaning                                              | Example                                                       |
| --------------- | ---------------------------------------------------- | ------------------------------------------------------------- |
| mailing_list_id | The mailing list to onto which to add the subscriber | 99182                                                         |
| subscriber_id   | The id of the subscriber to update                   | 17293 or bob@example.com (URI encoded as bob%40example%2Ecom) |

#### Request Payload

The PUT request should have a JSON document in its payload with all of the following keys.

| Key                           | Meaning                                                                                                        | Example                                                       | Type    |
| ----------------------------- | -------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ------- |
| subscriber.email              | The subscriber's email address                                                                                 | bob@example.com                                               | String  |
| subscriber.confirmed          | The subscriber's confirmed status. This column is only needed for mailing lists which use the Confirmed field. | true or false                                                 | Boolean |
| subscriber.email_format       | The subscriber's email format. This column is only needed for mailing lists which use the Format field.        | "plaintext" or "html"                                         | String  |
| subscriber.status             | The status of the subscriber.                                                                                  | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String  |
| subscriber.subscribe_time     | The time the subscriber subscribed.                                                                            | "2013-03-27T10:14:13-05:00"                                   | String  |
| subscriber.subscribe_ip       | The ip the subscriber subscribed from. This can be null if it is unknown.                                      | "192.168.0.123"                                               | String  |
| subscriber.custom_fields      | An array of entries matching the definition found below.                                                       | ...                                                           | Hash    |
| subscriber.run_autoresponders | Run autoresponders on this subscriber as though it was just created. Defaults to false.                        | true                                                          | Boolean |

* The `run_autoresponders` option does not affect reactions that are
  already in the queue. Using this parameter, it is possible for an
  autoresponder to be sent to the same subscriber multiple times.

Each entry in the specified *custom_fields* hash must have the following keys.
The keys for the hash is the name of the custom field.

| Key   | Meaning                                                   | Example       | Type             | Present for Custom Field Types                                    | 
| ----- | --------------------------------------------------------- | ------------- | ---------------- | ----------------------------------------------------------------- | 
| name  | The name of the custom field which this entry represents. | "First Name"  | String           | All                                                               | 
| value | The string value of the custom field.                     | "James McGuy" | String           | text, text_multiline, select_single_dropdown, select_single_radio | 
| value | The integer value of the custom field.                    | 9182          | Integer          | number                                                            | 
| value | The boolean value of the custom field.                    | true or false | Boolean          | boolean                                                           | 
| value | The date value of the custom field.                       | "2000-02-17"  | String           | date                                                              | 
| value | The list of values selected for the custom field.         | ...           | Array of strings | select_multiple_checkboxes                                        | 

#### Response

A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

    > PUT /ga/api/v2/mailing_lists/4/subscribers/10012 HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    > content-type: application/json
    > Content-Length: 343
    >
    {
        "subscriber": {
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
