<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [Jobs](#jobs)
  - [Get a list of background jobs](#get-a-list-of-background-jobs)
    - [URL (All background jobs)](#url-all-background-jobs)
    - [URL (Only unfinished background jobs)](#url-only-unfinished-background-jobs)
    - [Response](#response)
    - [Example Request](#example-request)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Jobs

### Get a list of background jobs

If the API key has system admin authority, this API endpoint will return all
jobs on the system. If the API key has organization admin authority, it will
only return jobs for the current organization.

#### URL (All background jobs)

This endpoint returns all jobs, regardless of status.

    GET /ga/api/v2/jobs/all

#### URL (Only unfinished background jobs)

This endpoint will return unfinished jobs, that is jobs that are pending,
scheduled, active, or paused.

    GET /ga/api/v2/jobs/unfinished

#### Response

| Key                 | Meaning                                                        | Example                | Type    |
| ------------------- | -------------------------------------------------------------- | ---------------------- | ------- |
| id                  | The internal identifier for this background job                | 31281                  | Integer |
| mailing_list_id     | The mailing list associated with this background job           | 881237                 | Integer |
| organization_id     | The internal identifier for this background job's organization | 826661                 | Integer |
| suppression_list_id | The suppression list associated with this background job       | 123                    | Integer |
| state               | The current status of this job                                 | "paused"               | String  |
| state2              | Campaigns will have a secondary state, returned here           | "onhold_autowinner"    | String  |
| paused              | True or false if this job is paused                            | true                   | Boolean |
| name                | The name of this job                                           | "Daily Weather"        | String  |
| progress_value      | Numerator of the job's current progress                        | 12                     | Integer |
| progress_total      | Denominator of the job's current progress                      | 10002                  | Integer |
| job_type            | The type of job represented by this object                     | "Campaign"             | String  |
| begins_at           | Scheduled time that this job will begin                        | "2014-07-03T13:37:00Z" | Time    |
| started_at          | The time at which this job began                               | "2014-07-03T13:37:00Z" | Time    |
| finished_at         | The time at which this job finished                            | "2014-07-03T13:37:00Z" | Time    |
| created_at          | The time at which this job was created                         | "2014-07-03T13:37:00Z" | Time    |
| retry_at            | The job hit a failure condition and will retry at this time    | "2014-07-03T13:37:00Z" | Time    |

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/jobs/all HTTP/1.1
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
             "begins_at":"2014-07-03T13:37:00Z",
             "created_at":"2014-07-03T13:37:33Z",
             "finished_at":null,
             "id":1,
             "job_type":"SubscriberImport",
             "mailing_list_id":12,
             "name":"50-subscribers.csv",
             "organization_id":1,
             "paused":false,
             "progress_total":null,
             "progress_value":0,
             "retry_at":null,
             "started_at":null,
             "state":"scheduled",
             "state2":null,
             "suppression_list_id":null,
             "updated_at":"2014-07-03T13:37:39Z"
          }
       ],
       "error_code":null,
       "error_message":null
    }
