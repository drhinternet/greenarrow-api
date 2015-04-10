<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Campaigns](#campaigns)
  - [Get a list of campaigns](#get-a-list-of-campaigns)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)
  - [Get campaign details](#get-campaign-details)
    - [URL](#url-1)
    - [URL (Get campaign details by Stat ID instead of Campaign ID)](#url-get-campaign-details-by-stat-id-instead-of-campaign-id)
    - [Request Parameters](#request-parameters-1)
    - [Response](#response-1)
    - [Example Request](#example-request-1)
  - [Create a new campaign](#create-a-new-campaign)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-2)
    - [Ad Hoc Segmentation Criteria](#ad-hoc-segmentation-criteria)
      - [In Mailing List](#in-mailing-list)
    - [Response](#response-2)
    - [Example Request](#example-request-2)
    - [Example code](#example-code)
  - [Update an existing campaign](#update-an-existing-campaign)
    - [URL](#url-3)
    - [URL (Update campaign details by Stat ID instead of Campaign ID)](#url-update-campaign-details-by-stat-id-instead-of-campaign-id)
    - [Request Parameters](#request-parameters-3)
    - [Response](#response-3)
    - [Example Request](#example-request-3)
  - [Pause a campaign](#pause-a-campaign)
    - [URL](#url-4)
    - [URL (Pause campaign a campaign by Stat ID instead of Campaign ID)](#url-pause-campaign-a-campaign-by-stat-id-instead-of-campaign-id)
    - [Request Parameters](#request-parameters-4)
    - [Response](#response-4)
    - [Example Request](#example-request-4)
  - [Resume a campaign](#resume-a-campaign)
    - [URL](#url-5)
    - [URL (Resume a campaign by Stat ID instead of Campaign ID)](#url-resume-a-campaign-by-stat-id-instead-of-campaign-id)
    - [Request Parameters](#request-parameters-5)
    - [Response](#response-5)
    - [Example Request](#example-request-5)
  - [Get campaign per-link statistics](#get-campaign-per-link-statistics)
    - [URL](#url-6)
    - [Request Parameters](#request-parameters-6)
    - [Pagination](#pagination)
    - [Response](#response-6)
    - [Example Request](#example-request-6)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Campaigns

### Get a list of campaigns

Get a list of the basic details of all campaigns of a particular mailing list.

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/campaigns

#### Request Parameters

| Key                 | Description                                                                      |
| ------------------- | -------------------------------------------------------------------------------- |
| `started_at__start` | A UNIX integer timestamp representing the earliest `started_at` time to include. |
| `started_at__end`   | A UNIX integer timestamp representing the latest `started_at` time to include.   |

The `started_at__start` and `started_at__end` parameters allow you to filter
the results returned by this API. Providing either of these keys will result in
**only** `sending`, `finished`, `cancelled`, or `failed` campaigns to be
included in the results.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key                        | Meaning                                                                                                                                  | Example              | Type     |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- | -------------------- | -------- |
| name                       | The name of the Campaign                                                                                                                 | "Campaign 1"         | String   |
| mailing_list_id            | The id of a Mailing List the Campaign belongs to                                                                                         | 1                    | Integer  |
| mailing_list_name          | The name of a Mailing List the Campaign belongs to                                                                                       | "Mailing List 1"     | String   |
| dispatch                   | Inline object containing delivery settings of the Campaign;  Comes from the server only if delivery settings of the Campaign are defined | {}                   | Hash     |
| dispatch.state             | The state of delivery; Can be one of: "idle", "scheduled", "sending", "finished", "failed", "cancelled"                                  | "failed"             | String   |
| dispatch.state_description | Localized textual description of the state                                                                                               | "Step 2: Scheduled"  | String   |
| dispatch.paused            | Marks whether the Campaign has been paused                                                                                               | false                | Boolean  |
| dispatch.begins_at         | Time to start delivery at                                                                                                                | 2013-01-01T00:00:00Z | DateTime |
| dispatch.started_at        | Time when delivery actually started                                                                                                      | 2013-01-01T00:00:00Z | DateTime |
| dispatch.finished_at       | Time when delivery has finished                                                                                                          | 2013-01-01T00:00:00Z | DateTime |

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/mailing_lists/1/campaigns HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    {  "name": "My New Campaign"  "mailing_list_id": }< HTTP/1.1 200 OK
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
          "content_html" : "",
          "stats" : null,
          "segmentation_criteria_id" : null,
          "created_at" : "2013-08-24T08:23:34Z",
          "organization_id" : 1,
          "mailing_list_name" : "test",
          "archived" : false,
          "content_determined" : true,
          "mailing_list_id" : 1,
          "content_subject" : "asdfadsf",
          "active_html_editor" : "ckeditor",
          "email_format" : "html",
          "content_text" : "",
          "updated_at" : "2013-08-26T11:37:45Z",
          "organization_name" : "System Organization",
          "name" : "test 1"
        }
      ]
    }


### Get campaign details

Get details of particular campaign belonging to a particular mailing list.

#### URL

    GET /ga/api/v2/campaigns/:campaign_id

#### URL (Get campaign details by Stat ID instead of Campaign ID)

    GET /ga/api/v2/campaigns/by_stat/:stat_id

#### Request Parameters

This API method does not require any additional parameters.

#### Response

| Key                                 | Meaning                                                                                                                                                                                 | Example                         | Type     |
| ----------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- | -------- |
| *name*                              | *The name of the Campaign*                                                                                                                                                              | *"Campaign 1"*                  | *String* |
| mailing_list_id                     | The id of a Mailing List the Campaign belongs to                                                                                                                                        | 1                               | Integer  |
| mailing_list_name                   | The name of a Mailing List the Campaign belongs to                                                                                                                                      | "Mailing List 1"                | String   |
| content_html                        | HTML content                                                                                                                                                                            | "<b>content</b>"                | String   |
| content_text                        | Text content                                                                                                                                                                            | "content"                       | String   |
| email_format                        | Email format to deliver                                                                                                                                                                 | "html"                          | String   |
| content_subject                     | Email subject to use                                                                                                                                                                    | "Hey there\!"                   | String   |
| active_html_editor                  | The keyword of active editor to be used on the form page for the Campaign; Can be one of: "ckeditor", "textarea"                                                                        | "ckeditor"                      | String   |
| segmentation_criteria_id            | The id of a Segmentation Criteria the Campaign should be filtered by                                                                                                                    | 1                               | Integer  |
| dispatch                            | Inline object containing delivery settings of the Campaign; Comes from the server only if delivery settings of the Campaign are defined                                                 | {}                              | Hash     |
| dispatch.state                      | The state of delivery; Can be one of: "idle", "scheduled", "sending", "finished", "failed", "cancelled"                                                                                 | "failed"                        | String   |
| dispatch.state_description          | Localized textual description of the state                                                                                                                                              | "Step 2: Scheduled"             | String   |
| dispatch.virtual_mta_id             | The id of a Virtual MTA explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting                                                                | 1                               | Integer  |
| dispatch.virtual_mta_name           | The name of a Virtual MTA explicitly assigned to the Campaign                                                                                                                           | "MTA 1"                         | String   |
| dispatch.bounce_email_id            | The id of a Bounce Email explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting                                                               | 1                               | Integer  |
| dispatch.bounce_email_name          | The Bounce Email explicitly assigned to the Campaign                                                                                                                                    | "no@reply.com"                  | String   |
| dispatch.url_domain_id              | The id of an URL domain explicitly assigned to the Campaign                                                                                                                             | 1                               | Integer  |
| dispatch.url_domain_name            | The URL domain explicitly assigned to the Campaign                                                                                                                                      | "example.com"                   | String   |
| dispatch.seed_list_id               | Deprecated: The ID of the first seed list assigned to the Campaign, ordered by ID. Use `seed_lists` instead.                                                                            | 1                               | Integer  |
| dispatch.seed_list_name             | Deprecated: The name of the first seed list assigned to the Campaign, ordered by ID. Use `seed_lists` instead.                                                                          | "Seed List 1"                   | String   |
| dispatch.seed_lists                 | An array of seed lists assigned to the Campaign, where each entry is a hash with `id` and `name` keys.                                                                                  | `[{"id": 1, "name": "S2"}]`     | Array    |
| dispatch.speed                      | Maximum throughput speed; 0 for unlimited throughput                                                                                                                                    | 0                               | Integer  |
| dispatch.track_opens                | Marks whether the Campaign will track openings stats                                                                                                                                    | true                            | Boolean  |
| dispatch.track_links                | Marks whether the Campaign will track clicks stats                                                                                                                                      | true                            | Boolean  |
| dispatch.paused                     | Marks whether the Campaign has been paused                                                                                                                                              | false                           | Boolean  |
| dispatch.from_name                  | Name to use in the "From:" field                                                                                                                                                        | "John Doe"                      | String   |
| dispatch.from_email                 | Email to use in the "From:" field                                                                                                                                                       | "john.doe@example.com"          | String   |
| dispatch.reply_to                   | Email to use in the "ReplyTo:" field                                                                                                                                                    | "john.doe@example.com"          | String   |
| dispatch.begins_at                  | Time to start delivery at                                                                                                                                                               | 2013-01-01T00:00:00Z            | DateTime |
| dispatch.started_at                 | Time when delivery actually started                                                                                                                                                     | 2013-01-01T00:00:00Z            | DateTime |
| dispatch.finished_at                | Time when delivery has finished                                                                                                                                                         | 2013-01-01T00:00:00Z            | DateTime |
| dispatch.autowinner_enabled         | The campaign is configured to use automatic winner selection (Note: For automatic winner selection to be used, this must be enabled _and_ the campaign must have more than one content) | true/false                      | Boolean  |
| dispatch.autowinner_percentage      | The percentage that will be sent for the split-test portion of the campaign (Note: This value is returned as a string to prevent floating-point conversion errors.)                     | "25.0"                          | String   |
| dispatch.autowinner_delay_amount    | The number of units of time that the campaign will wait before finishing after a split-test.                                                                                            | 25                              | Integer  |
| dispatch.autowinner_delay_unit      | The unit used in calculating the delay duration.                                                                                                                                        | "minutes", "hours", "days"      | String   |
| dispatch.autowinner_metric          | The metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                                                                          | "clicks_unique", "opens_unique" | String   |
| stat_summary                        | Basic campaign statistics                                                                                                                                                               | {}                              | Hash     |
| stat_summary.sent_text              | Number of recipients that were sent a text-only message                                                                                                                                 | 1                               | Integer  |
| stat_summary.sent_html              | Number of recipients that were sent a html-only message                                                                                                                                 | 1                               | Integer  |
| stat_summary.sent_multipart         | Number of recipients that were sent a multipart message                                                                                                                                 | 1                               | Integer  |
| stat_summary.bounces_total          | Total number of bounces received                                                                                                                                                        | 1                               | Integer  |
| stat_summary.bounces_unique         | Unique (by subscriber) bounces received                                                                                                                                                 | 1                               | Integer  |
| stat_summary.bounces_unique_hard    | Number of unique (by subscriber) bounces where bounce_type is hard                                                                                                                      | 1                               | Integer  |
| stat_summary.bounces_unique_soft    | Number of unique (by subscriber) bounces where bounce_type is soft                                                                                                                      | 1                               | Integer  |
| stat_summary.bounces_unique_other   | Number of unique (by subscriber) bounces where bounce_type is other                                                                                                                     | 1                               | Integer  |
| stat_summary.bounces_unique_local   | Number of unique (by subscriber) bounces that were local                                                                                                                                | 1                               | Integer  |
| stat_summary.bounces_unique_remote  | Number of unique (by subscriber) bounces that were remote                                                                                                                               | 1                               | Integer  |
| stat_summary.clicks_total           | Number of total clicks                                                                                                                                                                  | 1                               | Integer  |
| stat_summary.clicks_unique          | Number of unique clicks (unique by subscriber)                                                                                                                                          | 1                               | Integer  |
| stat_summary.clicks_unique_by_link  | **Deprecated** Number of unique clicks (unique by subscriber/link) -- this value does not carry much meaning -- see the Links endpoint below                                            | 1                               | Integer  |
| stat_summary.opens_total            | Number of total opens                                                                                                                                                                   | 1                               | Integer  |
| stat_summary.opens_unique           | Number of unique opens (unique by subscriber)                                                                                                                                           | 1                               | Integer  |
| stat_summary.scomps_total           | Number of scomps (spam complaints)                                                                                                                                                      | 1                               | Integer  |
| stat_summary.scomps_unique          | Number of unique scomps (unique by subscriber)                                                                                                                                          | 1                               | Integer  |
| stat_summary.scomps_status_updated  | Number of recipients where the status was updated to status 'scomp'                                                                                                                     | 1                               | Integer  |
| stat_summary.unsubs_total           | Number of total unsubscribes                                                                                                                                                            | 1                               | Integer  |
| stat_summary.unsubs_unique          | Number of unique unsubscribes (unique by subscriber)                                                                                                                                    | 1                               | Integer  |
| stat_summary.unsubs_status_updated  | Number of recipients where the status was updated to status 'unsubscribed'                                                                                                              | 1                               | Integer  |
| stat_summary.bounces_status_updated | Number of recipients where status was updated to status 'bounce'                                                                                                                        | 1                               | Integer  |
| stat_summary.bounces_unique_by_code | Number of unique (by subscriber) bounces for each bounce code                                                                                                                           | {}                              | Hash     |
| stat_summary.smtp_success           | The number of messages that were successfully delivered to the remote server.                                                                                                           | 1                               | Integer  |

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/mailing_lists/1/campaigns/1 HTTP/1.1
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
      "data" : {
        "id" : 1,
        "content_html" : "",
        "stats" : null,
        "segmentation_criteria_id" : 1,
        "created_at" : "2013-08-24T08:23:34Z",
        "organization_id" : 1,
        "mailing_list_name" : "test",
        "archived" : false,
        "content_determined" : true,
        "mailing_list_id" : 1,
        "content_subject" : "asdfadsf",
        "active_html_editor" : "ckeditor",
        "email_format" : "html",
        "content_text" : "",
        "updated_at" : "2013-08-26T11:37:45Z",
        "organization_name" : "System Organization",
        "name" : "test 1"
      },
      "error_code" : null,
      "success" : true
    }


### Create a new campaign

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/campaigns

#### Request Parameters

The POST request should have a JSON document in its payload with at least keys that marked with bold in the following list:

| Key                                                                 | Meaning                                                                                                                                 | Example                                                                                                                | Type     |
| ------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- | -------- |
| campaign.name                                                       | The name of the campaign                                                                                                                | "Campaign 1"                                                                                                           | String   |
| campaign.mailing_list_id                                            | The id of a Mailing List the Campaign belongs to                                                                                        | 1                                                                                                                      | Integer  |
| campaign.mailing_list_name                                          | The name of a Mailing List the Campaign belongs to                                                                                      | "Mailing List 1"                                                                                                       | String   |
| campaign.campaign_contents_attributes                               | An array of hashes with content details                                                                                                 | `{ name: "Content A", content_attributes: { format: "html", subject: "My Subj", html: "My HTML Content", text: "" } }` | Hash     |
| campaign.campaign_contents_attributes[x].content_attributes.html    | HTML content                                                                                                                            | "<b>content</b>"                                                                                                       | String   |
| campaign.campaign_contents_attributes[x].content_attributes.text    | Text content                                                                                                                            | "content"                                                                                                              | String   |
| campaign.campaign_contents_attributes[x].content_attributes.format  | Email format to deliver                                                                                                                 | "html"                                                                                                                 | String   |
| campaign.campaign_contents_attributes[x].content_attributes.subject | Email subject to use                                                                                                                    | "Hey there\!"                                                                                                          | String   |
| campaign.active_html_editor                                         | The keyword of active editor to be used on the form page for the Campaign; Can be one of: "ckeditor", "textarea"                        | "ckeditor"                                                                                                             | String   |
| campaign.segmentation_criteria_id                                   | The id of a Segmenetation Criteria                                                                                                      | 1                                                                                                                      | Integer  |
| campaign.segmentation_criteria_ad_hoc                               | An ad hoc segmentation criteria specification - see the "Ad Hoc Segmentation Criteria" section below for more details                   | [ ]                                                                                                                    | Array    |
| campaign.dispatch_attributes                                        | Inline object containing delivery settings of the Campaign; Comes from the server only if delivery settings of the Campaign are defined | {}                                                                                                                     | Hash     |
| campaign.dispatch_attributes.state                                  | The state of delivery; Can be one of: "idle", "scheduled", "sending", "finished", "failed", "cancelled"                                 | "failed"                                                                                                               | String   |
| campaign.dispatch_attributes.state_description                      | Localized textual description of the state                                                                                              | "Step 2: Scheduled"                                                                                                    | String   |
| campaign.dispatch_attributes.virtual_mta_id                         | The id of a Virtual MTA explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting                | 1                                                                                                                      | Integer  |
| campaign.dispatch_attributes.virtual_mta_name                       | The name of a Virtual MTA explicitly assigned to the Campaign                                                                           | "MTA 1"                                                                                                                | String   |
| campaign.dispatch_attributes.bounce_email_id                        | The id of a Bounce Email explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting               | 1                                                                                                                      | Integer  |
| campaign.dispatch_attributes.bounce_email_name                      | The Bounce Email explicitly assigned to the Campaign                                                                                    | "no@reply.com"                                                                                                         | String   |
| campaign.dispatch_attributes.url_domain_id                          | The id of an URL domain explicitly assigned to the Campaign                                                                             | 1                                                                                                                      | Integer  |
| campaign.dispatch_attributes.url_domain_name                        | The URL domain explicitly assigned to the Campaign                                                                                      | "example.com"                                                                                                          | String   |
| campaign.dispatch_attributes.seed_list_id                           | Deprecated: The ID of the first seed list assigned to the Campaign, ordered by ID. Use `seed_lists` instead.                            | 1                                                                                                                      | Integer  |
| campaign.dispatch_attributes.seed_list_name                         | Deprecated: The name of the first seed list assigned to the Campaign, ordered by ID. Use `seed_lists` instead.                          | "Seed List 1"                                                                                                          | String   |
| campaign.dispatch_attributes.seed_list_ids                          | An array of seed lists assigned to the Campaign, where each entry is the ID of a seed list to use.                                      | `[ 1, 2, 3 ]`                                                                                                          | Array    |
| campaign.dispatch_attributes.seed_list_names                        | An array of seed lists assigned to the Campaign, where each entry is the name of a seed list to use.                                    | `[ "Seed List", "Two" ]`                                                                                               | Array    |
| campaign.dispatch_attributes.speed                                  | Maximum throughput speed; 0 for unlimited throughput                                                                                    | 0                                                                                                                      | Integer  |
| campaign.dispatch_attributes.track_opens                            | Marks whether the Campaign will track openings stats                                                                                    | true                                                                                                                   | Boolean  |
| campaign.dispatch_attributes.track_links                            | Marks whether the Campaign will track clicks stats                                                                                      | true                                                                                                                   | Boolean  |
| campaign.dispatch_attributes.paused                                 | Marks whether the Campaign has been paused                                                                                              | false                                                                                                                  | Boolean  |
| campaign.dispatch_attributes.from_name                              | Name to use in the "From:" field                                                                                                        | "John Doe"                                                                                                             | String   |
| campaign.dispatch_attributes.from_email                             | Email to use in the "From:" field                                                                                                       | "john.doe@example.com"                                                                                                 | String   |
| campaign.dispatch_attributes.reply_to                               | Email to use in the "ReplyTo:" field                                                                                                    | "john.doe@example.com"                                                                                                 | String   |
| campaign.dispatch_attributes.begins_at                              | Time to start delivery at                                                                                                               | 2013-01-01T00:00:00Z                                                                                                   | DateTime |
| campaign.dispatch_attributes.started_at                             | Time when delivery actually started                                                                                                     | 2013-01-01T00:00:00Z                                                                                                   | DateTime |
| campaign.dispatch_attributes.autowinner_enabled                     | The campaign is configured to use automatic winner selection.                                                                           | true/false                                                                                                             | Boolean  |
| campaign.dispatch_attributes.autowinner_percentage                  | The percentage that will be sent for the split-test portion of the campaign. See note (1) below.                                        | "25.0"                                                                                                                 | String   |
| campaign.dispatch_attributes.autowinner_delay_amount                | The number of units of time that the campaign will wait before finishing after a split-test.                                            | 25                                                                                                                     | Integer  |
| campaign.dispatch_attributes.autowinner_delay_unit                  | The unit used in calculating the delay duration.                                                                                        | "minutes", "hours", "days"                                                                                             | String   |
| campaign.dispatch_attributes.autowinner_metric                      | The metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                          | "clicks_unique", "opens_unique"                                                                                        | String   |
| source_template_id                                                  | The id of campaign template to base on                                                                                                  | Integer  |

1. This value is returned as a string to prevent floating-point conversion errors.
   You may send this value as an Integer, Float or String. Posting a value with
   more than 2 decimals will cause a validation error. Be careful because IEEE
   floating point can not exactly represent some decimal values. For example 94.85
   is represented as 94.85000000000001 which will cause a validation error if used
   here. You may want to print to a string using two decimals of precision.
2. Only one of `seed_list_id`, `seed_list_name`, `seed_list_ids`, and
   `seed_list_names` may be present in a single request.
3. Assigning to the deprecated fields `seed_list_id` or `seed_list_name` will
   assign the entire list of seed lists to the provided value, overwriting one or
   more seed lists that were already in use.

#### Ad Hoc Segmentation Criteria

An ad hoc segmentation criteria may be specified to generate a basic
segmentation criteria for a campaign.

The ad hoc segmentation criteria is an array of clauses, all of which must be
true for each subscriber record to be included in the campaign.

Specifying an empty array `[]` is equivalent to sending to "All Active Subscribers".

##### In Mailing List

An ad hoc segment may include a clause restricting the included subscribers to
those whose email address exists on another mailing list.

Example:

```json
{
  "segmentation_criteria_ad_hoc": [
    { "type": "in_mailing_list", "operator": "is_in", "mailing_list_id": 12 }
  ]
}
```

This campaign would be sent to "All Active Subscribers whose email address exists on mailing list #12".

Example with multiple clauses:

```json
{
  "segmentation_criteria_ad_hoc": [
    { "type": "in_mailing_list", "operator": "is_in", "mailing_list_id": 12 },
    { "type": "in_mailing_list", "operator": "is_not_in", "mailing_list_id": 14 }
  ]
}
```

This campaign would be sent to "All Active Subscribers whose email address exists on mailing list #12 AND NOT in mailing list #14".

#### Response

A successful response will return the campaign record using the format described in the "Get campaign details" section of the API.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```
> POST /ga/api/mailing_lists/1/campaigns HTTP/1.1
> Authorization: Basic MTo1MjliODY5YzllNmE3YmFjY2M2NDdmYTg2OTlhMDA2ZGNiNzlkMTA1
> Accept: application/json
> Content-Type: application/json

{
  "campaign": {
    "name": "Daily Update 2015-01-22",
    "campaign_contents_attributes": [
      {
        "content_attributes": {
          "format": "html",
          "subject": "Daily Update Email",
          "html": "hello world"
        }
      }
    ],
    "segmentation_criteria_ad_hoc": [
    ],
    "dispatch_attributes": {
      "from_email": "from@example.com",
      "from_name": "From Example",
      "speed": 0,
      "virtual_mta_id": 0,
      "bounce_email_id": "1@1",
      "url_domain_id": 1,
      "begins_at": "2015-01-22 11:10AM CST",
      "track_opens": true,
      "track_links": true
    }
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "aca97539bce08474cf9b54efb0168cc9"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=6d52a26884763951a2a4d60caceb13dd; path=/; HttpOnly
< X-Request-Id: afc18b45c9c19b2601df84733bc5739b
< X-Runtime: 0.126468
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "active_html_editor": "ckeditor",
    "archived": false,
    "content_determined": true,
    "created_at": "2015-04-10T16:03:17Z",
    "id": 4,
    "mailing_list_id": 1,
    "name": "Daily Update 2015-01-22",
    "organization_id": 1,
    "segmentation_criteria_id": 4,
    "template": false,
    "updated_at": "2015-04-10T16:03:17Z",
    "mailing_list_name": "Default Mailing List",
    "organization_name": "System Organization",
    "stat_summary": null,
    "dispatch": {
      "autowinner_delay_amount": null,
      "autowinner_delay_unit": "minutes",
      "autowinner_enabled": false,
      "autowinner_metric": null,
      "autowinner_percentage": null,
      "begins_at": "2015-01-22T17:10:00Z",
      "finished_at": null,
      "from_email": "from@example.com",
      "from_name": "From Example",
      "paused": false,
      "reply_to": null,
      "sender_email": null,
      "speed": 0,
      "started_at": null,
      "state": "scheduled",
      "track_links": true,
      "track_opens": true,
      "url_domain_id": 1,
      "virtual_mta_id": 0,
      "state_description": "Step 2: Scheduled",
      "virtual_mta_name": "System Default Route",
      "virtual_mta_type": "default_route",
      "bounce_email_user_id": 1,
      "bounce_email_domain_id": 1,
      "bounce_email_email": "return@example.com",
      "url_domain_domain": "example.com",
      "seed_lists": [

      ],
      "seed_list_id": null,
      "seed_list_name": null
    },
    "campaign_contents": [
      {
        "id": 3,
        "name": "Content A",
        "subject": "Daily Update Email",
        "html": "hello world",
        "text": "",
        "format": "html"
      }
    ]
  },
  "error_code": null,
  "error_message": null
}
```

#### Example code

* [Create a new campaign](../examples/create_a_new_campaign.php)

### Update an existing campaign

#### URL

    PUT /ga/api/v2/campaigns/:campaign_id

#### URL (Update campaign details by Stat ID instead of Campaign ID)

    PUT /ga/api/v2/campaigns/by_stat/:stat_id

#### Request Parameters

The PUT request should have a JSON document in its payload with the format described in the "Create a new campaign" section of the API.

#### Response

A successful response will return the campaign record using the format described in the "Get campaign details" section of the API.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > PUT /ga/api/v2/mailing_lists/1/campaigns/1 HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    {
      "campaign": {
        "name": "My New Campaign"
      },
      "mailing_list_id": 1
    }
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
      "data" : {
        "id" : 3,
        "content_html" : "",
        "stats" : null,
        "segmentation_criteria_id" : null,
        "created_at" : "2013-09-02T16:01:49Z",
        "organization_id" : 1,
        "mailing_list_name" : "test",
        "archived" : false,
        "content_determined" : false,
        "mailing_list_id" : 1,
        "content_subject" : "",
        "active_html_editor" : "ckeditor",
        "email_format" : "html",
        "content_text" : "",
        "updated_at" : "2013-09-02T16:01:49Z",
        "organization_name" : "System Organization",
        "name" : "My New Campaign"
      },
      "error_code" : null,
      "success" : true
    }


### Pause a campaign

#### URL

    POST /ga/api/v2/campaigns/:campaign_id/pause

#### URL (Pause campaign a campaign by Stat ID instead of Campaign ID)

    POST /ga/api/v2/campaigns/by_stat/:stat_id/pause

#### Request Parameters

This API method does not require any additional parameters.

#### Response

A successful response will return the campaign record using the format described in the "Get campaign details" section of the API.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > POST /ga/api/v2/mailing_lists/1/campaigns/1/pause HTTP/1.1
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
      "data" : {
        "mailing_list_name" : "adsfadf",
        "content_subject" : "asdfadf",
        "content_text" : "",
        "updated_at" : "2013-09-02T16:26:45Z",
        "segmentation_criteria_id" : null,
        "archived" : false,
        "active_html_editor" : "ckeditor",
        "name" : "asdf",
        "content_html" : "<html>\n<head>\n\t<title></title>\n</head>\n<body>\n<p>adfadf</p>\n</body>\n</html>\n",
        "content_determined" : true,
        "id" : 4,
        "organization_id" : 1,
        "organization_name" : "System Organization",
        "dispatch" : {
          "reply_to" : "",
          "seed_list_id" : null,
          "seed_list_name" : null,
          "seed_lists" : [],
          "paused" : true,
          "virtual_mta_id" : 0,
          "from_email" : "foo@example.com",
          "speed" : 0,
          "state_description" : "Step 1: Pending",
          "track_opens" : true,
          "sender_email" : "",
          "state" : "idle",
          "from_name" : "Fo",
          "url_domain_id" : 1,
          "virtual_mta_type" : "default_route",
          "virtual_mta_name" : "System Default Route",
          "finished_at" : null,
          "bounce_email_user_id" : 1,
          "bounce_email_domain_id" : 1,
          "bounce_email_email" : "test@test",
          "started_at" : null,
          "url_domain_domain" : "test",
          "begins_at" : null,
          "autowinner_enabled": true,
          "autowinner_percentage": "25.0",
          "autowinner_delay_amount": 10,
          "autowinner_delay_unit": "hours",
          "autowinner_metric": "opens_unique",
        },
        "stats" : null,
        "mailing_list_id" : 1,
        "email_format" : "html",
        "created_at" : "2013-09-02T16:25:57Z"
      },
      "error_code" : null,
      "success" : true
    }


### Resume a campaign

#### URL

    POST /ga/api/v2/campaigns/:campaign_id/resume

#### URL (Resume a campaign by Stat ID instead of Campaign ID)

    POST /ga/api/v2/campaigns/by_stat/:stat_id/resume

#### Request Parameters

This API method does not require any additional parameters.

#### Response

A successful response will return the campaign record using the format described in the "Get campaign details" section of the API.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > POST /ga/api/v2/mailing_lists/1/campaigns/1/resume HTTP/1.1
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
      "data" : {
        "mailing_list_name" : "adsfadf",
        "content_subject" : "asdfadf",
        "content_text" : "",
        "updated_at" : "2013-09-02T16:26:45Z",
        "segmentation_criteria_id" : 1,
        "archived" : false,
        "active_html_editor" : "ckeditor",
        "name" : "asdf",
        "content_html" : "<html>\n<head>\n\t<title></title>\n</head>\n<body>\n<p>adfadf</p>\n</body>\n</html>\n",
        "content_determined" : true,
        "id" : 4,
        "organization_id" : 1,
        "organization_name" : "System Organization",
        "dispatch" : {
          "reply_to" : "",
          "seed_list_id" : null,
          "seed_list_name" : null,
          "seed_lists" : [],
          "paused" : false,
          "virtual_mta_id" : 0,
          "from_email" : "foo@example.com",
          "speed" : 0,
          "state_description" : "Step 1: Pending",
          "track_opens" : true,
          "sender_email" : "",
          "state" : "idle",
          "from_name" : "Fo",
          "url_domain_id" : 1,
          "virtual_mta_type" : "default_route",
          "virtual_mta_name" : "System Default Route",
          "finished_at" : null,
          "bounce_email_user_id" : 1,
          "bounce_email_domain_id" : 1,
          "bounce_email_email" : "test@test",
          "started_at" : null,
          "url_domain_domain" : "test",
          "begins_at" : null,
          "autowinner_enabled": true,
          "autowinner_percentage": "25.0",
          "autowinner_delay_amount": 10,
          "autowinner_delay_unit": "hours",
          "autowinner_metric": "opens_unique",
        },
        "stats" : null,
        "mailing_list_id" : 1,
        "email_format" : "html",
        "created_at" : "2013-09-02T16:25:57Z"
      },
      "error_code" : null,
      "success" : true
    }



### Get campaign per-link statistics

Get statistics for this campaign, broken down per-link.

Campaigns generate link entries during delivery. Thus if a campaign hasn't yet
delivered, this API will return an empty list.

#### URL

    GET /ga/api/v2/campaigns/:campaign_id/link_stats

#### Request Parameters

Optional Parameters

| Key        | Meaning                                                                                                                     |
| ---------- | --------------------------------------------------------------------------------------------------------------------------- |
| `url`      | If specified, only return links to the specified URL. The specified URL may contain wildcards (`*`) to match multiple URLs. |

* The value of the `url` parameter must be URI encoded.

#### Pagination

The links returned by this API are sorted first by their case-insensitive
`url`, then by `link_id`.

To query additional records, provide `page` and `per_page` parameters. The
`page` parameter starts at `0`.  The `per_page` parameter defaults to `100` and
the maximum allowed is `500`.

For example to get the second page:

    GET /ga/api/v2/campaigns/:campaign_id/link_stats?scope=all&page=1&per_page=100

The response will also contain the following extra parameters:

| Key           | Description                                      |
| ------------- | ------------------------------------------------ |
| `page`        | The current page number                          |
| `per_page`    | The number of records per page                   |
| `num_records` | The total number of records that match the query |
| `num_pages`   | The total number of pages that match the query   |

#### Response

<table>
  <tr>
    <td><b>all_unclicked_links_recorded</b><br><em>bool</em></td>
    <td>
      <p>
        If this value is false, the list of links available via this API is not
        a comprehensive list of links that were delivered in this campaign.
        Some links that have not received clicks may not be present. Links that
        have received at least one click will always be available in this API,
        regardless of the value of <code>all_unclicked_links_recorded</code>.
      </p><p>
        (This happens when an email campaign has more links than should be
        recorded in the database. This generally happens when a Special Sending
        Rule create custom links for each subscriber.)
      </p><p>
        If this value is true, all links delivered in this campaign are available
        via this API.
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>links</b><br><em>array of hashes</em><br>
      <table>
        <tr>
          <td><b>link_id</b><br><em>integer</em></td>
          <td>Internal identifier for this link</td>
        </tr>
        <tr>
          <td><b>url</b><br><em>string</em></td>
          <td>The URL of the link</td>
        </tr>
        <tr>
          <td><b>clicks_total</b><br><em>integer</em></td>
          <td>Total number of clicks on this link</td>
        </tr>
        <tr>
          <td><b>clicks_unique</b><br><em>integer</em></td>
          <td>Number of "unique clicks by subscriber" that happened on this link</td>
        </tr>
        <tr>
          <td><b>clicks_unique_by_link</b><br><em>integer</em></td>
          <td>Number of "unique clicks by subscriber/link" that happened on this link</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```
> GET /ga/api/campaigns/2/link_stats HTTP/1.1
> Authorization: Basic MTowYWUyNTJlMjA3MjkyNDcwYzViMTc0ZTk0MzhlNmU3MzMzZjJkNmU3
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "1f1fcc31723ce7df22f373ea3c568816"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=c0dcd71b03ad686d3102e24b3debf7ff; path=/; HttpOnly
< X-Request-Id: 4f5199066ea241610046a19b00bad99c
< X-Runtime: 0.026501
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "error_code": null,
  "error_message": null,
  "page": 0,
  "per_page": 100,
  "data": {
    "all_unclicked_links_recorded": true,
    "links": [
      {
        "clicks_total": 6,
        "clicks_unique": 0,
        "clicks_unique_by_link": 1,
        "link_id": 3,
        "url": "http://drh.net"
      },
      {
        "clicks_total": 1,
        "clicks_unique": 1,
        "clicks_unique_by_link": 1,
        "link_id": 4,
        "url": "http://duckduckgo.com"
      },
      {
        "clicks_total": 1,
        "clicks_unique": 0,
        "clicks_unique_by_link": 1,
        "link_id": 5,
        "url": "https://www.eff.org"
      }
    ]
  },
  "num_records": 3,
  "num_pages": 1
}
```
