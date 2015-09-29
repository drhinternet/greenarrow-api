## Subscribers

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Remote Lists](#remote-lists)
- [Get a list of subscribers](#get-a-list-of-subscribers)
  - [URL](#url)
  - [Request Parameters](#request-parameters)
  - [Pagination](#pagination)
  - [Response](#response)
  - [Example](#example)
- [Get subscriber details](#get-subscriber-details)
  - [URL](#url-1)
  - [Request Parameters](#request-parameters-1)
  - [Notes](#notes)
  - [Response](#response-1)
  - [Example Request](#example-request)
- [Create a new subscriber](#create-a-new-subscriber)
  - [URL](#url-2)
  - [Request Parameters](#request-parameters-2)
  - [Request Payload](#request-payload)
  - [Response](#response-2)
  - [Example](#example-1)
  - [Example code](#example-code)
- [Update an existing subscriber](#update-an-existing-subscriber)
  - [URL](#url-3)
  - [Request Parameters](#request-parameters-3)
  - [Request Payload](#request-payload-1)
  - [Response](#response-3)
  - [Example](#example-2)
  - [Example code](#example-code-1)
- [Trigger Autoresponders on a Subscriber](#trigger-autoresponders-on-a-subscriber)
  - [URL](#url-4)
  - [Request Parameters](#request-parameters-4)
  - [Request Payload](#request-payload-2)
  - [Response](#response-4)
  - [Example](#example-3)
- [Unsubscribe](#unsubscribe)
  - [URL](#url-5)
  - [Request Payload](#request-payload-3)
  - [Response](#response-5)
  - [Example](#example-4)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->



### Remote Lists

Subscribers are not available on [Remote Lists](../remote_lists.markdown). API
calls to these endpoints will return an error message if attempted on a Remote List.



### Get a list of subscribers

Get the details for all subscribers on this list.

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/subscribers

#### Request Parameters

| Key             | Meaning                              |
| --------------- | ------------------------------------ |
| mailing_list_id | The id of the mailing list to query. |

#### Pagination

This endpoint returns its records paginated.  The subscriber records will be
sorted by their id in ascending order.

Querying without any additional parameters will return the first page. The following
extra parameters may be specified.

| Key          | Meaning                                                              |
| ------------ | -------------------------------------------------------------------- |
| `page`       | The page number to retrieve (starts at 0).                           |
| `page_token` | The page token to retrieve. This is explained below.                 |
| `per_page`   | The number of records to return per page (default 100, maximum 500). |

There are two ways to page through the data:

* Sequentially increment `page` to specify additional page numbers until you
  have retrieved every page of the results. When subscribers are added or removed
  the page boundaries may shift, and it's possible that some subscribers will be missed
  between pages or returned on two adjacent pages.

* Provide in `page_token` the `next_page_token` value returned by the most recent
  call to this API which got the previous page. This guarantees that the next returned page
  will start immediately after the previous page, with all pages being contiguous and
  non-overlapping. When a `next_page_token` of null is returned, that indicates that this
  is the last page.

If you are presenting a list of pages to the user, you probably want to use
`page`. If you want to retrieve all of the data, `page_token` is likely what you want.
(When retrieving all data, the `page_token` method allows GreenArrow to more efficiently
provide the data.)

Both `page` and `page_token` may not be specified in the same request.

#### Response

The response will be an array of subscriber hashes, the same as returned by the
[Get subscriber details](#get-subscriber-details) endpoint documented below.

#### Example

```
> GET /ga/api/mailing_lists/1/subscribers?per_page=2 HTTP/1.1
> Authorization: Basic MTpkOTgzOGM4MDBlMmY3ODAxMWY0MTc1NWUzMGIwY2QzNWJiYTA1ZDYx
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "9394b6420de28ae7f15744c4a7aa9681"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=67423ec44938ad4beb4de1f8e9c684a0; path=/; HttpOnly
< X-Request-Id: 12cc0a5d90bbc75779478a30e8793e6b
< X-Runtime: 0.077669
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "error_code": null,
  "error_message": null,
  "per_page": 2,
  "page": 0,
  "data": [
    {
      "id": 1,
      "mailing_list_id": 1,
      "email": "user-1@discardallmail.drh.net",
      "created_at": "2015-03-09T10:34:04-05:00",
      "created_at_epoch": 1425915244,
      "status": "active",
      "subscribe_time": "2015-03-09T10:34:04-05:00",
      "subscribe_time_epoch": 1425915244,
      "subscribe_ip": null,
      "custom_fields": {
        "new field 1": {
          "name": "new field 1",
          "type": "text",
          "value": null
        },
        "new field 2": {
          "name": "new field 2",
          "type": "text",
          "value": null
        }
      }
    },
    {
      "id": 2,
      "mailing_list_id": 1,
      "email": "user-2@discardallmail.drh.net",
      "created_at": "2015-03-09T10:36:55-05:00",
      "created_at_epoch": 1425915415,
      "status": "active",
      "subscribe_time": "2015-03-09T10:36:55-05:00",
      "subscribe_time_epoch": 1425915415,
      "subscribe_ip": "10.0.81.5",
      "custom_fields": {
        "new field 1": {
          "name": "new field 1",
          "type": "text",
          "value": null
        },
        "new field 2": {
          "name": "new field 2",
          "type": "text",
          "value": null
        }
      }
    }
  ],
  "next_page_token": "EDZmZjYkFGOjlzM"
}
```



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

| Key                                      | Meaning                                                                                                        | Example                                                       | Type    |
| ---------------------------------------- | -------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------- | ------- |
| subscriber.email                         | The subscriber's email address                                                                                 | bob@example.com                                               | String  |
| subscriber.confirmed                     | The subscriber's confirmed status. This column is only needed for mailing lists which use the Confirmed field. | true or false                                                 | Boolean |
| subscriber.email_format                  | The subscriber's email format. This column is only needed for mailing lists which use the Format field.        | "plaintext" or "html"                                         | String  |
| subscriber.status                        | The status of the subscriber.                                                                                  | "active", "bounced", "unsubscribed", "scomp" or "deactivated" | String  |
| subscriber.subscribe_time                | The time the subscriber subscribed.                                                                            | "2013-03-27T10:14:13-05:00"                                   | String  |
| subscriber.subscribe_ip                  | The ip the subscriber subscribed from. This can be null if it is unknown.                                      | "192.168.0.123"                                               | String  |
| subscriber.custom_fields                 | An array of entries matching the definition found below (1).                                                   | ...                                                           | Hash    |
| subscriber.skip_autoresponders           | Do not run autoresponders for this new subscriber (see 2.1 below).                                             | false                                                         | Boolean |
| subscriber.autoresponder_filter          | Only run the autoresponders that match this case-insensitive string glob (see 2.4 below).                      | `Subscription Autoresponder Sequence*`                        | String  |
| subscriber.autoresponder_exclude_reacted | Do not run autoresponders if this subscriber has a reaction in the queue (see 2.5 below).                      | `true`                                                        | Boolean |

(1) Each entry in the specified *custom_fields* hash must have the following keys. The keys for the hash is the name of the custom field.

| Key | Meaning | Example | Type | Present for Custom Field Types |
| --- | ------- | ------- | ---- | ------------------------------ |
| name | The name of the custom field which this entry represents. | "First Name" | String | All |
| value | The string value of the custom field. | "James McGuy" | String | text, text_multiline, select_single_dropdown, select_single_radio |
| value | The integer value of the custom field. | 9182 | Integer | number |
| value | The boolean value of the custom field. | true or false | Boolean | boolean |
| value | The date value of the custom field. | "2000-02-17" | String | date |
| value | The list of values selected for the custom field. | ... | Array of strings | select_multiple_checkboxes |

(2) In order for an autoresponder to be triggered for later sending, the following must be true.

1. The `skip_autoresponders` field must not be enabled.
2. The autoresponder must trigger on *Subscription*.
3. The autoresponder trigger must be configured with the *Run From API?* option enabled.
4. If specified, the `autoresponder_filter` field will reduce the list of autoresponders
   that are run to those whose name matches the glob, where `*` is a wildcard character.
5. If specified, the `autoresponder_exclude_reacted` field will cause *all*
   autoresponders to be skipped if any autoresponder remaining at this point contains a
   reaction in the queue for this subscriber. This only evaluates autoresponders that:
   (a) are configured with *Run from API?* as true (step 3), (b) match the pattern provided in
   `autoresponder_filter` if present (step 4), and (c) are paused or un-paused.

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
#### Example code

* [Create a new subscriber](../examples/create_a_new_subscriber.php)
* [Create a new subscriber with custom fields](../examples/create_a_new_subscriber_with_custom_field.php)


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

#### Example code

* [Update an existing subscriber](../examples/update_existing_subscribers_custom_field.php)



### Trigger Autoresponders on a Subscriber

This endpoint will trigger autoresponders for a single subscriber. The list of
autoresponders to trigger may be provided by name or by ID.

Any autoresponder(s) may be triggered using this endpoint - it is *not*
restricted to just "API" triggers.

If any error is returned by this method, no autoresponders will be triggered.

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/subscribers/:subscriber_id_or_email/trigger_autoresponders

#### Request Parameters

In the URL of the request, the following values must be replaced.

<table>
  <tr valign="top">
    <td><b>mailing_list_id</b><br><em>integer</em></td>
    <td>The ID of the mailing list that contains the subscriber record.</td>
  </tr>
  <tr valign="top">
    <td><b>subscriber_id_or_email</b><br><em>string</em></td>
    <td>
      <p>This may either be the numeric ID for the subscriber record, or an email address.</p>
      <p>If this value is an email address, it must be URI escaped. For example, <code>bob@example.com</code> escapes as <code>bob%40example.com</code>.</p>
    </td>
  </tr>
</table>

#### Request Payload

The body of this request should be a JSON hash with the following keys.

<table>
  <tr valign="top">
    <td><b>create_missing_subscriber</b><br><em>boolean</em> &mdash; default <code>false</code><br></td>
    <td>
      <p>
        Studio can only send autoresponders to subscribers that are
        on the mailing list. If the subscriber is not found on the
        mailing list and this flag is true, the subscriber will be
        added to the mailing list.
      </p><p>
        <code>subscriber_id_or_email</code> must be an email address
        for this to work.
      </p>
      <ul>
        <li>
          If it is an integer and not found on the list a
          <code>not_found</code> error will be returned.
        </li><li>
          If it is an improperly formatted email address a
          <code>validation_failed</code> error will be returned.
        </li><li>
          If if the custom field data for the subscriber does not
          pass validation a <code>validation_failed</code> error will
          be returned.
        </li>
      </ul>
      <p>
        NOTE: On-subscription autoresponders that are configured to respond to subscribers created
        on the API will be triggered on subscribers created due to this flag. This can be prevented
        with the <code>skip_subscription_autoresponders</code> option.
      </p><p>
        <b>WARNING:</b> If you are also using this mailing list to send campaigns,
        you need to make sure you're not implicitly subscribing people to get mailing list
        messages from you, if that's not what you want.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>reactivate_subscriber</b><br><em>boolean</em> &mdash; default <code>false</code><br></td>
    <td>
      <p>
        Studio can only send autoresponders to subscribers that have a status of <code>active</code>.
      </p><p>
        If the requested subscriber exists on the mailing list and is in a non-active status:
      </p>
      <ul>
        <li>If this flag is true: the subscriber will be reactivated (its status set back to <code>active</code>) and the autoresponder will be triggered.</li>
        <li>If this flag is false: an <code>invalid_request</code> error will be returned.</li>
      </ul>
        <b>WARNING:</b> If you are also using this mailing list to send campaigns, be careful with this flag!
        This will reactivate the subscriber, potentially causing them to receive campaigns from which they had 
        previously unsubscribed.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>skip_subscription_autoresponders</b><br><em>boolean</em> &mdash; default <code>false</code></td>
    <td>
      <p>
        Set this value to <code>true</code> to skip subscription autoresponders
        that would have triggered as a result of a new subscriber being created
        with the <code>create_missing_subscriber</code> flag.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>autoresponder_names</b><br><em>array of strings</em></td>
    <td>
      <p>
        The list of autoresponders, by name, that should be triggered. The
        asterisk (<code>*</code>) is used as a wildcard character &mdash; if you have
        autoresponders named <code>AR 1</code> and <code>AR Two</code>, then including <code>AR *</code> in
        <code>autoresponder_names</code> will cause both to be triggered.
      </p></p>
        Only one of <code>autoresponder_names</code> and <code>autoresponder_ids</code> may be provided.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>autoresponder_ids</b><br><em>array of integers</em></td>
    <td>
      <p> The list of autoresponders, by numeric ID, that should be triggered. </p>
      <p> Only one of <code>autoresponder_names</code> and <code>autoresponder_ids</code> may be provided. </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>content_replacement_fields</b><br><em>hash of strings to strings</em></td>
    <td>
      <p>
        If provided, the key/value pairs in this hash will be interpolated into the content of the autoresponder,
        prefixed with an <code>api:</code> string with whitespace replaced as underscores.
      </p><p>
        For example, if you provide the hash <code>{ "my_value": "Hello World", "Second Key": "Here's another value" }</code>,
        anywhere in your autoresponder content that contains <code>%%api:my_value%%</code> or <code>%%api:Second_Key%%</code>
        will be replaced with <code>Hello World</code> and <code>Here's another value</code>, respectively. Spaces in the key
        must be replaced with underscores when entering the replacement code into your Autoresponder's content.
      </p><p>
        These values are <em>only</em> used for interpolation into the email(s) generated by this
        API request. Any subsequent autoresponders or campaigns sent to this subscriber will have
        no knowledge or history of these <code>content_replacement_fields</code> values.
      </p><p>
        These values are not passed to Special Sending Rules.
      </p><p>
        Fields present in this hash will override Custom Field counterparts
        with the same name. If you include a `content_replacement_fields` key
        `First Name`, it will override any custom field named `API:First Name`.
      </p><p>
        <!--
          If any clauses are added or modified here, please update the test in
          spec/controllers/api/v2/subscribers_controller_spec.rb
        -->
        The hash keys are validated as follows:

        <ul>
          <li>Keys must not be blank</li>
          <li>Keys must not consist of only whitespace</li>
          <li>Keys must contain at least one alphanumeric character <code>A-Z a-z 0-9</code></li>
          <li>Keys must be case-insensitive unique</li>
          <li>Keys must be 50 characters or less</li>
          <li>Whitespace within keys are treated as underscores - so <code>First_Name</code> and <code>First Name</code> are the same key</li>
        </ul>

        If a key is passed that does not match this, an `invalid_request` error will be returned.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td colspan="2">
      <b>custom_fields</b><br><em>hash</em><br>
      <hr />
      <p>
        Each value in this hash contains custom field data to be applied to
        the subscriber record. These hashes should be like
        <code>{ "Custom Field Name": "My Value" }</code> -- just as though it was
        being passed to update a subscriber record.
      </p><p>
        By default, if the subscriber is not active, this update will be not be applied.
        If <code>reactivate_subscriber</code> is set to <code>true</code>, then the
        subscriber will be reactivated and these updates will be applied.
      </p><p>
        The more specific hashes take precedence over the <code>for_all</code> hash.
        For example, if you pass in a <code>First Name</code> key in both <code>for_all</code>
        and <code>for_new</code> -- the value in <code>for_new</code> will be set.
        However, if both hashes contain unique keys - then all of the values will be set.
      </p><p>
        If the provided (or if a custom field is required, and not provided)
        custom fields result in a validation error on the subscriber record, no
        autoresponder will be sent. A validation error will be returned.
      </p>
      <table>
        <tr valign="top">
          <td><b>for_all</b><br><em>hash</em></td>
          <td>
            This is the base custom field data. Values in this hash will be applied
            to any subscriber that is successfully triggered.
          </td>
        </tr>
        <tr valign="top">
          <td><b>for_new</b><br><em>hash</em></td>
          <td>
            This custom field data will be applied to subscribers that are created as
            a result of <code>create_missing_subscriber</code> being set to <code>true</code>
            and the subscriber not already existing in the mailing list.
          </td>
        </tr>
        <tr valign="top">
          <td><b>for_active</b><br><em>hash</em></td>
          <td>
            This custom field data will be applied to subscribers who already existed
            and are active on the mailing list.
          </td>
        </tr>
        <tr valign="top">
          <td><b>for_reactivated</b><br><em>hash</em></td>
          <td>
            This custom field data will be applied to subscribers who are reactivated
            as a result of <code>reactivate_subscriber</code> being set to <code>true</code>.
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

#### Response

A successful response will contain the following keys.

<table>
  <tr valign="top">
    <td colspan="2">
      <b>triggered_autoresponders</b><br><em>array of hashes</em><br>
      <table>
        <tr valign="top">
          <td><b>id</b><br><em>integer</em></td>
          <td> The ID of the autoresponder that was triggered. </td>
        </tr>
        <tr valign="top">
          <td><b>name</b><br><em>string</em></td>
          <td> The name of the autoresponder that was triggered. </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr valign="top">
    <td><b>subscriber</b><br><em>hash</em></td>
    <td>
      <p>
        The subscriber record that was used for this call, as described in the
        format described in the "Get subscriber details" section of this API.
      </p><p>
        The record that is returned will be after any updates in this request
        have been applied.
      </p>
    </td>
  </tr>
  <tr valign="top">
    <td><b>subscription_result</b><br><em>string</em></td>
    <td>
      The result of the subscript as a result of this API call.
      If the subscriber was created, this value will be <code>created</code>.
      If the subscriber already existed and was active, this value will be <code>remained_active</code>.
      If the subscriber already existed and was reactivated, this value will be <code>reactivated</code>.
      If none of those situations applied, this call should have already resulted in an error.
    </td>
  </tr>
</table>

#### Example

```
> POST /ga/api/mailing_lists/2/subscribers/bob%40example.com/trigger_autoresponders HTTP/1.1
> Authorization: Basic MToyYjBmNTA5YjQ3MDk1ODk0Mzk5ZWRkMGVhODE1ZDlkMjQ4MzUwYjc4
> Accept: application/json
> Content-Type: application/json
```

```json
{
  "autoresponder_ids": [
    203
  ],
  "custom_fields": {
    "for_new": {
      "First Name": "Bob",
      "Last Name": "Example"
    }
  },
  "create_missing_subscriber": true
}
```

```
< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "29694bdf4c95e5a20de5d440073eff40"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=f6f0a9eac82fc88c3bbb036e0ac74390; path=/; HttpOnly
< X-Request-Id: a62aeb23d79348c61ddecaffaf231575
< X-Runtime: 0.183498
< Connection: close
< Server: thin
```

```json
{
  "success": true,
  "data": {
    "triggered_autoresponders": [
      {
        "id": 203,
        "name": "by api"
      }
    ],
    "subscriber": {
      "id": 3430120,
      "mailing_list_id": 2,
      "email": "bob@example.com",
      "created_at": "2015-09-29T14:07:34-05:00",
      "created_at_epoch": 1443553654,
      "status": "active",
      "subscribe_time": "2015-09-29T14:07:34-05:00",
      "subscribe_time_epoch": 1443553654,
      "subscribe_ip": null,
      "custom_fields": {
        "First Name": {
          "name": "First Name",
          "type": "text",
          "value": "Bob"
        },
        "Last Name": {
          "name": "Last Name",
          "type": "text",
          "value": "Example"
        }
      }
    },
    "subscription_result": "created"
  },
  "error_code": null,
  "error_message": null
}
```



### Unsubscribe

Unsubscribe a subscriber using a token from the delivered email. This will
cause the unsubscribe event to be associated with the specific campaign/content
in which the token was delivered.

The token which should be sent to this endpoint may be generated in the
campaign content by including the replacement code `%%unsubscribe_token%%`.

#### URL

    POST /ga/api/v2/subscribers/unsubscribe

#### Request Payload

<table>
  <tr>
    <td colspan="2">
      <b>unsubscribe</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>token</b><br><em>string</em></td>
          <td>
            The value for this field is obtained from the `%%unsubscribe_token%%` replacement code when composing a
            campaign's contents.  It may then be used to generate a real unsubscribe on that campaign for this subscriber.
          </td>
        </tr>
        <tr>
          <td><b>ip</b><br><em>string (optional)</em></td>
          <td>
            The IP address to use when logging this unsubscribe event. If this
            is not present, no IP will be set on the unsubscribe event.
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

#### Response

A successful response will return the subscriber record using the format described in the "Get subscriber details" section of the API.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

```
> POST /ga/api/mailing_lists/1/subscribers/unsubscribe HTTP/1.1
> Authorization: Basic MTpiYTVhZjYzN2JhYjA0NzM0ZjMyMDUwMTBkZWQyZjA3NGMzYmU2YTM1
> Accept: application/json
> Content-Type: application/json

{
  "unsubscribe": {
    "token": "0E2MiJGZlV2Y10iY4gTZhJWO3QTYyETM2EWLy0SMtETLx0iM",
    "ip": "127.0.0.7"
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "4778db54a2512804124ea70383ffa61c"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=044b98a3732095dd7bedcd96497215da; path=/; HttpOnly
< X-Request-Id: d3c93e6c84f61186f733dbbb3c354265
< X-Runtime: 0.105547
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "id": 1,
    "mailing_list_id": 1,
    "email": "user-1@discardallmail.drh.net",
    "created_at": "2015-06-19T14:19:12-05:00",
    "created_at_epoch": 1434741552,
    "status": "unsubscribed",
    "subscribe_time": "2015-06-19T14:19:12-05:00",
    "subscribe_time_epoch": 1434741552,
    "subscribe_ip": null,
    "custom_fields": {
      "First Name": {
        "name": "First Name",
        "type": "text",
        "value": "Bob the Builder"
      }
    }
  },
  "error_code": null,
  "error_message": null
}
```
