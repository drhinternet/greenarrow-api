<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Introduction](#introduction)
- [Formatting](#formatting)
    - [JSON Formatting](#json-formatting)
    - [Return Values](#return-values)
    - [Error Response](#error-response)
    - [Dates and Times](#dates-and-times)
- [Versions](#versions)
- [Authentication](#authentication)
    - [Organization ID](#organization-id)
    - [API Keys](#api-keys)
    - [Authorization Header](#authorization-header)
- [Version 2](#version-2)
    - [[Subscribers](./v2/subscribers.markdown)](#subscribersv2subscribersmarkdown)
    - [[Subscriber Imports](./v2/subscriber_imports.markdown)](#subscriber-importsv2subscriber_importsmarkdown)
    - [[Mailing Lists](./v2/mailing_lists.markdown)](#mailing-listsv2mailing_listsmarkdown)
    - [[Custom Fields](./v2/custom_fields.markdown)](#custom-fieldsv2custom_fieldsmarkdown)
    - [[Campaigns](./v2/campaigns.markdown)](#campaignsv2campaignsmarkdown)
    - [[Campaign Templates](./v2/campaign_templates.markdown)](#campaign-templatesv2campaign_templatesmarkdown)
    - [[Autoresponders](./v2/autoresponders.markdown)](#autorespondersv2autorespondersmarkdown)
    - [[Virtual MTAs](./v2/virtual_mtas.markdown)](#virtual-mtasv2virtual_mtasmarkdown)
    - [[URL Domains](./v2/url_domains.markdown)](#url-domainsv2url_domainsmarkdown)
    - [[Bounce Emails](./v2/bounce_emails.markdown)](#bounce-emailsv2bounce_emailsmarkdown)
    - [[Segmentation Criterias](./v2/segmentation_criterias.markdown)](#segmentation-criteriasv2segmentation_criteriasmarkdown)
    - [[Users](./v2/users.markdown)](#usersv2usersmarkdown)
    - [[Jobs](./v2/jobs.markdown)](#jobsv2jobsmarkdown)
- [Enumerated Values](#enumerated-values)
  - [Automatic Winner Selection Metrics](#automatic-winner-selection-metrics)
  - [Subscriber Statuses](#subscriber-statuses)
  - [Custom Field Types](#custom-field-types)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Introduction

This is the documentation for the GreenArrow Studio 4 API. If you have
additional questions about the API, or feel that you've encountered a bug,
please don't hesitate to contact us at
[our support address](https://drhinternet.zendesk.com/anonymous_requests/new).

Interactions with this API are accomplished over HTTP. On POST and PUT
requests, JSON is expected as the body of the request. All API calls reply with
JSON.



# Formatting


### JSON Formatting

The JSON included as examples in this document has been nicely formatted for
viewing. Neither the JSON expected as input into the API nor the JSON returned
by it will be formatted this way.


### Return Values

All API requests will return a JSON hash with the following keys:

| Key           | Meaning                                                                                                                            | Example                                    | Type          |
| ------------- | ---------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------ | ------------- |
| success       | The API call was successful or not.                                                                                                | true or false                              | Boolean       |
| data          | The object returned by the particular API call, as defined in each section of this document. This will be null if the call failed. | ...                                        | Array or Hash |
| error_code    | A simple error code to identify what went wrong. This will be null if the call was successful.                                     | "not_authorized"                           | String        |
| error_message | A more descriptive message of what went wrong. This will be null if the call was successful.                                       | please specify a valid auth_id or auth_key | String        |


### Error Response

Here's an example of an error message returned by this API.

    {
        "data": null,
        "error_code": "validation_failed",
        "error_message": "name cannot be blank",
        "success": false
    }

Here are all of the error codes that Studio can return. See the *error_message* value for more information on the specific response.

| error_code             | Explanation                                                          |
| ---------------------- | -------------------------------------------------------------------- |
| validation_failed      | The client tried to create or update a record into an invalid state. |
| invalid_request        | The request could not be processed.                                  |
| requested_too_many     | The client requested too many records at once.                       |
| not_found              | The requested record could not be found.                             |
| multiple_records_found | The request found multiple records instead of one.                   |


### Dates and Times

* Times are passed to the API in [ISO 8601 date/time format](http://www.w3.org/TR/NOTE-datetime):

    YYYY-MM-DDThh:mm:ss-ZZ:ZZ
    2013-03-27T10:41:15-05:00

* A date (with no time) can be passed to the API, and is returned, in the following format:

    YYYY-MM-DD
    2010-03-30

* Times are returned by the API as both an integer number of seconds since the
  UNIX epoch, and in [ISO 8601 date/time format](http://www.w3.org/TR/NOTE-datetime).

* All fields that are interpreted as a time also have a corresponding `_epoch`
  field with the integer number of seconds since the UNIX epoch. For example,
  on a subscriber the `created_at` field might have the value
  `"2013-03-27T10:41:15-05:00"`, there will also be a field `"created_at_epoch"`
  which contains the integer value `1364398875`.

* The timezone of all times is the organization timezone.



# Versions

During evolving the programmatic interface of API calls may change. To keep
things backward compatible, Studio 4 uses API versioning. Each request you send
should explicitly specify the version of API you are targeting. There are two
ways to achieve that:

* You can specify version within request headers using the `X-Version` header.

    X-Version: 2

* You can specify version within request path using the path component `v2`.

    /ga/api/v2/campaigns

*Important*: for compatibility reasons you will be routed to version 1&nbsp;if no version was specified\!



# Authentication

Every request to the GreenArrow Studio 4 API must be authenticated. This is
done via the "Authorization" HTTP header in the request. For this, you need
your "Organization ID" and "API Key", as detailed below. See the "Authorization
Header" section below for details on building the header.

### Organization ID

You will need your organization's ID to authenticate with the GreenArrow Studio
4 API. This ID can be found on the organization page in the "Organization
Details" section. To load that page for your organization, hover over "Admin"
in the top navigation menu, then select "My Organization":

!Screen Shot 2013-03-27 at 9.30.58 AM.jpg|border=1!

### API Keys

Organization administrators may create API keys from their organization's page.
To find that page, hover over "Admin" in the top navigation menu, then select
"My Organization". See the "API Keys" section on that screen. The "Key" column
contains the value needed for authentication.

!Screen Shot 2013-03-27 at 9.26.49 AM.jpg|border=1!

### Authorization Header

The *Authorization* header must be included in every call to the GreenArrow Studio 4 API.

    Authorization: Basic <Data>

The `<Data>` portion of this header should be a Base64 encoded string
containing your organization ID, followed by a colon, followed by your API key.
From the example screenshots above, using the API key for "Bob's Script", you
would Base64 encode the string "1:5e96465c883f3309f0105a2e1076632b687e61d2".
This results in the string "MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy".

Thus, for that example, our header would be the following.

    Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy



# Version 2


### [Subscribers](./v2/subscribers.markdown)

### [Subscriber Imports](./v2/subscriber_imports.markdown)

### [Mailing Lists](./v2/mailing_lists.markdown)

### [Custom Fields](./v2/custom_fields.markdown)

### [Campaigns](./v2/campaigns.markdown)

### [Campaign Templates](./v2/campaign_templates.markdown)

### [Autoresponders](./v2/autoresponders.markdown)

### [Virtual MTAs](./v2/virtual_mtas.markdown)

### [URL Domains](./v2/url_domains.markdown)

### [Bounce Emails](./v2/bounce_emails.markdown)

### [Segmentation Criterias](./v2/segmentation_criterias.markdown)

### [Users](./v2/users.markdown)

### [Jobs](./v2/jobs.markdown)



# Enumerated Values


## Automatic Winner Selection Metrics

| Value              | Description                                       |
| ------------------ | ------------------------------------------------- |
| opens_unique       | The number of unique opens                        |
| clicks_unique      | The number of unique clicks                       |
| opens_total        | The total number of opens, unique and non-unique  |
| clicks_total       | The total number of clicks, unique and non-unique |
| click_to_open_rate | The ratio of unique clicks to unique opens        |

## Subscriber Statuses

| Value        | Description                                                         |
| ------------ | ------------------------------------------------------------------- |
| active       | The subscriber is active for receiving email                        |
| unsubscribed | The subscriber has unsubscribed from this mailing list              |
| scomp        | GreenArrow Studio has received a spam complaint for this subscriber |
| bounced      | GreenArrow Studio received a bounce event for this subscriber       |
| deactivated  | This subscriber was deactivated by a user of GreenArrow Studio      |

## Custom Field Types

| Value                      | Description                                                                 |
| -------------------------- | --------------------------------------------------------------------------- |
| text                       | A single line text field                                                    |
| text_multiline             | A multiline text field                                                      |
| number date                | An integer value                                                            |
| day_of_year                | A month and day pairing, no year                                            |
| select_single_dropdown     | A dropdown list of options, one option can be selected at a time            |
| select_single_radio        | Radio boxes of options, one option can be selected at a time                |
| select_multiple_checkboxes | A list of options as checkboxes, multiple options can be selected at a time |
| boolean                    | A value that can be yes or no                                               |
