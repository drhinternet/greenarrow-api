<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Mailing Lists](#mailing-lists)
  - [Get list of mailing lists](#get-list-of-mailing-lists)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
      - [Preview Custom Field Data](#preview-custom-field-data)
    - [Example Request](#example-request)
  - [Create a new mailing list](#create-a-new-mailing-list)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters-1)
    - [Request Payload](#request-payload)
    - [Response](#response-1)
    - [Example](#example)
  - [Update an existing mailing list](#update-an-existing-mailing-list)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-2)
    - [Request Payload](#request-payload-1)
    - [Response](#response-2)
    - [Example](#example-1)
  - [Deleting a mailing list](#deleting-a-mailing-list)
    - [URL](#url-3)
    - [Response (Request Confirmation Code)](#response-request-confirmation-code)
      - [Example](#example-2)
    - [Response (Reply with Confirmation Code, Delete Mailing List)](#response-reply-with-confirmation-code-delete-mailing-list)
      - [Example](#example-3)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Mailing Lists


### Get list of mailing lists

Get a list of the basic details of all mailing lists in GreenArrow Studio 4.

#### URL

    GET /ga/api/v2/mailing_lists

#### Request Parameters

This API method does not require any additional parameters.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key                         | Meaning                                                                                                                                                                    | Example                         | Type    |
| --------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | ------- |
| id                          | The id of the mailing list                                                                                                                                                 | 123                             | Integer |
| name                        | The name of the mailing list                                                                                                                                               | "My Mailing List"               | String  |
| d_from_email                | The default from email for campaigns from this mailing list                                                                                                                | "bob@example.com"               | String  |
| d_from_name                 | The default from name for campaigns from this mailing list                                                                                                                 | "Bob Example"                   | String  |
| d_reply_to                  | The default reply-to email address for campaigns from this mailing list                                                                                                    | "replies@example.com"           | String  |
| d_virtual_mta               | The name of the default virtual mta for campaigns from this mailing list                                                                                                   | "smtp1-1"                       | String  |
| d_url_domain                | The default url domain for campaigns from this mailing list                                                                                                                | "www.urldomain.com"             | String  |
| d_speed                     | The default speed for campaigns from this mailing list                                                                                                                     | 75                              | Integer |
| d_sender_email              | The default sender email address for campaigns from this mailing list                                                                                                      | "sender@example.com"            | String  |
| d_bounce_email              | The default bounce email address for campaigns from this mailing list.                                                                                                     | "bounce@example.com"            | String  |
| d_seed_lists                | The default seed lists for campaigns from this mailing list. This is an array of hashes with the `id` and `name` keys.                                                     | `[ { "id": 1, "name": "S1" } ]` | Array   |
| d_autowinner_enabled        | The default setting for automatic winner selection on new campaigns                                                                                                        | true/false                      | Boolean |
| d_autowinner_percentage     | The default percentage that will be sent for the split-test portion of the campaign (Note: This value is returned as a string to prevent floating-point conversion errors) | "25.0"                          | String  |
| d_autowinner_delay_amount   | The default number of units of time that the campaign will wait before finishing after a split-test.                                                                       | 25                              | Integer |
| d_autowinner_delay_unit     | The default unit used in calculating the delay duration.                                                                                                                   | "minutes", "hours", "days"      | String  |
| d_autowinner_metric         | The default metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                                                     | "clicks_unique", "opens_unique" | String  |
| has_format                  | True if this mailing list uses the email_format field.                                                                                                                     | true or false                   | Boolean |
| has_confirmed               | True if this mailing list uses the confirmed field.                                                                                                                        | true or false                   | Boolean |
| custom_headers_enabled      | True if this mailing list uses custom headers. If true, custom_headers must be set.                                                                                        | true or false                   | Boolean |
| custom_headers              | The content of the custom headers that will be added to every email sent to this mailing list.                                                                             | X-Company: Acme\n               | String  |
| primary_key_custom_field_id | The custom field id of the primary key for the mailing list. If this value is NULL, then the primary key is the subscriber's email address.                                | 9918                            | Integer |
| preview_custom_field_data   | The custom field data, see example below.                                                                                                                                  | See below                       | Hash    |

##### Preview Custom Field Data

The `preview_custom_field_data` key is filled with a hash.

```
{
  "Custom Field Name": {
    "name": "Custom Field Name",
    "type": "text",
    "value": "Bob Example"
  },
  "Next Custom Field": {
    "name": "Next Custom Field",
    "type": "select_multiple_checkboxes",
    "value": [ "Red", "Blue" ]
  }
}
```

Custom fields which have Preview Custom Field Data values and are not specified in
the `preview_custom_field_data` list, will remain with the same values. In other words:
the custom fields provided in `preview_custom_field_data` are merged in with the existing
Preview Custom Field Data custom fields.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/mailing_lists HTTP/1.1
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
                "d_autowinner_enabled": false,
                "d_autowinner_percentage": null,
                "d_autowinner_delay_amount": null,
                "d_autowinner_delay_unit": null,
                "d_autowinner_metric": null,
                "has_format": false,
                "has_confirmed": false,
                "id": 2,
                "name": "Daily News Letter",
                "custom_headers_enabled": true,
                "custom_headers": "X-Company: Acme\n",
                "primary_key_custom_field_id": null,
                "preview_custom_field_data": {
                  "First Name": { "name": "First Name", "type": "text", "value": "Bob Example" }
                }
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
                "d_autowinner_enabled": true,
                "d_autowinner_percentage": "25.0",
                "d_autowinner_delay_amount": 10,
                "d_autowinner_delay_unit": "hours",
                "d_autowinner_metric": "opens_unique",
                "has_format": false,
                "has_confirmed": false,
                "id": 12,
                "name": "Weather Forecasts",
                "custom_headers_enabled": false,
                "custom_headers": "",
                "primary_key_custom_field_id": 112391,
            }
        ],
        "error_code": null,
        "error_message": null,
        "success": true
    }


### Create a new mailing list

#### URL

    POST /ga/api/v2/mailing_lists

#### Request Parameters

This API method does not require any additional parameters.

#### Request Payload

The POST request should have a JSON document in its payload with all of the following keys.

| Key                                    | Meaning                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | Example                         | Type    |
| -------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | ------- |
| mailing_list.name                      | The name of the mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | "My Mailing List"               | String  |
| mailing_list.d_from_email              | The default from email for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | "bob@example.com"               | String  |
| mailing_list.d_from_name               | The default from name for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | "Bob Example"                   | String  |
| mailing_list.d_reply_to                | The default reply-to email address for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | "replies@example.com"           | String  |
| mailing_list.d_virtual_mta             | The name of the default virtual mta for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | "smtp1-1"                       | String  |
| mailing_list.d_url_domain              | The default url domain for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | "www.urldomain.com"             | String  |
| mailing_list.d_speed                   | The default speed for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          | 75                              | Integer |
| mailing_list.d_sender_email            | The default sender email address for campaigns from this mailing list                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | "sender@example.com"            | String  |
| mailing_list.d_bounce_email            | The default bounce email address for campaigns from this mailing list.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          | "bounce@example.com"            | String  |
| mailing_list.d_seed_list_ids           | The default seed lists for campaigns from this mailing list. This is an array of integers that represent the IDs of the seed lists to use.                                                                                                                                                                                                                                                                                                                                                                                                                                      | `[ 1, 2 ]`                      | Array   |
| mailing_list.d_seed_list_names         | The default seed lists for campaigns from this mailing list. This is an array of strings that represent the names of the seed lists to use.                                                                                                                                                                                                                                                                                                                                                                                                                                     | `[ "Seed List", "Two" ]`        | Array   |
| mailing_list.d_autowinner_enabled      | The default setting for automatic winner selection on new campaigns                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | true/false                      | Boolean |
| mailing_list.d_autowinner_percentage   | The default percentage that will be sent for the split-test portion of the campaign (Note: This value is returned as a string to prevent floating-point conversion errors. You may send this value as an Integer, Float or String. Posting a value with more than two decimals will cause a validation error. Be careful because IEEE floating point can not exactly represent some decimal values. For example 94.85 is represented as 94.85000000000001 which will cause a validation error if used here. You may want to print to a string using two decimals of precision.) | "25.0"                          | String  |
| mailing_list.d_autowinner_delay_amount | The default number of units of time that the campaign will wait before finishing after a split-test.                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | 25                              | Integer |
| mailing_list.d_autowinner_delay_unit   | The default unit used in calculating the delay duration.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | "minutes", "hours", "days"      | String  |
| mailing_list.d_autowinner_metric       | The default metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                                                                                                                                                                                                                                                                                                                                                                                                                                                          | "clicks_unique", "opens_unique" | String  |
| mailing_list.has_format                | True if this mailing list uses the email_format field.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          | true or false                   | Boolean |
| mailing_list.has_confirmed             | True if this mailing list uses the confirmed field.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | true or false                   | Boolean |
| mailing_list.custom_headers_enabled    | True if this mailing list uses custom headers. If true, custom_headers must be set.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | true or false                   | Boolean |
| mailing_list.custom_headers            | The content of the custom headers that will be added to every email sent to this mailing list.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  | `X-Company: Acme\n`             | String  |

#### Response

A successful response will return the mailing list record using the format
described in the "Get list of mailing lists" section of the API.

A failure will return a standard error response with an explanation of what
went wrong.

* Only one of `d_seed_list_ids` and `d_seed_list_names` should be present in a single request.

#### Example

    > POST /ga/api/v2/mailing_lists HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    > content-type: application/json
    > Content-Length: 309
    >
    {
        "mailing_list": {
            "d_bounce_email": null,
            "d_from_email": "joe@example.com",
            "d_from_name": "Joe Example",
            "d_reply_to": "",
            "d_sender_email": "",
            "d_speed": 0,
            "d_seed_list_names": [ "Seed List" ],
            "d_url_domain": "staging.example.com",
            "d_virtual_mta": "System Default Route",
            "d_autowinner_enabled": true,
            "d_autowinner_percentage": "25.0",
            "d_autowinner_delay_amount": 10,
            "d_autowinner_delay_unit": "hours",
            "d_autowinner_metric": "opens_unique",
            "has_format": false,
            "has_confirmed": false,
            "name": "Daily News Letter",
        }
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
            "d_seed_lists": [ { "id": 1, "name": "Seed List" } ],
            "d_url_domain": "staging.example.com",
            "d_url_domain_id": 2,
            "d_virtual_mta": "System Default Route",
            "d_virtual_mta_id": 0,
            "d_autowinner_enabled": true,
            "d_autowinner_percentage": "25.0",
            "d_autowinner_delay_amount": 10,
            "d_autowinner_delay_unit": "hours",
            "d_autowinner_metric": "opens_unique",
            "has_format": false,
            "has_confirmed": false,
            "id": 22,
            "name": "Daily News Letter",
            "custom_headers_enabled": false,
            "custom_headers": "",
            "primary_key_custom_field_id": null,
        },
        "error_code": null,
        "error_message": null,
        "success": true
    }


### Update an existing mailing list

#### URL

    PUT /ga/api/v2/mailing_lists/:mailing_list_id

#### Request Parameters

| Key             | Meaning                              | Example |
| --------------- | ------------------------------------ | ------- |
| mailing_list_id | The id of the mailing list to update | 17293   |

#### Request Payload

The PUT request should have a JSON document in its payload with all of the following keys.

| Key                                      | Meaning                                                                                                                                     | Example                         | Type    |
| ---------------------------------------- | -----------------------------------------------------------------------------------------------------------------------------------------   | ------------------------------- | ------- |
| mailing_list.name                        | The name of the mailing list                                                                                                                | "My Mailing List"               | String  |
| mailing_list.d_from_email                | The default from email for campaigns from this mailing list                                                                                 | "bob@example.com"               | String  |
| mailing_list.d_from_name                 | The default from name for campaigns from this mailing list                                                                                  | "Bob Example"                   | String  |
| mailing_list.d_reply_to                  | The default reply-to email address for campaigns from this mailing list                                                                     | "replies@example.com"           | String  |
| mailing_list.d_virtual_mta               | The name of the default virtual mta for campaigns from this mailing list                                                                    | "smtp1-1"                       | String  |
| mailing_list.d_url_domain                | The default url domain for campaigns from this mailing list                                                                                 | "www.urldomain.com"             | String  |
| mailing_list.d_speed                     | The default speed for campaigns from this mailing list                                                                                      | 75                              | Integer |
| mailing_list.d_sender_email              | The default sender email address for campaigns from this mailing list                                                                       | "sender@example.com"            | String  |
| mailing_list.d_bounce_email              | The default bounce email address for campaigns from this mailing list.                                                                      | "bounce@example.com"            | String  |
| mailing_list.d_seed_list_ids             | The default seed lists for campaigns from this mailing list. This is an array of integers that represent the IDs of the seed lists to use.  | `[ 1, 2 ]`                      | Array   |
| mailing_list.d_seed_list_names           | The default seed lists for campaigns from this mailing list. This is an array of strings that represent the names of the seed lists to use. | `[ "Seed List", "Two" ]`        | Array   |
| mailing_list.d_autowinner_enabled        | The default setting for automatic winner selection on new campaigns                                                                         | true/false                      | Boolean |
| mailing_list.d_autowinner_percentage     | The default percentage that will be sent for the split-test portion of the campaign                                                         | "25.0"                          | String  |
| mailing_list.d_autowinner_delay_amount   | The default number of units of time that the campaign will wait before finishing after a split-test.                                        | 25                              | Integer |
| mailing_list.d_autowinner_delay_unit     | The default unit used in calculating the delay duration.                                                                                    | "minutes", "hours", "days"      | String  |
| mailing_list.d_autowinner_metric         | The default metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                      | "clicks_unique", "opens_unique" | String  |
| mailing_list.has_format                  | True if this mailing list uses the email_format field.                                                                                      | true or false                   | Boolean |
| mailing_list.has_confirmed               | True if this mailing list uses the confirmed field.                                                                                         | true or false                   | Boolean |
| mailing_list.custom_headers_enabled      | True if this mailing list uses custom headers. If true, custom_headers must be set.                                                         | true or false                   | Boolean |
| mailing_list.custom_headers              | The content of the custom headers that will be added to every email sent to this mailing list.                                              | `X-Company: Acme\n`             | String  |
| mailing_list.primary_key_custom_field_id | The custom field to use as this mailing list's primary key. If this is null, then the subscriber's email address will be the primary key.   | null                            | Integer |
| mailing_list.preview_custom_field_data   | The custom field data, a hash that maps custom field names to values.                                                                       | `{ "First Name": "Bob" }`       | Hash    |

* The `d_autowinner_percentage` value is returned as a string to prevent
  floating-point conversion errors. You may send this value as an Integer, Float
  or String. Posting a value with more than 2 decimals will cause a validation
  error. Be careful because IEEE floating point can not exactly represent some
  decimal values. For example 94.85 is represented as 94.85000000000001 which
  will cause a validation error if used here. You may want to print to a string
  using two decimals of precision.

* Only one of `d_seed_list_ids` and `d_seed_list_names` should be present
  in a single request.

#### Response

A successful response will return the subscriber record using the format
described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what
went wrong.

#### Example

    > PUT /ga/api/v2/mailing_lists/22 HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    > content-type: application/json
    > Content-Length: 309
    >
    {
        "mailing_list": {
            "d_bounce_email": null,
            "d_from_email": "joe@example.com",
            "d_from_name": "Joe Example",
            "d_reply_to": "",
            "d_sender_email": "",
            "d_speed": 0,
            "d_url_domain": "staging.example.com",
            "d_virtual_mta": "System Default Route",
            "d_autowinner_enabled": true,
            "d_autowinner_percentage": "25.0",
            "d_autowinner_delay_amount": 10,
            "d_autowinner_delay_unit": "hours",
            "d_autowinner_metric": "opens_unique",
            "has_format": false,
            "has_confirmed": false,
            "name": "Renamed Daily News Letter",
            "custom_headers_enabled": false,
            "custom_headers": "",
            "primary_key_custom_field_id": null,
        }
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
            "d_autowinner_enabled": true,
            "d_autowinner_percentage": "25.0",
            "d_autowinner_delay_amount": 10,
            "d_autowinner_delay_unit": "hours",
            "d_autowinner_metric": "opens_unique",
            "has_format": false,
            "has_confirmed": false,
            "id": 22,
            "name": "Renamed Daily News Letter",
            "custom_headers_enabled": false,
            "custom_headers": "",
            "primary_key_custom_field_id": null,
        },
        "error_code": null,
        "error_message": null,
        "success": true
    }


### Deleting a mailing list

Deleting a mailing list is a two-step process:

1. Request a "Delete Confirmation Code". This will generate a confirmation code
   that will be valid for 2 minutes.
2. Send the confirmation code back to the server.

We do this because deleting a mailing list is what we consider to be a major
event. The following happens when a mailing list is deleted:

1. All subscribers are deleted.
2. All active/scheduled subscriber imports and exports are cancelled.
3. All active/scheduled campaigns are cancelled.
4. The mailing list's database entry is marked as "deleted."

From that point forward, the mailing list will no longer appear in the user interface.

#### URL

To request the confirmation code:

    GET /ga/api/v2/mailing_lists/:mailing_list_id/delete_confirmation_code

To confirm the deletion and start the deletion process:

    DELETE /ga/api/v2/mailing_lists/:mailing_list_id/confirmed/:delete_confirmation_code

#### Response (Request Confirmation Code)

| Key                              | Meaning                                                                                 |
| -------------------------------- | --------------------------------------------------------------------------------------- |
| `delete_confirmation_code`       | The token to send back to the server to confirm deletion of the specified mailing list. |
| `delete_confirmation_expires_at` | The time at which the included token will no longer be valid.                           |

##### Example

```json
> GET /ga/api/mailing_lists/3/delete_confirmation_code HTTP/1.1
> Authorization: Basic MTpjMjBmMWMyODUwM2M5ODg2N2YwZDRjYWQ3NGYyMWI4NzU5ODMzYTAz
> Accept: application/json
> Content-Type: application/json

< Date: Tue, 20 Jan 2015 14:15:46 GMT
< Server: Apache/2.2.27 (Unix) mod_ssl/2.2.27 OpenSSL/1.0.1e-fips PHP/5.3.28 Phusion_Passenger/4.0.45
< X-UA-Compatible: IE=Edge,chrome=1
< ETag: "695e7fac5af2c12993874f8e798a127a"
< Cache-Control: must-revalidate, private, max-age=0
< X-Request-Id: efc60ffbc114662efdae67ff6f7f4e72
< X-Runtime: 0.084875
< X-Rack-Cache: miss
< X-Powered-By: Phusion Passenger 4.0.45
< Set-Cookie: _session_id=4c395b61027d76f25f469bedf53c6f5d; path=/; HttpOnly
< Status: 200 OK
< Transfer-Encoding: chunked
< Content-Type: application/json; charset=utf-8

{
  "success": true,
  "data": {
    "delete_confirmation_code": "889d6ede39689b0f25e41d8cd4441f7d18082c79:1421871666",
    "delete_confirmation_expires_at": "2015-01-20T14:17:46Z"
  },
  "error_code": null,
  "error_message": null
}
```

#### Response (Reply with Confirmation Code, Delete Mailing List)

An empty successful response to this request indicates that the mailing list
has been marked as deleted and the data cleanup listed above has been done.

##### Example

```json
> DELETE /ga/api/mailing_lists/3/confirmed/889d6ede39689b0f25e41d8cd4441f7d18082c79:1421871666 HTTP/1.1
> Authorization: Basic MTpjMjBmMWMyODUwM2M5ODg2N2YwZDRjYWQ3NGYyMWI4NzU5ODMzYTAz
> Accept: application/json
> Content-Type: application/json

< Date: Tue, 20 Jan 2015 14:16:00 GMT
< Server: Apache/2.2.27 (Unix) mod_ssl/2.2.27 OpenSSL/1.0.1e-fips PHP/5.3.28 Phusion_Passenger/4.0.45
< X-UA-Compatible: IE=Edge,chrome=1
< ETag: "f744395dc73a323ce47b552d60a1c6cb"
< Cache-Control: max-age=0, private, must-revalidate
< X-Request-Id: 75d99d41a3063d411b23cd751c9bf4cd
< X-Runtime: 0.096435
< X-Rack-Cache: invalidate, pass
< X-Powered-By: Phusion Passenger 4.0.45
< Set-Cookie: _session_id=ae243b2ca548b6e3e1c57967bc33e44f; path=/; HttpOnly
< Status: 200 OK
< Transfer-Encoding: chunked
< Content-Type: application/json; charset=utf-8

{
  "success": true,
  "data": null,
  "error_code": null,
  "error_message": null
}
```
