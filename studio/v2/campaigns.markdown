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

| Key                 | Description                                                                                                  |
| ------------------- | ------------------------------------------------------------------------------------------------------------ |
| `started_at__start` | A UNIX integer timestamp or ISO-8601 datetime string representing the earliest `started_at` time to include. |
| `started_at__end`   | A UNIX integer timestamp or ISO-8601 datetime string representing the latest `started_at` time to include.   |

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

You may provide an extra parameter `include_engine_sendid=1` in the request
URL.  If this parameter is supplied, the response will include a
`engine_sendid` string value.  Use this sendid value in interacting with
GreenArrow Engine's API.

#### Response

<table>

  <tr>
    <td><b>name</b><br><em>string</em></td>
    <td>The name of the campaign.</td>
  </tr>
  <tr>
    <td><b>mailing_list_id</b><br><em>integer</em></td>
    <td>The ID of the mailing list this campaign belongs to.</td>
  </tr>
  <tr>
    <td><b>name</b><br><em>string</em></td>
    <td>The name of the mailing list this campaign belongs to.</td>
  </tr>

  <tr>
    <td><b>content_subject</b><br><em>string</em></td>
    <td><em>Deprecated:</em> The subject of the email. For split-test campaigns, this field will contain the data on the first content by its ID value.</td>
  </tr>
  <tr>
    <td><b>email_format</b><br><em>string</em></td>
    <td><em>Deprecated:</em> Email format to use when delivering this campaign. Valid formats include <code>html</code>, <code>text</code>, and <code>both</code>. For split-test campaigns, this field will contain the data on the first content by its ID value.</td>
  </tr>
  <tr>
    <td><b>content_html</b><br><em>string</em></td>
    <td><em>Deprecated:</em> If format is <code>html</code> or <code>both</code>, this is the HTML portion of the email. For split-test campaigns, this field will contain the data on the first content by its ID value.</td>
  </tr>
  <tr>
    <td><b>content_text</b><br><em>string</em></td>
    <td><em>Deprecated:</em> If format is <code>text</code> or <code>both</code>, this is the plaintext portion of the email. For split-test campaigns, this field will contain the data on the first content by its ID value.</td>
  </tr>

  <tr>
    <td><b>segmentation_criteria_id</b><br><em>integer</em></td>
    <td>
      The ID of the segmentation criteria to use when delivering this campaign.
    </td>
  </tr>
  <tr>
    <td><b>segmentation_criteria_name</b><br><em>string</em></td>
    <td>
      The name of the segmentation criteria, if it is a stored segment.
    </td>
  </tr>
  <tr>
    <td><b>segmentation_criteria_remote_sql</b><br><em>string</em></td>
    <td>
      The SQL to use when querying the remote database for this campaign. This only applies to <a href="../remote_lists.markdown">Remote Lists</a>.
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>campaign_contents</b><br><em>array of hashes</em><br>
      <table>
        <tr>
          <td><b>id</b><br><em>integer</em></td>
          <td>The ID for this content record.</td>
        </tr>
        <tr>
          <td><b>name</b><br><em>string</em></td>
          <td>String identifier for this content.</td>
        </tr>
        <tr>
          <td><b>subject</b><br><em>string</em></td>
          <td>The subject of the email.</td>
        </tr>
        <tr>
          <td><b>format</b><br><em>string</em></td>
          <td>Email format to use when delivering this campaign. Valid formats include <code>html</code>, <code>text</code>, and <code>both</code>.</td>
        </tr>
        <tr>
          <td><b>html</b><br><em>string</em></td>
          <td>If format is <code>html</code> or <code>both</code>, this is the HTML portion of the email.</td>
        </tr>
        <tr>
          <td><b>text</b><br><em>string</em></td>
          <td>If format is <code>text</code> or <code>both</code>, this is the plaintext portion of the email.</td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>dispatch</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>state</b><br><em>string</em></td>
          <td>
            The state of delivery; Can be one of: <code>idle</code>, <code>scheduled</code>, <code>sending</code>, <code>finished</code>, <code>failed</code>, <code>cancelled</code>
          </td>
        </tr>
        <tr>
          <td><b>state_description</b><br><em>string</em></td>
          <td>
            Localized textual description of the state.
          </td>
        </tr>
        <tr>
          <td><b>virtual_mta_id</b><br><em>integer</em></td>
          <td>
            The ID of a Virtual MTA explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>virtual_mta_name</b><br><em>string</em></td>
          <td>
            The name of a Virtual MTA explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>bounce_email_id</b><br><em>string</em></td>
          <td>
            The ID of a Bounce Email explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>bounce_email_name</b><br><em>string</em></td>
          <td>
            The Bounce Email explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>url_domain_id</b><br><em>integer</em></td>
          <td>
            The ID of an URL domain explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>url_domain_name</b><br><em>string</em></td>
          <td>
            The URL domain explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_id</b><br><em>integer</em></td>
          <td>
            <em>Deprecated:</em> The ID of the first seed list assigned to the Campaign, ordered by ID. Use <code>seed_lists</code> instead.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_name</b><br><em>string</em></td>
          <td>
            <em>Deprecated:</em> The name of the first seed list assigned to the Campaign, ordered by ID. Use <code>seed_lists</code> instead.
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <b>seed_lists</b><br><em>array of hashes</em><br>
            <table>
              <tr>
                <td><b>id</b><br><em>integer</em></td>
                <td>The ID of a seed list used by this campaign.</td>
              </tr>
              <tr>
                <td><b>name</b><br><em>string</em></td>
                <td>The name of a seed list used by this campaign.</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td><b>speed</b><br><em>integer</em></td>
          <td>
            Maximum throughput speed; <code>0</code> for unlimited throughput.
          </td>
        </tr>
        <tr>
          <td><b>track_opens</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign will track openings stats.
          </td>
        </tr>
        <tr>
          <td><b>track_links</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign will track clicks stats.
          </td>
        </tr>
        <tr>
          <td><b>paused</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign has been paused.
          </td>
        </tr>
        <tr>
          <td><b>from_name</b><br><em>string</em></td>
          <td>
            Name to use in the "From:" field.
          </td>
        </tr>
        <tr>
          <td><b>from_email</b><br><em>string</em></td>
          <td>
            Email to use in the "From:" field.
          </td>
        </tr>
        <tr>
          <td><b>reply_to</b><br><em>string</em></td>
          <td>
            Email to use in the "ReplyTo:" field.
          </td>
        </tr>
        <tr>
          <td><b>sender_email</b><br><em>string</em></td>
          <td>
            Email to use in the "Sender:" field.
          </td>
        </tr>
        <tr>
          <td><b>begins_at</b><br><em>string</em></td>
          <td>
            Time to start delivery at. If this value is specified and the
            campaign has a segment, content, and delivery settings &mdash; the
            campaign will be marked as scheduled and sending will begin at the
            requested time. If one of those sections are missing or this value
            is blank, the campaign will remain in an "idle" state.
          </td>
        </tr>
        <tr>
          <td><b>started_at</b><br><em>string</em></td>
          <td>
            The time at which the campaign started sending.
            This will be <code>null</code> if the campaign has not yet started sending.
          </td>
        </tr>
        <tr>
          <td><b>finished_at</b><br><em>string</em></td>
          <td>
            The time at which the campaign finished sending.
            This will be <code>null</code> if the campaign has not yet finished sending.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_enabled</b><br><em>boolean</em></td>
          <td>
            The campaign is configured to use automatic winner selection.
            For automatic winner selection to be used, this must be enabled <em>and</em> the campaign must have more than one content.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_percentage</b><br><em>string</em></td>
          <td>
            The percentage that will be sent for the split-test portion of the campaign.
            This value is returned as a string to prevent floating-point conversion errors.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_delay_amount</b><br><em>integer</em></td>
          <td>
            The number of units of time that the campaign will wait before finishing after a split-test.
        </tr>
        <tr>
          <td><b>autowinner_delay_unit</b><br><em>string</em></td>
          <td>
            The unit used in calculating the delay duration. This may be <code>minutes</code>, <code>hours</code>, or <code>days</code>.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_metric</b><br><em>string</em></td>
          <td>
            The metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.
          </td>
        </tr>
        <tr>
          <td><b>special_sending_rule_id</b><br><em>integer</em></td>
          <td>
            The ID of the Special Sending Rule used for this campaign. Special Sending Rules may only be used on the System Organization. See note (4) below.
          </td>
        </tr>
        <tr>
          <td><b>special_sending_rule_name</b><br><em>string</em></td>
          <td>
            The name of the Special Sending Rule used for this campaign. See note (4) below.
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>stat_summary</b><br><em>hash</em><br>
      <table>

        <!-- Message Counts -->
        <tr>
          <td><b>sent_text</b><br><em>integer</em></td>
          <td>
            Number of recipients that were sent a text-only message.
          </td>
        </tr>
        <tr>
          <td><b>sent_html</b><br><em>integer</em></td>
          <td>
            Number of recipients that were sent a html-only message.
          </td>
        </tr>
        <tr>
          <td><b>sent_multipart</b><br><em>integer</em></td>
          <td>
            Number of recipients that were sent a multipart message.
          </td>
        </tr>
        <tr>
          <td><b>messages_sent</b><br><em>integer</em></td>
          <td>
            Total number of recipients.
          </td>
        </tr>
        <tr>
          <td><b>messages_html</b><br><em>integer</em></td>
          <td>
            Number of recipients that received either an HTML or multipart message.
          </td>
        </tr>
        <tr>
          <td><b>messages_text</b><br><em>integer</em></td>
          <td>
            Number of recipients that received a text-only message.
          </td>
        </tr>

        <!-- Bounces -->
        <tr>
          <td><b>bounces_total</b><br><em>integer</em></td>
          <td>
            Total number of bounces received.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique</b><br><em>integer</em></td>
          <td>
            Unique (by subscriber) bounces received.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_hard</b><br><em>integer</em></td>
          <td>
            Number of unique (by subscriber) bounces where bounce_type is hard.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_soft</b><br><em>integer</em></td>
          <td>
            Number of unique (by subscriber) bounces where bounce_type is soft.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_other</b><br><em>integer</em></td>
          <td>
            Number of unique (by subscriber) bounces where bounce_type is other.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_local</b><br><em>integer</em></td>
          <td>
            Number of unique (by subscriber) bounces that were local.
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_remote</b><br><em>integer</em></td>
          <td>
            Number of unique (by subscriber) bounces that were remote.
          </td>
        </tr>
        <tr>
          <td><b>bounces_status_updated</b><br><em>integer</em></td>
          <td>
            Number of recipients where status was updated to status 'bounce' (See 1 below).
          </td>
        </tr>
        <tr>
          <td><b>bounces_unique_by_code</b><br><em>hash</em></td>
          <td>
            Number of unique (by subscriber) bounces for each bounce code. The keys in the included hash are the bounce code.
          </td>
        </tr>
        <tr>
          <td><b>bounced</b><br><em>integer</em></td>
          <td>
            <em>Deprecated</em>: Unique (by subscriber) bounces received.
            This is just another name for <code>bounces_unique</code>.
          </td>
        </tr>
        <tr>
          <td><b>duplicate_bounces</b><br><em>integer</em></td>
          <td>
            Number of non-unique bounces.
          </td>
        </tr>
        <tr>
          <td><b>unbounced</b><br><em>integer</em></td>
          <td>
            Number of messages that were sent that have not bounced.
          </td>
        </tr>
        <tr>
          <td><b>bounce_rate</b><br><em>float</em></td>
          <td>
            Floating point value indicating the unique bounce rate for this campaign.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>bounce_rate_hard</b><br><em>float</em></td>
          <td>
            The ratio of the unique bounces that were hard bounces.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>bounce_rate_soft</b><br><em>float</em></td>
          <td>
            The ratio of the unique bounces that were soft bounces.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>bounce_rate_other</b><br><em>float</em></td>
          <td>
            The ratio of the unique bounces that were other bounces.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>bounce_local_rate</b><br><em>float</em></td>
          <td>
            The ratio of the unique bounces that were local bounces.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>

        <!-- Clicks -->
        <tr>
          <td><b>clicks_total</b><br><em>integer</em></td>
          <td>
            Number of total clicks.
          </td>
        </tr>
        <tr>
          <td><b>clicks_unique</b><br><em>integer</em></td>
          <td>
            Number of unique clicks (unique by subscriber).
          </td>
        </tr>
        <tr>
          <td><b>clicks_unique_by_link</b><br><em>integer</em></td>
          <td>
            <em>Deprecated:</em> Number of unique clicks (unique by subscriber/link) -- this value does not carry much meaning -- see the Links endpoint below.
          </td>
        </tr>
        <tr>
          <td><b>duplicate_clicks</b><br><em>integer</em></td>
          <td>
            Number of non-unique clicks.
          </td>
        </tr>
        <tr>
          <td><b>click_rate</b><br><em>float</em></td>
          <td>
            The ratio of messages that were accepted and have been clicked.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>click_to_open_rate</b><br><em>float</em></td>
          <td>
            The ratio of messages that were opened that have been clicked.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>unclicked</b><br><em>integer</em></td>
          <td>
            Number of messages that were accepted by the remote server but have not been clicked.
          </td>
        </tr>

        <!-- Opens -->
        <tr>
          <td><b>opens_total</b><br><em>integer</em></td>
          <td>
            Number of total opens
          </td>
        </tr>
        <tr>
          <td><b>opens_unique</b><br><em>integer</em></td>
          <td>
            Number of unique opens (unique by subscriber)
          </td>
        </tr>
        <tr>
          <td><b>open_rate</b><br><em>float</em></td>
          <td>
            Ratio of messages that were accepted that have been opened.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>open_ratio</b><br><em>float</em></td>
          <td>
            Average number of times each opened message has been opened (<code>opens_total / opens_unique</code>).
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>unopened</b><br><em>integer</em></td>
          <td>
            Number of messages that were accepted and have not been opened.
          </td>
        </tr>
        <tr>
          <td><b>duplicate_opens</b><br><em>integer</em></td>
          <td>
            Number of non-unique opens.
          </td>
        </tr>

        <!-- Spam Complaints -->
        <tr>
          <td><b>scomps_total</b><br><em>integer</em></td>
          <td>
            Number of spam complaints
          </td>
        </tr>
        <tr>
          <td><b>scomps_unique</b><br><em>integer</em></td>
          <td>
            Number of unique spam complaints (unique by subscriber).
          </td>
        </tr>
        <tr>
          <td><b>scomps_status_updated</b><br><em>integer</em></td>
          <td>
            Number of recipients where the status was updated to status 'scomp' (See 1 below).
          </td>
        </tr>
        <tr>
          <td><b>duplicate_scomps</b><br><em>integer</em></td>
          <td>
            Number of non-unique spam complaints.
          </td>
        </tr>

        <!-- Unsubscribes -->
        <tr>
          <td><b>unsubs_total</b><br><em>integer</em></td>
          <td>
            Number of total unsubscribes
          </td>
        </tr>
        <tr>
          <td><b>unsubs_unique</b><br><em>integer</em></td>
          <td>
            Number of unique unsubscribes (unique by subscriber)
          </td>
        </tr>
        <tr>
          <td><b>unsubs_status_updated</b><br><em>integer</em></td>
          <td>
            Number of recipients where the status was updated to status 'unsubscribed' (See 1 below).
          </td>
        </tr>
        <tr>
          <td><b>duplicate_unsubs</b><br><em>integer</em></td>
          <td>
            Number of non-unique unsubscribes.
          </td>
        </tr>
        <tr>
          <td><b>unsub_rate</b><br><em>float</em></td>
          <td>
            The ratio of messages that were accepted and unsubscribed.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>

        <!-- Skips -->
        <tr>
          <td><b>skips_error</b><br><em>integer</em></td>
          <td>
            Number of messages that were skipped due to a Special Sending Rule error.
          </td>
        </tr>
        <tr>
          <td><b>skips_request</b><br><em>integer</em></td>
          <td>
            Number of messages that were skipped due to a Special Sending Rule request.
          </td>
        </tr>

        <!-- Engine Injection -->
        <tr>
          <td><b>total_messages</b><br><em>integer</em></td>
          <td>
            Total number of messages injected for this campaign.
          </td>
        </tr>
        <tr>
          <td><b>total_success</b><br><em>integer</em></td>
          <td>
            Number of messages that were successfully delivered to the remote server.
          </td>
        </tr>
        <tr>
          <td><b>total_failure</b><br><em>integer</em></td>
          <td>
            Number of messages ended due to SMTP conversation failures.
          </td>
        </tr>
        <tr>
          <td><b>total_failure_toolong</b><br><em>integer</em></td>
          <td>
            Number of messages ended due to being in the queue too long.
          </td>
        </tr>
        <tr>
          <td><b>accepted</b><br><em>integer</em></td>
          <td>
            Total number of messages that were accepted by the remote server.
          </td>
        </tr>
        <tr>
          <td><b>accepted_rate</b><br><em>float</em></td>
          <td>
            Ratio of messages that were attempted and accepted (<code>accepted / messages_sent</code>).
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>in_queue</b><br><em>integer</em></td>
          <td>
            Number of messages that are currently in GreenArrow Engine's delivery queue.
          </td>
        </tr>
        <tr>
          <td><b>in_queue_rate</b><br><em>float</em></td>
          <td>
            Ratio of the total number of messages that have been handed off to GreenArrow Engine and are still in queue.
            This value ranges from <code>0.0</code> to <code>1.0</code>.
          </td>
        </tr>
        <tr>
          <td><b>max_unique_activities</b><br><em>integer</em></td>
          <td>
            The max value of <code>opens_unique</code>, <code>clicks_unique</code>, <code>unsubs_unique</code>, and <code>scomps_unique</code>.
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>content_stats</b><br><em>array of hashes</em><br>
      <table>
        <tr>
          <td colspan="2">
            <b>content</b><br><em>hash</em>
            <br>
            <table>
              <tr>
                <td><b>id</b><br><em>integer</em></td>
                <td>
                  The ID of this content.
                </td>
              </tr>
              <tr>
                <td><b>sent_html</b><br><em>integer</em></td>
                <td>
                  The name of this content.
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <b>content</b><br><em>hash</em>
            <br>
            See the <u>stat_summary</u> section above for details on these fields.
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>automatic_winner_selection</b><br><em>hash</em><br>
      If this campaign does not use automatic winner selection, this value will be <code>null</code>.
      <br>
      <table>
        <tr>
          <td><b>state</b><br><em>string</em></td>
          <td>
            The current state of automatic winner selection on this campaign.
            Possible values are: <code>split_testing</code>, <code>decision_delay</code>, <code>finished</code>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <b>winning_content</b><br><em>hash</em>
            <br>
            <table>
              <tr>
                <td><b>id</b><br><em>integer</em></td>
                <td>
                  The ID of this content.
                </td>
              </tr>
              <tr>
                <td><b>name</b><br><em>string</em></td>
                <td>
                  The name of this content.
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <b>snapshots</b><br><em>array of hashes</em>
            <br>
            <table>
              <tr>
                <td colspan="2">
                  <b>content</b><br><em>hash</em>
                  <br>
                  <table>
                    <tr>
                      <td><b>id</b><br><em>integer</em></td>
                      <td>
                        The ID of this content.
                      </td>
                    </tr>
                    <tr>
                      <td><b>name</b><br><em>string</em></td>
                      <td>
                        The name of this content.
                      </td>
                    </tr>
                    <tr>
                      <td><b>is_winner</b><br><em>boolean</em></td>
                      <td>
                        This content won in automatic winner selection.
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <b>snapshot</b><br><em>hash</em>
                  <br>
                  See the <u>stat_summary</u> section above for details on these fields.
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

</table>

1. The "status updated" fields will always be 0 on [Remote Lists](../remote_lists.markdown).

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```json
> GET /ga/api/campaigns/2 HTTP/1.1
> Authorization: Basic MTpkZDVjNmQ5NWM1Y2QyMDFmNDM1OTNhM2JlNjc4MmMyYjNhMGVhODhj
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "f622c5ef847b75998b7d1defc353e018"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=274d96960e9b54498ba8f8ff343b66fd; path=/; HttpOnly
< X-Request-Id: 23331bfb903702eceb2da74bad1e6660
< X-Runtime: 0.036800
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "active_html_editor": "ckeditor",
    "archived": false,
    "content_determined": true,
    "created_at": "2015-05-05T14:35:28Z",
    "id": 2,
    "mailing_list_id": 1,
    "name": "Default Campaign (Duplicate #1)",
    "organization_id": 1,
    "segmentation_criteria_id": 2,
    "template": false,
    "updated_at": "2015-05-05T14:35:28Z",
    "mailing_list_name": "Default Mailing List",
    "organization_name": "System Organization",
    "stat_summary": {
      "sent_text": 0,
      "sent_html": 21,
      "sent_multipart": 0,
      "bounces_total": 0,
      "bounces_unique": 0,
      "bounces_unique_hard": 0,
      "bounces_unique_soft": 0,
      "bounces_unique_other": 0,
      "bounces_unique_local": 0,
      "bounces_unique_remote": 0,
      "clicks_total": 0,
      "clicks_unique": 0,
      "clicks_unique_by_link": 0,
      "opens_total": 0,
      "opens_unique": 0,
      "scomps_total": 0,
      "scomps_unique": 0,
      "scomps_status_updated": 0,
      "unsubs_total": 0,
      "unsubs_unique": 0,
      "unsubs_status_updated": 0,
      "bounces_status_updated": 0,
      "total_messages": 21,
      "total_success": 21,
      "total_failure": 0,
      "total_failure_toolong": 0,
      "skips_error": 0,
      "skips_request": 0,
      "stat_id": 5,
      "bounces_unique_by_code": {
      },
      "messages_sent": 21,
      "messages_html": 21,
      "messages_text": 0,
      "accepted": 21,
      "accepted_rate": 1.0,
      "in_queue": 0,
      "in_queue_rate": 0.0,
      "max_unique_activities": 0,
      "open_rate": 0.0,
      "open_ratio": 0.0,
      "unopened": 21,
      "duplicate_opens": 0,
      "duplicate_clicks": 0,
      "click_rate": 0.0,
      "click_to_open_rate": 0.0,
      "unclicked": 21,
      "bounced": 0,
      "duplicate_bounces": 0,
      "unbounced": 21,
      "bounce_rate": 0.0,
      "bounce_rate_hard": 0.0,
      "bounce_rate_soft": 0.0,
      "bounce_rate_other": 0.0,
      "bounce_local_rate": 0.0,
      "duplicate_scomps": 0,
      "duplicate_unsubs": 0,
      "unsub_rate": 0.0
    },
    "content_stats": [
      {
        "content": {
          "id": 4,
          "name": "Content A"
        },
        "stat_summary": {
          "sent_text": 0,
          "sent_html": 19,
          "sent_multipart": 0,
          "bounces_total": 0,
          "bounces_unique": 0,
          "bounces_unique_hard": 0,
          "bounces_unique_soft": 0,
          "bounces_unique_other": 0,
          "bounces_unique_local": 0,
          "bounces_unique_remote": 0,
          "clicks_total": 0,
          "clicks_unique": 0,
          "clicks_unique_by_link": 0,
          "opens_total": 0,
          "opens_unique": 0,
          "scomps_total": 0,
          "scomps_unique": 0,
          "scomps_status_updated": 0,
          "unsubs_total": 0,
          "unsubs_unique": 0,
          "unsubs_status_updated": 0,
          "bounces_status_updated": 0,
          "total_messages": 19,
          "total_success": 19,
          "total_failure": 0,
          "total_failure_toolong": 0,
          "skips_error": 0,
          "skips_request": 0,
          "stat_slice_id": 6,
          "bounces_unique_by_code": {
          },
          "messages_sent": 19,
          "messages_html": 19,
          "messages_text": 0,
          "accepted": 19,
          "accepted_rate": 1.0,
          "in_queue": 0,
          "in_queue_rate": 0.0,
          "max_unique_activities": 0,
          "open_rate": 0.0,
          "open_ratio": 0.0,
          "unopened": 19,
          "duplicate_opens": 0,
          "duplicate_clicks": 0,
          "click_rate": 0.0,
          "click_to_open_rate": 0.0,
          "unclicked": 19,
          "bounced": 0,
          "duplicate_bounces": 0,
          "unbounced": 19,
          "bounce_rate": 0.0,
          "bounce_rate_hard": 0.0,
          "bounce_rate_soft": 0.0,
          "bounce_rate_other": 0.0,
          "bounce_local_rate": 0.0,
          "duplicate_scomps": 0,
          "duplicate_unsubs": 0,
          "unsub_rate": 0.0
        }
      },
      {
        "content": {
          "id": 5,
          "name": "Content B"
        },
        "stat_summary": {
          "sent_text": 0,
          "sent_html": 0,
          "sent_multipart": 0,
          "bounces_total": 0,
          "bounces_unique": 0,
          "bounces_unique_hard": 0,
          "bounces_unique_soft": 0,
          "bounces_unique_other": 0,
          "bounces_unique_local": 0,
          "bounces_unique_remote": 0,
          "clicks_total": 0,
          "clicks_unique": 0,
          "clicks_unique_by_link": 0,
          "opens_total": 0,
          "opens_unique": 0,
          "scomps_total": 0,
          "scomps_unique": 0,
          "scomps_status_updated": 0,
          "unsubs_total": 0,
          "unsubs_unique": 0,
          "unsubs_status_updated": 0,
          "bounces_status_updated": 0,
          "total_messages": 0,
          "total_success": 0,
          "total_failure": 0,
          "total_failure_toolong": 0,
          "skips_error": 0,
          "skips_request": 0,
          "bounces_unique_by_code": null,
          "messages_sent": 0,
          "messages_html": 0,
          "messages_text": 0,
          "accepted": 0,
          "accepted_rate": 0.0,
          "in_queue": 0,
          "in_queue_rate": 0.0,
          "max_unique_activities": 0,
          "open_rate": 0.0,
          "open_ratio": 0.0,
          "unopened": 0,
          "duplicate_opens": 0,
          "duplicate_clicks": 0,
          "click_rate": 0.0,
          "click_to_open_rate": 0.0,
          "unclicked": 0,
          "bounced": 0,
          "duplicate_bounces": 0,
          "unbounced": 0,
          "bounce_rate": 0.0,
          "bounce_rate_hard": 0.0,
          "bounce_rate_soft": 0.0,
          "bounce_rate_other": 0.0,
          "bounce_local_rate": 0.0,
          "duplicate_scomps": 0,
          "duplicate_unsubs": 0,
          "unsub_rate": 0.0
        }
      },
      {
        "content": {
          "id": 6,
          "name": "Content C"
        },
        "stat_summary": {
          "sent_text": 0,
          "sent_html": 2,
          "sent_multipart": 0,
          "bounces_total": 0,
          "bounces_unique": 0,
          "bounces_unique_hard": 0,
          "bounces_unique_soft": 0,
          "bounces_unique_other": 0,
          "bounces_unique_local": 0,
          "bounces_unique_remote": 0,
          "clicks_total": 0,
          "clicks_unique": 0,
          "clicks_unique_by_link": 0,
          "opens_total": 0,
          "opens_unique": 0,
          "scomps_total": 0,
          "scomps_unique": 0,
          "scomps_status_updated": 0,
          "unsubs_total": 0,
          "unsubs_unique": 0,
          "unsubs_status_updated": 0,
          "bounces_status_updated": 0,
          "total_messages": 2,
          "total_success": 2,
          "total_failure": 0,
          "total_failure_toolong": 0,
          "skips_error": 0,
          "skips_request": 0,
          "stat_slice_id": 8,
          "bounces_unique_by_code": {
          },
          "messages_sent": 2,
          "messages_html": 2,
          "messages_text": 0,
          "accepted": 2,
          "accepted_rate": 1.0,
          "in_queue": 0,
          "in_queue_rate": 0.0,
          "max_unique_activities": 0,
          "open_rate": 0.0,
          "open_ratio": 0.0,
          "unopened": 2,
          "duplicate_opens": 0,
          "duplicate_clicks": 0,
          "click_rate": 0.0,
          "click_to_open_rate": 0.0,
          "unclicked": 2,
          "bounced": 0,
          "duplicate_bounces": 0,
          "unbounced": 2,
          "bounce_rate": 0.0,
          "bounce_rate_hard": 0.0,
          "bounce_rate_soft": 0.0,
          "bounce_rate_other": 0.0,
          "bounce_local_rate": 0.0,
          "duplicate_scomps": 0,
          "duplicate_unsubs": 0,
          "unsub_rate": 0.0
        }
      }
    ],
    "automatic_winner_selection": {
      "state": "finished",
      "winning_content": {
        "id": 4,
        "name": "Content A"
      },
      "snapshots": [
        {
          "content": {
            "id": 4,
            "name": "Content A",
            "is_winner": true
          },
          "snapshot": {
            "bounces_status_updated": 0,
            "bounces_total": 0,
            "bounces_unique": 0,
            "bounces_unique_by_code": {
            },
            "bounces_unique_hard": 0,
            "bounces_unique_local": 0,
            "bounces_unique_other": 0,
            "bounces_unique_remote": 0,
            "bounces_unique_soft": 0,
            "clicks_total": 0,
            "clicks_unique": 0,
            "clicks_unique_by_link": 0,
            "id": 1,
            "opens_total": 0,
            "opens_unique": 0,
            "scomps_status_updated": 0,
            "scomps_total": 0,
            "scomps_unique": 0,
            "sent_html": 2,
            "sent_multipart": 0,
            "sent_text": 0,
            "skips_error": 0,
            "skips_request": 0,
            "snapshot_group": "b7c306537082c5c5257d3203c12e97fd",
            "stat_id": 5,
            "stat_slice_id": 6,
            "taken_at": "2015-05-05T14:37:17Z",
            "total_failure": 0,
            "total_failure_toolong": 0,
            "total_messages": 2,
            "total_success": 2,
            "unsubs_status_updated": 0,
            "unsubs_total": 0,
            "unsubs_unique": 0
          }
        },
        {
          "content": {
            "id": 5,
            "name": "Content B",
            "is_winner": false
          },
          "snapshot": {
            "bounces_status_updated": 0,
            "bounces_total": 0,
            "bounces_unique": 0,
            "bounces_unique_by_code": {
            },
            "bounces_unique_hard": 0,
            "bounces_unique_local": 0,
            "bounces_unique_other": 0,
            "bounces_unique_remote": 0,
            "bounces_unique_soft": 0,
            "clicks_total": 0,
            "clicks_unique": 0,
            "clicks_unique_by_link": 0,
            "id": 2,
            "opens_total": 0,
            "opens_unique": 0,
            "scomps_status_updated": 0,
            "scomps_total": 0,
            "scomps_unique": 0,
            "sent_html": 0,
            "sent_multipart": 0,
            "sent_text": 0,
            "skips_error": 0,
            "skips_request": 0,
            "snapshot_group": "b7c306537082c5c5257d3203c12e97fd",
            "stat_id": 5,
            "stat_slice_id": 7,
            "taken_at": "2015-05-05T14:37:17Z",
            "total_failure": 0,
            "total_failure_toolong": 0,
            "total_messages": 0,
            "total_success": 0,
            "unsubs_status_updated": 0,
            "unsubs_total": 0,
            "unsubs_unique": 0
          }
        },
        {
          "content": {
            "id": 6,
            "name": "Content C",
            "is_winner": false
          },
          "snapshot": {
            "bounces_status_updated": 0,
            "bounces_total": 0,
            "bounces_unique": 0,
            "bounces_unique_by_code": {
            },
            "bounces_unique_hard": 0,
            "bounces_unique_local": 0,
            "bounces_unique_other": 0,
            "bounces_unique_remote": 0,
            "bounces_unique_soft": 0,
            "clicks_total": 0,
            "clicks_unique": 0,
            "clicks_unique_by_link": 0,
            "id": 3,
            "opens_total": 0,
            "opens_unique": 0,
            "scomps_status_updated": 0,
            "scomps_total": 0,
            "scomps_unique": 0,
            "sent_html": 2,
            "sent_multipart": 0,
            "sent_text": 0,
            "skips_error": 0,
            "skips_request": 0,
            "snapshot_group": "b7c306537082c5c5257d3203c12e97fd",
            "stat_id": 5,
            "stat_slice_id": 8,
            "taken_at": "2015-05-05T14:37:17Z",
            "total_failure": 0,
            "total_failure_toolong": 0,
            "total_messages": 2,
            "total_success": 2,
            "unsubs_status_updated": 0,
            "unsubs_total": 0,
            "unsubs_unique": 0
          }
        }
      ]
    },
    "dispatch": {
      "autowinner_delay_amount": 1,
      "autowinner_delay_unit": "minutes",
      "autowinner_enabled": true,
      "autowinner_metric": "opens_unique",
      "autowinner_percentage": "20.0",
      "begins_at": "2015-05-05T14:36:12Z",
      "finished_at": "2015-05-05T14:37:20Z",
      "from_email": "sender@discardallmail.drh.net",
      "from_name": "Studio Sender",
      "paused": false,
      "reply_to": "",
      "sender_email": "",
      "speed": 0,
      "started_at": "2015-05-05T14:36:15Z",
      "state": "finished",
      "track_links": true,
      "track_opens": true,
      "url_domain_id": 1,
      "virtual_mta_id": 0,
      "state_description": "Step 4: Finished",
      "virtual_mta_name": "System Default Route",
      "virtual_mta_type": "default_route",
      "bounce_email_user_id": 1,
      "bounce_email_domain_id": 1,
      "bounce_email_email": "return@example.com",
      "url_domain_domain": "example.com",
      "seed_lists": [

      ],
      "special_sending_rule_id": null,
      "special_sending_rule_name": null,
      "seed_list_id": null,
      "seed_list_name": null
    },
    "campaign_contents": [
      {
        "id": 4,
        "name": "Content A",
        "subject": "aaaaa",
        "html": "<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n<p>aaaaa</p>\n</body>\n</html>",
        "text": "",
        "format": "html"
      },
      {
        "id": 5,
        "name": "Content B",
        "subject": "bbbb",
        "html": "<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n<p>bbbb</p>\n</body>\n</html>",
        "text": "",
        "format": "html"
      },
      {
        "id": 6,
        "name": "Content C",
        "subject": "cccc",
        "html": "<!DOCTYPE html>\n<html>\n<head>\n</head>\n<body>\n<p>cccc</p>\n</body>\n</html>",
        "text": "",
        "format": "html"
      }
    ],
    "segmentation_criteria_name": null
  },
  "error_code": null,
  "error_message": null
}
```



### Create a new campaign

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/campaigns

#### Request Parameters

The POST request should have a JSON document in its payload with at least keys that marked with bold in the following list:

<table>

  <tr>
    <td><b>name</b><br><em>string</em></td>
    <td>The name of the campaign.</td>
  </tr>

  <tr>
    <td><b>source_template_id</b><br><em>integer</em></td>
    <td>
      Use the specified template as a base when creating this new campaign.
      Any other fields supplied in this request will overwrite the values inherited from the template.
    </td>
  </tr>

  <tr>
    <td><b>segmentation_criteria_id</b><br><em>integer</em></td>
    <td>
      The ID of the segmentation criteria to use when delivering this campaign.
      Only one of <code>segmentation_criteria_id</code>, <code>segmentation_criteria_ad_hoc</code>, and <code>segmentation_criteria_remote_sql</code> may be specified.
    </td>
  </tr>
  <tr>
    <td><b>segmentation_criteria_ad_hoc</b><br><em>array of hashes</em></td>
    <td>
      An ad hoc segmentation criteria specification - see the "Ad Hoc Segmentation Criteria" section below for more details.
      Only one of <code>segmentation_criteria_id</code>, <code>segmentation_criteria_ad_hoc</code>, and <code>segmentation_criteria_remote_sql</code> may be specified.
    </td>
  </tr>
  <tr>
    <td><b>segmentation_criteria_remote_sql</b><br><em>integer</em></td>
    <td>
      The SQL to use when querying the remote database for this campaign. This only applies to <a href="../remote_lists.markdown">Remote Lists</a>.
      Only one of <code>segmentation_criteria_id</code>, <code>segmentation_criteria_ad_hoc</code>, and <code>segmentation_criteria_remote_sql</code> may be specified.
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>contents</b><br><em>array of hashes</em><br>
      <table>
        <tr>
          <td><b>name</b><br><em>string</em></td>
          <td>String identifier for this content.</td>
        </tr>
        <tr>
          <td><b>subject</b><br><em>string</em></td>
          <td>The subject of the email.</td>
        </tr>
        <tr>
          <td><b>format</b><br><em>string</em></td>
          <td>Email format to use when delivering this campaign. Valid formats include <code>html</code>, <code>text</code>, and <code>both</code>.</td>
        </tr>
        <tr>
          <td><b>html</b><br><em>string</em></td>
          <td>If format is <code>html</code> or <code>both</code>, this is the HTML portion of the email.</td>
        </tr>
        <tr>
          <td><b>text</b><br><em>string</em></td>
          <td>If format is <code>text</code> or <code>both</code>, this is the plaintext portion of the email.</td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td colspan="2">
      <b>dispatch_attributes</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>state</b><br><em>string</em></td>
          <td>
            The state of delivery; Can be one of: "idle", "scheduled", "sending", "finished", "failed", "cancelled"
          </td>
        </tr>
        <tr>
          <td><b>state_description</b><br><em>string</em></td>
          <td>
            Localized textual description of the state.
          </td>
        </tr>
        <tr>
          <td><b>virtual_mta_id</b><br><em>integer</em></td>
          <td>
            The ID of a Virtual MTA explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting.
          </td>
        </tr>
        <tr>
          <td><b>virtual_mta_name</b><br><em>string</em></td>
          <td>
            The name of a Virtual MTA explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>bounce_email_id</b><br><em>string</em></td>
          <td>
            The ID of a Bounce Email explicitly assigned to the Campaign; Will come blank if Campaign is about to use general setting.
          </td>
        </tr>
        <tr>
          <td><b>bounce_email_name</b><br><em>string</em></td>
          <td>
            The Bounce Email explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>url_domain_id</b><br><em>integer</em></td>
          <td>
            The ID of an URL domain explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>url_domain_name</b><br><em>string</em></td>
          <td>
            The URL domain explicitly assigned to the Campaign.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_id</b><br><em>integer</em></td>
          <td>
            <em>Deprecated:</em> The ID of the first seed list assigned to the Campaign, ordered by ID. Use <code>seed_lists</code> instead.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_name</b><br><em>string</em></td>
          <td>
            <em>Deprecated:</em> The name of the first seed list assigned to the Campaign, ordered by ID. Use <code>seed_lists</code> instead.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_ids</b><br><em>array of integers</em></td>
          <td>
            An array of seed lists assigned to the Campaign, where each entry is the ID of a seed list to use.
          </td>
        </tr>
        <tr>
          <td><b>seed_list_names</b><br><em>array of strings</em></td>
          <td>
            An array of seed lists assigned to the Campaign, where each entry is the name of a seed list to use.
          </td>
        </tr>
        <tr>
          <td><b>speed</b><br><em>integer</em></td>
          <td>
            Maximum throughput speed; <code>0</code> for unlimited throughput.
          </td>
        </tr>
        <tr>
          <td><b>track_opens</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign will track openings stats.
          </td>
        </tr>
        <tr>
          <td><b>track_links</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign will track clicks stats.
          </td>
        </tr>
        <tr>
          <td><b>paused</b><br><em>boolean</em></td>
          <td>
            Marks whether the Campaign has been paused.
          </td>
        </tr>
        <tr>
          <td><b>from_name</b><br><em>string</em></td>
          <td>
            Name to use in the "From:" field.
          </td>
        </tr>
        <tr>
          <td><b>from_email</b><br><em>string</em></td>
          <td>
            Email to use in the "From:" field.
          </td>
        </tr>
        <tr>
          <td><b>reply_to</b><br><em>string</em></td>
          <td>
            Email to use in the "ReplyTo:" field.
          </td>
        </tr>
        <tr>
          <td><b>sender_email</b><br><em>string</em></td>
          <td>
            Email to use in the "Sender:" field.
          </td>
        </tr>
        <tr>
          <td><b>begins_at</b><br><em>string</em></td>
          <td>
            Time to start delivery at. If this value is specified and the
            campaign has a segment, content, and delivery settings - the
            campaign will be marked as scheduled and sending will begin at the
            requested time. If one of those sections are missing or this value
            is blank, the campaign will remain in an "idle" state.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_enabled</b><br><em>boolean</em></td>
          <td>
            The campaign is configured to use automatic winner selection.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_percentage</b><br><em>string</em></td>
          <td>
            The percentage that will be sent for the split-test portion of the campaign. See note (1) below.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_delay_amount</b><br><em>integer</em></td>
          <td>
            The number of units of time that the campaign will wait before finishing after a split-test.
        </tr>
        <tr>
          <td><b>autowinner_delay_unit</b><br><em>string</em></td>
          <td>
            The unit used in calculating the delay duration. This may be <code>minutes</code>, <code>hours</code>, or <code>days</code>.
          </td>
        </tr>
        <tr>
          <td><b>autowinner_metric</b><br><em>string</em></td>
          <td>
            The metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.
          </td>
        </tr>
        <tr>
          <td><b>special_sending_rule_id</b><br><em>integer</em></td>
          <td>
            The ID of the Special Sending Rule used for this campaign. Special Sending Rules may only be used on the System Organization. See note (4) below.
          </td>
        </tr>
        <tr>
          <td><b>special_sending_rule_name</b><br><em>string</em></td>
          <td>
            The name of the Special Sending Rule used for this campaign. See note (4) below.
          </td>
        </tr>
      </table>
    </td>
  </tr>

</table>

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
4. Only one of `special_sending_rule_id` and `special_sending_rule_name` may be
   present in a single request. Special Sending Rules are only valid on the System Organization.

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

```json
> POST /ga/api/mailing_lists/1/campaigns HTTP/1.1
> Authorization: Basic MTpkZDVjNmQ5NWM1Y2QyMDFmNDM1OTNhM2JlNjc4MmMyYjNhMGVhODhj
> Accept: application/json
> Content-Type: application/json

{
  "campaign": {
    "name": "Daily News 1002",
    "contents": [
      {
        "name": "multipart content",
        "format": "both",
        "subject": "this is my email",
        "html": "hello world",
        "text": "a text part"
      },
      {
        "name": "plaintext content",
        "format": "text",
        "subject": "this is my plaintext email",
        "text": "hello world"
      }
    ],
    "segmentation_criteria_ad_hoc": [

    ],
    "dispatch_attributes": {
      "state": "scheduled",
      "from_email": "from@example.com",
      "from_name": "From Example",
      "speed": 0,
      "virtual_mta_id": 0,
      "bounce_email_id": "1@1",
      "url_domain_id": 1,
      "begins_at": "2015-01-22 11:10AM CST",
      "track_opens": true,
      "track_links": "1"
    }
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "1ff490406b54210615c6fdb88cc3d4c5"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=ec45b74de869d92a0a80b8108e2b2ac6; path=/; HttpOnly
< X-Request-Id: 6613fc943a2c20ff3571639c2c968c6e
< X-Runtime: 0.212025
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "active_html_editor": "ckeditor",
    "archived": false,
    "content_determined": true,
    "created_at": "2015-05-05T20:34:41Z",
    "id": 5,
    "mailing_list_id": 1,
    "name": "Daily News 1002",
    "organization_id": 1,
    "segmentation_criteria_id": 5,
    "template": false,
    "updated_at": "2015-05-05T20:34:41Z",
    "mailing_list_name": "Default Mailing List",
    "organization_name": "System Organization",
    "stat_summary": null,
    "content_stats": [
      {
        "content": {
          "id": 11,
          "name": "multipart content"
        },
        "stat_summary": null
      },
      {
        "content": {
          "id": 12,
          "name": "plaintext content"
        },
        "stat_summary": null
      }
    ],
    "automatic_winner_selection": null,
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
      "special_sending_rule_id": null,
      "special_sending_rule_name": null,
      "seed_list_id": null,
      "seed_list_name": null
    },
    "campaign_contents": [
      {
        "id": 11,
        "name": "multipart content",
        "subject": "this is my email",
        "html": "hello world",
        "text": "a text part",
        "format": "both"
      },
      {
        "id": 12,
        "name": "plaintext content",
        "subject": "this is my plaintext email",
        "html": "",
        "text": "hello world",
        "format": "text"
      }
    ],
    "segmentation_criteria_name": null
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

```json
> PUT /ga/api/mailing_lists/1/campaigns/5 HTTP/1.1
> Authorization: Basic MTpkZDVjNmQ5NWM1Y2QyMDFmNDM1OTNhM2JlNjc4MmMyYjNhMGVhODhj
> Accept: application/json
> Content-Type: application/json

{
  "campaign": {
    "name": "My Campaign's New Name 3"
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "37499a62c4458bd1fb26c47a1b010817"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=a8c605f6f4346e20a04f07058dc8e800; path=/; HttpOnly
< X-Request-Id: 1afa82fcf5f5c794c59d28d63ef3aa92
< X-Runtime: 0.037008
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "active_html_editor": "ckeditor",
    "archived": false,
    "content_determined": true,
    "created_at": "2015-05-05T20:34:41Z",
    "id": 5,
    "mailing_list_id": 1,
    "name": "My Campaign's New Name 3",
    "organization_id": 1,
    "segmentation_criteria_id": 5,
    "template": false,
    "updated_at": "2015-05-05T20:38:52Z",
    "mailing_list_name": "Default Mailing List",
    "organization_name": "System Organization",
    "stat_summary": {
      "sent_text": 11,
      "sent_html": 0,
      "sent_multipart": 10,
      "bounces_total": 0,
      "bounces_unique": 0,
      "bounces_unique_hard": 0,
      "bounces_unique_soft": 0,
      "bounces_unique_other": 0,
      "bounces_unique_local": 0,
      "bounces_unique_remote": 0,
      "clicks_total": 0,
      "clicks_unique": 0,
      "clicks_unique_by_link": 0,
      "opens_total": 0,
      "opens_unique": 0,
      "scomps_total": 0,
      "scomps_unique": 0,
      "scomps_status_updated": 0,
      "unsubs_total": 0,
      "unsubs_unique": 0,
      "unsubs_status_updated": 0,
      "bounces_status_updated": 0,
      "total_messages": 21,
      "total_success": 21,
      "total_failure": 0,
      "total_failure_toolong": 0,
      "skips_error": 0,
      "skips_request": 0,
      "stat_id": 15,
      "bounces_unique_by_code": {
      },
      "messages_sent": 21,
      "messages_html": 10,
      "messages_text": 11,
      "accepted": 21,
      "accepted_rate": 1.0,
      "in_queue": 0,
      "in_queue_rate": 0.0,
      "max_unique_activities": 0,
      "open_rate": 0.0,
      "open_ratio": 0.0,
      "unopened": 21,
      "duplicate_opens": 0,
      "duplicate_clicks": 0,
      "click_rate": 0.0,
      "click_to_open_rate": 0.0,
      "unclicked": 21,
      "bounced": 0,
      "duplicate_bounces": 0,
      "unbounced": 21,
      "bounce_rate": 0.0,
      "bounce_rate_hard": 0.0,
      "bounce_rate_soft": 0.0,
      "bounce_rate_other": 0.0,
      "bounce_local_rate": 0.0,
      "duplicate_scomps": 0,
      "duplicate_unsubs": 0,
      "unsub_rate": 0.0
    },
    "content_stats": [
      {
        "content": {
          "id": 11,
          "name": "multipart content"
        },
        "stat_summary": {
          "sent_text": 0,
          "sent_html": 0,
          "sent_multipart": 10,
          "bounces_total": 0,
          "bounces_unique": 0,
          "bounces_unique_hard": 0,
          "bounces_unique_soft": 0,
          "bounces_unique_other": 0,
          "bounces_unique_local": 0,
          "bounces_unique_remote": 0,
          "clicks_total": 0,
          "clicks_unique": 0,
          "clicks_unique_by_link": 0,
          "opens_total": 0,
          "opens_unique": 0,
          "scomps_total": 0,
          "scomps_unique": 0,
          "scomps_status_updated": 0,
          "unsubs_total": 0,
          "unsubs_unique": 0,
          "unsubs_status_updated": 0,
          "bounces_status_updated": 0,
          "total_messages": 10,
          "total_success": 10,
          "total_failure": 0,
          "total_failure_toolong": 0,
          "skips_error": 0,
          "skips_request": 0,
          "stat_slice_id": 16,
          "bounces_unique_by_code": {
          },
          "messages_sent": 10,
          "messages_html": 10,
          "messages_text": 0,
          "accepted": 10,
          "accepted_rate": 1.0,
          "in_queue": 0,
          "in_queue_rate": 0.0,
          "max_unique_activities": 0,
          "open_rate": 0.0,
          "open_ratio": 0.0,
          "unopened": 10,
          "duplicate_opens": 0,
          "duplicate_clicks": 0,
          "click_rate": 0.0,
          "click_to_open_rate": 0.0,
          "unclicked": 10,
          "bounced": 0,
          "duplicate_bounces": 0,
          "unbounced": 10,
          "bounce_rate": 0.0,
          "bounce_rate_hard": 0.0,
          "bounce_rate_soft": 0.0,
          "bounce_rate_other": 0.0,
          "bounce_local_rate": 0.0,
          "duplicate_scomps": 0,
          "duplicate_unsubs": 0,
          "unsub_rate": 0.0
        }
      },
      {
        "content": {
          "id": 12,
          "name": "plaintext content"
        },
        "stat_summary": {
          "sent_text": 11,
          "sent_html": 0,
          "sent_multipart": 0,
          "bounces_total": 0,
          "bounces_unique": 0,
          "bounces_unique_hard": 0,
          "bounces_unique_soft": 0,
          "bounces_unique_other": 0,
          "bounces_unique_local": 0,
          "bounces_unique_remote": 0,
          "clicks_total": 0,
          "clicks_unique": 0,
          "clicks_unique_by_link": 0,
          "opens_total": 0,
          "opens_unique": 0,
          "scomps_total": 0,
          "scomps_unique": 0,
          "scomps_status_updated": 0,
          "unsubs_total": 0,
          "unsubs_unique": 0,
          "unsubs_status_updated": 0,
          "bounces_status_updated": 0,
          "total_messages": 11,
          "total_success": 11,
          "total_failure": 0,
          "total_failure_toolong": 0,
          "skips_error": 0,
          "skips_request": 0,
          "stat_slice_id": 17,
          "bounces_unique_by_code": {
          },
          "messages_sent": 11,
          "messages_html": 0,
          "messages_text": 11,
          "accepted": 11,
          "accepted_rate": 1.0,
          "in_queue": 0,
          "in_queue_rate": 0.0,
          "max_unique_activities": 0,
          "open_rate": 0.0,
          "open_ratio": 0.0,
          "unopened": 11,
          "duplicate_opens": 0,
          "duplicate_clicks": 0,
          "click_rate": 0.0,
          "click_to_open_rate": 0.0,
          "unclicked": 11,
          "bounced": 0,
          "duplicate_bounces": 0,
          "unbounced": 11,
          "bounce_rate": 0.0,
          "bounce_rate_hard": 0.0,
          "bounce_rate_soft": 0.0,
          "bounce_rate_other": 0.0,
          "bounce_local_rate": 0.0,
          "duplicate_scomps": 0,
          "duplicate_unsubs": 0,
          "unsub_rate": 0.0
        }
      }
    ],
    "automatic_winner_selection": null,
    "dispatch": {
      "autowinner_delay_amount": null,
      "autowinner_delay_unit": "minutes",
      "autowinner_enabled": false,
      "autowinner_metric": null,
      "autowinner_percentage": null,
      "begins_at": "2015-01-22T17:10:00Z",
      "finished_at": "2015-05-05T20:34:48Z",
      "from_email": "from@example.com",
      "from_name": "From Example",
      "paused": false,
      "reply_to": null,
      "sender_email": null,
      "speed": 0,
      "started_at": "2015-05-05T20:34:44Z",
      "state": "finished",
      "track_links": true,
      "track_opens": true,
      "url_domain_id": 1,
      "virtual_mta_id": 0,
      "state_description": "Step 4: Finished",
      "virtual_mta_name": "System Default Route",
      "virtual_mta_type": "default_route",
      "bounce_email_user_id": 1,
      "bounce_email_domain_id": 1,
      "bounce_email_email": "return@example.com",
      "url_domain_domain": "example.com",
      "seed_lists": [

      ],
      "special_sending_rule_id": null,
      "special_sending_rule_name": null,
      "seed_list_id": null,
      "seed_list_name": null
    },
    "campaign_contents": [
      {
        "id": 11,
        "name": "multipart content",
        "subject": "this is my email",
        "html": "hello world",
        "text": "a text part",
        "format": "both"
      },
      {
        "id": 12,
        "name": "plaintext content",
        "subject": "this is my plaintext email",
        "html": "",
        "text": "hello world",
        "format": "text"
      }
    ],
    "segmentation_criteria_name": null
  },
  "error_code": null,
  "error_message": null
}
```



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
          "special_sending_rule_id": null,
          "special_sending_rule_name": null
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
