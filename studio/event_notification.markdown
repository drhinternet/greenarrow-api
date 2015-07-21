<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Event Notification](#event-notification)
  - [Click and Open Tracking Events](#click-and-open-tracking-events)
    - [studio_click Event](#studio_click-event)
    - [studio_open Event](#studio_open-event)
  - [Unsubscribe events](#unsubscribe-events)
    - [studio_unsub Event](#studio_unsub-event)
  - [Subscriber Created or Updated Events](#subscriber-created-or-updated-events)
    - [studio_subscriber_created Event](#studio_subscriber_created-event)
    - [studio_subscriber_updated Event](#studio_subscriber_updated-event)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

Event Notification
==================

There are multiple kinds of events in the GreenArrow system that you can access
or be notified of. This document gives an overview of events that are specific
to GreenArrow Studio, and how they are related.

For information on GreenArrow Engine events, see
[GreenArrow Engine's Types of Events documentation](https://wiki.drh.net/confluence/display/ENGINEDOCS/Types+of+Events).

## Click and Open Tracking Events

A click or open event will be created whenever someone load images in an email message, or clicks on a link in it.

| ![info](http://docs.drh.net/downloads/information.gif) Interaction with SimpleMH |
| --- |
| If you are using GreenArrow Engine's SimpleMH with click and open tracking enabled, then you will also receive engine_click and engine_open events. See [GreenArrow Engine's Types of Events documentation](https://wiki.drh.net/confluence/display/ENGINEDOCS/Types+of+Events). |

### studio_click Event

| Field | Description | Example Value |
| --- | --- | --- |
| event_type | The type of event that this is. This will be "studio_click" | studio_click |
| listid | The identifier for the mailing list that this message is a part of. | 99 |
| list_name | The name of the mailing list that this message is a part of. | YourCompanyName List |
| email | The email address that this message was to. | customer@example.com |
| sendid | The SendID value used in Engine for this email | a1092 |
| event_time | The time that the click happened. | 1317305252 |
| click_url | The URL of the link that was clicked on. | [http://www.example.com/] |
| studio_mailing_list_id | The Studio mailing_list_id from which this event originated. | 88172 |
| studio_subscriber_id | The Studio subscriber_id associated with this event. This value will be NULL for a Remote List. | 98918274 |
| studio_campaign_id | If this event originated from a Studio campaign, then this column will contain the Campaign ID. | 91827 |
| studio_autoresponder_id | If this event originated from a Studio autoresponder, then this column will contain the Autoresponder ID. | 8172931 |
| studio_is_unique | This column will indicate if it was a unique event. | TRUE |
| studio_ip | The IP address from which this event occurred. | 10.0.89.100 |
| studio_rl_seq_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, this is the sequence id of this recipient in the campaign, starting with 1 for the first recipient. If not a Remote List, then this is NULL. | 9000 |
| studio_rl_distinct_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, then is the value of the distinct_id column returned by the remote database, if provided. If not provided by the remote database, this is NULL. If not a Remote List, then this is NULL. | 10293 |

### studio_open Event

| Field | Description | Example Value |
| --- | --- | --- |
| event_type | The type of event that this is. This will be "studio_open" | studio_open |
| listid | The identifier for the mailing list that this message is a part of. | 99 |
| list_name | The name of the mailing list that this message is a part of. | YourCompanyName List |
| email | The email address that this message was to. | customer@example.com |
| sendid | The SendID value used in Engine for this email | a1092 |
| event_time | The time that the open happened. | 1317305252 |
| studio_mailing_list_id | The Studio mailing_list_id from which this event originated. | 88172 |
| studio_subscriber_id | The Studio subscriber_id associated with this event. This value will be NULL for a Remote List. | 98918274 |
| studio_campaign_id | If this event originated from a Studio campaign, then this column will contain the Campaign ID. | 91827 |
| studio_autoresponder_id | If this event originated from a Studio autoresponder, then this column will contain the Autoresponder ID. | 8172931 |
| studio_is_unique | This column will indicate if it was a unique event. | TRUE |
| studio_ip | The IP address from which this event occurred. | 10.0.89.100 |
| studio_rl_seq_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, this is the sequence id of this recipient in the campaign, starting with 1 for the first recipient. If not a Remote List, then this is NULL. | 9000 |
| studio_rl_distinct_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, then is the value of the distinct_id column returned by the remote database, if provided. If not provided by the remote database, this is NULL. If not a Remote List, then this is NULL. | 10293 |

## Unsubscribe events

Unsubscribe events are created when someone clicks on a GreenArrow Studio
unsubscribe link or unsubscribes via the list-unsubscribe header. Unsubscribes
that are caused by either a GreenArrow Studio API call, or importing a list of
addresses with their Status set as "Unsubscribed" will not be recorded as
studio_unsub events.

| ![info](http://docs.drh.net/downloads/information.gif) Interaction with SimpleMH |
| --- |
| If you are using GreenArrow Engine's SimpleMH with unsubscribe links, then you will also receive engine_unsub events. See [GreenArrow Engine's Types of Events documentation](https://wiki.drh.net/confluence/display/ENGINEDOCS/Types+of+Events). |

### studio_unsub Event

| Field | Description | Example Value |
| --- | --- | --- |
| event_type | The type of event that this is. This will be "studio_unsub" | studio_unsub |
| listid | The identifier for the mailing list that this message is a part of. | 99 |
| list_name | The name of the mailing list that this message is a part of. | YourCompanyName List |
| email | The email address that this message was to. | customer@example.com |
| sendid | The SendID value used in Engine for this email | a1092 |
| event_time | The time that the unsubscribe happened. | 1317305252 |
| studio_mailing_list_id | The Studio mailing_list_id from which this event originated. | 88172 |
| studio_subscriber_id | The Studio subscriber_id associated with this event. This value will be NULL for a Remote List. | 98918274 |
| studio_campaign_id | If this event originated from a Studio campaign, then this column will contain the Campaign ID. | 91827 |
| studio_autoresponder_id | If this event originated from a Studio autoresponder, then this column will contain the Autoresponder ID. | 8172931 |
| studio_is_unique | This column will indicate if it was a unique event. | TRUE |
| studio_rl_seq_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, this is the sequence id of this recipient in the campaign, starting with 1 for the first recipient. If not a Remote List, then this is NULL. | 9000 |
| studio_rl_distinct_id | _Remote Lists:_ If this event originated from a campaign to a Remote List, then is the value of the distinct_id column returned by the remote database, if provided. If not provided by the remote database, this is NULL. If not a Remote List, then this is NULL. | 10293 |

## Subscriber Created or Updated Events

When a subscriber is created or updated, a *studio_subscriber_created* or *studio_subscriber_updated* event may be generated.

### studio_subscriber_created Event

| Field | Description | Example Value |
| --- | --- | --- |
| event_type | The type of event that this is. This will be "studio_subscriber_created" | studio_subscriber_created |
| listid | The identifier for the mailing list that this message is a part of. | a99 |
| studio_mailing_list_id | The GreenArrow Studio ID for this mailing list. | 99 |
| list_name | The name of the mailing list that this message is a part of. | YourCompanyName List |
| studio_subscriber_id | The GreenArrow Studio ID for this subscriber. | 1234 |
| email | The email address of this subscriber. | customer@example.com |
| event_time | The time that this event was triggered. | 1317305252 |
| json_after | The subscriber data as defined by the GreenArrow Studio API. | [See API Documentation](https://github.com/drhinternet/greenarrow-api/blob/master/studio/v2/subscribers.markdown#get-subscriber-details) |

### studio_subscriber_updated Event

| Field | Description | Example Value |
| --- | --- | --- |
| event_type | The type of event that this is. This will be "studio_subscriber_updated" | studio_subscriber_updated |
| listid | The identifier for the mailing list that this message is a part of. | a99 |
| studio_mailing_list_id | The GreenArrow Studio ID for this mailing list. | 99 |
| list_name | The name of the mailing list that this message is a part of. | YourCompanyName List |
| studio_subscriber_id | The GreenArrow Studio ID for this subscriber. | 1234 |
| email | The email address of this subscriber *after* the update was applied. | customer@example.com |
| event_time | The time that this event was triggered. | 1317305252 |
| json_before | The subscriber data *before* the update was applied, as defined by the GreenArrow Studio API. | [See API Documentation](https://github.com/drhinternet/greenarrow-api/blob/master/studio/v2/subscribers.markdown#get-subscriber-details) |
| json_after | The subscriber data *after* the update was applied, as defined by the GreenArrow Studio API. | [See API Documentation](https://github.com/drhinternet/greenarrow-api/blob/master/studio/v2/subscribers.markdown#get-subscriber-details) |
