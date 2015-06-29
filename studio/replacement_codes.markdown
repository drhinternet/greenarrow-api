<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Content Replacement Codes](#content-replacement-codes)
  - [Subscriber ID](#subscriber-id)
  - [Subscriber's Email Address](#subscribers-email-address)
  - [Subscriber's Email Address MD5](#subscribers-email-address-md5)
  - [Mailing List ID](#mailing-list-id)
  - [Mailing List Name](#mailing-list-name)
  - [Unsubscribe Link](#unsubscribe-link)
  - [Web Version Link](#web-version-link)
  - [Campaign ID](#campaign-id)
  - [Campaign Name](#campaign-name)
  - [Current Year](#current-year)
  - [Percent %](#percent-%25)
  - [From Email](#from-email)
  - [From Name](#from-name)
  - [Sender Email](#sender-email)
  - [Reply-To Email](#reply-to-email)
  - [Subscriber Date Subscribed (Long)](#subscriber-date-subscribed-long)
  - [Subscriber Date Subscribed (Database)](#subscriber-date-subscribed-database)
  - [Subscriber Subscription IP](#subscriber-subscription-ip)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Content Replacement Codes #

The following replacement codes may be added to campaigns and autoresponders.

## Subscriber ID ##

The primary key of the subscriber in GreenArrow Studio's database.

    Replacement Code: %%subscriber_id%%

## Subscriber's Email Address ##

The subscriber's email address as recorded in GreenArrow Studio.

    Replacement Code: %%subscribers_email_address%%

## Subscriber's Email Address MD5 ##

The lowercased MD5 of the Subscriber's lowercased email address.

    Replacement Code: %%emailaddress_md5%%

## Mailing List ID ##

The primary key of the mailing list in GreenArrow Studio's database.

    Replacement Code: %%mailing_list_id%%

## Mailing List Name ##

The unique name assigned to this mailing list.

    Replacement Code: %%mailing_list_name%%

## Unsubscribe Link ##

The raw URL that will cause the subscriber to unsubscribe from this mailing list.

    Replacement Code: %%unsubscribe_link%%

## Web Version Link ##

The raw URL that will lead the subscriber to the web version of this email.
This is only available on campaigns.

    Replacement Code: %%link_to_web_version%%

## Campaign ID ##

The primary key of the campaign in GreenArrow Studio's database.

    Replacement Code: %%data_campaign_id%%

    Deprecated Replacement Code: %%campaign_id%%

## Campaign Name ##

The unique name assigned to this campaign.

    Replacement Code: %%data_campaign_name%%

## Current Year ##

The current year in 4 digits (2000). The current year is retrieved using the
server's current time. This value is determined when the replacement is made,
not when the campaign was sent.

    Replacement Code: %%data_current_year%%

## Percent % ##

A simple percent `%` symbol. This replacement exists because `%` is used as
part of the replacement code anchors, and there may be content that needs this
in order to be formed properly.

    Replacement Code: %%data_percent%%

## From Email ##

The "From Email" value used for this message.

    Replacement Code: %%data_from_email%%

## From Name ##

The "From Name" value used for this message.

    Replacement Code: %%data_from_name%%

## Sender Email ##

The "Sender Email" value used for this message. This may be blank.

    Replacement Code: %%data_sender_email%%

## Reply-To Email ##

The "Reply-To Email" value used for this message. This may be blank.

    Replacement Code: %%data_reply_to_email%%

## Subscriber Date Subscribed (Long) ##

The date this subscriber subscribed, formatted like "December 5, 2015".

    Replacement Code: %%data_subscribe_date_long%%

## Subscriber Date Subscribed (Database) ##

The date this subscriber subscribed, formatted like "2015-12-05".

    Replacement Code: %%data_subscribe_date_database%%

## Subscriber Subscription IP ##

The IP from which the subscriber originally subscribed.

    Replacement Code: %%data_subscribe_ip%%
