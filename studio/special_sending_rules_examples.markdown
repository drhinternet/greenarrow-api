# Example Special Sending Rules

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Restrict campaign delivery to one message per email address per day (PHP)](#restrict-campaign-delivery-to-one-message-per-email-address-per-day-php)
- [Set delivery details based on a custom field value (Perl)](#set-delivery-details-based-on-a-custom-field-value-perl)
- [Set random delivery details (Perl)](#set-random-delivery-details-perl)
- [Set random delivery details with 25% / 25% / 50% splits (Perl)](#set-random-delivery-details-with-25%25--25%25--50%25-splits-perl)

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

## Set delivery details based on a custom field value (Perl)

This special sending rule changes the From Name, From Email, Virtual MTA,
Bounce Email, and URL Domain based on the value of the custom field "Favorite
Color".

If the recipient does not match either "Red" or "Blue", no changes will be made.

```perl
my %result = map {
  # Retrieve details about the individual recipient
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };
  my $color_value  = $recipient->{subscriber}{custom_fields}{"Favorite Color"};

  # Prepare the overrides hash that we'll return
  my $overrides    = {};

  # Override values based on a custom field
  if ( $color_value eq "Red" ) {
    $overrides->{from_name}        = 'Example Red';
    $overrides->{from_email}       = 'from@example-red.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-red.com';
    $overrides->{url_domain_name}  = 'example-red.com';
  } elsif ( $color_value eq "Blue" ) {
    $overrides->{from_name}        = 'Example Blue';
    $overrides->{from_email}       = 'from@example-blue.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-blue.com';
    $overrides->{url_domain_name}  = 'example-blue.com';
  }

  # Return the override hash for this recipient
  $recipient_id => $overrides
} keys(%$multiple_recipients_information_hash);

return \%result;
```

## Set random delivery details (Perl)

This special sending rule changes the From Name, From Email, Virtual MTA,
Bounce Email, and URL Domain based on a random number.

**Warning:** Splitting the same email content over multiple domain names
can cause your email to get blocked as "[Snowshoe Spam](http://www.spamhaus.org/faq/section/Glossary#233)."
Please make sure you know what you are doing if you use a special sending
rule like this.

A random number from 0 to 99 is generated. If that number is 0-33, the "Red"
values will be used. If that number is 34-66, the "Blue" values will be used.
Otherwise, no overrides are made.

```perl
my %result = map {
  # Retrieve details about the individual recipient
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };
  my $rand_value   = int(rand(100));

  # Prepare the overrides hash that we'll return
  my $overrides    = {};

  # Override values based on the random value
  if ( $rand_value <= 33 ) {
    $overrides->{from_name}        = 'Example Red';
    $overrides->{from_email}       = 'from@example-red.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-red.com';
    $overrides->{url_domain_name}  = 'example-red.com';
  } elsif ( $rand_value <= 66 ) {
    $overrides->{from_name}        = 'Example Blue';
    $overrides->{from_email}       = 'from@example-blue.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-blue.com';
    $overrides->{url_domain_name}  = 'example-blue.com';
  }

  # Return the override hash for this recipient
  $recipient_id => $overrides
} keys(%$multiple_recipients_information_hash);

return \%result;
```

## Set random delivery details with 25% / 25% / 50% splits (Perl)

This special sending rule changes the From Name, From Email, Virtual MTA,
Bounce Email, and URL Domain based on a random number.

**Warning:** Splitting the same email content over multiple domain names
can cause your email to get blocked as "[Snowshoe Spam](http://www.spamhaus.org/faq/section/Glossary#233)."
Please make sure you know what you are doing if you use a special sending
rule like this.

A random number from 0 to 99 is generated. If that number is 0-24, the "Red"
values will be used. If that number is 25-49, the "Blue" values will be used.
Otherwise, the "Green" values will be used.

```perl
my %result = map {
  # Retrieve details about the individual recipient
  my $recipient_id = $_;
  my $recipient    = $multiple_recipients_information_hash->{ $recipient_id };
  my $rand_value   = int(rand(100));

  # Prepare the overrides hash that we'll return
  my $overrides    = {};

  # Override values based on the random value
  if ( $rand_value <= 24 ) {
    $overrides->{from_name}        = 'Example Red';
    $overrides->{from_email}       = 'from@example-red.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-red.com';
    $overrides->{url_domain_name}  = 'example-red.com';
  } elsif ( $rand_value <= 49 ) {
    $overrides->{from_name}        = 'Example Blue';
    $overrides->{from_email}       = 'from@example-blue.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-blue.com';
    $overrides->{url_domain_name}  = 'example-blue.com';
  } else {
    $overrides->{from_name}        = 'Example Green';
    $overrides->{from_email}       = 'from@example-green.com';
    $overrides->{virtual_mta_name} = 'example-1-ipaddr';
    $overrides->{bounce_email}     = 'bounce@example-green.com';
    $overrides->{url_domain_name}  = 'example-green.com';
  }

  # Return the override hash for this recipient
  $recipient_id => $overrides
} keys(%$multiple_recipients_information_hash);

return \%result;
```
