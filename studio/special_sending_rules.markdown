# Special Sending Rules

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Overview](#overview)
- [Special Sending Rules: Usage & Interface](#special-sending-rules-usage-&-interface)
  - [Notes](#notes)
  - [Attributes of a Special Sending Rule](#attributes-of-a-special-sending-rule)
  - [Managing Special Sending Rules](#managing-special-sending-rules)
    - [Viewing the List of Special Sending Rules](#viewing-the-list-of-special-sending-rules)
    - [Creating a New Special Sending Rule](#creating-a-new-special-sending-rule)
    - [Previewing a Special Sending Rule](#previewing-a-special-sending-rule)
      - [Special Sending Rules in Campaign Preview Emails](#special-sending-rules-in-campaign-preview-emails)
  - [System and Organization Configuration](#system-and-organization-configuration)
    - [Setting the Max SSR Workers Value](#setting-the-max-ssr-workers-value)
    - [Organization Permissions](#organization-permissions)
  - [Campaign Preview Emails](#campaign-preview-emails)
- [Special Sending Rules: Development](#special-sending-rules-development)
  - [Conventions in this Document](#conventions-in-this-document)
  - [Details and Limitations](#details-and-limitations)
  - [Definition of Data In and Out of Special Sending Rules](#definition-of-data-in-and-out-of-special-sending-rules)
    - [Data Provided to the Special Sending Rule](#data-provided-to-the-special-sending-rule)
      - [Campaign Information Hash](#campaign-information-hash)
      - [Recipient Information Hash](#recipient-information-hash)
        - [subscriber Hash](#subscriber-hash)
        - [content Hash](#content-hash)
    - [Data Returned From the Special Sending Rule](#data-returned-from-the-special-sending-rule)
      - [Override Hash](#override-hash)
      - [Attachment Hash](#attachment-hash)
  - [Special Sending Rule Function Interface](#special-sending-rule-function-interface)
    - [General Structure](#general-structure)
    - [Input Variables](#input-variables)
      - [Campaign Information Hash](#campaign-information-hash-1)
      - [Multiple Recipients Information Hash](#multiple-recipients-information-hash)
    - [Expected Return Value](#expected-return-value)
  - [Examples](#examples)
    - [Perl](#perl)
      - [Example Input to SSR](#example-input-to-ssr)
      - [Example Return Value](#example-return-value)
      - [Example Special Sending Rule that Passes Through the Values it Receives](#example-special-sending-rule-that-passes-through-the-values-it-receives)
      - [Example Special Sending Rule that Issues an HTTP GET to Replace the Text Content](#example-special-sending-rule-that-issues-an-http-get-to-replace-the-text-content)
      - [Example Special Sending Rule that Sends Using Different Virtual MTAs for Even and Odd Subscriber IDs](#example-special-sending-rule-that-sends-using-different-virtual-mtas-for-even-and-odd-subscriber-ids)
    - [PHP](#php)
      - [Example Special Sending Rule that Passes Through the Values it Receives](#example-special-sending-rule-that-passes-through-the-values-it-receives-1)
      - [Example Special Sending Rule that Issues an HTTP GET to Replace the Text Content](#example-special-sending-rule-that-issues-an-http-get-to-replace-the-text-content-1)
      - [Example Special Sending Rule that Sends Using Different Virtual MTAs for Even and Odd Subscriber IDs](#example-special-sending-rule-that-sends-using-different-virtual-mtas-for-even-and-odd-subscriber-ids-1)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Overview

Special Sending Rules provide a way to programmatically customize the sending
attributes or the content of a message before it is sent.

When a Special Sending Rule is configured for an email campaign a function is
called to customize each message. This function is given data about what will be
sent and can return data to override the sending attributes or content of the
message.

Special Sending Rule code is called once per message.

# Special Sending Rules: Usage & Interface

## Notes

* Only System Admin users may create or update Special Sending Rules.
* Special Sending Rules may be applied to mailing lists as a campaign default.
  New campaigns will use that SSR as a default.
* Special Sending Rules may be applied to campaigns.
* If a special sending rule returns a `Virtual MTA`, `Bounce Email`, or `URL Domain`
  that does not exist (by name, not ID) in GreenArrow Engine, it will cause
  the campaign to fail.

## Attributes of a Special Sending Rule

**Name** —
This is the identifier that you'll use within GreenArrow Studio to select this SSR.

**Number of Workers** —
This value determines how many processes will be run to execute this SSR. If
the SSR is simple with low CPU usage, this can safely be set to the default (2).
If you have an SSR that is complex or slow, this can be increased to improve
overall performance. The maximum value for this field is determined by the *Max
SSR Workers* system configuration.

**Language** —
The programming language that the SSR will be evaluated as. Currently Perl and
PHP are the supported SSR languages.

**Code** —
This is the computer code that will be executed to determine this SSR's functionality.

## Managing Special Sending Rules

### Viewing the List of Special Sending Rules

In the "Admin" top navigation, click on the "SSRs" sub-navigation link.

### Creating a New Special Sending Rule

1. In the "Admin" top navigation, click on the "SSRs" sub-navigation link.
2. Click "Create a special sending rule".
3. Fill in this form with the correct details. See the documentation below to
   know how to declare the SSR function.
4. Click "Create this special sending rule".

### Previewing a Special Sending Rule

To see what affect an SSR will have on a campaign, navigate to the SSR's show
page and do the following.

1. Click the "Preview this special sending rule" button.
2. Select an organization, campaign, and subscriber details to use.
3. Click the "View preview" button.

The resulting page will detail what the SSR did. If there is an error or
exception thrown by the code, it will be shown on this page.

If the selected campaign has a split-test, the preview will run for the first
defined content.

#### Special Sending Rules in Campaign Preview Emails

If a campaign is configured to use a special sending rule, that rule will be
applied to campaign preview emails as well.

The special sending rule evaluation and preview email will have the following details:

* The recipient's email address will be the address specified when creating the preview.
* The recipient's custom fields will be the mailing list's "Preview and Seed Custom Field Values".
* If no segmentation criteria is set for the campaign, null values will be
  passed to the special sending rule for segmentation criteria fields.
* Other delivery details will be pulled from the campaign. If no delivery
  details are set, then the system "Campaign Preview Defaults" values will be used.
* The preview delivery default Virtual MTA will always be used, regardless of
  if the campaign or special sending rule overrides it.
* Any errors in the special sending rule will be presented when creating the preview email.

## System and Organization Configuration

### Setting the Max SSR Workers Value

In order to prevent individual SSRs from being configured to use too many
processes, in the *System Configuration* screen you may set a *Max SSR Workers*
value. This is the maximum number of workers that any individual SSR may allocate.

### Organization Permissions

Organization access to SSRs may be configured when editing an organization. The
following settings are available.

**Allow users to select any Special Sending Rule** —
This allows any user to select any Special Sending Rule when editing a mailing
list or campaign. This is the most permissive option available.

**Allow users to select from the following Special Sending Rules** —
Selecting this setting brings up a multi-select box in which the you can select
one or more specific Special Sending Rules that users within the organization
may choose from.

**Always use the following Special Sending Rule** —
Using this mode will force all email campaigns sent for this organization to be
processed through the Specified Special Sending Rule. The users of that
organization will not see that an SSR is configured.

**Disable Special Sending Rules** —
This will hide the Special Sending Rule functionality from that organization
entirely. No email sent for this organization will use any Special Sending Rule
and users will not see the option to select one.

* By default, all Organizations except the System Organization will be set to
  **Disable Special Sending Rules**. A system administrator may enable these
  features on a per-organization basis at any time.

## Campaign Preview Emails

If a campaign is configured to use a Special Sending Rule at the time a preview
email is requested, the SSR will be evaluated on that preview email.

# Special Sending Rules: Development

## Conventions in this Document

This document describes methods in multiple computer languages which use
different terms for similar things. Here is how the concepts are translated.

| In this document | Perl           | PHP   |
| ---------------- | -------------- | ----- |
| Hash             | Hash reference | Array |
| Undefined        | undef          | null  |

## Details and Limitations

* A Special Sending Rule may run for a maximum of 60 seconds before being
  terminated, potentially causing the campaign to fail.
* Special Sending Rules will be attempted three times before causing processing the 
  subscriber to fail.
* The first retry will be 10 seconds later, with the second retry 60 seconds after that.
* Depending on the configuration of the Special Sending Rule, either:
    * a single error processing a subscriber will cause the campaign to be stopped, or
    * an error threshold must be exceeded for the campaign to be stopped 
      (For example, greater than 10% of subscribers with errors in the last 2 minutes.)
* The "Number of Workers" field in Special Sending Rules defines the
  parallelism of the SSR. Every campaign that is using this SSR will run that
  many instances of the evaluator process.

## Definition of Data In and Out of Special Sending Rules

### Data Provided to the Special Sending Rule

#### Campaign Information Hash

The Campaign Information Hash ($campaign_information_hash) contains data about the campaign. This does not change per recipient.

| Key                          | Description                                                                                                                                         |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| `is_preview`                 | If this is a campaign preview, then 1. Otherwise 0.                                                                                                 |
| `seed_list_id`               | Deprecated: The ID of the first seed list assigned to the Campaign, ordered by ID. Use `seed_lists` instead. (Undefined if no seed list selected.)  |
| `seed_list_name`             | Deprecated: The name of the first seed list, ordered by ID. (Undefined if no seed list selected.)                                                   |
| `seed_lists`                 | An array of seed lists used for the campaign. Each entry will be a hash with `id` and `name` keys.                                                  |
| `speed`                      | Speed of the campaign in messages per hour or zero if unlimited.                                                                                    |
| `from_name`                  | From address name.                                                                                                                                  |
| `from_email`                 | From email address.                                                                                                                                 |
| `sender_email`               | Sender email address. (Undefined if not specified.)                                                                                                 |
| `reply_to`                   | Reply-to email address (Undefined if not specified.)                                                                                                |
| `virtual_mta_name`           | Name of VirtualMTA used for sending. (If this option is hidden from the user, then this will be set to the actual value used for sending.)          |
| `virtual_mta_id`             | Primary key of the VirtualMTA.                                                                                                                      |
| `url_domain_name`            | Domain name for click and open tracking URLs. (If this option is hidden from the user, then this will be set to the actual value used for sending.) |
| `url_domain_id`              | Primary key of the URL Domain.                                                                                                                      |
| `track_opens`                | If tracking opens, then 1. Otherwise 0.                                                                                                             |
| `track_links`                | If tracking links, then 1. Otherwise 0.                                                                                                             |
| `bounce_email`               | Bounce handling email address. (If this option is hidden from the user, then this will be set to the actual value used for sending.)                |
| `campaign_name`              | Name of campaign.                                                                                                                                   |
| `campaign_id`                | Primary key of campaign.                                                                                                                            |
| `mailing_list_name`          | Name of mailing list.                                                                                                                               |
| `mailing_list_id`            | Primary key of mailing list.                                                                                                                        |
| `segmentation_criteria_name` | The name of the segmentation criteria used for this campaign.                                                                                       |
| `segmentation_criteria_id`   | The ID of the segmentation criteria used for this campaign.                                                                                         |
| `segmentation_criteria_json` | The JSON blob that defines the segmentation criteria used for this campaign.                                                                        |

Note on `segmentation_criteria_json`: The format of this field is undocumented.
It exists as an input for users that need it, but its fields should be
discovered through experimentation. (If a campaign does not yet have a segment
defined, then these values will be null. This can happen when a SSR is applied
to a campaign preview where the campaign does not have a segment defined.)

#### Recipient Information Hash

The Recipient Information Hash ($multiple_recipients_information_hash) contains two hashes:

| Key        | Description                                                                                                                                                                                                           |
| ---------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| subscriber | Information about the recipient of the email message. (Defined below.)                                                                                                                                                |
| content    | Information about the content to be sent. This is not part of the campaign information hash, because with split A/B testing a campaign can send different content versions to different subscribers. (Defined below.) |

##### subscriber Hash

| Key                      | Description                                                                                                                           |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------- |
| id                       | Primary key of subscriber.                                                                                                            |
| email                    | Email address.                                                                                                                        |
| created_at               | Time subscriber record was created in [ISO 8601 date/time format](http://www.w3.org/TR/NOTE-datetime) in the organization time zone.  |
| created_at_epoch         | Time subscriber record was created in seconds past the UNIX epoch in the organization time zone.                                      |
| created_at_epoch_utc     | Time subscriber record was created in seconds past the UNIX epoch in the UTC time zone.                                               |
| confirmed                | If confirmed, then 1. Otherwise 0. This key is only presented for mailing lists which use the Confirmed field.                        |
| email_format             | Subscriber's format setting ("html" or "text"). This key is only presented for mailing lists which use the Format field.              |
| status                   | Status for the subscriber. Is always "active".                                                                                        |
| subscribe_time           | Time that subscriber subscribed in [ISO 8601 date/time format](http://www.w3.org/TR/NOTE-datetime) in the organization time zone.     |
| subscribe_time_epoch     | Time that subscriber subscribed in seconds past the UNIX epoch in the organization time zone.                                         |
| subscribe_time_epoch_utc | Time that subscriber subscribed in seconds past the UNIX epoch in the UTC time zone.                                                  |
| subscribe_ip             | IP address that subscriber subscribed from.                                                                                           |
| custom_fields            | Hash of custom fields. Uses the same format as returned by the get subscriber API call.                                               |

The date values are returned in `YYYY-MM-DDThh:mm:ss.s` format, using UTC as the time zone. For example, `2014-10-30 13:08:18.936708`.

##### content Hash

| Key     | Description                                                                                                                                     |
| ------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| id      | The internal ID of this content object                                                                                                          |
| format  | Format of email message to send: "both", "html", or "text"                                                                                      |
| html    | HTML content before custom field replacement, click tracking, and open tracking. (If this is a text-only message, then this will be undefined.) |
| text    | Text content before custom field replacement, click tracking, and open tracking. (If this is a html-only message, then this will be undefined.) |
| subject | Subject of email before custom field replacement.                                                                                               |

### Data Returned From the Special Sending Rule

#### Override Hash

Setting a key in the Override Hash (the return value of the Special Sending Rule) overrides the
default value for a particular delivery.

| Key              | Corresponds to                             | Description                                                                                                                                                                                                                                                                                       |
| ---------------- | ------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| html             | message_information_hash.content.html      | New HTML content. If this is set to undefined or a blank string, then this removes the HTML content and creates a text-only email, provided that text content exists. Custom field replacement, click tracking, and open tracking will be performed on this content.                              |
| text             | message_information_hash.content.text      | New text content. If this is set to undefined or a blank string, then this removes the text content and creates a HTML-only email, provided that HTML content exists. Custom field replacement, and click tracking will be performed on this content.                                             |
| subject          | message_information_hash.content.subject   | New subject. Custom field replacement will be performed on this content.                                                                                                                                                                                                                          |
| from_name        | campaign_information_hash.from_name        | New from address name.                                                                                                                                                                                                                                                                            |
| from_email       | campaign_information_hash.from_email       | New from email address.                                                                                                                                                                                                                                                                           |
| sender_email     | campaign_information_hash.sender_email     | New sender email address. Set to blank or undefined to clear the sender email address.                                                                                                                                                                                                            |
| reply_to         | campaign_information_hash.reply_to         | New reply-to email address. Set to blank or undefined to clear the reply-to email address.                                                                                                                                                                                                        |
| virtual_mta_name | campaign_information_hash.virtual_mta_name | New VirtualMTA. Set to the name of the VirtualMTA. Specify only one of this or `virtual_mta_id`.                                                                                                                                                                                                  |
| virtual_mta_id   | campaign_information_hash.virtual_mta_id   | New VirtualMTA. Set to the ID of the VirtualMTA.  Specify only one of this or `virtual_mta_name`.                                                                                                                                                                                                 |
| url_domain_name  | campaign_information_hash.url_domain_name  | New URL domain. Set to the URL Domain domain name. Specify only one of this or `url_domain_id`.                                                                                                                                                                                                   |
| url_domain_id    | campaign_information_hash.url_domain_id    | New URL domain. Set to the ID of the URL Domain. Specify only one of this or `url_domain_name`.                                                                                                                                                                                                   |
| bounce_email     | campaign_information_hash.bounce_email     | New bounce email address. Specify only one of this or `bounce_email_id`.                                                                                                                                                                                                                          |
| bounce_email_id  | &mdash;                                    | New bounce email address. Specify only one of this or `bounce_email`.                                                                                                                                                                                                                             |
| skip             | &mdash;                                    | A return value of true, `1`, or a number greater than zero in this field will cause this recipient to be skipped in delivery.                                                                                                                                                                     |
| skip_message     | &mdash;                                    | If provided, this message will be set on the `skip` event and presented in statistics screen.                                                                                                                                                                                                     |
| attachments      | &mdash;                                    | An array of attachment hashes, as defined below.                                                                                                                                                                                                                                                  |

* If the SSR's override hash includes `html` or `text` keys, this may cause
  the email format to change. For example, if a campaign was originally `text`,
  but the SSR returns non-blank values for both `html` and `text`, a
  `multipart/alternative` email will be sent instead of `text/plain`.
* If the SSR returns blank values for both `html` and `text`, this will cause
  the delivery to fail because no content is available to send. Note that this
  *only* comes up if the override has defined those keys, removing the original
  content.
* If a SSR returns a blank value for `text` on a text-only campaign, this will
  cause the delivery to fail because no content is available to send.

#### Attachment Hash

Each hash in the `attachments` array of the Override Hash must have the following keys:

| Key       | Description                                                                        |
| --------- | ---------------------------------------------------------------------------------- |
| filename  | The string that will be used as the filename in the attachment. Must not be blank. |
| mime_type | The string that will be used as the MIME type for the attached file.               |
| content   | The string that will be used as the content of the attachment.                     |

* Filenames may contain the characters `A-Z a-z 0-9 _ - .` and spaces, must be at least
  one character long, must contain at least one non-whitespace character, and may be at
  most 100 characters long.
* If `mime_type` is blank, it will be defaulted to `application/octet-stream`.

Here are some of the most common MIME Types used in email attachments.
[See the Wikipedia page on MIME Types](http://en.wikipedia.org/wiki/Internet_media_type)
for an expanded list of types.

| MIME Type                  | File Extension | Description                            |
| -------------------------- | -------------- | -------------------------------------- |
| `text/plain`               | `.txt`         | Plain Text                             |
| `text/html`                | `.html`        | HTML                                   |
| `application/pdf`          | `.pdf`         | Adobe Acrobat Portable Document Format |
| `application/msword`       | `.doc`         | Microsoft Word                         |
| `application/vnd.ms-excel` | `.xls`         | Microsoft Excel                        |

## Special Sending Rule Function Interface

### General Structure

Your Special Sending Rule contains code that will be run as part of a function by GreenArrow
Studio. You don't provide the syntax that defines the function/subroutine itself (such as
`function example ($arg) { statements... }`), but rather just provide the source code lines
(statements) that will be run.

Input values will be provided in variables already defined in the local context.

Data is returned by calling the `return` command. Not calling the `return` command will result in
an error.

### Input Variables

The following variables will be defined in local context:

| Variable                                       | Description                          |
| ---------------------------------------------- | ------------------------------------ |
| $campaign_information_hash                     | Campaign Information Hash            |
| $multiple_recipients_information_hash          | Multiple Recipients Information Hash |

#### Campaign Information Hash

This is the "Campaign Information Hash" as defined above.

#### Multiple Recipients Information Hash

This is a hash that contains information on one or more recipients for the Special Sending Rule
to process.

* Key: The id of the subscriber (the numeric primary key).
* Value: The "recipient information hash" (as defined above) with information on this subscriber
  and their email.

See examples below.

### Expected Return Value

The Special Sending Rule returns a hash with override information for the current subscriber.

* Key: The subscriber id (numeric primary key) of the subscriber to have overrides performed
  on their email. This subscriber id must have been provided as part of the "Multiple Recipients
  Information Hash" that was passed to this invocation of the Special Sending Rule.
* Value: The "override hash" (as defined above) with the settings to override.

See examples below.

## Examples

[We've created a practical set of examples for reference](./special_sending_rules_examples.markdown)

### Perl

#### Example Input to SSR

```perl
$campaign_information_hash = {
    seed_list_name    => 'GreenArrow Monitor',
    seed_list_id      => 12,
    seed_lists        => [ { id => 12, name => 'GreenArrow Monitor' } ],
    speed             => 0,
    from_name         => 'DRH Internet',
    from_email        => 'newsletter@example.drh.net',
    sender_email      => undef,
    reply_to          => undef,
    virtual_mta_name  => 'smtp1-2',
    virtual_mta_id    => 3,
    url_domain_name   => 'http://newsletter.example.drh.net/',
    track_opens       => 1,
    track_links       => 1,
    bounce_email      => 'return@newsletter.example.drh.net',
    campaign_name     => 'December newsletter',
    campaign_id       => 76,
    mailing_list_name => 'Newsletter subscribers',
    mailing_list_id   => 3,
};

$multiple_recipients_information_hash = {
    182634 => {
        subscriber => {
            id                       => 182634,
            email                    => 'fred@example.com',
            created_at               => '2014-12-03T08:39:53+12:00',
            created_at_epoch         => 1417595993,
            created_at_epoch_utc     => 1417552793,
            confirmed                => 1,
            email_format             => 'html',
            status                   => 'active'
            subscribe_time           => '2014-12-03T08:39:53+12:00',
            subscribe_time_epoch     => 1417595993,
            subscribe_time_epoch_utc => 1417552793,
            subscribe_ip             => '10.0.0.3',
            custom_fields            => {
                "First Name" => {
                    name  => "First Name",
                    type  => "text",
                    value => "Bob",
                },
                "Favorite Color" => {
                    name  => "Favorite Color",
                    type  => "select_single_dropdown",
                    value => "Red",
                },
            },
        },
        content => {
            format  => 'both',
            html    => '<html><body><p>Hello world</p><p><a href="%%unsubscribe_link%%">Unsubscribe me</a></p>/body></html>',
            text    => "Hello world\n\nUnsubscribe me: %%unsubscribe_link%%\n",
            subject => 'Hello',
        },
    },
};
```

#### Example Return Value

```perl
$return_value = {
    182634 => {
        html              => '<html><body><p>Hi there</p><p><a href="%%unsubscribe_link%%">Unsubscribe me</a></p>/body></html>',
        text              => "Hi there\n\nUnsubscribe me: %%unsubscribe_link%%\n",
        subject           => 'Hi',
        from_name         => 'DRH Internet Newsletter',
        from_email        => 'the-newsletter@example.drh.net',
    },
};
```

#### Example Special Sending Rule that Passes Through the Values it Receives

```perl
# Available variables:
#
# $campaign_information_hash
# $multiple_recipients_information_hash
#
# NOTE: The example code below returns all potential values. For best
# performance, it's best to trim the return value down to just the fields
# you need to override.

my %result = map {
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };

  $recipient_id => {
    html              => $recipient->{content}{html},
    text              => $recipient->{content}{text},
    subject           => $recipient->{content}{subject},
    from_name         => $campaign_information_hash->{from_name},
    from_email        => $campaign_information_hash->{from_email},
    sender_email      => $campaign_information_hash->{sender_email},
    reply_to          => $campaign_information_hash->{reply_to},
    virtual_mta_name  => $campaign_information_hash->{virtual_mta_name},
    url_domain_name   => $campaign_information_hash->{url_domain_name},
    bounce_email      => $campaign_information_hash->{bounce_email},
  }
} keys(%$multiple_recipients_information_hash);

return \%result;
```

#### Example Special Sending Rule that Issues an HTTP GET to Replace the Text Content

```perl
use LWP::Simple;

my %result = map {
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };

  my $new_content = get("http://drh.net/robots.txt");

  $recipient_id => {
    text => $new_content,
  }
} keys(%$multiple_recipients_information_hash);

return \%result;
```

#### Example Special Sending Rule that Sends Using Different Virtual MTAs for Even and Odd Subscriber IDs

```perl
my %result = map {
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };

  my $override_hash = {};

  if ( $recipient_id % 2 == 0 ) {
    $override_hash->{virtual_mta_name} = "smtp-even";
  } else {
    $override_hash->{virtual_mta_name} = "smtp-odd";
  }

  $recipient_id => $override_hash;
} keys(%$multiple_recipients_information_hash);

return \%result;
```

### PHP

#### Example Special Sending Rule that Passes Through the Values it Receives

```php
# Available variables:
#
# $campaign_information_hash
# $multiple_recipients_information_hash
#
# NOTE: The example code below returns all potential values. For best
# performance, it's best to trim the return value down to just the fields
# you need to override.

return array_map((function ($recipient) use ($campaign_information_hash) {
  return array(
    'html'              => $recipient->content->html,
    'text'              => $recipient->content->text,
    'subject'           => $recipient->content->subject,
    'from_name'         => $campaign_information_hash->from_name,
    'from_email'        => $campaign_information_hash->from_email,
    'sender_email'      => $campaign_information_hash->sender_email,
    'reply_to'          => $campaign_information_hash->reply_to,
    'virtual_mta_name'  => $campaign_information_hash->virtual_mta_name,
    'url_domain_name'   => $campaign_information_hash->url_domain_name,
    'bounce_email'      => $campaign_information_hash->bounce_email,
  );
}), $multiple_recipients_information_hash);
```

#### Example Special Sending Rule that Issues an HTTP GET to Replace the Text Content

```php
return array_map((function ($recipient) use ($campaign_information_hash) {
  $new_content = file_get_contents("http://drh.net/robots.txt");

  return array(
    'text' => $new_content,
  );
}), $multiple_recipients_information_hash);
```

#### Example Special Sending Rule that Sends Using Different Virtual MTAs for Even and Odd Subscriber IDs

```php
return array_map((function ($recipient) use ($campaign_information_hash) {
  $override_hash = array();

  if ( $recipient->subscriber->id % 2 === 0 )
    $override_hash["virtual_mta_name"] = "smtp-even";
  else
    $override_hash["virtual_mta_name"] = "smtp-odd";

  return $override_hash;
}), $multiple_recipients_information_hash);
```
