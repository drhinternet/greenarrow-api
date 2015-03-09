# Example Special Sending Rules

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Restrict campaign delivery to one message per email address per day (PHP)](#restrict-campaign-delivery-to-one-message-per-email-address-per-day-php)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Restrict campaign delivery to one message per email address per day (PHP)

This special sending rule will prevent the same email address from receiving
more than one email per day from campaigns that are configured to use this
rule.

It has no affect on:

* campaigns that don't use this SSR
* autoresponders

This rule requires that a Redis server be running at `127.0.0.1:6379`, which is
its default configuration.

```php
# We want "today" to be in the "America/Chicago" time zone. See a full list of
# available time zones in PHP here:
#
#   http://php.net/manual/en/timezones.php

date_default_timezone_set("America/Chicago");

# Get or establish a connection to Redis. We'll store the connection in a
# global variable for use by a later execution of this rule.

global $myRedis;

if ( is_null($myRedis) ) {
    $myRedis = new Redis();
    $myRedis->connect("127.0.0.1", 6379);
}

# This is the actual execution of the special sending rule. For each recipient,
# we want to skip it if it's already received an email today.

return array_map((function ($recipient) use ($campaign_information_hash, $myRedis) {

  # Use Redis's GETSET command to do the following.
  #
  #   (1) Test if the email has already received a message today
  #   (2) Mark that the email has received a message today

  $email      = $recipient->subscriber->email;
  $today      = strftime("%Y-%m-%d");
  $keyExpire  = 60 * 60 * 48; // 48 hours, in seconds
  $key        = "HasEmailReceivedToday:$today:$email";
  $keyValue   = $myRedis->getset($key, "1");
  $didReceive = $keyValue === "1";
  $skip       = $didReceive ? 1 : 0;

  # Expire the written key after some time so that we do not persist old data
  # that is no longer relevant.

  $myRedis->expire($key, $keyExpire);

  # Instruct the sender to skip if appropriate.

  return array('skip' => $skip);

}), $multiple_recipients_information_hash);
```
