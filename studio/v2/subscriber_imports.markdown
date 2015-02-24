## Subscriber Imports

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Definitions](#definitions)
  - [Subscriber Import States](#subscriber-import-states)
  - [Mapping Array](#mapping-array)
  - [Default Custom Fields](#default-custom-fields)
  - [Date/Time Fields](#datetime-fields)
- [Get a list of subscriber imports](#get-a-list-of-subscriber-imports)
  - [URL](#url)
  - [Request Parameters](#request-parameters)
  - [Pagination](#pagination)
  - [Order](#order)
  - [Response](#response)
  - [Example Request](#example-request)
- [Get expanded details about a subscriber import](#get-expanded-details-about-a-subscriber-import)
  - [URL](#url-1)
  - [Response](#response-1)
  - [Example Request](#example-request-1)
- [Create a new subscriber import](#create-a-new-subscriber-import)
  - [URL](#url-2)
  - [Request](#request)
  - [Response](#response-2)
  - [Example Request](#example-request-2)
- [Pause or unpause a subscriber import](#pause-or-unpause-a-subscriber-import)
  - [URL](#url-3)
  - [Response](#response-3)
- [Cancel a subscriber import](#cancel-a-subscriber-import)
  - [URL](#url-4)
  - [Response](#response-4)
- [Read import logs](#read-import-logs)
  - [URL](#url-5)
  - [Types of logs](#types-of-logs)
  - [Response](#response-5)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

### Definitions

#### Subscriber Import States

<!-- BEGIN table subscriber_import_states -->

| Value       | Description                                           |
| ----------- | ----------------------------------------------------- |
| `idle`      | The import has not yet been scheduled                 |
| `scheduled` | The import has been scheduled and is waiting to start |
| `splitting` | The import is being prepared and analyzed             |
| `importing` | The import is now being processed                     |
| `paused`    | The import has been paused                            |
| `finished`  | The import finished successfully                      |
| `failed`    | There was an internal error during this import        |
| `cancelled` | The import was permanently cancelled                  |

<!-- END table subscriber_import_states -->

#### Mapping Array

The mapping array declares how each column of the CSV import maps to the subscriber record.

| Key              | Description                                                                                                                                 |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| `email`          | **Required** The email address for this subscriber record.                                                                                  |
| `status`         | The status for this subscriber record. See the "Subscriber Statuses" table for a list of values.                                            |
| `confirmed`      | True or false value for this subscriber's confirmed field. Only applies if the mailing list has the confirmed field enabled.                |
| `email_format`   | The email format for this subscriber. Can be `html`, `text` or `both`. Only applies if the mailing list has the email format field enabled. |
| `subscribe_time` | The time at which the subscriber subscribed.                                                                                                |
| `subscribe_ip`   | The IP from which the subscriber subscribed.                                                                                                |
| `remove_time`    | The time at which the subscriber was removed from the list.                                                                                 |
| `remove_ip`      | The IP from which the subscriber was removed from the list.                                                                                 |

Custom Fields can be mapped to columns in the import file using their name. For
example, for a CSV file that contains four columns (Email, Subscribe Time,
Subscribe IP and data for a custom field "First Name").

```json
"mapping": [
  "email",
  "subscribe_time",
  "subscribe_ip",
  "First Name"
]
```

#### Default Custom Fields

The `default_custom_fields` on a subscriber import are values that are set for
each new subscriber in the import.

If `overwrite_custom_fields` is set, then these values will also be applied to
updated subscribers.

The `default_custom_fields` values should be set as a hash of custom field
names to values.

Here is an example, with `Subscriber Name` as a text field and
`Preferred Cars` as a checkboxes field:

```json
"default_custom_fields": {
  "Subscriber Name": "Bob Example",
  "Preferred Cars": [ "Toyota", "Kia" ]
}
```

#### Date/Time Fields

Custom field import data can include date/times for the following fields: `Date Custom Fields`,
`Day of Year Custom Fields`, `Subscribe Time`, `Remove Time`, and `Confirm Time`

The following date/time formats are accepted for these values.

* `1994-03-11T14:30:47-06:00`
* `March 11, 1994 14:30`
* `March 11, 1994`
* `11 March 1994`
* `03-11-1994 2:30:47pm`
* `03-11-1994 14:30:47`
* `03-11-1994 2:30pm`
* `03-11-1994 14:30`
* `03-11-1994`
* `03/11/1994 2:30:47pm`
* `03/11/1994 14:30:47`
* `03/11/1994 2:30pm`
* `03/11/1994 14:30`
* `03/11/1994`
* `1994-03-11 14:30`
* `1994-03-11`

Note: Other formats may be parsed successfully, but we recommend that you stick
to this list of accepted formats.

Note: The ambiguous date formats (for example, should `5/11/2014` be `May 11, 2014`
or `November 5, 2014`) are clarified by the `date_format` field. See the documentation
below for details on how to set it.


### Get a list of subscriber imports

Get a list of subscriber imports, filterable by state.

#### URL

    GET /ga/api/v2/subscriber_imports

    GET /ga/api/v2/subscriber_imports?scope=active

    GET /ga/api/v2/subscriber_imports?scope=finished

    GET /ga/api/v2/subscriber_imports?scope=all

To get the subscriber imports for a specific mailing list:

    GET /ga/api/v2/mailing_lists/:mailing_list_id/subscriber_imports

    GET /ga/api/v2/mailing_lists/:mailing_list_id/subscriber_imports?scope=:scope

#### Request Parameters

Provide a `scope` parameter to filter the subscriber imports returned.

| Scope       | Description                                                                          |
| ----------- | ------------------------------------------------------------------------------------ |
| `finished`  | All finished subscriber imports                                                      |
| `active`    | All incomplete subscriber imports                                                    |
| `recent`    | **Default** All incomplete and recently (within 2 weeks) finished subscriber imports |
| `all`       | All subscriber imports                                                               |

This API returns the first 100 records by default and supports pagination.

#### Pagination

To query additional records, provide `page` and `per_page` parameters. The `page` parameter starts at `0`.
The `per_page` parameter defaults to `100` and the maximum allowed is `500`.

For example to get the second page:

    GET /ga/api/v2/subscriber_imports?scope=all&page=1&per_page=100

The response will also contain the following extra parameters:

| Key           | Description                                      |
| ------------- | ------------------------------------------------ |
| `page`        | The current page number                          |
| `per_page`    | The number of records per page                   |
| `num_records` | The total number of records that match the query |
| `num_pages`   | The total number of pages that match the query   |

#### Order

Imports are returned in this order:

* non-finished/cancelled imports with the soonest scheduled time first (oldest `begins_at` first), then
* finished/cancelled imports with the most recently completed first (newest `finished_at` first)

#### Response

The response will be a JSON array where each element contains the following keys.

<!-- BEGIN object subscriber_import -->

<table>
  <tr>
    <td><b>id</b><br><em>integer</em></td>
    <td>The internal identifier for this subscriber import</td>
  </tr>
  <tr>
    <td><b>mailing_list_id</b><br><em>integer</em></td>
    <td>The ID of the mailing list this import is adding to.</td>
  </tr>
  <tr>
    <td><b>mailing_list_name</b><br><em>string</em></td>
    <td>The name of the mailing list this import is adding to.</td>
  </tr>
  <tr>
    <td><b>created_at</b><br><em>datetime</em></td>
    <td>Timestamp when this import was originally created.</td>
  </tr>
  <tr>
    <td><b>state</b><br><em>string</em></td>
    <td>The current state of this import.</td>
  </tr>
  <tr>
    <td><b>begins_at</b><br><em>datetime</em></td>
    <td>The time at which this import is scheduled to begin.</td>
  </tr>
  <tr>
    <td><b>finished_at</b><br><em>datetime</em></td>
    <td>The time at which this import finished.</td>
  </tr>
  <tr>
    <td colspan="2">
      <b>file_source</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>type</b><br><em>string</em></td>
          <td>The source of the data to use for this import. This can be <code>json</code> or <code>upload_directory</code>.</td>
        </tr>
        <tr>
          <td><b>filename</b><br><em>string</em></td>
          <td>For <code>upload_directory</code> imports, this is the filename of the local file in the user upload directory.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>stats</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>number_of_records</b><br><em>integer</em></td>
          <td>The total number of rows that were detected in the import&#x27;s input file.</td>
        </tr>
        <tr>
          <td><b>records_imported</b><br><em>integer</em></td>
          <td>The total number of rows that were processed during the import.</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- END object subscriber_import -->

#### Example Request

```
> GET /ga/api/mailing_lists/1/subscriber_imports HTTP/1.1
> Authorization: Basic MToyMTk5MzY2YTAzYWM3OWE1N2YwYTRlNzYwZWQyZTNkOGJkNzBjOWYw
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "d64fa2907baedf9f003a3dc9c5f6c483"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=f1e4a07566f9b284bd84cac355afde56; path=/; HttpOnly
< X-Request-Id: 2478536084b570ad8c223c0f3ad11010
< X-Runtime: 0.023404
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "error_code": null,
  "error_message": null,
  "page": 0,
  "per_page": 100,
  "data": [
    {
      "id": 15,
      "mailing_list_id": 1,
      "mailing_list_name": "Default Mailing List",
      "created_at": "2015-01-15T20:53:18Z",
      "state": "finished",
      "begins_at": "2015-01-15T20:53:18Z",
      "finished_at": "2015-01-15T20:53:20Z",
      "stats": {
        "number_of_records": 2,
        "records_imported": 2
      },
      "file_source": {
        "type": "json",
        "filename": "data"
      }
    },
    {
      "id": 14,
      "mailing_list_id": 1,
      "mailing_list_name": "Default Mailing List",
      "created_at": "2015-01-15T20:51:31Z",
      "state": "finished",
      "begins_at": "2015-01-15T20:51:31Z",
      "finished_at": "2015-01-15T20:51:33Z",
      "stats": {
        "number_of_records": 1,
        "records_imported": 1
      },
      "file_source": {
        "type": "json",
        "filename": "data"
      }
    }
  ],
  "num_records": 2,
  "num_pages": 1
}
```



### Get expanded details about a subscriber import

Get details about a single subscriber import, with more details than the index provides.

#### URL

    GET /ga/api/v2/subscriber_imports/:id

#### Response

The response will be a JSON object with the following keys.

<!-- BEGIN object subscriber_import -->

<table>
  <tr>
    <td><b>id</b><br><em>integer</em></td>
    <td>The internal identifier for this subscriber import</td>
  </tr>
  <tr>
    <td><b>mailing_list_id</b><br><em>integer</em></td>
    <td>The ID of the mailing list this import is adding to.</td>
  </tr>
  <tr>
    <td><b>mailing_list_name</b><br><em>string</em></td>
    <td>The name of the mailing list this import is adding to.</td>
  </tr>
  <tr>
    <td><b>created_at</b><br><em>datetime</em></td>
    <td>Timestamp when this import was originally created.</td>
  </tr>
  <tr>
    <td><b>state</b><br><em>string</em></td>
    <td>The current state of this import.</td>
  </tr>
  <tr>
    <td><b>begins_at</b><br><em>datetime</em></td>
    <td>The time at which this import is scheduled to begin.</td>
  </tr>
  <tr>
    <td><b>finished_at</b><br><em>datetime</em></td>
    <td>The time at which this import finished.</td>
  </tr>
  <tr>
    <td><b>overwrite</b><br><em>boolean</em></td>
    <td>This import should overwrite existing subscribers with the same email address.</td>
  </tr>
  <tr>
    <td colspan="2">
      <b>overwrite_what</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>custom_fields</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should overwrite the custom fields.</td>
        </tr>
        <tr>
          <td><b>autoresponder</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, run autoresponders for the updated subscribers.</td>
        </tr>
        <tr>
          <td><b>confirmed</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should update the confirmed field.</td>
        </tr>
        <tr>
          <td><b>format</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should update the format field.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>overwrite_when_status</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>active</b><br><em>boolean</em></td>
          <td>This import should overwrite existing active subscribers.</td>
        </tr>
        <tr>
          <td><b>unsubscribed</b><br><em>boolean</em></td>
          <td>This import should overwrite existing unsubscribed subscribers.</td>
        </tr>
        <tr>
          <td><b>bounced</b><br><em>boolean</em></td>
          <td>This import should overwrite existing bounced subscribers.</td>
        </tr>
        <tr>
          <td><b>deactivated</b><br><em>boolean</em></td>
          <td>This import should overwrite existing deactivated subscribers.</td>
        </tr>
        <tr>
          <td><b>scomp</b><br><em>boolean</em></td>
          <td>This import should overwrite existing spam complaint subscribers.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><b>column_mapping</b><br><em>definition subscriber import mapping</em></td>
    <td>Import mapping to use, see the &quot;Mapping Array&quot; documentation above.</td>
  </tr>
  <tr>
    <td><b>default_custom_fields</b><br><em>definition subscriber import default custom fields</em></td>
    <td>The custom field values to assign to all subscribers in this import.</td>
  </tr>
  <tr>
    <td colspan="2">
      <b>file_source</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>type</b><br><em>string</em></td>
          <td>The source of the data to use for this import. This can be <code>json</code> or <code>upload_directory</code>.</td>
        </tr>
        <tr>
          <td><b>content</b><br><em>string</em></td>
          <td>For <code>json</code> imports, this is the CSV content of the import file.</td>
        </tr>
        <tr>
          <td><b>filename</b><br><em>string</em></td>
          <td>For <code>upload_directory</code> imports, this is the filename of the local file in the user upload directory.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>file_format</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>csv_has_headers</b><br><em>boolean</em></td>
          <td>The top line of this file is headers, don&#x27;t use it as a record.</td>
        </tr>
        <tr>
          <td><b>character_set</b><br><em>string</em></td>
          <td>The character set to use for this import. Defaults to <code>UTF-8</code>, can also be <code>ISO-8859-1</code>.</td>
        </tr>
        <tr>
          <td><b>csv_field_separator</b><br><em>string</em></td>
          <td>The character to use to separate fields. Defaults to <code>,</code>, can also be a literal tab (<code>"\t"</code> in JSON) for tabs.</td>
        </tr>
        <tr>
          <td><b>csv_field_enclosure</b><br><em>string</em></td>
          <td>The character to use to enclose fields. Defaults to <code>&quot;</code>, can also be <code>&#x27;</code> for single quotes.</td>
        </tr>
        <tr>
          <td><b>date_format</b><br><em>string</em></td>
          <td>
            <p>The date format to use when parsing `Date` custom fields, `Subscribe Time`, `Remove Time`, and `Confirm Time`. Defaults to <code>mdy</code>.</p>
            <p>A value of `mdy` will parse `01/02/2014` as `January 2, 2014`.</p>
            <p>A value of `dmy` will parse `01/02/2014` as `February 1, 2014`.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>stats</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>number_of_records</b><br><em>integer</em></td>
          <td>The total number of rows that were detected in the import&#x27;s input file.</td>
        </tr>
        <tr>
          <td><b>records_imported</b><br><em>integer</em></td>
          <td>The total number of rows that were processed during the import.</td>
        </tr>
        <tr>
          <td colspan="2">
            <b>subscribers</b><br><em>hash</em><br>
            <table>
              <tr>
                <td><b>added</b><br><em>integer</em></td>
                <td>The number of subscribers that were added to the mailing list in this import.</td>
              </tr>
              <tr>
                <td><b>updated</b><br><em>integer</em></td>
                <td>The number of existing subscribers that were updated on the mailing list in this import.</td>
              </tr>
              <tr>
                <td><b>failed</b><br><em>integer</em></td>
                <td>The number of rows that failed to be processed in this import.</td>
              </tr>
              <tr>
                <td><b>skipped_overwrite</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite.</td>
              </tr>
              <tr>
                <td><b>skipped_active</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite active subscribers.</td>
              </tr>
              <tr>
                <td><b>skipped_unsubscribed</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite unsubscribed subscribers.</td>
              </tr>
              <tr>
                <td><b>skipped_scomp</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite spam complaint subscribers.</td>
              </tr>
              <tr>
                <td><b>skipped_bounced</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite bounced subscribers.</td>
              </tr>
              <tr>
                <td><b>skipped_deactivated</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because this import is not set to overwrite deactivated subscribers.</td>
              </tr>
              <tr>
                <td><b>skipped_duplicate</b><br><em>integer</em></td>
                <td>The number of subscribers that were skipped because the same email address appeared earlier in the import.</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- END object subscriber_import -->

#### Example Request

```
> GET /ga/api/mailing_lists/1/subscriber_imports/15 HTTP/1.1
> Authorization: Basic MToyMTk5MzY2YTAzYWM3OWE1N2YwYTRlNzYwZWQyZTNkOGJkNzBjOWYw
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "d36e7bf33aa83b076d172cce7cd19e0e"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=a023e6220d8d6929013c6035f8a0ae5c; path=/; HttpOnly
< X-Request-Id: 42b255c3d98d4a86928afd5bd87deb69
< X-Runtime: 0.020476
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "id": 15,
    "mailing_list_id": 1,
    "mailing_list_name": "Default Mailing List",
    "created_at": "2015-01-15T20:53:18Z",
    "state": "finished",
    "begins_at": "2015-01-15T20:53:18Z",
    "finished_at": "2015-01-15T20:53:20Z",
    "stats": {
      "number_of_records": 2,
      "records_imported": 2,
      "subscribers": {
        "added": 1,
        "updated": 1,
        "failed": 0,
        "skipped_overwrite": 0,
        "skipped_active": 0,
        "skipped_unsubscribed": 0,
        "skipped_scomp": 0,
        "skipped_bounced": 0,
        "skipped_deactivated": 0,
        "skipped_duplicate": 0
      }
    },
    "file_source": {
      "type": "json",
      "filename": "data"
    },
    "file_format": {
      "character_set": "utf-8",
      "csv_has_headers": true,
      "csv_field_enclosure": "\"",
      "csv_field_separator": ",",
      "date_format": "mdy"
    },
    "subscriber_defaults": {
      "status": "active"
    },
    "overwrite": true,
    "overwrite_when_status": {
      "active": true,
      "unsubscribed": false,
      "bounced": false,
      "deactivated": false,
      "scomp": false
    },
    "column_mapping": [
      "email"
    ],
    "default_custom_fields": {
    },
    "overwrite_what": {
      "custom_fields": true,
      "autoresponder": true,
      "confirmed": false,
      "format": false
    }
  },
  "error_code": null,
  "error_message": null
}
```



### Create a new subscriber import

Start a new subscriber import, providing all details needed to run.

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/subscriber_imports

#### Request

The request should be a JSON object under the `subscriber_import` key with the
keys listed below. See the example request below.

<!-- BEGIN object subscriber_import insert-only -->

<table>
  <tr>
    <td><b>begins_at</b><br><em>datetime</em></td>
    <td>The time at which this import is scheduled to begin. Default: the current time</td>
  </tr>
  <tr>
    <td><b>overwrite</b><br><em>boolean</em></td>
    <td>This import should overwrite existing subscribers with the same email address. Default: false</td>
  </tr>
  <tr>
    <td colspan="2">
      <b>overwrite_what</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>custom_fields</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should overwrite the custom fields. Default: true.</td>
        </tr>
        <tr>
          <td><b>autoresponder</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, run autoresponders for the updated subscribers. Default: true.</td>
        </tr>
        <tr>
          <td><b>confirmed</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should update the confirmed field. Default: false.</td>
        </tr>
        <tr>
          <td><b>format</b><br><em>boolean</em></td>
          <td>When overwriting existing subscribers, this import should update the format field. Default: false.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>overwrite_when_status</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>active</b><br><em>boolean</em></td>
          <td>This import should overwrite existing active subscribers. Default: true.</td>
        </tr>
        <tr>
          <td><b>unsubscribed</b><br><em>boolean</em></td>
          <td>This import should overwrite existing unsubscribed subscribers. Default: false.</td>
        </tr>
        <tr>
          <td><b>bounced</b><br><em>boolean</em></td>
          <td>This import should overwrite existing bounced subscribers. Default: false.</td>
        </tr>
        <tr>
          <td><b>deactivated</b><br><em>boolean</em></td>
          <td>This import should overwrite existing deactivated subscribers. Default: false.</td>
        </tr>
        <tr>
          <td><b>scomp</b><br><em>boolean</em></td>
          <td>This import should overwrite existing spam complaint subscribers. Default: false.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><b>column_mapping</b><br><em>array: definition subscriber import mapping</em></td>
    <td>Import mapping to use, see the &quot;Mapping Array&quot; documentation above. Required.</td>
  </tr>
  <tr>
    <td><b>default_custom_fields</b><br><em>hash: definition subscriber import default custom fields</em></td>
    <td>The custom field values to assign to all subscribers in this import. Default: empty hash.</td>
  </tr>
  <tr>
    <td colspan="2">
      <b>file_source</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>type</b><br><em>string</em></td>
          <td>The source of the data to use for this import. This can be <code>json</code> or <code>upload_directory</code>. Required.</td>
        </tr>
        <tr>
          <td><b>content</b><br><em>string</em></td>
          <td>For <code>json</code> imports, this is the CSV content of the import file.</td>
        </tr>
        <tr>
          <td><b>filename</b><br><em>string</em></td>
          <td>For <code>upload_directory</code> imports, this is the filename of the local file in the user upload directory.</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <b>file_format</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>csv_has_headers</b><br><em>boolean</em></td>
          <td>The top line of this file is headers, don&#x27;t use it as a record. Default: true.</td>
        </tr>
        <tr>
          <td><b>character_set</b><br><em>string</em></td>
          <td>The character set to use for this import. Defaults to <code>UTF-8</code>, can also be <code>ISO-8859-1</code>.</td>
        </tr>
        <tr>
          <td><b>csv_field_separator</b><br><em>string</em></td>
          <td>The character to use to separate fields. Defaults to <code>,</code>, can also be <code>\t</code> for tabs.</td>
        </tr>
        <tr>
          <td><b>csv_field_enclosure</b><br><em>string</em></td>
          <td>The character to use to enclose fields. Defaults to <code>&quot;</code>, can also be <code>&#x27;</code> for single quotes.</td>
        </tr>
        <tr>
          <td><b>date_format</b><br><em>string</em></td>
          <td>
            <p>The date format to use when parsing `Date` custom fields, `Subscribe Time`, `Remove Time`, and `Confirm Time`. Defaults to <code>mdy</code>.</p>
            <p>A value of `mdy` will parse `01/02/2014` as `January 2, 2014`.</p>
            <p>A value of `dmy` will parse `01/02/2014` as `February 1, 2014`.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<!-- END object subscriber_import -->

#### Response

The response will be a JSON object in the same format as the subscriber import
show endpoint.

#### Example Request

```
> POST /ga/api/mailing_lists/1/subscriber_imports HTTP/1.1
> Authorization: Basic MTo0MDRhYzkzZTVjYmY4NzI4YjcyMzU5M2FmM2VkMTcwZDk0Yjc0Mjg4
> Accept: application/json
> Content-Type: application/json

{
  "subscriber_import": {
    "begins_at": "now",
    "column_mapping": [
      "email"
    ],
    "file_source": {
      "type": "json",
      "content": "email\nbob1234@example.com\nbilbo@example.com\n"
    },
    "file_format": {
      "character_set": "iso-8859-1",
      "csv_has_headers": true,
      "csv_field_separator": ",",
      "csv_field_enclosure": "\"",
      "date_format": "mdy"
    },
    "overwrite": true,
    "overwrite_what": {
      "custom_fields": true,
      "autoresponder": false,
      "confirmed": false,
      "format": false
    },
    "overwrite_when_status": {
      "active": true,
      "unsubscribed": false,
      "bounced": false,
      "deactivated": false,
      "scomp": false
    },
    "subscriber_defaults": {
      "status": "active",
      "confirmed": true,
      "format": "html"
    },
    "default_custom_fields": {
      "First Name": "Bobbie"
    }
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "ad1f04869c6928097908511b2b7333e0"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=09d7790d36289b7d7ab61dd863c14514; path=/; HttpOnly
< X-Request-Id: 5963b6949c36a75cf0c5c93d845c3af8
< X-Runtime: 0.122245
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "id": 1,
    "mailing_list_id": 1,
    "mailing_list_name": "Default Mailing List",
    "created_at": "2015-01-15T21:07:30Z",
    "state": "scheduled",
    "begins_at": "2015-01-15T21:07:30Z",
    "finished_at": null,
    "stats": {
      "number_of_records": null,
      "records_imported": 0,
      "subscribers": {
        "added": 0,
        "updated": 0,
        "failed": 0,
        "skipped_overwrite": 0,
        "skipped_active": 0,
        "skipped_unsubscribed": 0,
        "skipped_scomp": 0,
        "skipped_bounced": 0,
        "skipped_deactivated": 0,
        "skipped_duplicate": 0
      }
    },
    "file_source": {
      "type": "json",
      "filename": "data"
    },
    "file_format": {
      "character_set": "iso-8859-1",
      "csv_has_headers": true,
      "csv_field_enclosure": "\"",
      "csv_field_separator": ",",
      "date_format": "mdy"
    },
    "subscriber_defaults": {
      "status": "active"
    },
    "overwrite": true,
    "overwrite_when_status": {
      "active": true,
      "unsubscribed": false,
      "bounced": false,
      "deactivated": false,
      "scomp": false
    },
    "column_mapping": [
      "email"
    ],
    "default_custom_fields": {
      "First Name": "Bobbie"
    },
    "overwrite_what": {
      "custom_fields": true,
      "autoresponder": false,
      "confirmed": false,
      "format": false
    }
  },
  "error_code": null,
  "error_message": null
}
```



### Pause or unpause a subscriber import

Subscriber imports that are in progress can be paused and later unpaused.

#### URL

    POST /ga/api/v2/subscriber_imports/:id/pause

    POST /ga/api/v2/subscriber_imports/:id/unpause

#### Response

The response will be a JSON object in the same format to the subscriber import show endpoint.

If the subscriber import cannot be paused (or unpaused), this endpoint will
return a `validation_failed` error.

### Cancel a subscriber import

Subscriber imports that haven't yet finished can be cancelled.

#### URL

    POST /ga/api/v2/subscriber_imports/:id/cancel

#### Response

The response will be a JSON object in the same format to the subscriber import
show endpoint.

If the subscriber import cannot be cancelled (because it has finished), this
endpoint will return a `validation_failed` error.



### Read import logs

Subscriber imports generate a variety of logs. These logs can be accessed at
the included URLs below.

#### URL

    GET /ga/api/v2/subscriber_imports/:id/logs/added

    GET /ga/api/v2/subscriber_imports/:id/logs/updated

    GET /ga/api/v2/subscriber_imports/:id/logs/failed

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_overwrite

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_active

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_unsubscribed

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_scomp

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_bounced

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_deactivated

    GET /ga/api/v2/subscriber_imports/:id/logs/skipped_duplicate

#### Types of logs

| Name                   | Description                                                                                       |
| ---------------------- | ------------------------------------------------------------------------------------------------- |
| `added`                | Email addresses that were added                                                                   |
| `updated`              | Email addresses that were updated                                                                 |
| `failed`               | A CSV file of failed rows in the import - the last column is an error message                     |
| `skipped_overwrite`    | Email addresses that were skipped because overwriting is not enabled                              |
| `skipped_active`       | Email addresses that were skipped because this import does not update active subscribers          |
| `skipped_unsubscribed` | Email addresses that were skipped because this import does not update unsubscribed subscribers    |
| `skipped_scomp`        | Email addresses that were skipped because this import does not update spam complaint subscribers  |
| `skipped_bounced`      | Email addresses that were skipped because this import does not update bounced subscribers         |
| `skipped_deactivated`  | Email addresses that were skipped because this import does not update deactivated subscribers     |
| `skipped_duplicate`    | Email addresses that were skipped because the record was a duplicate found earlier in the file    |

#### Response

For the `log_failed` endpoint, the response will be a CSV file. The last row
will be the errors that prevented the subscriber record from being saved.

For the rest of the endpoints, the response will be a flat list of email
addresses, separated by newlines, that meet the description listed above.

If the log file cannot be found, a `not_found` error will be returned. This can
be the case in any of the following situations:

* The import hasn't yet started
* The import has no logs for that classification, because no items in that classification were generated
* The import has had its logs purged

**Note:** Logs are purged 7 days after the import finished running.
