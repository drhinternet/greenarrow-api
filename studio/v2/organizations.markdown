<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Organizations](#organizations)
  - [Organization Attributes](#organization-attributes)
  - [Get a list of organizations](#get-a-list-of-organizations)
    - [URL](#url)
    - [Response](#response)
  - [Create a new organization](#create-a-new-organization)
    - [URL](#url-1)
    - [Payload](#payload)
    - [Response](#response-1)
  - [Update an existing organization](#update-an-existing-organization)
    - [URL](#url-2)
    - [Payload](#payload-1)
    - [Response](#response-2)
  - [Get an accounting of messages sent by campaigns & autoresponders for a single organization](#get-an-accounting-of-messages-sent-by-campaigns-&-autoresponders-for-a-single-organization)
    - [URL](#url-3)
    - [Parameters](#parameters)
    - [Response](#response-3)
    - [Example](#example)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Organizations


### Organization Attributes

| Key             | Meaning                                                | Example                                  | Type    |
| --------------- | ------------------------------------------------------ | ---------------------------------------- | ------- |
| id              | Internal identifier for this organization              | 123                                      | Integer |
| name            | Identifying (unique) name                              | "System Organization"                    | String  |
| anniversary_day | Day of the month that this organization's quotas reset | 17                                       | Integer |
| time_zone_name  | The time zone for times in this organization           | "(GMT-06:00) Central Time (US & Canada)" | String  |
| html_header     | The HTML header prepended to all emails sent           | `"<h9>Hello from My Org</h9>"`           | String  |
| html_footer     | The HTML footer appended to all emails sent            | `"<h9>Goodbye!</h9>"`                    | String  |
| text_header     | The Text header prepended to all emails sent           | "Hello from My Org"                      | String  |
| text_footer     | The Text footer appended to all emails sent            | "Bye!"                                   | String  |


### Get a list of organizations

#### URL

    GET /ga/api/v2/organizations

#### Response

The response will be a JSON array where each element contains an organization object as defined above.


### Create a new organization

#### URL

    POST /ga/api/v2/organizations

#### Payload

You should send a JSON object that is of the format `{ "organization" => { ... } }`
with the attributes as defined above. No `id` field is needed for creating a new organization.

#### Response

The response will be a JSON object that is an organization object as defined
above containing details about the new organization.


### Update an existing organization

#### URL

    PUT /ga/api/v2/organizations/:organization_id

#### Payload

You should send a JSON object that is of the format `{ "organization" => { ... } }`
with the attributes as defined above. No `id` field is needed in the JSON object
itself, as it is specified on the URL.

#### Response

The response will be a JSON object that is an organization object as defined
above containing details about the updated organization.



### Get an accounting of messages sent by campaigns & autoresponders for a single organization

This endpoint will return a report on the number of messages sent, broken down
by autoresponder and campaign, for a single organization over a time period. It
can group by day or by month, returning JSON data or CSV.

#### URL

    GET /ga/api/v2/organizations/:organization_id/messages_sent/daily
    GET /ga/api/v2/organizations/:organization_id/messages_sent/daily.csv
    GET /ga/api/v2/organizations/:organization_id/messages_sent/monthly
    GET /ga/api/v2/organizations/:organization_id/messages_sent/monthly.csv

#### Parameters

The following parameters may be provided:

<table>
  <tr>
    <td><b>start_date</b><br><em>date</em></td>
    <td>
      The earliest date to include in the report (e.g. <code>2015-04-01</code>).
      Defaults to capture three months -- so if today is April 2, the default date is February 1.
      For monthly reports, the specified value will be translated into "the beginning of the specified month".
      The "beginning of the month" is the 1st, <em>not</em> the organization anniversary.
    </td>
  </tr><tr>
    <td><b>end_date</b><br><em>date</em></td>
    <td>
      The latest date to include in the report (e.g. <code>2015-04-30</code>).
      Defaults to the end of the current month -- so if today is April 2, the default date is April 30.
      For monthly reports, the specified value will be translated into "the end of the specified month".
      The "end of the month" is the last day of the calendar month, <em>not</em> the organization anniversary.
    </td>
  </tr>
</table>

#### Response

If the request is made using one of the `.csv` variations, a CSV document will be sent.

The standard JSON response will contain the following fields.

<table>
  <tr colspan="2">
    <b>report</b><br><em>array of hashes</em><br>
    <table>
      <tr>
        <td><b>time_period_start</b><br><em>string</em></td>
        <td>
          The earliest time covered by this entry.
          If a campaign or autoresponder sent over the course of multiple days, it will have multiple entries.
        </td>
      </tr>
      <tr>
        <td><b>time_period_end</b><br><em>string</em></td>
        <td>The latest time covered by this entry.</td>
      </tr>
      <tr>
        <td><b>campaign_id</b><br><em>integer</em></td>
        <td>The primary key of the campaign that sent this group of messages</td>
      </tr>
      <tr>
        <td><b>campaign_name</b><br><em>string</em></td>
        <td>The name of the campaign that sent this group of messages</td>
      </tr>
      <tr>
        <td><b>autoresponder_id</b><br><em>integer</em></td>
        <td>The primary key of the autoresponder that sent this group of messages</td>
      </tr>
      <tr>
        <td><b>autoresponder_name</b><br><em>string</em></td>
        <td>The name of the autoresponder that sent this group of messages</td>
      </tr>
      <tr>
        <td><b>messages_sent</b><br><em>integer</em></td>
        <td>The number of messages sent by this object in the specified unit of time</td>
      </tr>
    </table>
  </tr>
</table>

#### Example

Example JSON response

```
> GET /ga/api/organizations/1/messages_sent/daily HTTP/1.1
> Authorization: Basic MToyYjBmNTA5YjQ3MDk1ODk0Mzk5ZWRkMGVhODE1ZDlkMjQ4MzUwYjc4
> Accept: application/json
> Content-Type: application/json
```

```
< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "23895f5c12a983d01679df3d12d35c2e"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=2929b9a1608dab85705f340621b08b30; path=/; HttpOnly
< X-Request-Id: b30346c963612c5e98dab3b438e82dc5
< X-Runtime: 0.056364
< Connection: close
< Server: thin
```

```json
{
  "success": true,
  "data": {
    "report": [
      {
        "time_period_start": "2015-09-04T00:00:00-05:00",
        "time_period_end": "2015-09-04T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 11,
        "campaign_name": "Default Campaign (Duplicate #10)",
        "messages_sent": 425
      },
      {
        "time_period_start": "2015-09-04T00:00:00-05:00",
        "time_period_end": "2015-09-04T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 13,
        "campaign_name": "Default Campaign (Duplicate #11)",
        "messages_sent": 98
      },
      {
        "time_period_start": "2015-09-05T00:00:00-05:00",
        "time_period_end": "2015-09-05T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 33,
        "campaign_name": "2015-09-05 18:54:07 -0500 (1)",
        "messages_sent": 22
      },
      {
        "time_period_start": "2015-09-05T00:00:00-05:00",
        "time_period_end": "2015-09-05T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 36,
        "campaign_name": "2015-09-05 18:54:07 -0500 (1) (Duplicate #1)",
        "messages_sent": 13078
      },
      {
        "time_period_start": "2015-09-05T00:00:00-05:00",
        "time_period_end": "2015-09-05T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 34,
        "campaign_name": "2015-09-05 18:57:03 -0500 (1)",
        "messages_sent": 4
      },
      {
        "time_period_start": "2015-09-05T00:00:00-05:00",
        "time_period_end": "2015-09-05T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 35,
        "campaign_name": "2015-09-05 18:57:11 -0500 (1)",
        "messages_sent": 4
      },
      {
        "time_period_start": "2015-09-05T00:00:00-05:00",
        "time_period_end": "2015-09-05T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 37,
        "campaign_name": "2015-09-05 19:00:02 -0500 (1)",
        "messages_sent": 19
      },
      {
        "time_period_start": "2015-09-08T00:00:00-05:00",
        "time_period_end": "2015-09-08T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 31,
        "campaign_name": "2015-09-05 18:40:58 -0500 (1)",
        "messages_sent": 24
      },
      {
        "time_period_start": "2015-09-08T00:00:00-05:00",
        "time_period_end": "2015-09-08T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 32,
        "campaign_name": "2015-09-05 18:47:52 -0500 (1)",
        "messages_sent": 4
      },
      {
        "time_period_start": "2015-09-08T00:00:00-05:00",
        "time_period_end": "2015-09-08T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 111,
        "campaign_name": "2015-09-08 08:57:38 -0500 (1)",
        "messages_sent": 24589
      },
      {
        "time_period_start": "2015-09-08T00:00:00-05:00",
        "time_period_end": "2015-09-08T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 112,
        "campaign_name": "2015-09-08 08:57:38 -0500 (2)",
        "messages_sent": 24576
      },
      {
        "time_period_start": "2015-10-15T00:00:00-05:00",
        "time_period_end": "2015-10-15T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 179,
        "campaign_name": "campaign one (Duplicate #9)",
        "messages_sent": 1
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 195,
        "campaign_name": "2015-10-20 13:39:37 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 196,
        "campaign_name": "2015-10-20 13:40:12 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 197,
        "campaign_name": "2015-10-20 13:40:34 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 198,
        "campaign_name": "2015-10-20 13:40:51 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 200,
        "campaign_name": "2015-10-20 13:41:38 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 201,
        "campaign_name": "2015-10-20 13:41:58 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 202,
        "campaign_name": "2015-10-20 13:42:43 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 204,
        "campaign_name": "2015-10-20 13:46:34 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 205,
        "campaign_name": "2015-10-20 13:47:10 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 206,
        "campaign_name": "2015-10-20 13:49:45 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 207,
        "campaign_name": "2015-10-20 13:50:07 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 208,
        "campaign_name": "2015-10-20 13:54:37 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 209,
        "campaign_name": "2015-10-20 13:56:20 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 210,
        "campaign_name": "2015-10-20 13:58:06 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 211,
        "campaign_name": "2015-10-20 13:58:39 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 212,
        "campaign_name": "2015-10-20 13:59:09 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 214,
        "campaign_name": "2015-10-20 14:07:54 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 215,
        "campaign_name": "2015-10-20 14:09:23 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 216,
        "campaign_name": "2015-10-20 14:10:15 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 217,
        "campaign_name": "2015-10-20 14:11:23 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 218,
        "campaign_name": "2015-10-20 14:23:18 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 219,
        "campaign_name": "2015-10-20 14:29:07 -0500 (1)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-10-20T00:00:00-05:00",
        "time_period_end": "2015-10-20T23:59:59-05:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 192,
        "campaign_name": "campaign one (Duplicate #22)",
        "messages_sent": 2
      },
      {
        "time_period_start": "2015-11-06T00:00:00-06:00",
        "time_period_end": "2015-11-06T23:59:59-06:00",
        "autoresponder_id": null,
        "autoresponder_name": null,
        "campaign_id": 228,
        "campaign_name": "one campaign (Duplicate #2)",
        "messages_sent": 1
      }
    ]
  },
  "error_code": null,
  "error_message": null
}
```

Example CSV response

```csv
"Time Period Start","Time Period End","Organization ID","Organization Name","Campaign ID","Campaign Name","Autoresponder ID","Autoresponder Name","Messages Sent"
"2015-09-04T00:00:00-05:00","2015-09-04T23:59:59-05:00","","","11","Default Campaign (Duplicate #10)","","","425"
"2015-09-04T00:00:00-05:00","2015-09-04T23:59:59-05:00","","","13","Default Campaign (Duplicate #11)","","","98"
"2015-09-05T00:00:00-05:00","2015-09-05T23:59:59-05:00","","","33","2015-09-05 18:54:07 -0500 (1)","","","22"
"2015-09-05T00:00:00-05:00","2015-09-05T23:59:59-05:00","","","36","2015-09-05 18:54:07 -0500 (1) (Duplicate #1)","","","13078"
"2015-09-05T00:00:00-05:00","2015-09-05T23:59:59-05:00","","","34","2015-09-05 18:57:03 -0500 (1)","","","4"
"2015-09-05T00:00:00-05:00","2015-09-05T23:59:59-05:00","","","35","2015-09-05 18:57:11 -0500 (1)","","","4"
"2015-09-05T00:00:00-05:00","2015-09-05T23:59:59-05:00","","","37","2015-09-05 19:00:02 -0500 (1)","","","19"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","31","2015-09-05 18:40:58 -0500 (1)","","","24"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","32","2015-09-05 18:47:52 -0500 (1)","","","4"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","111","2015-09-08 08:57:38 -0500 (1)","","","24589"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","112","2015-09-08 08:57:38 -0500 (2)","","","24576"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","113","2015-09-08 08:57:38 -0500 (3)","","","24648"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","114","2015-09-08 08:57:38 -0500 (4)","","","24019"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","115","2015-09-08 08:57:38 -0500 (5)","","","24870"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","135","2015-09-08 09:16:36 -0500 (1)","","","34008"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","136","2015-09-08 09:16:36 -0500 (2)","","","33936"
"2015-09-08T00:00:00-05:00","2015-09-08T23:59:59-05:00","","","137","2015-09-08 09:16:36 -0500 (3)","","","34046"
"2015-09-09T00:00:00-05:00","2015-09-09T23:59:59-05:00","","","150","2015-09-05 18:40:58 -0500 (1) (Duplicate #1)","","","3612"
"2015-10-30T00:00:00-05:00","2015-10-30T23:59:59-05:00","","","221","hello world (Duplicate #2)","","","4"
"2015-10-30T00:00:00-05:00","2015-10-30T23:59:59-05:00","","","222","hello world (Duplicate #3)","","","4"
"2015-10-30T00:00:00-05:00","2015-10-30T23:59:59-05:00","","","223","hello world (Duplicate #4)","","","4"
"2015-11-03T00:00:00-06:00","2015-11-03T23:59:59-06:00","","","224","hello world (Duplicate #5)","","","4"
"2015-11-06T00:00:00-06:00","2015-11-06T23:59:59-06:00","","","226","one campaign","","","1"
"2015-11-06T00:00:00-06:00","2015-11-06T23:59:59-06:00","","","227","one campaign (Duplicate #1)","","","1"
"2015-11-06T00:00:00-06:00","2015-11-06T23:59:59-06:00","","","228","one campaign (Duplicate #2)","","","1"
```
