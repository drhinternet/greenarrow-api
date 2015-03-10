## System Campaigns

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Get a list of campaigns across all organizations](#get-a-list-of-campaigns-across-all-organizations)
  - [URL](#url)
  - [Request Parameters](#request-parameters)
  - [Pagination Order](#pagination-order)
  - [Response](#response)
  - [Example](#example)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

### Get a list of campaigns across all organizations

This API provides a way for system administrators to access the list of all
campaigns that have started sending, across the system.

* Campaigns that are currently sending
* Campaigns that started sending and were subsequently paused
* Campaigns that failed or were cancelled
* Campaigns that finished sending

The API user that accesses this endpoint must be a `system_admin`.

#### URL

    GET /ga/api/v2/system_campaigns

#### Request Parameters

This endpoint accepts pagination parameters.

| Key           | Description                                               |
| ------------- | --------------------------------------------------------- |
| `page`        | The page number to return (starting at 0)                 |
| `per_page`    | The number of records per page (default 100, maximum 500) |

This endpoint also accepts parameters to filter based on the time that the campaign started.

| Key                 | Description                                                                          |
| ------------------- | ------------------------------------------------------------------------------------ |
| `started_at__start` | An ISO 8601 Date/Time string representing the earliest `started_at` time to include. |
| `started_at__end`   | An ISO 8601 Date/Time string representing the latest `started_at` time to include.   |

Furthermore, you can provide provide a key to exclude `sending` campaigns from this report.

| Key                        | Description                                                                   |
| -------------------------- | ----------------------------------------------------------------------------- |
| `exclude_active_campaigns` | Only report campaigns that are Finished, Cancelled or Failed (value: 1 or 0). |

#### Pagination Order

The campaigns returned are sorted in the following order:

1. By the time the campaign started sending (this is usually unique)
2. By the campaign ID

#### Response

<table>
  <tr>
    <td colspan="2">
      <b>campaign_report</b> &mdash; <em>array of hashes</em><br>
      <table>
        <tr>
          <td colspan="2">
            <b>organization</b> &mdash; <em>hash</em><br>
            <table>
              <tr>
                <td width="20%"><b>id</b><br><em>integer</em></td>
                <td width="80%">Organization ID</td>
              </tr><tr>
                <td width="20%"><b>name</b><br><em>string</em></td>
                <td width="80%">Organization Name</td>
              </tr>
            </table>
          </td>
        </tr><tr>
          <td colspan="2">
            <b>mailing_list</b> &mdash; <em>hash</em><br>
            <table>
              <tr>
                <td width="20%"><b>id</b><br><em>integer</em></td>
                <td width="80%">Mailing List ID</td>
              </tr><tr>
                <td width="20%"><b>name</b><br><em>string</em></td>
                <td width="80%">Mailing List Name</td>
              </tr>
            </table>
          </td>
        </tr><tr>
          <td colspan="2">
            <b>campaign</b> &mdash; <em>hash</em><br>
            <table>
              <tr>
                <td width="20%"><b>id</b><br><em>integer</em></td>
                <td width="80%">Campaign ID</td>
              </tr><tr>
                <td width="20%"><b>name</b><br><em>string</em></td>
                <td width="80%">Campaign Name</td>
              </tr><tr>
                <td width="20%"><b>state</b><br><em>string</em></td>
                <td width="80%">Campaign State (<code>sending</code>, <code>finished</code>, <code>failed</code>, <code>cancelled</code>)</td>
              </tr><tr>
                <td width="20%"><b>paused</b><br><em>boolean</em></td>
                <td width="80%">The campaign is currently paused.</td>
              </tr><tr>
                <td colspan="2">
                  <b>stats</b><br><em>hash</em><br>
                  <table>
                    <tr>
                      <td colspan="2">
                        <b>recipients</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total recipients in this campaign</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>sent</b><br><em>integer</em></td>
                            <td width="80%">Number of recipients that were sent an email</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>skip</b><br><em>integer</em></td>
                            <td width="80%">Number of recipients that were skipped due to Special Sending Rules</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>remaining</b><br><em>integer</em></td>
                            <td width="80%">Number of recipients remaining in this campaign</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>sent</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total messages sent so far in this campaign</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>accepted</b><br><em>integer</em></td>
                            <td width="80%">Number of messages that have been accepted by a SMTP server (and are no longer in Engine's queue)</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>bounced</b><br><em>integer</em></td>
                            <td width="80%">Number of messages that resulted in bounces</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>in_queue</b><br><em>integer</em></td>
                            <td width="80%">Number of messages in Engine's queue waiting for delivery</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>skip</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>ssr_failure</b><br><em>integer</em></td>
                            <td width="80%">Number of messages that failed because of an error in a Special Sending Rule</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>ssr_request</b><br><em>integer</em></td>
                            <td width="80%">Number of messages that were skipped because a Special Sending Rule indicated it should be skipped</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>open</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total number of opens / renders, including duplicates</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>unique</b><br><em>integer</em></td>
                            <td width="80%">Number of unique opens / renders</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>click</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total number of clicks, including duplicates</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>unique</b><br><em>integer</em></td>
                            <td width="80%">Number of unique clicks</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>bounce</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total number of bounces, including duplicates</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>unique</b><br><em>integer</em></td>
                            <td width="80%">Number of unique bounces</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>hard</b><br><em>integer</em></td>
                            <td width="80%">Number of unique hard bounces</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>soft</b><br><em>integer</em></td>
                            <td width="80%">Number of unique soft bounces</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>other</b><br><em>integer</em></td>
                            <td width="80%">Number of unique other bounces</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>subscribers_updated</b><br><em>integer</em></td>
                            <td width="80%">Number of subscribers whose status changed due to a bounce</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>scomp</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total number of spam complaints, including duplicates</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>unique</b><br><em>integer</em></td>
                            <td width="80%">Number of unique spam complaints</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>subscribers_updated</b><br><em>integer</em></td>
                            <td width="80%">Number of subscribers whose status changed due to a spam complaint</td>
                          </tr>
                        </table>
                      </td>
                    </tr><tr>
                      <td colspan="2">
                        <b>unsub</b> &mdash; <em>hash</em><br>
                        <table>
                          <tr>
                            <td width="20%"><b>total</b><br><em>integer</em></td>
                            <td width="80%">Total number of unsubscribes, including duplicates</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>unique</b><br><em>integer</em></td>
                            <td width="80%">Number of unique unsubscribes</td>
                          </tr>
                          <tr>
                            <td width="20%"><b>subscribers_updated</b><br><em>integer</em></td>
                            <td width="80%">Number of subscribers whose status changed due to an unsubscribe</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

This endpoint also returns pagination details.

| Key           | Description                                      |
| ------------- | ------------------------------------------------ |
| `page`        | The current page number                          |
| `per_page`    | The number of records per page                   |
| `num_records` | The total number of records that match the query |
| `num_pages`   | The total number of pages that match the query   |

#### Example

```
> GET /ga/api/system_campaigns HTTP/1.1
> Authorization: Basic MTozNTZjNTg0ZWM4YWJlMWQ0NDY0OGZlMTY3MmVkM2ZlYmVkYTQxNWRh
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "427f115a558eb8134d5d20711c6e276e"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=dad8e99250c3941d201628a809cf4f85; path=/; HttpOnly
< X-Request-Id: 827177bb507f40519e575d74b25898e4
< X-Runtime: 0.058486
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "error_code": null,
  "error_message": null,
  "page": 0,
  "per_page": 100,
  "data": {
    "campaign_report": [
      {
        "organization": {
          "id": 1,
          "name": "System Organization"
        },
        "mailing_list": {
          "id": 1,
          "name": "Default Mailing List"
        },
        "campaign": {
          "id": 1,
          "name": "Default Campaign",
          "state": "failed",
          "stats": {
            "recipients": {
              "total": 2,
              "sent": 1,
              "skip": 1,
              "remaining": 1
            },
            "sent": {
              "total": 0,
              "accepted": 0,
              "bounced": 0,
              "in_queue": 0
            },
            "skip": {
              "ssr_failure": 0,
              "ssr_request": 1
            },
            "open": {
              "total": 0,
              "unique": 0
            },
            "click": {
              "total": 0,
              "unique": 0
            },
            "bounce": {
              "total": 0,
              "unique": 0,
              "hard": 0,
              "soft": 0,
              "other": 0,
              "subscribers_updated": 0
            },
            "scomp": {
              "total": 0,
              "unique": 0,
              "subscribers_updated": 0
            },
            "unsub": {
              "total": 0,
              "unique": 0,
              "subscribers_updated": 0
            }
          }
        }
      },
      {
        "organization": {
          "id": 1,
          "name": "System Organization"
        },
        "mailing_list": {
          "id": 1,
          "name": "Default Mailing List"
        },
        "campaign": {
          "id": 2,
          "name": "Default Campaign (Duplicate #1)",
          "state": "failed",
          "stats": {
            "recipients": {
              "total": 2,
              "sent": 1,
              "skip": 1,
              "remaining": 1
            },
            "sent": {
              "total": 0,
              "accepted": 0,
              "bounced": 0,
              "in_queue": 0
            },
            "skip": {
              "ssr_failure": 0,
              "ssr_request": 1
            },
            "open": {
              "total": 0,
              "unique": 0
            },
            "click": {
              "total": 0,
              "unique": 0
            },
            "bounce": {
              "total": 0,
              "unique": 0,
              "hard": 0,
              "soft": 0,
              "other": 0,
              "subscribers_updated": 0
            },
            "scomp": {
              "total": 0,
              "unique": 0,
              "subscribers_updated": 0
            },
            "unsub": {
              "total": 0,
              "unique": 0,
              "subscribers_updated": 0
            }
          }
        }
      }
    ]
  }
}
```
