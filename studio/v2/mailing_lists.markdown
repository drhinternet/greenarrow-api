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

The POST request should have a JSON document in its payload with all of the following keys.

| Key                                      | Meaning                                                                                                                                   | Example                         | Type    |
| ---------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | ------- |
| mailing_list.name                        | The name of the mailing list                                                                                                              | "My Mailing List"               | String  |
| mailing_list.d_from_email                | The default from email for campaigns from this mailing list                                                                               | "bob@example.com"               | String  |
| mailing_list.d_from_name                 | The default from name for campaigns from this mailing list                                                                                | "Bob Example"                   | String  |
| mailing_list.d_reply_to                  | The default reply-to email address for campaigns from this mailing list                                                                   | "replies@example.com"           | String  |
| mailing_list.d_virtual_mta               | The name of the default virtual mta for campaigns from this mailing list                                                                  | "smtp1-1"                       | String  |
| mailing_list.d_url_domain                | The default url domain for campaigns from this mailing list                                                                               | "www.urldomain.com"             | String  |
| mailing_list.d_speed                     | The default speed for campaigns from this mailing list                                                                                    | 75                              | Integer |
| mailing_list.d_sender_email              | The default sender email address for campaigns from this mailing list                                                                     | "sender@example.com"            | String  |
| mailing_list.d_bounce_email              | The default bounce email address for campaigns from this mailing list.                                                                    | "bounce@example.com"            | String  |
| mailing_list.d_autowinner_enabled        | The default setting for automatic winner selection on new campaigns                                                                       | true/false                      | Boolean |
| mailing_list.d_autowinner_percentage     | The default percentage that will be sent for the split-test portion of the campaign                                                       | "25.0"                          | String  |
| mailing_list.d_autowinner_delay_amount   | The default number of units of time that the campaign will wait before finishing after a split-test.                                      | 25                              | Integer |
| mailing_list.d_autowinner_delay_unit     | The default unit used in calculating the delay duration.                                                                                  | "minutes", "hours", "days"      | String  |
| mailing_list.d_autowinner_metric         | The default metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                    | "clicks_unique", "opens_unique" | String  |
| mailing_list.has_format                  | True if this mailing list uses the email_format field.                                                                                    | true or false                   | Boolean |
| mailing_list.has_confirmed               | True if this mailing list uses the confirmed field.                                                                                       | true or false                   | Boolean |
| mailing_list.custom_headers_enabled      | True if this mailing list uses custom headers. If true, custom_headers must be set.                                                       | true or false                   | Boolean |
| mailing_list.custom_headers              | The content of the custom headers that will be added to every email sent to this mailing list.                                            | `X-Company: Acme\n`             | String  |
| mailing_list.primary_key_custom_field_id | The custom field to use as this mailing list's primary key. If this is null, then the subscriber's email address will be the primary key. | null                            | Integer |

Note: The `d_autowinner_percentage` value is returned as a string to prevent
floating-point conversion errors. You may send this value as an Integer, Float
or String. Posting a value with more than 2 decimals will cause a validation
error. Be careful because IEEE floating point can not exactly represent some
decimal values. For example 94.85 is represented as 94.85000000000001 which
will cause a validation error if used here. You may want to print to a string
using two decimals of precision.

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
