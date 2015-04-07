<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Autoresponders](#autoresponders)
  - [Get a list of autoresponders](#get-a-list-of-autoresponders)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)
  - [Create a new autoresponder](#create-a-new-autoresponder)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters-1)
    - [Response](#response-1)
    - [Example Request](#example-request-1)
  - [Update an existing autoresponder](#update-an-existing-autoresponder)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-2)
    - [Response](#response-2)
    - [Example Request](#example-request-2)
  - [Get statistics for an autoresponder](#get-statistics-for-an-autoresponder)
    - [URL](#url-3)
    - [Request Parameters](#request-parameters-3)
    - [Response](#response-3)
    - [Example Request](#example-request-3)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Autoresponders

### Get a list of autoresponders

Get a list of the basic details of all autoresponders of a particular mailing list.

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/autoresponders

#### Request Parameters

This API method does not require any additional parameters.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key                                     | Meaning                                                                                                        | Example                                       | Type    |
| --------------------------------------- | -------------------------------------------------------------------------------------------------------------- | --------------------------------------------- | ------- |
| id                                      | The autoresponder's internal ID                                                                                | 1234                                          | Integer |
| mailing_list_id                         | The mailing list ID                                                                                            | 99182                                         | Integer |
| name                                    | The name of the autoresponder                                                                                  | "On Subscription"                             | String  |
| paused                                  | This autoresponder is paused                                                                                   | true                                          | Boolean |
| trigger                                 | The type of action that this autoresponder triggers on                                                         | "subscription", "campaign_open"               | String  |
| delay                                   | Indicate whether or not this autoresponder is delayed                                                          | "immediately", "with_delay"                   | String  |
| delay_amount                            | The number of units to delay this autoresponder                                                                | 12345                                         | Integer |
| delay_unit                              | The time unit to delay the autoresponder                                                                       | "minutes", "hours", "days", "weeks", "months" | String  |
| delay_time                              | For "days", "weeks", and "months" -- this field determines the hour of day at which the autoresponder will run | 12 (For 12pm), 23 (For 11pm)                  | Integer |
| trigger_include_subscribers_from_import | Determines if this autoresponder should run on subscribers added in imports                                    | false                                         | Boolean |
| trigger_run_on_api                      | Determines if this autoresponder should run on subscribers created via the API                                 | true                                          | Boolean |
| trigger_campaign_to_open_id             | If this autoresponder's trigger is `campaign_open`, the campaign it will trigger on                            | null                                          | Integer |
| use_external_delivery_setting           | This autoresponder uses the mailing list's web form delivery settings                                          | false                                         | Boolean |
| bounce_email_user_id                    | The bounce email's `user_id` component                                                                         | 1                                             | Integer |
| bounce_email_domain_id                  | The bounce email's `domain_id` component                                                                       | 2                                             | Integer |
| from_name                               | Emails from this autoresponder will be sent using this `from_name`                                             | "bob@example.com"                             | String  |
| from_email                              | Emails from this autoresponder will be sent using this `from_email`                                            | "Bob Example"                                 | String  |
| virtual_mta_id                          | Emails from this autoresponder will be sent using this Virtual MTA                                             | 123                                           | Integer |
| url_domain_id                           | Emails from this autoresponder will be sent using this URL Domain                                              | 456                                           | Integer |
| track_opens                             | Track open statistics on this autoresponder                                                                    | false                                         | Boolean |
| track_links                             | Track click statistics on this autoresponder                                                                   | true                                          | Boolean |
| content_subject                         | The subject to use in emails                                                                                   | "both"                                        | String  |
| content_format                          | Email format for this autoresponder's messages                                                                 | "Message Inside!"                             | String  |
| content_html                            | The HTML content for this autoresponder                                                                        | `"Hello, <b>world</b>!"`                      | String  |
| content_text                            | The plain-text content for this autoresponder                                                                  | "Hello, world!"                               | String  |
| triggered_on                            | The time this autoresponder last triggered                                                                     | "2013-01-01T00:00:00Z"                        | String  |
| paused_at                               | The time at which this autoresponder was paused                                                                | "2013-01-01T00:00:00Z"                        | String  |
| segmentation_criteria_id                | The segmentation criteria used to filter messages sent for this autoresponder                                  | 123                                           | Integer |

#### Example Request

    > GET /ga/api/v2/mailing_lists/1/autoresponders HTTP/1.1
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
       "success":true,
       "data":[
          {
             "bounce_email_domain_id":2,
             "bounce_email_user_id":2,
             "delay":"immediately",
             "delay_amount":0,
             "delay_time":0,
             "delay_unit":null,
             "from_email":"bob@example.com",
             "from_name":"Bob Example",
             "id":1,
             "mailing_list_id":1,
             "name":"Autoresponder c923c0320fae0a7370e23111e138acb3 0",
             "paused":false,
             "paused_at":null,
             "segmentation_criteria_id":1,
             "track_links":true,
             "track_opens":true,
             "trigger":"subscription",
             "trigger_campaign_to_open_id":null,
             "trigger_include_subscribers_from_import":false,
             "trigger_run_on_api":false,
             "triggered_on":"2014-06-30",
             "url_domain_id":2,
             "use_external_delivery_setting":true,
             "virtual_mta_id":0
          }
       ]
    }

### Create a new autoresponder

Create a new autoresponder on the specified mailing list.

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/autoresponders

#### Request Parameters

The request body should be a JSON hash in the format of `{ 'autoresponder': AUTORESPONDER_DETAILS }`
where `AUTORESPONDER_DETAILS` is defined above in the `Get a list of autoresponders` section.

#### Response

The response will be a JSON object in the same format as the response to the autoresponders index.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```
> POST /ga/api/mailing_lists/1/autoresponders HTTP/1.1
> Authorization: Basic MTo5ODU2MzhiMDNkNGJjOGFlZDJjYTk5NWQ4NzcwM2ExYWZiMjJhYTRl
> Accept: application/json
> Content-Type: application/json

{
  "autoresponder": {
    "bounce_email_domain_id": 1,
    "bounce_email_user_id": 1,
    "delay": "immediately",
    "delay_amount": 0,
    "delay_time": 0,
    "delay_unit": null,
    "from_email": "bob@example.com",
    "from_name": "Bob Example",
    "name": "Autoresponder 2",
    "paused": false,
    "paused_at": null,
    "segmentation_criteria_id": 1,
    "track_links": true,
    "track_opens": true,
    "trigger": "subscription",
    "trigger_campaign_to_open_id": null,
    "trigger_include_subscribers_from_import": false,
    "trigger_run_on_api": false,
    "triggered_on": "2014-06-30",
    "url_domain_id": 1,
    "use_external_delivery_setting": true,
    "virtual_mta_id": 0,
    "content_format": "html",
    "content_subject": "Welcome to our mailing list!",
    "content_html": "<p>Welcome!</p>"
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "a8b71350b39af606469bc672096ca0ac"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=c6c7db826070a655890578718cfd3e23; path=/; HttpOnly
< X-Request-Id: 389f0fe0c0628b2dcd4318f4cdfd50e9
< X-Runtime: 0.089678
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "bounce_email_domain_id": 1,
    "bounce_email_user_id": 1,
    "delay": "immediately",
    "delay_amount": 0,
    "delay_time": 0,
    "delay_unit": null,
    "from_email": "bob@example.com",
    "from_name": "Bob Example",
    "id": 1,
    "mailing_list_id": 1,
    "name": "Autoresponder 2",
    "paused": false,
    "paused_at": null,
    "segmentation_criteria_id": 1,
    "track_links": true,
    "track_opens": true,
    "trigger": "subscription",
    "trigger_campaign_to_open_id": null,
    "trigger_include_subscribers_from_import": false,
    "trigger_run_on_api": false,
    "triggered_on": null,
    "url_domain_id": 1,
    "use_external_delivery_setting": true,
    "virtual_mta_id": 0
  },
  "error_code": null,
  "error_message": null
}
```

### Update an existing autoresponder

Update an existing autoresponder.

#### URL

    PUT /ga/api/v2/mailing_lists/:mailing_list_id/autoresponders/:id

#### Request Parameters

The request body for updating a subscriber is in the same format as the one
declared above for creating a new autoresponder.

#### Response

The response will be a JSON object in the same format as the response to the autoresponders index.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```
> PUT /ga/api/mailing_lists/1/autoresponders/1 HTTP/1.1
> Authorization: Basic MTo5ODU2MzhiMDNkNGJjOGFlZDJjYTk5NWQ4NzcwM2ExYWZiMjJhYTRl
> Accept: application/json
> Content-Type: application/json

{
  "autoresponder": {
    "bounce_email_domain_id": 1,
    "bounce_email_user_id": 1,
    "delay": "immediately",
    "delay_amount": 0,
    "delay_time": 0,
    "delay_unit": null,
    "from_email": "bob@example.com",
    "from_name": "Bob Example",
    "name": "Autoresponder 2",
    "paused": false,
    "paused_at": null,
    "segmentation_criteria_id": 1,
    "track_links": true,
    "track_opens": true,
    "trigger": "subscription",
    "trigger_campaign_to_open_id": null,
    "trigger_include_subscribers_from_import": false,
    "trigger_run_on_api": false,
    "triggered_on": "2014-06-30",
    "url_domain_id": 1,
    "use_external_delivery_setting": true,
    "virtual_mta_id": 0,
    "content_format": "html",
    "content_subject": "Welcome to our mailing list!",
    "content_html": "<p>Welcome!</p>"
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "a8b71350b39af606469bc672096ca0ac"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=9ae77aeb60e739aeacf0188153217822; path=/; HttpOnly
< X-Request-Id: 5821e8d46350c5d54f3eceb23ab70235
< X-Runtime: 0.148615
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "bounce_email_domain_id": 1,
    "bounce_email_user_id": 1,
    "delay": "immediately",
    "delay_amount": 0,
    "delay_time": 0,
    "delay_unit": null,
    "from_email": "bob@example.com",
    "from_name": "Bob Example",
    "id": 1,
    "mailing_list_id": 1,
    "name": "Autoresponder 2",
    "paused": false,
    "paused_at": null,
    "segmentation_criteria_id": 1,
    "track_links": true,
    "track_opens": true,
    "trigger": "subscription",
    "trigger_campaign_to_open_id": null,
    "trigger_include_subscribers_from_import": false,
    "trigger_run_on_api": false,
    "triggered_on": null,
    "url_domain_id": 1,
    "use_external_delivery_setting": true,
    "virtual_mta_id": 0
  },
  "error_code": null,
  "error_message": null
}
```

### Get statistics for an autoresponder

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/autoresponders/:id/statistics
    GET /ga/api/v2/mailing_lists/:mailing_list_id/autoresponders/:id/statistics?start_date=20140302&end_date=20140401

#### Request Parameters

| Key             | Meaning                                                                                                                                                 | Example             |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------- |
| mailing_list_id | The id of the mailing list the subscribers are on. This can be found on the mailing list's page under the "Admin" section                               | 456                 |
| id              | The id of the autoresponder                                                                                                                             | 12345               |
| start_date      | The earliest date that email was sent for the requested statistics. The result will include statistics for emails sent on this date. This can be blank. | 20140403 (YYYYMMDD) |
| end_date        | The latest date that email was sent for the requested statistics. The result will include statistics for emails sent on this date. This can be blank.   | 20140403 (YYYYMMDD) |

#### Response

The response will be a JSON object in the format below.

| Key                    | Meaning                                                                       | Example | Type    |
| ---------------------- | ----------------------------------------------------------------------------- | ------- | ------- |
| id                     | The autoresponder's ID                                                        | 99123   | Integer |
| sent_text              | Number of recipients that were sent a text-only message                       | 1       | Integer |
| sent_html              | Number of recipients that were sent a html-only message                       | 1       | Integer |
| sent_multipart         | Number of recipients that were sent a multipart message                       | 1       | Integer |
| bounces_total          | Total number of bounces received                                              | 1       | Integer |
| bounces_unique         | Unique (by subscriber) bounces received                                       | 1       | Integer |
| bounces_unique_hard    | Number of unique (by subscriber) bounces where bounce_type is hard            | 1       | Integer |
| bounces_unique_soft    | Number of unique (by subscriber) bounces where bounce_type is soft            | 1       | Integer |
| bounces_unique_other   | Number of unique (by subscriber) bounces where bounce_type is other           | 1       | Integer |
| bounces_unique_local   | Number of unique (by subscriber) bounces that were local                      | 1       | Integer |
| bounces_unique_remote  | Number of unique (by subscriber) bounces that were remote                     | 1       | Integer |
| clicks_total           | Number of total clicks                                                        | 1       | Integer |
| clicks_unique          | Number of unique clicks (unique by subscriber)                                | 1       | Integer |
| clicks_unique_by_link  | Number of unique clicks (unique by subscriber/link)                           | 1       | Integer |
| opens_total            | Number of total opens                                                         | 1       | Integer |
| opens_unique           | Number of unique opens (unique by subscriber)                                 | 1       | Integer |
| scomps_total           | Number of scomps (spam complaints)                                            | 1       | Integer |
| scomps_unique          | Number of unique scomps (unique by subscriber)                                | 1       | Integer |
| scomps_status_updated  | Number of recipients where the status was updated to status 'scomp'           | 1       | Integer |
| unsubs_total           | Number of total unsubscribes                                                  | 1       | Integer |
| unsubs_unique          | Number of unique unsubscribes (unique by subscriber)                          | 1       | Integer |
| unsubs_status_updated  | Number of recipients where the status was updated to status 'unsubscribed'    | 1       | Integer |
| bounces_status_updated | Number of recipients where status was updated to status 'bounce'              | 1       | Integer |
| bounces_unique_by_code | Number of unique (by subscriber) bounces for each bounce code                 | {}      | Hash    |
| smtp_success           | The number of messages that were successfully delivered to the remote server. | 1       | Integer |

#### Example Request

    > GET /ga/api/v2/mailing_lists/1/autoresponders/1/statistics HTTP/1.1
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
       "success":true,
       "data":{
          "sent_text":3,
          "sent_html":137,
          "sent_multipart":137,
          "bounces_total":2,
          "bounces_unique":2,
          "bounces_unique_hard":2,
          "bounces_unique_soft":0,
          "bounces_unique_other":0,
          "bounces_unique_local":0,
          "bounces_unique_remote":2,
          "clicks_total":22,
          "clicks_unique":22,
          "clicks_unique_by_link":22,
          "opens_total":299,
          "opens_unique":101,
          "scomps_total":2,
          "scomps_unique":2,
          "scomps_status_updated":2,
          "unsubs_total":30,
          "unsubs_unique":23,
          "unsubs_status_updated":0,
          "bounces_status_updated":0,
          "total_messages":0,
          "total_success":0,
          "total_failure":0,
          "total_failure_toolong":0,
          "bounces_unique_by_code":{
             "200":1,
             "209":1
          },
          "messages_sent":277,
          "messages_html":274,
          "messages_text":3,
          "accepted":275,
          "accepted_rate":0.9927797833935018,
          "in_queue":0,
          "in_queue_rate":0.0,
          "max_unique_activities":101,
          "open_rate":0.36727272727272725,
          "open_ratio":2.9603960396039604,
          "unopened":174,
          "duplicate_opens":198,
          "duplicate_clicks":0,
          "click_rate":0.08,
          "click_to_open_rate":0.21782178217821782,
          "unclicked":253,
          "bounced":2,
          "duplicate_bounces":0,
          "unbounced":275,
          "bounce_rate":0.007220216606498195,
          "bounce_rate_hard":1.0,
          "bounce_rate_soft":0.0,
          "bounce_rate_other":0.0,
          "bounce_local_rate":0.0,
          "duplicate_scomps":0,
          "duplicate_unsubs":7,
          "unsub_rate":0.08363636363636363
       },
       "error_code":null,
       "error_message":null
    }
